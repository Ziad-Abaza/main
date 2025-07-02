<template>
  <div v-if="!isloading" :class="['min-h-screen', isDark ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white' : 'bg-gradient-to-br from-slate-100 via-blue-100 to-purple-100 text-slate-900']">
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-20 left-10 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
      <div class="absolute top-40 right-20 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
      <div class="absolute bottom-20 left-1/3 w-60 h-60 bg-indigo-600/10 rounded-full blur-3xl animate-pulse delay-2000"></div>
    </div>

    <div class="container mx-auto px-6 py-12 relative z-10 max-w-4xl">
      <!-- Theme Toggle Button in Header -->
      <div class="flex justify-center mb-4">
        <button
          @click="toggleTheme"
          class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 dark:bg-slate-800/40 border border-white/30 dark:border-slate-700 shadow hover:scale-110 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
          :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
        >
          <font-awesome-icon :icon="isDark ? 'sun' : 'moon'" class="text-xl transition-colors duration-300" />
          <span class="font-medium text-sm text-slate-700 dark:text-slate-200">{{ isDark ? 'Light Mode' : 'Dark Mode' }}</span>
        </button>
      </div>

      <!-- Back Button -->
      <div class="mb-8">
        <router-link
          :to="{ name: 'video-detail', params: { id: quizStore.quiz.video_id } }"
          class="group inline-flex items-center gap-3 px-6 py-3 glass-card-premium rounded-xl border border-white/20 hover:border-blue-500/50 transition-all duration-300 hover:scale-105"
        >
          <font-awesome-icon
            icon="arrow-left"
            class="group-hover:-translate-x-1 transition-transform duration-300"
          />
          <span class="font-medium">Back to Video</span>
        </router-link>
      </div>

      <!-- Quiz Header -->
      <div class="text-center mb-12">
        <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500/20 to-purple-500/20 border border-blue-500/30 rounded-full backdrop-blur-sm mb-6">
          <span class="text-sm font-medium text-blue-300">🧠 Knowledge Test</span>
        </div>

        <h1 class="text-4xl md:text-5xl font-black mb-4">
          <span class="bg-gradient-to-r from-white via-blue-100 to-purple-100 bg-clip-text text-transparent">
            {{ quizStore.quiz.video_title }}
          </span>
        </h1>

        <p class="text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed">
          Test your understanding with our
          <span class="text-blue-400 font-semibold">interactive quiz</span>
        </p>
      </div>

      <!-- Progress Section -->
      <div class="mb-12">
        <div class="glass-card-premium rounded-2xl p-6 border border-white/20">
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                <font-awesome-icon icon="brain" class="text-white text-sm" />
              </div>
              <div>
                <h3 class="font-semibold text-white">Quiz Progress</h3>
                <p class="text-slate-400 text-sm">{{ progressLabel }}</p>
              </div>
            </div>
            <div class="text-right">
              <div class="text-2xl font-bold text-blue-400">{{ Math.round(progressWidth) }}%</div>
              <div class="text-xs text-slate-400">Complete</div>
            </div>
          </div>

          <!-- Progress Bar -->
          <div class="relative">
            <div class="w-full h-3 bg-slate-800/50 rounded-full overflow-hidden">
              <div
                class="h-full bg-gradient-to-r from-blue-500 to-purple-600 rounded-full transition-all duration-700 ease-out relative"
                :style="{ width: progressWidth + '%' }"
              >
                <div class="absolute inset-0 bg-white/20 animate-pulse rounded-full"></div>
              </div>
            </div>
            <div class="flex justify-between mt-2 text-xs text-slate-400">
              <span>Question {{ currentStep + 1 }}</span>
              <span>{{ allQuestions.length }} Total</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Question Form -->
      <form @submit.prevent="handleSubmit" class="space-y-8">
        <!-- Current Question -->
        <div v-for="q in currentQuestions" :key="q.id" class="group">
          <div class="glass-card-premium rounded-3xl p-8 border border-white/10 group-hover:border-blue-500/30 transition-all duration-500 relative overflow-hidden">
            <!-- Question Header -->
            <div class="flex items-center justify-between mb-6">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-lg flex items-center justify-center">
                  <font-awesome-icon icon="question" class="text-white text-sm" />
                </div>
                <div class="px-3 py-1 bg-yellow-500/20 rounded-full text-xs text-yellow-300 border border-yellow-500/30">
                  Multiple Choice
                </div>
              </div>
              <div class="text-right">
                <div class="text-sm text-slate-400">Question</div>
                <div class="text-lg font-bold text-blue-400">{{ currentStep + 1 }}/{{ allQuestions.length }}</div>
              </div>
            </div>

            <!-- Question Text -->
            <div class="mb-8">
              <h2 class="text-xl md:text-2xl font-bold leading-relaxed text-white mb-4">
                {{ q.text }}
              </h2>
            </div>

            <!-- Options Grid -->
            <div class="space-y-4">
              <label
                v-for="(option, optionIndex) in q.options"
                :key="option.id"
                class="block cursor-pointer group/option"
              >
                <input
                  type="radio"
                  :name="'q' + q.id"
                  :value="option.id"
                  v-model="selectedAnswers[q.id]"
                  class="hidden peer"
                >
                <div class="relative glass-card-premium p-6 rounded-xl border border-white/10
                  peer-checked:border-green-500 peer-checked:bg-green-500/10
                  peer-checked:scale-[1.02] peer-checked:shadow-lg peer-checked:shadow-green-500/10
                  transition-all duration-300
                  group-hover/option:border-purple-500/30 group-hover/option:scale-[1.02] group-hover/option:shadow-lg group-hover/option:shadow-purple-500/10">
                  <!-- Option Letter -->
                  <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full border-2 border-slate-600 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center font-bold text-sm transition-all duration-300 group-hover/option:border-purple-500">
                      <span class="peer-checked:text-white text-slate-400">
                        {{ String.fromCharCode(65 + optionIndex) }}
                      </span>
                    </div>
                    <div class="flex-1">
                      <p class="text-white font-medium group-hover/option:text-blue-300 transition-colors duration-300">
                        {{ option.text }}
                      </p>
                    </div>
                    <!-- Selected Indicator -->
                    <div class="opacity-0 peer-checked:opacity-100 transition-opacity duration-300">
                      <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                        <font-awesome-icon icon="check" class="text-white text-xs" />
                      </div>
                    </div>
                  </div>
                </div>
              </label>
            </div>
          </div>
        </div>

        <!-- Navigation Controls -->
        <div class="flex justify-between items-center">
          <button
            type="button"
            @click="prev"
            :class="[
              'group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-700 to-slate-600 text-white rounded-xl hover:from-slate-600 hover:to-slate-500 transition-all duration-300 hover:scale-105 shadow-lg',
              { 'opacity-50 cursor-not-allowed hover:scale-100': currentStep === 0 }
            ]"
            :disabled="currentStep === 0"
          >
            <font-awesome-icon
              icon="chevron-left"
              class="text-sm group-hover:-translate-x-1 transition-transform duration-300"
            />
            <span class="font-medium">Previous</span>
          </button>

          <!-- Question Counter -->
          <div class="glass-card-premium px-4 py-2 rounded-xl border border-white/20">
            <div class="flex items-center gap-2 text-sm">
              <font-awesome-icon icon="list-ol" class="text-blue-400" />
              <span class="text-slate-300">{{ currentStep + 1 }} of {{ allQuestions.length }}</span>
            </div>
          </div>

          <button
            v-if="currentStep < totalSteps - 1"
            type="button"
            @click="next"
            class="group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-500 hover:to-indigo-600 transition-all duration-300 hover:scale-105 shadow-lg"
          >
            <span class="font-medium">Next</span>
            <font-awesome-icon
              icon="chevron-right"
              class="text-sm group-hover:translate-x-1 transition-transform duration-300"
            />
          </button>

          <button
            v-else
            type="submit"
            class="group flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-500 hover:to-emerald-500 transition-all duration-300 hover:scale-105 shadow-lg relative overflow-hidden"
          >
            <div class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
            <font-awesome-icon icon="paper-plane" class="text-sm relative z-10" />
            <span class="font-medium relative z-10">Submit Quiz</span>
          </button>
        </div>
      </form>

      <!-- Quiz Stats -->
      <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-card-premium rounded-xl p-6 border border-white/10 text-center">
          <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-3">
            <font-awesome-icon icon="clock" class="text-white" />
          </div>
          <div class="text-lg font-bold text-white mb-1">{{ Math.floor(timeSpent / 60) }}:{{ String(timeSpent % 60).padStart(2, '0') }}</div>
          <div class="text-sm text-slate-400">Time Spent</div>
        </div>

        <div class="glass-card-premium rounded-xl p-6 border border-white/10 text-center">
          <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-3">
            <font-awesome-icon icon="check-circle" class="text-white" />
          </div>
          <div class="text-lg font-bold text-white mb-1">{{ answeredCount }}</div>
          <div class="text-sm text-slate-400">Answered</div>
        </div>

        <div class="glass-card-premium rounded-xl p-6 border border-white/10 text-center">
          <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mx-auto mb-3">
            <font-awesome-icon icon="hourglass-half" class="text-white" />
          </div>
          <div class="text-lg font-bold text-white mb-1">{{ allQuestions.length - answeredCount }}</div>
          <div class="text-sm text-slate-400">Remaining</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Loading State -->
  <div v-else class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 flex items-center justify-center">
    <div class="text-center">
      <div class="relative">
        <div class="w-20 h-20 border-4 border-blue-500/30 border-t-blue-500 rounded-full animate-spin mb-6"></div>
        <div class="absolute inset-0 w-20 h-20 border-4 border-purple-500/30 border-t-purple-500 rounded-full animate-spin animation-delay-150"></div>
      </div>
      <div class="glass-card-premium rounded-xl p-6 border border-white/20">
        <h3 class="text-xl font-bold text-white mb-2">Loading Quiz</h3>
        <p class="text-slate-300">Getting your quiz ready...</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useQuizStore } from '@/stores/quizStore';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import {
  faArrowLeft, faChevronLeft, faChevronRight, faBrain, faQuestion,
  faCheck, faCheckCircle, faClock, faHourglassHalf, faListOl,
  faPaperPlane, faMoon, faSun
} from '@fortawesome/free-solid-svg-icons';
import { useTheme } from '@/composables/useTheme';

