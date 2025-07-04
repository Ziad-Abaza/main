<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
    >
        <!-- Floating particles background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute w-2 h-2 bg-teal-400 rounded-full animate-pulse opacity-40"
                style="top: 15%; left: 20%; animation-delay: 0s"
            ></div>
            <div
                class="absolute w-1 h-1 bg-cyan-400 rounded-full animate-pulse opacity-30"
                style="top: 65%; left: 75%; animation-delay: 1.5s"
            ></div>
            <div
                class="absolute w-1.5 h-1.5 bg-purple-400 rounded-full animate-pulse opacity-40"
                style="top: 35%; left: 85%; animation-delay: 2.5s"
            ></div>
            <div
                class="absolute w-1 h-1 bg-blue-400 rounded-full animate-pulse opacity-35"
                style="top: 85%; left: 15%; animation-delay: 3.5s"
            ></div>
            <div
                class="absolute w-2 h-2 bg-pink-400 rounded-full animate-pulse opacity-30"
                style="top: 25%; left: 60%; animation-delay: 4s"
            ></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 py-8 max-w-7xl">
            <!-- Back Button -->
            <router-link
                :to="{ name: 'videos', params: { id: courseId } }"
                :class="[
                    'inline-flex items-center space-x-2 mb-8 px-4 py-2 rounded-full transition-all duration-300 hover:scale-105',
                    isDark
                        ? 'bg-white/10 hover:bg-white/20 text-blue-300 hover:text-blue-200'
                        : 'bg-white/80 hover:bg-white text-blue-600 hover:text-blue-700 shadow-lg',
                ]"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
                <span class="font-medium">Back to Course</span>
            </router-link>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                <!-- Video Player Section (3 columns) -->
                <div class="xl:col-span-3">
                    <!-- Video Player Card -->
                    <div
                        :class="[
                            'group rounded-3xl overflow-hidden shadow-2xl mb-8 relative',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-gray-100',
                        ]"
                    >
                        <!-- Background gradient overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-purple-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>

                        <div class="relative z-10">
                            <!-- Video Player -->
                            <div class="aspect-video bg-black relative">
                                <template v-if="videoUrl">
                                    <template v-if="isYouTube">
                                        <iframe
                                            class="w-full h-full"
                                            :src="youtubeEmbedUrl"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                        ></iframe>
                                    </template>
                                    <template v-else>
                                        <video
                                            controls
                                            class="w-full h-full object-cover"
                                            preload="metadata"
                                        >
                                            <source
                                                :src="videoUrl"
                                                type="video/mp4"
                                            />
                                            Your browser does not support the
                                            video tag.
                                        </video>
                                    </template>
                                </template>
                                <div
                                    v-else
                                    class="flex items-center justify-center h-full"
                                >
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="animate-spin rounded-full h-8 w-8 border-b-2 border-teal-500"
                                        ></div>
                                        <span
                                            :class="
                                                isDark
                                                    ? 'text-gray-300'
                                                    : 'text-gray-600'
                                            "
                                            >Loading video...</span
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Video Info -->
                            <div class="p-8">
                                <div
                                    class="flex items-start justify-between mb-4"
                                >
                                    <h1
                                        class="text-3xl font-black bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-500 bg-clip-text text-transparent"
                                    >
                                        {{ videoTitle }}
                                    </h1>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            :class="[
                                                'text-sm px-3 py-1 rounded-full font-medium',
                                                isDark
                                                    ? 'bg-slate-700 text-slate-300'
                                                    : 'bg-slate-100 text-slate-600',
                                            ]"
                                        >
                                            #{{ videoOrder }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Enhanced Video Meta -->
                                <div
                                    class="flex items-center justify-between mb-6"
                                >
                                    <div
                                        class="flex items-center space-x-6 text-sm"
                                    >
                                        <div
                                            :class="[
                                                'flex items-center space-x-2 px-3 py-1.5 rounded-full',
                                                isDark
                                                    ? 'bg-teal-500/20 text-teal-300 border border-teal-500/30'
                                                    : 'bg-teal-100 text-teal-700 border border-teal-200',
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
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                            <span
                                                class="font-semibold text-sm"
                                                >{{
                                                    formatVideoDuration(
                                                        videoDuration
                                                    )
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>

                                <!-- Video Description -->
                                <div
                                    :class="
                                        isDark
                                            ? 'text-gray-300'
                                            : 'text-gray-600'
                                    "
                                    class="text-lg leading-relaxed"
                                >
                                    {{ videoDescription }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Indicator -->
                    <div
                        :class="[
                            'group rounded-3xl p-6 shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 relative overflow-hidden mb-8',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-teal-100 hover:shadow-2xl',
                        ]"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-teal-500/5 via-transparent to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>

                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-black text-teal-500">
                                    Your Progress
                                </h3>
                                <div
                                    :class="
                                        isDark
                                            ? 'text-gray-300'
                                            : 'text-gray-600'
                                    "
                                    class="text-sm font-medium"
                                >
                                    {{ progressPercentage }}% Complete
                                </div>
                            </div>

                            <div
                                class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3 mb-3"
                            >
                                <div
                                    class="bg-gradient-to-r from-teal-500 to-cyan-500 h-3 rounded-full transition-all duration-500 ease-out"
                                    :style="{ width: progressPercentage + '%' }"
                                ></div>
                            </div>

                            <p
                                :class="
                                    isDark ? 'text-gray-400' : 'text-gray-500'
                                "
                                class="text-sm"
                            >
                                {{ progressText }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (1 column) -->
                <div class="space-y-6">
                    <!-- Course Info -->
                    <div
                        :class="[
                            'group rounded-3xl p-6 shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 relative overflow-hidden',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-teal-100 hover:shadow-2xl',
                        ]"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-teal-500/5 via-transparent to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>

                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-black text-teal-500">
                                    Course Info
                                </h3>
                                <div
                                    :class="
                                        isDark
                                            ? 'p-3 bg-gradient-to-br from-teal-900 to-teal-800 rounded-xl'
                                            : 'p-3 bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl'
                                    "
                                    class="group-hover:scale-110 transition-transform duration-300"
                                >
                                    <svg
                                        class="w-6 h-6 text-teal-500"
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

                            <h4
                                :class="isDark ? 'text-white' : 'text-gray-800'"
                                class="font-bold text-lg mb-2"
                            >
                                {{ courseTitle }}
                            </h4>
                            <p
                                :class="
                                    isDark ? 'text-gray-300' : 'text-gray-600'
                                "
                                class="text-sm leading-relaxed"
                            >
                                {{ courseDescription }}
                            </p>
                        </div>
                    </div>

                    <!-- Quiz Section -->
                    <div
                        :class="[
                            'group rounded-3xl p-6 shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 relative overflow-hidden',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-purple-100 hover:shadow-2xl',
                        ]"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-purple-500/5 via-transparent to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>

                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-black text-purple-500">
                                    Knowledge Check
                                </h3>
                                <div
                                    :class="
                                        isDark
                                            ? 'p-3 bg-gradient-to-br from-purple-900 to-purple-800 rounded-xl'
                                            : 'p-3 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl'
                                    "
                                    class="group-hover:scale-110 transition-transform duration-300"
                                >
                                    <svg
                                        class="w-6 h-6 text-purple-500"
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

                            <template v-if="is_have_questions">
                                <p
                                    :class="
                                        isDark
                                            ? 'text-gray-300'
                                            : 'text-gray-600'
                                    "
                                    class="text-sm mb-4"
                                >
                                    Test your understanding with interactive
                                    questions about this video.
                                </p>
                                <router-link
                                    :to="`/quiz/${videoId}`"
                                    :class="[
                                        'block w-full text-center px-6 py-4 rounded-xl font-bold text-white transition-all duration-300 transform hover:scale-105 shadow-lg',
                                        isDark
                                            ? 'bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 hover:shadow-purple-500/25'
                                            : 'bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-400 hover:to-pink-400 hover:shadow-purple-500/25',
                                    ]"
                                >
                                    <span
                                        class="flex items-center justify-center space-x-2"
                                    >
                                        <svg
                                            class="w-5 h-5"
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
                                        <span>Start Quiz</span>
                                    </span>
                                </router-link>
                            </template>
                            <template v-else>
                                <div class="text-center py-4">
                                    <div
                                        :class="
                                            isDark
                                                ? 'bg-slate-800/50'
                                                : 'bg-slate-100'
                                        "
                                        class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4"
                                    >
                                        <svg
                                            class="w-8 h-8 text-slate-400"
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
                                    <p
                                        :class="
                                            isDark
                                                ? 'text-gray-300'
                                                : 'text-gray-600'
                                        "
                                        class="text-sm"
                                    >
                                        No quiz available for this video.
                                    </p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Next Video Section -->
                    <div
                        :class="[
                            'group rounded-3xl p-6 shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 relative overflow-hidden',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-blue-100 hover:shadow-2xl',
                        ]"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-transparent to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>

                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-xl font-black text-blue-500">
                                    Continue Learning
                                </h3>
                                <div
                                    :class="
                                        isDark
                                            ? 'p-3 bg-gradient-to-br from-blue-900 to-blue-800 rounded-xl'
                                            : 'p-3 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl'
                                    "
                                    class="group-hover:scale-110 transition-transform duration-300"
                                >
                                    <svg
                                        class="w-6 h-6 text-blue-500"
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
                                </div>
                            </div>

                            <!-- Course Completion Message -->
                            <template v-if="!nextVideoTitle">
                                <div class="text-center py-6">
                                    <div
                                        class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4"
                                    >
                                        <svg
                                            class="w-8 h-8 text-green-500"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                    <h4
                                        class="text-green-500 font-bold text-lg mb-2"
                                    >
                                        Course Completed!
                                    </h4>
                                    <p
                                        :class="
                                            isDark
                                                ? 'text-gray-400'
                                                : 'text-gray-500'
                                        "
                                        class="text-sm"
                                    >
                                        Congratulations! You've finished all
                                        videos in this course.
                                    </p>
                                </div>
                            </template>

                            <!-- Next Video Link -->
                            <template v-else>
                                <template v-if="is_have_questions">
                                    <div
                                        :class="[
                                            'border-l-4 p-4 rounded-md shadow-sm',
                                            isDark
                                                ? 'bg-yellow-900/20 border-yellow-500'
                                                : 'bg-yellow-50 border-yellow-400',
                                        ]"
                                    >
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <svg
                                                    class="w-5 h-5 text-yellow-500"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                                    />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p
                                                    :class="
                                                        isDark
                                                            ? 'text-yellow-300'
                                                            : 'text-yellow-700'
                                                    "
                                                    class="text-sm font-medium"
                                                >
                                                    Quiz Required
                                                </p>
                                                <p
                                                    :class="
                                                        isDark
                                                            ? 'text-yellow-400'
                                                            : 'text-yellow-600'
                                                    "
                                                    class="text-sm mt-1"
                                                >
                                                    Complete the quiz to unlock
                                                    the next video.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <router-link
                                        :to="`/video/${nextVideoId}`"
                                        :class="[
                                            'group block transition-all duration-300 transform hover:scale-105 hover:shadow-lg rounded-2xl p-4',
                                            isDark
                                                ? 'bg-slate-800/50 hover:bg-slate-700/50'
                                                : 'bg-slate-50 hover:bg-slate-100',
                                        ]"
                                    >
                                        <div class="flex items-start space-x-4">
                                            <div class="relative">
                                                <div
                                                    class="w-20 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300"
                                                >
                                                    <svg
                                                        class="w-6 h-6 text-white"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M8 5v14l11-7z"
                                                        />
                                                    </svg>
                                                </div>
                                                <div
                                                    class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center"
                                                >
                                                    <svg
                                                        class="w-3 h-3 text-white"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M8 5v14l11-7z"
                                                        />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4
                                                    :class="
                                                        isDark
                                                            ? 'text-white group-hover:text-blue-300'
                                                            : 'text-gray-800 group-hover:text-blue-600'
                                                    "
                                                    class="font-bold text-sm transition-colors duration-300 line-clamp-2"
                                                >
                                                    {{ nextVideoTitle }}
                                                </h4>
                                                <p
                                                    :class="
                                                        isDark
                                                            ? 'text-gray-400'
                                                            : 'text-gray-500'
                                                    "
                                                    class="text-xs mt-1"
                                                >
                                                    Duration:
                                                    {{ nextVideoDuration }}
                                                </p>
                                            </div>
                                        </div>
                                    </router-link>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useVideosStore } from "@/stores/videosStore";
