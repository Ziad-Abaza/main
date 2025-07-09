<template>
  <div
    id="app"
    :class="[
      'min-h-screen transition-colors duration-500',
      isDark
        ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white'
        : 'bg-gradient-to-br from-slate-100 via-blue-100 to-purple-100 text-slate-900',
    ]"
  >
    <NavBar v-if="!is404" />
    <div v-if="!is404" class="h-20"></div>
    <router-view></router-view>
    <Footer v-if="!is404" />
    <UiToast ref="globalToast" />
  </div>
</template>

<script setup>
import NavBar from "./components/NavBar.vue";
import Footer from "./components/Footer.vue";
import { ref, computed, onMounted } from "vue";
import { useAuthStore } from "./stores/auth";
import { useRouter, useRoute } from "vue-router";
import { useTheme } from "./composables/useTheme";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faMoon, faSun } from "@fortawesome/free-solid-svg-icons";
import UiToast from "./components/ui/Toast.vue";

library.add(faMoon, faSun);

const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();
const mobileOpen = ref(false);
const { isDark, toggleTheme } = useTheme();

const is404 = computed(() => route.name === "not-found");

const handleLogout = async () => {
  mobileOpen.value = false;
  await authStore.logout();
  router.push({ name: "login" });
};

// Global toast helper
const globalToast = ref(null);
onMounted(() => {
  window.$toast = {
    show: (msg, variant = "info") => globalToast.value?.show(msg, variant),
    success: (msg) => globalToast.value?.show(msg, "success"),
    error: (msg) => globalToast.value?.show(msg, "danger"),
    info: (msg) => globalToast.value?.show(msg, "info"),
  };
});

// If the app is loaded and there's a token, try to fetch user to update roles, etc.
// This is especially useful if the user refreshes the page.
if (authStore.token && !authStore.user) {
  authStore.fetchUser().catch((err) => {
    console.error("Failed to fetch user on app load, logging out if token invalid.");
    // If fetchUser fails (e.g. token expired), logout might be appropriate
    // authStore.logout();
    // router.push({ name: 'login' });
  });
}
</script>

<style>
/* Add any additional global styles here if needed */
</style>
