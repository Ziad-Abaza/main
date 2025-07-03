<template>
  <div class="max-w-2xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Course Quiz Results</h1>
    <div v-if="loading" class="text-gray-400">Loading results...</div>
    <div v-else-if="error" class="text-red-500">{{ error }}</div>
    <div v-else>
      <div class="mb-4">
        <span class="font-semibold">Score:</span> {{ score }} / {{ totalQuestions }}
      </div>
      <div class="mb-4">
        <span class="font-semibold">Percentage:</span> {{ percentage }}%
      </div>
      <div v-if="attempts.length">
        <h2 class="text-xl font-semibold mb-2">Your Answers</h2>
        <ul>
          <li v-for="a in attempts" :key="a.attempt_id" class="mb-2">
            <span class="font-semibold">Q:</span> {{ a.question_id }} -
            <span :class="a.is_correct ? 'text-green-400' : 'text-red-400'">
              {{ a.is_correct ? 'Correct' : 'Incorrect' }}
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useCourseQuizResultsStore } from '@/stores/CourseQuizResultsStore';

const route = useRoute();
const courseId = route.params.courseId;
const resultsStore = useCourseQuizResultsStore();
const loading = ref(true);
const error = ref(null);

const score = ref(0);
const totalQuestions = ref(0);
const percentage = ref(0);
const attempts = ref([]);

onMounted(async () => {
  loading.value = true;
  error.value = null;
  try {
    await resultsStore.fetchQuizResults(courseId);
    score.value = resultsStore.score;
    totalQuestions.value = resultsStore.totalQuestions;
    percentage.value = resultsStore.percentage;
    attempts.value = resultsStore.attempts;
  } catch (e) {
    error.value = resultsStore.error || 'Failed to load results.';
  } finally {
    loading.value = false;
  }
});
</script>

<style scoped>
.text-green-400 { color: #4ade80; }
.text-red-400 { color: #f87171; }
</style>
