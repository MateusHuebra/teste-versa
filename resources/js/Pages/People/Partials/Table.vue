<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

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
            <table v-if="people.length > 0">
                <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Birthday</th>
                    <th>CPF</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="person in people">
                    <td>{{ person.first_name }}</td>
                    <td>{{ person.last_name }}</td>
                    <td>{{ person.gender }}</td>
                    <td>{{ person.birthday_formatted }}</td>
                    <td>{{ person.cpf }}</td>
                    <td>
                        <Link :href="route('people')">
                            <PrimaryButton>
                                Edit
                            </PrimaryButton>
                        </Link>
                        <Link :href="route('people')" style="margin-left: 10px">
                            <DangerButton @click.prevent="openDeleteModal(person)">Delete</DangerButton>
                        </Link>
                    </td>
                </tr>
                </tbody>
            </table>
            <h2 v-else>
                No People found. Create one and they will be shown here.
            </h2>
        </div>
    </section>

    <div class="modal" v-if="isModalOpen" @click="closeDeleteModal">
        <div class="modal-content" @click.stop>
            <p class="modal-title">Delete Person</p>
            <p>Are you sure you want to delete person {{ personToBeDeleted.first_name }} (cpf: {{ personToBeDeleted.cpf }})?</p>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeDeleteModal">
                    Cancel
                </SecondaryButton>
                <DangerButton
                    class="ms-3"
                    @click.prevent="deletePerson"
                >
                    Confirm Deletion
                </DangerButton>
            </div>
        </div>
    </div>
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

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

.modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    border-radius: 5px;
    width: 30%;
    text-align: center;
}

.modal-title {
    font-size: x-large;
    margin-bottom: 10px;
}
</style>