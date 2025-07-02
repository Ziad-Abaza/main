<template>
  <transition name="toast" appear>
    <div v-if="visible" :class="['fixed bottom-6 right-6 bg-gray-800 text-white px-4 py-3 rounded shadow-lg flex items-center', variantClass]">
      <span>{{ message }}</span>
    </div>
  </transition>
</template>

<script setup>
import { ref } from 'vue';
const visible = ref(false);
const message = ref('');
const variantClass = ref('');

function show(msg, variant = 'info') {
  message.value = msg;
  variantClass.value = variant === 'success' ? 'bg-green-600' : variant === 'danger' ? 'bg-red-600' : 'bg-gray-800';
  visible.value = true;
  setTimeout(() => (visible.value = false), 3000);
}

defineExpose({ show });
</script>

<style scoped>
.toast-enter-active, .toast-leave-active { transition: opacity 0.2s; }
.toast-enter-from, .toast-leave-to { opacity: 0; }
</style>
