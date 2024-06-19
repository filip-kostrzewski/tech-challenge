<template>
    <div>
        <h1 class="mb-6">Journals -> Add New Journal</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Date</label>
                <input type="date" id="name" class="form-control" v-model="journal.date">
                <p v-for="message in errors.date" class="text-red-400">{{ message }}</p>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" class="form-control" v-model="journal.content" rows="15"></textarea>
                <p v-for="message in errors.content" class="text-red-400">{{ message }}</p>
            </div>

            <div class="text-right">
                <a :href="client.url" class="btn btn-default">Cancel</a>
                <button @click="storeJournal" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'JournalsForm',

    props: ['client'],

    data() {
        return {
            journal: {
                date: '',
                content: '',
            },
            errors: {
                date: '',
                content: '',
            }
        }
    },

    methods: {
        storeJournal() {
            axios.post(this.client.url + '/journals', this.journal)
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .then((data) => {
                    if(data?.status !== 201) return;
                    window.location.href = this.client.url;
                });
        }
    }
}
</script>
