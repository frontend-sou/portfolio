<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '../../Components/PrimaryButton.vue';

const form = useForm({
  title: '',
  content: '',
  image: null // ファイルアップロード用
});

const handleFileChange = e =>{
  form.image = e.target.files[0];
}

const submit = ()=> {
  form.post('/posts', {
    forceFormData: true // 画像を含むためFormDataを使用
  });
}

</script>

<template>
  <Head title="新規投稿" />
  <div class="container mx-auto p-6 bg-white shadow-md rounded-md">
    <h1 class="text-2xl font-semibold mb-4">新規投稿</h1>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
        <input v-model="form.title" id="title" type="text" class="mt-1 p-2 block w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">{{ form.errors.title }}</div>
      </div>
      <div class="mb-4">
        <label for="content" class="block text-sm font-medium text-gray-700">レシピ詳細</label>
        <textarea v-model="form.content" id="content" rows="4" class="mt-1 p-2 block w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
        <div v-if="form.errors.content" class="text-red-600 text-sm mt-1">{{ form.errors.content }}</div>
      </div>
      <div class="mb-4">
        <label for="image" class="block text-sm font-medium text-gray-700">画像アップロード</label>
        <input @change="handleFileChange" type="file" id="image" class="mt-1 p-2 block w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <!-- <div v-if="form.errors.image" class="text-red-600 text-sm mt-1">{{ form.errors.image }}</div> -->
      </div>
      <PrimaryButton>送信</PrimaryButton>
    </form>
  </div>
</template>