library.add(
  faArrowLeft, faChevronLeft, faChevronRight, faBrain, faQuestion,
  faCheck, faCheckCircle, faClock, faHourglassHalf, faListOl,
  faPaperPlane, faMoon, faSun
);

const isloading = ref(true);
const route = useRoute();
const router = useRouter();
const quizStore = useQuizStore();
const { isDark, toggleTheme } = useTheme();

// Quiz State
const questionsPerPage = 1;
const currentStep = ref(0);
const selectedAnswers = ref({});
const timeSpent = ref(0);
const timer = ref(null);

// Computed Properties
const allQuestions = computed(() => {
  return (quizStore.quiz?.questions || []).map((q) => ({
    id: q.question_id,
    text: q.text,
    options: q.options.map((opt) => ({
      text: opt.option_text,
      id: opt.option_id,
    })),
  }));
});

const totalSteps = computed(() => Math.ceil(allQuestions.value.length / questionsPerPage));

const currentQuestions = computed(() => {
  const start = currentStep.value * questionsPerPage;
  return allQuestions.value.slice(start, start + questionsPerPage);
});

const progressWidth = computed(() => {
  return allQuestions.value.length > 0 ? ((currentStep.value + 1) / allQuestions.value.length) * 100 : 0;
});

const progressLabel = computed(() => `Question ${currentStep.value + 1} of ${allQuestions.value.length}`);

