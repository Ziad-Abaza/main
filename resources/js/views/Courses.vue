<template>
    <div :class="[
        'min-h-screen transition-colors duration-500',
        isDark
            ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white'
            : 'bg-gradient-to-br from-slate-100 via-blue-100 to-purple-100 text-slate-900'
    ]">
      <!-- Animated background -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div :class="[
            'absolute top-20 left-10 w-72 h-72 rounded-full blur-3xl animate-pulse',
            isDark ? 'bg-blue-600/10' : 'bg-blue-600/20'
        ]"></div>
        <div :class="[
            'absolute top-40 right-20 w-80 h-80 rounded-full blur-3xl animate-pulse delay-1000',
            isDark ? 'bg-purple-600/10' : 'bg-purple-600/20'
        ]"></div>
        <div :class="[
            'absolute bottom-20 left-1/3 w-60 h-60 rounded-full blur-3xl animate-pulse delay-2000',
            isDark ? 'bg-indigo-600/10' : 'bg-indigo-600/20'
        ]"></div>
      </div>

      <div class="container mx-auto px-6 py-12 relative z-10">
        <!-- Back button -->
        <div v-if="hasQuery" class="mb-8">
          <button @click="resetFilters"
            :class="[
                'group inline-flex items-center gap-3 px-6 py-3 rounded-xl border transition-all duration-300 hover:scale-105',
                isDark
                    ? 'glass-card-premium border-white/20 hover:border-blue-500/50'
                    : 'bg-white/50 border-slate-200/50 hover:border-blue-500/50 hover:bg-white/70'
            ]">
            <font-awesome-icon icon="arrow-left" class="group-hover:-translate-x-1 transition-transform duration-300" />
            <span class="font-medium">Back to All Courses</span>
          </button>
        </div>

        <!-- Header section -->
        <div class="text-center mb-16">
          <div :class="[
              'inline-flex items-center px-4 py-2 border rounded-full backdrop-blur-sm mb-6',
              isDark
                  ? 'bg-gradient-to-r from-blue-500/20 to-purple-500/20 border-blue-500/30'
                  : 'bg-gradient-to-r from-blue-500/10 to-purple-500/10 border-blue-500/20'
          ]">
            <span :class="[
                'text-sm font-medium',
                isDark ? 'text-blue-300' : 'text-blue-700'
            ]">🎓 Discover Knowledge</span>
          </div>
          <h1 class="text-5xl md:text-6xl font-black mb-6">
            <span :class="[
                'bg-clip-text text-transparent',
                isDark
                    ? 'bg-gradient-to-r from-white via-blue-100 to-purple-100'
                    : 'bg-gradient-to-r from-slate-900 via-blue-900 to-purple-900'
            ]">
              Course Library
            </span>
          </h1>
          <p :class="[
              'text-xl max-w-2xl mx-auto leading-relaxed',
              isDark ? 'text-slate-300' : 'text-slate-600'
          ]">
            Explore our curated collection of
            <span :class="[
                'font-semibold',
                isDark ? 'text-blue-400' : 'text-blue-600'
            ]">premium courses</span>
            designed to accelerate your career growth
          </p>
        </div>

        <!-- Search bar -->
        <div class="mb-12 max-w-2xl mx-auto">
          <div class="relative group">
            <div :class="[
                'absolute inset-0 rounded-2xl blur-lg group-focus-within:blur-xl transition-all duration-300',
                isDark ? 'bg-gradient-to-r from-blue-600/20 to-purple-600/20' : 'bg-gradient-to-r from-blue-600/10 to-purple-600/10'
            ]"></div>
            <div :class="[
                'relative rounded-2xl border group-focus-within:border-blue-500/50 transition-all duration-300',
                isDark
                    ? 'glass-card-premium border-white/20'
                    : 'bg-white/50 border-slate-200/50 group-focus-within:bg-white/70'
            ]">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search for courses, instructors, or topics..."
                :class="[
                    'w-full p-6 bg-transparent placeholder:text-black focus:outline-none pl-14 pr-6 text-lg',
                    isDark ? 'text-white placeholder:text-black' : 'text-slate-900 placeholder:text-slate-500'
                ]"
              />
              <font-awesome-icon
                icon="search"
                :class="[
                    'absolute left-5 top-1/2 transform -translate-y-1/2 text-xl',
                    isDark ? 'text-blue-400' : 'text-blue-600'
                ]"
              />
              <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                <div :class="[
                    'px-3 py-1 rounded-lg text-xs border',
                    isDark
                        ? 'bg-blue-500/20 text-blue-300 border-blue-500/30'
                        : 'bg-blue-500/10 text-blue-700 border-blue-500/20'
                ]">
                  {{ filteredCourses.length }} found
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Loading and error states -->
        <div v-if="loading" class="text-center py-16">
          <div :class="[
              'inline-flex items-center space-x-3',
              isDark ? 'text-slate-400' : 'text-slate-600'
          ]">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
            <span class="text-lg">Loading courses...</span>
          </div>
        </div>

        <div v-else-if="error" :class="[
            'text-center py-16 rounded-2xl p-8 border',
            isDark
                ? 'glass-card-premium border-red-500/20'
                : 'bg-white/50 border-red-500/20'
        ]">
          <div class="text-red-400 text-lg font-semibold">{{ error }}</div>
          <button @click="mounted" :class="[
              'mt-4 px-4 py-2 rounded-lg text-sm transition-colors',
              isDark
                  ? 'bg-blue-500/20 hover:bg-blue-500/30 text-blue-300'
                  : 'bg-blue-500/10 hover:bg-blue-500/20 text-blue-700'
          ]">
            Try Again
          </button>
        </div>

        <!-- Course grid -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Course card -->
          <router-link
            v-for="course in paginatedCourses"
            :key="course.id"
            :to="`/courses/${course.id}`"
            class="block group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2"
          >
            <div :class="[
                'rounded-3xl shadow-2xl overflow-hidden border h-full flex flex-col backdrop-blur-xl hover:shadow-blue-500/20 hover:border-blue-500/30 transition-all duration-500',
                isDark
                    ? 'glass-card-premium border-white/10'
                    : 'bg-white/50 border-slate-200/50 hover:bg-white/70'
            ]">
              <!-- Course image -->
              <div class="relative">
                <img
                  :src="course.image"
                  :alt="course.title"
                  class="w-full h-48 object-cover"
                />
                <!-- Discount badge -->
                <div v-if="course.pricing.discountPercentage > 0 && course.pricing.isActiveDiscount" class="absolute top-4 right-4 bg-orange-500 text-white text-xs px-3 py-1 rounded-full font-bold">
                  {{ course.pricing.discountPercentage }}% OFF
                </div>
              </div>

              <!-- Course content -->
              <div class="p-6 flex-1 flex flex-col">
                <!-- Course title -->
                <h3 :class="[
                    'text-xl font-bold mb-2 line-clamp-2 transition-colors duration-300',
                    isDark
                        ? 'text-white group-hover:text-blue-400'
                        : 'text-slate-800 group-hover:text-blue-600'
                ]">
                  {{ course.title }}
                </h3>

                <!-- Course description -->
                <p :class="[
                    'mb-4 line-clamp-2 text-sm',
                    isDark ? 'text-slate-300' : 'text-slate-600'
                ]">
                  {{ course.description }}
                </p>

                <!-- Instructor info -->
                <div class="flex items-center gap-2 mt-4 text-xs">
                  <div class="w-6 h-6 rounded-full overflow-hidden border border-white/20">
                    <img
                      :src="course.instructorImage"
                      :alt="course.instructor"
                      @error="$event.target.src = defaultImage"
                      class="w-full h-full object-cover"
                    />
                  </div>
                  <span :class="[
                      isDark ? 'text-slate-400' : 'text-slate-500'
                  ]">{{ course.instructor }}</span>
                </div>

                <!-- Course meta -->
                <div class="grid grid-cols-2 gap-2 mt-4 text-sm">
                  <div class="flex items-center gap-1.5">
                    <font-awesome-icon :icon="['fas', 'chalkboard-teacher']" :class="[
                        isDark ? 'text-blue-400' : 'text-blue-600'
                    ]" />
                    <span :class="[
                        isDark ? 'text-slate-400' : 'text-slate-500'
                    ]">{{ course.category }}</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <font-awesome-icon :icon="['fas', 'video']" :class="[
                        isDark ? 'text-purple-400' : 'text-purple-600'
                    ]" />
                    <span :class="[
                        isDark ? 'text-slate-400' : 'text-slate-500'
                    ]">{{ course.videoCount }} {{ course.videoCount === 1 ? 'Lesson' : 'Lessons' }}</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <font-awesome-icon :icon="['fas', 'clock']" :class="[
                        isDark ? 'text-indigo-400' : 'text-indigo-600'
                    ]" />
                    <span :class="[
                        isDark ? 'text-slate-400' : 'text-slate-500'
                    ]">{{ course.details.durationMinutes }} min</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <font-awesome-icon :icon="['fas', 'user-friends']" :class="[
                        isDark ? 'text-emerald-400' : 'text-emerald-600'
                    ]" />
                    <span :class="[
                        isDark ? 'text-slate-400' : 'text-slate-500'
                    ]" v-if="course.enrollment.maxStudents > 0">
                      {{ course.enrollment.currentStudents }}/{{ course.enrollment.maxStudents }}
                    </span>
                    <span :class="[
                        isDark ? 'text-slate-400' : 'text-slate-500'
                    ]" v-else>Unlimited</span>
                  </div>
                </div>

                <!-- Price info -->
                <div class="mt-6 flex items-center justify-between">
                  <div v-if="course.pricing.discountedPrice > 0 && course.pricing.isActiveDiscount" :class="[
                      'font-bold text-lg',
                      isDark ? 'text-white' : 'text-slate-800'
                  ]">
                    ${{ course.pricing.discountedPrice }}
                    <span :class="[
                        'ml-2 text-sm line-through',
                        isDark ? 'text-slate-400' : 'text-slate-500'
                    ]">${{ course.pricing.originalPrice }}</span>
                  </div>
                  <div v-else :class="[
                      'font-bold text-lg',
                      isDark ? 'text-white' : 'text-slate-800'
                  ]">
                    ${{ course.pricing.originalPrice }}
                  </div>

                  <button class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 rounded-lg text-sm text-white transition-all duration-300 transform hover:scale-105">
                    View Details
                  </button>
                </div>
              </div>
            </div>
          </router-link>
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
          <div :class="[
              'p-4 rounded-2xl shadow-2xl border',
              isDark
                  ? 'glass-card-premium border-white/20'
                  : 'bg-white/50 border-slate-200/50'
          ]">
            <nav class="flex items-center gap-2">
              <!-- Previous Button -->
              <button
                @click="goToPage(currentPage - 1)"
                :disabled="currentPage === 1"
                class="group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-500 hover:to-indigo-600 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 shadow-lg"
              >
                <font-awesome-icon icon="chevron-left" class="text-sm group-hover:-translate-x-1 transition-transform duration-300" />
                <span class="font-medium">Previous</span>
              </button>

              <!-- Page numbers -->
              <div class="flex items-center gap-1 mx-4">
                <button
                  v-for="page in visiblePages"
                  :key="page"
                  @click="goToPage(page)"
                  :class="[
                      'w-12 h-12 rounded-xl flex items-center justify-center font-semibold transition-all duration-300 hover:scale-105',
                      {
                        'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg': currentPage === page,
                        'hover:bg-white/10': currentPage !== page
                      },
                      currentPage !== page && (isDark ? 'text-slate-400 hover:text-white' : 'text-slate-600 hover:text-slate-800')
                  ]"
                >
                  {{ page }}
                </button>
              </div>

              <!-- Next Button -->
              <button
                @click="goToPage(currentPage + 1)"
                :disabled="currentPage === totalPages"
                class="group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-700 to-blue-600 text-white rounded-xl hover:from-indigo-600 hover:to-blue-500 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 shadow-lg"
              >
                <span class="font-medium">Next</span>
                <font-awesome-icon icon="chevron-right" class="text-sm group-hover:translate-x-1 transition-transform duration-300" />
              </button>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed, watch } from 'vue';
  import { useCourseStore } from '@/stores/coursesStore';
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
  import { library } from '@fortawesome/fontawesome-svg-core';
  import defaultImage from '@/assets/icons/EduStream.jpg';
  import {
    faChevronLeft, faChevronRight, faSearch, faChalkboardTeacher,
    faVideo, faClock, faUserFriends, faArrowLeft
  } from '@fortawesome/free-solid-svg-icons';
  import { useRoute, useRouter } from 'vue-router';
  import { useTheme } from '../composables/useTheme';

  library.add(faChevronLeft, faChevronRight, faSearch, faChalkboardTeacher, faVideo, faClock, faUserFriends, faArrowLeft);

  const coursesStore = useCourseStore();
  const currentPage = ref(1);
  const itemsPerPage = ref(9);
  const route = useRoute();
  const router = useRouter();
  const { isDark } = useTheme();

  const category = route.query.category;
  const search = route.query.search;
  const searchQuery = ref(search || '');
  const hasQuery = computed(() => !!route.query.search || !!route.query.category);
  const loading = ref(false);
  const error = ref(null);

  // Reset filters and go back to main courses page
  const resetFilters = () => {
    searchQuery.value = '';
    currentPage.value = 1;
    router.push({ path: '/courses' });
    fetchCourses();
  };

  // Watch for changes in the search query
  watch(searchQuery, (newVal) => {
    router.push({
      query: {
        ...route.query,
        search: newVal || undefined,
      }
    });
  });

  // Watch for changes in the route query
  watch(
    () => route.query,
    (newQuery) => {
      if (newQuery.search !== searchQuery.value) {
        searchQuery.value = newQuery.search || '';
      }
      fetchCourses();
    }
  );

  // Filter courses based on search query
  const filteredCourses = computed(() => {
    const query = searchQuery.value.toLowerCase();
    return coursesStore.courses.filter(
      (course) =>
        course.title.toLowerCase().includes(query) ||
        course.instructor.toLowerCase().includes(query) ||
        course.category.toLowerCase().includes(query)
    );
  });

  // Calculate total pages
  const totalPages = computed(() => Math.ceil(filteredCourses.value.length / itemsPerPage.value));

  // Get paginated courses
  const paginatedCourses = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return filteredCourses.value.slice(start, start + itemsPerPage.value);
  });

  // Calculate visible page numbers
  const visiblePages = computed(() => {
    const pages = [];
    const maxVisible = 5;
    let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2));
    let end = Math.min(totalPages.value, start + maxVisible - 1);

    if (end - start + 1 < maxVisible) {
      start = Math.max(1, end - maxVisible + 1);
    }

    for (let i = start; i <= end; i++) {
      pages.push(i);
    }
    return pages;
  });

  // Fetch courses from the store
  const fetchCourses = async () => {
    loading.value = true;
    error.value = null;

    try {
      await coursesStore.fetchCourses(
        currentPage.value,
        itemsPerPage.value,
        route.query.category,
        searchQuery.value
      );
    } catch (err) {
      console.error("Error fetching courses:", err);
      error.value = "Failed to load courses. Please try again later.";
    } finally {
      loading.value = false;
    }
  };

  // Navigate to specific page
  const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
      currentPage.value = page;
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  };

  // Mounted hook to fetch initial data
  const mounted = async () => {
    await fetchCourses();
  };

  mounted();
  </script>

  <style scoped>
  .glass-card-premium {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1);
  }

  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  @keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    33% { transform: translateY(-10px) rotate(1deg); }
    66% { transform: translateY(5px) rotate(-1deg); }
  }

  @media (max-width: 768px) {
    .glass-card-premium {
      backdrop-filter: blur(15px);
    }
    .text-5xl { font-size: 2.5rem; }
    .text-6xl { font-size: 3rem; }
  }

  button:focus,
  a:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }

  .animate-spin {
    animation: spin 1s linear infinite;
  }

  .shadow-glow {
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
  }

  .text-shadow {
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
  }

  button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  }

  .glass-card-premium:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
  }
  </style>
