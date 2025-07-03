<template>
  <section class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-red-100 via-yellow-100 to-blue-100 dark:from-slate-900 dark:via-rose-900 dark:to-indigo-950 transition-colors duration-500">
    <div class="text-center">
      <h1 class="text-4xl md:text-5xl font-extrabold mb-6 bg-gradient-to-r from-red-500 to-yellow-500 bg-clip-text text-transparent">Are you trying to hack me?</h1>
      <p class="text-lg text-slate-700 dark:text-slate-300 mb-8">Nice try! But here's something for you instead...</p>
      <div class="rounded-xl overflow-hidden shadow-lg max-w-xl mx-auto">
        <video
          ref="videoEl"
          id="rickroll-video"
          class="video-js vjs-default-skin vjs-big-play-centered"
          width="400"
          height="225"
          preload="metadata"
          controls
          loop
          playsinline
        >
          <source src="@/assets/videos/SnapAny.mp4" type="video/mp4" />
          Sorry, your browser does not support the video tag.
        </video>
        <div v-if="showAutoplayMsg" class="mt-4 text-red-600 dark:text-red-400 text-sm">Autoplay with sound was blocked. Click the play button above!</div>
      </div>
      <p class="mt-8 text-slate-500 dark:text-slate-400">Never gonna give you up, never gonna let you down...</p>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import videojs from 'video.js';
import 'video.js/dist/video-js.css';
import { useTheme } from '../composables/useTheme';
const { isDark } = useTheme();

const videoEl = ref(null);
const showAutoplayMsg = ref(false);

onMounted(() => {
  const player = videojs(videoEl.value, {
    autoplay: true,
    controls: true,
    loop: true,
    preload: 'auto',
  });
  // Try to play with sound
  player.ready(function () {
    player.volume(1);
    player.muted(false);
    const playPromise = player.play();
    if (playPromise !== undefined) {
      playPromise.catch(() => {
        showAutoplayMsg.value = true;
      });
    }
  });
});
</script>
