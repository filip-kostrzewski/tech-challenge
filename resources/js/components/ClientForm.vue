<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="client.name">
                <p v-for="message in errors.name" class="text-red-400">{{ message }}</p>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" v-model="client.email">
                <p v-for="message in errors.email" class="text-red-400">{{ message }}</p>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" class="form-control" v-model="client.phone">
                <p v-for="message in errors.phone" class="text-red-400">{{ message }}</p>
            </div>
            <div class="form-group">
                <label for="name">Address</label>
                <input type="text" id="address" class="form-control" v-model="client.address">
            </div>
            <div class="flex">
                <div class="form-group flex-1">
                    <label for="city">City</label>
                    <input type="text" id="city" class="form-control" v-model="client.city">
                </div>
                <div class="form-group flex-1">
                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" class="form-control" v-model="client.postcode">
                </div>
            </div>

            <div class="text-right">
                <a href="/clients" class="btn btn-default">Cancel</a>
                <button @click="storeClient" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientForm',

    data() {
        return {
            client: {
                name: '',
                email: '',
                phone: '',
                address: '',
                city: '',
                postcode: '',
            },
            errors: {
                name: '',
                email: '',
                phone: '',
            }
        }
    },

    methods: {
        storeClient() {
            axios.post('/clients', this.client)
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .then((data) => {
                    if(data?.status !== 201) return;
                    window.location.href = data.data.url;
                });
        }
    }
}
</script>
