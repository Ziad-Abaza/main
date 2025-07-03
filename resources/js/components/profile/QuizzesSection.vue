<template>
  <div :class="isDark ? 'text-white' : 'text-slate-800'">
    <h2 class="text-2xl font-semibold mb-4">My Course Quizzes</h2>
    <div v-if="loading" :class="isDark ? 'text-gray-400' : 'text-gray-500'">Loading...</div>
    <div v-else>
      <div v-if="quizzes.length === 0" :class="isDark ? 'text-gray-400' : 'text-gray-500'">No quizzes found for your courses.</div>
      <ul v-else class="space-y-4">
        <li v-for="quiz in quizzes" :key="quiz.quiz_id" :class="['p-4 rounded-lg flex flex-col md:flex-row md:justify-between md:items-center', isDark ? 'bg-gray-800' : 'bg-blue-50']">
          <div>
            <div class="font-bold text-lg">{{ quiz.title }}</div>
            <div :class="isDark ? 'text-sm text-gray-400' : 'text-sm text-gray-500'">Course: {{ quiz.course_title }}</div>
            <div :class="isDark ? 'text-sm text-gray-400' : 'text-sm text-gray-500'">Start: {{ formatDate(quiz.start_at) }}</div>
            <div class="text-sm">
              <span v-if="quiz.status === 'scheduled'" :class="isDark ? 'text-blue-400' : 'text-blue-600'">Scheduled</span>
              <span v-else-if="quiz.status === 'open'" :class="isDark ? 'text-green-400' : 'text-green-600'">Open</span>
              <span v-else :class="isDark ? 'text-gray-400' : 'text-gray-500'">Closed</span>
            </div>
            <div v-if="quiz.status === 'scheduled'" :class="isDark ? 'text-xs text-blue-300 mt-1' : 'text-xs text-blue-500 mt-1'">{{ quiz.message }}</div>
          </div>
          <router-link
            :to="quiz.status === 'open' ? `/profile/quiz/${quiz.quiz_id}` : '#'"
            :class="[isDark ? 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-3 md:mt-0' : 'bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-3 md:mt-0', { 'opacity-50 pointer-events-none': quiz.status !== 'open' } ]"
            :tabindex="quiz.status === 'open' ? 0 : -1"
          >
            Take Quiz
          </router-link>
        </li>
      </ul>
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
.opacity-50 {
  opacity: 0.5;
}
.pointer-events-none {
  pointer-events: none;
}
</style>
