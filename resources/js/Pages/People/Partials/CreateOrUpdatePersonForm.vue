<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const buttonText = ref('Create');

const form = useForm({
    first_name: '',
    last_name: '',
    gender: '',
    birthday: '',
    cpf: '',
});

const props = defineProps({
    person: {
        type: Object,
        required: false,
    }
});

if(props.person) {
    form.first_name = props.person.first_name;
    form.last_name = props.person.last_name;
    form.gender = props.person.gender;
    form.birthday = props.person.birthday;
    form.cpf = props.person.cpf;
    buttonText.value = 'Update'
}

const submit = () => {
    if(props.person) {
        form.patch(route('people.update', {id: props.person.id}));
        return;
    }

    form.post(route('people.store'));
}
</script>

<template>
    <section>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="first_name" value="First Name" />

                <TextInput
                    id="first_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.first_name"
                    required
                    autofocus
                    autocomplete="first_name"
                />

                <InputError class="mt-2" :message="form.errors.first_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="last_name" value="Last Name" />

                <TextInput
                    id="last_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.last_name"
                    autocomplete="last_name"
                />

                <InputError class="mt-2" :message="form.errors.last_name" />
            </div>

            <div class="mt-4">
                <InputLabel for="gender" value="Gender" />

                <select v-model="form.gender" name="gender" id="gender-select">
                    <option value="">--Please choose an option--</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>

                <InputError class="mt-2" :message="form.errors.gender" />
            </div>

            <div class="mt-4">
                <InputLabel for="birthday" value="Birthday" />

                <input
                    id="birthday"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.birthday"
                    required
                    autocomplete="birthday"
                />

                <InputError class="mt-2" :message="form.errors.birthday" />
            </div>

            <div class="mt-4">
                <InputLabel for="cpf" value="CPF" />

                <input
                    id="cpf"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.cpf"
                    autocomplete="cpf"
                    maxlength="11"
                    placeholder="numbers only"
                />

                <InputError class="mt-2" :message="form.errors.cpf" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ buttonText }}
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
