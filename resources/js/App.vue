<template>
    <div
        id="app"
        :class="[
            'min-h-screen transition-colors duration-500',
            isDark
                ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white'
                : 'bg-gradient-to-br from-slate-100 via-blue-100 to-purple-100 text-slate-900'
        ]"
    >
        <!-- Global Theme Toggle Button -->
        <div class="fixed top-4 right-4 z-50">
            <button
                @click="toggleTheme"
                class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 dark:bg-slate-800/40 border border-white/30 dark:border-slate-700 shadow-lg hover:scale-110 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-400 backdrop-blur-sm"
                :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
            >
                <font-awesome-icon :icon="isDark ? 'sun' : 'moon'" class="text-xl transition-colors duration-300" />
                <span class="font-medium text-sm text-slate-700 dark:text-slate-200 hidden sm:inline">{{ isDark ? 'Light' : 'Dark' }}</span>
            </button>
        </div>

        <NavBar v-if="!is404" />
        <div v-if="!is404" class=" h-20"></div>
        <router-view></router-view>
        <Footer v-if="!is404" />
    </div>
</template>

<script setup>
import NavBar from "./components/NavBar.vue";
import Footer from "./components/Footer.vue";
import { ref, computed } from "vue";
import { useAuthStore } from "./stores/auth";
import { useRouter, useRoute } from "vue-router";
import { useTheme } from "./composables/useTheme";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faMoon, faSun } from '@fortawesome/free-solid-svg-icons';

library.add(faMoon, faSun);

const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();
const mobileOpen = ref(false);
const { isDark, toggleTheme } = useTheme();

const is404 = computed(() => route.name === 'not-found');

const handleLogout = async () => {
    mobileOpen.value = false;
    await authStore.logout();
    router.push({ name: "login" });
};

// If the app is loaded and there's a token, try to fetch user to update roles, etc.
// This is especially useful if the user refreshes the page.
if (authStore.token && !authStore.user) {
    authStore.fetchUser().catch((err) => {
        console.error(
            "Failed to fetch user on app load, logging out if token invalid."
        );
        // If fetchUser fails (e.g. token expired), logout might be appropriate
        // authStore.logout();
        // router.push({ name: 'login' });
    });
}
</script>

<style>
/* Add any additional global styles here if needed */
</style>
