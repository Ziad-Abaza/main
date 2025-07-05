<template>
  <div
    class="min-h-screen transition-colors duration-500"
    :class="[
      isDark
        ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white'
        : 'bg-gradient-to-br from-slate-100 via-blue-100 to-purple-100 text-slate-900',
    ]"
  >
    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div
        class="absolute top-20 left-10 w-72 h-72 rounded-full blur-3xl animate-pulse"
        :class="isDark ? 'bg-blue-600/10' : 'bg-blue-600/20'"
      ></div>
      <div
        class="absolute bottom-20 right-10 w-80 h-80 rounded-full blur-3xl animate-pulse delay-1000"
        :class="isDark ? 'bg-purple-600/10' : 'bg-purple-600/20'"
      ></div>
      <div
        class="absolute bottom-40 left-1/4 w-60 h-60 rounded-full blur-3xl animate-pulse delay-2000"
        :class="isDark ? 'bg-indigo-600/10' : 'bg-indigo-600/20'"
      ></div>
    </div>

    <div
      v-if="loading"
      class="min-h-screen flex items-center justify-center transition-colors duration-500"
      :class="[
        isDark
          ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950'
          : 'bg-gradient-to-br from-slate-100 via-blue-100 to-purple-100',
      ]"
    >
      <div class="text-center">
        <div
          class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mx-auto mb-4 animate-pulse"
        >
          <font-awesome-icon icon="user" class="text-white text-xl" />
        </div>
        <p
          class="text-lg transition-colors duration-300"
          :class="isDark ? 'text-blue-200' : 'text-blue-700'"
        >
          Loading instructor profile...
        </p>
        <div class="mt-4 flex justify-center gap-2">
          <div class="w-3 h-3 bg-blue-400 rounded-full animate-bounce"></div>
          <div class="w-3 h-3 bg-purple-400 rounded-full animate-bounce delay-100"></div>
          <div class="w-3 h-3 bg-indigo-400 rounded-full animate-bounce delay-200"></div>
        </div>
      </div>
    </div>

    <div
      v-else-if="error"
      class="min-h-screen flex items-center justify-center transition-colors duration-500"
      :class="[
        isDark
          ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950'
          : 'bg-gradient-to-br from-slate-100 via-blue-100 to-purple-100',
      ]"
    >
      <div
        class="text-center glass-card p-8 rounded-3xl border transition-colors duration-300"
        :class="isDark ? 'border-red-400/15' : 'border-red-400/30'"
      >
        <div
          class="w-16 h-16 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center mx-auto mb-4"
        >
          <font-awesome-icon icon="exclamation-triangle" class="text-white text-xl" />
        </div>
        <h2
          class="text-xl font-bold mb-2 transition-colors duration-300"
          :class="isDark ? 'text-white' : 'text-slate-900'"
        >
          Instructor Not Found
        </h2>
        <p
          class="mb-6 transition-colors duration-300"
          :class="isDark ? 'text-blue-200' : 'text-slate-600'"
        >
          {{ error || "The instructor profile could not be loaded." }}
        </p>
        <button
          @click="$router.push('/instructors')"
          class="px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-400 hover:to-purple-400 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-blue-400/30"
        >
          Back to Instructors
        </button>
      </div>
    </div>

    <div v-else class="container mx-auto px-6 py-12 relative z-10">
      <!-- Back Button -->
      <div class="mb-8">
        <button
          @click="$router.back()"
          class="group inline-flex items-center gap-3 px-6 py-3 glass-card-premium rounded-xl transition-all duration-300 hover:scale-105"
          :class="
            isDark
              ? 'border border-white/20 hover:border-blue-500/50'
              : 'border border-slate-200/50 hover:border-blue-500/50'
          "
        >
          <font-awesome-icon
            icon="arrow-left"
            class="group-hover:-translate-x-1 transition-transform duration-300"
          />
          <span
            class="font-medium transition-colors duration-300"
            :class="isDark ? 'text-white' : 'text-slate-700'"
            >Back to Instructors</span
          >
        </button>
      </div>

      <!-- Instructor Header -->
      <div class="glass-card-premium rounded-3xl overflow-hidden mb-12">
        <div class="relative">
          <!-- Cover Image -->
          <div
            class="relative h-48 sm:h-64 md:h-72 lg:h-80 xl:h-96 overflow-hidden rounded-2xl transition-colors duration-300"
            :class="
              isDark
                ? 'bg-gradient-to-r from-blue-900/30 to-purple-900/30'
                : 'bg-gradient-to-r from-blue-100/50 to-purple-100/50'
            "
          >
            <!-- Gradient overlay -->
            <div
              class="absolute inset-0 z-10 transition-colors duration-300"
              :class="
                isDark
                  ? 'bg-gradient-to-t from-black/80 to-transparent'
                  : 'bg-gradient-to-t from-white/80 to-transparent'
              "
            ></div>

            <!-- Background image -->
            <img
              :src="defaultCoverImage"
              alt="Instructor cover"
              class="absolute inset-0 w-full h-full object-cover z-0"
            />
          </div>

          <!-- Instructor Info -->
          <div
            class="relative pt-20 pb-10 px-8 md:px-12 flex flex-col md:flex-row items-center md:items-end gap-6"
          >
            <!-- Avatar -->
            <div
              class="relative -mt-20 md:-mt-24 w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden border-4 shadow-2xl transition-colors duration-300"
              :class="isDark ? 'border-slate-800' : 'border-white'"
            >
              <img
                :src="instructor.image"
                :alt="instructor.name"
                @error="$event.target.src = defaultAvatar"
                class="w-full h-full object-cover"
              />
              <div
                class="absolute inset-0 bg-gradient-to-tr from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
              ></div>
            </div>

            <!-- Basic Info -->
            <div class="flex-1 text-center md:text-left">
              <div
                class="flex flex-wrap justify-center md:justify-start items-center gap-4 mb-3"
              >
                <h1
                  class="text-3xl md:text-4xl font-bold bg-gradient-to-r bg-clip-text text-transparent transition-colors duration-300"
                  :class="
                    isDark ? 'from-white to-slate-300' : 'from-slate-900 to-slate-600'
                  "
                >
                  {{ instructor.name }}
                </h1>
                <div class="inline-flex items-center gap-2">
                  <a
                    v-if="instructor.linkedinUrl"
                    :href="instructor.linkedinUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-10 h-10 rounded-lg flex items-center justify-center transition-colors duration-300 cursor-pointer social-link"
                    :class="
                      isDark
                        ? 'bg-blue-900/50 hover:bg-blue-800/70'
                        : 'bg-blue-100/80 hover:bg-blue-200/80'
                    "
                  >
                    <font-awesome-icon
                      :icon="['fab', 'linkedin-in']"
                      class="transition-colors duration-300"
                      :class="isDark ? 'text-blue-300' : 'text-blue-600'"
                    />
                  </a>
                  <a
                    v-if="instructor.githubUrl"
                    :href="instructor.githubUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-10 h-10 rounded-lg flex items-center justify-center transition-colors duration-300 cursor-pointer social-link"
                    :class="
                      isDark
                        ? 'bg-gray-800/50 hover:bg-gray-700/70'
                        : 'bg-gray-100/80 hover:bg-gray-200/80'
                    "
                  >
                    <font-awesome-icon
                      :icon="['fab', 'github']"
                      class="transition-colors duration-300"
                      :class="isDark ? 'text-gray-300' : 'text-gray-600'"
                    />
                  </a>
                  <a
                    v-if="instructor.websiteUrl"
                    :href="instructor.websiteUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-10 h-10 rounded-lg flex items-center justify-center transition-colors duration-300 cursor-pointer social-link"
                    :class="
                      isDark
                        ? 'bg-emerald-900/50 hover:bg-emerald-800/70'
                        : 'bg-emerald-100/80 hover:bg-emerald-200/80'
                    "
                  >
                    <font-awesome-icon
                      icon="globe"
                      class="transition-colors duration-300"
                      :class="isDark ? 'text-emerald-300' : 'text-emerald-600'"
                    />
                  </a>
                </div>
              </div>

              <div class="flex flex-wrap justify-center md:justify-start gap-4 mb-4">
                <div class="inline-flex items-center gap-2">
                  <font-awesome-icon icon="chalkboard-teacher" class="text-blue-400" />
                  <span
                    class="font-medium transition-colors duration-300"
                    :class="isDark ? 'text-blue-200' : 'text-blue-700'"
                    >{{ instructor.specialization }}</span
                  >
                </div>
                <div class="inline-flex items-center gap-2">
                  <font-awesome-icon icon="briefcase" class="text-purple-400" />
                  <span
                    class="transition-colors duration-300"
                    :class="isDark ? 'text-purple-200' : 'text-purple-700'"
                    >{{ instructor.experience }} of experience</span
                  >
                </div>
              </div>

              <p
                class="max-w-2xl mx-auto md:mx-0 leading-relaxed transition-colors duration-300"
                :class="isDark ? 'text-slate-300' : 'text-slate-600'"
              >
                {{ instructor.bio }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Stats and Courses Section -->
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Statistics Sidebar -->
        <div class="lg:col-span-1">
          <div class="glass-card-premium rounded-2xl p-6 sticky top-24">
            <h3
              class="text-xl font-bold mb-6 transition-colors duration-300"
              :class="isDark ? 'text-white' : 'text-slate-900'"
            >
              About {{ instructor.name.split(" ")[0] }}
            </h3>

            <div class="space-y-6">
              <!-- Experience -->
              <div class="flex items-start gap-3">
                <div class="mt-1">
                  <font-awesome-icon icon="briefcase" class="text-blue-400" />
                </div>
                <div>
                  <h4
                    class="text-sm uppercase tracking-wider mb-1 transition-colors duration-300"
                    :class="isDark ? 'text-slate-400' : 'text-slate-500'"
                  >
                    Experience
                  </h4>
                  <p
                    class="transition-colors duration-300"
                    :class="isDark ? 'text-slate-200' : 'text-slate-700'"
                  >
                    {{ instructor.experience }} of experience
                  </p>
                </div>
              </div>

              <!-- Courses -->
              <div class="flex items-start gap-3">
                <div class="mt-1">
                  <font-awesome-icon icon="chalkboard-teacher" class="text-purple-400" />
                </div>
                <div>
                  <h4
                    class="text-sm uppercase tracking-wider mb-1 transition-colors duration-300"
                    :class="isDark ? 'text-slate-400' : 'text-slate-500'"
                  >
                    Courses Taught
                  </h4>
                  <p
                    class="transition-colors duration-300"
                    :class="isDark ? 'text-slate-200' : 'text-slate-700'"
                  >
                    {{ instructor.statistics.coursesCount }}
                    {{ instructor.statistics.coursesCount === 1 ? "Course" : "Courses" }}
                  </p>
                </div>
              </div>

              <!-- Students -->
              <div class="flex items-start gap-3">
                <div class="mt-1">
                  <font-awesome-icon icon="users" class="text-indigo-400" />
                </div>
                <div>
                  <h4
                    class="text-sm uppercase tracking-wider mb-1 transition-colors duration-300"
                    :class="isDark ? 'text-slate-400' : 'text-slate-500'"
                  >
                    Students
                  </h4>
                  <p
                    class="transition-colors duration-300"
                    :class="isDark ? 'text-slate-200' : 'text-slate-700'"
                  >
                    {{ instructor.statistics.totalStudents }} students
                  </p>
                </div>
              </div>

              <!-- Videos -->
              <div class="flex items-start gap-3">
                <div class="mt-1">
                  <font-awesome-icon icon="video" class="text-emerald-400" />
                </div>
                <div>
                  <h4
                    class="text-sm uppercase tracking-wider mb-1 transition-colors duration-300"
                    :class="isDark ? 'text-slate-400' : 'text-slate-500'"
                  >
                    Video Content
                  </h4>
                  <p
                    class="transition-colors duration-300"
                    :class="isDark ? 'text-slate-200' : 'text-slate-700'"
                  >
                    {{ instructor.statistics.totalVideos }} video lessons
                  </p>
                </div>
              </div>

              <!-- Skills -->
              <div class="flex items-start gap-3">
                <div class="mt-1">
                  <font-awesome-icon icon="lightbulb" class="text-yellow-400" />
                </div>
                <div>
                  <h4
                    class="text-sm uppercase tracking-wider mb-1 transition-colors duration-300"
                    :class="isDark ? 'text-slate-400' : 'text-slate-500'"
                  >
                    Skills
                  </h4>
                  <div class="flex flex-wrap gap-2 mt-1">
                    <span
                      v-for="(skill, index) in instructor.skills"
                      :key="index"
                      class="px-3 py-1 text-xs rounded-full transition-colors duration-300"
                      :class="
                        isDark
                          ? 'bg-blue-500/20 text-blue-300'
                          : 'bg-blue-100 text-blue-700'
                      "
                    >
                      {{ skill }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-3 space-y-8">
          <!-- About Section -->
          <div class="glass-card-premium rounded-2xl p-6 md:p-8">
            <h2
              class="text-2xl font-bold mb-6 flex items-center transition-colors duration-300"
              :class="isDark ? 'text-white' : 'text-slate-900'"
            >
              <font-awesome-icon icon="info-circle" class="mr-2 text-blue-400" />
              About {{ instructor.name.split(" ")[0] }}
            </h2>
            <p
              class="leading-relaxed whitespace-pre-line transition-colors duration-300"
              :class="isDark ? 'text-slate-300' : 'text-slate-600'"
            >
              {{ instructor.bio }}
            </p>
          </div>

          <!-- Courses by Instructor -->
          <div class="glass-card-premium rounded-2xl p-6 md:p-8">
            <h2
              class="text-2xl font-bold mb-6 flex items-center transition-colors duration-300"
              :class="isDark ? 'text-white' : 'text-slate-900'"
            >
              <font-awesome-icon icon="chalkboard-teacher" class="mr-2 text-purple-400" />
              {{ instructor.name.split(" ")[0] }}'s Courses
            </h2>

            <div
              v-if="instructor.statistics.coursesCount === 0"
              class="text-center py-12"
            >
              <font-awesome-icon
                icon="chalkboard-teacher"
                class="text-5xl mb-4 transition-colors duration-300"
                :class="isDark ? 'text-slate-600' : 'text-slate-400'"
              />
              <h3
                class="text-xl font-semibold mb-2 transition-colors duration-300"
                :class="isDark ? 'text-slate-300' : 'text-slate-700'"
              >
                No courses available
              </h3>
              <p
                class="mb-6 transition-colors duration-300"
                :class="isDark ? 'text-slate-500' : 'text-slate-500'"
              >
                This instructor hasn't published any courses yet.
              </p>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div
                v-for="course in instructorCourses"
                :key="course.id"
                class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2 cursor-pointer"
              >
                <div
                  class="glass-card-premium rounded-xl overflow-hidden h-full flex flex-col backdrop-blur-xl transition-all duration-500"
                  :class="
                    isDark
                      ? 'border border-white/10 hover:shadow-blue-500/20 hover:border-blue-500/30'
                      : 'border border-slate-200/50 hover:shadow-blue-500/20 hover:border-blue-500/30'
                  "
                >
                  <div class="relative">
                    <img
                      :src="course.image"
                      :alt="course.title"
                      class="w-full h-36 object-cover"
                    />
                    <div
                      class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                    ></div>
                  </div>

                  <div class="p-4">
                    <h3
                      class="text-lg font-bold mb-2 line-clamp-2 transition-colors duration-300"
                      :class="
                        isDark
                          ? 'text-white group-hover:text-blue-400'
                          : 'text-slate-900 group-hover:text-blue-600'
                      "
                    >
                      {{ course.title }}
                    </h3>

                    <div class="flex items-center justify-between mt-4">
                      <div class="flex items-center gap-2">
                        <img
                          :src="instructor.image"
                          :alt="instructor.name"
                          class="w-8 h-8 rounded-full border transition-colors duration-300"
                          :class="isDark ? 'border-white/20' : 'border-slate-200'"
                        />
                        <span
                          class="text-sm transition-colors duration-300"
                          :class="isDark ? 'text-slate-400' : 'text-slate-500'"
                          >{{ instructor.name }}</span
                        >
                      </div>

                      <div
                        class="text-xs px-2 py-1 rounded-full transition-colors duration-300"
                        :class="
                          isDark
                            ? 'bg-blue-500/20 text-blue-300'
                            : 'bg-blue-100 text-blue-700'
                        "
                      >
                        {{ course.durationMinutes }} min
                      </div>
                    </div>

                    <div class="mt-4 flex items-center gap-2">
                      <div
                        class="text-sm transition-colors duration-300"
                        :class="isDark ? 'text-slate-400' : 'text-slate-500'"
                      >
                        {{ course.videos_count }}
                        {{ course.videos_count === 1 ? "Lesson" : "Lessons" }}
                      </div>
                      <div
                        class="w-1 h-1 rounded-full transition-colors duration-300"
                        :class="isDark ? 'bg-slate-600' : 'bg-slate-400'"
                      ></div>
                      <div
                        class="text-sm transition-colors duration-300"
                        :class="isDark ? 'text-slate-400' : 'text-slate-500'"
                      >
                        {{ course.students_count }} students
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Latest Course Section -->
          <div
            v-if="
              instructor.statistics.latestCourse &&
              instructor.statistics.latestCourse.title !== 'N/A'
            "
            class="glass-card-premium rounded-2xl p-6 md:p-8"
          >
            <h2
              class="text-2xl font-bold mb-6 flex items-center transition-colors duration-300"
              :class="isDark ? 'text-white' : 'text-slate-900'"
            >
              <font-awesome-icon icon="graduation-cap" class="mr-2 text-emerald-400" />
              Latest Course
            </h2>

            <div class="md:flex gap-6">
              <div class="md:w-1/3 mb-6 md:mb-0">
                <img
                  :src="latestCourse.image"
                  :alt="latestCourse.title"
                  class="w-full h-48 object-cover rounded-xl"
                />
              </div>
              <div class="md:w-2/3">
                <h3
                  class="text-xl font-bold mb-3 transition-colors duration-300"
                  :class="isDark ? 'text-white' : 'text-slate-900'"
                >
                  {{ latestCourse.title }}
                </h3>
                <p
                  class="mb-4 transition-colors duration-300"
                  :class="isDark ? 'text-slate-400' : 'text-slate-600'"
                >
                  {{ latestCourse.description }}
                </p>
                <div
                  class="flex flex-wrap gap-4 text-sm mb-6 transition-colors duration-300"
                  :class="isDark ? 'text-slate-500' : 'text-slate-500'"
                >
                  <div class="inline-flex items-center gap-2">
                    <font-awesome-icon icon="clock" class="text-blue-500" />
                    <span>{{ latestCourse.durationMinutes }} minutes</span>
                  </div>
                  <div class="inline-flex items-center gap-2">
                    <font-awesome-icon icon="video" class="text-purple-500" />
                    <span
                      >{{ latestCourse.videos_count }}
                      {{ latestCourse.videos_count === 1 ? "Lesson" : "Lessons" }}</span
                    >
                  </div>
                  <div class="inline-flex items-center gap-2">
                    <font-awesome-icon icon="user-friends" class="text-emerald-500" />
                    <span>{{ latestCourse.students_count }} students</span>
                  </div>
                </div>
                <router-link
                  :to="`/courses/${latestCourse.course_id}`"
                  class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 rounded-lg font-medium transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer"
                >
                  View Course Details
                  <font-awesome-icon icon="arrow-right" />
                </router-link>
              </div>
            </div>
          </div>

          <!-- Call to Action -->
          <div class="glass-card-premium rounded-2xl p-6 md:p-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
              <div class="flex-1">
                <h2
                  class="text-2xl font-bold mb-3 transition-colors duration-300"
                  :class="isDark ? 'text-white' : 'text-slate-900'"
                >
                  Ready to start learning?
                </h2>
                <p
                  class="mb-6 transition-colors duration-300"
                  :class="isDark ? 'text-slate-400' : 'text-slate-600'"
                >
                  Explore all courses taught by {{ instructor.name }} and grow your skills
                  today.
                </p>
              </div>
              <router-link
                :to="`/courses?instructor=${instructor.userId}`"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 rounded-lg font-medium transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer"
              >
                Browse All Courses
                <font-awesome-icon icon="arrow-right" />
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useInstructorStore } from "@/stores/InstructorStore";
import { useCourseStore } from "@/stores/coursesStore";
import { useTheme } from "@/composables/useTheme";
import defaultCoverImagePath from "@/assets/icons/instructor2.png";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
  faChalkboardTeacher,
  faUser,
  faBriefcase,
  faUsers,
  faClock,
  faVideo,
  faGraduationCap,
  faInfoCircle,
  faArrowRight,
  faArrowLeft,
  faGlobe,
  faLightbulb,
  faUserFriends,
  faExclamationTriangle,
} from "@fortawesome/free-solid-svg-icons";
import { faLinkedinIn, faGithub } from "@fortawesome/free-brands-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(
  faChalkboardTeacher,
  faUser,
  faBriefcase,
  faUsers,
  faClock,
  faVideo,
  faGraduationCap,
  faInfoCircle,
  faArrowRight,
  faArrowLeft,
  faGlobe,
  faLightbulb,
  faUserFriends,
  faExclamationTriangle,
  faLinkedinIn,
  faGithub
);

