<template>
  <!-- Global Theme Toggle Button -->
  <div class="fixed top-4 right-4 z-50">
    <button
      @click="toggleTheme"
      class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 dark:bg-slate-800/40 border border-white/30 dark:border-slate-700 shadow-lg hover:scale-110 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-400 backdrop-blur-sm"
      :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
    >
      <font-awesome-icon
        :icon="isDark ? 'sun' : 'moon'"
        class="text-xl transition-colors duration-300"
      />
      <span
        class="font-medium text-sm text-slate-700 dark:text-slate-200 hidden sm:inline"
        >{{ isDark ? "Light" : "Dark" }}</span
      >
    </button>
  </div>

  <div class="notfound-container w-full" :class="{ dark: isDark, light: !isDark }">
    <!-- SVG Aurora Borealis (dark mode) -->
    <div v-if="isDark" class="aurora-svg">
      <svg viewBox="0 0 1440 320" width="100%" height="320" preserveAspectRatio="none">
        <path
          class="aurora-path"
          d="M0,160 C360,240 1080,80 1440,160 L1440,320 L0,320 Z"
          fill="url(#auroraGradient)"
        />
        <defs>
          <linearGradient id="auroraGradient" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#7CFFCB" stop-opacity="0.32" />
            <stop offset="60%" stop-color="#32FF7E" stop-opacity="0.18" />
            <stop offset="100%" stop-color="#00FF94" stop-opacity="0" />
          </linearGradient>
        </defs>
      </svg>
    </div>
    <!-- 404 background image for light mode -->
    <div v-if="!isDark" class="light-404-bg"></div>
    <!-- 404 ground image for light mode -->
    <div v-if="!isDark" class="light-404-ground"></div>
    <!-- Stars (dark mode) -->
    <div v-if="isDark" class="stars">
      <div
        v-for="star in stars"
        :key="star.id"
        class="star"
        :style="{
          top: star.top + '%',
          left: star.left + '%',
          width: star.size + 'px',
          height: star.size + 'px',
          animationDuration: star.duration + 's',
          animationDelay: star.delay + 's',
        }"
      ></div>
    </div>
    <!-- SVG Meteors (Curved Shooting Stars, dark mode) -->
    <div v-if="isDark" class="meteors">
      <svg
        v-for="meteor in meteors"
        :key="meteor.id"
        class="meteor-svg"
        :style="{
          top: meteor.top + '%',
          left: meteor.left + '%',
          animationDelay: meteor.delay + 's',
        }"
        width="60"
        height="32"
        viewBox="0 0 60 32"
        fill="none"
      >
        <!-- Curved tail with animated wiggle -->
        <path
          class="meteor-tail"
          d="M10 28 Q 30 10, 50 4"
          stroke="url(#meteorTailGradient)"
          stroke-width="3"
          stroke-linecap="round"
          fill="none"
          filter="url(#glow)"
          opacity="0.7"
        />
        <!-- Meteor head -->
        <circle
          cx="52"
          cy="6"
          r="4"
          fill="#fffbe7"
          fill-opacity="0.95"
          filter="url(#glow)"
        />
        <defs>
          <linearGradient
            id="meteorTailGradient"
            x1="10"
            y1="28"
            x2="50"
            y2="4"
            gradientUnits="userSpaceOnUse"
          >
            <stop offset="0%" stop-color="#fffbe7" stop-opacity="0.0" />
            <stop offset="0.3" stop-color="#fffbe7" stop-opacity="0.4" />
            <stop offset="0.7" stop-color="#ffe066" stop-opacity="0.8" />
            <stop offset="1" stop-color="#ffe066" stop-opacity="1" />
          </linearGradient>
          <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
            <feGaussianBlur stdDeviation="2.5" result="coloredBlur" />
            <feMerge>
              <feMergeNode in="coloredBlur" />
              <feMergeNode in="SourceGraphic" />
            </feMerge>
          </filter>
        </defs>
      </svg>
    </div>
    <div class="dragon-bg">
      <img :src="dragonImg" alt="404 Dragon" :class="{ 'flip-x': !isDark }" />
    </div>
    <div class="notfound-content">
      <div class="notfound-404">
        <span v-if="isDark" class="gradient-text">404</span>
        <span v-else class="solid-text">404</span>
      </div>
      <div class="notfound-message">Page Not Found</div>
      <router-link to="/" class="notfound-home-btn">Go Home</router-link>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { useTheme } from "@/composables/useTheme";

