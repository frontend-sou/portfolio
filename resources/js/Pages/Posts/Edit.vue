<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';
import PrimaryButton from '../../Components/PrimaryButton.vue';

const props = defineProps({
    post: {
        type: Object,
        required: true,
    }
});

const form = useForm({
    title: props.post.title || '',
    content: props.post.content || '',
    image: null,
    _method: 'PUT', //フォームメソッドのオーバーライドを利用。
});


const handleFileChange = (e) => {
    form.image = e.target.files[0];
}

const submit = ()=>{
    // ルート,パラメータはroute()内に入れる
    form.post(route('posts.update',{post: props.post})),{
        forceFormData: true,
    }

};

</script>

<template>
    <Head title="投稿編集" />
    <div class="container mx-auto p-6 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-semibold mb-4">投稿編集</h1>
        <!-- 画像データの時はformにenctype必須 -->
        <form @submit.prevent="submit" enctype="multipart/form-data">
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
            </div>
            <PrimaryButton>送信</PrimaryButton>
        </form>
        <div v-if="post.image_path" class="mt-4">
            <img  class="h-auto max-w-14 rounded-lg" :src="post.image_path" alt="Current Image"/>
        </div>
    </div>
</template>

