<template>
  <div
    :class="isDark ? 'text-white' : 'text-slate-800'"
    class="relative min-h-screen overflow-x-hidden"
  >
    <!-- Unique Animated Background -->
    <div class="absolute inset-0">
      <!-- Flowing Waves -->
      <div
        :class="
          isDark
            ? 'absolute top-0 left-0 w-full h-16 sm:h-32 bg-gradient-to-b from-teal-500/20 to-transparent transform -skew-y-6'
            : 'absolute top-0 left-0 w-full h-16 sm:h-32 bg-gradient-to-b from-teal-400/30 to-transparent transform -skew-y-6'
        "
      ></div>
      <div
        :class="
          isDark
            ? 'absolute top-10 sm:top-20 right-0 w-full h-12 sm:h-24 bg-gradient-to-b from-purple-500/15 to-transparent transform skew-y-3'
            : 'absolute top-10 sm:top-20 right-0 w-full h-12 sm:h-24 bg-gradient-to-b from-purple-400/25 to-transparent transform skew-y-3'
        "
      ></div>
      <div
        :class="
          isDark
            ? 'absolute bottom-0 left-0 w-full h-20 sm:h-40 bg-gradient-to-t from-cyan-500/20 to-transparent transform skew-y-6'
            : 'absolute bottom-0 left-0 w-full h-20 sm:h-40 bg-gradient-to-t from-cyan-400/30 to-transparent transform skew-y-6'
        "
      ></div>

      <!-- Geometric Pattern -->
      <div class="absolute inset-0 opacity-10">
        <div
          v-for="i in 15"
          :key="i"
          :class="[
            'absolute rounded-full',
            isDark
              ? 'bg-gradient-to-r from-teal-400/20 to-cyan-400/20'
              : 'bg-gradient-to-r from-teal-500/30 to-cyan-500/30',
          ]"
          :style="{
            width: `${20 + i * 5}px`,
            height: `${20 + i * 5}px`,
            top: `${Math.random() * 100}%`,
            left: `${Math.random() * 100}%`,
            animationDelay: `${i * 0.2}s`,
          }"
        ></div>
      </div>
    </div>

    <!-- Header Section -->
    <div class="mb-8 sm:mb-16 relative z-10 px-4 sm:px-6 py-8 sm:py-12">
      <div class="text-center mb-8 sm:mb-12">
        <div class="relative inline-block mb-6 sm:mb-8">
          <div
            :class="
              isDark
                ? 'absolute inset-0 bg-gradient-to-r from-teal-500 to-purple-500 rounded-full blur-xl opacity-30'
                : 'absolute inset-0 bg-gradient-to-r from-teal-400 to-purple-400 rounded-full blur-xl opacity-40'
            "
          ></div>
          <div
            :class="
              isDark
                ? 'relative px-4 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-teal-500/20 to-purple-500/20 border border-teal-400/30 rounded-full backdrop-blur-sm'
                : 'relative px-4 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-teal-200/60 to-purple-200/60 border border-teal-300/50 rounded-full backdrop-blur-sm'
            "
          >
            <span
              :class="
                isDark
                  ? 'text-sm sm:text-lg font-bold text-teal-300'
                  : 'text-sm sm:text-lg font-bold text-teal-700'
              "
            >
              📚 My Learning Journey
            </span>
          </div>
        </div>

        <h2
          class="text-3xl sm:text-5xl md:text-6xl lg:text-8xl font-black mb-6 sm:mb-8 relative px-4"
        >
          <span
            :class="
              isDark
                ? 'bg-gradient-to-r from-white via-teal-200 to-purple-200 bg-clip-text text-transparent'
                : 'bg-gradient-to-r from-slate-900 via-teal-700 to-purple-700 bg-clip-text text-transparent'
            "
          >
            My
          </span>
          <br />
          <span
            :class="
              isDark
                ? 'bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-400 bg-clip-text text-transparent'
                : 'bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500 bg-clip-text text-transparent'
            "
          >
            Courses
          </span>
        </h2>

        <div
          :class="
            isDark
              ? 'w-20 sm:w-32 h-1 bg-gradient-to-r from-teal-500 to-purple-500 mx-auto mb-6 sm:mb-8 rounded-full'
              : 'w-20 sm:w-32 h-1 bg-gradient-to-r from-teal-500 to-purple-500 mx-auto mb-6 sm:mb-8 rounded-full'
          "
        ></div>

        <!-- Stats Row -->
        <div
          v-if="!loading && !error"
          class="flex justify-center gap-4 sm:gap-8 mb-6 sm:mb-8"
        >
          <div
            :class="
              isDark
                ? 'px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-teal-500/20 to-cyan-500/20 border border-teal-400/30 rounded-2xl backdrop-blur-sm'
                : 'px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-teal-100/60 to-cyan-100/60 border border-teal-300/50 rounded-2xl backdrop-blur-sm'
            "
          >
            <div class="text-center">
              <div
                :class="
                  isDark
                    ? 'text-2xl sm:text-3xl font-bold text-teal-400'
                    : 'text-2xl sm:text-3xl font-bold text-teal-600'
                "
              >
                {{ courses.length }}
              </div>
              <div
                :class="isDark ? 'text-slate-300' : 'text-slate-600'"
                class="text-xs sm:text-sm font-medium"
              >
                Enrolled Courses
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="text-center py-12 sm:py-20">
      <div class="relative">
        <div
          :class="
            isDark
              ? 'w-16 sm:w-20 h-16 sm:h-20 border-4 border-teal-500/30 border-t-teal-500 rounded-full animate-spin mx-auto'
              : 'w-16 sm:w-20 h-16 sm:h-20 border-4 border-teal-500/30 border-t-teal-500 rounded-full animate-spin mx-auto'
          "
        ></div>
        <div
          :class="
            isDark
              ? 'absolute inset-0 w-16 sm:w-20 h-16 sm:h-20 border-4 border-purple-500/20 border-t-purple-500 rounded-full animate-spin mx-auto'
              : 'absolute inset-0 w-16 sm:w-20 h-16 sm:h-20 border-4 border-purple-500/20 border-t-purple-500 rounded-full animate-spin mx-auto'
          "
          style="animation-direction: reverse; animation-duration: 1.5s"
        ></div>
      </div>
      <p
        :class="
          isDark
            ? 'mt-4 sm:mt-6 text-base sm:text-lg text-slate-400'
            : 'mt-4 sm:mt-6 text-base sm:text-lg text-slate-600'
        "
      >
        Loading your learning journey...
      </p>
    </div>

    <!-- Error State -->
    <div v-if="error" class="text-center py-12 sm:py-20 px-4">
      <div
        :class="
          isDark
            ? 'inline-flex items-center p-6 sm:p-8 bg-gradient-to-r from-red-500/20 to-orange-500/20 border border-red-400/30 rounded-2xl backdrop-blur-sm'
            : 'inline-flex items-center p-6 sm:p-8 bg-gradient-to-r from-red-100/80 to-orange-100/80 border border-red-300/50 rounded-2xl backdrop-blur-sm'
        "
      >
        <div class="text-red-400 text-lg sm:text-xl font-bold">
          {{ error }}
        </div>
      </div>
    </div>

    <!-- Unique Courses Layout -->
    <div
      v-if="!loading && !error && courses.length > 0"
      class="max-w-7xl mx-auto px-4 sm:px-6 pb-8 sm:pb-12"
    >
      <div class="space-y-8 sm:space-y-16">
        <div v-for="(course, index) in courses" :key="course.course_id" class="relative">
          <!-- Responsive Layout -->
          <div
            :class="[
              'flex flex-col lg:flex-row gap-6 sm:gap-8 lg:gap-12 items-center',
              index % 2 === 1 ? 'lg:flex-row-reverse' : '',
            ]"
          >
            <!-- Visual Element -->
            <div class="w-full lg:w-1/2 relative">
              <div
                :class="
                  isDark
                    ? 'relative p-4 sm:p-6 lg:p-8 bg-gradient-to-br from-teal-500/10 via-cyan-500/10 to-purple-500/10 rounded-2xl sm:rounded-3xl border border-white/10 backdrop-blur-sm'
                    : 'relative p-4 sm:p-6 lg:p-8 bg-gradient-to-br from-teal-100/60 via-cyan-100/60 to-purple-100/60 rounded-2xl sm:rounded-3xl border border-teal-200/40 backdrop-blur-sm'
                "
              >
                <!-- Decorative Elements -->
                <div
                  :class="
                    isDark
                      ? 'absolute top-2 sm:top-4 left-2 sm:left-4 w-8 sm:w-12 lg:w-16 h-8 sm:h-12 lg:h-16 bg-gradient-to-br from-teal-500/20 to-cyan-500/20 rounded-xl sm:rounded-2xl rotate-12'
                      : 'absolute top-2 sm:top-4 left-2 sm:left-4 w-8 sm:w-12 lg:w-16 h-8 sm:h-12 lg:h-16 bg-gradient-to-br from-teal-400/30 to-cyan-400/30 rounded-xl sm:rounded-2xl rotate-12'
                  "
                ></div>
                <div
                  :class="
                    isDark
                      ? 'absolute bottom-2 sm:bottom-4 right-2 sm:right-4 w-6 sm:w-8 lg:w-12 h-6 sm:h-8 lg:h-12 bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-lg sm:rounded-xl -rotate-12'
                      : 'absolute bottom-2 sm:bottom-4 right-2 sm:right-4 w-6 sm:w-8 lg:w-12 h-6 sm:h-8 lg:h-12 bg-gradient-to-br from-purple-400/30 to-pink-400/30 rounded-lg sm:rounded-xl -rotate-12'
                  "
                ></div>

                <!-- Course Image Container -->
                <div class="relative z-10">
                  <div
                    :class="[
                      'w-full h-48 sm:h-56 lg:h-64 rounded-xl sm:rounded-2xl overflow-hidden shadow-xl transition-all duration-500 group-hover:scale-105',
                      isDark ? 'bg-slate-800' : 'bg-slate-100',
                    ]"
                  >
                    <img
                      v-if="course.image"
                      :src="course.image"
                      :alt="course.title"
                      class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                    />
                    <div
                      v-else
                      :class="[
                        'w-full h-full flex items-center justify-center',
                        isDark ? 'bg-slate-800' : 'bg-slate-100',
                      ]"
                    >
                      <font-awesome-icon
                        icon="book"
                        :class="
                          isDark
                            ? 'text-2xl sm:text-3xl lg:text-4xl text-slate-400'
                            : 'text-2xl sm:text-3xl lg:text-4xl text-slate-400'
                        "
                      />
                    </div>
                  </div>

                  <!-- Course Number Badge -->
                  <div
                    :class="
                      isDark
                        ? 'absolute -top-2 sm:-top-4 -left-2 sm:-left-4 w-8 sm:w-10 lg:w-12 h-8 sm:h-10 lg:h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-lg sm:rounded-xl lg:rounded-2xl flex items-center justify-center shadow-lg'
                        : 'absolute -top-2 sm:-top-4 -left-2 sm:-left-4 w-8 sm:w-10 lg:w-12 h-8 sm:h-10 lg:h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-lg sm:rounded-xl lg:rounded-2xl flex items-center justify-center shadow-lg'
                    "
                  >
                    <span class="text-white font-bold text-sm sm:text-base lg:text-lg">
                      {{ index + 1 }}
                    </span>
                  </div>

                  <!-- Category Badge -->
                  <div
                    :class="
                      isDark
                        ? 'absolute -top-2 sm:-top-4 -right-2 sm:-right-4 px-2 sm:px-3 lg:px-4 py-1 sm:py-1.5 lg:py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs sm:text-sm font-bold rounded-full shadow-lg'
                        : 'absolute -top-2 sm:-top-4 -right-2 sm:-right-4 px-2 sm:px-3 lg:px-4 py-1 sm:py-1.5 lg:py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs sm:text-sm font-bold rounded-full shadow-lg'
                    "
                  >
                    {{ course.category_name }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Content -->
            <div class="w-full lg:w-1/2 space-y-4 sm:space-y-6 lg:space-y-8">
              <div>
                <h3
                  :class="
                    isDark
                      ? 'text-xl sm:text-2xl lg:text-3xl xl:text-4xl font-bold text-white mb-3 sm:mb-4 lg:mb-6 line-clamp-2'
                      : 'text-xl sm:text-2xl lg:text-3xl xl:text-4xl font-bold text-slate-900 mb-3 sm:mb-4 lg:mb-6 line-clamp-2'
                  "
                >
                  {{ course.title }}
                </h3>
                <p
                  :class="
                    isDark
                      ? 'text-sm sm:text-base lg:text-lg text-slate-300 leading-relaxed line-clamp-3'
                      : 'text-sm sm:text-base lg:text-lg text-slate-600 leading-relaxed line-clamp-3'
                  "
                >
                  Continue your learning journey with this amazing course. Dive deep into
                  the content and enhance your skills.
                </p>
              </div>

              <!-- Action Button -->
              <div class="pt-2 sm:pt-4">
                <button
                  @click="$router.push(`/courses/${course.course_id}`)"
                  :class="
                    isDark
                      ? 'group relative w-full sm:w-auto px-6 sm:px-8 lg:px-10 py-3 sm:py-4 lg:py-5 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 rounded-xl sm:rounded-2xl font-bold text-white transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-2xl'
                      : 'group relative w-full sm:w-auto px-6 sm:px-8 lg:px-10 py-3 sm:py-4 lg:py-5 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 rounded-xl sm:rounded-2xl font-bold text-white transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-2xl'
                  "
                >
                  <span
                    class="flex items-center justify-center sm:justify-start gap-2 sm:gap-3"
                  >
                    <span>Continue Learning</span>
                    <font-awesome-icon
                      icon="arrow-right"
                      class="transition-transform duration-300 group-hover:translate-x-2"
                    />
                  </span>
                </button>
              </div>
            </div>
          </div>

          <!-- Separator -->
          <div
            v-if="index < courses.length - 1"
            :class="
              isDark
                ? 'mt-8 sm:mt-12 lg:mt-16 w-full h-px bg-gradient-to-r from-transparent via-teal-500/30 to-transparent'
                : 'mt-8 sm:mt-12 lg:mt-16 w-full h-px bg-gradient-to-r from-transparent via-teal-500/50 to-transparent'
            "
          ></div>
        </div>
      </div>
    </div>

    <!-- Enhanced Empty State -->
    <div
      v-if="!loading && !error && courses.length === 0"
      class="flex flex-col items-center justify-center py-12 sm:py-16 lg:py-24 px-4 sm:px-6"
    >
      <div class="text-center max-w-md">
        <div
          :class="[
            'w-24 sm:w-32 h-24 sm:h-32 rounded-full flex items-center justify-center mb-6 sm:mb-8 mx-auto shadow-2xl',
            isDark
              ? 'bg-gradient-to-br from-slate-800/50 to-slate-900/50 backdrop-blur-sm'
              : 'bg-gradient-to-br from-slate-50 to-slate-100',
          ]"
        >
          <font-awesome-icon
            icon="book-open"
            :class="
              isDark
                ? 'text-2xl sm:text-3xl lg:text-4xl text-slate-400'
                : 'text-2xl sm:text-3xl lg:text-4xl text-slate-400'
            "
          />
        </div>
        <h3
          :class="
            isDark
              ? 'text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4'
              : 'text-xl sm:text-2xl font-bold text-slate-800 mb-3 sm:mb-4'
          "
        >
          Start Your Learning Journey
        </h3>
        <p
          :class="
            isDark
              ? 'text-sm sm:text-base lg:text-lg text-slate-300 leading-relaxed mb-6 sm:mb-8'
              : 'text-sm sm:text-base lg:text-lg text-slate-600 leading-relaxed mb-6 sm:mb-8'
          "
        >
          You haven't enrolled in any courses yet. Explore our amazing courses and begin
          your educational adventure!
        </p>
        <router-link
          to="/courses"
          :class="
            isDark
              ? 'inline-flex items-center w-full sm:w-auto justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 rounded-xl sm:rounded-2xl font-bold text-white transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-2xl'
              : 'inline-flex items-center w-full sm:w-auto justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 rounded-xl sm:rounded-2xl font-bold text-white transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 shadow-2xl'
          "
        >
          <span class="flex items-center gap-2 sm:gap-3">
            <span>Browse Courses</span>
            <font-awesome-icon
              icon="arrow-right"
              class="transition-transform duration-300 group-hover:translate-x-2"
            />
          </span>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import { faBook, faBookOpen, faArrowRight } from "@fortawesome/free-solid-svg-icons";
