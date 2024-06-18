<script setup>
import { Head,Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';

defineProps({
    likes:{
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
    <Head title="いいね" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">いいね</h2>
        </template>
    </AuthenticatedLayout>
</template>