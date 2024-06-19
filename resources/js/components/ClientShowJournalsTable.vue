<template>
    <div class="flex">
        <div class=" w-100 bg-white rounded p-4">
            <div class="flex align-items-center justify-content-between">
                <h3 class="mb-3">List of client journals</h3>
                <a :href="`/clients/${client.id}/journals/create`" class="btn btn-primary">+ New Journal</a>
            </div>

            <template v-if="client.journals && client.journals.length > 0">
                <table>
                    <thead>
                        <tr>
                            <th class="px-3">Date</th>
                            <th class="w-100 px-3">Content</th>
                            <th class="px-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="journal in client.journals" :key="journal.id">
                            <td class="px-3">
                                <p class="text-nowrap">
                                    {{ journal.date }}
                                </p>
                            </td>
                            <td class="px-3">
                                <p>
                                    {{ journal.content }}
                                </p>
                            </td>
                            <td class="px-3">
                                <button class="btn btn-danger btn-sm" @click="deleteJournal(journal)">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>

            <template v-else>
                <p class="text-center">The client has no journals.</p>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ClientShowJournalsTable',

    props: ['client'],

    methods: {
        deleteJournal(journal) {
            this.$emit('delete', journal.id);
        },
    }
}
</script>
