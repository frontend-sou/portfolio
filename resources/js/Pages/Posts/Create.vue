<script setup>
    import { Head ,useForm } from '@inertiajs/vue3';

    
      const form = useForm({
        title: '',
        content: '',
        image_path: ''
      })
  
      function submit() {
        form.post('/posts')
      }
    
</script>

<template>
  <Head title="新規投稿" />
    <div>
      <h1>新規投稿</h1>
      <!-- submitイベントをリッスンし、デフォルトイベントを無効にした上でsubmitメソッドを呼び出し -->
      <form @submit.prevent="submit">
        <div>
          <label for="title">タイトル</label>
          <!-- v-modelはデータバインディング(双方向に反映)ユーザーの入力値⇔form.title -->
          <input v-model="form.title" id="title" type="text" />
        </div>
        <div>
          <label for="content">レシピ詳細</label>
          <textarea v-model="form.content" id="content"></textarea>
        </div>
        <div>
          <label for="image_path">後で画像アップロード機能に変更</label>
          <input v-model="form.image_path" id="image_path" type="text" />
        </div>
        <button type="submit">送信</button>
      </form>
    </div>
  </template>
  
  