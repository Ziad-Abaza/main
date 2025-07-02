<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white">
      <!-- Animated background elements -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-20 left-1/3 w-60 h-60 bg-indigo-600/10 rounded-full blur-3xl animate-pulse delay-2000"></div>
      </div>

      <div class="container mx-auto px-6 py-12 relative z-10">
        <!-- Header Section -->
        <div class="text-center mb-16">
          <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500/20 to-purple-500/20 border border-blue-500/30 rounded-full backdrop-blur-sm mb-6">
            <span class="text-sm font-medium text-blue-300">🧑‍🏫 Expert Educators</span>
          </div>
          <h1 class="text-5xl md:text-6xl font-black mb-6">
            <span class="bg-gradient-to-r from-white via-blue-100 to-purple-100 bg-clip-text text-transparent">
              Meet Our Instructors
            </span>
          </h1>
          <p class="text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">
            Learn from
            <span class="text-blue-400 font-semibold">industry professionals</span>
            who bring real-world knowledge to every lesson
          </p>
        </div>

        <!-- Search Bar -->
        <div class="mb-12 max-w-2xl mx-auto">
          <div class="relative group">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-2xl blur-lg group-focus-within:blur-xl transition-all duration-300"></div>
            <div class="relative glass-card-premium rounded-2xl border border-white/20 group-focus-within:border-blue-500/50 transition-all duration-300">
              <input
                v-model="searchQuery"
                type="text"
                placeholder="Search instructors by name or specialization..."
                class="w-full p-6 bg-transparent text-white placeholder:text-white/50 focus:outline-none pl-14 pr-6 text-lg"
              />
              <font-awesome-icon
                icon="search"
                class="absolute left-5 top-1/2 transform -translate-y-1/2 text-blue-400 text-xl"
              />
              <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                <div class="px-3 py-1 bg-blue-500/20 rounded-lg text-xs text-blue-300 border border-blue-500/30">
                  {{ filteredInstructors.length }} found
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Loading state -->
        <div v-if="loading" class="text-center py-16">
          <div class="inline-flex items-center gap-3 text-slate-400">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
            <span class="text-lg">Loading instructors...</span>
          </div>
        </div>

        <!-- Error state -->
        <div v-else-if="error" class="text-center py-16 glass-card-premium rounded-2xl p-8 border border-red-500/20">
          <div class="text-red-400 text-lg font-semibold">{{ error }}</div>
          <button
            @click="fetchInstructors"
            class="mt-4 px-4 py-2 bg-blue-500/20 hover:bg-blue-500/30 rounded-lg text-sm text-blue-300 transition-colors"
          >
            Try Again
          </button>
        </div>

        <!-- Instructors Grid -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
          <!-- Instructor Card -->
          <div
            v-for="instructor in paginatedInstructors"
            :key="instructor.id"
            class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2"
          >
            <div class="glass-card-premium rounded-3xl shadow-2xl overflow-hidden border border-white/10 h-full flex flex-col backdrop-blur-xl hover:shadow-blue-500/20 hover:border-blue-500/30 transition-all duration-500">
              <!-- Instructor image -->
              <div class="relative p-6 bg-gradient-to-br from-blue-500/10 to-purple-500/10">
                <img
                  :src="instructor.image"
                  :alt="instructor.name"
                  @error="$event.target.src = defaultAvatar"
                  class="w-32 h-32 mx-auto rounded-full border-4 border-slate-800 object-cover shadow-lg"
                />
                <div class="absolute top-6 right-6">
                  <div class="flex gap-2">
                    <a v-if="instructor.linkedinUrl" :href="instructor.linkedinUrl" target="_blank" rel="noopener noreferrer"
                       class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center hover:bg-blue-500 transition-colors">
                      <font-awesome-icon :icon="['fab', 'linkedin-in']" class="text-white text-xs" />
                    </a>
                    <a v-if="instructor.githubUrl" :href="instructor.githubUrl" target="_blank" rel="noopener noreferrer"
                       class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-gray-700 transition-colors">
                      <font-awesome-icon :icon="['fab', 'github']" class="text-white text-xs" />
                    </a>
                  </div>
                </div>
                <div v-if="instructor.statistics.coursesCount > 0" class="absolute bottom-6 left-0 right-0 text-center">
                  <div class="inline-flex items-center gap-2 bg-white/5 px-3 py-1 rounded-full">
                    <font-awesome-icon icon="chalkboard-teacher" class="text-blue-400" />
                    <span class="text-sm text-white">{{ instructor.statistics.coursesCount }} {{ instructor.statistics.coursesCount === 1 ? 'Course' : 'Courses' }}</span>
                  </div>
                </div>
              </div>

              <!-- Instructor content -->
              <div class="p-6 flex-1 flex flex-col">
                <!-- Name -->
                <h3 class="text-xl font-bold mb-1 text-white line-clamp-1 text-center">{{ instructor.name }}</h3>

                <!-- Specialization -->
                <p class="text-blue-400 font-medium mb-2 text-center">{{ instructor.specialization }}</p>

                <!-- Experience -->
                <div class="flex items-center justify-center gap-1.5 mb-4 text-slate-400 text-sm text-center">
                  <font-awesome-icon icon="briefcase" />
                  <span>{{ instructor.experience }} of experience</span>
                </div>

                <!-- Bio -->
                <p class="text-slate-300 text-sm mb-6 line-clamp-2 text-center">{{ instructor.bio }}</p>

                <!-- Instructor stats -->
                <div class="grid grid-cols-3 gap-4 mt-auto pt-4 border-t border-slate-700">
                  <div class="text-center">
                    <div class="text-lg font-bold text-white">{{ instructor.statistics.coursesCount }}</div>
                    <div class="text-xs text-slate-400">Courses</div>
                  </div>
                  <div class="text-center">
                    <div class="text-lg font-bold text-white">{{ instructor.statistics.totalStudents }}</div>
                    <div class="text-xs text-slate-400">Students</div>
                  </div>
                  <div class="text-center">
                    <div class="text-lg font-bold text-white">{{ instructor.statistics.totalVideos }}</div>
                    <div class="text-xs text-slate-400">Videos</div>
                  </div>
                </div>

                <!-- View Profile Button -->
                <router-link
                  :to="`/instructors/${instructor.id}`"
                  class="mt-6 inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-medium rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 shadow-md hover:shadow-blue-500/20"
                >
                  View Profile
                  <font-awesome-icon icon="arrow-right" class="ml-2" />
                </router-link>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mb-16">
          <div class="glass-card-premium p-4 rounded-2xl shadow-2xl border border-white/20">
            <nav class="flex items-center gap-2">
              <!-- Previous Button -->
              <button
                @click="goToPage(currentPage - 1)"
                :disabled="currentPage === 1"
                class="group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-xl hover:from-blue-500 hover:to-indigo-600 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <font-awesome-icon icon="chevron-left" class="text-sm group-hover:-translate-x-1 transition-transform duration-300" />
                <span class="font-medium">Previous</span>
              </button>

              <!-- Page Numbers -->
              <div class="flex items-center gap-1 mx-4">
                <button
                  v-for="page in visiblePages"
                  :key="page"
                  @click="goToPage(page)"
                  :class="{
                    'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg': currentPage === page,
                    'text-slate-400 hover:text-white hover:bg-white/10': currentPage !== page
                  }"
                  class="w-12 h-12 rounded-xl flex items-center justify-center font-semibold transition-all duration-300 hover:scale-105"
                >
                  {{ page }}
                </button>
              </div>

              <!-- Next Button -->
              <button
                @click="goToPage(currentPage + 1)"
                :disabled="currentPage === totalPages"
                class="group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-700 to-blue-600 text-white rounded-xl hover:from-indigo-600 hover:to-blue-500 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span class="font-medium">Next</span>
                <font-awesome-icon icon="chevron-right" class="text-sm group-hover:translate-x-1 transition-transform duration-300" />
              </button>
            </nav>
          </div>
        </div>

        <!-- Call to Action -->
        <section class="text-center glass-card-premium p-12 rounded-3xl shadow-2xl border border-white/10 relative overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-purple-600/5"></div>
          <div class="relative z-10">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-2xl">
              <font-awesome-icon icon="chalkboard-teacher" class="text-white text-2xl" />
            </div>
            <h2 class="text-4xl font-bold mb-4 bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
              Want to Become an Instructor?
            </h2>
            <p class="text-slate-300 mb-8 text-lg max-w-2xl mx-auto leading-relaxed">
              Join our community of expert instructors and share your knowledge with
              <span class="text-blue-400 font-semibold">learners worldwide</span>
            </p>
            <button class="group px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 rounded-2xl font-semibold transition-all duration-300 shadow-lg hover:shadow-blue-500/25 hover:scale-105 transform">
              <span class="flex items-center gap-3">
                Apply Now
                <font-awesome-icon icon="arrow-right" class="group-hover:translate-x-1 transition-transform duration-300" />
              </span>
            </button>
          </div>
        </section>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed, onMounted } from 'vue';
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
  import { library } from '@fortawesome/fontawesome-svg-core';
  import { faChevronLeft, faChevronRight, faChalkboardTeacher, faBriefcase } from '@fortawesome/free-solid-svg-icons';
  import { faLinkedinIn, faGithub } from '@fortawesome/free-brands-svg-icons';
  import { useInstructorStore } from '@/stores/InstructorStore';

  // Add icons to library
  library.add(faChevronLeft, faChevronRight, faChalkboardTeacher, faBriefcase, faLinkedinIn, faGithub);

  const instructorStore = useInstructorStore();
  const currentPage = ref(1);
  const itemsPerPage = ref(9);
  const searchQuery = ref('');
  const loading = ref(true);
  const error = ref(null);
  const defaultAvatar = ref('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIHJ4PSI1MCIgZmlsbD0iIzRCNzY4OCIvPjxjaXJjbGUgY3g9IjUwIiBjeT0iNDAiIHI9IjE1IiBmaWxsPSJ3aGl0ZSIgZmlsbC1vcGFjaXR5PSIwLjgiLz48cGF0aCBkPSJNMjUgNzVjMC0xMy44IDExLjItMjUgMjUtMjVzMjUgMTEuMiAyNSAyNXYxMEgyNVY3NXoiIGZpbGw9IndoaXRlIiBmaWxsLW9wYWNpdHk9IjAuOCIvPjwvc3ZnPg==');

  // Computed properties
  const filteredInstructors = computed(() => {
    const query = searchQuery.value.toLowerCase();
    return instructorStore.instructors.filter(
      (instructor) =>
        instructor.name.toLowerCase().includes(query) ||
        instructor.specialization.toLowerCase().includes(query) ||
        instructor.bio.toLowerCase().includes(query)
    );
  });

  const totalPages = computed(() => Math.ceil(filteredInstructors.value.length / itemsPerPage.value));

  const paginatedInstructors = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return filteredInstructors.value.slice(start, start + itemsPerPage.value);
  });

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

  // Methods
  const fetchInstructors = async () => {
    loading.value = true;
    try {
      await instructorStore.fetchInstructors(currentPage.value, itemsPerPage.value);
      loading.value = false;
    } catch (err) {
      error.value = "Failed to load instructors. Please try again later.";
      loading.value = false;
    }
  };

  const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
      currentPage.value = page;
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  };

  // Lifecycle
  onMounted(async () => {
    await fetchInstructors();
  });
  </script>

  <style scoped>
  .glass-card-premium {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
  }

  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
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
  </style>
