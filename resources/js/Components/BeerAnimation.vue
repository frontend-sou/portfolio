<script setup>
import { onMounted, ref } from 'vue';

const emit = defineEmits(['animation-done']);

const showText = ref(false);
const hideText = ref(false);

// ビールアニメーション終了2秒前にテキスト表示、アニメーション終了時にテキスト非表示
const handleAnimationEnd = onMounted(() => {
    // 3.5秒後にテキスト表示
    setTimeout(() => {
        showText.value = true;
    }, 3500);

    // 5.5秒後にアニメーション終了イベント
    setTimeout(() => {
        hideText.value = true;
        emit('animation-done');
    }, 5500);
});

</script>

<template>    
    <div class="beer-container" @animationend="handleAnimationEnd">
        <div class="beer"></div>
        <div class="bubble-container">
            <div class="bubble" v-for="n in 20" :key="n"></div>
        </div>
        <transition name="fade" mode="out-in">
            <div v-if="showText && !hideText" class="overlay">
                <div class="text">ツマミソウ</div>
            </div>
        </transition>
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

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  backdrop-filter: blur(10px);
  transition: backdrop-filter 1s, opacity 1s;
}

.text {
  font-size: 3rem;
  color: rgb(255, 255, 255);
  text-align: center;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>

  