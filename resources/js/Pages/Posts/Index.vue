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
    tags:{
        type: Array,
        required: true,
    },
}); 

const categories = {
    食材: ["肉", "魚介・海藻", "卵・乳製品", "野菜・豆類・キノコ類", "加工品", "主食", "果物", "種実類"],
    料理の種類: ["和風", "洋風", "中華風", "イタリアン", "アジア・エスニック", "その他創作"],
    お酒の種類: ["ビール", "ワイン", "焼酎", "チューハイ", "カクテル", "その他"]
};

// 検索入力値をリアクティブに
// const tagSearch = ref(form.tags);
const searchQuery = ref('');

// タグのボタン切り替え(tagはクリックされたタグの名前)
// const toggleTag = (tag) => {
//     // タグがすでに選択されてtagsの中に含まれている場合、タグリストの中身一つをelementとしてtagと照合し合致した以外の要素を配列にし直して再構成
//     if (tagSearch.value.includes(tag)) {
//       tagSearch.value = tagSearch.value.filter(element => element !== tag);
//       // タグが無かったらtagの要素追加
//     } else {
//       tagSearch.value.push(tag);
//     }
// };


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
            <div class="flex">
                <!-- タグ検索機能 -->
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-2/5 mx-auto px-3 mb-4 block py-1 border-indigo-400 text-start text-base font-medium text-indigo-70 bg-indigo-50">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">タグ検索</h3>
                        <!-- <div v-for="(tags,category) in categories" :key="category" class="mb-4">
                            <h3 class="text-lg font-semibold">{{ category }}</h3>
                            <div class="flex flex-wrap gap-2">
                                <span v-for="tag in tags" :key="tag" 
                                    @click="toggleTag(tag)" 
                                    :class="tagSearch.includes(tag) ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800'"
                                    class="cursor-pointer px-3 py-1 rounded-full">
                                {{ tag }}
                                </span>
                            </div>
                        </div> -->
                    </div>
                </div>
                <!-- キーワード検索機能 -->
                <div class="w-full md:w-1/2 lg:w-1/3 xl:w-2/5 mx-auto px-3 mb-4 block py-1 border-indigo-400 text-start text-base font-medium text-indigo-70 bg-indigo-50">
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">キーワード検索</h3>
                        <input v-model="searchQuery" type="text" placeholder="キーワードを入力" class="w-full p-2 border rounded mb-4">
                    </div>
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
