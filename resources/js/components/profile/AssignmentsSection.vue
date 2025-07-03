<template>
  <div :class="isDark ? 'text-white' : 'text-slate-800'">
    <h2 class="text-2xl font-semibold mb-4">Assignments</h2>

    <div v-if="store.loading" :class="isDark ? 'text-gray-400' : 'text-gray-500'">Loading assignments...</div>
    <div v-if="store.error" class="text-red-500">{{ store.error }}</div>

    <div v-if="!store.loading && !store.error">
      <div v-if="store.assignments.length === 0" :class="isDark ? 'text-gray-400' : 'text-gray-500'">No assignments yet.</div>

      <ul class="space-y-4">
        <li
          v-for="as in store.assignments"
          :key="as.id"
          :class="[
            'p-4 rounded-xl flex flex-col md:flex-row md:items-center justify-between',
            isDark ? (isOverdue(as.due_date) ? 'bg-white/5 opacity-75' : 'bg-white/5') : (isOverdue(as.due_date) ? 'bg-red-50 opacity-75' : 'bg-blue-50'),
            isDark ? (isWithinDays(as.due_date, 3) && !isWithinDays(as.due_date, 1) ? 'border-2 border-yellow-500/50' : '') : (isWithinDays(as.due_date, 3) && !isWithinDays(as.due_date, 1) ? 'border-2 border-yellow-300/50' : ''),
            isDark ? (isWithinDays(as.due_date, 1) && !isOverdue(as.due_date) ? 'border-2 border-red-500/50' : '') : (isWithinDays(as.due_date, 1) && !isOverdue(as.due_date) ? 'border-2 border-red-300/50' : '')
          ]"
        >
          <div>
            <h3 :class="[
              'text-xl font-semibold',
              isDark ? (isOverdue(as.due_date) ? 'line-through text-gray-500' : (isWithinDays(as.due_date, 3) && !isWithinDays(as.due_date, 1) ? 'text-yellow-500' : (isWithinDays(as.due_date, 1) && !isOverdue(as.due_date) ? 'text-red-500' : 'text-gray-300'))) : (isOverdue(as.due_date) ? 'line-through text-gray-400' : (isWithinDays(as.due_date, 3) && !isWithinDays(as.due_date, 1) ? 'text-yellow-700' : (isWithinDays(as.due_date, 1) && !isOverdue(as.due_date) ? 'text-red-700' : 'text-gray-700')))
            ]">{{ as.title }}</h3>
            <p :class="[
              'text-sm',
              isDark ? (isOverdue(as.due_date) ? 'text-gray-500' : (isWithinDays(as.due_date, 3) && !isWithinDays(as.due_date, 1) ? 'text-yellow-500' : (isWithinDays(as.due_date, 1) && !isOverdue(as.due_date) ? 'text-red-500' : 'text-gray-300'))) : (isOverdue(as.due_date) ? 'text-gray-400' : (isWithinDays(as.due_date, 3) && !isWithinDays(as.due_date, 1) ? 'text-yellow-700' : (isWithinDays(as.due_date, 1) && !isOverdue(as.due_date) ? 'text-red-700' : 'text-gray-500')))
            ]" v-if="as.due_date">Due: {{ as.due_date }}</p>
          </div>
          <div class="mt-3 md:mt-0 flex items-center gap-4">
            <a v-if="as.attachment_url" :href="as.attachment_url" :class="isDark ? 'px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg text-sm text-white' : 'px-4 py-2 bg-blue-100 hover:bg-blue-200 rounded-lg text-sm text-blue-700'" target="_blank">Download</a>
            <router-link :to="`/assignments/${as.id}`" :class="isDark ? 'px-4 py-2 bg-purple-600 hover:bg-purple-500 rounded-lg text-sm text-white' : 'px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg text-sm text-white'">Open</router-link>
          </div>
        </li>
      </ul>
    </div>

    <h2 class="text-2xl font-semibold mt-10 mb-4">My Submissions</h2>

    <div v-if="store.loadingSubs" :class="isDark ? 'text-gray-400' : 'text-gray-500'">Loading submissions...</div>
    <div v-if="store.errorSubs" class="text-red-500">{{ store.errorSubs }}</div>

    <div v-if="!store.loadingSubs && !store.errorSubs">
      <div v-if="store.submissions.length === 0" :class="isDark ? 'text-gray-400' : 'text-gray-500'">You haven't submitted anything yet.</div>
      <ul class="space-y-4">
        <li
          v-for="sub in store.submissions"
          :key="sub.id"
          :class="['p-4 rounded-xl flex flex-col md:flex-row md:items-center justify-between', isDark ? 'bg-white/5' : 'bg-blue-50']"
        >
          <div>
            <h3 class="text-xl font-semibold">{{ sub.assignment_title }}</h3>
            <p :class="isDark ? 'text-gray-300 text-sm' : 'text-gray-500 text-sm'">Submitted: {{ sub.created_at }}</p>
          </div>
          <div class="mt-3 md:mt-0 flex items-center gap-4">
            <a v-if="sub.file_url" :href="sub.file_url" target="_blank" :class="isDark ? 'px-4 py-2 bg-blue-600 hover:bg-blue-500 rounded-lg text-sm text-white' : 'px-4 py-2 bg-blue-100 hover:bg-blue-200 rounded-lg text-sm text-blue-700'">Download</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useProfileStore } from '@/stores/profile';
import { useTheme } from '../../composables/useTheme';

const store = useProfileStore();
const { isDark } = useTheme();

const isWithinDays = (dueDate, days) => {
  if (!dueDate) return false;
  const due = new Date(dueDate);
  const now = new Date();
  const diffTime = due - now;
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
  return diffDays <= days && diffDays > 0;
};

const isOverdue = (dueDate) => {
  if (!dueDate) return false;
  const due = new Date(dueDate);
  return due < new Date();
};

onMounted(() => {
  store.fetchSubmissions();
});
</script>

<style scoped></style>
