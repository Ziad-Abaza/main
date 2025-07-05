<template>
  <div :class="['flex min-h-screen', isDark ? 'profile-bg-dark' : 'profile-bg-light']">
    <!-- Mobile Menu Overlay -->
    <div
      v-if="isMobileMenuOpen"
      @click="closeMobileMenu"
      class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
    ></div>

    <!-- Sidebar -->
    <aside
      :class="[
        'fixed md:relative inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 ease-in-out overflow-y-auto',
        isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
        isDark ? 'profile-sidebar-dark' : 'profile-sidebar-light',
      ]"
    >
      <!-- Mobile Close Button -->
      <div
        class="flex items-center justify-between p-4 md:hidden border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-inherit z-10"
      >
        <div class="text-xl font-bold">My Profile</div>
        <button
          @click="closeMobileMenu"
          class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors touch-manipulation"
          aria-label="Close menu"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            ></path>
          </svg>
        </button>
      </div>

      <!-- Desktop Header -->
      <div class="hidden md:block p-6 text-2xl font-bold">My Profile</div>

      <!-- Navigation -->
      <nav class="space-y-2 px-4 py-4 md:py-0">
        <button
          v-for="item in menu"
          :key="item.key"
          @click="goToTab(item)"
          :class="[
            currentTab === item.key
              ? isDark
                ? 'bg-gray-700 text-white'
                : 'bg-blue-100 text-blue-700'
              : isDark
              ? 'hover:bg-gray-700 text-gray-300'
              : 'hover:bg-blue-50 text-gray-700',
            'w-full text-left px-4 py-4 md:py-3 rounded-lg flex items-center justify-between cursor-pointer transition-all duration-200 touch-manipulation min-h-[44px]',
          ]"
        >
          <span class="flex items-center gap-3">
            <span v-if="item.icon" class="text-lg">{{ item.icon }}</span>
            <span class="font-medium">{{ item.label }}</span>
          </span>
          <span
            v-if="item.key === 'assignments' && store.pendingAssignmentsCount > 0"
            :class="[
              isDark ? 'bg-red-500 text-white' : 'bg-red-100 text-red-700',
              'text-xs font-bold px-2 py-1 rounded-full',
            ]"
          >
            {{ store.pendingAssignmentsCount }}
          </span>
        </button>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
      <!-- Mobile Header -->
      <div
        class="md:hidden flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-inherit z-10"
      >
        <button
          @click="openMobileMenu"
          class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors touch-manipulation"
          aria-label="Open menu"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            ></path>
          </svg>
        </button>
        <div class="text-xl font-bold">{{ currentComponent.__name }}</div>
        <div class="w-10"></div>
        <!-- Spacer for centering -->
      </div>

      <!-- Main Content Area -->
      <div
        class="flex-1 p-4 md:p-6"
        :class="[isDark ? 'profile-main-dark' : 'profile-main-light']"
      >
        <component v-if="validTab" :is="currentComponent" />
        <div v-else class="text-center text-2xl text-red-400 py-20">
          <span>404 - Page Not Found</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useLmsStore } from "@/stores/lms";
import OverviewSection from "../components/lms/OverviewSection.vue";
import CoursesSection from "../components/lms/CoursesSection.vue";
import QuizzesSection from "../components/lms/QuizzesSection.vue";
import AssignmentsSection from "../components/lms/AssignmentsSection.vue";
import { useRouter, useRoute } from "vue-router";
import { useTheme } from "../composables/useTheme";
import SettingsSection from "../views/LmsSettings.vue";

const { isDark } = useTheme();
const store = useLmsStore();
const router = useRouter();
const route = useRoute();

// Mobile menu state
const isMobileMenuOpen = ref(false);

const menu = [
  { key: "overview", label: "Overview", icon: "🏠" },
  { key: "courses", label: "My Courses", icon: "📚" },
  { key: "course-quizzes", label: "Course Quizzes", icon: "📝" },
  { key: "assignments", label: "Assignments", icon: "📂" },
  { key: "settings", label: "Settings", icon: "⚙️" },
];

const currentTab = computed(() => route.params.page || "overview");
const validTab = computed(() => menu.some((item) => item.key === currentTab.value));

const componentMap = {
  overview: OverviewSection,
  courses: CoursesSection,
  "course-quizzes": QuizzesSection,
  assignments: AssignmentsSection,
  settings: SettingsSection,
};

const currentComponent = computed(
  () => componentMap[currentTab.value] || OverviewSection
);

function goToTab(tab) {
  router.push(`/lms/${tab.key}`);
  // Close mobile menu when navigating
  closeMobileMenu();
}

function openMobileMenu() {
  isMobileMenuOpen.value = true;
  // Prevent body scroll when menu is open
  document.body.classList.add("menu-open");
}

function closeMobileMenu() {
  isMobileMenuOpen.value = false;
  // Restore body scroll
  document.body.classList.remove("menu-open");
}

// Handle escape key to close mobile menu
function handleEscapeKey(event) {
  if (event.key === "Escape" && isMobileMenuOpen.value) {
    closeMobileMenu();
  }
}

// Handle window resize
function handleResize() {
  if (window.innerWidth >= 768 && isMobileMenuOpen.value) {
    closeMobileMenu();
  }
}

onMounted(() => {
  store.fetchAssignments();
  document.addEventListener("keydown", handleEscapeKey);
  window.addEventListener("resize", handleResize);
});

onUnmounted(() => {
  document.removeEventListener("keydown", handleEscapeKey);
  window.removeEventListener("resize", handleResize);
  // Ensure body scroll is restored
  document.body.classList.remove("menu-open");
});
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
  box-shadow: 2px 0 8px rgba(0, 0, 0, 0.3);
}
.profile-sidebar-light {
  background: #fff;
  color: #1e293b;
  border-right: 1px solid #e5e7eb;
  box-shadow: 2px 0 8px 0 rgba(59, 130, 246, 0.03);
}
.profile-main-dark {
  background: transparent;
  color: #fff;
}
.profile-main-light {
  background: #fff;
  color: #1e293b;
  border-radius: 1rem;
  box-shadow: 0 2px 8px 0 rgba(59, 130, 246, 0.04);
}
.cursor-pointer {
  cursor: pointer;
}

/* Mobile optimizations */
@media (max-width: 768px) {
  .profile-sidebar-dark,
  .profile-sidebar-light {
    box-shadow: 4px 0 12px rgba(0, 0, 0, 0.4);
  }

  /* Improve touch targets on mobile */
  button {
    min-height: 44px;
    min-width: 44px;
  }

  /* Prevent horizontal scroll on mobile */
  .flex-1 {
    min-width: 0;
  }

  /* Better spacing for mobile */
  .p-4 {
    padding: 1rem;
  }
}

/* Prevent body scroll when mobile menu is open */
body.menu-open {
  overflow: hidden;
  position: fixed;
  width: 100%;
}

/* Smooth transitions */
.transition-transform {
  transition-property: transform;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}

/* Focus styles for accessibility */
button:focus {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}

button:focus-visible {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}

/* Dark mode focus styles */
.dark button:focus,
.dark button:focus-visible {
  outline-color: #60a5fa;
}
</style>
