<template>
  <section class="min-h-screen py-16 px-4 md:px-0 flex flex-col items-center bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-950 dark:to-indigo-950 transition-colors duration-500">
    <div class="max-w-3xl w-full text-center mb-10">
      <h1 class="text-4xl md:text-5xl font-extrabold mb-2 bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent">Contact Us</h1>
      <p class="text-lg text-slate-600 dark:text-slate-300">We'd love to hear from you! Reach out with questions, feedback, or just to say hello.</p>
    </div>
    <div class="max-w-4xl w-full grid md:grid-cols-2 gap-10">
      <!-- Contact Form -->
      <form @submit.prevent="submitForm" class="bg-white/80 dark:bg-slate-900/80 rounded-2xl shadow p-8 flex flex-col gap-4">
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Name</label>
        <input v-model="form.name" type="text" required class="rounded-lg px-4 py-2 border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 text-slate-700 dark:text-slate-200" />
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email</label>
        <input v-model="form.email" type="email" required class="rounded-lg px-4 py-2 border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 text-slate-700 dark:text-slate-200" />
        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Message</label>
        <textarea v-model="form.message" required rows="4" class="rounded-lg px-4 py-2 border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 text-slate-700 dark:text-slate-200"></textarea>
        <button type="submit" :disabled="loading" class="mt-4 px-6 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold shadow hover:from-blue-400 hover:to-purple-400 transition-all duration-200">
          <span v-if="loading">Sending...</span>
          <span v-else>Send Message</span>
        </button>
        <p v-if="success" class="text-green-600 dark:text-green-400 mt-2">Thank you for contacting us! We'll get back to you soon.</p>
        <p v-if="error" class="text-red-600 dark:text-red-400 mt-2">{{ error }}</p>
      </form>
      <!-- Map & Info -->
      <div class="flex flex-col gap-6 items-center md:items-start justify-center">
        <GoogleMapEmbed :lat="30.8582961" :lng="29.5713993" :zoom="16" title="Borg El-Arab Technological University, Alexandria, Egypt" />
        <div class="text-slate-700 dark:text-slate-300 text-sm mt-2">
          <div class="font-semibold mb-1">Borg El-Arab Technological University</div>
          <div>VH5C+8H8, Unnamed Road, Hod Sakrah WA Abu Hamad,<br>Borg El Arab, Alexandria Governorate 5220211, Egypt</div>
          <div class="mt-2">Email: <a href="mailto:info@ctu.edu.eg" class="text-blue-500 underline">info@ctu.edu.eg</a></div>
          <div>Phone: <a href="tel:+201234567890" class="text-blue-500 underline">+20 123 456 7890</a></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import GoogleMapEmbed from '../components/ui/GoogleMapEmbed.vue';

const form = ref({ name: '', email: '', message: '' });
const loading = ref(false);
const success = ref(false);
const error = ref('');

async function submitForm() {
  loading.value = true;
  error.value = '';
  success.value = false;
  try {
    await axios.post('/api/contact', form.value);
    success.value = true;
    form.value = { name: '', email: '', message: '' };
  } catch (e) {
    error.value = e.response?.data?.message || 'Failed to send message.';
  } finally {
    loading.value = false;
  }
}
</script>
