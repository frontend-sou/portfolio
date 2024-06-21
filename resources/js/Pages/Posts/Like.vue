<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { usePage, Link, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '../../Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';

// const props = defineProps({
//     likes:{
//         type: Object,
//         require: true,
//     }
// });

// usePageで共有データとしてlikesを扱う(likeControllerのpropsと自動的に同期)
const { props } = usePage();
const likes = ref(props.likes);

// 投稿のいいねを解除したときの処理
const handlePostUnliked = (e) => {
    // show.vueで定義したe.detailプロパティをpostIdで定義
    const postId = e.detail;

    // いいねされた投稿からいいねを外した投稿をフィルターして配列を再生成
    likes.value.data = likes.value.data.filter(like => like.id !== postId);
};

// コンポーネントがレンダリングされる直前に実行
onMounted(() => {
    window.addEventListener('post-unliked', handlePostUnliked);
});

// コンポーネントが画面から除去される直前に実行
onUnmounted(() => {
    window.removeEventListener('post-unliked', handlePostUnliked);
});
</script>


<template>
    <Head title="いいね" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">いいね</h2>
        </template>

        <div class="container mx-auto py-10">
            <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <li v-for="like in likes.data" :key="like.id" class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <Link :href="`/posts/${like.id}`" class="block hover:shadow-xl transition-shadow duration-300">
                        <div class="p-4">
                            <h2 class="text-2xl font-semibold text-gray-900 mb-3">タイトル：{{ like.title }}</h2>
                            <img v-if="like.image_path" :src="like.image_path" alt="Post Image" class="w-full h-48 object-cover rounded-md">
                        </div>
                    </Link>
                </li>
            </ul>
            <!-- ページネーション -->
            <Pagination :links="likes.links" />
        </div>
    </AuthenticatedLayout>
</template>