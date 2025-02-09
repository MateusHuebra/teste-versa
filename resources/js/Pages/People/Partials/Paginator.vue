<script setup>
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <section>
        <div class="px-6 pb-6 text-gray-900 flex justify-end space-x-1">
            <Link v-for="link in links" :href="link.url">
                <PrimaryButton :disabled="link.active || link.url===null" v-html="link.label"></PrimaryButton>
            </Link>
        </div>
    </section>
</template>