const route = useRoute();
const instructorStore = useInstructorStore();
const courseStore = useCourseStore();
const { isDark } = useTheme();

const instructor_profile_id = route.params.id;
const instructor = ref(null);
const loading = ref(true);
const error = ref(null);
const defaultAvatar = ref(
  "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIHJ4PSI1MCIgZmlsbD0iIzRCNzY4OCIvPjxjaXJjbGUgY3g9IjUwIiBjeT0iNDAiIHI9IjE1IiBmaWxsPSJ3aGl0ZSIgZmlsbC1vcGFjaXR5PSIwLjgiLz48cGF0aCBkPSJNMjUgNzVjMC0xMy44IDExLjItMjUgMjUtMjVzMjUgMTEuMiAyNSAyNXYxMEgyNVY3NXoiIGZpbGw9IndoaXRlIiBmaWxsLW9wYWNpdHk9IjAuOCIvPjwvc3ZnPg=="
);
const defaultCoverImage = ref(defaultCoverImagePath);

// Fetch instructor data when component mounts
onMounted(async () => {
  loading.value = true;
  try {
    await instructorStore.getInstructorbyId(instructor_profile_id);
    instructor.value = instructorStore.instructor;

    if (!instructor.value) {
      error.value = "Instructor not found";
    }
  } catch (err) {
    console.error("Error fetching instructor:", err);
    error.value = "Failed to load instructor profile.";
  } finally {
    loading.value = false;
  }
});

