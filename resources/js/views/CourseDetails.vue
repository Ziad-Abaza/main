<template>
    <div :class="['min-h-screen', isDark ? 'bg-slate-900 text-white' : 'bg-blue-50 text-slate-900']">
        <!-- Back Button -->
        <div class="container mx-auto px-6 py-6">
            <router-link to="/courses"
                :class="['group inline-flex items-center gap-3 px-6 py-3 rounded-xl border transition-all duration-300 hover:scale-105', isDark ? 'glass-card-premium border-white/20 hover:border-blue-500/50' : 'bg-white border-blue-100 hover:border-blue-300 shadow']">
                <font-awesome-icon :icon="['fas', 'arrow-left']" class="text-lg" />
                <span class="font-medium">Back to Courses</span>
            </router-link>
        </div>

        <!-- Loading State -->
        <div v-if="courseDetailsStore.loading" class="flex justify-center py-20">
            <div :class="isDark ? 'animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500' : 'animate-spin rounded-full h-12 w-12 border-b-2 border-blue-400'"></div>
            <span :class="isDark ? 'ml-3 text-slate-400' : 'ml-3 text-slate-500'">Loading course details...</span>
        </div>

        <!-- Error State -->
        <div v-else-if="courseDetailsStore.error" class="text-center py-20">
            <h3 :class="isDark ? 'text-red-400 text-xl' : 'text-red-600 text-xl'">{{ courseDetailsStore.error }}</h3>
        </div>

        <!-- Course Content -->
        <div v-else class="container mx-auto px-6 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Course Info Card -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Course Hero -->
                    <div :class="['rounded-2xl overflow-hidden shadow-2xl', isDark ? 'glass-card-premium' : 'bg-white border border-blue-100']">
                        <img :src="course.image || defaultImage" :alt="course.title" class="w-full h-64 object-cover" />
                        <div class="p-6">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span :class="isDark ? 'bg-blue-900/50 text-blue-300' : 'bg-blue-100 text-blue-700'" class="text-xs px-2.5 py-0.5 rounded-full">{{
                                    course.level }} Level</span>
                                <span :class="isDark ? 'bg-purple-900/50 text-purple-300' : 'bg-purple-100 text-purple-700'" class="text-xs px-2.5 py-0.5 rounded-full">{{
                                    course.language }}</span>
                                <span :class="isDark ? 'bg-green-900/50 text-green-300' : 'bg-green-100 text-green-700'" class="text-xs px-2.5 py-0.5 rounded-full">{{
                                    stats.videos_count }}
                                    {{ stats.videos_count === 1 ? "Lesson" : "Lessons" }}</span>
                            </div>

                            <h1 class="text-3xl font-bold mb-4">{{ course.title }}</h1>
                            <p :class="isDark ? 'text-slate-300 mb-6' : 'text-slate-600 mb-6'">{{ course.description }}</p>

                            <!-- Instructor Info -->
                            <div class="flex items-center gap-4 mt-6">
                                <div class="relative w-12 h-12 rounded-full overflow-hidden">
                                    <img :src="instructor.avatar || defaultAvatar" alt="Instructor Avatar"
                                        class="w-full h-full object-cover" />
                                </div>
                                <div>
                                    <h3 class="font-semibold">{{ instructor.name }}</h3>
                                    <p :class="isDark ? 'text-sm text-slate-400' : 'text-sm text-slate-500'">{{ instructor.email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Details Tabs -->
                    <div :class="['rounded-2xl p-6 space-y-6', isDark ? 'glass-card-premium' : 'bg-white border border-blue-100']">
                        <h2 class="text-xl font-bold mb-4">Course Details</h2>

                        <!-- Objectives -->
                        <div>
                            <h3 class="font-semibold text-lg">Objectives</h3>
                            <p :class="isDark ? 'text-slate-300 mt-2' : 'text-slate-600 mt-2'">{{ details.objectives }}</p>
                        </div>

                        <!-- Prerequisites -->
                        <div>
                            <h3 class="font-semibold text-lg">Prerequisites</h3>
                            <p :class="isDark ? 'text-slate-300 mt-2' : 'text-slate-600 mt-2'">{{ details.prerequisites }}</p>
                        </div>

                        <!-- Content -->
                        <div>
                            <h3 class="font-semibold text-lg">Content</h3>
                            <p :class="isDark ? 'text-slate-300 mt-2' : 'text-slate-600 mt-2'">{{ details.content }}</p>
                        </div>
                    </div>

                    <!-- Videos Section -->
                    <div :class="['rounded-2xl p-6 space-y-4', isDark ? 'glass-card-premium' : 'bg-white border border-blue-100']">
                        <h2 class="text-xl font-bold mb-4">Videos</h2>

                        <!-- Scrollable container -->
                        <div class="max-h-80 overflow-y-auto pr-2 custom-scrollbar space-y-2">
                            <div v-for="video in videos" :key="video.id" :class="['group flex items-center gap-4 p-3 rounded-lg cursor-pointer transition', isDark ? 'hover:bg-white/5' : 'hover:bg-blue-50']">
                                <div :class="isDark ? 'w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center' : 'w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center'">
                                    <font-awesome-icon :icon="['fas', 'play']" :class="isDark ? 'text-2xl text-blue-400' : 'text-2xl text-blue-600'" />
                                </div>
                                <div class="flex-1">
                                    <h3 :class="isDark ? 'font-semibold group-hover:text-blue-400 transition' : 'font-semibold group-hover:text-blue-700 transition'">{{ video.title }}
                                    </h3>
                                    <p :class="isDark ? 'text-sm text-slate-400' : 'text-sm text-slate-500'">{{ formatDuration(video.duration) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar - Pricing & Enrollment -->
                <div class="space-y-6">
                    <!-- Pricing Card -->
                    <div :class="['rounded-2xl p-6', isDark ? 'glass-card-premium' : 'bg-white border border-blue-100']">
                        <h3 class="font-bold text-lg mb-4">Pricing</h3>

                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span :class="isDark ? 'text-slate-400' : 'text-slate-500'">Original Price</span>
                                <span :class="isDark ? 'text-slate-300 line-through' : 'text-slate-400 line-through'">${{ pricing.original_price }}</span>
                            </div>

                            <div v-if="pricing.discounted_price" class="flex justify-between">
                                <span :class="isDark ? 'text-yellow-400 font-medium' : 'text-yellow-600 font-medium'">Discounted Price</span>
                                <span :class="isDark ? 'text-yellow-300 font-bold' : 'text-yellow-700 font-bold'">${{ pricing.discounted_price }}</span>
                            </div>

                            <div v-if="pricing.discount_percentage" class="mt-2">
                                <span :class="isDark ? 'inline-block bg-yellow-500/20 text-yellow-400 text-sm px-3 py-1 rounded-full' : 'inline-block bg-yellow-100 text-yellow-700 text-sm px-3 py-1 rounded-full'">
                                    {{ pricing.discount_percentage }}% OFF
                                </span>
                            </div>

                            <div class="flex justify-between text-sm mt-4" :class="isDark ? 'text-slate-400' : 'text-slate-500'">
                                <span>Remaining Time: </span>
                                <span>{{ pricing.time_left }}</span>
                            </div>
                        </div>
                    </div>


                    <!-- Enrolled Success Message -->
                    <div v-if="enrolled" class="mb-6">
                        <div :class="isDark ? 'bg-green-900/80 border border-green-400 text-green-200' : 'bg-green-50 border border-green-200 text-green-800'" class="rounded-xl px-6 py-5 flex flex-col md:flex-col md:items-center md:justify-between gap-4 shadow-lg animate__animated animate__fadeInDown">
                            <div class="flex items-center gap-3">
                                <font-awesome-icon icon="trophy" :class="isDark ? 'text-yellow-400 text-2xl' : 'text-yellow-600 text-2xl'" />
                                <span :class="isDark ? 'font-bold text-lg' : 'font-bold text-lg'">🎉 You're Enrolled!</span>
                            </div>
                            <div :class="isDark ? 'text-green-100' : 'text-green-700'">You have access to all course content. Start learning now!</div>
                            <router-link :to="`/videos/${courseId}`" :class="isDark ? 'btn btn-primary bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition' : 'btn btn-primary bg-blue-500 hover:bg-blue-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition'">
                                View All Videos
                            </router-link>
                        </div>
                    </div>


                    <!-- Enroll Card -->
                    <div v-else :class="['rounded-2xl p-6', isDark ? 'glass-card-premium' : 'bg-white border border-blue-100']">
                        <h3 class="font-bold text-lg mb-4">Enrollment</h3>

                        <div class="space-y-4">
                            <div class="flex justify-between text-sm" :class="isDark ? 'text-slate-400' : 'text-slate-500'">
                                <span>Max Students</span>
                                <span>{{ enrollment.max_students }}</span>
                            </div>
                            <div class="flex justify-between text-sm" :class="isDark ? 'text-slate-400' : 'text-slate-500'">
                                <span>Current Enrolled</span>
                                <span>{{ enrollment.current_students }}</span>
                            </div>
                            <div class="flex justify-between text-sm" :class="isDark ? 'text-slate-400' : 'text-slate-500'">
                                <span>Available Seats</span>
                                <span>{{ enrollment.available_seats }}</span>
                            </div>

                            <div class="pt-4 border-t" :class="isDark ? 'border-white/10' : 'border-blue-100'">
                                <button @click="enroll" :disabled="is_processing_enrollment || isEnrolling"
                                    :class="['cursor-pointer w-full py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed', isDark ? 'bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white' : 'bg-gradient-to-r from-blue-500 to-indigo-400 hover:from-blue-400 hover:to-indigo-500 text-white']">
                                    <font-awesome-icon icon="chalkboard-teacher" />
                                    <span>{{
                                        is_processing_enrollment
                                            ? "Reviewing..."
                                            : enrolled
                                                ? "You are enrolled"
                                                : isEnrolling
                                                    ? "Processing..."
                                                    : "Enroll Now"
                                    }}</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div :class="['rounded-2xl p-6', isDark ? 'glass-card-premium' : 'bg-white border border-blue-100']">
                        <h3 class="font-bold text-lg mb-4">Category</h3>
                        <div class="flex items-center gap-3">
                            <div :class="isDark ? 'w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center' : 'w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center'">
                                <font-awesome-icon icon="layer-group" :class="isDark ? 'text-blue-400' : 'text-blue-600'" />
                            </div>
                            <span :class="isDark ? 'text-white' : 'text-blue-900'">{{ category.name }}</span>
                        </div>
                    </div>

                    <!-- Certificates -->
                    <div :class="['rounded-2xl p-6', isDark ? 'glass-card-premium' : 'bg-white border border-blue-100']">
                        <h3 class="font-bold text-lg mb-4">Certificate</h3>
                        <div class="flex items-center gap-3">
                            <font-awesome-icon icon="certificate" :class="isDark ? 'text-emerald-400' : 'text-emerald-600'" />
                            <span :class="isDark ? 'text-white' : 'text-blue-900'">{{
                                certificates.some((cert) => cert.course_has_certificate)
                                    ? "This course includes a certificate"
                                    : "No certificate available"
                            }}</span>
                        </div>
                    </div>

                    <!-- Coupons -->
                    <div :class="['rounded-2xl p-6', isDark ? 'glass-card-premium' : 'bg-white border border-blue-100']">
                        <h3 class="font-bold text-lg mb-4">Coupons</h3>

                        <div v-if="coupons.length > 0">
                            <p :class="isDark ? 'text-slate-300 mb-4' : 'text-slate-600 mb-4'">Enter your coupon code to get a discount on this course.</p>
                            <!-- Apply Coupon Form -->
                            <div class="mt-6">
                                <form @submit.prevent="applyCoupon" class="flex flex-col sm:flex-row gap-3">
                                    <input v-model="couponCode" type="text" placeholder="Enter coupon code"
                                        :class="['flex-1 px-4 py-2 rounded-lg focus:outline-none', isDark ? 'bg-slate-800 border border-slate-700 text-white placeholder:text-slate-500 focus:border-blue-500' : 'bg-blue-50 border border-blue-200 text-slate-900 placeholder:text-blue-400 focus:border-blue-500']"
                                        required />
                                    <button type="submit"
                                        :class="['cursor-pointer px-4 py-2 font-semibold rounded-lg transition-all duration-300', isDark ? 'bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white' : 'bg-gradient-to-r from-purple-400 to-indigo-300 hover:from-purple-300 hover:to-indigo-400 text-white']">
                                        Apply Coupon
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- حالة: لا توجد كوبونات -->
                        <div v-else class="text-center py-6">
                            <div :class="isDark ? 'text-slate-400 italic' : 'text-slate-500 italic'">
                                No coupons are currently available for this course.
                            </div>
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
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { useCourseStore } from '@/stores/coursesStore';
import { useTheme } from '../composables/useTheme';
const { isDark } = useTheme();

import {
    faVideo,
    faClock,
    faTrophy,
    faChalkboardTeacher,
    faArrowLeft,
    faPlay,
    faCertificate,
    faLayerGroup,
} from '@fortawesome/free-solid-svg-icons';

library.add(faVideo, faClock, faTrophy, faChalkboardTeacher, faArrowLeft, faPlay, faCertificate, faLayerGroup);

const route = useRoute();
const courseId = route.params.id;
const courseDetailsStore = useCourseStore();

// Data Computed
const course = computed(() => courseDetailsStore.course.info || {});
const instructor = computed(() => courseDetailsStore.course.instructor || {});
const category = computed(() => courseDetailsStore.course.category || {});
const details = computed(() => courseDetailsStore.course.details || {});
const enrollment = computed(() => courseDetailsStore.course.enrollment || {});
const pricing = computed(() => courseDetailsStore.course.pricing || {});
const stats = computed(() => courseDetailsStore.course.stats || {});
const videos = computed(() => courseDetailsStore.course.videos || []);
const certificates = computed(() => courseDetailsStore.course.certificates || []);
const coupons = computed(() => courseDetailsStore.course.coupons || []);
const enrolled = computed(() => courseDetailsStore.enrolled || false);
const is_processing_enrollment = computed(() => courseDetailsStore.course.enrollment?.is_processing > 0);

// Methods
const defaultImage = "https://i.ibb.co/67ZKPkmK/logo.png ";
const defaultAvatar = "https://i.ibb.co/67ZKPkmK/instructor-default.jpg ";

const isEnrolling = ref(false);

function formatDuration(seconds) {
    const minutes = Math.floor(seconds / 60);
    return `${minutes} min`;
}

async function enroll() {
    isEnrolling.value = true;
    await courseDetailsStore.enrollInCourse(courseId);
    if (!courseDetailsStore.error) {
        await courseDetailsStore.fetchCourseDetails(courseId);
    }
    isEnrolling.value = false;
}

onMounted(() => {
    courseDetailsStore.fetchCourseDetails(courseId);
});
</script>

<style scoped>
.glass-card-premium {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

@keyframes float {

    0%,
    100% {
        transform: translateY(0px);
    }

    33% {
        transform: translateY(-10px);
    }

    66% {
        transform: translateY(5px);
    }
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
}

.bg-blue-50 {
    background: #f0f6ff !important;
}

.border-blue-100 {
    border-color: #dbeafe !important;
}
</style>
