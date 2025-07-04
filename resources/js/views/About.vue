<template>
    <div
        :class="
            isDark
                ? 'relative min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white overflow-hidden'
                : 'relative min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800 overflow-hidden'
        "
    >
        <!-- هندسيات ثابتة -->
        <div class="fixed-shapes pointer-events-none select-none">
            <!-- Hexagon -->
            <div
                :class="[
                    'shape-hexagon',
                    isDark ? 'shape-dark-hexagon' : 'shape-light-hexagon',
                ]"
            ></div>
            <!-- Triangle -->
            <div
                :class="[
                    'shape-triangle',
                    isDark ? 'shape-dark-triangle' : 'shape-light-triangle',
                ]"
            ></div>
            <!-- Star -->
            <div
                :class="[
                    'shape-star',
                    isDark ? 'shape-dark-star' : 'shape-light-star',
                ]"
            ></div>
            <!-- Circle -->
            <div
                :class="[
                    'shape-circle',
                    isDark ? 'shape-dark-circle' : 'shape-light-circle',
                ]"
            ></div>
        </div>

        <div
            class="relative z-10 container mx-auto px-4 py-24 flex flex-col items-center"
        >
            <!-- Header Section -->
            <div class="max-w-4xl w-full text-center mb-16 animate-slide-up">
                <div class="mb-8">
                    <h1
                        class="text-5xl md:text-7xl font-black mb-6 bg-gradient-to-r from-teal-500 via-purple-600 to-cyan-500 bg-clip-text text-transparent leading-tight animate-gradient"
                    >
                        About CTU
                    </h1>
                    <div
                        class="w-24 h-1 bg-gradient-to-r from-teal-500 to-purple-600 mx-auto mb-8 rounded-full"
                    ></div>
                </div>
                <p
                    :class="
                        isDark
                            ? 'text-xl md:text-2xl text-slate-300 mb-10 leading-relaxed font-light'
                            : 'text-xl md:text-2xl text-slate-600 mb-10 leading-relaxed font-light'
                    "
                >
                    Borg El-Arab Technological University is dedicated to
                    empowering learners and inspiring innovation in
                    <span class="font-semibold text-teal-600 dark:text-teal-400"
                        >Alexandria, Egypt</span
                    >
                    and beyond.
                </p>
                <div class="flex justify-center gap-4 flex-wrap">
                    <span
                        class="inline-block px-6 py-3 rounded-full bg-gradient-to-r from-teal-500 to-cyan-600 text-white text-sm font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 cursor-pointer"
                    >
                        Innovation
                    </span>
                    <span
                        class="inline-block px-6 py-3 rounded-full bg-gradient-to-r from-purple-500 to-purple-600 text-white text-sm font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 cursor-pointer"
                    >
                        Excellence
                    </span>
                    <span
                        class="inline-block px-6 py-3 rounded-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-sm font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 cursor-pointer"
                    >
                        Community
                    </span>
                </div>
            </div>

            <!-- Mission & Vision Cards -->
            <div class="max-w-5xl w-full grid md:grid-cols-2 gap-8 mb-16">
                <div
                    class="glass-card-premium rounded-3xl shadow-2xl p-10 hover:shadow-3xl hover:scale-105 hover:-translate-y-2 transition-all duration-300 group"
                >
                    <div class="flex items-center mb-6">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300"
                        >
                            <svg
                                class="w-6 h-6 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                        </div>
                        <h2
                            class="text-3xl font-bold text-teal-600 dark:text-teal-300"
                        >
                            Our Mission
                        </h2>
                    </div>
                    <p
                        :class="
                            isDark
                                ? 'text-slate-300 text-lg leading-relaxed'
                                : 'text-slate-700 text-lg leading-relaxed'
                        "
                    >
                        To provide world-class education, foster research and
                        innovation, and prepare students to become leaders in
                        technology and society.
                    </p>
                </div>
                <div
                    class="glass-card-premium rounded-3xl shadow-2xl p-10 hover:shadow-3xl hover:scale-105 hover:-translate-y-2 transition-all duration-300 group"
                >
                    <div class="flex items-center mb-6">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300"
                        >
                            <svg
                                class="w-6 h-6 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                ></path>
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                ></path>
                            </svg>
                        </div>
                        <h2
                            class="text-3xl font-bold text-purple-600 dark:text-purple-300"
                        >
                            Our Vision & Values
                        </h2>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center group/item">
                            <div
                                class="w-2 h-2 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full mr-3 group-hover/item:scale-150 transition-transform duration-300"
                            ></div>
                            <p
                                :class="
                                    isDark
                                        ? 'text-slate-300 group-hover/item:text-purple-300 transition-colors duration-300'
                                        : 'text-slate-700 group-hover/item:text-purple-600 transition-colors duration-300'
                                "
                            >
                                Empowering students to reach their full
                                potential
                            </p>
                        </div>
                        <div class="flex items-center group/item">
                            <div
                                class="w-2 h-2 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full mr-3 group-hover/item:scale-150 transition-transform duration-300"
                            ></div>
                            <p
                                :class="
                                    isDark
                                        ? 'text-slate-300 group-hover/item:text-purple-300 transition-colors duration-300'
                                        : 'text-slate-700 group-hover/item:text-purple-600 transition-colors duration-300'
                                "
                            >
                                Promoting diversity, inclusion, and
                                collaboration
                            </p>
                        </div>
                        <div class="flex items-center group/item">
                            <div
                                class="w-2 h-2 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full mr-3 group-hover/item:scale-150 transition-transform duration-300"
                            ></div>
                            <p
                                :class="
                                    isDark
                                        ? 'text-slate-300 group-hover/item:text-purple-300 transition-colors duration-300'
                                        : 'text-slate-700 group-hover/item:text-purple-600 transition-colors duration-300'
                                "
                            >
                                Commitment to academic excellence and integrity
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Section -->
            <div
                class="max-w-5xl w-full glass-card-premium rounded-3xl shadow-2xl p-10 hover:shadow-3xl hover:scale-105 hover:-translate-y-2 transition-all duration-300 mb-16"
            >
                <div class="flex items-center mb-8">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4"
                    >
                        <svg
                            class="w-6 h-6 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            ></path>
                        </svg>
                    </div>
                    <h2
                        class="text-3xl font-bold text-emerald-600 dark:text-emerald-300"
                    >
                        Our Team
                    </h2>
                </div>
                <p
                    :class="
                        isDark
                            ? 'text-slate-300 mb-8 text-lg leading-relaxed'
                            : 'text-slate-700 mb-8 text-lg leading-relaxed'
                    "
                >
                    Meet the passionate educators, researchers, and leaders who
                    make CTU a center of excellence.
                    <span
                        class="text-emerald-600 dark:text-emerald-400 font-semibold"
                        >(Team bios and photos coming soon.)</span
                    >
                </p>
                <div class="flex flex-wrap gap-6 justify-center">
                    <div class="group">
                        <div
                            class="w-40 h-40 rounded-full bg-gradient-to-br from-teal-400 to-purple-500 flex items-center justify-center text-4xl font-black text-white shadow-2xl hover:shadow-3xl transition-all duration-300 hover:scale-110 animate-pulse-glow cursor-pointer"
                        >
                            CT
                        </div>
                        <p
                            class="text-center mt-4 text-slate-600 dark:text-slate-400 font-semibold"
                        >
                            Cairo Tech
                        </p>
                    </div>
                    <div class="group">
                        <div
                            class="w-40 h-40 rounded-full bg-gradient-to-br from-emerald-400 to-cyan-500 flex items-center justify-center text-4xl font-black text-white shadow-2xl hover:shadow-3xl transition-all duration-300 hover:scale-110 animate-pulse-glow-delayed cursor-pointer"
                        >
                            U
                        </div>
                        <p
                            class="text-center mt-4 text-slate-600 dark:text-slate-400 font-semibold"
                        >
                            University
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bottom Decorative Element -->
            <div class="mt-16 w-full max-w-4xl text-center">
                <div
                    class="w-32 h-1 bg-gradient-to-r from-teal-500 via-purple-500 to-emerald-500 mx-auto rounded-full"
                ></div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useTheme } from "../composables/useTheme";