// Get courses for this instructor
const instructorCourses = computed(() => {
  return courseStore.courses.filter(
    (course) => course.instructorId === instructor.value?.userId
  );
});

// Get latest course
const latestCourse = computed(() => {
  if (!instructor.value?.statistics?.latestCourse) {
    // Return a default course if no latest course exists
    return {
      title: "Introduction to Web Development",
      description: "Start your journey as a web developer with the fundamentals.",
      image: " https://via.placeholder.com/600x400.png?text=No+Courses+Available",
      durationMinutes: 120,
      videos_count: 0,
      students_count: 0,
    };
  }

  // Return the actual latest course
  return {
    ...instructor.value.statistics.latestCourse,
    course_id: instructor.value.statistics.latestCourse.id,
    durationMinutes: instructor.value.statistics.latestCourse.durationMinutes || 0,
    videos_count: instructor.value.statistics.latestCourse.videos_count || 0,
    students_count: instructor.value.statistics.latestCourse.students_count || 0,
  };
});
</script>

<style scoped>
.glass-card-premium {
  backdrop-filter: blur(20px);
  transition: all 0.3s ease;
}

/* Dark mode glass card */
.dark .glass-card-premium {
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.08);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

/* Light mode glass card */
.glass-card-premium {
  background: rgba(255, 255, 255, 0.7);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.8);
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Add cursor pointer to interactive elements */
button,
a,
.cursor-pointer {
  cursor: pointer;
}

/* Hover effects for interactive elements */
.glass-card-premium:hover {
  transform: translateY(-2px);
}

.social-link:hover {
  transform: scale(1.1);
}
</style>