import { useTheme } from "../composables/useTheme";

const { isDark } = useTheme();
const route = useRoute();
const videosStore = useVideosStore();

const videoId = route.params.id;

const videoUrl = ref("");
const videoTitle = ref("");
const videoDuration = ref("");
const videoOrder = ref("");
const videoDescription = ref("");
const progressPercentage = ref(0);
const progressText = ref("");
const courseTitle = ref("");
const courseDescription = ref("");
const nextVideoTitle = ref("");
const nextVideoDuration = ref("");
const is_have_questions = ref(false);
const nextVideoId = ref(null);
const courseId = ref("1");

// New interactive features
const videoPlayer = ref(null);
const currentTime = ref(0);
const duration = ref(0);
const isPlaying = ref(false);
const isLive = ref(false);

const fetchVideoDetails = async () => {
    const videoId = route.params.id;
    const data = await videosStore.fetchVideoDetails(videoId);

    if (data) {
        const { video, nextVideo } = data;

        videoUrl.value = video.url;
        videoTitle.value = video.title;
        videoDuration.value = video.duration;
        videoOrder.value = video.order;
        videoDescription.value = video.description;
        progressPercentage.value = video.progress?.percentage || 0;
        progressText.value = video.progress
            ? `${video.progress.percentage}% watched`
            : "You haven't watched this video yet.";
        courseTitle.value = video.course.title;
        courseDescription.value = video.course.description || "";
        is_have_questions.value = video.hasQuiz;
        courseId.value = video.course.id;

        if (nextVideo) {
            nextVideoTitle.value = nextVideo.title;
            nextVideoDuration.value = `${Math.floor(
                nextVideo.duration / 60
            )}:${String(nextVideo.duration % 60).padStart(2, "0")}`;
            nextVideoId.value = nextVideo.id;
        } else {
            nextVideoTitle.value = null;
        }
    }
};

