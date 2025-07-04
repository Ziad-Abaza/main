<template>
  <template v-if="!quizResultsStore.loading">
    <div :class="[
      'min-h-screen relative overflow-hidden',
      isDark 
        ? 'bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white' 
        : 'bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
    ]">
      <!-- Floating particles background -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div
          class="absolute w-2 h-2 bg-teal-400 rounded-full animate-pulse opacity-40"
          style="top: 20%; left: 20%; animation-delay: 0s"
        ></div>
        <div
          class="absolute w-1 h-1 bg-cyan-400 rounded-full animate-pulse opacity-30"
          style="top: 60%; left: 80%; animation-delay: 1s"
        ></div>
        <div
          class="absolute w-1.5 h-1.5 bg-purple-400 rounded-full animate-pulse opacity-40"
          style="top: 40%; left: 15%; animation-delay: 2s"
        ></div>
        <div
          class="absolute w-1 h-1 bg-blue-400 rounded-full animate-pulse opacity-35"
          style="top: 80%; left: 75%; animation-delay: 3s"
        ></div>
        <div
          class="absolute w-2 h-2 bg-pink-400 rounded-full animate-pulse opacity-30"
          style="top: 30%; left: 85%; animation-delay: 4s"
        ></div>
      </div>

      <div class="relative z-10 container mx-auto px-6 py-8 max-w-4xl flex items-center justify-center min-h-screen">
        <!-- Confetti Particles -->
        <div id="confetti-container" ref="confettiContainer"></div>

        <!-- Enhanced Quiz Result Card -->
        <div :class="[
          'rounded-3xl p-8 shadow-2xl text-center animate-pop-in transform transition-transform duration-700 hover:scale-105 relative overflow-hidden',
          isDark
            ? 'glass-card-premium border border-white/10'
            : 'bg-white border border-teal-100 hover:shadow-2xl'
        ]">
          <!-- Success Icon with enhanced styling -->
          <div class="w-24 h-24 mx-auto mb-8 relative">
            <div :class="[
              'w-full h-full rounded-full flex items-center justify-center',
              quizResultsStore.percentage >= 50
                ? 'bg-gradient-to-br from-green-500 to-emerald-600 animate-bounce'
                : 'bg-gradient-to-br from-red-500 to-pink-600 animate-pulse'
            ]">
              <svg v-if="quizResultsStore.percentage >= 50" class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <svg v-else class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <!-- Glow effect -->
            <div :class="[
              'absolute inset-0 rounded-full blur-xl opacity-30',
              quizResultsStore.percentage >= 50 ? 'bg-green-500' : 'bg-red-500'
            ]"></div>
          </div>

          <!-- Enhanced Title -->
          <h1 class="text-4xl md:text-5xl font-black mb-6 bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-500 bg-clip-text text-transparent drop-shadow-2xl tracking-tight">
            Quiz Completed!
          </h1>
          <div class="w-24 h-1 bg-gradient-to-r from-teal-400 to-purple-500 rounded-full mx-auto mb-6"></div>

          <!-- Enhanced Score Display -->
          <div class="mb-8">
            <p :class="isDark ? 'text-gray-300 text-lg' : 'text-gray-600 text-lg'" class="mb-2">
              You answered
              <span class="font-bold text-green-500">{{ quizResultsStore.correct_answers }} out of {{ quizResultsStore.total_questions }}</span>
              questions correctly.
            </p>
            <p :class="isDark ? 'text-gray-300 text-lg' : 'text-gray-600 text-lg'" class="mb-6">
              Your score is
              <span class="font-bold text-blue-500 text-2xl">{{ quizResultsStore.percentage }}%</span>
            </p>
          </div>

          <!-- Enhanced Pass/Fail Message -->
          <div v-if="quizResultsStore.percentage >= 50" :class="[
            'mt-6 mb-8 p-6 rounded-2xl border-2',
            isDark 
              ? 'bg-gradient-to-r from-green-500/10 to-emerald-500/10 border-green-500/30' 
              : 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-200'
          ]">
            <div class="flex items-center justify-center space-x-3">
              <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span class="text-green-600 font-bold text-lg">Congratulations! You passed the quiz successfully 🎉</span>
            </div>
          </div>
          <div v-else :class="[
            'mt-6 mb-8 p-6 rounded-2xl border-2',
            isDark 
              ? 'bg-gradient-to-r from-red-500/10 to-pink-500/10 border-red-500/30' 
              : 'bg-gradient-to-r from-red-50 to-pink-50 border-red-200'
          ]">
            <div class="flex items-center justify-center space-x-3">
              <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span class="text-red-600 font-bold text-lg">You did not pass. Try again!</span>
            </div>
          </div>

          <!-- Enhanced Next Video Button -->
          <template v-if="quizResultsStore.next_video">
            <router-link 
              :to="{ name: 'video', params: { id: quizResultsStore.next_video.video_id } }"
              :class="[
                'inline-flex items-center space-x-2 px-8 py-4 rounded-2xl font-semibold transition-all duration-300 hover:scale-105 shadow-lg relative overflow-hidden',
                isDark
                  ? 'bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-400 hover:to-cyan-400 text-white'
                  : 'bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-400 hover:to-cyan-400 text-white'
              ]"
            >
              <div class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
              <span class="relative z-10">Continue to Next Video</span>
              <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </router-link>
          </template>
          <template v-else>
            <div :class="[
              'mt-8 p-6 rounded-2xl border-2',
              isDark 
                ? 'bg-gradient-to-r from-purple-500/10 to-pink-500/10 border-purple-500/30' 
                : 'bg-gradient-to-r from-purple-50 to-pink-50 border-purple-200'
            ]">
              <p :class="isDark ? 'text-purple-300' : 'text-purple-600'" class="text-xl font-bold mb-2">
                🎉 You've completed all videos!
              </p>
              <p :class="isDark ? 'text-gray-400' : 'text-gray-600'">
                Great job on finishing everything. Check back later for more content!
              </p>
            </div>
          </template>
        </div>
      </div>
    </div>
  </template>
  
  <template v-else>
    <div :class="[
      'min-h-screen flex items-center justify-center',
      isDark 
        ? 'bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900' 
        : 'bg-gradient-to-br from-slate-50 via-teal-50 to-white'
    ]">
      <div class="text-center">
        <div class="relative mb-6">
          <div :class="[
            'w-20 h-20 border-4 rounded-full animate-spin',
            isDark 
              ? 'border-blue-500/30 border-t-blue-500' 
              : 'border-blue-500/30 border-t-blue-500'
          ]"></div>
          <div :class="[
            'absolute inset-0 w-20 h-20 border-4 rounded-full animate-spin animation-delay-150',
            isDark 
              ? 'border-purple-500/30 border-t-purple-500' 
              : 'border-purple-500/30 border-t-purple-500'
          ]"></div>
        </div>
        <div :class="[
          'rounded-xl p-6 shadow-xl border',
          isDark 
            ? 'glass-card-premium border-white/20' 
            : 'bg-white border-gray-200'
        ]">
          <h3 :class="isDark ? 'text-white' : 'text-gray-800'" class="text-xl font-bold mb-2">Loading Results</h3>
          <p :class="isDark ? 'text-gray-300' : 'text-gray-600'">Calculating your quiz results...</p>
        </div>
      </div>
    </div>
  </template>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useQuizResultsStore } from '@/stores/quizResultsStore'
