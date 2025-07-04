<template>
    <nav
        :class="[
            'modern-navbar',
            { scrolled: isScrolled },
            isDark
                ? 'fixed top-0 left-0 w-full z-50 px-4 py-3 transition-all duration-500'
                : 'fixed top-0 left-0 w-full z-50 px-4 py-3 transition-all duration-500 bg-white/95 border-b border-teal-50 shadow',
            !isDark && isScrolled
                ? 'bg-white border-b border-teal-100 shadow-md'
                : '',
        ]"
    >
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                :class="
                    isDark
                        ? 'absolute top-0 left-10 w-32 h-32 bg-teal-600/10 rounded-full blur-3xl animate-pulse'
                        : 'absolute top-0 left-10 w-32 h-32 bg-teal-200/30 rounded-full blur-3xl animate-pulse'
                "
            ></div>
            <div
                :class="
                    isDark
                        ? 'absolute top-0 right-10 w-24 h-24 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000'
                        : 'absolute top-0 right-10 w-24 h-24 bg-purple-200/30 rounded-full blur-3xl animate-pulse delay-1000'
                "
            ></div>
        </div>

        <div
            class="container mx-auto flex items-center justify-between relative z-10"
        >
            <!-- Logo with enhanced animation -->
            <router-link to="/" class="flex items-center space-x-2 group">
                <div class="relative">
                    <img
                        :src="logo"
                        alt="CTU Logo"
                        class="h-16 w-16 object-contain transition-transform duration-300 group-hover:scale-110"
                    />
                    <div
                        :class="
                            isDark
                                ? 'absolute inset-0 bg-gradient-to-br from-teal-500/20 via-cyan-500/20 to-purple-500/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300'
                                : 'absolute inset-0 bg-gradient-to-br from-teal-200/40 via-cyan-200/40 to-purple-200/40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300'
                        "
                    ></div>
                </div>
                <span
                    class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-500"
                    >CTU</span
                >
            </router-link>

            <!-- Desktop Menu with enhanced styling -->
            <div class="hidden md:flex items-center space-x-1">
                <router-link
                    v-for="link in navLinks"
                    :key="link.path"
                    :to="link.path"
                    class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 group nav-link"
                    :class="{
                        'text-teal-400 bg-white/10 shadow-md':
                            $route.path === link.path,
                        'text-gray-300 hover:text-white hover:bg-white/5':
                            $route.path !== link.path,
                    }"
                >
                    <span class="relative z-10">{{ link.name }}</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-teal-500/20 via-cyan-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    ></div>
                </router-link>
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center space-x-3">
                <!-- Theme Toggle Button -->
                <button
                    @click="toggleTheme"
                    class="flex items-center justify-center w-10 h-10 rounded-lg transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-teal-400 bg-white/10 hover:bg-white/20 text-yellow-400 dark:text-teal-400"
                    :title="
                        isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'
                    "
                >
                    <font-awesome-icon
                        :icon="isDark ? 'sun' : 'moon'"
                        class="text-xl transition-colors duration-300"
                    />
                </button>

                <!-- Search Button with enhanced design -->
                <button
                    class="hidden md:flex items-center justify-center w-10 h-10 text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300 hover:scale-105 group"
                    @click="toggleSearch"
                >
                    <font-awesome-icon
                        :icon="['fas', 'search']"
                        class="text-sm"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-teal-500/20 via-cyan-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    ></div>
                </button>

                <!-- Auth Actions -->
                <router-link
                    to="/lms"
                    v-if="authStore.user"
                    class="flex items-center space-x-3"
                >
                    <div
                        class="hidden md:flex items-center space-x-2 px-3 py-2 bg-white/5 rounded-lg"
                    >
                        <div
                            class="w-2 h-2 bg-teal-400 rounded-full animate-pulse"
                        ></div>
                        <span class="text-sm text-gray-300">
                            {{ authStore.name || authStore.user.email }}
                        </span>
                    </div>
                    <button
                        @click="authStore.logout()"
                        class="relative overflow-hidden text-sm px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-400 hover:to-red-500 text-white rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 group"
                    >
                        <span class="relative z-10">Logout</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-red-400 to-red-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        ></div>
                    </button>
                </router-link>
                <router-link
                    v-else
                    to="/login"
                    class="relative overflow-hidden text-sm px-5 py-2 bg-gradient-to-r from-teal-600 via-cyan-600 to-purple-600 hover:from-teal-500 hover:via-cyan-500 hover:to-purple-500 text-white rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105 group"
                >
                    <span class="relative z-10">Login</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    ></div>
                </router-link>

                <!-- Mobile Menu Toggle -->
                <button
                    class="md:hidden relative w-10 h-10 flex items-center justify-center text-gray-300 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-300 group"
                    @click="toggleMobileMenu"
                >
                    <font-awesome-icon
                        :icon="['fas', isMobileMenuOpen ? 'times' : 'bars']"
                        class="text-sm"
                    />
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-teal-500/20 via-cyan-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    ></div>
                </button>
            </div>
        </div>

        <!-- Enhanced Mobile Menu -->
        <transition name="mobile-menu">
            <div
                v-if="isMobileMenuOpen"
                class="md:hidden glass-card-premium mt-4 mx-2 rounded-xl shadow-2xl border border-white/10"
            >
                <div class="flex flex-col space-y-2 p-4">
                    <router-link
                        v-for="link in navLinks"
                        :key="link.path"
                        :to="link.path"
                        class="relative px-4 py-3 text-gray-300 text-base font-medium rounded-lg transition-all duration-300 group"
                        :class="{
                            'text-teal-400 bg-white/10':
                                $route.path === link.path,
                        }"
                        @click="isMobileMenuOpen = false"
                    >
                        <span class="relative z-10">{{ link.name }}</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-teal-500/20 via-cyan-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        ></div>
                    </router-link>

                    <!-- Mobile Search -->
                    <button
                        @click="
                            toggleSearch();
                            isMobileMenuOpen = false;
                        "
                        class="relative px-4 py-3 text-gray-300 text-base font-medium rounded-lg transition-all duration-300 group text-left"
                    >
                        <span class="relative z-10 flex items-center">
                            <font-awesome-icon
                                :icon="['fas', 'search']"
                                class="mr-3"
                            />
                            Search
                        </span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-teal-500/20 via-cyan-500/20 to-purple-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        ></div>
                    </button>
                </div>
            </div>
        </transition>
    </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faStream,
    faSearch,
    faBars,
    faTimes,
    faMoon,
    faSun,
} from "@fortawesome/free-solid-svg-icons";
import { useAuthStore } from "../stores/auth";
import { useRoute } from "vue-router";
import { useTheme } from "../composables/useTheme";
import logo from "../assets/icons/logo.png";

