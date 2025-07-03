<template>
  <nav :class="[
    'modern-navbar',
    { scrolled: isScrolled },
    isDark ? 'fixed top-0 left-0 w-full z-50 px-4 py-3 transition-all duration-500' : 'fixed top-0 left-0 w-full z-50 px-4 py-3 transition-all duration-500 bg-white/95 border-b border-blue-50 shadow',
    !isDark && isScrolled ? 'bg-white border-b border-blue-100 shadow-md' : ''
  ]">
    <div class="container mx-auto flex items-center justify-between">
      <!-- Logo with enhanced animation -->
      <router-link to="/" class="flex items-center space-x-2 group">
        <img :src="logo" alt="CTU Logo" class="h-16 w-16 object-contain transition-transform duration-300 group-hover:scale-110" />
        <span class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500">CTU</span>
      </router-link>

      <!-- Desktop Menu with enhanced styling -->
      <div class="hidden md:flex items-center space-x-1">
        <router-link v-for="link in navLinks" :key="link.path" :to="link.path"
          class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 group nav-link"
          :class="{
            'text-blue-400 bg-white/10 shadow-md': $route.path === link.path,
            'text-gray-300 hover:text-white hover:bg-white/5': $route.path !== link.path
          }">
          <span class="relative z-10">{{ link.name }}</span>
          <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </router-link>
      </div>

      <!-- Right Side Actions -->
      <div class="flex items-center space-x-3">
        <!-- Theme Toggle Button -->
        <button
          @click="toggleTheme"
          class="flex items-center justify-center w-10 h-10 rounded-lg transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white/10 hover:bg-white/20 text-yellow-400 dark:text-blue-400"
          :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
        >
          <font-awesome-icon :icon="isDark ? 'sun' : 'moon'" class="text-xl transition-colors duration-300" />
        </button>

        <!-- Search Button with enhanced design -->
        <button
          class="hidden md:flex items-center justify-center w-10 h-10 text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300 hover:scale-105 group"
          @click="toggleSearch">
          <font-awesome-icon :icon="['fas', 'search']" class="text-sm" />
          <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </button>

        <!-- Auth Actions -->
        <div v-if="authStore.user" class="flex items-center space-x-3">
          <div class="hidden md:flex items-center space-x-2 px-3 py-2 bg-white/5 rounded-lg">
            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
            <span class="text-sm text-gray-300">
              {{ authStore.name || authStore.user.email }}
            </span>
          </div>
          <button @click="authStore.logout()"
            class="relative overflow-hidden text-sm px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-400 hover:to-red-500 text-white rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 group">
            <span class="relative z-10">Logout</span>
            <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-red-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </button>
        </div>
        <router-link v-else to="/login"
          class="relative overflow-hidden text-sm px-5 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 group">
          <span class="relative z-10">Login</span>
          <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </router-link>

        <!-- Mobile Menu Toggle -->
        <button class="md:hidden relative w-10 h-10 flex items-center justify-center text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300 group" @click="toggleMobileMenu">
          <font-awesome-icon :icon="['fas', isMobileMenuOpen ? 'times' : 'bars']" class="text-sm" />
          <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </button>
      </div>
    </div>

    <!-- Enhanced Mobile Menu -->
    <transition name="mobile-menu">
      <div v-if="isMobileMenuOpen"
        class="md:hidden bg-gradient-to-br from-gray-900/95 to-purple-900/95 backdrop-filter backdrop-blur-lg mt-4 mx-2 rounded-xl shadow-2xl border border-white/10">
        <div class="flex flex-col space-y-2 p-4">
          <router-link v-for="link in navLinks" :key="link.path" :to="link.path"
            class="relative px-4 py-3 text-gray-300 text-base font-medium rounded-lg transition-all duration-300 group"
            :class="{ 'text-blue-400 bg-white/10': $route.path === link.path }"
            @click="isMobileMenuOpen = false">
            <span class="relative z-10">{{ link.name }}</span>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </router-link>

          <!-- Mobile Search -->
          <button @click="toggleSearch(); isMobileMenuOpen = false"
            class="relative px-4 py-3 text-gray-300 text-base font-medium rounded-lg transition-all duration-300 group text-left">
            <span class="relative z-10 flex items-center">
              <font-awesome-icon :icon="['fas', 'search']" class="mr-3" />
              Search
            </span>
            <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </button>
        </div>
      </div>
    </transition>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faStream, faSearch, faBars, faTimes, faMoon, faSun } from '@fortawesome/free-solid-svg-icons';
import { useAuthStore } from '../stores/auth';
import { useRoute } from 'vue-router';
import { useTheme } from '../composables/useTheme';
import logo from '../assets/icons/logo.png';

library.add(faStream, faSearch, faBars, faTimes, faMoon, faSun);

const authStore = useAuthStore();
const route = useRoute();
const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);
const { isDark, toggleTheme } = useTheme();

const navLinks = [
  { name: 'Home', path: '/' },
  { name: 'Courses', path: '/courses' },
  { name: 'Categories', path: '/categories' },
  { name: 'Instructors', path: '/instructors' },
];

const handleScroll = () => {
  isScrolled.value = window.scrollY > 30;
};

