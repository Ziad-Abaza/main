<template>
    <template v-if="!loading">
        <div :class="['container mx-auto px-4 py-8 max-w-3xl', isDark ? 'text-white' : 'text-slate-900']">
            <router-link to="/courses"
                :class="isDark ? 'inline-block mb-4 text-blue-400 hover:text-blue-300 transition underline' : 'inline-block mb-4 text-blue-700 hover:text-blue-500 transition underline'">&larr; Back to
                Course</router-link>

            <h1 class="text-2xl font-bold mb-2">{{ title || 'Course Videos' }}</h1>
            <p :class="isDark ? 'text-sm text-gray-400 mb-6' : 'text-sm text-gray-500 mb-6'">Watch and interact with the course videos below.</p>

            <!-- Videos List -->
            <div class="space-y-4">
                <template v-for="video in videos" :key="video.video_id">
                    <router-link :to="`/video/${video.video_id}`"
                        :class="['rounded-xl p-4 shadow-md flex items-center justify-between group hover:shadow-indigo-500/20 transition overflow-hidden', isDark ? 'glass-card' : 'bg-white border border-blue-100 hover:shadow-blue-200']">
                        <div class="flex items-center gap-4 min-w-0">
                            <div :class="isDark ? 'w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0' : 'w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0'">
                                <img v-if="video.thumbnail"
                                    :src="video.thumbnail"
                                    :alt="video.title"
                                    @error="$event.target.src = defaultImage"
                                    class="w-full h-full object-cover rounded-lg" />
                                <img v-else :src="defaultImage" alt="Default Thumbnail"
                                    class="w-full h-full object-cover rounded-lg" />
                            </div>
                            <div class="min-w-0">
                                <h2 :class="isDark ? 'font-medium truncate group-hover:text-blue-400' : 'font-medium truncate group-hover:text-blue-700'">{{ video.title }}</h2>
                                <p :class="isDark ? 'text-xs text-gray-400 mt-1' : 'text-xs text-gray-500 mt-1'">Duration: {{ video.duration }} | Order: #{{
                                    video.order }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                            <font-awesome-icon :icon="video.watched ? 'eye' : 'eye-slash'" class="cursor-pointer"
                                :class="video.watched ? (isDark ? 'text-green-500' : 'text-green-600') : (isDark ? 'text-gray-500' : 'text-gray-400')"
                                :title="video.watched ? 'Watched' : 'Not Watched'" />
                            <button @click="startQuiz(video.id)"
                                :class="isDark ? 'text-xs px-3 py-1 bg-indigo-600 hover:bg-indigo-500 rounded-full transition' : 'text-xs px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-full transition'">
                                Start Quiz
                            </button>
                            <span v-if="video.status" :class="{
                                'bg-green-700 text-green-100': isDark && video.status === 'Completed',
                                'bg-yellow-700 text-yellow-100': isDark && video.status === 'In Progress',
                                'bg-green-100 text-green-700': !isDark && video.status === 'Completed',
                                'bg-yellow-100 text-yellow-700': !isDark && video.status === 'In Progress',
                            }" class="ml-2 text-xs px-3 py-1 rounded-full whitespace-nowrap">
                                {{ video.status }}
                            </span>
                        </div>
                    </router-link>
                </template>
            </div>
        </div>
    </template>

    <template v-else>
        <div class="flex flex-col items-center justify-center min-h-[300px]">
            <svg :class="isDark ? 'animate-spin h-12 w-12 text-indigo-500 mb-4' : 'animate-spin h-12 w-12 text-blue-400 mb-4'" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span :class="isDark ? 'text-gray-400 text-lg font-medium' : 'text-gray-500 text-lg font-medium'">Loading videos...</span>
        </div>
    </template>
</template>



<script setup>
import { ref } from 'vue';
import { useVideosStore } from '@/stores/videosStore';
import { useRoute } from 'vue-router';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faVideo, faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons';
import defaultImage from '@/assets/icons/EduStream.jpg';
import { useTheme } from '../composables/useTheme';
const { isDark } = useTheme();

library.add(faVideo, faEye, faEyeSlash);

const route = useRoute();
const id = route.params.id;

const videosStore = useVideosStore();
const videos = ref([]);
const title = ref('');
const loading = ref(true);

const fetchVideos = async () => {
    if (id) {
        await videosStore.fetchVideos(id);
        videos.value = videosStore.videos;
        title.value = videosStore.title;
        loading.value = false;
    }
};

fetchVideos();


const startQuiz = (videoId) => {
    console.log(`Starting quiz for video ID: ${videoId}`);
    // Add logic to navigate to the quiz page or handle quiz start
};

</script>

<style scoped>
.glass-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
.bg-blue-50 {
    background: #f0f6ff !important;
}
.border-blue-100 {
    border-color: #dbeafe !important;
}
</style>