import { useTheme } from '@/composables/useTheme'

const route = useRoute()
const quizResultsStore = useQuizResultsStore()
const { isDark } = useTheme()
const videoId = route.params.videoId
const data = ref(null);

const mount = async () => {
  if (videoId) {
    try {
      await quizResultsStore.fetchQuizResults(videoId);
    } catch (err) {
      alert('Could not load quiz results.')
    }
  }
}

mount();
</script>

<style scoped>
.glass-card-premium {
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.15);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

@keyframes popIn {
  0% {
    transform: scale(0.7);
    opacity: 0;
  }

  70% {
    transform: scale(1.1);
    opacity: 1;
  }

  100% {
    transform: scale(1);
    opacity: 1;
  }
}

.animate-pop-in {
  animation: popIn 1s ease-out forwards;
}

@keyframes confetti {
  0% {
    transform: translateY(0) rotate(0);
    opacity: 1;
  }

  100% {
    transform: translateY(200px) rotate(360deg);
    opacity: 0;
  }
}

.confetti {
  position: absolute;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  animation: confetti 3s infinite linear;
}

@keyframes pulse {
  0%, 100% {
    opacity: 0.3;
  }
  50% {
    opacity: 0.8;
  }
}

.animate-pulse {
  animation: pulse 3s ease-in-out infinite;
}

.animation-delay-150 {
  animation-delay: 150ms;
}
</style>