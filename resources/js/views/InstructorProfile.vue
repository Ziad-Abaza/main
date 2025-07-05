<template>
  <div
    :class="[
      'min-h-screen transition-colors duration-500',
      isDark
        ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white'
        : 'bg-gradient-to-br from-slate-100 via-blue-100 to-purple-100 text-slate-900',
    ]"
  >
    <!-- Animated background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div
        :class="[
          'absolute top-20 left-10 w-72 h-72 rounded-full blur-3xl animate-pulse',
          isDark ? 'bg-teal-600/10' : 'bg-teal-200/30',
        ]"
      ></div>
      <div
        :class="[
          'absolute bottom-20 right-10 w-80 h-80 rounded-full blur-3xl animate-pulse delay-1000',
          isDark ? 'bg-purple-600/10' : 'bg-purple-200/30',
        ]"
      ></div>
      <div
        :class="[
          'absolute bottom-40 left-1/4 w-60 h-60 rounded-full blur-3xl animate-pulse delay-2000',
          isDark ? 'bg-cyan-600/10' : 'bg-cyan-200/30',
        ]"
      ></div>
    </div>

    <div
      v-if="loading"
      :class="[
        'min-h-screen flex items-center justify-center transition-colors duration-500',
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
        <p :class="['text-lg', isDark ? 'text-blue-200' : 'text-blue-700']">
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
      :class="[
        'min-h-screen flex items-center justify-center transition-colors duration-500',
        isDark
          ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950'
          : 'bg-gradient-to-br from-slate-100 via-blue-100 to-purple-100',
      ]"
    >
      <div
        :class="[
          'text-center p-8 rounded-3xl border',
          isDark
            ? 'glass-card border-red-400/15'
            : 'bg-white/80 backdrop-blur-xl border-red-200 shadow-card-light',
        ]"
      >
        <div
          class="w-16 h-16 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center mx-auto mb-4"
        >
          <font-awesome-icon icon="exclamation-triangle" class="text-white text-xl" />
        </div>
        <h2 :class="['text-xl font-bold mb-2', isDark ? 'text-white' : 'text-slate-900']">
          Instructor Not Found
        </h2>
        <p :class="['mb-6', isDark ? 'text-blue-200' : 'text-slate-600']">
          {{ error || "The instructor profile could not be loaded." }}
        </p>
        <button
          @click="$router.push('/instructors')"
          class="cursor-pointer px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-400 hover:to-purple-400 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-blue-400/30"
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
          :class="[
            'group inline-flex items-center gap-3 px-6 py-3 rounded-xl border transition-all duration-300 hover:scale-105',
            isDark
              ? 'glass-card-premium border-white/20 hover:border-blue-500/50'
              : 'bg-white/80 backdrop-blur-xl border-slate-200 hover:border-blue-300 shadow-card-light',
          ]"
        >
          <font-awesome-icon
            icon="arrow-left"
            class="group-hover:-translate-x-1 transition-transform duration-300"
          />
          <span :class="['font-medium', isDark ? 'text-white' : 'text-slate-700']"
            >Back to Instructors</span
          >
        </button>
      </div>

      <!-- Instructor Header -->
      <div
        :class="[
          'rounded-3xl overflow-hidden mb-12',
          isDark
            ? 'glass-card-premium'
            : 'bg-white/80 backdrop-blur-xl shadow-card-light',
        ]"
      >
        <div class="relative">
          <!-- Cover Image -->
          <div
            :class="[
              'relative h-48 sm:h-64 md:h-72 lg:h-80 xl:h-96 overflow-hidden rounded-2xl',
              isDark
                ? 'bg-gradient-to-r from-teal-900/30 to-cyan-900/30'
                : 'bg-gradient-to-r from-teal-100/50 to-cyan-100/50',
            ]"
          >
            <!-- Gradient overlay -->
            <div
              :class="[
                'absolute inset-0 z-10',
                isDark
                  ? 'bg-gradient-to-t from-black/80 to-transparent'
                  : 'bg-gradient-to-t from-white/80 to-transparent',
              ]"
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
              :class="[
                'relative -mt-20 md:-mt-24 w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden border-4 shadow-2xl',
                isDark ? 'border-slate-800' : 'border-white',
              ]"
            >
              <img
                :src="instructor.image"
                :alt="instructor.name"
                @error="$event.target.src = defaultAvatar"
                class="w-full h-full object-cover"
              />
              <div
                :class="[
                  'absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300',
                  isDark
                    ? 'bg-gradient-to-tr from-teal-500/10 to-cyan-500/10'
                    : 'bg-gradient-to-tr from-teal-200/20 to-cyan-200/20',
                ]"
              ></div>
            </div>

            <!-- Basic Info -->
            <div class="flex-1 text-center md:text-left">
              <div
                class="flex flex-wrap justify-center md:justify-start items-center gap-4 mb-3"
              >
                <h1
                  :class="[
                    'text-3xl md:text-4xl font-bold bg-clip-text text-transparent',
                    isDark
                      ? 'bg-gradient-to-r from-white via-teal-100 to-cyan-100'
                      : 'bg-gradient-to-r from-slate-900 via-teal-800 to-cyan-800',
                  ]"
                >
                  {{ instructor.name }}
                </h1>
                <div class="inline-flex items-center gap-2">
                  <a
                    v-if="instructor.linkedinUrl"
                    :href="instructor.linkedinUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    :class="[
                      'w-10 h-10 rounded-lg flex items-center justify-center transition-colors',
                      isDark
                        ? 'bg-blue-900/50 hover:bg-blue-800/70'
                        : 'bg-blue-100 hover:bg-blue-200',
                    ]"
                  >
                    <font-awesome-icon
                      :icon="['fab', 'linkedin-in']"
                      :class="isDark ? 'text-blue-300' : 'text-blue-600'"
                    />
                  </a>
                  <a
                    v-if="instructor.githubUrl"
                    :href="instructor.githubUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    :class="[
                      'w-10 h-10 rounded-lg flex items-center justify-center transition-colors',
                      isDark
                        ? 'bg-gray-800/50 hover:bg-gray-700/70'
                        : 'bg-gray-100 hover:bg-gray-200',
                    ]"
                  >
                    <font-awesome-icon
                      :icon="['fab', 'github']"
                      :class="isDark ? 'text-gray-300' : 'text-gray-600'"
                    />
                  </a>
                  <a
                    v-if="instructor.websiteUrl"
                    :href="instructor.websiteUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    :class="[
                      'w-10 h-10 rounded-lg flex items-center justify-center transition-colors',
                      isDark
                        ? 'bg-emerald-900/50 hover:bg-emerald-800/70'
                        : 'bg-emerald-100 hover:bg-emerald-200',
                    ]"
                  >
                    <font-awesome-icon
                      :icon="'globe'"
                      :class="isDark ? 'text-emerald-300' : 'text-emerald-600'"
                    />
                  </a>
                </div>
              </div>

              <div class="flex flex-wrap justify-center md:justify-start gap-4 mb-4">
                <div class="inline-flex items-center gap-2">
                  <font-awesome-icon icon="chalkboard-teacher" class="text-teal-400" />
                  <span
                    :class="['font-medium', isDark ? 'text-teal-300' : 'text-teal-700']"
                    >{{ instructor.specialization }}</span
                  >
                </div>
                <div class="inline-flex items-center gap-2">
                  <font-awesome-icon icon="briefcase" class="text-cyan-400" />
                  <span :class="isDark ? 'text-cyan-300' : 'text-cyan-700'"
                    >{{ instructor.experience }} of experience</span
                  >
                </div>
              </div>

              <p
                :class="[
                  'max-w-2xl mx-auto md:mx-0 leading-relaxed',
                  isDark ? 'text-slate-300' : 'text-slate-600',
                ]"
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
          <div
            :class="[
              'rounded-2xl p-6 sticky top-24',
              isDark
                ? 'glass-card-premium'
                : 'bg-white/80 backdrop-blur-xl shadow-card-light',
            ]"
          >
            <h3
              :class="[
                'text-xl font-bold mb-6',
                isDark ? 'text-white' : 'text-slate-900',
              ]"
            >
              About {{ instructor.name.split(" ")[0] }}
            </h3>

            <div class="space-y-6">
              <!-- Experience -->
              <div class="flex items-start gap-3">
                <div class="mt-1">
                  <font-awesome-icon icon="briefcase" class="text-teal-400" />
                </div>
                <div>
                  <h4
                    :class="[
                      'text-sm uppercase tracking-wider mb-1',
                      isDark ? 'text-slate-400' : 'text-slate-500',
                    ]"
                  >
                    Experience
                  </h4>
                  <p :class="isDark ? 'text-slate-200' : 'text-slate-700'">
                    {{ instructor.experience }} of experience
                  </p>
                </div>
              </div>

              <!-- Courses -->
              <div class="flex items-start gap-3">
                <div class="mt-1">
                  <font-awesome-icon icon="chalkboard-teacher" class="text-cyan-400" />
                </div>
                <div>
                  <h4
                    :class="[
                      'text-sm uppercase tracking-wider mb-1',
                      isDark ? 'text-slate-400' : 'text-slate-500',
                    ]"
                  >
                    Courses Taught
                  </h4>
                  <p :class="isDark ? 'text-slate-200' : 'text-slate-700'">
                    {{ instructor.statistics.coursesCount }}
                    {{ instructor.statistics.coursesCount === 1 ? "Course" : "Courses" }}
                  </p>
                </div>
              </div>

              <!-- Students -->
              <div class="flex items-start gap-3">
                <div class="mt-1">
                  <font-awesome-icon icon="users" class="text-purple-400" />
                </div>
                <div>
                  <h4
                    :class="[
                      'text-sm uppercase tracking-wider mb-1',
                      isDark ? 'text-slate-400' : 'text-slate-500',
                    ]"
                  >
                    Students
                  </h4>
                  <p :class="isDark ? 'text-slate-200' : 'text-slate-700'">
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
                    :class="[
                      'text-sm uppercase tracking-wider mb-1',
                      isDark ? 'text-slate-400' : 'text-slate-500',
                    ]"
                  >
                    Video Content
                  </h4>
                  <p :class="isDark ? 'text-slate-200' : 'text-slate-700'">
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
                    :class="[
                      'text-sm uppercase tracking-wider mb-1',
                      isDark ? 'text-slate-400' : 'text-slate-500',
                    ]"
                  >
                    Skills
                  </h4>
                  <div class="flex flex-wrap gap-2 mt-1">
                    <span
                      v-for="(skill, index) in instructor.skills"
                      :key="index"
                      :class="[
                        'px-3 py-1 text-xs rounded-full',
                        isDark
                          ? 'bg-teal-500/20 text-teal-300'
                          : 'bg-teal-100 text-teal-700',
                      ]"
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
          <div
            :class="[
              'rounded-2xl p-6 md:p-8',
              isDark
                ? 'glass-card-premium'
                : 'bg-white/80 backdrop-blur-xl shadow-card-light',
            ]"
          >
            <h2
              :class="[
                'text-2xl font-bold mb-6 flex items-center',
                isDark ? 'text-white' : 'text-slate-900',
              ]"
            >
              <font-awesome-icon icon="info-circle" class="mr-2 text-teal-400" />
              About {{ instructor.name.split(" ")[0] }}
            </h2>
            <p
              :class="[
                'leading-relaxed whitespace-pre-line',
                isDark ? 'text-slate-300' : 'text-slate-600',
              ]"
            >
              {{ instructor.bio }}
            </p>
          </div>

          <!-- Courses by Instructor -->
          <div
            :class="[
              'rounded-2xl p-6 md:p-8',
              isDark
                ? 'glass-card-premium'
                : 'bg-white/80 backdrop-blur-xl shadow-card-light',
            ]"
          >
            <h2
              :class="[
                'text-2xl font-bold mb-6 flex items-center',
                isDark ? 'text-white' : 'text-slate-900',
              ]"
            >
              <font-awesome-icon icon="chalkboard-teacher" class="mr-2 text-cyan-400" />
              {{ instructor.name.split(" ")[0] }}'s Courses
            </h2>

            <div
              v-if="instructor.statistics.coursesCount === 0"
              class="text-center py-12"
            >
              <font-awesome-icon
                icon="chalkboard-teacher"
                :class="['text-5xl mb-4', isDark ? 'text-slate-600' : 'text-slate-400']"
              />
              <h3
                :class="[
                  'text-xl font-semibold mb-2',
                  isDark ? 'text-slate-300' : 'text-slate-700',
                ]"
              >
                No courses available
              </h3>
              <p :class="isDark ? 'text-slate-500' : 'text-slate-500'">
                This instructor hasn't published any courses yet.
              </p>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div
                v-for="course in instructorCourses"
                :key="course.id"
                class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2"
              >
                <div
                  :class="[
                    'rounded-xl overflow-hidden h-full flex flex-col backdrop-blur-xl transition-all duration-500',
                    isDark
                      ? 'glass-card-premium border border-white/10 hover:shadow-teal-500/20 hover:border-teal-500/30'
                      : 'bg-white/90 border border-slate-200 hover:shadow-teal-500/20 hover:border-teal-300 shadow-card-light',
                  ]"
                >
                  <div class="relative">
                    <img
                      :src="course.image"
                      :alt="course.title"
                      class="w-full h-36 object-cover"
                    />
                    <div
                      :class="[
                        'absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300',
                        isDark
                          ? 'bg-gradient-to-t from-black/80 to-transparent'
                          : 'bg-gradient-to-t from-white/80 to-transparent',
                      ]"
                    ></div>
                  </div>

                  <div class="p-4">
                    <h3
                      :class="[
                        'text-lg font-bold mb-2 line-clamp-2 group-hover:text-teal-400 transition-colors duration-300',
                        isDark ? 'text-white' : 'text-slate-900',
                      ]"
                    >
                      {{ course.title }}
                    </h3>

                    <div class="flex items-center justify-between mt-4">
                      <div class="flex items-center gap-2">
                        <img
                          :src="instructor.image"
                          :alt="instructor.name"
                          :class="[
                            'w-8 h-8 rounded-full border',
                            isDark ? 'border-white/20' : 'border-slate-200',
                          ]"
                        />
                        <span :class="isDark ? 'text-slate-400' : 'text-slate-600'">{{
                          instructor.name
                        }}</span>
                      </div>

                      <div
                        :class="[
                          'text-xs px-2 py-1 rounded-full',
                          isDark
                            ? 'bg-teal-500/20 text-teal-300'
                            : 'bg-teal-100 text-teal-700',
                        ]"
                      >
                        {{ course.durationMinutes }} min
                      </div>
                    </div>

                    <div class="mt-4 flex items-center gap-2">
                      <div :class="isDark ? 'text-slate-400' : 'text-slate-500'">
                        {{ course.videos_count }}
                        {{ course.videos_count === 1 ? "Lesson" : "Lessons" }}
                      </div>
                      <div
                        :class="[
                          'w-1 h-1 rounded-full',
                          isDark ? 'bg-slate-600' : 'bg-slate-400',
                        ]"
                      ></div>
                      <div :class="isDark ? 'text-slate-400' : 'text-slate-500'">
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
            :class="[
              'rounded-2xl p-6 md:p-8',
              isDark
                ? 'glass-card-premium'
                : 'bg-white/80 backdrop-blur-xl shadow-card-light',
            ]"
          >
            <h2
              :class="[
                'text-2xl font-bold mb-6 flex items-center',
                isDark ? 'text-white' : 'text-slate-900',
              ]"
            >
              <font-awesome-icon icon="graduation-cap" class="mr-2 text-teal-400" />
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
                  :class="[
                    'text-xl font-bold mb-3',
                    isDark ? 'text-white' : 'text-slate-900',
                  ]"
                >
                  {{ latestCourse.title }}
                </h3>
                <p :class="isDark ? 'text-slate-400' : 'text-slate-600'">
                  {{ latestCourse.description }}
                </p>
                <div class="flex flex-wrap gap-4 text-sm mb-6">
                  <div class="inline-flex items-center gap-2">
                    <font-awesome-icon icon="clock" class="text-teal-500" />
                    <span :class="isDark ? 'text-slate-500' : 'text-slate-600'"
                      >{{ latestCourse.durationMinutes }} minutes</span
                    >
                  </div>
                  <div class="inline-flex items-center gap-2">
                    <font-awesome-icon icon="video" class="text-cyan-500" />
                    <span :class="isDark ? 'text-slate-500' : 'text-slate-600'"
                      >{{ latestCourse.videos_count }}
                      {{ latestCourse.videos_count === 1 ? "Lesson" : "Lessons" }}</span
                    >
                  </div>
                  <div class="inline-flex items-center gap-2">
                    <font-awesome-icon icon="user-friends" class="text-purple-500" />
                    <span :class="isDark ? 'text-slate-500' : 'text-slate-600'"
                      >{{ latestCourse.students_count }} students</span
                    >
                  </div>
                </div>
                <router-link
                  :to="`/courses/${latestCourse.course_id}`"
                  class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 rounded-lg font-medium transition-all duration-300 transform hover:-translate-y-0.5"
                >
                  View Course Details
                  <font-awesome-icon icon="arrow-right" />
                </router-link>
              </div>
            </div>
          </div>

          <!-- Call to Action -->
          <div
            :class="[
              'rounded-2xl p-6 md:p-8',
              isDark
                ? 'glass-card-premium'
                : 'bg-white/80 backdrop-blur-xl shadow-card-light',
            ]"
          >
            <div class="flex flex-col md:flex-row items-center gap-6">
              <div class="flex-1">
                <h2
                  :class="[
                    'text-2xl font-bold mb-3',
                    isDark ? 'text-white' : 'text-slate-900',
                  ]"
                >
                  Ready to start learning?
                </h2>
                <p :class="isDark ? 'text-slate-400' : 'text-slate-600'">
                  Explore all courses taught by {{ instructor.name }} and grow your skills
                  today.
                </p>
              </div>
              <router-link
                :to="`/courses?instructor=${instructor.userId}`"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 rounded-lg font-medium transition-all duration-300 transform hover:-translate-y-0.5"
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
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.15);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

/* Light mode glass card styles */
:deep(.bg-white\/80) {
  background: rgba(255, 255, 255, 0.8);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.6);
}

:deep(.bg-white\/90) {
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), inset 0 1px 0 rgba(255, 255, 255, 0.8);
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Light mode specific hover effects */
:deep(.bg-white\/80:hover) {
  background: rgba(255, 255, 255, 0.9);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.8);
}

:deep(.bg-white\/90:hover) {
  background: rgba(255, 255, 255, 0.95);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.9);
}
</style>
