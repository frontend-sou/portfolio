<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '../../Components/PrimaryButton.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head ,Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';


const props = defineProps({
    posts:{
        type: Object,
        required: true,
    },
}); 

// 検索入力値をリアクティブに
const searchQuery = ref('');

// computedでリアクティブな値をもとに新たな結果を表示する(入力された場合にのみ発動)
const postFilter = computed(() => {
    const query = searchQuery.value.toLowerCase();
    // 検索の入力値が空、何も入力されていないときの処理
    if (!query) {
        return props.posts.data;
    }else{
        // タイトルか本文に検索クエリの値が含まれている投稿を返す
        return props.posts.data.filter((post) =>{
            const titleMatches = post.title.toLowerCase().includes(query);
            const contentMatches = post.content.toLowerCase().includes(query);
            return titleMatches || contentMatches;
        });
    }
});

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
            <!-- 検索機能 -->
            <div class="w-full md:w-1/2 lg:w-1/3 xl:w-2/5 mx-auto px-3 mb-4 block py-1 border-indigo-400 text-start text-base font-medium text-indigo-70 bg-indigo-50">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">検索</h3>
                    <input v-model="searchQuery" type="text" placeholder="キーワードを入力" class="w-full p-2 border rounded mb-4">
                </div>
            </div>
             
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- postsはArray,paginateはdataプロパティに格納されているためpost.dataにアクセスしてArray回す -->
                <li v-for="post in postFilter" :key="post.id" class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <Link :href="`/posts/${post.id}`" class="block hover:shadow-xl transition-shadow duration-300">
                        <div class="p-4">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-3">タイトル：{{ post.title }}</h2>
                            <img v-if="post.image_path" :src="post.image_path" alt="Post Image" class="w-full h-48 object-cover rounded-md">
                        </div>
                    </Link>
                </li>
            </ul>
            <!-- ページネーション -->
            <Pagination :links="posts.links" />
        </div>
    </AuthenticatedLayout>
</template>