onMounted(fetchVideoDetails);

watch(
    () => route.params.id,
    (newId) => {
        if (newId) {
            fetchVideoDetails();
        }
    }
);

// Check if videoUrl is a YouTube link
const isYouTube = computed(() => {
    return (
        videoUrl.value.includes("youtube.com") ||
        videoUrl.value.includes("youtu.be")
    );
});

// Convert to embeddable YouTube URL
const youtubeEmbedUrl = computed(() => {
    if (videoUrl.value.includes("youtube.com/watch?v=")) {
        return videoUrl.value.replace("watch?v=", "embed/");
    } else if (videoUrl.value.includes("youtu.be/")) {
        const videoId = videoUrl.value.split("youtu.be/")[1].split("?")[0];
        return `https://www.youtube.com/embed/${videoId}`;
    }
    return "";
});

// Video player functions
const updateProgress = () => {
    if (videoPlayer.value) {
        currentTime.value = videoPlayer.value.currentTime;
        duration.value = videoPlayer.value.duration;
        isPlaying.value = !videoPlayer.value.paused;
    }
};

const onVideoLoaded = () => {
    if (videoPlayer.value) {
        duration.value = videoPlayer.value.duration;
    }
};

const togglePlay = () => {
    if (videoPlayer.value) {
        if (isPlaying.value) {
            videoPlayer.value.pause();
        } else {
            videoPlayer.value.play();
        }
        isPlaying.value = !isPlaying.value;
    }
};

