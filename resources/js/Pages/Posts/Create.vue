<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  title: '',
  content: '',
  image: null // ファイルアップロード用
});

const handleFileChange = e =>{
  form.image = e.target.files[0];
}

function submit() {
  form.post('/posts', {
    forceFormData: true // 画像を含むためFormDataを使用
  });
}

</script>

<template>
  <Head title="新規投稿" />
  <div>
    <h1>新規投稿</h1>
    <form @submit.prevent="submit">
      <div>
        <label for="title">タイトル</label>
        <!-- v-modelで入力値を同期的に使用 -->
        <input v-model="form.title" id="title" type="text" />
        <div v-if="form.errors.title" class="text-red-600">{{ form.errors.title }}</div>
      </div>
      <div>
        <label for="content">レシピ詳細</label>
        <textarea v-model="form.content" id="content"></textarea>
        <div v-if="form.errors.content" class="text-red-600">{{ form.errors.content }}</div>
      </div>
      <div>
        <label for="image">画像アップロード</label>
        <input @change="handleFileChange" type="file" id="image" />
        <!-- <div v-if="form.errors.image" class="text-red-600">{{ form.errors.image }}</div> -->
      </div>
      <button type="submit">送信</button>
    </form>
  </div>
</template>
