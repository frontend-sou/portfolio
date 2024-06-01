<script setup>
import { Head ,Link} from '@inertiajs/vue3';

defineProps({
  posts:{
      type:Array 
    },
});
</script>

<template>   
  <Head title="投稿一覧" />
  <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-7">投稿一覧</h1>
    <ul class="space-y-6 flex box">
      <li v-for="post in posts" :key="post.id" class="p-4 bg-white rounded-lg shadow-md mr-10">
        <Link :href="`/posts/${post.id}`">
          <h2 class="text-2xl font-semibold mb-2">タイトル：{{ post.title }}</h2>
        </Link>
          <img v-if="post.image_path" :src="post.image_path" alt="Post Image" class="mb-2">
        </li>
      </ul>
  </div>
</template>
