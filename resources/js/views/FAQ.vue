<template>
  <section class="min-h-screen py-16 px-4 md:px-0 flex flex-col items-center bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-950 dark:to-indigo-950 transition-colors duration-500">
    <div class="max-w-3xl w-full text-center mb-10">
      <h1 class="text-4xl md:text-5xl font-extrabold mb-2 bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent">Frequently Asked Questions</h1>
      <p class="text-lg text-slate-600 dark:text-slate-300">Find answers to common questions about CTU, our programs, and services.</p>
    </div>
    <div class="max-w-2xl w-full bg-white/80 dark:bg-slate-900/80 rounded-2xl shadow p-8 flex flex-col gap-4">
      <div v-if="loading" class="text-center text-blue-500 py-8">Loading FAQs...</div>
      <div v-else-if="error" class="text-center text-red-500 py-8">{{ error }}</div>
      <template v-else>
        <details v-for="faq in faqs" :key="faq.id" class="group rounded-lg border border-slate-200 dark:border-slate-700 p-4 transition-colors duration-200" :open="faqs.length === 1">
          <summary class="font-semibold cursor-pointer text-blue-600 dark:text-blue-300">{{ faq.question }}</summary>
          <p class="mt-2 text-slate-700 dark:text-slate-300">{{ faq.answer }}</p>
        </details>
      </template>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const faqs = ref([]);
const loading = ref(true);
const error = ref('');

onMounted(async () => {
  try {
    const res = await axios.get('/api/faqs');
    faqs.value = res.data;
  } catch (e) {
    error.value = 'Failed to load FAQs.';
  } finally {
    loading.value = false;
  }
});
</script>
