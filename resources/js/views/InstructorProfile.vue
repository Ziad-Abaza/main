<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white">
      <!-- Animated background elements -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-40 left-1/4 w-60 h-60 bg-indigo-600/10 rounded-full blur-3xl animate-pulse delay-2000"></div>
      </div>

      <div v-if="loading" class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 flex items-center justify-center">
        <div class="text-center">
          <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mx-auto mb-4 animate-pulse">
            <font-awesome-icon icon="user" class="text-white text-xl" />
          </div>
          <p class="text-blue-200 text-lg">Loading instructor profile...</p>
          <div class="mt-4 flex justify-center gap-2">
            <div class="w-3 h-3 bg-blue-400 rounded-full animate-bounce"></div>
            <div class="w-3 h-3 bg-purple-400 rounded-full animate-bounce delay-100"></div>
            <div class="w-3 h-3 bg-indigo-400 rounded-full animate-bounce delay-200"></div>
          </div>
        </div>
      </div>

      <div v-else-if="error" class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 flex items-center justify-center">
        <div class="text-center glass-card p-8 rounded-3xl border border-red-400/15">
          <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center mx-auto mb-4">
            <font-awesome-icon icon="exclamation-triangle" class="text-white text-xl" />
          </div>
          <h2 class="text-xl font-bold text-white mb-2">Instructor Not Found</h2>
          <p class="text-blue-200 mb-6">{{ error || 'The instructor profile could not be loaded.' }}</p>
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
            class="group inline-flex items-center gap-3 px-6 py-3 glass-card-premium rounded-xl border border-white/20 hover:border-blue-500/50 transition-all duration-300 hover:scale-105"
          >
            <font-awesome-icon icon="arrow-left" class="group-hover:-translate-x-1 transition-transform duration-300" />
            <span class="font-medium">Back to Instructors</span>
          </button>
        </div>

        <!-- Instructor Header -->
        <div class="glass-card-premium rounded-3xl overflow-hidden mb-12">
          <div class="relative">
            <!-- Cover Image -->
            <div class="relative h-48 sm:h-64 md:h-72 lg:h-80 xl:h-96 bg-gradient-to-r from-blue-900/30 to-purple-900/30 overflow-hidden rounded-2xl">
  <!-- Gradient overlay -->
  <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10"></div>

  <!-- Background image -->
  <img
    :src="defaultCoverImage"
    alt="Instructor cover"
    class="absolute inset-0 w-full h-full object-cover z-0"
  />
