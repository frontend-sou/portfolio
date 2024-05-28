<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
  title: '',
  content: '',
  image: null // ファイルアップロード用
});

function handleFileChange(event) {
  form.image = event.target.files[0];
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
        <input v-model="form.title" id="title" type="text" />
      </div>
      <div>
        <label for="content">レシピ詳細</label>
        <textarea v-model="form.content" id="content"></textarea>
      </div>
      <div>
        <label for="image">画像アップロード</label>
        <input @change="handleFileChange" type="file" id="image" />
      </div>
      <button type="submit">送信</button>
    </form>
  </div>
</template>
