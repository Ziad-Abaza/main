<template>
  <div class="logout-page">
    <p>Clearing session data...</p>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAuthStore } from '../../stores/auth';

const authStore = useAuthStore();

onMounted(async () => {
  try {
    await authStore.clearStorage();
  } catch (error) {
    console.error('Failed to clear storage:', error);
    window.location.assign('/login');
  }
});
</script>

<style scoped>
.logout-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  font-size: 1.2rem;
  color: #666;
}
</style>
