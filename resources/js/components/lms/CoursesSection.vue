<template>
  <div :class="isDark ? 'text-white' : 'text-slate-800'">
    <h2 class="text-2xl font-semibold mb-4">My Courses</h2>

    <div v-if="loading" :class="isDark ? 'text-gray-400' : 'text-gray-500'">Loading...</div>
    <div v-if="error" class="text-red-500">{{ error }}</div>

    <ul v-if="!loading && !error" class="space-y-4">
      <li v-for="c in courses" :key="c.course_id" :class="['p-4 rounded-xl flex justify-between items-center', isDark ? 'bg-white/5' : 'bg-blue-50']">
        <div>
          <h3 class="text-xl font-semibold">{{ c.title }}</h3>
          <p :class="isDark ? 'text-gray-400' : 'text-gray-500 text-sm'">{{ c.category_name }}</p>
        </div>
        <router-link :to="`/courses/${c.course_id}`" :class="isDark ? 'px-4 py-2 bg-purple-600 hover:bg-purple-500 rounded-lg text-sm text-white' : 'px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg text-sm text-white'">Open</router-link>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useTheme } from '../../composables/useTheme';
const { isDark } = useTheme();

const loading = ref(false);
const error = ref(null);
const courses = ref([]);

const fetchCourses = async () => {
  loading.value = true;
  try {
    const res = await axios.get('/api/user/courses');
    courses.value = res.data.data ?? res.data; // depending on API
  } catch (e) {
    error.value = 'Failed to fetch courses';
  } finally {
    loading.value = false;
  }
};

onMounted(fetchCourses);
</script>

<style scoped></style>
