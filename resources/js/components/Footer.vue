<template>
    <footer
        :class="[
            'border-t pt-12 pb-6 transition-colors duration-500 relative overflow-hidden',
            isDark
                ? 'border-white/10 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'border-teal-200/30 bg-white text-slate-700 shadow-xl',
        ]"
    >
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 pointer-events-none z-0">
            <div
                :class="
                    isDark
                        ? 'absolute top-10 left-10 w-32 h-32 bg-teal-600/10 rounded-full blur-3xl animate-pulse'
                        : 'absolute top-10 left-10 w-32 h-32 bg-teal-200/30 rounded-full blur-3xl animate-pulse'
                "
            ></div>
            <div
                :class="
                    isDark
                        ? 'absolute bottom-10 right-10 w-40 h-40 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000'
                        : 'absolute bottom-10 right-10 w-40 h-40 bg-purple-200/30 rounded-full blur-3xl animate-pulse delay-1000'
                "
            ></div>
            <div
                :class="
                    isDark
                        ? 'absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 bg-cyan-600/10 rounded-full blur-2xl animate-ping'
                        : 'absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 bg-cyan-200/30 rounded-full blur-2xl animate-ping'
                "
            ></div>
        </div>
        <div
            class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 relative z-10"
        >
            <!-- Branding & Tagline -->
            <div class="flex flex-col items-center md:items-start gap-4">
                <img
                    src="@/assets/icons/logo.png"
                    alt="CTU Logo"
                    class="h-16 w-16 object-contain mb-2 drop-shadow-lg"
                />
                <span
                    class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-500 tracking-wide"
                    >CTU</span
                >
                <p
                    class="text-sm mt-2 max-w-xs text-center md:text-left"
                    :class="isDark ? 'text-slate-400' : 'text-slate-500'"
                >
                    Empowering learners worldwide. Inspiring innovation and
                    excellence in education.
                </p>
                <div class="flex gap-4 mt-2">
                    <a
                        href="https://www.linkedin.com/company/ctu"
                        target="_blank"
                        rel="noopener"
                        :title="'LinkedIn'"
                        class="group relative p-2 rounded-lg transition-all duration-300 hover:scale-110"
                        :class="
                            isDark
                                ? 'bg-white/5 hover:bg-white/10'
                                : 'bg-slate-100/60 hover:bg-slate-200/80'
                        "
                    >
                        <font-awesome-icon
                            :icon="['fab', 'linkedin-in']"
                            class="text-2xl transition-colors duration-200"
                            :class="
                                isDark
                                    ? 'text-teal-400 group-hover:text-teal-300'
                                    : 'text-teal-700 group-hover:text-teal-600'
                            "
                        />
                    </a>
                    <a
                        href="https://github.com/ctu"
                        target="_blank"
                        rel="noopener"
                        :title="'GitHub'"
                        class="group relative p-2 rounded-lg transition-all duration-300 hover:scale-110"
                        :class="
                            isDark
                                ? 'bg-white/5 hover:bg-white/10'
                                : 'bg-slate-100/60 hover:bg-slate-200/80'
                        "
                    >
                        <font-awesome-icon
                            :icon="['fab', 'github']"
                            class="text-2xl transition-colors duration-200"
                            :class="
                                isDark
                                    ? 'text-slate-300 group-hover:text-white'
                                    : 'text-slate-700 group-hover:text-black'
                            "
                        />
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex flex-col items-center md:items-start gap-2">
                <span
                    class="font-semibold mb-2 text-base tracking-wide bg-gradient-to-r from-teal-400 to-cyan-400 bg-clip-text text-transparent"
                    >Quick Links</span
                >
                <router-link
                    v-for="link in navLinks"
                    :key="link.path"
                    :to="link.path"
                    class="text-sm font-medium hover:underline transition-all duration-200 rounded px-2 py-1 group"
                    :class="
                        isDark
                            ? 'text-slate-300 hover:text-teal-400 hover:bg-white/5'
                            : 'text-slate-600 hover:text-teal-600 hover:bg-slate-100/60'
                    "
                >
                    <span class="relative z-10">{{ link.name }}</span>
                </router-link>
            </div>

            <!-- More Pages -->
            <div class="flex flex-col items-center md:items-start gap-2">
                <span
                    class="font-semibold mb-2 text-base tracking-wide bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent"
                    >More Pages</span
                >
                <router-link
                    v-for="page in morePages"
                    :key="page.path"
                    :to="page.path"
                    class="text-sm font-medium hover:underline transition-all duration-200 rounded px-2 py-1 group"
                    :class="
                        isDark
                            ? 'text-slate-300 hover:text-purple-400 hover:bg-white/5'
                            : 'text-slate-600 hover:text-purple-600 hover:bg-slate-100/60'
                    "
                >
                    <span class="relative z-10">{{ page.name }}</span>
                </router-link>
                <router-link
                    to="/team"
                    class="text-sm font-medium hover:underline transition-all duration-200 rounded px-2 py-1 group"
                    :class="
                        isDark
                            ? 'text-slate-300 hover:text-purple-400 hover:bg-white/5'
                            : 'text-slate-600 hover:text-purple-600 hover:bg-slate-100/60'
                    "
                >
                    <span class="relative z-10">Our Team</span>
                </router-link>
            </div>

            <!-- Search & Map -->
            <div class="flex flex-col items-center md:items-end gap-4 w-full">
                <span
                    class="font-semibold mb-2 text-base tracking-wide bg-gradient-to-r from-purple-400 to-teal-400 bg-clip-text text-transparent"
                    >Search</span
                >
                <form
                    @submit.prevent="handleSearch"
                    class="w-full flex items-center gap-2"
                >
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search..."
                        class="w-full rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-teal-400 transition-all duration-200 shadow border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 text-slate-700 dark:text-slate-200"
                    />
                    <button
                        type="submit"
                        class="px-3 py-2 rounded-lg bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500 text-white font-semibold shadow hover:from-teal-400 hover:via-cyan-400 hover:to-purple-400 transition-all duration-200 hover:scale-105"
                    >
                        <font-awesome-icon :icon="['fas', 'search']" />
                    </button>
                </form>
                <span
                    class="font-semibold mt-6 mb-2 text-base tracking-wide bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-400 bg-clip-text text-transparent"
                    >Our Location</span
                >
                <GoogleMapEmbed
                    :lat="30.8582961"
                    :lng="29.5713993"
                    :zoom="16"
                    title="Borg El-Arab Technological University, Alexandria, Egypt"
                />
            </div>
        </div>
        <!-- Enhanced Copyright Section -->
        <div
            class="mt-12 border-t pt-6 text-center text-xs relative z-10"
            :class="
                isDark
                    ? 'border-white/10 text-slate-500'
                    : 'border-teal-200/30 text-slate-400'
            "
        >
            <div
                class="flex flex-col md:flex-row items-center justify-center gap-2"
            >
                <span>© 2025 CTU. All rights reserved.</span>
                <span class="hidden md:inline">•</span>
                <span
                    >Made with
                    <span :class="isDark ? 'text-red-500' : 'text-red-600'"
                        >❤️</span
                    >
                    by CTU Team.</span
                >
            </div>
            <div
                class="mt-2 flex items-center justify-center gap-4 text-xs opacity-75"
            >
                <span
                    class="bg-gradient-to-r from-teal-400 to-cyan-400 bg-clip-text text-transparent font-medium"
                    >Innovation</span
                >
                <span
                    class="bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent font-medium"
                    >Excellence</span
                >
                <span
                    class="bg-gradient-to-r from-purple-400 to-teal-400 bg-clip-text text-transparent font-medium"
                    >Future</span
                >
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from "vue";
import { useTheme } from "../composables/useTheme";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faLinkedinIn, faGithub } from "@fortawesome/free-brands-svg-icons";
import { faSearch } from "@fortawesome/free-solid-svg-icons";
import GoogleMapEmbed from "./ui/GoogleMapEmbed.vue";

