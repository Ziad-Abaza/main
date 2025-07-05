<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
    >
        <!-- Simple Background -->
        <div class="absolute inset-0">
            <div
                :class="
                    isDark
                        ? 'absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-purple-500/10 to-transparent'
                        : 'absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-purple-400/20 to-transparent'
                "
            ></div>
            <div
                :class="
                    isDark
                        ? 'absolute bottom-0 right-0 w-full h-24 bg-gradient-to-t from-cyan-500/10 to-transparent'
                        : 'absolute bottom-0 right-0 w-full h-24 bg-gradient-to-t from-cyan-400/20 to-transparent'
                "
            ></div>
        </div>

        <!-- Header Section -->
        <div class="pt-20 pb-16 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-5xl md:text-6xl font-bold mb-8">
                    <span
                        :class="
                            isDark
                                ? 'bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent'
                                : 'bg-gradient-to-r from-slate-900 to-purple-700 bg-clip-text text-transparent'
                        "
                    >
                        Terms of Service
                    </span>
                </h2>

                <div
                    :class="
                        isDark
                            ? 'w-24 h-1 bg-gradient-to-r from-purple-500 to-cyan-500 mx-auto mb-8 rounded-full'
                            : 'w-24 h-1 bg-gradient-to-r from-purple-500 to-cyan-500 mx-auto mb-8 rounded-full'
                    "
                ></div>

                <p
                    :class="
                        isDark
                            ? 'text-lg text-slate-300 max-w-2xl mx-auto'
                            : 'text-lg text-slate-600 max-w-2xl mx-auto'
                    "
                >
                    Please read these terms carefully before using our services
                </p>
            </div>
        </div>

        <!-- Simple Content Layout -->
        <div class="max-w-4xl mx-auto px-6 pb-20 relative z-10">
            <div
                :class="
                    isDark
                        ? 'bg-white/10 backdrop-blur-sm rounded-2xl p-12 shadow-xl border border-white/20 hover:shadow-2xl transition-all duration-300'
                        : 'bg-white/90 backdrop-blur-sm rounded-2xl p-12 shadow-xl border border-purple-200/40 hover:shadow-2xl transition-all duration-300'
                "
            >
                <div class="text-center mb-12">
                    <div
                        :class="
                            isDark
                                ? 'w-16 h-16 bg-gradient-to-br from-purple-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg hover:scale-110 transition-transform duration-300'
                                : 'w-16 h-16 bg-gradient-to-br from-purple-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg hover:scale-110 transition-transform duration-300'
                        "
                    >
                        <svg
                            class="w-8 h-8 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>
                    </div>
                    <h3
                        :class="
                            isDark
                                ? 'text-2xl font-bold text-white mb-4'
                                : 'text-2xl font-bold text-slate-900 mb-4'
                        "
                    >
                        Service Terms
                    </h3>
                    <p
                        :class="
                            isDark
                                ? 'text-slate-300 leading-relaxed'
                                : 'text-slate-600 leading-relaxed'
                        "
                    >
                        These terms govern your use of our services and outline the rules and guidelines for using our platform.
                    </p>
                </div>

                <!-- Simple Content -->
                <div class="space-y-8">
                    <div 
                        :class="
                            isDark
                                ? 'p-6 bg-gradient-to-r from-purple-500/5 to-cyan-500/5 rounded-xl border border-purple-400/10'
                                : 'p-6 bg-gradient-to-r from-purple-50/50 to-cyan-50/50 rounded-xl border border-purple-200/30'
                        "
                    >
                        <div class="flex items-center mb-3">
                            <div
                                :class="
                                    isDark
                                        ? 'w-3 h-3 bg-purple-400 rounded-full mr-3'
                                        : 'w-3 h-3 bg-purple-500 rounded-full mr-3'
                                "
                            ></div>
                            <h4
                                :class="
                                    isDark
                                        ? 'text-lg font-semibold text-purple-300'
                                        : 'text-lg font-semibold text-purple-700'
                                "
                            >
                                Acceptance of Terms
                            </h4>
                        </div>
                        <p
                            :class="
                                isDark
                                    ? 'text-slate-300 leading-relaxed pl-6'
                                    : 'text-slate-600 leading-relaxed pl-6'
                            "
                        >
                            This terms of service document will be updated with specific details about usage rules, 
                            user responsibilities, and service guidelines.
                        </p>
                    </div>

                    <div 
                        :class="
                            isDark
                                ? 'p-6 bg-gradient-to-r from-cyan-500/5 to-teal-500/5 rounded-xl border border-cyan-400/10'
                                : 'p-6 bg-gradient-to-r from-cyan-50/50 to-teal-50/50 rounded-xl border border-cyan-200/30'
                        "
                    >
                        <div class="flex items-center mb-3">
                            <div
                                :class="
                                    isDark
                                        ? 'w-3 h-3 bg-cyan-400 rounded-full mr-3'
                                        : 'w-3 h-3 bg-cyan-500 rounded-full mr-3'
                                "
                            ></div>
                            <h4
                                :class="
                                    isDark
                                        ? 'text-lg font-semibold text-cyan-300'
                                        : 'text-lg font-semibold text-cyan-700'
                                "
                            >
                                User Guidelines
                            </h4>
                        </div>
                        <p
                            :class="
                                isDark
                                    ? 'text-slate-300 leading-relaxed pl-6'
                                    : 'text-slate-600 leading-relaxed pl-6'
                            "
                        >
                            For questions about these terms, please contact our support team.
                        </p>
                    </div>
                </div>

                <!-- Contact Section -->
                <div
                    :class="
                        isDark
                            ? 'text-center mt-12 pt-8 border-t border-slate-700/50'
                            : 'text-center mt-12 pt-8 border-t border-slate-300/30'
                    "
                >
                    <div
                        :class="
                            isDark
                                ? 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500/10 to-cyan-500/10 border border-purple-400/20 rounded-xl backdrop-blur-sm'
                                : 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-100/60 to-cyan-100/60 border border-purple-300/40 rounded-xl backdrop-blur-sm'
                        "
                    >
                        <svg
                            class="w-5 h-5 mr-3"
                            :class="isDark ? 'text-purple-300' : 'text-purple-600'"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                            />
                        </svg>
                        <h4
                            :class="
                                isDark
                                    ? 'text-lg font-semibold text-purple-300'
                                    : 'text-lg font-semibold text-purple-700'
                            "
                        >
                            Contact Support
                        </h4>
                    </div>
                    <p
                        :class="
                            isDark
                                ? 'text-slate-300 mt-4'
                                : 'text-slate-600 mt-4'
                        "
                    >
                        For questions about these terms of service, please reach out to our team.
                    </p>
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
@media (max-width: 768px) {
    .text-5xl {
        font-size: 2.5rem;
    }
    .text-6xl {
        font-size: 3rem;
    }
}
</style>
