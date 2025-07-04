<template>
  <div :class="isDark ? 'text-white' : 'text-slate-800'">
    <h2 class="text-2xl font-semibold mb-4">Welcome back!</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 flex flex-col items-center">
        <h3 class="text-lg font-semibold mb-2">Courses</h3>
        <div class="flex space-x-4">
          <div class="text-center">
            <div class="text-2xl font-bold">{{ coursesStats.total }}</div>
            <div class="text-xs text-gray-500">Total</div>
          </div>
          <div class="text-center">
            <div class="text-2xl font-bold text-green-600">{{ coursesStats.completed }}</div>
            <div class="text-xs text-gray-500">Completed</div>
          </div>
          <div class="text-center">
            <div class="text-2xl font-bold text-yellow-500">{{ coursesStats.in_progress }}</div>
            <div class="text-xs text-gray-500">In Progress</div>
          </div>
        </div>
      </div>
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6 flex flex-col items-center">
        <h3 class="text-lg font-semibold mb-2">Assignments</h3>
        <div class="flex space-x-4">
          <div class="text-center">
            <div class="text-2xl font-bold">{{ assignmentsStats.total }}</div>
            <div class="text-xs text-gray-500">Total</div>
          </div>
          <div class="text-center">
            <div class="text-2xl font-bold text-green-600">{{ assignmentsStats.completed }}</div>
            <div class="text-xs text-gray-500">Completed</div>
          </div>
          <div class="text-center">
            <div class="text-2xl font-bold text-yellow-500">{{ assignmentsStats.pending }}</div>
            <div class="text-xs text-gray-500">Pending</div>
          </div>
        </div>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Course Progress Over Time</h3>
        <BarChart v-if="graphData.coursesProgress.length" :chart-data="coursesProgressChartData" :options="barChartOptions" />
      </div>
      <div class="bg-white dark:bg-slate-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Assignments Completed Over Time</h3>
        <LineChart v-if="graphData.assignmentsOverTime.length" :chart-data="assignmentsOverTimeChartData" :options="lineChartOptions" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';
import { useTheme } from '../../composables/useTheme';
// Chart.js for Vue 3 (vue-chart-3)
import { BarChart, LineChart } from 'vue-chart-3';

const { isDark } = useTheme();

const coursesStats = ref({ total: 0, completed: 0, in_progress: 0 });
const assignmentsStats = ref({ total: 0, completed: 0, pending: 0 });
const graphData = ref({ coursesProgress: [], assignmentsOverTime: [] });

const fetchStats = async () => {
  const [coursesRes, assignmentsRes, graphRes] = await Promise.all([
    axios.get('/api/overview/courses-stats'),
    axios.get('/api/overview/assignments-stats'),
    axios.get('/api/overview/graph-data'),
  ]);
  coursesStats.value = coursesRes.data;
  assignmentsStats.value = assignmentsRes.data;
  graphData.value = graphRes.data;
};

onMounted(fetchStats);

const coursesProgressChartData = computed(() => ({
  labels: graphData.value.coursesProgress.map(item => item.date),
  datasets: [
    {
      label: 'Progress (%)',
      backgroundColor: '#6366f1',
      data: graphData.value.coursesProgress.map(item => item.progress),
    },
  ],
}));

const assignmentsOverTimeChartData = computed(() => ({
  labels: graphData.value.assignmentsOverTime.map(item => item.date),
  datasets: [
    {
      label: 'Assignments Completed',
      borderColor: '#10b981',
      backgroundColor: 'rgba(16,185,129,0.2)',
      fill: true,
      data: graphData.value.assignmentsOverTime.map(item => item.completed),
    },
  ],
}));

const barChartOptions = {
  responsive: true,
  plugins: {
    legend: { display: false },
  },
  scales: {
    y: { beginAtZero: true, max: 100 },
  },
};

const lineChartOptions = {
  responsive: true,
  plugins: {
    legend: { display: false },
  },
  scales: {
    y: { beginAtZero: true },
  },
};
</script>

<style scoped>
.bg-white.dark\:bg-slate-800 {
  transition: background 0.3s;
}
</style>
