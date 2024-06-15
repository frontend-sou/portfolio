<script setup>
import { Head,Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';

defineProps({
    myPosts:{
        type: Array,
      },
});

</script>

<template>
    <Head title="マイ投稿" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">マイ投稿</h2>
        </template>
    
      <div class="container mx-auto py-10">
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <li v-for="myPost in myPosts" :key="myPost.id" class="bg-white rounded-lg shadow-lg overflow-hidden">
            <Link :href="`/posts/${myPost.id}`" class="block hover:shadow-xl transition-shadow duration-300">
              <div class="p-4">
                <h2 class="text-2xl font-semibold text-gray-900 mb-3">タイトル：{{ myPost.title }}</h2>
                <img v-if="myPost.image_path" :src="myPost.image_path" alt="Post Image" class="w-full h-48 object-cover rounded-md">
              </div>
            </Link>
          </li>
        </ul>
      </div>
  </AuthenticatedLayout>
</template>