<template>
  <div class="container mx-auto px-4 py-8 max-w-6xl">
    <!-- Back Button -->
    <router-link :to="{ name: 'videos', params: { id: courseId } }"
      class="inline-block mb-6 text-blue-400 hover:text-blue-300 transition underline">
      &larr; Back to Course
    </router-link>

    <!-- Video Player Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Video Column -->
      <div class="lg:col-span-2">
        <!-- Video Card -->
        <div class="glass-card rounded-xl overflow-hidden shadow-xl mb-6">
          <div class="aspect-video bg-black">
            <template v-if="videoUrl">
              <template v-if="isYouTube">
                <iframe class="w-full h-full" :src="youtubeEmbedUrl" frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen></iframe>
              </template>
              <template v-else>
                <video controls class="w-full h-full object-cover">
                  <source :src="videoUrl" type="video/mp4" />
                  Your browser does not support the video tag.
                </video>
              </template>
            </template>
            <div v-else class="flex items-center justify-center h-full text-gray-500">
              Loading video...
            </div>
          </div>
          <div class="p-6">
            <h2 class="text-2xl font-bold mb-2">{{ videoTitle }}</h2>
            <div class="flex items-center text-sm text-gray-400 space-x-4">
              <span>
                <font-awesome-icon icon="clock" class="mr-1" /> Duration: {{ videoDuration }}
              </span>
              <span>
                <font-awesome-icon icon="hashtag" class="mr-1" /> Order: #{{ videoOrder }}
              </span>
            </div>
            <p class="mt-4 text-gray-300">
              {{ videoDescription }}
            </p>
          </div>
        </div>

        <!-- Progress Indicator -->
        <div class="glass-card rounded-xl p-4 mb-6">
          <h3 class="font-semibold text-sm uppercase tracking-wide text-gray-400 mb-2">
            Your Progress
          </h3>
          <div class="w-full bg-gray-700 rounded-full h-2">
            <div class="bg-green-500 h-2 rounded-full" :style="{ width: progressPercentage + '%' }"></div>
          </div>
          <p class="mt-2 text-xs text-gray-400">{{ progressText }}</p>
        </div>
      </div>

      <!-- Sidebar Info -->
      <div class="space-y-6">
        <!-- Course Info -->
        <div class="glass-card rounded-xl p-6">
          <h3 class="font-semibold text-lg mb-4">Course Title</h3>
          <p class="text-gray-300 font-medium">{{ courseTitle }}</p>
        </div>

        <!-- Description -->
        <div class="glass-card rounded-xl p-6">
          <h3 class="font-semibold text-lg mb-4">Description</h3>
          <p class="text-sm text-gray-300 leading-relaxed">
            {{ courseDescription }}
          </p>
        </div>

        <!-- Quiz Section -->
        <template v-if="is_have_questions">
          <div class="glass-card rounded-xl p-6">
            <h3 class="font-semibold text-lg mb-4">Test Your Knowledge</h3>
            <p class="text-sm text-gray-300 mb-4">
              Answer a few questions to reinforce what you've learned from this video.
            </p>
            <router-link :to="`/quiz/${videoId}`"
              class="block w-full text-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 text-white rounded-full transition">
              Start Quiz
            </router-link>
          </div>
        </template>
        <template v-else>
          <div class="glass-card rounded-xl p-6">
            <h3 class="font-semibold text-lg mb-4">No Quiz Available</h3>
            <p class="text-sm text-gray-400">
              This video does not have any associated quiz questions.
            </p>
          </div>
        </template>
        <!-- Related Videos -->
        <div class="glass-card rounded-xl p-6">
          <h3 class="font-semibold text-lg mb-4">Next Video</h3>

          <!-- Show Course Completion Message -->
          <template v-if="!nextVideoTitle">
            <div class="text-center py-4">
              <p class="text-green-400 font-medium flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"></path>
                </svg>
                Course Completed!
              </p>
              <p class="text-sm text-gray-400 mt-2">You've finished all videos in this course.</p>
            </div>
          </template>

          <!-- Next Video Link -->
          <template v-else>
            <template v-if="is_have_questions">
              <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md shadow-sm mt-4">
                <div class="flex items-start">
                  <div class="flex-shrink-0">
                    <font-awesome-icon icon="exclamation-triangle" class="text-yellow-400 h-5 w-5" />
                  </div>
                  <div class="ml-3">
                    <p class="text-sm text-yellow-700 font-medium">
                      Quiz Required
                    </p>
                    <p class="text-sm text-yellow-600 mt-1">
                      You need to complete the quiz before proceeding to the next video.
                    </p>
                  </div>
                </div>
              </div>
            </template>
            <template v-else>
              <router-link :to="`/video/${nextVideoId}`"
                class="group block transition transform hover:scale-105 hover:shadow-md duration-200 ease-in-out">
                <div class="flex items-start space-x-3">
                  <div
                    class="w-16 h-10 bg-gray-800 rounded-md flex items-center justify-center group-hover:bg-indigo-600 transition">
                    <font-awesome-icon icon="play-circle" class="text-indigo-500 group-hover:text-white" />
                  </div>
                  <div>
                    <p class="font-medium text-sm truncate group-hover:text-indigo-400 transition">{{ nextVideoTitle }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Duration: {{ nextVideoDuration }}</p>
                  </div>
                </div>
              </router-link>
            </template>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faClock, faHashtag, faPlayCircle } from '@fortawesome/free-solid-svg-icons';
