<script setup>
import { Head, Link } from '@inertiajs/vue3';
import SecondaryButton from '../Components/SecondaryButton.vue';
import ApplicationLogo from '../Components/ApplicationLogo.vue';



defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    // laravelVersion: {
    //     type: String,
    //     required: true,
    // },
    // phpVersion: {
    //     type: String,
    //     required: true,
    // },
});

// function handleImageError() {
//     document.getElementById('screenshot-container')?.classList.add('!hidden');
//     document.getElementById('docs-card')?.classList.add('!row-span-1');
//     document.getElementById('docs-card-content')?.classList.add('!flex-row');
//     document.getElementById('background')?.classList.add('!hidden');
// }
</script>

<template>
    <Head title="トップページ" />
    <div class="bg-gray-50 text-black dark:bg-gray-900 dark:text-white">
        <div class="relative min-h-screen flex flex-col items-center justify-between selection:bg-blue selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <!-- Header -->
                <header class="grid grid-cols-1 lg:grid-cols-3 items-center gap-4 pb-10 pt-5">
                    <!-- Logo and Title -->
                    <div class="flex justify-center items-center lg:col-start-2 text-center">
                        <h1 class="font-bold text-1xl mr-2">ーつまんでこそー</h1>
                        <ApplicationLogo class="block h-16 w-auto fill-current text-gray-800 dark:text-gray-200 mx-2"/>
                        <h2 class="font-bold text-1xl ml-2">ー酒は旨くなるー</h2>
                    </div>
                    <!-- Navigation -->
                    <nav v-if="canLogin" class="flex flex-1 justify-end lg:justify-center">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('posts.index')"
                            class="rounded-md px-3 py-2 mx-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-blue dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            <SecondaryButton>一覧ページ</SecondaryButton>
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 mx-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-blue dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                            <SecondaryButton>ログイン</SecondaryButton>
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 mx-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-blue dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                            <SecondaryButton>新規登録</SecondaryButton>
                            </Link>
                        </template>
                    </nav>
                </header>
                <!-- Main Content -->
                <main class="text-center my-10">
                    <h1 class="text-5xl font-bold mb-6">お酒のつまみレシピ投稿アプリ</h1>
                    <p class="text-xl mb-8">お酒の時間をもっと楽しむための、美味しいつまみレシピを共有しよう！</p>
                    <div class="relative">
                        <img src="/images/top_bg.jpg" alt="Background Image" class="w-full h-auto object-cover rounded-lg shadow-lg">
                        <div class="absolute inset-0 bg-black opacity-30 rounded-lg"></div>
                        <p class="absolute inset-0 flex items-center justify-center text-white text-2xl font-semibold">
                            自分のレシピで晩酌をもっと楽しく！
                        </p>
                    </div>
                </main>
            </div>
            <!-- Footer -->
            <footer class="w-full py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                
                <a target="_blank" href="https://icons8.com/icon/c0aWWdZ9S_nj/beer">ビール</a> アイコン by <a target="_blank" href="https://icons8.com">Icons8</a>
                © 2024 Tsumami-sou. All rights reserved.
            </footer>
        </div>
    </div>
</template>


