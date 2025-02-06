<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';

const isModalOpen = ref(false);
const personToBeDeleted = ref(null);
const form = useForm({
    person: '',
});

defineProps({
    people: {
        type: Array,
        required: true,
    },

});

const openDeleteModal = (person) => {
    isModalOpen.value = true;
    personToBeDeleted.value = person;
};

const closeDeleteModal = () => {
    isModalOpen.value = false;
    personToBeDeleted.value = null;
}

const deletePerson = () => {
    form.delete(route('people.destroy', {id: personToBeDeleted.value.id}), {
        preserveScroll: true,
        onSuccess: () => closeDeleteModal()
    });
}
</script>

<template>
    <section>
        <div class="p-6 text-gray-900">
            <table v-if="people.length > 0" class="w-full border-collapse border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-gray-100">
                    <tr class="text-left text-gray-700">
                        <th class="p-3 border border-gray-300">First Name</th>
                        <th class="p-3 border border-gray-300">Last Name</th>
                        <th class="p-3 border border-gray-300">Gender</th>
                        <th class="p-3 border border-gray-300">Birthday</th>
                        <th class="p-3 border border-gray-300">CPF</th>
                        <th class="p-3 border border-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="person in people" :key="person.id" class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-2 border border-gray-300">{{ person.first_name }}</td>
                        <td class="p-2 border border-gray-300">{{ person.last_name }}</td>
                        <td class="p-2 border border-gray-300">{{ person.gender }}</td>
                        <td class="p-2 border border-gray-300">{{ person.birthday_formatted }}</td>
                        <td class="p-2 border border-gray-300">{{ person.cpf_formatted }}</td>
                        <td class="p-2 border border-gray-300 space-x-2">
                            <Link :href="route('people.edit', { id: person.id })" class="bg-blue-500 text-white px-3 rounded-md hover:bg-blue-600" style="padding-top: 6px; padding-bottom: 7px">
                                Edit
                            </Link>
                            <button @click="openDeleteModal(person)" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <h2 v-else>
                No People found. Create one and they will be shown here.
            </h2>
        </div>
    </section>

    <Modal :show="isModalOpen" @close="closeDeleteModal">
        <div class="m-6" @click.stop>
            <p class="text-2xl mb-3">Delete Person</p>
            <p>Are you sure you want to delete this person?</p>
            <div class="mt-2 bg-gray-200 py-1 px-2 inline-block border rounded-lg">
                First name: {{  personToBeDeleted.first_name }} <br>
                Last name: {{  personToBeDeleted.last_name }} <br>
                Gender: {{  personToBeDeleted.gender }} <br>
                Birthday: {{  personToBeDeleted.birthday_formatted }} <br>
                CPF: {{  personToBeDeleted.cpf_formatted }}
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeDeleteModal">
                    Cancel
                </SecondaryButton>
                <DangerButton class="ms-3" @click.prevent="deletePerson">
                    Confirm Deletion
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>