<template>
  <div
    :class="
      isDark
        ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
        : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
    "
    class="relative px-4 py-10 md:px-10 md:py-16"
  >
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
        My Course Quizzes
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
          Loading quizzes...
        </span>
      </div>
    </div>

    <!-- Quizzes Grid -->
    <div
      v-else-if="quizzes.length > 0"
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
    >
      <div
        v-for="quiz in quizzes"
        :key="quiz.quiz_id"
        :class="[
          'group relative overflow-hidden rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:scale-105 hover:-translate-y-2',
          isDark
            ? 'glass-card-premium border border-white/10'
            : 'bg-white border border-blue-100 hover:shadow-2xl',
        ]"
        style="backdrop-filter: blur(20px)"
      >
        <!-- Background gradient overlay -->
        <div
          :class="[
            'absolute inset-0 transition-opacity duration-500',
            quiz.status === 'open' 
              ? 'bg-gradient-to-br from-green-500/10 via-blue-500/10 to-cyan-500/10 opacity-0 group-hover:opacity-100'
              : quiz.status === 'scheduled'
              ? 'bg-gradient-to-br from-blue-500/10 via-purple-500/10 to-cyan-500/10 opacity-0 group-hover:opacity-100'
              : 'bg-gradient-to-br from-gray-500/10 via-slate-500/10 to-gray-500/10 opacity-0 group-hover:opacity-100'
          ]"
        ></div>

        <!-- Content -->
        <div class="relative z-10">
          <!-- Quiz Status Icon -->
          <div class="mb-6">
            <div
              :class="[
                'w-16 h-16 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300 border border-white/10',
                quiz.status === 'open' 
                  ? isDark 
                    ? 'bg-gradient-to-br from-green-900 to-green-800' 
                    : 'bg-gradient-to-br from-green-50 to-green-100'
                  : quiz.status === 'scheduled'
                  ? isDark 
                    ? 'bg-gradient-to-br from-blue-900 to-blue-800' 
                    : 'bg-gradient-to-br from-blue-50 to-blue-100'
                  : isDark 
                    ? 'bg-gradient-to-br from-gray-900 to-gray-800' 
                    : 'bg-gradient-to-br from-gray-50 to-gray-100'
              ]"
            >
              <svg
                :class="[
                  'w-8 h-8',
                  quiz.status === 'open' 
                    ? 'text-green-500' 
                    : quiz.status === 'scheduled'
                    ? 'text-blue-500'
                    : 'text-gray-500'
                ]"
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

          <!-- Quiz Info -->
          <div class="mb-8">
            <h3
              class="text-2xl font-bold mb-3 group-hover:text-blue-500 transition-colors duration-300 tracking-tight"
            >
              {{ quiz.title }}
            </h3>
            
            <div class="space-y-2 mb-4">
              <div class="flex items-center space-x-2">
                <div
                  :class="isDark ? 'bg-slate-700' : 'bg-slate-100'"
                  class="px-3 py-1 rounded-full"
                >
                  <p
                    :class="isDark ? 'text-gray-300' : 'text-gray-600'"
                    class="text-sm font-medium"
                  >
                    {{ quiz.course_title }}
                  </p>
                </div>
              </div>
              
              <div class="flex items-center space-x-2">
                <svg
                  class="w-4 h-4 text-gray-500"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2h3z"
                  />
                </svg>
                <span
                  :class="isDark ? 'text-gray-300' : 'text-gray-600'"
                  class="text-sm"
                >
                  {{ formatDate(quiz.start_at) }}
                </span>
              </div>
            </div>

            <!-- Status Badge -->
            <div
              :class="[
                'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold',
                quiz.status === 'open' 
                  ? isDark 
                    ? 'bg-green-900/30 text-green-400 border border-green-700/50' 
                    : 'bg-green-50 text-green-700 border border-green-200'
                  : quiz.status === 'scheduled'
                  ? isDark 
                    ? 'bg-blue-900/30 text-blue-400 border border-blue-700/50' 
                    : 'bg-blue-50 text-blue-700 border border-blue-200'
                  : isDark 
                    ? 'bg-gray-900/30 text-gray-400 border border-gray-700/50' 
                    : 'bg-gray-50 text-gray-700 border border-gray-200'
              ]"
            >
              <span
                v-if="quiz.status === 'scheduled'"
                class="w-2 h-2 rounded-full bg-blue-500 mr-2"
              ></span>
              <span
                v-else-if="quiz.status === 'open'"
                class="w-2 h-2 rounded-full bg-green-500 mr-2"
              ></span>
              <span
                v-else
                class="w-2 h-2 rounded-full bg-gray-500 mr-2"
              ></span>
              
              <span v-if="quiz.status === 'scheduled'">Scheduled</span>
              <span v-else-if="quiz.status === 'open'">Open</span>
              <span v-else>Closed</span>
            </div>

            <!-- Scheduled Message -->
            <div
              v-if="quiz.status === 'scheduled'"
              :class="isDark ? 'text-blue-300 mt-2' : 'text-blue-600 mt-2'"
              class="text-sm italic"
            >
              {{ quiz.message }}
            </div>
          </div>

          <!-- Action Button -->
          <router-link
            :to="quiz.status === 'open' ? `/profile/quiz/${quiz.quiz_id}` : '#'"
            class="block w-full"
            :tabindex="quiz.status === 'open' ? 0 : -1"
          >
            <button
              :class="[
                'w-full px-6 py-3 rounded-2xl font-bold text-white text-base transition-all duration-300 transform shadow-lg',
                quiz.status === 'open'
                  ? isDark
                    ? 'bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-500 hover:to-blue-500 hover:shadow-green-500/25 hover:scale-105'
                    : 'bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-500 hover:to-blue-500 hover:shadow-green-500/25 hover:scale-105'
                  : 'bg-gray-400 cursor-not-allowed opacity-60'
              ]"
              :disabled="quiz.status !== 'open'"
            >
              <span
                class="flex items-center justify-center space-x-2"
              >
                <span>
                  {{ quiz.status === 'open' ? 'Take Quiz' : 'Quiz Unavailable' }}
                </span>
                <svg
                  v-if="quiz.status === 'open'"
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
          :class="[
            'absolute top-6 right-6 w-3 h-3 rounded-full transition-opacity duration-300',
            quiz.status === 'open' 
              ? 'bg-green-400 opacity-30 group-hover:opacity-60'
              : quiz.status === 'scheduled'
              ? 'bg-blue-400 opacity-30 group-hover:opacity-60'
              : 'bg-gray-400 opacity-30 group-hover:opacity-60'
          ]"
        ></div>
        <div
          :class="[
            'absolute bottom-6 left-6 w-2 h-2 rounded-full transition-opacity duration-300',
            quiz.status === 'open' 
              ? 'bg-green-400 opacity-40 group-hover:opacity-80'
              : quiz.status === 'scheduled'
              ? 'bg-blue-400 opacity-40 group-hover:opacity-80'
              : 'bg-gray-400 opacity-40 group-hover:opacity-80'
          ]"
        ></div>
      </div>
    </div>

    <!-- Empty State -->
    <div
      v-else
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
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
      </div>
      <h3 class="text-xl font-bold mb-2 text-slate-500">
        No quizzes found
      </h3>
      <p class="text-slate-400 text-center max-w-md">
        No quizzes found for your courses. Check back later for new quizzes!
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useCourseQuizStore } from '@/stores/CourseQuizStore';
import { useTheme } from '../../composables/useTheme';
const { isDark } = useTheme();

const loading = ref(true);
const quizzes = ref([]);
const quizStore = useCourseQuizStore();

function formatDate(dateStr) {
  if (!dateStr) return '';
  const d = new Date(dateStr);
  return d.toLocaleString();
}

onMounted(async () => {
  loading.value = true;
  try {
    quizzes.value = await quizStore.fetchAllQuizzes();
  } catch (e) {
    quizzes.value = [];
  } finally {
    loading.value = false;
  }
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