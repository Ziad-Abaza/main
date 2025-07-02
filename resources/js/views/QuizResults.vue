<template>
  <template v-if="!quizResultsStore.loading">

    <div class="container mx-auto px-4 py-12 max-w-3xl relative h-screen flex items-center justify-center">
      <!-- Confetti Particles -->
      <div id="confetti-container" ref="confettiContainer"></div>

      <!-- Quiz Result Card -->
      <div
        class="glass-card rounded-2xl p-8 shadow-2xl text-center animate-pop-in transform transition-transform duration-700 hover:scale-105">

        <!-- Success Icon -->
        <div class="w-20 h-20 mx-auto mb-6 relative">
          <i class="fas fa-award text-yellow-400 text-5xl animate-bounce"></i>
        </div>

        <!-- Title -->
        <h1 class="text-3xl font-bold mb-4">Quiz Completed!</h1>

        <!-- Score -->
        <p class="text-gray-300 mb-2">
          You answered
          <span class="font-semibold text-green-400">{{ quizResultsStore.correct_answers }} out of {{
            quizResultsStore.total_questions }}</span>
          questions correctly.
        </p>
        <p class="text-gray-300 mb-6">
          Your score is
          <span class="font-semibold text-blue-400">{{ quizResultsStore.percentage }}%</span>
        </p>

        <!-- Pass/Fail Message -->
        <div v-if="quizResultsStore.percentage >= 50"
          class="mt-6 mb-8 p-4 rounded-lg bg-green-500/10 border border-green-500/30">
          <i class="fas fa-check-circle text-green-500 mr-2"></i>
          <span class="text-green-400 font-semibold">Congratulations! You passed the quiz successfully 🎉</span>
        </div>
        <div v-else class="mt-6 mb-8 p-4 rounded-lg bg-red-500/10 border border-red-500/30">
          <i class="fas fa-times-circle text-red-500 mr-2"></i>
          <span class="text-red-400 font-semibold">You did not pass. Try again!</span>
        </div>

        <!-- Next Video Button -->
        <template v-if="quizResultsStore.next_video">
          <router-link :to="{ name: 'video', params: { id: quizResultsStore.next_video.video_id } }"
            class="inline-block mt-4 px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 rounded-full transition">
            Continue to Next Video →
          </router-link>
        </template>
        <template v-else>
          <p class="text-gray-500 dark:text-gray-400 mt-4 text-xl font-semibold">
            🎉 You've completed all videos!
          </p>
          <p class="text-gray-400 dark:text-gray-500 mt-2">
            Great job on finishing everything. Check back later for more content!
          </p>
        </template>
      </div>
    </div>
  </template>
  <template v-else>
    <div class="flex flex-col items-center justify-center h-screen bg-gray-900 text-white">
      <div class="loader mb-4"></div>
      <p class="text-lg font-medium">Loading your quiz results...</p>
    </div>
  </template>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import { useQuizResultsStore } from '@/stores/quizResultsStore'

const route = useRoute()
const quizResultsStore = useQuizResultsStore()
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
.glass-card {
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.1);
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


.loader {
  width: 60px;
  height: 60px;
  border: 6px solid #ffffff;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
</style>