const { isDark } = useTheme();
</script>

<style scoped>
.glass-card-premium {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

.fixed-shapes {
    position: absolute;
    inset: 0;
    z-index: 1;
}
.shape-hexagon {
    position: absolute;
    top: 40px;
    left: 32px;
    width: 80px;
    height: 80px;
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    transition: opacity 0.3s, background 0.3s;
}
.shape-light-hexagon {
    background: linear-gradient(135deg, #06b6d4 0%, #22d3ee 60%, #a78bfa 100%);
    opacity: 0.32;
}
.shape-dark-hexagon {
    background: linear-gradient(135deg, #0e7490 0%, #6366f1 100%);
    opacity: 0.13;
}
.shape-triangle {
    position: absolute;
    bottom: 60px;
    right: 48px;
    width: 60px;
    height: 60px;
    clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
    transition: opacity 0.3s, background 0.3s;
}
.shape-light-triangle {
    background: linear-gradient(135deg, #818cf8 0%, #06b6d4 60%, #fbbf24 100%);
    opacity: 0.28;
}
.shape-dark-triangle {
    background: linear-gradient(135deg, #334155 0%, #06b6d4 60%, #fbbf24 100%);
    opacity: 0.11;
}
.shape-star {
    position: absolute;
    top: 120px;
    right: 80px;
    width: 48px;
    height: 48px;
    clip-path: polygon(
        50% 0%,
        61% 35%,
        98% 35%,
        68% 57%,
        79% 91%,
        50% 70%,
        21% 91%,
        32% 57%,
        2% 35%,
        39% 35%
    );
    transition: opacity 0.3s, background 0.3s;
}
.shape-light-star {
    background: linear-gradient(135deg, #fbbf24 0%, #06b6d4 60%, #a5b4fc 100%);
    opacity: 0.23;
}
.shape-dark-star {
    background: linear-gradient(135deg, #6366f1 0%, #fbbf24 100%);
    opacity: 0.1;
}
.shape-circle {
    position: absolute;
    bottom: 32px;
    left: 80px;
    width: 54px;
    height: 54px;
    border-radius: 50%;
    transition: opacity 0.3s, background 0.3s;
}
.shape-light-circle {
    background: linear-gradient(135deg, #22d3ee 0%, #818cf8 100%);
    opacity: 0.22;
}
.shape-dark-circle {
    background: linear-gradient(135deg, #334155 0%, #818cf8 100%);
    opacity: 0.09;
}
@media (max-width: 768px) {
    .shape-hexagon,
    .shape-triangle,
    .shape-star,
    .shape-circle {
        width: 36px;
        height: 36px;
        left: 12px !important;
        right: 12px !important;
        top: 12px !important;
        bottom: 12px !important;
    }
}

@keyframes float {
    0%,
    100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes gradient {
    0%,
    100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

@keyframes pulse-glow {
    0% {
        box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
    }
    100% {
        box-shadow: 0 0 40px rgba(59, 130, 246, 0.6);
    }
}

@keyframes slide-up {
    0% {
        transform: translateY(50px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float 6s ease-in-out infinite;
    animation-delay: -3s;
}

.animate-float-slow {
    animation: float 8s ease-in-out infinite;
    animation-delay: -1.5s;
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

.animate-pulse-glow {
    animation: pulse-glow 2s ease-in-out infinite alternate;
}

.animate-pulse-glow-delayed {
    animation: pulse-glow 2s ease-in-out infinite alternate;
    animation-delay: 0.5s;
}

.animate-slide-up {
    animation: slide-up 0.8s ease-out;
}

.dark .glass-card-premium {
    background: rgba(15, 23, 42, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
</style>
