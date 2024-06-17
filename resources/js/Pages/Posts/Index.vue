<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import { Head ,Link } from '@inertiajs/vue3';


defineProps({
    posts:{
        type: Object,
        required: true,
    },
});

function decodeHtmlEntity(text) {
    const textArea = document.createElement('textarea');
    textArea.innerHTML = text;
    return textArea.value;
}
    

</script>

<template>
    <Head title="投稿一覧" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">投稿一覧</h2>
            <Link :href="route('posts.create')" class="inline-flex items-center gap-4">
                <PrimaryButton >新規投稿</PrimaryButton>
            </Link>
        </template>
    
        <div class="container mx-auto py-10">
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- postsはArray,paginateはdataプロパティに格納されているためpost.dataにアクセスしてArray回す -->
                <li v-for="post in posts.data" :key="post.id" class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <Link :href="`/posts/${post.id}`" class="block hover:shadow-xl transition-shadow duration-300">
                        <div class="p-4">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-3">タイトル：{{ post.title }}</h2>
                            <img v-if="post.image_path" :src="post.image_path" alt="Post Image" class="w-full h-48 object-cover rounded-md">
                        </div>
                    </Link>
                </li>
            </ul>
            <!-- ページネーション -->
            <div v-if="posts.links.length > 3">
                <div class="flex justify-center mb-1">
                    <template v-for="(link,id) in posts.links" :key="id">
                        <div
                            v-if="link.url === null"
                            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                        >
                            {{ decodeHtmlEntity(link.label) }}
                        </div>
                        <Link
                            v-else
                            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-yellow-400 focus:border-indigo-500 focus:text-indigo-500"
                            :class="{ 'bg-blue-700 text-white hover:bg-blue-600': link.active }"
                            :href="link.url"
                        >
                            {{ decodeHtmlEntity(link.label) }}
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