const answeredCount = computed(() => {
  return Object.values(selectedAnswers.value).filter(answer => answer !== null).length;
});

// Timer Management
const startTimer = () => {
  timer.value = setInterval(() => {
    timeSpent.value++;
  }, 1000);
};

const stopTimer = () => {
  if (timer.value) {
    clearInterval(timer.value);
    timer.value = null;
  }
};

// Lifecycle
onMounted(async () => {
  const videoId = route.params.videoId;
  if (!videoId) {
    console.error('No video ID provided in route');
    return;
  }

  try {
    await quizStore.fetchQuizByVideoId(videoId);
    isloading.value = false;

    // Initialize selectedAnswers
    allQuestions.value.forEach(q => {
      selectedAnswers.value[q.id] = null;
    });

    startTimer();
  } catch (error) {
    console.error('Failed to load quiz:', error);
  }
});

onUnmounted(() => {
  stopTimer();
});

// Methods
function selectAnswer(questionId, option) {
  selectedAnswers.value[questionId] = option.id;
}

function prev() {
  if (currentStep.value > 0) {
    currentStep.value--;
  }
}

function next() {
  if (currentStep.value < totalSteps.value - 1) {
    currentStep.value++;
  }
}

async function handleSubmit() {
  const answers = allQuestions.value.map((q) => {
    const selectedOptionId = selectedAnswers.value[q.id];
    return {
      question_id: q.id,
      selected_option_id: selectedOptionId,
    };
  });

  if (answers.some((a) => a.selected_option_id === null)) {
    alert('Please answer all questions before submitting.');
    return;
  }

  try {
    stopTimer();
    await quizStore.submitAnswers(route.params.videoId, answers);
    await router.push({
      name: 'quiz-result',
      params: { videoId: route.params.videoId },
    });
  } catch (err) {
    console.error('Failed to submit quiz:', err);
    alert('Failed to submit quiz. Please try again.');
  }
}
</script>

<style scoped>
.glass-card-premium {
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.animation-delay-150 {
  animation-delay: 150ms;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  33% { transform: translateY(-10px) rotate(1deg); }
  66% { transform: translateY(5px) rotate(-1deg); }
}

@media (max-width: 768px) {
  .glass-card-premium {
    backdrop-filter: blur(15px);
  }

  .text-4xl { font-size: 2rem; }
  .text-5xl { font-size: 2.5rem; }
}
</style>