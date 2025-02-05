<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Table from './Partials/Table.vue';

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
                        
                        <Link :href="route('people.create')">
                            <PrimaryButton>
                                Create a Person
                            </PrimaryButton>
                        </Link>
                    </div>
                    <Table
                        :people="people"
                    >
                    </Table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>