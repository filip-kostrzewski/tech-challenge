<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-gray-600 pr-3">Name</th>
                                <td>{{ client.name }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Email</th>
                                <td>{{ client.email }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Phone</th>
                                <td>{{ client.phone }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Address</th>
                                <td>{{ client.address }}<br/>{{ client.postcode + ' ' + client.city }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div class="mb-4">
                    <button class="btn" :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}" @click="switchTab('bookings')">Bookings</button>
                    <button class="btn" :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}" @click="switchTab('journals')">Journals</button>
                </div>

                <BookingsTable v-if="currentTab === 'bookings'" :client="localClient" @delete="deleteBooking" />
                <JournalsTable v-if="currentTab === 'journals'" :client="localClient" @delete="deleteJournal" />
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import BookingsTable from './ClientShowBookingsTable.vue';
import JournalsTable from './ClientShowJournalsTable.vue';

export default {
    name: 'ClientShow',

    components: {
        BookingsTable, JournalsTable
    },

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            localClient: this.client,
            bookingFilter: new URLSearchParams(window.location.search).get('booking_filter') || ''
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/clients/${this.client.id}/bookings/${booking}`)
                .then(() => {
                    this.localClient.bookings = this.localClient.bookings.filter(item => item.id !== booking);
                });
        },

        deleteJournal(journal) {
            axios.delete(`/clients/${this.client.id}/journals/${journal}`)
                .then(() => {
                    this.localClient.journals = this.localClient.journals.filter(item => item.id !== journal);
                });
        },

        bookingFilterChanged() {
            window.location.href = `/clients/${this.client.id}?booking_filter=${this.bookingFilter}`;
        }
    }
}
</script>
