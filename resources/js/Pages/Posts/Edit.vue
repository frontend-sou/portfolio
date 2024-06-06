<script setup>
import { Head,Link,useForm } from '@inertiajs/vue3';

defineProps({
    post:{
        type:Object,
    }
});

const form = useForm({
    title: '',
    content: '',
    image: null,
})

const submit = ()=>{
    form.post('/posts',{
        forceFormData: true //画像データを含むからデータを強制的にform-data形式にする
    });
}

const handleFileChange = (e)=>{
    form.image = e.target.files[0];
}

</script>

<template>
    <Head title="投稿編集" />
    <div>
    <h1>投稿編集</h1>
    <h2>{{ post }}</h2>
    <form @submit.prevent="submit">
      <div>
        <label for="title">タイトル</label>
        <!-- v-modelで入力値を同期的に使用 -->
        <input v-model="post.title" id="title" type="text" />
        <div v-if="form.errors.title" class="text-red-600">{{ form.errors.title }}</div>
      </div>
      <div>
        <label for="content">レシピ詳細</label>
        <textarea v-model="post.content" id="content"></textarea>
        <div v-if="form.errors.content" class="text-red-600">{{ form.errors.content }}</div>
      </div>
      <div>
        <label for="image">画像アップロード</label>
        <input v-if="post.image_path" :src="post.image_path" @change="handleFileChange" type="file" id="image" />
        <!-- <div v-if="form.errors.image" class="text-red-600">{{ form.errors.image }}</div> -->
      </div>
      <button type="submit">送信</button>
    </form>
  </div>
</template>