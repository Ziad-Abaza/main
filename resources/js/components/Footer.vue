<template>
  <footer :class="[
    'border-t backdrop-blur-sm py-8 text-center transition-colors duration-500',
    isDark
      ? 'border-white/10 bg-black/50 text-white'
      : 'border-slate-300/30 bg-white/50 text-slate-700'
  ]">
    © 2025 EduStream. All rights reserved. Made with ❤️ by EduStream Team.
  </footer>
</template>

<script setup>
import { useTheme } from '../composables/useTheme';

const { isDark } = useTheme();
</script>

<style scoped>
/* footer {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(10px);
  border-top: 1px solid rgba(255, 255, 255, 0.1);
} */
</style>
