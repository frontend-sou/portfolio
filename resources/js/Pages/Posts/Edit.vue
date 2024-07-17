<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { route } from "../../../../vendor/tightenco/ziggy/src/js";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import { ref } from "vue";
import { getImagePath } from "../../Utils";

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    tags: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    title: props.post.title,
    content: props.post.content,
    image: null,
    tags: props.tags.map((tag) => tag.name),
    _method: "PUT", //フォームメソッドのオーバーライドを利用。
});

const selectedTags = ref(form.tags);

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

// タグのボタン切り替え(tagはクリックされたタグの名前)
const toggleTag = (tag) => {
    // タグがすでに選択されてtagsの中に含まれている場合、タグリストの中身一つをelementとしてtagと照合し合致した以外の要素を配列にし直して再構成
    if (selectedTags.value.includes(tag)) {
        selectedTags.value = selectedTags.value.filter(
            (element) => element !== tag
        );
        // タグが無かったらtagの要素追加
    } else {
        selectedTags.value.push(tag);
    }
    form.tags = selectedTags.value;
};

const handleFileChange = (e) => {
    form.image = e.target.files[0];
};

const submit = () => {
    // ルート,パラメータはroute()内に入れる
    form.post(route("posts.update", { post: props.post, tags: props.tags })),
        {
            forceFormData: true,
        };
};
</script>

<template>
    <Head title="投稿編集" />
    <div class="container mx-auto p-6 bg-white shadow-md rounded-md">
        <h1 class="text-2xl font-semibold mb-4">投稿編集</h1>
        <!-- タグセクション -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">タグを選択</h2>
            <!-- :keyを指定してカテゴリーを一意に追跡。categoriesはキーと値を持つためtags,categoryをループさせている -->
            <div
                v-for="(tags, category) in categories"
                :key="category"
                class="mb-4"
            >
                <h3 class="text-lg font-semibold">{{ category }}</h3>
                <div class="flex flex-wrap gap-2">
                    <span
                        v-for="tag in tags"
                        :key="tag"
                        @click="toggleTag(tag)"
                        :class="
                            selectedTags.includes(tag)
                                ? 'bg-blue-500 text-white'
                                : 'bg-gray-200 text-gray-800'
                        "
                        class="cursor-pointer px-3 py-1 rounded-full"
                    >
                        {{ tag }}
                    </span>
                </div>
            </div>
            <div v-if="form.errors.tags" class="text-red-600 text-sm mt-1">
                {{ form.errors.tags }}
            </div>
        </div>

        <!-- 画像データの時はformにenctype必須 -->
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div class="mb-4">
                <label
                    for="title"
                    class="block text-sm font-medium text-gray-700"
                    >タイトル</label
                >
                <input
                    v-model="form.title"
                    id="title"
                    type="text"
                    class="mt-1 p-2 block w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">
                    {{ form.errors.title }}
                </div>
            </div>
            <div class="mb-4">
                <label
                    for="content"
                    class="block text-sm font-medium text-gray-700"
                    >レシピ詳細</label
                >
                <textarea
                    v-model="form.content"
                    id="content"
                    rows="4"
                    class="mt-1 p-2 block w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                ></textarea>
                <div
                    v-if="form.errors.content"
                    class="text-red-600 text-sm mt-1"
                >
                    {{ form.errors.content }}
                </div>
            </div>
            <div class="mb-4">
                <label
                    for="image"
                    class="block text-sm font-medium text-gray-700"
                    >画像アップロード</label
                >
                <input
                    @change="handleFileChange"
                    type="file"
                    id="image"
                    class="mt-1 p-2 block w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <PrimaryButton>送信</PrimaryButton>
        </form>
        <div v-if="post.image_path" class="mt-4">
            <img
                class="h-auto max-w-14 rounded-lg"
                :src="getImagePath(post.image_path)"
                alt="Current Image"
            />
        </div>
    </div>
</template>
