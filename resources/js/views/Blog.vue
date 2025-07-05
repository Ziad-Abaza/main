<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
    >
        <section class="relative overflow-hidden">
            <!-- Unique Animated Background -->
            <div class="absolute inset-0">
                <!-- Flowing Waves -->
                <div
                    :class="
                        isDark
                            ? 'absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-teal-500/20 to-transparent transform -skew-y-6'
                            : 'absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-teal-400/30 to-transparent transform -skew-y-6'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute top-20 right-0 w-full h-24 bg-gradient-to-b from-purple-500/15 to-transparent transform skew-y-3'
                            : 'absolute top-20 right-0 w-full h-24 bg-gradient-to-b from-purple-400/25 to-transparent transform skew-y-3'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute bottom-0 left-0 w-full h-40 bg-gradient-to-t from-cyan-500/20 to-transparent transform skew-y-6'
                            : 'absolute bottom-0 left-0 w-full h-40 bg-gradient-to-t from-cyan-400/30 to-transparent transform skew-y-6'
                    "
                ></div>

                <!-- Floating Elements -->
                <div
                    v-for="i in 8"
                    :key="i"
                    :class="[
                        'absolute rounded-full animate-bounce',
                        isDark
                            ? `bg-gradient-to-r from-teal-400/20 to-cyan-400/20`
                            : `bg-gradient-to-r from-teal-500/30 to-cyan-500/30`,
                    ]"
                    :style="{
                        width: `${20 + i * 8}px`,
                        height: `${20 + i * 8}px`,
                        top: `${10 + i * 8}%`,
                        left: `${5 + i * 12}%`,
                        animationDelay: `${i * 0.5}s`,
                        animationDuration: `${3 + i * 0.3}s`,
                    }"
                ></div>
            </div>

            <div class="container mx-auto px-6 py-16 relative z-10">
                <!-- Unique Header -->
                <div class="text-center mb-20">
                    <h1 class="text-6xl md:text-8xl font-black mb-8 relative">
                        <span
                            :class="
                                isDark
                                    ? 'bg-gradient-to-r from-white via-teal-200 to-purple-200 bg-clip-text text-transparent'
                                    : 'bg-gradient-to-r from-slate-900 via-teal-700 to-purple-700 bg-clip-text text-transparent'
                            "
                        >
                            CTU
                        </span>
                        <br />
                        <span
                            :class="
                                isDark
                                    ? 'bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-400 bg-clip-text text-transparent'
                                    : 'bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500 bg-clip-text text-transparent'
                            "
                        >
                            BLOG
                        </span>
                    </h1>

                    <div
                        :class="
                            isDark
                                ? 'w-32 h-1 bg-gradient-to-r from-teal-500 to-purple-500 mx-auto mb-8 rounded-full'
                                : 'w-32 h-1 bg-gradient-to-r from-teal-500 to-purple-500 mx-auto mb-8 rounded-full'
                        "
                    ></div>

                    <p
                        :class="
                            isDark
                                ? 'text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed'
                                : 'text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed'
                        "
                    >
                        Discover the latest insights, stories, and updates from
                        <span
                            :class="
                                isDark
                                    ? 'text-teal-400 font-bold'
                                    : 'text-teal-600 font-bold'
                            "
                        >
                            Borg El-Arab Technological University
                        </span>
                    </p>
                </div>

                <!-- Unique Blog Layout -->
                <div class="max-w-7xl mx-auto">
                    <!-- Loading State -->
                    <div v-if="loading" class="text-center py-20">
                        <div class="relative">
                            <div
                                :class="
                                    isDark
                                        ? 'w-20 h-20 border-4 border-teal-500/30 border-t-teal-500 rounded-full animate-spin mx-auto'
                                        : 'w-20 h-20 border-4 border-teal-500/30 border-t-teal-500 rounded-full animate-spin mx-auto'
                                "
                            ></div>
                            <div
                                :class="
                                    isDark
                                        ? 'absolute inset-0 w-20 h-20 border-4 border-purple-500/20 border-t-purple-500 rounded-full animate-spin mx-auto'
                                        : 'absolute inset-0 w-20 h-20 border-4 border-purple-500/20 border-t-purple-500 rounded-full animate-spin mx-auto'
                                "
                                style="
                                    animation-direction: reverse;
                                    animation-duration: 1.5s;
                                "
                            ></div>
                        </div>
                        <p
                            :class="
                                isDark
                                    ? 'mt-6 text-lg text-slate-400'
                                    : 'mt-6 text-lg text-slate-600'
                            "
                        >
                            Loading amazing stories...
                        </p>
                    </div>

                    <!-- Error State -->
                    <div v-else-if="error" class="text-center py-20">
                        <div
                            :class="
                                isDark
                                    ? 'inline-flex items-center p-8 bg-gradient-to-r from-red-500/20 to-orange-500/20 border border-red-400/30 rounded-2xl backdrop-blur-sm'
                                    : 'inline-flex items-center p-8 bg-gradient-to-r from-red-100/80 to-orange-100/80 border border-red-300/50 rounded-2xl backdrop-blur-sm'
                            "
                        >
                            <div class="text-red-400 text-xl font-bold">
                                {{ error }}
                            </div>
                        </div>
                    </div>

                    <!-- Unique Blog Posts Layout -->
                    <div v-else class="space-y-16">
                        <div
                            v-for="(post, index) in posts"
                            :key="post.id"
                            class="relative"
                        >
                            <!-- Alternating Layout -->
                            <div
                                :class="[
                                    'flex flex-col lg:flex-row gap-8 items-center',
                                    index % 2 === 1
                                        ? 'lg:flex-row-reverse'
                                        : '',
                                ]"
                            >
                                <!-- Visual Element -->
                                <div class="lg:w-1/2 relative">
                                    <div
                                        :class="
                                            isDark
                                                ? 'relative p-8 bg-gradient-to-br from-teal-500/10 via-cyan-500/10 to-purple-500/10 rounded-3xl border border-white/10 backdrop-blur-sm'
                                                : 'relative p-8 bg-gradient-to-br from-teal-100/60 via-cyan-100/60 to-purple-100/60 rounded-3xl border border-teal-200/40 backdrop-blur-sm'
                                        "
                                    >
                                        <!-- Decorative Elements -->
                                        <div
                                            :class="
                                                isDark
                                                    ? 'absolute top-4 left-4 w-16 h-16 bg-gradient-to-br from-teal-500/20 to-cyan-500/20 rounded-2xl rotate-12'
                                                    : 'absolute top-4 left-4 w-16 h-16 bg-gradient-to-br from-teal-400/30 to-cyan-400/30 rounded-2xl rotate-12'
                                            "
                                        ></div>
                                        <div
                                            :class="
                                                isDark
                                                    ? 'absolute bottom-4 right-4 w-12 h-12 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-xl -rotate-12'
                                                    : 'absolute bottom-4 right-4 w-12 h-12 bg-gradient-to-br from-purple-400/30 to-pink-400/30 rounded-xl -rotate-12'
                                            "
                                        ></div>

                                        <!-- Icon Container -->
                                        <div
                                            class="relative z-10 text-center py-12"
                                        >
                                            <div
                                                :class="
                                                    isDark
                                                        ? 'inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-3xl shadow-2xl mb-6'
                                                        : 'inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-3xl shadow-2xl mb-6'
                                                "
                                            >
                                                <font-awesome-icon
                                                    icon="newspaper"
                                                    class="text-white text-3xl"
                                                />
                                            </div>
                                            <div
                                                :class="
                                                    isDark
                                                        ? 'text-2xl font-bold text-white'
                                                        : 'text-2xl font-bold text-slate-800'
                                                "
                                            >
                                                {{
                                                    post.title
                                                        .split(" ")
                                                        .slice(0, 3)
                                                        .join(" ")
                                                }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Floating Badge -->
                                    <div
                                        :class="
                                            isDark
                                                ? 'absolute -top-4 -right-4 px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm font-bold rounded-full shadow-lg'
                                                : 'absolute -top-4 -right-4 px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white text-sm font-bold rounded-full shadow-lg'
                                        "
                                    >
                                        NEW
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="lg:w-1/2 space-y-6">
                                    <div>
                                        <h2
                                            :class="
                                                isDark
                                                    ? 'text-3xl font-bold text-white mb-4'
                                                    : 'text-3xl font-bold text-slate-900 mb-4'
                                            "
                                        >
                                            {{ post.title }}
                                        </h2>
                                        <p
                                            :class="
                                                isDark
                                                    ? 'text-lg text-slate-300 leading-relaxed'
                                                    : 'text-lg text-slate-600 leading-relaxed'
                                            "
                                        >
                                            {{ post.excerpt }}
                                        </p>
                                    </div>

                                    <!-- Meta Information -->
                                    <div
                                        :class="
                                            isDark
                                                ? 'flex items-center gap-6 text-sm text-slate-400'
                                                : 'flex items-center gap-6 text-sm text-slate-500'
                                        "
                                    >
                                        <div class="flex items-center gap-2">
                                            <div
                                                :class="
                                                    isDark
                                                        ? 'w-8 h-8 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full flex items-center justify-center'
                                                        : 'w-8 h-8 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full flex items-center justify-center'
                                                "
                                            >
                                                <font-awesome-icon
                                                    icon="user"
                                                    class="text-white text-xs"
                                                />
                                            </div>
                                            <span>{{ post.author }}</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div
                                                :class="
                                                    isDark
                                                        ? 'w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center'
                                                        : 'w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center'
                                                "
                                            >
                                                <font-awesome-icon
                                                    icon="calendar"
                                                    class="text-white text-xs"
                                                />
                                            </div>
                                            <span>
                                                {{
                                                    post.published_at
                                                        ? new Date(
                                                              post.published_at
                                                          ).toLocaleDateString()
                                                        : ""
                                                }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="pt-4">
                                        <button
                                            :class="
                                                isDark
                                                    ? 'group relative px-8 py-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 rounded-2xl font-bold text-white transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-2xl'
                                                    : 'group relative px-8 py-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 rounded-2xl font-bold text-white transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-2xl'
                                            "
                                        >
                                            <span
                                                class="flex items-center gap-3"
                                            >
                                                <span>Read Full Story</span>
                                                <font-awesome-icon
                                                    icon="arrow-right"
                                                    class="transition-transform duration-300 group-hover:translate-x-2"
                                                />
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Separator -->
                            <div
                                v-if="index < posts.length - 1"
                                :class="
                                    isDark
                                        ? 'mt-16 w-full h-px bg-gradient-to-r from-transparent via-teal-500/30 to-transparent'
                                        : 'mt-16 w-full h-px bg-gradient-to-r from-transparent via-teal-500/50 to-transparent'
                                "
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faNewspaper,
    faUser,
    faCalendar,
    faArrowRight,
} from "@fortawesome/free-solid-svg-icons";
import { useTheme } from "../composables/useTheme";

library.add(faNewspaper, faUser, faCalendar, faArrowRight);

const { isDark } = useTheme();

const posts = ref([]);
const loading = ref(true);
const error = ref("");

onMounted(async () => {
    try {
        const res = await axios.get("/api/blogs");
        posts.value = res.data;
    } catch (e) {
        error.value = "Failed to load blog posts.";
    } finally {
        loading.value = false;
    }
});
</script>

<style scoped>
@keyframes bounce {
    0%,
    20%,
    50%,
    80%,
    100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-20px);
    }
    60% {
        transform: translateY(-10px);
    }
}

.animate-bounce {
    animation: bounce 3s infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

button:focus,
a:focus {
    outline: 2px solid #14b8a6;
    outline-offset: 2px;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.1);
}

button:focus-visible,
a:focus-visible {
    outline: 2px solid #14b8a6;
    outline-offset: 4px;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.2);
}

@media (max-width: 768px) {
    .text-6xl {
        font-size: 3rem;
    }
    .text-8xl {
        font-size: 4rem;
    }
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
}
</style>
