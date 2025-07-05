<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
    >
        <!-- Enhanced Animated Background -->
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
                        ? 'absolute bottom-0 right-0 w-full h-40 bg-gradient-to-t from-purple-500/20 to-transparent transform skew-y-6'
                        : 'absolute bottom-0 right-0 w-full h-40 bg-gradient-to-t from-purple-400/30 to-transparent transform skew-y-6'
                "
            ></div>
            
            <!-- Floating Elements -->
            <div
                :class="[
                    'absolute top-1/4 left-1/4 w-2 h-2 rounded-full animate-float',
                    isDark ? 'bg-teal-400' : 'bg-teal-600',
                ]"
            ></div>
            <div
                :class="[
                    'absolute top-1/3 right-1/4 w-1.5 h-1.5 rounded-full animate-float-delayed',
                    isDark ? 'bg-purple-400' : 'bg-purple-600',
                ]"
            ></div>
            <div
                :class="[
                    'absolute bottom-1/3 left-1/3 w-2.5 h-2.5 rounded-full animate-float-slow',
                    isDark ? 'bg-cyan-400' : 'bg-cyan-600',
                ]"
            ></div>
        </div>

        <!-- Header Section -->
        <div class="pt-20 pb-16 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-6xl md:text-8xl font-black mb-8 relative">
                    <span
                        :class="
                            isDark
                                ? 'bg-gradient-to-r from-white via-teal-200 to-purple-200 bg-clip-text text-transparent'
                                : 'bg-gradient-to-r from-slate-900 via-teal-700 to-purple-700 bg-clip-text text-transparent'
                        "
                    >
                        Privacy
                    </span>
                    <br />
                    <span
                        :class="
                            isDark
                                ? 'bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-400 bg-clip-text text-transparent'
                                : 'bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500 bg-clip-text text-transparent'
                        "
                    >
                        Policy
                    </span>
                </h2>

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
                    Protecting your privacy and ensuring the security of your personal information is our top priority
                </p>
            </div>
        </div>

        <!-- Enhanced Content Layout -->
        <div class="max-w-5xl mx-auto px-6 pb-20 relative z-10">
            <div
                :class="
                    isDark
                        ? 'glass-card-premium rounded-3xl p-16 shadow-2xl border border-white/10'
                        : 'bg-white/95 backdrop-blur-sm rounded-3xl p-16 shadow-2xl border border-teal-200/40'
                "
            >
                <div class="text-center mb-16">
                    <div
                        :class="
                            isDark
                                ? 'w-24 h-24 bg-gradient-to-br from-teal-500/20 to-purple-500/20 border-4 border-teal-400/30 rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-300'
                                : 'w-24 h-24 bg-gradient-to-br from-teal-100/80 to-purple-100/80 border-4 border-teal-300/50 rounded-3xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 transition-transform duration-300'
                        "
                    >
                        <svg
                            class="w-12 h-12 text-teal-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                            />
                        </svg>
                    </div>
                    <h3
                        :class="
                            isDark
                                ? 'text-4xl font-bold text-white mb-6'
                                : 'text-4xl font-bold text-slate-900 mb-6'
                        "
                    >
                        Our Commitment to Privacy
                    </h3>
                    <p
                        :class="
                            isDark
                                ? 'text-xl text-slate-300 leading-relaxed max-w-3xl mx-auto'
                                : 'text-xl text-slate-600 leading-relaxed max-w-3xl mx-auto'
                        "
                    >
                        We are committed to protecting your privacy and ensuring the security of your personal information. 
                        This policy outlines how we collect, use, and safeguard your data.
                    </p>
                </div>

                <!-- Enhanced Content Sections -->
                <div class="grid md:grid-cols-2 gap-12 mb-16">
                    <div
                        :class="
                            isDark
                                ? 'p-8 bg-gradient-to-br from-teal-500/10 to-cyan-500/10 rounded-2xl border border-teal-400/20'
                                : 'p-8 bg-gradient-to-br from-teal-50/80 to-cyan-50/80 rounded-2xl border border-teal-200/40'
                        "
                    >
                        <div class="flex items-center mb-4">
                            <div
                                :class="
                                    isDark
                                        ? 'w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center mr-4'
                                        : 'w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center mr-4'
                                "
                            >
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h4
                                :class="
                                    isDark
                                        ? 'text-xl font-bold text-teal-300'
                                        : 'text-xl font-bold text-teal-700'
                                "
                            >
                                Data Collection
                            </h4>
                        </div>
                        <p
                            :class="
                                isDark
                                    ? 'text-slate-300 leading-relaxed'
                                    : 'text-slate-600 leading-relaxed'
                            "
                        >
                            We collect only the information necessary to provide our services and improve your experience.
                        </p>
                    </div>

                    <div
                        :class="
                            isDark
                                ? 'p-8 bg-gradient-to-br from-purple-500/10 to-pink-500/10 rounded-2xl border border-purple-400/20'
                                : 'p-8 bg-gradient-to-br from-purple-50/80 to-pink-50/80 rounded-2xl border border-purple-200/40'
                        "
                    >
                        <div class="flex items-center mb-4">
                            <div
                                :class="
                                    isDark
                                        ? 'w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4'
                                        : 'w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4'
                                "
                            >
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h4
                                :class="
                                    isDark
                                        ? 'text-xl font-bold text-purple-300'
                                        : 'text-xl font-bold text-purple-700'
                                "
                            >
                                Data Protection
                            </h4>
                        </div>
                        <p
                            :class="
                                isDark
                                    ? 'text-slate-300 leading-relaxed'
                                    : 'text-slate-600 leading-relaxed'
                            "
                        >
                            Your data is protected using industry-standard security measures and encryption protocols.
                        </p>
                    </div>
                </div>

                <!-- Contact Section -->
                <div
                    :class="
                        isDark
                            ? 'text-center pt-12 border-t border-slate-700/50'
                            : 'text-center pt-12 border-t border-slate-300/30'
                    "
                >
                    <h4
                        :class="
                            isDark
                                ? 'text-2xl font-bold text-white mb-6'
                                : 'text-2xl font-bold text-slate-900 mb-6'
                        "
                    >
                        Questions About Privacy?
                    </h4>
                    <p
                        :class="
                            isDark
                                ? 'text-slate-300 mb-8 max-w-2xl mx-auto'
                                : 'text-slate-600 mb-8 max-w-2xl mx-auto'
                        "
                    >
                        If you have any questions about our privacy practices or this policy, 
                        please don't hesitate to reach out to our privacy team.
                    </p>
                    <div
                        :class="
                            isDark
                                ? 'inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-500/20 to-purple-500/20 border border-teal-400/30 rounded-2xl backdrop-blur-sm'
                                : 'inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-100/80 to-purple-100/80 border border-teal-300/50 rounded-2xl backdrop-blur-sm'
                        "
                    >
                        <span
                            :class="
                                isDark
                                    ? 'text-lg font-semibold text-teal-300'
                                    : 'text-lg font-semibold text-teal-700'
                            "
                        >
                            Contact Privacy Team
                        </span>
                    </div>
                </div>
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

@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    33% {
        transform: translateY(-10px) rotate(1deg);
    }
    66% {
        transform: translateY(5px) rotate(-1deg);
    }
}

@keyframes float-delayed {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    33% {
        transform: translateY(-15px) rotate(-1deg);
    }
    66% {
        transform: translateY(8px) rotate(1deg);
    }
}

@keyframes float-slow {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(2deg);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
    animation-delay: 2s;
}

.animate-float-slow {
    animation: float-slow 10s ease-in-out infinite;
    animation-delay: 1s;
}

@media (max-width: 768px) {
    .text-6xl {
        font-size: 3rem;
    }
    .text-8xl {
        font-size: 4rem;
    }
}
</style>
