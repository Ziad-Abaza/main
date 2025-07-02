<template>
    <div class="flex min-h-screen bg-gray-900 text-white">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 flex-shrink-0 hidden md:block">
            <div class="p-6 text-2xl font-bold">My Profile</div>
            <nav class="space-y-2 px-4">
                <button v-for="item in menu" :key="item.key" @click="currentTab = item.key"
                    :class="[currentTab === item.key ? 'bg-gray-700' : 'hover:bg-gray-700', 'w-full text-left px-4 py-2 rounded-lg flex items-center justify-between']">
                    <span>{{ item.label }}</span>
                    <span v-if="item.key === 'assignments' && store.pendingAssignmentsCount > 0"
                        class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                        {{ store.pendingAssignmentsCount }}
                    </span>
                </button>
            </nav>
        </aside>

        <!-- Main -->
        <div class="flex-1 p-6">
            <component :is="currentComponent" />
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useProfileStore } from '@/stores/profile';
import OverviewSection from '../components/profile/OverviewSection.vue';
import CoursesSection from '../components/profile/CoursesSection.vue';
import QuizzesSection from '../components/profile/QuizzesSection.vue';
import AssignmentsSection from '../components/profile/AssignmentsSection.vue';

const store = useProfileStore();

const menu = [
    { key: 'overview', label: 'Overview' },
    { key: 'courses', label: 'My Courses' },
    { key: 'quizzes', label: 'My Quizzes' },
    { key: 'assignments', label: 'Assignments' }
];

const currentTab = ref('overview');

const componentMap = {
    overview: OverviewSection,
    courses: CoursesSection,
    quizzes: QuizzesSection,
    assignments: AssignmentsSection
};

const currentComponent = computed(() => componentMap[currentTab.value]);

const mounted = () => {
    store.fetchAssignments();
};

mounted();
</script>

<style scoped>
/* nothing yet */
</style>