const { isDark } = useTheme();
library.add(faLinkedinIn, faGithub, faSearch);

const navLinks = [
    { name: "Home", path: "/" },
    { name: "Courses", path: "/courses" },
    { name: "Categories", path: "/categories" },
    { name: "Instructors", path: "/instructors" },
];

const morePages = [
    { name: "About", path: "/about" },
    { name: "Contact", path: "/contact" },
    { name: "Blog", path: "/blog" },
    { name: "FAQ", path: "/faq" },
    { name: "Privacy Policy", path: "/privacy" },
    { name: "Terms of Service", path: "/terms" },
];

const searchQuery = ref("");
const handleSearch = () => {
    if (searchQuery.value.trim()) {
        // You can replace this with your own search logic or route
        window.location.href = `/search?q=${encodeURIComponent(
            searchQuery.value
        )}`;
    }
};
</script>

<style scoped>
footer {
    font-family: "Inter", sans-serif;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.07), 0 1.5px 0 rgba(80, 80, 80, 0.03);
}
input:focus {
    outline: none;
    box-shadow: 0 0 0 2px #14b8a6;
}

/* Search input custom colors */
input[type="text"] {
    background: #fff;
    border: 2px solid #14b8a6;
    color: #222;
    font-size: 1.08rem;
    border-radius: 1rem;
    padding: 0.75rem 1.25rem;
    box-shadow: 0 2px 12px 0 rgba(20, 184, 166, 0.07);
    transition: border 0.2s, box-shadow 0.2s;
    font-weight: 500;
}
:deep(.dark) input[type="text"] {
    background: rgba(20, 184, 166, 0.1);
    border: 2px solid #5eead4;
    color: #e0f2fe;
}
input[type="text"]:focus {
    border: 2.5px solid #14b8a6;
    box-shadow: 0 0 0 3px #5eead4;
}
:deep(.dark) input[type="text"]:focus {
    border: 2.5px solid #5eead4;
    box-shadow: 0 0 0 3px #14b8a6;
}
input[type="text"]::placeholder {
    color: #0e7490;
    opacity: 1;
    font-weight: 400;
}
:deep(.dark) input[type="text"]::placeholder {
    color: #5eead4;
    opacity: 1;
}

/* Search button color harmony */
button[type="submit"] {
    background: linear-gradient(to right, #14b8a6, #06b6d4, #a855f7);
    color: #fff;
    border-radius: 0.75rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(13, 148, 136, 0.1);
    transition: background 0.2s, box-shadow 0.2s;
}
button[type="submit"]:hover {
    background: linear-gradient(to right, #0d9488, #0891b2, #a855f7);
    box-shadow: 0 4px 16px rgba(13, 148, 136, 0.13);
}

/* Enhanced hover effects */
a:hover {
    transform: translateY(-1px);
}

/* Gradient text animation */
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

/* Floating animation for social icons */
a:hover {
    animation: float 2s ease-in-out infinite;
}

@keyframes float {
    0%,
    100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-2px);
    }
}

/* Enhanced focus states for accessibility */
button:focus,
a:focus {
    outline: 2px solid #14b8a6;
    outline-offset: 2px;
}

/* Smooth transitions */
* {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