</div>


            <!-- Instructor Info -->
            <div class="relative pt-20 pb-10 px-8 md:px-12 flex flex-col md:flex-row items-center md:items-end gap-6">
              <!-- Avatar -->
              <div class="relative -mt-20 md:-mt-24 w-32 h-32 md:w-40 md:h-40 rounded-2xl overflow-hidden border-4 border-slate-800 shadow-2xl">
                <img
                  :src="instructor.image"
                  :alt="instructor.name"
                  @error="$event.target.src = defaultAvatar"
                  class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              </div>

              <!-- Basic Info -->
              <div class="flex-1 text-center md:text-left">
                <div class="flex flex-wrap justify-center md:justify-start items-center gap-4 mb-3">
                  <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">
                    {{ instructor.name }}
                  </h1>
                  <div class="inline-flex items-center gap-2">
                    <a
                      v-if="instructor.linkedinUrl"
                      :href="instructor.linkedinUrl"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="w-10 h-10 bg-blue-900/50 rounded-lg flex items-center justify-center hover:bg-blue-800/70 transition-colors"
                    >
                      <font-awesome-icon :icon="['fab', 'linkedin-in']" class="text-blue-300" />
                    </a>
                    <a
                      v-if="instructor.githubUrl"
                      :href="instructor.githubUrl"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="w-10 h-10 bg-gray-800/50 rounded-lg flex items-center justify-center hover:bg-gray-700/70 transition-colors"
                    >
                      <font-awesome-icon :icon="['fab', 'github']" class="text-gray-300" />
                    </a>
                    <a
                      v-if="instructor.websiteUrl"
                      :href="instructor.websiteUrl"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="w-10 h-10 bg-emerald-900/50 rounded-lg flex items-center justify-center hover:bg-emerald-800/70 transition-colors"
                    >
                      <font-awesome-icon icon="globe" class="text-emerald-300" />
                    </a>
                  </div>
                </div>

                <div class="flex flex-wrap justify-center md:justify-start gap-4 mb-4">
                  <div class="inline-flex items-center gap-2">
                    <font-awesome-icon icon="chalkboard-teacher" class="text-blue-400" />
                    <span class="text-blue-200 font-medium">{{ instructor.specialization }}</span>
                  </div>
                  <div class="inline-flex items-center gap-2">
                    <font-awesome-icon icon="briefcase" class="text-purple-400" />
                    <span class="text-purple-200">{{ instructor.experience }} of experience</span>
                  </div>
                </div>

                <p class="text-slate-300 max-w-2xl mx-auto md:mx-0 leading-relaxed">
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
              <h3 class="text-xl font-bold mb-6 text-white">About {{ instructor.name.split(' ')[0] }}</h3>

              <div class="space-y-6">
                <!-- Experience -->
                <div class="flex items-start gap-3">
                  <div class="mt-1">
                    <font-awesome-icon icon="briefcase" class="text-blue-400" />
                  </div>
                  <div>
                    <h4 class="text-sm text-slate-400 uppercase tracking-wider mb-1">Experience</h4>
                    <p class="text-slate-200">{{ instructor.experience }} of experience</p>
                  </div>
                </div>

                <!-- Courses -->
                <div class="flex items-start gap-3">
                  <div class="mt-1">
                    <font-awesome-icon icon="chalkboard-teacher" class="text-purple-400" />
                  </div>
                  <div>
                    <h4 class="text-sm text-slate-400 uppercase tracking-wider mb-1">Courses Taught</h4>
                    <p class="text-slate-200">{{ instructor.statistics.coursesCount }} {{ instructor.statistics.coursesCount === 1 ? 'Course' : 'Courses' }}</p>
                  </div>
                </div>

                <!-- Students -->
                <div class="flex items-start gap-3">
                  <div class="mt-1">
                    <font-awesome-icon icon="users" class="text-indigo-400" />
                  </div>
                  <div>
                    <h4 class="text-sm text-slate-400 uppercase tracking-wider mb-1">Students</h4>
                    <p class="text-slate-200">{{ instructor.statistics.totalStudents }} students</p>
                  </div>
                </div>

                <!-- Videos -->
                <div class="flex items-start gap-3">
                  <div class="mt-1">
                    <font-awesome-icon icon="video" class="text-emerald-400" />
                  </div>
                  <div>
                    <h4 class="text-sm text-slate-400 uppercase tracking-wider mb-1">Video Content</h4>
                    <p class="text-slate-200">{{ instructor.statistics.totalVideos }} video lessons</p>
                  </div>
                </div>

                <!-- Skills -->
                <div class="flex items-start gap-3">
                  <div class="mt-1">
                    <font-awesome-icon icon="lightbulb" class="text-yellow-400" />
                  </div>
                  <div>
                    <h4 class="text-sm text-slate-400 uppercase tracking-wider mb-1">Skills</h4>
                    <div class="flex flex-wrap gap-2 mt-1">
                      <span
                        v-for="(skill, index) in instructor.skills"
                        :key="index"
                        class="px-3 py-1 bg-blue-500/20 text-blue-300 text-xs rounded-full"
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
              <h2 class="text-2xl font-bold mb-6 text-white flex items-center">
                <font-awesome-icon icon="info-circle" class="mr-2 text-blue-400" />
                About {{ instructor.name.split(' ')[0] }}
              </h2>
              <p class="text-slate-300 leading-relaxed whitespace-pre-line">{{ instructor.bio }}</p>
            </div>

            <!-- Courses by Instructor -->
            <div class="glass-card-premium rounded-2xl p-6 md:p-8">
              <h2 class="text-2xl font-bold mb-6 text-white flex items-center">
                <font-awesome-icon icon="chalkboard-teacher" class="mr-2 text-purple-400" />
                {{ instructor.name.split(' ')[0] }}'s Courses
              </h2>

              <div v-if="instructor.statistics.coursesCount === 0" class="text-center py-12">
                <font-awesome-icon icon="chalkboard-teacher" class="text-slate-600 text-5xl mb-4" />
                <h3 class="text-xl font-semibold mb-2 text-slate-300">No courses available</h3>
                <p class="text-slate-500 mb-6">This instructor hasn't published any courses yet.</p>
              </div>

              <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div
                  v-for="course in instructorCourses"
                  :key="course.id"
                  class="group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2"
                >
                  <div class="glass-card-premium rounded-xl overflow-hidden border border-white/10 h-full flex flex-col backdrop-blur-xl hover:shadow-blue-500/20 hover:border-blue-500/30 transition-all duration-500">
                    <div class="relative">
                      <img
                        :src="course.image"
                        :alt="course.title"
                        class="w-full h-36 object-cover"
                      />
                      <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <div class="p-4">
                      <h3 class="text-lg font-bold mb-2 text-white line-clamp-2 group-hover:text-blue-400 transition-colors duration-300">
                        {{ course.title }}
                      </h3>

                      <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center gap-2">
                          <img
                            :src="instructor.image"
                            :alt="instructor.name"
                            class="w-8 h-8 rounded-full border border-white/20"
                          />
                          <span class="text-sm text-slate-400">{{ instructor.name }}</span>
                        </div>

                        <div class="bg-blue-500/20 text-blue-300 text-xs px-2 py-1 rounded-full">
                          {{ course.durationMinutes }} min
                        </div>
                      </div>

                      <div class="mt-4 flex items-center gap-2">
                        <div class="text-sm text-slate-400">{{ course.videos_count }} {{ course.videos_count === 1 ? 'Lesson' : 'Lessons' }}</div>
                        <div class="w-1 h-1 bg-slate-600 rounded-full"></div>
                        <div class="text-sm text-slate-400">{{ course.students_count }} students</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Latest Course Section -->
            <div v-if="instructor.statistics.latestCourse && instructor.statistics.latestCourse.title !== 'N/A'" class="glass-card-premium rounded-2xl p-6 md:p-8">
              <h2 class="text-2xl font-bold mb-6 text-white flex items-center">
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
                  <h3 class="text-xl font-bold mb-3 text-white">{{ latestCourse.title }}</h3>
                  <p class="text-slate-400 mb-4">{{ latestCourse.description }}</p>
                  <div class="flex flex-wrap gap-4 text-sm text-slate-500 mb-6">
                    <div class="inline-flex items-center gap-2">
                      <font-awesome-icon icon="clock" class="text-blue-500" />
                      <span>{{ latestCourse.durationMinutes }} minutes</span>
                    </div>
                    <div class="inline-flex items-center gap-2">
                      <font-awesome-icon icon="video" class="text-purple-500" />
                      <span>{{ latestCourse.videos_count }} {{ latestCourse.videos_count === 1 ? 'Lesson' : 'Lessons' }}</span>
                    </div>
                    <div class="inline-flex items-center gap-2">
                      <font-awesome-icon icon="user-friends" class="text-emerald-500" />
                      <span>{{ latestCourse.students_count }} students</span>
                    </div>
                  </div>
                  <router-link
                    :to="`/courses/${latestCourse.course_id}`"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 rounded-lg font-medium transition-all duration-300 transform hover:-translate-y-0.5"
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
                  <h2 class="text-2xl font-bold mb-3 text-white">Ready to start learning?</h2>
                  <p class="text-slate-400 mb-6">Explore all courses taught by {{ instructor.name }} and grow your skills today.</p>
                </div>
                <router-link
                  :to="`/courses?instructor=${instructor.userId}`"
                  class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 rounded-lg font-medium transition-all duration-300 transform hover:-translate-y-0.5"
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
  import { ref, computed, onMounted } from 'vue';
  import { useRoute } from 'vue-router';
  import { useInstructorStore } from '@/stores/InstructorStore';
  import { useCourseStore } from '@/stores/coursesStore';
  import defaultCoverImagePath from '@/assets/icons/instructor2.png';
  import { library } from '@fortawesome/fontawesome-svg-core';
  import {
  faChalkboardTeacher, faUser, faBriefcase, faUsers,
  faClock, faVideo, faGraduationCap, faInfoCircle, faArrowRight,
  faArrowLeft, faGlobe, faLightbulb, faUserFriends
} from '@fortawesome/free-solid-svg-icons';
  import { faLinkedinIn, faGithub } from '@fortawesome/free-brands-svg-icons';
  import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

  library.add(
  faChalkboardTeacher, faUser, faBriefcase, faUsers,
  faClock, faVideo, faGraduationCap, faInfoCircle, faArrowRight,
  faArrowLeft, faGlobe, faLightbulb, faUserFriends,
  faLinkedinIn, faGithub
);


  const route = useRoute();
  const instructorStore = useInstructorStore();
  const courseStore = useCourseStore();

  const instructor_profile_id = route.params.id;
  const instructor = ref(null);
  const loading = ref(true);
  const error = ref(null);
  const defaultAvatar = ref('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIHJ4PSI1MCIgZmlsbD0iIzRCNzY4OCIvPjxjaXJjbGUgY3g9IjUwIiBjeT0iNDAiIHI9IjE1IiBmaWxsPSJ3aGl0ZSIgZmlsbC1vcGFjaXR5PSIwLjgiLz48cGF0aCBkPSJNMjUgNzVjMC0xMy44IDExLjItMjUgMjUtMjVzMjUgMTEuMiAyNSAyNXYxMEgyNVY3NXoiIGZpbGw9IndoaXRlIiBmaWxsLW9wYWNpdHk9IjAuOCIvPjwvc3ZnPg==');
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
    return courseStore.courses.filter(course => course.instructorId === instructor.value?.userId);
  });

  // Get latest course
  const latestCourse = computed(() => {
    if (!instructor.value?.statistics?.latestCourse) {
      // Return a default course if no latest course exists
      return {
        title: 'Introduction to Web Development',
        description: 'Start your journey as a web developer with the fundamentals.',
        image: ' https://via.placeholder.com/600x400.png?text=No+Courses+Available',
        durationMinutes: 120,
        videos_count: 0,
        students_count: 0
      };
    }

    // Return the actual latest course
    return {
      ...instructor.value.statistics.latestCourse,
      course_id: instructor.value.statistics.latestCourse.id,
      durationMinutes: instructor.value.statistics.latestCourse.durationMinutes || 0,
      videos_count: instructor.value.statistics.latestCourse.videos_count || 0,
      students_count: instructor.value.statistics.latestCourse.students_count || 0
    };
  });
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
  </style>