library.add(faStream, faSearch, faBars, faTimes, faMoon, faSun);

const authStore = useAuthStore();
const route = useRoute();
const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);
const { isDark, toggleTheme } = useTheme();

const navLinks = [
    { name: "Home", path: "/" },
    { name: "Courses", path: "/courses" },
    { name: "Categories", path: "/categories" },
    { name: "Instructors", path: "/instructors" },
];

const handleScroll = () => {
    isScrolled.value = window.scrollY > 30;
};

const toggleMobileMenu = () => {
    isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

const toggleSearch = () => {
    console.log("Search toggled");
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>

<style scoped>
.glass-card-premium {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

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
    --navbar-bg: #ffffff;
    background: #ffffff !important;
    color: #1e293b;
    border-bottom: 1px solid #e2e8f0;
    box-shadow: 0 4px 24px 0 rgba(14, 165, 233, 0.08), 0 1px 3px 0 rgba(14, 165, 233, 0.05);
    backdrop-filter: blur(10px) !important;
    -webkit-backdrop-filter: blur(10px) !important;
}

:deep(.modern-navbar):not(.dark).scrolled {
    --navbar-bg: rgba(255, 255, 255, 0.95);
    background: rgba(255, 255, 255, 0.95) !important;
    border-bottom: 1px solid #cbd5e1;
    box-shadow: 0 8px 32px 0 rgba(14, 165, 233, 0.12), 0 4px 16px 0 rgba(14, 165, 233, 0.08);
    backdrop-filter: blur(20px) !important;
    -webkit-backdrop-filter: blur(20px) !important;
}

:deep(.modern-navbar):not(.dark) .nav-link {
    color: #475569;
    background: transparent;
    border-radius: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.01em;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

:deep(.modern-navbar):not(.dark) .nav-link.router-link-active,
:deep(.modern-navbar):not(.dark) .nav-link.router-link-exact-active {
    color: #0ea5e9;
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
    border: 1px solid rgba(14, 165, 233, 0.2);
}

:deep(.modern-navbar):not(.dark) .nav-link:hover {
    color: #0ea5e9;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(14, 165, 233, 0.12);
    border: 1px solid rgba(14, 165, 233, 0.15);
}

:deep(.modern-navbar):not(.dark) .bg-gradient-to-r {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%) !important;
    color: transparent;
    background-clip: text;
    -webkit-background-clip: text;
    background-size: 200% 200%;
    animation: gradient-text 3s ease infinite;
}

@keyframes gradient-text {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

:deep(.modern-navbar):not(.dark) .text-teal-400 {
    color: #0ea5e9 !important;
}

:deep(.modern-navbar):not(.dark) .bg-white\/10 {
    background: rgba(14, 165, 233, 0.08) !important;
    border: 1px solid rgba(14, 165, 233, 0.1);
}

:deep(.modern-navbar):not(.dark) .bg-white\/5 {
    background: rgba(240, 249, 255, 0.8) !important;
    border: 1px solid rgba(14, 165, 233, 0.1);
}

:deep(.modern-navbar):not(.dark) .hover\:bg-white\/5:hover {
    background: rgba(224, 242, 254, 0.9) !important;
}

:deep(.modern-navbar):not(.dark) .hover\:bg-white\/10:hover {
    background: rgba(14, 165, 233, 0.12) !important;
}

:deep(.modern-navbar):not(.dark) .rounded-lg {
    border-radius: 1rem;
}

:deep(.modern-navbar):not(.dark) .shadow-lg {
    box-shadow: 0 4px 16px rgba(22, 179, 177, 0.1);
}

:deep(.modern-navbar):not(.dark) .shadow-xl {
    box-shadow: 0 8px 32px rgba(22, 179, 177, 0.13);
}

:deep(.modern-navbar):not(.dark) button {
    color: #64748b;
    background: rgba(248, 250, 252, 0.8);
    border: 1px solid rgba(14, 165, 233, 0.1);
    border-radius: 0.75rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(10px);
}

:deep(.modern-navbar):not(.dark) button:hover {
    color: #ffffff;
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    box-shadow: 0 4px 16px rgba(14, 165, 233, 0.25);
    transform: translateY(-1px);
    border: 1px solid rgba(14, 165, 233, 0.3);
}

:deep(.modern-navbar):not(.dark) .text-yellow-400 {
    color: #f59e0b !important;
}

:deep(.modern-navbar):not(.dark) .dark\:text-teal-400 {
    color: #0ea5e9 !important;
}

:deep(.modern-navbar):not(.dark) .text-gray-300 {
    color: #64748b !important;
}

:deep(.modern-navbar):not(.dark) .hover\:text-white:hover {
    color: #ffffff !important;
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
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: linear-gradient(to right, #0d9488, #0891b2, #a855f7);
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
    height: 2px;
    background: linear-gradient(90deg, #0d9488, #0891b2, #a855f7, #0d9488);
    background-size: 200% 200%;
    animation: underline-gradient-move 2s linear infinite;
    box-shadow: 0 1px 6px #0d948833;
}

@keyframes underline-gradient-move {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

/* Smooth transition for nav link color and underline */
.nav-link {
    transition: color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
        background 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Subtle animations */
@keyframes float {
    0%,
    100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-2px);
    }
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
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

/* Focus states for accessibility */
button:focus,
a:focus {
    outline: none;
    outline-offset: 0;
}

/* Enhanced glass morphism for mobile menu */
.glass-card-premium {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

:deep(.modern-navbar):not(.dark) .glass-card-premium {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(14, 165, 233, 0.15);
    box-shadow: 0 8px 32px rgba(14, 165, 233, 0.12),
        inset 0 1px 0 rgba(255, 255, 255, 0.9);
}

:deep(.modern-navbar):not(.dark) .focus\:ring-teal-400:focus {
    --tw-ring-color: #0ea5e9;
}

:deep(.modern-navbar):not(.dark) .focus\:ring-2:focus {
    --tw-ring-offset-shadow: 0 0 0 2px rgba(14, 165, 233, 0.2);
}

/* Enhanced user profile section styling */
:deep(.modern-navbar):not(.dark) .bg-white\/5 {
    background: rgba(240, 249, 255, 0.8) !important;
    border: 1px solid rgba(14, 165, 233, 0.1);
    border-radius: 0.75rem;
}

:deep(.modern-navbar):not(.dark) .w-2.h-2.bg-teal-400 {
    background: #0ea5e9 !important;
}

/* Enhanced login button styling */
:deep(.modern-navbar):not(.dark) .bg-gradient-to-r.from-teal-600 {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%) !important;
    box-shadow: 0 4px 16px rgba(14, 165, 233, 0.25);
    border: 1px solid rgba(14, 165, 233, 0.2);
}

:deep(.modern-navbar):not(.dark) .bg-gradient-to-r.from-teal-600:hover {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 50%, #1e40af 100%) !important;
    box-shadow: 0 6px 24px rgba(14, 165, 233, 0.35);
    transform: translateY(-1px);
}
</style>
