<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-white text-slate-800'
        "
        class="relative px-4 py-10 md:px-10 md:py-16"
    >
        <!-- Floating particles background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute w-2 h-2 bg-purple-400 rounded-full animate-pulse opacity-40"
                style="top: 20%; left: 10%; animation-delay: 0s"
            ></div>
            <div
                class="absolute w-1 h-1 bg-pink-400 rounded-full animate-pulse opacity-30"
                style="top: 60%; left: 85%; animation-delay: 1s"
            ></div>
            <div
                class="absolute w-1.5 h-1.5 bg-cyan-400 rounded-full animate-pulse opacity-40"
                style="top: 40%; left: 20%; animation-delay: 2s"
            ></div>
        </div>

        <!-- Header Section -->
        <div class="mb-12 relative z-10">
            <h2
                class="text-3xl md:text-4xl font-black mb-4 bg-gradient-to-r from-purple-400 via-pink-400 to-cyan-500 bg-clip-text text-transparent drop-shadow-2xl tracking-tight"
            >
                Assignments
            </h2>
            <div
                class="w-20 h-1 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full"
            ></div>
        </div>

        <!-- Assignments Section -->
        <div class="mb-16">
            <!-- Loading State -->
            <div
                v-if="store.loading"
                class="flex items-center justify-center py-12"
            >
                <div class="flex items-center space-x-3">
                    <div
                        class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-500"
                    ></div>
                    <span
                        :class="isDark ? 'text-gray-400' : 'text-gray-500'"
                        class="text-lg font-medium"
                    >
                        Loading assignments...
                    </span>
                </div>
            </div>

            <!-- Error State -->
            <div
                v-if="store.error"
                class="flex items-center justify-center py-12"
            >
                <div
                    :class="
                        isDark
                            ? 'bg-red-900/20 border-red-700/50'
                            : 'bg-red-50 border-red-200'
                    "
                    class="border rounded-2xl p-6 max-w-md w-full"
                >
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-red-100 rounded-full">
                            <svg
                                class="w-6 h-6 text-red-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-red-600">
                                Error
                            </h3>
                            <p class="text-red-500 text-sm">
                                {{ store.error }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignments Grid -->
            <div v-if="!store.loading && !store.error">
                <!-- Empty State -->
                <div
                    v-if="store.assignments.length === 0"
                    class="flex flex-col items-center justify-center py-16"
                >
                    <div
                        :class="isDark ? 'bg-slate-800/50' : 'bg-slate-100'"
                        class="w-24 h-24 rounded-full flex items-center justify-center mb-6"
                    >
                        <svg
                            class="w-12 h-12 text-slate-400"
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
                    <h3 class="text-xl font-bold mb-2 text-slate-500">
                        No assignments yet
                    </h3>
                    <p class="text-slate-400 text-center max-w-md">
                        You don't have any assignments at the moment. Check back
                        later!
                    </p>
                </div>

                <!-- Assignments List -->
                <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div
                        v-for="as in store.assignments"
                        :key="as.id"
                        :class="[
                            'group relative overflow-hidden rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:scale-105 hover:-translate-y-2',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-purple-100 hover:shadow-2xl',
                            // Overdue styling
                            isOverdue(as.due_date) ? 'opacity-75' : '',
                            // Due soon styling
                            isWithinDays(as.due_date, 3) &&
                            !isWithinDays(as.due_date, 1)
                                ? isDark
                                    ? 'border-2 border-yellow-500/50'
                                    : 'border-2 border-yellow-300/50'
                                : '',
                            // Due very soon styling
                            isWithinDays(as.due_date, 1) &&
                            !isOverdue(as.due_date)
                                ? isDark
                                    ? 'border-2 border-red-500/50'
                                    : 'border-2 border-red-300/50'
                                : '',
                        ]"
                    >
                        <!-- Background gradient overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-purple-500/10 via-pink-500/10 to-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>

                        <!-- Content -->
                        <div class="relative z-10">
                            <!-- Assignment Icon -->
                            <div class="mb-6">
                                <div
                                    :class="[
                                        'w-16 h-16 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300 border border-white/10',
                                        isDark
                                            ? 'bg-gradient-to-br from-purple-900 to-pink-900'
                                            : 'bg-gradient-to-br from-purple-50 to-pink-50',
                                    ]"
                                >
                                    <svg
                                        :class="[
                                            'w-8 h-8',
                                            isOverdue(as.due_date)
                                                ? 'text-gray-500'
                                                : isWithinDays(
                                                      as.due_date,
                                                      3
                                                  ) &&
                                                  !isWithinDays(as.due_date, 1)
                                                ? 'text-yellow-500'
                                                : isWithinDays(
                                                      as.due_date,
                                                      1
                                                  ) && !isOverdue(as.due_date)
                                                ? 'text-red-500'
                                                : 'text-purple-500',
                                        ]"
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
                            </div>

                            <!-- Assignment Info -->
                            <div class="mb-8">
                                <h3
                                    :class="[
                                        'text-2xl font-bold mb-3 group-hover:text-purple-500 transition-colors duration-300 tracking-tight',
                                        isOverdue(as.due_date)
                                            ? 'line-through text-gray-500'
                                            : isWithinDays(as.due_date, 3) &&
                                              !isWithinDays(as.due_date, 1)
                                            ? isDark
                                                ? 'text-yellow-400'
                                                : 'text-yellow-600'
                                            : isWithinDays(as.due_date, 1) &&
                                              !isOverdue(as.due_date)
                                            ? isDark
                                                ? 'text-red-400'
                                                : 'text-red-600'
                                            : isDark
                                            ? 'text-white'
                                            : 'text-slate-800',
                                    ]"
                                >
                                    {{ as.title }}
                                </h3>

                                <div
                                    v-if="as.due_date"
                                    class="flex items-center space-x-2"
                                >
                                    <div
                                        :class="[
                                            'px-4 py-2 rounded-full text-sm font-medium flex items-center space-x-2',
                                            isOverdue(as.due_date)
                                                ? isDark
                                                    ? 'bg-gray-800/50 text-gray-400'
                                                    : 'bg-gray-100 text-gray-500'
                                                : isWithinDays(
                                                      as.due_date,
                                                      3
                                                  ) &&
                                                  !isWithinDays(as.due_date, 1)
                                                ? isDark
                                                    ? 'bg-yellow-900/30 text-yellow-400'
                                                    : 'bg-yellow-100 text-yellow-700'
                                                : isWithinDays(
                                                      as.due_date,
                                                      1
                                                  ) && !isOverdue(as.due_date)
                                                ? isDark
                                                    ? 'bg-red-900/30 text-red-400'
                                                    : 'bg-red-100 text-red-700'
                                                : isDark
                                                ? 'bg-slate-700 text-slate-300'
                                                : 'bg-slate-100 text-slate-600',
                                        ]"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                        <span>Due: {{ as.due_date }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center space-x-4">
                                <a
                                    v-if="as.attachment_url"
                                    :href="as.attachment_url"
                                    target="_blank"
                                    :class="[
                                        'px-6 py-3 rounded-2xl font-bold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center space-x-2',
                                        isDark
                                            ? 'bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white'
                                            : 'bg-gradient-to-r from-blue-100 to-cyan-100 hover:from-blue-200 hover:to-cyan-200 text-blue-700',
                                    ]"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                    <span>Download</span>
                                </a>

                                <router-link
                                    :to="`/assignments/${as.id}`"
                                    class="flex-1"
                                >
                                    <button
                                        :class="[
                                            'w-full px-6 py-3 rounded-2xl font-bold text-white text-sm transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center space-x-2',
                                            isDark
                                                ? 'bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500'
                                                : 'bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500',
                                        ]"
                                    >
                                        <span>Open Assignment</span>
                                        <svg
                                            class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-300"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                                            />
                                        </svg>
                                    </button>
                                </router-link>
                            </div>
                        </div>

                        <!-- Decorative elements -->
                        <div
                            class="absolute top-6 right-6 w-3 h-3 bg-purple-400 rounded-full opacity-30 group-hover:opacity-60 transition-opacity duration-300"
                        ></div>
                        <div
                            class="absolute bottom-6 left-6 w-2 h-2 bg-pink-400 rounded-full opacity-40 group-hover:opacity-80 transition-opacity duration-300"
                        ></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submissions Section -->
        <div class="border-t border-white/10 pt-16">
            <!-- Header -->
            <div class="mb-12">
                <h2
                    class="text-3xl md:text-4xl font-black mb-4 bg-gradient-to-r from-teal-400 via-cyan-400 to-blue-500 bg-clip-text text-transparent drop-shadow-2xl tracking-tight"
                >
                    My Submissions
                </h2>
                <div
                    class="w-20 h-1 bg-gradient-to-r from-teal-400 to-blue-500 rounded-full"
                ></div>
            </div>

            <!-- Loading State -->
            <div
                v-if="store.loadingSubs"
                class="flex items-center justify-center py-12"
            >
                <div class="flex items-center space-x-3">
                    <div
                        class="animate-spin rounded-full h-8 w-8 border-b-2 border-teal-500"
                    ></div>
                    <span
                        :class="isDark ? 'text-gray-400' : 'text-gray-500'"
                        class="text-lg font-medium"
                    >
                        Loading submissions...
                    </span>
                </div>
            </div>

            <!-- Error State -->
            <div
                v-if="store.errorSubs"
                class="flex items-center justify-center py-12"
            >
                <div
                    :class="
                        isDark
                            ? 'bg-red-900/20 border-red-700/50'
                            : 'bg-red-50 border-red-200'
                    "
                    class="border rounded-2xl p-6 max-w-md w-full"
                >
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-red-100 rounded-full">
                            <svg
                                class="w-6 h-6 text-red-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-red-600">
                                Error
                            </h3>
                            <p class="text-red-500 text-sm">
                                {{ store.errorSubs }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submissions Grid -->
            <div v-if="!store.loadingSubs && !store.errorSubs">
                <!-- Empty State -->
                <div
                    v-if="store.submissions.length === 0"
                    class="flex flex-col items-center justify-center py-16"
                >
                    <div
                        :class="isDark ? 'bg-slate-800/50' : 'bg-slate-100'"
                        class="w-24 h-24 rounded-full flex items-center justify-center mb-6"
                    >
                        <svg
                            class="w-12 h-12 text-slate-400"
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
                    <h3 class="text-xl font-bold mb-2 text-slate-500">
                        No submissions yet
                    </h3>
                    <p class="text-slate-400 text-center max-w-md">
                        You haven't submitted anything yet. Complete your
                        assignments to see them here!
                    </p>
                </div>

                <!-- Submissions List -->
                <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div
                        v-for="sub in store.submissions"
                        :key="sub.id"
                        :class="[
                            'group relative overflow-hidden rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:scale-105 hover:-translate-y-2',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-teal-100 hover:shadow-2xl',
                        ]"
                    >
                        <!-- Background gradient overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-teal-500/10 via-cyan-500/10 to-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>

                        <!-- Content -->
                        <div class="relative z-10">
                            <!-- Submission Icon -->
                            <div class="mb-6">
                                <div
                                    :class="[
                                        'w-16 h-16 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300 border border-white/10',
                                        isDark
                                            ? 'bg-gradient-to-br from-teal-900 to-cyan-900'
                                            : 'bg-gradient-to-br from-teal-50 to-cyan-50',
                                    ]"
                                >
                                    <svg
                                        class="w-8 h-8 text-teal-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <!-- Submission Info -->
                            <div class="mb-8">
                                <h3
                                    class="text-2xl font-bold mb-3 group-hover:text-teal-500 transition-colors duration-300 tracking-tight"
                                >
                                    {{ sub.assignment_title }}
                                </h3>

                                <div class="flex items-center space-x-2">
                                    <div
                                        :class="[
                                            'px-4 py-2 rounded-full text-sm font-medium flex items-center space-x-2',
                                            isDark
                                                ? 'bg-green-900/30 text-green-400'
                                                : 'bg-green-100 text-green-700',
                                        ]"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                        <span
                                            >Submitted:
                                            {{ sub.created_at }}</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div v-if="sub.file_url">
                                <a
                                    :href="sub.file_url"
                                    target="_blank"
                                    :class="[
                                        'inline-flex items-center space-x-2 px-6 py-3 rounded-2xl font-bold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg',
                                        isDark
                                            ? 'bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white'
                                            : 'bg-gradient-to-r from-teal-100 to-cyan-100 hover:from-teal-200 hover:to-cyan-200 text-teal-700',
                                    ]"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        />
                                    </svg>
                                    <span>Download Submission</span>
                                </a>
                            </div>
                        </div>

                        <!-- Decorative elements -->
                        <div
                            class="absolute top-6 right-6 w-3 h-3 bg-teal-400 rounded-full opacity-30 group-hover:opacity-60 transition-opacity duration-300"
                        ></div>
                        <div
                            class="absolute bottom-6 left-6 w-2 h-2 bg-cyan-400 rounded-full opacity-40 group-hover:opacity-80 transition-opacity duration-300"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useLmsStore } from "@/stores/lms";
import { useTheme } from "../../composables/useTheme";

const store = useLmsStore();
const { isDark } = useTheme();

const isWithinDays = (dueDate, days) => {
    if (!dueDate) return false;
    const due = new Date(dueDate);
    const now = new Date();
    const diffTime = due - now;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    return diffDays <= days && diffDays > 0;
};

const isOverdue = (dueDate) => {
    if (!dueDate) return false;
    const due = new Date(dueDate);
    return due < new Date();
};

onMounted(() => {
    store.fetchSubmissions();
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

@keyframes pulse {
    0%,
    100% {
        opacity: 0.3;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-pulse {
    animation: pulse 3s ease-in-out infinite;
}
</style>
