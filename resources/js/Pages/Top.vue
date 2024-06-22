<script setup>
import { Head, Link } from '@inertiajs/vue3';
import SecondaryButton from '../Components/SecondaryButton.vue';
import ApplicationLogo from '../Components/ApplicationLogo.vue';
// import Icon from "~icons/icons/logo";


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
    <div class="bg-gray-40 text-black/80 dark:bg-black dark:text-white/50">
        <div class="relative min-h-screen flex flex-col items-center justify-between selection:bg-blue selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <!-- Header -->
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <!-- Logo -->
                    <div class="flex lg:justify-center lg:col-start-2 text-center">
                        <h1 class="font-bold">ーつまんでこそー</h1>
                        <ApplicationLogo class="block h-12 w-auto fill-current text-gray-800"/>
                        <h1 class="font-bold">ー酒は旨くなるー</h1>
                    </div>
                    <!-- Navigation -->
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('posts.index')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-blue dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
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
                    <h1 class="text-4xl font-bold mb-4">お酒のつまみレシピ投稿アプリ</h1>
                    <p class="text-lg mb-8">お酒の時間をもっと楽しむための、美味しいつまみレシピを共有しよう！</p>
                    <div class="relative">
                        <img src="/images/top_bg.jpg" alt="Background Image" class="w-full h-auto object-cover opacity-70">
                        <div class="absolute inset-0 bg-black opacity-50"></div>
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
