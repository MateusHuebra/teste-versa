<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CreateOrUpdatePersonForm from './Partials/CreateOrUpdatePersonForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    person: {
        type: Object,
        required: true,
    }
});
</script>

<template>
    <Head title="Edit Person" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                People > Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <CreateOrUpdatePersonForm class="max-w-xl" :person="person"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

