<template>
    <div :class="['flex min-h-screen', isDark ? 'profile-bg-dark' : 'profile-bg-light']">
        <!-- Sidebar -->
        <aside :class="['w-64 flex-shrink-0 hidden md:block', isDark ? 'profile-sidebar-dark' : 'profile-sidebar-light']">
            <div class="p-6 text-2xl font-bold">My Profile</div>
            <nav class="space-y-2 px-4">
                <button v-for="item in menu" :key="item.key" @click="goToTab(item)"
                    :class="[currentTab === item.key ? (isDark ? 'bg-gray-700' : 'bg-blue-100 text-blue-700') : (isDark ? 'hover:bg-gray-700' : 'hover:bg-blue-50'), 'w-full text-left px-4 py-2 rounded-lg flex items-center justify-between cursor-pointer transition']">
                    <span class="flex items-center gap-2">
                      <span v-if="item.icon">{{ item.icon }}</span>
                      {{ item.label }}
                    </span>
                    <span v-if="item.key === 'assignments' && store.pendingAssignmentsCount > 0"
                        :class="[isDark ? 'bg-red-500 text-white' : 'bg-red-100 text-red-700', 'text-xs font-bold px-2 py-1 rounded-full']">
                        {{ store.pendingAssignmentsCount }}
                    </span>
                </button>
            </nav>
        </aside>

        <!-- Main -->
        <div class="flex-1 p-6" :class="[isDark ? 'profile-main-dark' : 'profile-main-light']">
            <component v-if="validTab" :is="currentComponent" />
            <div v-else class="text-center text-2xl text-red-400 py-20">
                <span>404 - Page Not Found</span>
            </div>
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
import { useRouter, useRoute } from 'vue-router';
import { useTheme } from '../composables/useTheme';

const { isDark } = useTheme();
const store = useProfileStore();
const router = useRouter();
const route = useRoute();

const menu = [
    { key: 'overview', label: 'Overview', icon: '🏠' },
    { key: 'courses', label: 'My Courses', icon: '📚' },
    { key: 'course-quizzes', label: 'Course Quizzes', icon: '📝' },
    { key: 'assignments', label: 'Assignments', icon: '📂' }
];

const currentTab = computed(() => route.params.page || 'overview');
const validTab = computed(() => menu.some(item => item.key === currentTab.value));

const componentMap = {
    overview: OverviewSection,
    courses: CoursesSection,
    'course-quizzes': QuizzesSection,
    assignments: AssignmentsSection
};

const currentComponent = computed(() => componentMap[currentTab.value] || OverviewSection);

function goToTab(tab) {
    router.push(`/profile/${tab.key}`);
}

const mounted = () => {
    store.fetchAssignments();
};

mounted();
</script>

<style scoped>
.profile-bg-dark {
  background: #111827;
  color: #fff;
}
.profile-bg-light {
  background: #f8fafc;
  color: #1e293b;
}
.profile-sidebar-dark {
  background: #1f2937;
  color: #fff;
}
.profile-sidebar-light {
  background: #fff;
  color: #1e293b;
  border-right: 1px solid #e5e7eb;
  box-shadow: 2px 0 8px 0 rgba(59,130,246,0.03);
}
.profile-main-dark {
  background: transparent;
  color: #fff;
}
.profile-main-light {
  background: #fff;
  color: #1e293b;
  border-radius: 1rem;
  box-shadow: 0 2px 8px 0 rgba(59,130,246,0.04);
}
.cursor-pointer {
  cursor: pointer;
}
</style>
