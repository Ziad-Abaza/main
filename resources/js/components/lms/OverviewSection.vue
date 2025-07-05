<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
    >
        <!-- Header Section -->
        <div class="pt-16 pb-8 flex flex-col items-center relative">
            <!-- Floating particles background -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute w-2 h-2 bg-teal-400 rounded-full animate-pulse opacity-40"
                    style="top: 20%; left: 10%; animation-delay: 0s"
                ></div>
                <div
                    class="absolute w-1 h-1 bg-cyan-400 rounded-full animate-pulse opacity-30"
                    style="top: 60%; left: 85%; animation-delay: 1s"
                ></div>
                <div
                    class="absolute w-1.5 h-1.5 bg-purple-400 rounded-full animate-pulse opacity-40"
                    style="top: 40%; left: 20%; animation-delay: 2s"
                ></div>
            </div>

            <h2
                class="text-5xl md:text-6xl font-black mb-4 bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-500 bg-clip-text text-transparent drop-shadow-2xl tracking-tight text-center relative"
            >
                Learning Dashboard
            </h2>
            <div
                class="w-24 h-1 bg-gradient-to-r from-teal-400 to-purple-500 rounded-full"
            ></div>
        </div>

        <!-- Stats Cards Section -->
        <div class="px-6 mb-16">
            <div
                class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-7xl mx-auto"
            >
                <!-- Courses Card -->
                <div
                    :class="[
                        'group rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 relative overflow-hidden',
                        isDark
                            ? 'glass-card-premium border border-white/10'
                            : 'bg-white border border-teal-100 hover:shadow-2xl',
                    ]"
                >
                    <!-- Background gradient overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-teal-500/5 via-transparent to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                    ></div>

                    <div
                        class="flex items-center justify-between mb-8 relative z-10"
                    >
                        <div>
                            <h3
                                class="text-3xl font-black bg-gradient-to-r from-teal-500 to-cyan-500 bg-clip-text text-transparent mb-2"
                            >
                                Courses
                            </h3>
                            <div
                                class="w-16 h-0.5 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-full"
                            ></div>
                        </div>
                        <div
                            :class="
                                isDark
                                    ? 'p-4 bg-gradient-to-br from-teal-900 to-teal-800 rounded-2xl shadow-lg'
                                    : 'p-4 bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl shadow-lg'
                            "
                            class="group-hover:scale-110 transition-transform duration-300"
                        >
                            <svg
                                class="w-8 h-8 text-teal-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                />
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 relative z-10">
                        <div
                            :class="
                                isDark
                                    ? 'bg-gradient-to-br from-slate-800 to-slate-700 text-cyan-300 border border-slate-600/50'
                                    : 'bg-gradient-to-br from-slate-50 to-slate-100 text-cyan-700 border border-slate-200'
                            "
                            class="text-center p-6 rounded-2xl transform hover:scale-105 transition-all duration-300 shadow-lg"
                        >
                            <div class="text-4xl font-black mb-2">
                                {{ coursesStats.total }}
                            </div>
                            <div class="text-sm font-semibold opacity-80">
                                Total
                            </div>
                        </div>
                        <div
                            :class="
                                isDark
                                    ? 'bg-gradient-to-br from-green-900/30 to-green-800/30 text-green-400 border border-green-700/50'
                                    : 'bg-gradient-to-br from-green-50 to-green-100 text-green-700 border border-green-200'
                            "
                            class="text-center p-6 rounded-2xl transform hover:scale-105 transition-all duration-300 shadow-lg"
                        >
                            <div class="text-4xl font-black mb-2">
                                {{ coursesStats.completed }}
                            </div>
                            <div class="text-sm font-semibold opacity-80">
                                Completed
                            </div>
                        </div>
                        <div
                            :class="
                                isDark
                                    ? 'bg-gradient-to-br from-yellow-900/30 to-yellow-800/30 text-yellow-400 border border-yellow-700/50'
                                    : 'bg-gradient-to-br from-yellow-50 to-yellow-100 text-yellow-700 border border-yellow-200'
                            "
                            class="text-center p-6 rounded-2xl transform hover:scale-105 transition-all duration-300 shadow-lg"
                        >
                            <div class="text-4xl font-black mb-2">
                                {{ coursesStats.in_progress }}
                            </div>
                            <div class="text-sm font-semibold opacity-80">
                                In Progress
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assignments Card -->
                <div
                    :class="[
                        'group rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 relative overflow-hidden',
                        isDark
                            ? 'glass-card-premium border border-white/10'
                            : 'bg-white border border-purple-100 hover:shadow-2xl',
                    ]"
                >
                    <!-- Background gradient overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-500/5 via-transparent to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                    ></div>

                    <div
                        class="flex items-center justify-between mb-8 relative z-10"
                    >
                        <div>
                            <h3
                                class="text-3xl font-black bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent mb-2"
                            >
                                Assignments
                            </h3>
                            <div
                                class="w-16 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full"
                            ></div>
                        </div>
                        <div
                            :class="
                                isDark
                                    ? 'p-4 bg-gradient-to-br from-purple-900 to-purple-800 rounded-2xl shadow-lg'
                                    : 'p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl shadow-lg'
                            "
                            class="group-hover:scale-110 transition-transform duration-300"
                        >
                            <svg
                                class="w-8 h-8 text-purple-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 relative z-10">
                        <div
                            :class="
                                isDark
                                    ? 'bg-gradient-to-br from-slate-800 to-slate-700 text-purple-300 border border-slate-600/50'
                                    : 'bg-gradient-to-br from-slate-50 to-slate-100 text-purple-700 border border-slate-200'
                            "
                            class="text-center p-6 rounded-2xl transform hover:scale-105 transition-all duration-300 shadow-lg"
                        >
                            <div class="text-4xl font-black mb-2">
                                {{ assignmentsStats.total }}
                            </div>
                            <div class="text-sm font-semibold opacity-80">
                                Total
                            </div>
                        </div>
                        <div
                            :class="
                                isDark
                                    ? 'bg-gradient-to-br from-green-900/30 to-green-800/30 text-green-400 border border-green-700/50'
                                    : 'bg-gradient-to-br from-green-50 to-green-100 text-green-700 border border-green-200'
                            "
                            class="text-center p-6 rounded-2xl transform hover:scale-105 transition-all duration-300 shadow-lg"
                        >
                            <div class="text-4xl font-black mb-2">
                                {{ assignmentsStats.completed }}
                            </div>
                            <div class="text-sm font-semibold opacity-80">
                                Completed
                            </div>
                        </div>
                        <div
                            :class="
                                isDark
                                    ? 'bg-gradient-to-br from-yellow-900/30 to-yellow-800/30 text-yellow-400 border border-yellow-700/50'
                                    : 'bg-gradient-to-br from-yellow-50 to-yellow-100 text-yellow-700 border border-yellow-200'
                            "
                            class="text-center p-6 rounded-2xl transform hover:scale-105 transition-all duration-300 shadow-lg"
                        >
                            <div class="text-4xl font-black mb-2">
                                {{ assignmentsStats.pending }}
                            </div>
                            <div class="text-sm font-semibold opacity-80">
                                Pending
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="px-6 pb-16">
            <div
                class="grid grid-cols-1 xl:grid-cols-2 gap-8 max-w-7xl mx-auto"
            >
                <!-- Course Progress Chart -->
                <div
                    :class="[
                        'group rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:scale-105 hover:-translate-y-1 relative overflow-hidden',
                        isDark
                            ? 'glass-card-premium border border-white/10'
                            : 'bg-white border border-teal-100 hover:shadow-2xl',
                    ]"
                >
                    <!-- Background gradient overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-teal-500/5 via-transparent to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                    ></div>

                    <div
                        class="flex items-center justify-between mb-8 relative z-10"
                    >
                        <div>
                            <h3
                                class="text-2xl font-black text-cyan-700 dark:text-cyan-300 mb-2"
                            >
                                Course Progress Over Time
                            </h3>
                            <div
                                class="w-12 h-0.5 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-full"
                            ></div>
                        </div>
                        <div
                            :class="
                                isDark
                                    ? 'p-3 bg-gradient-to-br from-teal-900 to-teal-800 rounded-xl shadow-lg'
                                    : 'p-3 bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl shadow-lg'
                            "
                            class="group-hover:scale-110 transition-transform duration-300"
                        >
                            <svg
                                class="w-6 h-6 text-cyan-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                />
                            </svg>
                        </div>
                    </div>

                    <div class="relative z-10">
                        <BarChart
                            v-if="graphData.coursesProgress.length"
                            :chart-data="coursesProgressChartData"
                            :options="barChartOptions"
                        />
                    </div>
                </div>

                <!-- Assignments Progress Chart -->
                <div
                    :class="[
                        'group rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:scale-105 hover:-translate-y-1 relative overflow-hidden',
                        isDark
                            ? 'glass-card-premium border border-white/10'
                            : 'bg-white border border-purple-100 hover:shadow-2xl',
                    ]"
                >
                    <!-- Background gradient overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-500/5 via-transparent to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                    ></div>

                    <div
                        class="flex items-center justify-between mb-8 relative z-10"
                    >
                        <div>
                            <h3
                                class="text-2xl font-black text-purple-700 dark:text-purple-300 mb-2"
                            >
                                Assignments Completed Over Time
                            </h3>
                            <div
                                class="w-12 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full"
                            ></div>
                        </div>
                        <div
                            :class="
                                isDark
                                    ? 'p-3 bg-gradient-to-br from-purple-900 to-purple-800 rounded-xl shadow-lg'
                                    : 'p-3 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-lg'
                            "
                            class="group-hover:scale-110 transition-transform duration-300"
                        >
                            <svg
                                class="w-6 h-6 text-purple-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"
                                />
                            </svg>
                        </div>
                    </div>

                    <div class="relative z-10">
                        <LineChart
                            v-if="graphData.assignmentsOverTime.length"
                            :chart-data="assignmentsOverTimeChartData"
                            :options="lineChartOptions"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { useTheme } from "../../composables/useTheme";
