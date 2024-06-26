<script setup>
import { onMounted, ref } from 'vue';

const emit = defineEmits(['animation-done']);

// アニメーション終了を制御するため2.5秒後にイベントをトリガー
// イベントを送出する関数。アニメーション終了後の操作
const handleAnimationEnd = onMounted(() => {
    setTimeout(() => {
        emit('animation-done');
    },3000);
});
</script>

<template>    
    <div class="beer-container" @animationend="handleAnimationEnd">
        <div class="beer"></div>
        <div class="bubble-container">
            <div class="bubble" v-for="n in 20" :key="n"></div>
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
  overflow: hidden;
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

.bubble:nth-child(5n+1) {
  left: 15%;
  animation-delay: .8s;
}

.bubble:nth-child(5n+2) {
  left: 30%;
  animation-delay: .2s;
}

.bubble:nth-child(5n+3) {
  left: 60%;
  animation-delay: .4s;
}

.bubble:nth-child(5n+4) {
  left: 75%;
  animation-delay: .9s;
}

.bubble:nth-child(5n+5) {
  left: 90%;
  animation-delay: .6s;
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

  