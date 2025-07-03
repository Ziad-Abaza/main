<template>
  <div :class="isDark ? 'text-white' : 'text-slate-800'">
    <h2 class="text-2xl font-semibold">Welcome back!</h2>
    <p class="mt-4" :class="isDark ? 'text-gray-300' : 'text-gray-500'">Select an item from the sidebar to view your data.</p>
  </div>
</template>

<script setup>
import { useTheme } from '../../composables/useTheme';
const { isDark } = useTheme();
</script>

<style scoped></style>
