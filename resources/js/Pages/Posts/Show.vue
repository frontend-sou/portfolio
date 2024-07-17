<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { getImagePath } from "../../Utils";

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    liked: {
        type: Boolean,
        required: true,
    },
    tags: {
        type: Array,
        required: true,
    },
});

// useFormフックスを使って入力値に対して処理させる
const form = useForm({
    post_id: props.post.id,
});

const handleDelete = (post) => {
    if (confirm("本当に削除しますか？")) {
        form.delete(route("posts.destroy", post.id), {
            onSuccess: () => {
                alert("投稿が削除されました。");
            },
            onError: (errors) => {
                alert("削除に失敗しました。もう一度お試しください。");
            },
        });
    }
};

// クリック状態を監視し、変更があれば変更後の状態を再描画(リアクティブ)
const clicked = ref(props.liked);

// トグル処理(refの中身とるには.value)
const toggleClicked = () => {
    clicked.value = !clicked.value;

    if (clicked.value) {
        form.post(route("like.store", { post: props.post.id }));
    } else {
        form.delete(route("like.destroy", { post: props.post.id }), {
            onSuccess: () => {
                // カスタムイベント'post-unlike'を作成し、イベントを発火させそれに対する処理をイベントの送り先で実行
                const e = new CustomEvent("post-unliked", {
                    detail: props.post.id,
                });
                window.dispatchEvent(e);
            },
        });
    }
};
</script>

<template>
    <Head title="投稿詳細" />
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-7 text-center sm:text-left">
            投稿詳細
        </h1>
        <div class="p-4 bg-white rounded-lg shadow-md">
            <div class="flex flex-col sm:flex-row justify-between p-5">
                <h2 class="text-2xl font-semibold mb-2 sm:mb-0">
                    タイトル：{{ post.title }}
                </h2>
                <!-- いいねボタン -->
                <button
                    type="button"
                    :class="[
                        'border focus:outline-none font-medium rounded-full text-sm px-4 py-2 text-center inline-flex items-center justify-center',
                        clicked
                            ? 'bg-blue-700 text-white border-blue-700'
                            : 'text-blue-700 border-blue-700 hover:bg-blue-700 hover:text-white',
                    ]"
                    @click="toggleClicked"
                    class="m-2 p-2 sm:mt-0 max-w-xs"
                >
                    <svg
                        class="w-4 h-4 mr-1"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 18 18"
                    >
                        <path
                            d="M3 7H1a1 1 0 0 0-1 1v8a2 2 0 0 0 4 0V8a1 1 0 0 0-1-1Zm12.954 0H12l1.558-4.5a1.778 1.778 0 0 0-3.331-1.06A24.859 24.859 0 0 1 6 6.8v9.586h.114C8.223 16.969 11.015 18 13.6 18c1.4 0 1.592-.526 1.88-1.317l2.354-7A2 2 0 0 0 15.954 7Z"
                        />
                    </svg>
                    <span>いいね</span>
                </button>
            </div>

            <!-- タグの表示 -->
            <div class="p-5 flex">
                <h3 class="text-xl font-semibold mb-2 mr-3">タグ:</h3>
                <div class="flex flex-wrap gap-2">
                    <span
                        v-for="tag in tags"
                        :key="tag.id"
                        class="px-3 py-1 rounded-full bg-gray-200 text-gray-800"
                    >
                        {{ tag.name }}
                    </span>
                </div>
            </div>

            <!-- 本文の表示 -->
            <div class="p-5 flex flex-col sm:flex-row">
                <img
                    v-if="post.image_path"
                    :src="getImagePath(post.image_path)"
                    alt="Post Image"
                    class="rounded-lg max-w-lg md:w-1/2 sm:w-1/4 md:mr-4 md:mb-0 mb-4"
                />
                <h1 class="text-base md:text-lg">作り方：{{ post.content }}</h1>
            </div>
        </div>

        <div
            class="flex flex-col sm:flex-row items-center justify-center mt-5 space-y-2 sm:space-y-0 sm:space-x-2"
        >
            <Link
                :href="route('posts.edit', post.id)"
                class="m-2 p-2 shadow-md rounded-lg bg-blue-500 text-white text-center w-full sm:w-auto max-w-xs"
                >編集</Link
            >
            <button
                class="m-2 p-2 shadow-md rounded-lg bg-red-500 text-white text-center w-full sm:w-auto max-w-xs"
                type="button"
                @click="handleDelete(post)"
            >
                削除
            </button>
        </div>
    </div>
</template>
