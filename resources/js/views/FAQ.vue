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
                <!-- Geometric Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div
                        v-for="i in 12"
                        :key="i"
                        :class="[
                            'absolute rounded-full',
                            isDark
                                ? 'bg-gradient-to-r from-teal-400/20 to-cyan-400/20'
                                : 'bg-gradient-to-r from-teal-500/30 to-cyan-500/30',
                        ]"
                        :style="{
                            width: `${40 + i * 15}px`,
                            height: `${40 + i * 15}px`,
                            top: `${Math.random() * 100}%`,
                            left: `${Math.random() * 100}%`,
                            animationDelay: `${i * 0.3}s`,
                        }"
                    ></div>
                </div>

                <!-- Flowing Lines -->
                <div
                    :class="
                        isDark
                            ? 'absolute top-20 left-0 w-full h-px bg-gradient-to-r from-transparent via-teal-500/30 to-transparent'
                            : 'absolute top-20 left-0 w-full h-px bg-gradient-to-r from-transparent via-teal-500/50 to-transparent'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute bottom-20 left-0 w-full h-px bg-gradient-to-r from-transparent via-purple-500/30 to-transparent'
                            : 'absolute bottom-20 left-0 w-full h-px bg-gradient-to-r from-transparent via-purple-500/50 to-transparent'
                    "
                ></div>

                <!-- Diagonal Elements -->
                <div
                    :class="
                        isDark
                            ? 'absolute top-1/4 left-0 w-32 h-1 bg-gradient-to-r from-teal-500/40 to-transparent transform rotate-45'
                            : 'absolute top-1/4 left-0 w-32 h-1 bg-gradient-to-r from-teal-500/60 to-transparent transform rotate-45'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute bottom-1/4 right-0 w-32 h-1 bg-gradient-to-l from-purple-500/40 to-transparent transform -rotate-45'
                            : 'absolute bottom-1/4 right-0 w-32 h-1 bg-gradient-to-l from-purple-500/60 to-transparent transform -rotate-45'
                    "
                ></div>
            </div>

            <div class="container mx-auto px-6 py-16 relative z-10">
                <!-- Unique Header -->
                <div class="text-center mb-20">
                    <div class="relative inline-block mb-8">
                        <div
                            :class="
                                isDark
                                    ? 'absolute inset-0 bg-gradient-to-r from-teal-500 to-purple-500 rounded-full blur-xl opacity-30'
                                    : 'absolute inset-0 bg-gradient-to-r from-teal-400 to-purple-400 rounded-full blur-xl opacity-40'
                            "
                        ></div>
                        <div
                            :class="
                                isDark
                                    ? 'relative px-8 py-4 bg-gradient-to-r from-teal-500/20 to-purple-500/20 border border-teal-400/30 rounded-full backdrop-blur-sm'
                                    : 'relative px-8 py-4 bg-gradient-to-r from-teal-200/60 to-purple-200/60 border border-teal-300/50 rounded-full backdrop-blur-sm'
                            "
                        >
                            <span
                                :class="
                                    isDark
                                        ? 'text-lg font-bold text-teal-300'
                                        : 'text-lg font-bold text-teal-700'
                                "
                            >
                                ❓ Got Questions?
                            </span>
                        </div>
                    </div>

                    <h1 class="text-6xl md:text-8xl font-black mb-8 relative">
                        <span
                            :class="
                                isDark
                                    ? 'bg-gradient-to-r from-white via-teal-200 to-purple-200 bg-clip-text text-transparent'
                                    : 'bg-gradient-to-r from-slate-900 via-teal-700 to-purple-700 bg-clip-text text-transparent'
                            "
                        >
                            FAQ
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
                        Find answers to common questions about
                        <span
                            :class="
                                isDark
                                    ? 'text-teal-400 font-bold'
                                    : 'text-teal-600 font-bold'
                            "
                        >
                            CTU, our programs, and services
                        </span>
                    </p>
                </div>

                <!-- Unique FAQ Layout -->
                <div class="max-w-6xl mx-auto">
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
                            Loading answers...
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

                    <!-- Unique FAQ Grid -->
                    <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div
                            v-for="(faq, index) in faqs"
                            :key="faq.id"
                            class="relative group"
                        >
                            <!-- FAQ Card -->
                            <div
                                :class="
                                    isDark
                                        ? 'relative p-8 bg-gradient-to-br from-white/5 via-teal-500/5 to-purple-500/5 rounded-3xl border border-white/10 backdrop-blur-sm hover:border-teal-500/30 transition-all duration-500'
                                        : 'relative p-8 bg-gradient-to-br from-white/90 via-teal-50/50 to-purple-50/50 rounded-3xl border border-teal-200/40 backdrop-blur-sm hover:border-teal-500/60 transition-all duration-500'
                                "
                            >
                                <!-- Question Number -->
                                <div
                                    :class="
                                        isDark
                                            ? 'absolute -top-4 -left-4 w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg'
                                            : 'absolute -top-4 -left-4 w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg'
                                    "
                                >
                                    <span class="text-white font-bold text-lg">
                                        {{ index + 1 }}
                                    </span>
                                </div>

                                <!-- Question Icon -->
                                <div class="flex items-start gap-4 mb-6">
                                    <div
                                        :class="
                                            isDark
                                                ? 'w-16 h-16 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-2xl flex items-center justify-center'
                                                : 'w-16 h-16 bg-gradient-to-br from-purple-400/30 to-pink-400/30 rounded-2xl flex items-center justify-center'
                                        "
                                    >
                                        <font-awesome-icon
                                            icon="question-circle"
                                            :class="
                                                isDark
                                                    ? 'text-2xl text-purple-400'
                                                    : 'text-2xl text-purple-600'
                                            "
                                        />
                                    </div>
                                    <div class="flex-1">
                                        <h3
                                            :class="
                                                isDark
                                                    ? 'text-xl font-bold text-white mb-2'
                                                    : 'text-xl font-bold text-slate-900 mb-2'
                                            "
                                        >
                                            {{ faq.question }}
                                        </h3>
                                    </div>
                                </div>

                                <!-- Answer -->
                                <div class="relative">
                                    <div
                                        :class="
                                            isDark
                                                ? 'absolute left-4 top-0 w-px h-full bg-gradient-to-b from-teal-500/50 to-purple-500/50'
                                                : 'absolute left-4 top-0 w-px h-full bg-gradient-to-b from-teal-500/70 to-purple-500/70'
                                        "
                                    ></div>
                                    <div class="pl-8">
                                        <div
                                            :class="
                                                isDark
                                                    ? 'w-4 h-4 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full absolute left-2 top-2'
                                                    : 'w-4 h-4 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full absolute left-2 top-2'
                                            "
                                        ></div>
                                        <p
                                            :class="
                                                isDark
                                                    ? 'text-slate-300 leading-relaxed text-lg'
                                                    : 'text-slate-600 leading-relaxed text-lg'
                                            "
                                        >
                                            {{ faq.answer }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Decorative Elements -->
                                <div
                                    :class="
                                        isDark
                                            ? 'absolute top-4 right-4 w-8 h-8 bg-gradient-to-br from-teal-400/20 to-cyan-400/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                            : 'absolute top-4 right-4 w-8 h-8 bg-gradient-to-br from-teal-400/30 to-cyan-400/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                    "
                                ></div>
                                <div
                                    :class="
                                        isDark
                                            ? 'absolute bottom-4 left-4 w-6 h-6 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200'
                                            : 'absolute bottom-4 left-4 w-6 h-6 bg-gradient-to-br from-purple-400/30 to-pink-400/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-200'
                                    "
                                ></div>
                            </div>

                            <!-- Floating Badge -->
                            <div
                                :class="
                                    isDark
                                        ? 'absolute -top-2 -right-2 px-3 py-1 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                        : 'absolute -top-2 -right-2 px-3 py-1 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs font-bold rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                "
                            >
                                Q&A
                            </div>
                        </div>
                    </div>

                    <!-- Contact Section -->
                    <div class="text-center mt-20">
                        <div
                            :class="
                                isDark
                                    ? 'inline-block p-8 bg-gradient-to-r from-teal-500/10 via-cyan-500/10 to-purple-500/10 border border-teal-400/30 rounded-3xl backdrop-blur-sm'
                                    : 'inline-block p-8 bg-gradient-to-r from-teal-100/60 via-cyan-100/60 to-purple-100/60 border border-teal-300/50 rounded-3xl backdrop-blur-sm'
                            "
                        >
                            <h3
                                :class="
                                    isDark
                                        ? 'text-2xl font-bold text-white mb-4'
                                        : 'text-2xl font-bold text-slate-900 mb-4'
                                "
                            >
                                Still Have Questions?
                            </h3>
                            <p
                                :class="
                                    isDark
                                        ? 'text-slate-300 mb-6'
                                        : 'text-slate-600 mb-6'
                                "
                            >
                                Can't find what you're looking for? Get in touch
                                with us!
                            </p>
                            <router-link
                                to="/contact"
                                :class="
                                    isDark
                                        ? 'inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 rounded-2xl font-bold text-white transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-2xl'
                                        : 'inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 rounded-2xl font-bold text-white transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-2xl'
                                "
                            >
                                <span class="flex items-center gap-3">
                                    <span>Contact Us</span>
                                    <font-awesome-icon
                                        icon="arrow-right"
                                        class="transition-transform duration-300 group-hover:translate-x-2"
                                    />
                                </span>
                            </router-link>
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
    faQuestionCircle,
    faArrowRight,
} from "@fortawesome/free-solid-svg-icons";
import { useTheme } from "../composables/useTheme";

library.add(faQuestionCircle, faArrowRight);

const { isDark } = useTheme();

const faqs = ref([]);
const loading = ref(true);
const error = ref("");

onMounted(async () => {
    try {
        const res = await axios.get("/api/faqs");
        faqs.value = res.data;
    } catch (e) {
        error.value = "Failed to load FAQs.";
    } finally {
        loading.value = false;
    }
});
</script>

<style scoped>
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

.group:hover {
    transform: translateY(-5px);
}
</style>
