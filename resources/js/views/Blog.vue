<template>
  <section class="min-h-screen py-16 px-4 md:px-0 flex flex-col items-center bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-950 dark:to-indigo-950 transition-colors duration-500">
    <div class="max-w-3xl w-full text-center mb-10">
      <h1 class="text-4xl md:text-5xl font-extrabold mb-2 bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent">CTU Blog</h1>
      <p class="text-lg text-slate-600 dark:text-slate-300">Latest news, stories, and updates from Borg El-Arab Technological University.</p>
    </div>
    <div class="max-w-5xl w-full grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
      <div v-if="loading" class="col-span-full text-center text-blue-500 py-8">Loading blog posts...</div>
      <div v-else-if="error" class="col-span-full text-center text-red-500 py-8">{{ error }}</div>
      <template v-else>
        <div v-for="post in posts" :key="post.id" class="bg-white/80 dark:bg-slate-900/80 rounded-2xl shadow p-6 flex flex-col gap-3">
          <h2 class="text-xl font-bold text-blue-600 dark:text-blue-300">{{ post.title }}</h2>
          <p class="text-slate-700 dark:text-slate-300">{{ post.excerpt }}</p>
          <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 mt-2">
            <span>By {{ post.author }}</span>
            <span>{{ post.published_at ? new Date(post.published_at).toLocaleDateString() : '' }}</span>
          </div>
        </div>
      </template>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const posts = ref([]);
const loading = ref(true);
const error = ref('');

onMounted(async () => {
  try {
    const res = await axios.get('/api/blogs');
    posts.value = res.data;
  } catch (e) {
    error.value = 'Failed to load blog posts.';
  } finally {
    loading.value = false;
  }
});
</script>
