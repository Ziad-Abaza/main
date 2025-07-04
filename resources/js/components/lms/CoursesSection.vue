<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
        class="relative px-4 py-10 md:px-10 md:py-16"
    >
        <!-- Fixed Background Shapes -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Scattered Dots -->
            <div
                :class="isDark ? 'bg-blue-400/30' : 'bg-blue-400/20'"
                class="absolute w-3 h-3 rounded-full top-20 left-10"
            ></div>

            <div
                :class="isDark ? 'bg-purple-400/30' : 'bg-purple-400/20'"
                class="absolute w-2 h-2 rounded-full top-40 right-20"
            ></div>

            <div
                :class="isDark ? 'bg-cyan-400/30' : 'bg-cyan-400/20'"
                class="absolute w-4 h-4 rounded-full top-60 left-1/4"
            ></div>

            <div
                :class="isDark ? 'bg-teal-400/30' : 'bg-teal-400/20'"
                class="absolute w-1 h-1 rounded-full top-80 right-1/3"
            ></div>

            <div
                :class="isDark ? 'bg-pink-400/30' : 'bg-pink-400/20'"
                class="absolute w-3 h-3 rounded-full top-1/3 left-1/2"
            ></div>

            <div
                :class="isDark ? 'bg-yellow-400/30' : 'bg-yellow-400/20'"
                class="absolute w-2 h-2 rounded-full top-2/3 right-1/4"
            ></div>

            <div
                :class="isDark ? 'bg-green-400/30' : 'bg-green-400/20'"
                class="absolute w-1 h-1 rounded-full bottom-40 left-1/6"
            ></div>

            <div
                :class="isDark ? 'bg-orange-400/30' : 'bg-orange-400/20'"
                class="absolute w-3 h-3 rounded-full bottom-20 right-1/5"
            ></div>

            <div
                :class="isDark ? 'bg-red-400/30' : 'bg-red-400/20'"
                class="absolute w-2 h-2 rounded-full bottom-1/3 left-1/3"
            ></div>

            <div
                :class="isDark ? 'bg-indigo-400/30' : 'bg-indigo-400/20'"
                class="absolute w-1 h-1 rounded-full top-1/4 right-1/6"
            ></div>

            <div
                :class="isDark ? 'bg-emerald-400/30' : 'bg-emerald-400/20'"
                class="absolute w-4 h-4 rounded-full top-3/4 left-1/5"
            ></div>

            <div
                :class="isDark ? 'bg-violet-400/30' : 'bg-violet-400/20'"
                class="absolute w-2 h-2 rounded-full bottom-1/4 right-1/2"
            ></div>

            <div
                :class="isDark ? 'bg-amber-400/30' : 'bg-amber-400/20'"
                class="absolute w-1 h-1 rounded-full top-1/2 left-1/6"
            ></div>

            <div
                :class="isDark ? 'bg-rose-400/30' : 'bg-rose-400/20'"
                class="absolute w-3 h-3 rounded-full bottom-1/6 left-1/4"
            ></div>

            <div
                :class="isDark ? 'bg-sky-400/30' : 'bg-sky-400/20'"
                class="absolute w-2 h-2 rounded-full top-1/6 right-1/3"
            ></div>

            <div
                :class="isDark ? 'bg-lime-400/30' : 'bg-lime-400/20'"
                class="absolute w-1 h-1 rounded-full top-5/6 left-1/2"
            ></div>

            <div
                :class="isDark ? 'bg-fuchsia-400/30' : 'bg-fuchsia-400/20'"
                class="absolute w-3 h-3 rounded-full bottom-1/3 right-1/6"
            ></div>

            <div
                :class="isDark ? 'bg-slate-400/30' : 'bg-slate-400/20'"
                class="absolute w-2 h-2 rounded-full top-2/5 left-1/8"
            ></div>

            <div
                :class="isDark ? 'bg-gray-400/30' : 'bg-gray-400/20'"
                class="absolute w-1 h-1 rounded-full bottom-2/5 right-1/8"
            ></div>
        </div>

        <!-- Floating particles background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute w-1.5 h-1.5 bg-blue-400 rounded-full animate-pulse opacity-30"
                style="top: 15%; left: 5%; animation-delay: 0s"
            ></div>
            <div
                class="absolute w-1 h-1 bg-purple-400 rounded-full animate-pulse opacity-40"
                style="top: 70%; left: 90%; animation-delay: 1.5s"
            ></div>
            <div
                class="absolute w-2 h-2 bg-cyan-400 rounded-full animate-pulse opacity-30"
                style="top: 45%; left: 15%; animation-delay: 3s"
            ></div>
        </div>

        <!-- Header Section -->
        <div class="mb-8 relative z-10">
            <h2
                class="text-4xl font-black mb-3 bg-gradient-to-r from-blue-500 via-purple-500 to-cyan-500 bg-clip-text text-transparent"
            >
                My Courses
            </h2>
            <div
                class="w-20 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full"
            ></div>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="flex items-center justify-center py-12">
            <div class="flex items-center space-x-3">
                <div
                    class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"
                ></div>
                <span
                    :class="isDark ? 'text-gray-400' : 'text-gray-500'"
                    class="text-lg font-medium"
                >
                    Loading courses...
                </span>
            </div>
        </div>

        <!-- Error State -->
        <div v-if="error" class="flex items-center justify-center py-12">
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
                        <p class="text-red-500 text-sm">{{ error }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Courses Grid -->
        <div
            v-if="!loading && !error"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10"
        >
            <div
                v-for="c in courses"
                :key="c.course_id"
                :class="[
                    'group relative overflow-hidden rounded-3xl p-8 md:p-10 shadow-2xl transition-all duration-500 hover:scale-105 hover:-translate-y-2',
                    isDark
                        ? 'glass-card-premium border border-white/10'
                        : 'bg-white border border-teal-100 hover:shadow-2xl',
                ]"
                style="backdrop-filter: blur(20px)"
            >
                <!-- Background gradient overlay -->
                <div
                    class="absolute inset-0 bg-gradient-to-br from-teal-500/10 via-purple-500/10 to-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                ></div>

                <!-- Content -->
                <div class="relative z-10">
                    <!-- Course Icon -->
                    <div class="mb-6">
                        <div
                            :class="
                                isDark
                                    ? 'bg-gradient-to-br from-blue-900 to-purple-900'
                                    : 'bg-gradient-to-br from-blue-50 to-purple-50'
                            "
                            class="w-20 h-20 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300 border border-white/10"
                        >
                            <svg
                                class="w-10 h-10 text-blue-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="mb-8">
                        <h3
                            class="text-2xl font-bold mb-2 group-hover:text-teal-500 transition-colors duration-300 tracking-tight"
                        >
                            {{ c.title }}
                        </h3>
                        <div class="flex items-center space-x-2">
                            <div
                                :class="
                                    isDark ? 'bg-slate-700' : 'bg-slate-100'
                                "
                                class="px-4 py-1 rounded-full"
                            >
                                <p
                                    :class="
                                        isDark
                                            ? 'text-gray-300'
                                            : 'text-gray-600'
                                    "
                                    class="text-sm font-medium"
                                >
                                    {{ c.category_name }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <router-link
                        :to="`/courses/${c.course_id}`"
                        class="block w-full"
                    >
                        <button
                            :class="[
                                'w-full px-8 py-3 rounded-2xl font-bold text-white text-base transition-all duration-300 transform hover:scale-105 shadow-lg',
                                isDark
                                    ? 'bg-gradient-to-r from-purple-600 to-teal-600 hover:from-purple-500 hover:to-teal-500 hover:shadow-purple-500/25'
                                    : 'bg-gradient-to-r from-teal-600 to-purple-600 hover:from-teal-500 hover:to-purple-500 hover:shadow-teal-500/25',
                            ]"
                        >
                            <span
                                class="flex items-center justify-center space-x-2"
                            >
                                <span>Open Course</span>
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
                            </span>
                        </button>
                    </router-link>
                </div>

                <!-- Decorative elements -->
                <div
                    class="absolute top-6 right-6 w-3 h-3 bg-blue-400 rounded-full opacity-30 group-hover:opacity-60 transition-opacity duration-300"
                ></div>
                <div
                    class="absolute bottom-6 left-6 w-2 h-2 bg-purple-400 rounded-full opacity-40 group-hover:opacity-80 transition-opacity duration-300"
                ></div>
            </div>
        </div>

        <!-- Empty State -->
        <div
            v-if="!loading && !error && courses.length === 0"
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
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    />
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-2 text-slate-500">
                No courses yet
            </h3>
            <p class="text-slate-400 text-center max-w-md">
                You haven't enrolled in any courses yet. Start exploring and
                find the perfect course for you!
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useTheme } from "../../composables/useTheme";
const { isDark } = useTheme();

const loading = ref(false);
const error = ref(null);
const courses = ref([]);

const fetchCourses = async () => {
    loading.value = true;
    try {
        const res = await axios.get("/api/user/courses");
        courses.value = res.data.data ?? res.data; // depending on API
    } catch (e) {
        error.value = "Failed to fetch courses";
    } finally {
        loading.value = false;
    }
};

onMounted(fetchCourses);
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
