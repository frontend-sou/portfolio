<script setup>
import BeerAnimation from '../Components/BeerAnimation.vue';
import TopPage from '../Components/TopPage.vue';
import { shallowRef } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

const emit = defineEmits(['animation-done']);

const currentComponent = shallowRef(BeerAnimation);

const showTopPage = (canLogin,canRegister) => {
    currentComponent.value = TopPage
}

</script>

<template>
    <div>
        <!-- transitionコンポーネントで状態の変化に応じてスタイル適用。transitionの中にdivタグ必須 -->
        <transition name="fade" mode="out-in">
            <div>
                <!-- 親コンポーネントがコンポーネントの状態を動的に呼び出し -->
                <component :is="currentComponent" @animation-done="showTopPage(canLogin,canRegister)" />
            </div>
        </transition>
    </div>
</template>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>