const { isDark, toggleTheme } = useTheme();

const darkImg = new URL("@/assets/images/dark_404.png", import.meta.url).href;
const lightImg = new URL("@/assets/images/light_404.png", import.meta.url).href;

const dragonImg = computed(() => (isDark.value ? darkImg : lightImg));

// Generate stars for dark mode
const stars = ref([]);
const STAR_COUNT = 60;
onMounted(() => {
  stars.value = Array.from({ length: STAR_COUNT }, (_, i) => ({
    id: i,
    top: Math.random() * 100,
    left: Math.random() * 100,
    size: 1 + Math.random() * 2,
    duration: 2 + Math.random() * 3,
    delay: Math.random() * 3,
  }));
});

// Generate meteors for dark mode (SVG shooting stars)
const meteors = ref([]);
const METEOR_COUNT = 14;
onMounted(() => {
  meteors.value = Array.from({ length: METEOR_COUNT }, (_, i) => ({
    id: i,
    top: Math.random() * 90, // 0% to 90% from top
    left: Math.random() * 90, // 0% to 90% from left
    delay: Math.random() * 8, // random delay for each meteor
  }));
});
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Orbitron:wght@900&display=swap");

.flip-x {
  transform: scaleX(-1);
}

/* Move dragon to the left in light mode on large screens */
@media (min-width: 1024px) {
  .notfound-container.light .dragon-bg {
    left: 45%;
  }

  .light-404-ground {
    width: 700px;
    height: 150px;
  }
}

