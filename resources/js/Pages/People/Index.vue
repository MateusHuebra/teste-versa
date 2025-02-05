<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    people: {
        type: Array,
        required: true,
    }
});
</script>

<template>
    <Head title="People" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                People
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <Link style="border: 1px solid black; padding: 10px;"
                            :href="route('people.create')"
                        >
                            Create
                        </Link>
                    </div>
                    <div class="p-6 text-gray-900">
                        <table v-if="people.length > 0">
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>Birthday</th>
                                <th>CPF</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="person in people">
                                <td>{{ person.first_name }}</td>
                                <td>{{ person.last_name }}</td>
                                <td>{{ person.gender }}</td>
                                <td>{{ person.birthday_formatted }}</td>
                                <td>{{ person.cpf }}</td>
                                <td>
                                    <Link style="border: 1px solid black; padding: 5px;"
                                        :href="route('people')"
                                    >
                                        Edit
                                    </Link>
                                    <Link style="border: 1px solid black; padding: 5px; margin-left: 10px;"
                                        :href="route('people')"
                                    >
                                        Delete
                                    </Link>
                                </td>
                            </tr>
                        </table>
                        <h2 v-else>
                            No People found. Create one and they will be shown here.
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
table {
  width: 100%;
}

th, td {
  padding: 10px;
  text-align: left;
  border: 1px solid black;
}

th {
  background-color: #f4f4f4;
}
</style>