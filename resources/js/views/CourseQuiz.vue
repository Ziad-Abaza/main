<template>
  <div class="max-w-2xl mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Course Quiz</h1>
    <div v-if="loading" class="text-gray-400">Loading quiz...</div>
    <div v-else-if="error" class="text-red-500">{{ error }}</div>
    <div v-else-if="quiz">
      <h2 class="text-xl font-semibold mb-4">{{ quiz.title }}</h2>
      <form @submit.prevent="submitQuiz">
        <div v-for="(q, idx) in quiz.questions" :key="q.question_id" class="mb-8">
          <div class="font-semibold mb-2 text-lg">{{ idx + 1 }}. {{ q.text }}</div>
          <div v-if="q">
            <div v-for="opt in q.options" :key="opt.option_id" class="mb-2">
              <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" :name="q.question_id" :value="opt.option_id" v-model="answers[q.question_id]"
                  class="form-radio" />
                <span>{{ opt.option_text }}</span>
              </label>
            </div>
          </div>
          <div v-else-if="q.type === 'true_false'">
            <div v-for="opt in q.options" :key="opt.option_id" class="mb-2">
              <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" :name="q.question_id" :value="opt.option_id" v-model="answers[q.question_id]"
                  class="form-radio" />
                <span>{{ opt.option_text }}</span>
              </label>
            </div>
          </div>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-4">Submit
          Quiz</button>
      </form>
    </div>
    <div v-else class="text-gray-400">No quiz found for this course.</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useCourseQuizStore } from '@/stores/CourseQuizStore';

const route = useRoute();
const router = useRouter();
const quizId = route.params.id;
const quizStore = useCourseQuizStore();
const loading = ref(true);
const error = ref(null);
const quiz = ref(null);
const answers = ref({});

onMounted(async () => {
  loading.value = true;
  error.value = null;
  try {
    quiz.value = await quizStore.fetchQuizById(quizId);
    if (!quiz.value) throw new Error('Quiz not found');
    // Initialize answers
    if (quiz.value.questions) {
      quiz.value.questions.forEach(q => {
        answers.value[q.question_id] = null;
      });
      console.log('Quiz questions:', quiz.value.questions);

      console.log('Answers initialized:', answers.value);
    }
  } catch (e) {
    console.error('Error loading quiz:', e);
    error.value = quizStore.error || 'Failed to load quiz.';
  } finally {
    loading.value = false;
  }
});

async function submitQuiz() {
  try {
    const payload = quiz.value.questions.map(q => ({
      question_id: q.question_id,
      selected_option_id: answers.value[q.question_id],
      type: q.type || 'mcq'
    }));

    // Optional: Check for unanswered questions
    const unanswered = payload.find(a => !a.selected_option_id);
    if (unanswered) {
      error.value = 'Please answer all questions before submitting.';
      return;
    }

    await quizStore.submitAnswers(quizId, payload);
    router.push({ name: 'profile-quiz-result', params: { id: quizId } });
  } catch (e) {
    console.error('Error submitting quiz:', e);
    error.value = quizStore.error || 'Failed to submit quiz.';
  }
}
</script>

<style scoped>
/* No @apply or .btn-primary here. */
</style>