const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const toggleSearch = () => {
  console.log('Search toggled');
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

<style scoped>
.modern-navbar {
  background: rgba(15, 23, 42, 0.8);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
}

:deep(.modern-navbar) {
  /* Light mode overrides */
  background: var(--navbar-bg, rgba(15, 23, 42, 0.8));
}

:deep(.modern-navbar):not(.dark) {
  --navbar-bg: #fff;
  color: #1e293b;
  border-bottom: 1px solid #f1f5f9;
  box-shadow: 0 2px 8px rgba(59, 130, 246, 0.04);
}

:deep(.modern-navbar):not(.dark).scrolled {
  --navbar-bg: #fff;
  border-bottom: 1px solid #e0e7ef;
  box-shadow: 0 4px 16px rgba(59, 130, 246, 0.07);
}

:deep(.modern-navbar):not(.dark) .nav-link {
  color: #64748b;
  background: transparent;
}
:deep(.modern-navbar):not(.dark) .nav-link.router-link-active,
:deep(.modern-navbar):not(.dark) .nav-link.router-link-exact-active {
  color: #2563eb;
  background: #f1f5f9;
}
:deep(.modern-navbar):not(.dark) .nav-link:hover {
  color: #1e40af;
  background: #f3f4f6;
}
:deep(.modern-navbar):not(.dark) .group-hover\:opacity-100.transition-opacity.duration-300 {
  background: linear-gradient(to right, #e0e7ff55, #f3e8ff55);
}
:deep(.modern-navbar):not(.dark) .bg-gradient-to-r {
  background: linear-gradient(to right, #60a5fa, #a78bfa);
  color: transparent;
  background-clip: text;
  -webkit-background-clip: text;
}
:deep(.modern-navbar):not(.dark) .text-gray-300 {
  color: #64748b !important;
}
:deep(.modern-navbar):not(.dark) .bg-white\/10 {
  background: #f1f5f9 !important;
}
:deep(.modern-navbar):not(.dark) .bg-white\/5 {
  background: #f3f4f6 !important;
}
:deep(.modern-navbar):not(.dark) .text-blue-400 {
  color: #2563eb !important;
}
:deep(.modern-navbar):not(.dark) .text-white {
  color: #1e293b !important;
}
:deep(.modern-navbar):not(.dark) .hover\:bg-white\/5:hover {
  background: #f3f4f6 !important;
}
:deep(.modern-navbar):not(.dark) .hover\:bg-white\/10:hover {
  background: #f1f5f9 !important;
}
:deep(.modern-navbar):not(.dark) .bg-gradient-to-r.from-blue-600.to-purple-600 {
  background: linear-gradient(to right, #2563eb, #a78bfa) !important;
}
:deep(.modern-navbar):not(.dark) .bg-gradient-to-r.from-red-500.to-red-600 {
  background: linear-gradient(to right, #ef4444, #f87171) !important;
}
:deep(.modern-navbar):not(.dark) .bg-gradient-to-r.from-blue-500.to-purple-500 {
  background: linear-gradient(to right, #60a5fa, #a78bfa) !important;
}
:deep(.modern-navbar):not(.dark) .bg-gradient-to-r.from-blue-500\/20.to-purple-500\/20 {
  background: linear-gradient(to right, #e0e7ff55, #f3e8ff55) !important;
}
:deep(.modern-navbar):not(.dark) .bg-gradient-to-r.from-red-400.to-red-500 {
  background: linear-gradient(to right, #fca5a5, #f87171) !important;
}
:deep(.modern-navbar):not(.dark) .text-yellow-400 {
  color: #f59e42 !important;
}
:deep(.modern-navbar):not(.dark) .dark\:text-blue-400 {
  color: #2563eb !important;
}
:deep(.modern-navbar):not(.dark) .rounded-lg {
  border-radius: 0.75rem;
}
:deep(.modern-navbar):not(.dark) .shadow-lg {
  box-shadow: 0 2px 8px rgba(59, 130, 246, 0.04);
}
:deep(.modern-navbar):not(.dark) .shadow-xl {
  box-shadow: 0 4px 16px rgba(59, 130, 246, 0.07);
}

.scrolled {
  background: rgba(15, 23, 42, 0.95) !important;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
  border-bottom: 1px solid rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(24px);
}

/* إصلاح مشكلة المؤشر عند الـ hover على الروابط والأزرار */
.absolute,
.group-hover\:opacity-100.transition-opacity.duration-300 {
  pointer-events: none;
}

/* Enhanced button and link transitions */
button,
a {
  @apply transition-all duration-300;
}

/* Mobile menu animation */
.mobile-menu-enter-active,
.mobile-menu-leave-active {
  transition: all 0.3s ease-in-out;
}

.mobile-menu-enter-from {
  opacity: 0;
  transform: translateY(-10px) scale(0.95);
}

.mobile-menu-leave-to {
  opacity: 0;
  transform: translateY(-10px) scale(0.95);
}

/* Enhanced nav link styling */
.nav-link::before {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 0;
  height: 2px;
  background: linear-gradient(to right, #60a5fa, #a78bfa);
  transition: all 0.3s ease;
  transform: translateX(-50%);
}

.nav-link:hover::before {
  width: 80%;
}

/* Animated gradient underline for active nav link */
.nav-link.router-link-active::before,
.nav-link.router-link-exact-active::before {
  width: 100%;
  height: 2px; /* تقليل السماكة من 4px إلى 2px */
  background: linear-gradient(90deg, #60a5fa, #a78bfa, #f472b6, #60a5fa);
  background-size: 200% 200%;
  animation: underline-gradient-move 2s linear infinite;
  box-shadow: 0 1px 6px #a78bfa33;
}

@keyframes underline-gradient-move {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Smooth transition for nav link color and underline */
.nav-link {
  transition: color 0.4s cubic-bezier(.4,0,.2,1), background 0.4s cubic-bezier(.4,0,.2,1);
}

/* Subtle animations */
@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-2px); }
}

.nav-link:hover {
  animation: float 2s ease-in-out infinite;
}

/* Enhanced gradients */
.bg-gradient-to-r {
  background-size: 200% 200%;
  animation: gradientShift 3s ease infinite;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

/* Focus states for accessibility */
button:focus,
a:focus {
  outline: none;
  outline-offset: 0;
}
</style>
