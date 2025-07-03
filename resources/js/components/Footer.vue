<template>
  <footer :class="[
    'border-t backdrop-blur-sm pt-12 pb-6 transition-colors duration-500',
    isDark
      ? 'border-white/10 bg-black/70 text-white'
      : 'border-slate-300/30 bg-white/70 text-slate-700'
  ]">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
      <!-- Branding & Tagline -->
      <div class="flex flex-col items-center md:items-start gap-4">
        <img src="@/assets/icons/logo.png" alt="CTU Logo" class="h-16 w-16 object-contain mb-2 drop-shadow-lg" />
        <span class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500 tracking-wide">CTU</span>
        <p class="text-sm mt-2 max-w-xs text-center md:text-left" :class="isDark ? 'text-slate-400' : 'text-slate-500'">
          Empowering learners worldwide. Inspiring innovation and excellence in education.
        </p>
        <div class="flex gap-4 mt-2">
          <a href="https://www.linkedin.com/company/ctu" target="_blank" rel="noopener" :title="'LinkedIn'">
            <font-awesome-icon :icon="['fab', 'linkedin-in']" class="text-2xl transition-colors duration-200" :class="isDark ? 'text-blue-400 hover:text-blue-300' : 'text-blue-700 hover:text-blue-500'" />
          </a>
          <a href="https://github.com/ctu" target="_blank" rel="noopener" :title="'GitHub'">
            <font-awesome-icon :icon="['fab', 'github']" class="text-2xl transition-colors duration-200" :class="isDark ? 'text-slate-300 hover:text-white' : 'text-slate-700 hover:text-black'" />
          </a>
        </div>
      </div>

      <!-- Navigation Links -->
      <div class="flex flex-col items-center md:items-start gap-2">
        <span class="font-semibold mb-2 text-base tracking-wide">Quick Links</span>
        <router-link v-for="link in navLinks" :key="link.path" :to="link.path"
          class="text-sm font-medium hover:underline transition-colors duration-200 rounded px-2 py-1"
          :class="isDark ? 'text-slate-300 hover:text-blue-400' : 'text-slate-600 hover:text-blue-600'">
          {{ link.name }}
        </router-link>
      </div>

      <!-- More Pages -->
      <div class="flex flex-col items-center md:items-start gap-2">
        <span class="font-semibold mb-2 text-base tracking-wide">More Pages</span>
        <router-link v-for="page in morePages" :key="page.path" :to="page.path"
          class="text-sm font-medium hover:underline transition-colors duration-200 rounded px-2 py-1"
          :class="isDark ? 'text-slate-300 hover:text-purple-400' : 'text-slate-600 hover:text-purple-600'">
          {{ page.name }}
        </router-link>
      </div>

      <!-- Search & Map -->
      <div class="flex flex-col items-center md:items-end gap-4 w-full">
        <span class="font-semibold mb-2 text-base tracking-wide">Search</span>
        <form @submit.prevent="handleSearch" class="w-full flex items-center gap-2">
          <input v-model="searchQuery" type="text" placeholder="Search..." class="w-full rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition-all duration-200 shadow border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 text-slate-700 dark:text-slate-200" />
          <button type="submit" class="px-3 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold shadow hover:from-blue-400 hover:to-purple-400 transition-all duration-200">
            <font-awesome-icon :icon="['fas', 'search']" />
          </button>
        </form>
        <span class="font-semibold mt-6 mb-2 text-base tracking-wide">Our Location</span>
        <GoogleMapEmbed
          :lat="30.8582961"
          :lng="29.5713993"
          :zoom="16"
          title="Borg El-Arab Technological University, Alexandria, Egypt"
        />
      </div>
    </div>
    <div class="mt-12 border-t pt-6 text-center text-xs" :class="isDark ? 'border-white/10 text-slate-500' : 'border-slate-200 text-slate-400'">
      © 2025 CTU. All rights reserved. Made with <span :class="isDark ? 'text-red-500' : 'text-red-600'">❤️</span> by CTU Team.
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue';
import { useTheme } from '../composables/useTheme';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faLinkedinIn, faGithub } from '@fortawesome/free-brands-svg-icons';
import { faSearch } from '@fortawesome/free-solid-svg-icons';
import GoogleMapEmbed from './ui/GoogleMapEmbed.vue';

const { isDark } = useTheme();
library.add(faLinkedinIn, faGithub, faSearch);

const navLinks = [
  { name: 'Home', path: '/' },
  { name: 'Courses', path: '/courses' },
  { name: 'Categories', path: '/categories' },
  { name: 'Instructors', path: '/instructors' },
];

const morePages = [
  { name: 'About', path: '/about' },
  { name: 'Contact', path: '/contact' },
  { name: 'Blog', path: '/blog' },
  { name: 'FAQ', path: '/faq' },
  { name: 'Privacy Policy', path: '/privacy' },
  { name: 'Terms of Service', path: '/terms' },
];

const searchQuery = ref('');
const handleSearch = () => {
  if (searchQuery.value.trim()) {
    // You can replace this with your own search logic or route
    window.location.href = `/search?q=${encodeURIComponent(searchQuery.value)}`;
  }
};
</script>

<style scoped>
footer {
  font-family: 'Inter', sans-serif;
  box-shadow: 0 8px 32px rgba(0,0,0,0.07), 0 1.5px 0 rgba(80,80,80,0.03);
}
input:focus {
  outline: none;
  box-shadow: 0 0 0 2px #6366f1;
}
</style>
