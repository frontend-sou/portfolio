<script setup>
import { Head,Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';

defineProps({
    favorites:{
        type: Object,
        require: true,
      },
});

function decodeHtmlEntity(text) {
    const textArea = document.createElement('textarea');
    textArea.innerHTML = text;
    return textArea.value;
}

</script>

<template>
    <Head title="お気に入り" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">お気に入り</h2>
        </template>
    </AuthenticatedLayout>
</template>