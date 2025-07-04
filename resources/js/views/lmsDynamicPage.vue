<script setup>
import { computed, defineAsyncComponent } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();

const component = computed(() => {
  if (route.params.page === 'quiz') {
    return defineAsyncComponent(() => import('@/views/CourseQuiz.vue'));
  } else if (route.params.page === 'quiz-result') {
    return defineAsyncComponent(() => import('@/views/CourseQuizResults.vue'));
  } else {
    return defineAsyncComponent(() => import('@/views/NotFound.vue'));
  }
});
</script>

<template>
  <component :is="component" />
</template>