.day-sky {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  height: 100vh;
  background: linear-gradient(180deg, #e0f7fa 0%, #fff 100%);
  z-index: 0;
  overflow: hidden;
  pointer-events: none;
}

.sun {
  position: absolute;
  top: 40px;
  left: 60px;
  z-index: 1;
  animation: sunPulse 4s ease-in-out infinite alternate;
}

.sun-rays line {
  transform-origin: 60px 60px;
  animation: sunRaySpin 8s linear infinite;
}

@keyframes sunPulse {
  0% {
    filter: brightness(1) drop-shadow(0 0 12px #ffe06688);
  }

  100% {
    filter: brightness(1.15) drop-shadow(0 0 32px #ffe066cc);
  }
}

@keyframes sunRaySpin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

.cloud {
  position: absolute;
  z-index: 2;
  opacity: 0.85;
  pointer-events: none;
}

.cloud1 {
  top: 80px;
  left: 20vw;
  animation: cloudMove1 38s linear infinite;
}

.cloud2 {
  top: 160px;
  left: 60vw;
  animation: cloudMove2 52s linear infinite;
}

.cloud3 {
  top: 220px;
  left: 35vw;
  animation: cloudMove3 44s linear infinite;
}

@keyframes cloudMove1 {
  0% {
    left: 20vw;
  }

  100% {
    left: 80vw;
  }
}

@keyframes cloudMove2 {
  0% {
    left: 60vw;
  }

  100% {
    left: -20vw;
  }
}

@keyframes cloudMove3 {
  0% {
    left: 35vw;
  }

  100% {
    left: 90vw;
  }
}

.sparkle {
  position: absolute;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background: radial-gradient(circle, #fffbe7 0%, #ffe066 60%, transparent 100%);
  opacity: 0.7;
  pointer-events: none;
  z-index: 3;
  animation: sparkleTwinkle 2.5s infinite alternate;
}

.sparkle1 {
  top: 120px;
  left: 30vw;
  animation-delay: 0.2s;
}

.sparkle2 {
  top: 200px;
  left: 70vw;
  animation-delay: 1.1s;
}

.sparkle3 {
  top: 300px;
  left: 50vw;
  animation-delay: 1.8s;
}

@keyframes sparkleTwinkle {
  0% {
    opacity: 0.5;
    transform: scale(1);
  }

  50% {
    opacity: 1;
    transform: scale(1.2);
  }

  100% {
    opacity: 0.5;
    transform: scale(1);
  }
}

.aurora-svg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 320px;
  z-index: 0;
  pointer-events: none;
  overflow: hidden;
  animation: auroraWave 8s ease-in-out infinite alternate;
}

.aurora-svg svg {
  width: 100%;
  height: 320px;
  display: block;
}

.aurora-path {
  filter: blur(8px) brightness(1.2);
  opacity: 0.85;
  animation: auroraColor 10s ease-in-out infinite alternate;
}

@keyframes auroraWave {
  0% {
    transform: scaleY(1) translateY(0);
  }

  50% {
    transform: scaleY(1.08) translateY(10px);
  }

  100% {
    transform: scaleY(1) translateY(0);
  }
}

@keyframes auroraColor {
  0% {
    filter: blur(8px) brightness(1.2) hue-rotate(0deg);
  }

  50% {
    filter: blur(12px) brightness(1.3) hue-rotate(-10deg);
  }

  100% {
    filter: blur(8px) brightness(1.2) hue-rotate(0deg);
  }
}

.stars {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  height: 100vh;
  pointer-events: none;
  z-index: 1;
}

.star {
  position: absolute;
  background: white;
  border-radius: 50%;
  opacity: 0.8;
  box-shadow: 0 0 6px 2px #fff8;
  animation: twinkle 2.5s infinite alternate, floatStar 10s linear infinite;
}

@keyframes twinkle {
  0% {
    opacity: 0.7;
  }

  50% {
    opacity: 1;
  }

  100% {
    opacity: 0.6;
  }
}

@keyframes floatStar {
  0% {
    transform: translateY(0);
  }

  100% {
    transform: translateY(-10px);
  }
}

.meteors {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  height: 100vh;
  pointer-events: none;
  z-index: 2;
}

.meteor-svg {
  position: absolute;
  width: 60px;
  height: 32px;
  pointer-events: none;
  opacity: 0;
  animation: meteorCurve 2.2s linear infinite;
  transform: rotate(-45deg);
}

.meteor-tail {
  animation: tailWiggle 1.2s ease-in-out infinite alternate;
}

@keyframes tailWiggle {
  0% {
    d: path("M10 28 Q 30 10, 50 4");
  }

  25% {
    d: path("M10 28 Q 32 14, 50 4");
  }

  50% {
    d: path("M10 28 Q 28 6, 50 4");
  }

  75% {
    d: path("M10 28 Q 34 18, 50 4");
  }

  100% {
    d: path("M10 28 Q 30 10, 50 4");
  }
}

@keyframes meteorCurve {
  0% {
    opacity: 0;
    transform: rotate(+45deg) translate(-20px, -40px) scale(1);
  }

  10% {
    opacity: 1;
  }

  80% {
    opacity: 1;
    transform: rotate(-45deg) translate(60px, 80px) scale(1.1);
  }

  100% {
    opacity: 0;
    transform: rotate(-45deg) translate(120px, 120px) scale(1.15);
  }
}

.notfound-container {
  position: relative;
  min-height: 100vh;
  width: 100%;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #18181b;
  transition: background 0.3s;
}

.notfound-container.light {
  background: #f3f4f6;
}

.dragon-bg {
  position: absolute;
  top: 50%;
  left: 50%;
  width: 700px;
  height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
  transform: translate(-50%, -55%);
  z-index: 1;
  pointer-events: none;
}

.dragon-bg img {
  width: 100%;
  height: auto;
  opacity: 0.97;
  user-select: none;
}

.notfound-content {
  position: relative;
  z-index: 7;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.notfound-404 {
  font-size: 9rem;
  font-family: "Orbitron", "Segoe UI", Arial, sans-serif;
  font-weight: 900;
  margin-bottom: 0.5rem;
  letter-spacing: 0.1em;
  filter: drop-shadow(0 4px 32px #000) drop-shadow(0 2px 8px #222);
  animation: float404 3.5s ease-in-out infinite alternate;
  line-height: 1;
  user-select: none;
}

.gradient-text {
  background: linear-gradient(90deg, #6366f1, #60a5fa, #f87171, #fbbf24);
  background-size: 200% 200%;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-fill-color: transparent;
  animation: gradientMove 4s linear infinite;
  text-shadow: 0 0 32px #fff8, 0 2px 8px #0008;
}

@keyframes gradientMove {
  0% {
    background-position: 0% 50%;
  }

  50% {
    background-position: 100% 50%;
  }

  100% {
    background-position: 0% 50%;
  }
}

@keyframes float404 {
  0% {
    transform: translateY(0);
  }

  100% {
    transform: translateY(-18px);
  }
}

.notfound-container.light .notfound-404 .gradient-text {
  background: linear-gradient(90deg, #6366f1, #60a5fa, #f87171, #fbbf24);
  text-shadow: 0 0 32px #fff8, 0 2px 8px #bbb8;
}

.notfound-message {
  font-size: 2rem;
  color: #f87171;
  margin-bottom: 2rem;
  text-shadow: 0 2px 8px #000;
  transition: color 0.3s, text-shadow 0.3s;
}

.notfound-container.light .notfound-message {
  color: #ef4444;
  text-shadow: 0 2px 8px #fff8;
}

.notfound-home-btn {
  padding: 0.75rem 2.5rem;
  background: linear-gradient(90deg, #6366f1, #60a5fa);
  color: #fff;
  border-radius: 999px;
  font-size: 1.25rem;
  font-weight: 600;
  text-decoration: none;
  box-shadow: 0 2px 12px #0004;
  transition: background 0.2s, transform 0.2s, color 0.3s;
}

.notfound-container.light .notfound-home-btn {
  color: #18181b;
  background: linear-gradient(90deg, #a5b4fc, #bae6fd);
  box-shadow: 0 2px 12px #bbb4;
}

.notfound-home-btn:hover {
  background: linear-gradient(90deg, #60a5fa, #6366f1);
  transform: translateY(-2px) scale(1.04);
}

.notfound-container.light .notfound-home-btn:hover {
  background: linear-gradient(90deg, #bae6fd, #a5b4fc);
}

.solid-text {
  color: #18181b;
  text-shadow: 0 4px 32px #fff8, 0 2px 8px #bbb8;
  font-family: "Orbitron", "Segoe UI", Arial, sans-serif;
  font-size: inherit;
  font-weight: inherit;
  animation: float404 3.5s ease-in-out infinite alternate;
  line-height: 1;
  user-select: none;
}

.light-404-bg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100vh;
  z-index: 1;
  background: url("@/assets/images/404_bg.png") no-repeat center center;
  background-size: cover;
  opacity: 0.7;
  pointer-events: none;
}

.light-404-ground {
  position: absolute;
  left: 28%;
  bottom: 250px;
  /* width: 600px; */
  /* max-width: 90vw; */
  height: 9999px;
  z-index: 3;
  transform: translateX(-50%);
  background: url("@/assets/images/404_ground.png") no-repeat center bottom;
  background-size: contain;
  pointer-events: none;
}

.notfound-container.light .dragon-bg {
  z-index: 4;
}
</style>