import { useTheme } from "../../composables/useTheme";

library.add(faBook, faBookOpen, faArrowRight);

const { isDark } = useTheme();

const loading = ref(false);
const error = ref(null);
const courses = ref([]);

const fetchCourses = async () => {
  loading.value = true;
  error.value = null;
  try {
    const res = await axios.get("/api/user/courses");
    courses.value = res.data.data ?? res.data;
  } catch (e) {
    error.value = "Failed to load courses";
    console.error("Error fetching courses:", e);
  } finally {
    loading.value = false;
  }
};

onMounted(fetchCourses);
</script>

<style scoped>
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}

button:focus,
a:focus {
  outline: 2px solid #14b8a6;
  outline-offset: 2px;
  box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.1);
}

button:focus-visible,
a:focus-visible {
  outline: 2px solid #14b8a6;
  outline-offset: 4px;
  box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.2);
}

/* Responsive utilities */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

@media (max-width: 768px) {
  .text-6xl {
    font-size: 3rem;
  }
  .text-8xl {
    font-size: 4rem;
  }

  /* Prevent horizontal overflow */
  .overflow-x-hidden {
    overflow-x: hidden;
  }

  /* Better touch targets on mobile */
  button {
    min-height: 44px;
    min-width: 44px;
  }

  /* Improve spacing on mobile */
  .space-y-4 > * + * {
    margin-top: 1rem;
  }

  .space-y-6 > * + * {
    margin-top: 1.5rem;
  }

  .space-y-8 > * + * {
    margin-top: 2rem;
  }
}

@media (max-width: 640px) {
  /* Even smaller text for very small screens */
  .text-3xl {
    font-size: 1.875rem;
  }

  .text-5xl {
    font-size: 3rem;
  }

  /* Reduce padding on very small screens */
  .px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
  }

  .py-8 {
    padding-top: 2rem;
    padding-bottom: 2rem;
  }
}

button:hover {
  transform: translateY(-2px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
}

.group:hover {
  transform: translateY(-5px);
}
</style>
