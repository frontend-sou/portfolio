<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    post:{
        type:Object,
        required:true,
    },
});

</script>

<template>
    <Head title="投稿詳細" />
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-7">投稿詳細</h1>
        <div class="p-4 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-2">タイトル：{{ post.title }}</h2>
            <p class="mb-2">本文：{{ post.content }}</p>
            <img v-if="post.image_path" :src="post.image_path" alt="Post Image" class="mb-2">
        </div>
    </div>
</template>