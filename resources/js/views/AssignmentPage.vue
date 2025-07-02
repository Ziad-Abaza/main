<template>
  <div class="container py-4">
    <div v-if="loading" class="text-center text-white">Loading...</div>
    <div v-if="error" class="text-center text-red-500">{{ error }}</div>
    <assignment-viewer
      v-if="assignment"
      :assignment="assignment"
      @submission-success="handleSubmissionSuccess"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import AssignmentViewer from '../components/AssignmentViewer.vue';

const route = useRoute();
const assignment = ref(null);
const loading = ref(false);
const error = ref(null);

const loadAssignment = async () => {
  loading.value = true;
  error.value = null;
  try {
    const res = await axios.get(`/api/assignments/${route.params.id}`);
    assignment.value = res.data.data;
  } catch (e) {
    error.value = 'Failed to load assignment. Please try again.';
    console.error(e);
  } finally {
    loading.value = false;
  }
};

const handleSubmissionSuccess = (updatedAssignment) => {
    assignment.value = updatedAssignment;
    // Here you could trigger a global toast notification for better UX
    alert('Submission successful!');
};

onMounted(loadAssignment);
</script>

<style scoped></style>
