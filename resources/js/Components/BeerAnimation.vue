<script setup>
import { defineEmits, onMounted } from 'vue';

const emit = defineEmits(['animation-done']);

// イベントを送出する関数。アニメーション終了後の操作
const handleAnimationEnd = () => {
    emit('animation-done');
}
  
// アニメーション終了を制御するため3秒後にイベントをトリガー
onMounted(() => {
    setTimeout(() => {
      handleAnimationEnd();
    }, 2500);
});

</script>

<template>
    <div class="beer-container" @animationend="handleAnimationEnd">
      <div class="beer"></div>
      <div class="bubble-container">
        <div class="bubble" v-for="n in 10" :key="n"></div>
      </div>
    </div>
</template>

<style scoped>
.beer-container {
    position: relative;
    width: 100%;
    height: 100vh;
    background-color: #f5f5f5;
    overflow: hidden;
}
  
.beer {
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 70%;
    background-color: #f4c542;
    animation: fillBeer 2.5s forwards;
}
  
@keyframes fillBeer {
    from {
      height: 0;
    }
    to {
      height: 70%;
    }
}
  
.bubble-container {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
}
  
.bubble {
    position: absolute;
    bottom: 0;
    width: 20px;
    height: 20px;
    background-color: white;
    border-radius: 50%;
    animation: riseBubble 1.0s infinite ease-in;
    opacity: 0.7;
}
  
.bubble:nth-child(odd) {
    left: 30%;
    width: 15px;
    height: 15px;
    animation-duration: 1.2s;
}
  
.bubble:nth-child(even) {
    left: 60%;
    width: 10px;
    height: 10px;
    animation-duration: 1s;
}
  
@keyframes riseBubble {
    0% {
      bottom: 0;
      transform: scale(0.5);
    }
    50% {
      transform: scale(1);
    }
    100% {
      bottom: 100%;
      transform: scale(0.5);
    }
}
</style>
  