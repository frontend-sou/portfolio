<script setup>
import { Head ,Link } from '@inertiajs/vue3';

defineProps({
    posts:{
        type: Array,
      },
});
</script>

<template>
  <div>
    <Head title="投稿一覧" />
    <div class="container mx-auto p-4">
      <h1 class="text-4xl font-extrabold text-gray-800 mb-8">投稿一覧</h1>
      <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <li v-for="post in posts" :key="post.id" class="bg-white rounded-lg shadow-lg overflow-hidden">
          <Link :href="`/posts/${post.id}`" class="block hover:shadow-xl transition-shadow duration-300">
            <div class="p-4">
              <h2 class="text-2xl font-semibold text-gray-900 mb-3">タイトル：{{ post.title }}</h2>
              <img v-if="post.image_path" :src="post.image_path" alt="Post Image" class="w-full h-48 object-cover rounded-md">
            </div>
          </Link>
        </li>
      </ul>
    </div>
  </div>
</template>


