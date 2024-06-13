<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';

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
    <div>
        <h1>投稿編集</h1>
        <!-- 画像データの時はformにenctype必須 -->
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div>
                <label for="title">タイトル</label>
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
            </div>
            <button type="submit">送信</button>
        </form>
        <div v-if="post.image_path">
            <img  class="h-auto max-w-14 rounded-lg" :src="post.image_path" alt="Current Image"/>
        </div>
    </div>
</template>