import { useVideosStore } from '@/stores/videosStore';

library.add(faClock, faHashtag, faPlayCircle);

const route = useRoute();
const videosStore = useVideosStore();

const videoId = route.params.id;

const videoUrl = ref('');
const videoTitle = ref('');
const videoDuration = ref('');
const videoOrder = ref('');
const videoDescription = ref('');
const progressPercentage = ref(0);
const progressText = ref('');
const courseTitle = ref('');
const courseDescription = ref('');
const nextVideoTitle = ref('');
const nextVideoDuration = ref('');
const is_have_questions = ref(false);
const nextVideoId = ref(null); // Add this line
const courseId = ref('1'); 
// Inside fetchVideoDetails


const fetchVideoDetails = async () => {
  const videoId = route.params.id; // Get updated ID from route
  const data = await videosStore.fetchVideoDetails(videoId);

  if (data) {
    const { video, nextVideo } = data;

    videoUrl.value = video.url;
    videoTitle.value = video.title;
    videoDuration.value = video.duration;
    videoOrder.value = video.order;
    videoDescription.value = video.description;
    progressPercentage.value = video.progress?.percentage || 0;
    progressText.value = video.progress ? `${video.progress.percentage}% watched` : "You haven't watched this video yet.";
    courseTitle.value = video.course.title;
    courseDescription.value = video.course.description || '';
    is_have_questions.value = video.hasQuiz;
    courseId.value = video.course.id; // Set courseId from video data
    if (nextVideo) {
      nextVideoTitle.value = nextVideo.title;
      nextVideoDuration.value = `${Math.floor(nextVideo.duration / 60)}:${String(nextVideo.duration % 60).padStart(2, '0')}`;
      nextVideoId.value = nextVideo.id;
    } else {
      nextVideoTitle.value = null; // Triggers completion UI
    }
  }
};

fetchVideoDetails();


watch(
  () => route.params.id,
  (newId) => {
    if (newId) {
      fetchVideoDetails(); // Re-fetch video details when ID changes
    }
  }
);

// Check if videoUrl is a YouTube link
const isYouTube = computed(() => {
  return videoUrl.value.includes('youtube.com') || videoUrl.value.includes('youtu.be');
});

// Convert to embeddable YouTube URL
const youtubeEmbedUrl = computed(() => {
  if (videoUrl.value.includes('youtube.com/watch?v=')) {
    return videoUrl.value.replace('watch?v=', 'embed/');
  } else if (videoUrl.value.includes('youtu.be/')) {
    const videoId = videoUrl.value.split('youtu.be/')[1].split('?')[0];
    return `https://www.youtube.com/embed/${videoId}`;
  }
  return '';
});

</script>

<style scoped>
.glass-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.1);
}
</style>