const toggleFullscreen = () => {
    if (videoPlayer.value) {
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            videoPlayer.value.requestFullscreen();
        }
    }
};

// Helper functions
const formatTime = (seconds) => {
    if (!seconds) return "0:00";
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = Math.floor(seconds % 60);
    return `${minutes}:${String(remainingSeconds).padStart(2, "0")}`;
};

const formatVideoDuration = (duration) => {
    if (!duration) return "0:00";

    // إذا كان الوقت بصيغة "HH:MM:SS"
    if (duration.includes(":")) {
        const parts = duration.split(":");
        if (parts.length === 3) {
            const hours = parseInt(parts[0]);
            const minutes = parseInt(parts[1]);
            const seconds = parseInt(parts[2]);

            if (hours > 0) {
                return `${hours}h ${minutes}m ${seconds}s`;
            } else {
                return `${minutes}m ${seconds}s`;
            }
        } else if (parts.length === 2) {
            const minutes = parseInt(parts[0]);
            const seconds = parseInt(parts[1]);
            return `${minutes}m ${seconds}s`;
        }
    }

    // إذا كان الوقت بالثواني
    const totalSeconds = parseInt(duration);
    if (!isNaN(totalSeconds)) {
        const hours = Math.floor(totalSeconds / 3600);
        const minutes = Math.floor((totalSeconds % 3600) / 60);
        const seconds = totalSeconds % 60;

        if (hours > 0) {
            return `${hours}h ${minutes}m ${seconds}s`;
        } else if (minutes > 0) {
            return `${minutes}m ${seconds}s`;
        } else {
            return `${seconds}s`;
        }
    }

    return duration;
};
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
