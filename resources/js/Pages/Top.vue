<script setup>
import BeerAnimation from '../Components/BeerAnimation.vue';
import TopPage from '../Components/TopPage.vue';
import { shallowRef } from 'vue';

const emit = defineEmits(['animation-done']);
const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

// 浅いリアクティブ
const currentComponent = shallowRef(BeerAnimation);

// propsをTopPageに渡す
const showTopPage = () => {
    currentComponent.value = TopPage;
}
</script>

<template>
    <!-- 親コンポーネントがコンポーネントの状態を動的に呼び出し -->
    <component v-bind="{canLogin,canRegister}" :is="currentComponent" @animation-done="showTopPage"/>
</template>