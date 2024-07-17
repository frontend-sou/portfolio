<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { getImagePath } from "../../Utils";

const props = defineProps({
    posts: {
        type: Object,
        required: true,
    },
    tags: {
        type: Array,
        required: true,
    },
});

const categories = {
    食材: [
        "肉",
        "魚介・海藻",
        "卵・乳製品",
        "野菜・豆類・キノコ類",
        "加工品",
        "主食",
        "果物",
        "種実類",
    ],
    料理の種類: [
        "和風",
        "洋風",
        "中華風",
        "イタリアン",
        "アジア・エスニック",
        "その他創作",
    ],
    お酒の種類: [
        "ビール",
        "ワイン",
        "焼酎",
        "チューハイ",
        "カクテル",
        "その他",
    ],
};
// リアクティブのデータ
const tagSearch = ref([]);
const searchQuery = ref("");
const activeTab = ref("tags");

const setActiveTab = (tab) => {
    activeTab.value = tab;
};

// タグのボタン切り替え(tagはクリックされたタグの名前)
const toggleTag = (tag) => {
    // タグがすでに選択されてtagsの中に含まれている場合、タグリストの中身一つをelementとしてtagと照合し合致した以外の要素を配列にし直して再構成
    if (tagSearch.value.includes(tag)) {
        tagSearch.value = tagSearch.value.filter((element) => element !== tag);
        // タグが無かったらtagの要素追加
    } else {
        tagSearch.value.push(tag);
    }
};

// computedでリアクティブな値をもとに新たな結果を表示する(入力された場合にのみ発動)
const postFilter = computed(() => {
    const query = searchQuery.value.toLowerCase();
    // 配列の要素一つ一つに条件に合うかどうかチェック、条件合致したものだけで配列を作り直す
    const filteredPosts = props.posts.data.filter((post) => {
        const titleMatches = post.title.toLowerCase().includes(query);
        const contentMatches = post.content.toLowerCase().includes(query);
        // タグ配列が空の場合か、選択したタグが配列に一つでもあればtrueを返す
        const tagMatches =
            tagSearch.value.length === 0 ||
            post.tags.some((tag) => tagSearch.value.includes(tag.name));
        return (titleMatches || contentMatches) && tagMatches;
    });
    return filteredPosts;
});
</script>

<template>
    <Head title="投稿一覧" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                投稿一覧
            </h2>
            <Link
                :href="route('posts.create')"
                class="inline-flex items-center gap-4"
            >
                <PrimaryButton>新規投稿</PrimaryButton>
            </Link>
        </template>

        <div
            class="container mx-auto py-10 flex flex-col md:flex-row-reverse gap-6"
        >
            <!-- 投稿リスト -->
            <div class="flex-1">
                <ul
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6"
                >
                    <li
                        v-for="post in postFilter"
                        :key="post.id"
                        class="bg-white rounded-lg shadow-lg overflow-hidden"
                    >
                        <Link
                            :href="`/posts/${post.id}`"
                            class="block hover:shadow-xl transition-shadow duration-300"
                        >
                            <div class="p-4">
                                <h2
                                    class="text-xm font-semibold text-gray-900 mb-3"
                                >
                                    タイトル：{{ post.title }}
                                </h2>
                                <img
                                    v-if="post.image_path"
                                    :src="getImagePath(post.image_path)"
                                    alt="Post Image"
                                    class="w-full h-48 object-cover rounded-md"
                                />
                            </div>
                        </Link>
                    </li>
                </ul>
                <!-- ページネーション -->
                <Pagination :links="props.posts.links" />
            </div>

            <!-- 検索機能 -->
            <div class="w-full md:w-1/3">
                <div class="hidden md:block bg-indigo-50 rounded-lg shadow p-4">
                    <!-- タグ検索機能 -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">タグ検索</h3>
                        <div
                            v-for="(tags, category) in categories"
                            :key="category"
                            class="mb-4"
                        >
                            <h4 class="text-base font-semibold mb-2">
                                {{ category }}
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-for="tag in tags"
                                    :key="tag"
                                    @click="toggleTag(tag)"
                                    :class="
                                        tagSearch.includes(tag)
                                            ? 'bg-blue-500 text-white'
                                            : 'bg-gray-200 text-gray-800'
                                    "
                                    class="cursor-pointer px-3 py-1 rounded-full transition duration-200 ease-in-out"
                                >
                                    {{ tag }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- キーワード検索機能 -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">
                            キーワード検索
                        </h3>
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="キーワードを入力"
                            class="w-full p-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                    </div>
                </div>

                <!-- モバイル向けタブ切り替え -->
                <div class="md:hidden">
                    <div class="mb-4 flex">
                        <button
                            @click="setActiveTab('tags')"
                            :class="
                                activeTab === 'tags'
                                    ? 'bg-blue-500 text-white'
                                    : 'bg-gray-200 text-gray-800'
                            "
                            class="px-4 py-2 rounded-l-full w-1/2"
                        >
                            タグ検索
                        </button>
                        <button
                            @click="setActiveTab('keyword')"
                            :class="
                                activeTab === 'keyword'
                                    ? 'bg-blue-500 text-white'
                                    : 'bg-gray-200 text-gray-800'
                            "
                            class="px-4 py-2 rounded-r-full w-1/2"
                        >
                            キーワード検索
                        </button>
                    </div>
                    <div
                        v-if="activeTab === 'tags'"
                        class="bg-indigo-50 rounded-lg shadow p-4"
                    >
                        <h3 class="text-lg font-semibold mb-4">タグ検索</h3>
                        <div
                            v-for="(tags, category) in categories"
                            :key="category"
                            class="mb-4"
                        >
                            <h4 class="text-base font-semibold mb-2">
                                {{ category }}
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-for="tag in tags"
                                    :key="tag"
                                    @click="toggleTag(tag)"
                                    :class="
                                        tagSearch.includes(tag)
                                            ? 'bg-blue-500 text-white'
                                            : 'bg-gray-200 text-gray-800'
                                    "
                                    class="cursor-pointer px-3 py-1 rounded-full transition duration-200 ease-in-out"
                                >
                                    {{ tag }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="activeTab === 'keyword'"
                        class="bg-indigo-50 rounded-lg shadow p-4"
                    >
                        <h3 class="text-lg font-semibold mb-4">
                            キーワード検索
                        </h3>
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="キーワードを入力"
                            class="w-full p-2 border rounded mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