// Chart.js for Vue 3 (vue-chart-3)
import { BarChart, LineChart } from "vue-chart-3";

const { isDark } = useTheme();

const coursesStats = ref({ total: 0, completed: 0, in_progress: 0 });
const assignmentsStats = ref({ total: 0, completed: 0, pending: 0 });
const graphData = ref({ coursesProgress: [], assignmentsOverTime: [] });

const fetchStats = async () => {
    const [coursesRes, assignmentsRes, graphRes] = await Promise.all([
        axios.get("/api/overview/courses-stats"),
        axios.get("/api/overview/assignments-stats"),
        axios.get("/api/overview/graph-data"),
    ]);
    coursesStats.value = coursesRes.data;
    assignmentsStats.value = assignmentsRes.data;
    graphData.value = graphRes.data;
};

onMounted(fetchStats);

const coursesProgressChartData = computed(() => ({
    labels: graphData.value.coursesProgress.map((item) => item.date),
    datasets: [
        {
            label: "Progress (%)",
            backgroundColor: "#6366f1",
            data: graphData.value.coursesProgress.map((item) => item.progress),
        },
    ],
}));

const assignmentsOverTimeChartData = computed(() => ({
    labels: graphData.value.assignmentsOverTime.map((item) => item.date),
    datasets: [
        {
            label: "Assignments Completed",
            borderColor: "#10b981",
            backgroundColor: "rgba(16,185,129,0.2)",
            fill: true,
            data: graphData.value.assignmentsOverTime.map(
                (item) => item.completed
            ),
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
.glass-card-premium {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

@keyframes pulse {
    0%,
    100% {
        opacity: 0.3;
    }
    50% {
        opacity: 0.8;
    }

}

.animate-pulse {
    animation: pulse 3s ease-in-out infinite;
}
</style>

