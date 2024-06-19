<template>
    <div class="flex">
        <div class=" w-100 bg-white rounded p-4">
            <div class="flex flex-1 justify-content-between">
                <h3 class="mb-3">List of client bookings</h3>
                <div class="form-group ">
                    <select v-model="bookingFilter" @change="bookingFilterChanged" class="form-control">
                        <option value="">All bookings</option>
                        <option value="upcoming">Future bookings only</option>
                        <option value="past">Past bookings only</option>
                    </select>
                </div>
            </div>

            <template v-if="client.bookings && client.bookings.length > 0">
                <table>
                    <thead>
                        <tr>
                            <th class="px-3">Time</th>
                            <th class="w-100 px-3">Notes</th>
                            <th class="px-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="booking in client.bookings" :key="booking.id">
                            <td class="px-3 align-top">
                                <p class="text-nowrap">
                                    {{ booking.formatted_time_duration }}
                                </p>
                            </td>
                            <td class="px-3">
                                <p>
                                    {{ booking.notes }}
                                </p>
                            </td>
                            <td class="px-3 align-top">
                                <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>

            <template v-else>
                <p class="text-center">The client has no bookings.</p>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ClientShowBookingsTable',

    props: ['client'],

    data() {
        return {
            bookingFilter: new URLSearchParams(window.location.search).get('booking_filter') || ''
        }
    },

    methods: {
        deleteBooking(booking) {
            this.$emit('delete', booking.id);
        },

        bookingFilterChanged() {
            window.location.href = `/clients/${this.client.id}?booking_filter=${this.bookingFilter}`;
        }
    }
}
</script>
