<script setup>
import { Head ,Link ,useForm} from '@inertiajs/vue3';

defineProps({
    post:{
        type: Object,
        required: true,
    },
});
// useFormフックスを使って入力値に対して処理させる
const form = useForm({});

const handleDelete = (post) => {
    if (confirm('本当に削除すんの？')) {
        form.delete(route('posts.destroy',post.id),{
            onSuccess: () => {
                alert('投稿が削除されました。');
            },
            onError: (errors) => {
                alert('削除に失敗しました。もう一度お試しください。');
            }
        });
    }
};

</script>

<template>
    <Head title="投稿詳細" />
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-7">投稿詳細</h1>
        <div class="p-4 bg-white rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-2">タイトル：{{ post.title }}</h2>
            <h1 class="mb-2">本文：{{ post.content }}</h1>
            <img v-if="post.image_path" :src="post.image_path" alt="Post Image" class="mb-2">
        </div>
        <div class="mx-auto p-5 flex items-center justify-center">
            <Link :href="route('posts.edit',post.id)" class="m-5 p-2 shadow-md rounded-lg bg-blue-500 text-white">編集</Link>
            <button class="m-5 p-2 shadow-md rounded-lg bg-red-500 text-white" type="button" @click="handleDelete(post)">削除</button>
        </div>
    </div>
</template>