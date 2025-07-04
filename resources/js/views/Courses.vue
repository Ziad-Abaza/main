<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
    >
        <section class="relative overflow-hidden">
            <!-- Animated Background  -->
            <div class="absolute inset-0">
                <div
                    :class="
                        isDark
                            ? 'absolute top-20 left-10 w-72 h-72 bg-teal-600/10 rounded-full blur-3xl animate-pulse'
                            : 'absolute top-20 left-10 w-72 h-72 bg-teal-200/30 rounded-full blur-3xl animate-pulse'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute top-40 right-20 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000'
                            : 'absolute top-40 right-20 w-80 h-80 bg-purple-200/30 rounded-full blur-3xl animate-pulse delay-1000'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute bottom-20 left-1/3 w-60 h-60 bg-cyan-600/10 rounded-full blur-3xl animate-pulse delay-2000'
                            : 'absolute bottom-20 left-1/3 w-60 h-60 bg-cyan-200/30 rounded-full blur-3xl animate-pulse delay-2000'
                    "
                ></div>
            </div>

            <!-- Floating Particles -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute top-1/4 left-1/4 w-2 h-2 bg-teal-400 rounded-full animate-float"
                ></div>
                <div
                    class="absolute top-1/3 left-3/4 w-1.5 h-1.5 bg-purple-400 rounded-full animate-float-delayed"
                ></div>
                <div
                    class="absolute top-2/3 left-1/6 w-2.5 h-2.5 bg-cyan-400 rounded-full animate-float-slow"
                ></div>
            </div>

            <!-- Fixed Geometric Shapes Around Cards Area -->
            <!-- Diamond Shape - Top Left -->
            <div class="absolute inset-0 pointer-events-none">
                <div
                    :class="[
                        'absolute top-8 left-8 w-16 h-16 rotate-45 opacity-20',
                        isDark ? 'bg-teal-400' : 'bg-teal-300',
                    ]"
                ></div>

                <!-- Triangle Shape - Top Right -->
                <div
                    :class="[
                        'absolute top-12 right-12 w-0 h-0 opacity-15',
                        isDark
                            ? 'border-l-[20px] border-l-transparent border-r-[20px] border-r-transparent border-b-[35px] border-b-purple-400'
                            : 'border-l-[20px] border-l-transparent border-r-[20px] border-r-transparent border-b-[35px] border-b-purple-300',
                    ]"
                ></div>

                <!-- Hexagon Shape - Bottom Left -->
                <div
                    :class="[
                        'absolute bottom-16 left-12 w-12 h-12 opacity-25',
                        isDark ? 'bg-cyan-400' : 'bg-cyan-300',
                    ]"
                    style="
                        clip-path: polygon(
                            50% 0%,
                            100% 25%,
                            100% 75%,
                            50% 100%,
                            0% 75%,
                            0% 25%
                        );
                    "
                ></div>

                <!-- Square Shape - Bottom Right -->
                <div
                    :class="[
                        'absolute bottom-20 right-16 w-10 h-10 rotate-12 opacity-18',
                        isDark ? 'bg-teal-400' : 'bg-teal-300',
                    ]"
                ></div>

                <!-- Circle Shape - Middle Left -->
                <div
                    :class="[
                        'absolute top-1/2 left-6 w-8 h-8 rounded-full opacity-12',
                        isDark ? 'bg-purple-400' : 'bg-purple-300',
                    ]"
                ></div>

                <!-- Star Shape - Middle Right -->
                <div
                    :class="[
                        'absolute top-1/2 right-8 w-6 h-6 opacity-20',
                        isDark ? 'bg-cyan-400' : 'bg-cyan-300',
                    ]"
                    style="
                        clip-path: polygon(
                            50% 0%,
                            61% 35%,
                            98% 35%,
                            68% 57%,
                            79% 91%,
                            50% 70%,
                            21% 91%,
                            32% 57%,
                            2% 35%,
                            39% 35%
                        );
                    "
                ></div>

                <!-- Small Triangles - Scattered -->
                <div
                    :class="[
                        'absolute top-1/4 right-6 w-0 h-0 opacity-10',
                        isDark
                            ? 'border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-b-[14px] border-b-teal-400'
                            : 'border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-b-[14px] border-b-teal-300',
                    ]"
                ></div>

                <div
                    :class="[
                        'absolute bottom-1/3 left-4 w-0 h-0 opacity-12',
                        isDark
                            ? 'border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-b-[10px] border-b-purple-400'
                            : 'border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-b-[10px] border-b-purple-300',
                    ]"
                ></div>

                <!-- Abstract Lines -->
                <div
                    :class="[
                        'absolute top-1/3 left-2 w-12 h-0.5 rotate-45 opacity-8',
                        isDark
                            ? 'bg-gradient-to-r from-teal-400 to-transparent'
                            : 'bg-gradient-to-r from-teal-300 to-transparent',
                    ]"
                ></div>

                <div
                    :class="[
                        'absolute bottom-1/4 right-2 w-8 h-0.5 -rotate-30 opacity-8',
                        isDark
                            ? 'bg-gradient-to-r from-purple-400 to-transparent'
                            : 'bg-gradient-to-r from-purple-300 to-transparent',
                    ]"
                ></div>
            </div>

            <div class="container mx-auto px-6 py-16 relative z-10">
                <!-- Back button -->
                <div v-if="hasQuery" class="mb-8">
                    <button
                        @click="resetFilters"
                        :class="[
                            'inline-flex items-center gap-3 px-6 py-3 rounded-xl border',
                            isDark
                                ? 'glass-card-premium border-white/20'
                                : 'bg-white/50 border-slate-200/50',
                        ]"
                    >
                        <font-awesome-icon icon="arrow-left" />
                        <span class="font-medium">Back to All Courses</span>
                    </button>
                </div>

                <!-- Header section -->
                <div class="text-center mb-16">
                    <div
                        :class="[
                            'inline-flex items-center px-6 py-3 border rounded-full backdrop-blur-sm mb-6',
                            isDark
                                ? 'bg-gradient-to-r from-teal-500/20 via-cyan-500/20 to-purple-500/20 border-teal-500/30'
                                : 'bg-gradient-to-r from-teal-200/40 via-cyan-200/40 to-purple-200/40 border-teal-300/50',
                        ]"
                    >
                        <span
                            :class="[
                                'text-sm font-bold',
                                isDark ? 'text-teal-300' : 'text-teal-700',
                            ]"
                            >🎓 Discover Knowledge</span
                        >
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black mb-6">
                        <span
                            :class="[
                                'bg-clip-text text-transparent',
                                isDark
                                    ? 'bg-gradient-to-r from-white via-teal-100 to-purple-100'
                                    : 'bg-gradient-to-r from-slate-900 via-teal-800 to-purple-800',
                            ]"
                        >
                            Course Library
                        </span>
                    </h1>
                    <p
                        :class="[
                            'text-xl max-w-2xl mx-auto leading-relaxed',
                            isDark ? 'text-slate-300' : 'text-slate-600',
                        ]"
                    >
                        Explore our curated collection of
                        <span
                            :class="
                                isDark
                                    ? 'text-teal-400 font-semibold'
                                    : 'text-teal-700 font-semibold'
                            "
                            >premium courses</span
                        >
                        designed to accelerate your career growth
                    </p>
                </div>

                <!-- Search bar -->
                <div class="mb-12 max-w-2xl mx-auto">
                    <div class="relative">
                        <div
                            :class="[
                                'absolute inset-0 rounded-2xl blur-lg',
                                isDark
                                    ? 'bg-gradient-to-r from-teal-600/20 to-purple-600/20'
                                    : 'bg-gradient-to-r from-teal-600/10 to-purple-600/10',
                            ]"
                        ></div>
                        <div
                            :class="[
                                'relative rounded-2xl border',
                                isDark
                                    ? 'glass-card-premium border-white/20'
                                    : 'bg-white/50 border-slate-200/50',
                            ]"
                        >
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search for courses, instructors, or topics..."
                                :class="[
                                    'w-full p-6 bg-transparent placeholder:text-black focus:outline-none pl-14 pr-6 text-lg',
                                    isDark
                                        ? 'text-white placeholder:text-black'
                                        : 'text-slate-900 placeholder:text-slate-500',
                                ]"
                            />
                            <font-awesome-icon
                                icon="search"
                                :class="[
                                    'absolute left-5 top-1/2 transform -translate-y-1/2 text-xl',
                                    isDark ? 'text-teal-400' : 'text-teal-600',
                                ]"
                            />
                            <div
                                class="absolute right-4 top-1/2 transform -translate-y-1/2"
                            >
                                <div
                                    :class="[
                                        'px-3 py-1 rounded-lg text-xs border',
                                        isDark
                                            ? 'bg-teal-500/20 text-teal-300 border-teal-500/30'
                                            : 'bg-teal-500/10 text-teal-700 border-teal-500/20',
                                    ]"
                                >
                                    {{ filteredCourses.length }} found
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading and error states -->
                <div v-if="loading" class="text-center py-16">
                    <div
                        :class="[
                            'inline-flex items-center space-x-3',
                            isDark ? 'text-slate-400' : 'text-slate-600',
                        ]"
                    >
                        <div
                            class="animate-spin rounded-full h-8 w-8 border-b-2 border-teal-500"
                        ></div>
                        <span class="text-lg">Loading courses...</span>
                    </div>
                </div>

                <div
                    v-else-if="error"
                    :class="[
                        'text-center py-16 rounded-2xl p-8 border',
                        isDark
                            ? 'glass-card-premium border-red-500/20'
                            : 'bg-white/50 border-red-500/20',
                    ]"
                >
                    <div class="text-red-400 text-lg font-semibold">
                        {{ error }}
                    </div>
                    <button
                        @click="mounted"
                        :class="[
                            'mt-4 px-4 py-2 rounded-lg text-sm',
                            isDark
                                ? 'bg-teal-500/20 text-teal-300'
                                : 'bg-teal-500/10 text-teal-700',
                        ]"
                    >
                        Try Again
                    </button>
                </div>

                <!-- Course grid -->
                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <!-- Course card -->
                    <router-link
                        v-for="course in paginatedCourses"
                        :key="course.id"
                        :to="`/courses/${course.id}`"
                        class="block relative"
                    >
                        <div
                            :class="[
                                'rounded-3xl shadow-2xl overflow-hidden border h-full flex flex-col backdrop-blur-xl',
                                isDark
                                    ? 'glass-card-premium border-white/10'
                                    : 'bg-white/95 border-teal-200/40 shadow-lg',
                            ]"
                        >
                            <!-- Course image -->
                            <div class="relative overflow-hidden">
                                <img
                                    :src="course.image"
                                    :alt="course.title"
                                    class="w-full h-48 object-cover"
                                />
                                <!-- Discount badge -->
                                <div
                                    v-if="
                                        course.pricing.discountPercentage > 0 &&
                                        course.pricing.isActiveDiscount
                                    "
                                    class="absolute top-4 right-4 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs px-3 py-1 rounded-full font-bold shadow-lg"
                                >
                                    {{ course.pricing.discountPercentage }}% OFF
                                </div>
                            </div>

                            <!-- Course content -->
                            <div class="p-6 flex-1 flex flex-col">
                                <!-- Course title -->
                                <h3
                                    :class="[
                                        'text-xl font-bold mb-2 line-clamp-2',
                                        isDark
                                            ? 'text-white'
                                            : 'text-slate-900',
                                    ]"
                                >
                                    {{ course.title }}
                                </h3>

                                <!-- Course description -->
                                <p
                                    :class="[
                                        'mb-4 line-clamp-2 text-sm',
                                        isDark
                                            ? 'text-slate-300'
                                            : 'text-slate-600',
                                    ]"
                                >
                                    {{ course.description }}
                                </p>

                                <!-- Instructor info -->
                                <div
                                    class="flex items-center gap-2 mt-4 text-xs"
                                >
                                    <div
                                        class="w-6 h-6 rounded-full overflow-hidden border border-white/20"
                                    >
                                        <img
                                            :src="course.instructorImage"
                                            :alt="course.instructor"
                                            @error="
                                                $event.target.src = defaultImage
                                            "
                                            class="w-full h-full object-cover"
                                        />
                                    </div>
                                    <span
                                        :class="
                                            isDark
                                                ? 'text-slate-400'
                                                : 'text-slate-500'
                                        "
                                        >{{ course.instructor }}</span
                                    >
                                </div>

                                <!-- Course meta -->
                                <div
                                    class="grid grid-cols-2 gap-2 mt-4 text-sm"
                                >
                                    <div class="flex items-center gap-1.5">
                                        <font-awesome-icon
                                            :icon="[
                                                'fas',
                                                'chalkboard-teacher',
                                            ]"
                                            :class="
                                                isDark
                                                    ? 'text-teal-400'
                                                    : 'text-teal-600'
                                            "
                                        />
                                        <span
                                            :class="
                                                isDark
                                                    ? 'text-slate-400'
                                                    : 'text-slate-500'
                                            "
                                            >{{ course.category }}</span
                                        >
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <font-awesome-icon
                                            :icon="['fas', 'video']"
                                            :class="
                                                isDark
                                                    ? 'text-purple-400'
                                                    : 'text-purple-600'
                                            "
                                        />
                                        <span
                                            :class="
                                                isDark
                                                    ? 'text-slate-400'
                                                    : 'text-slate-500'
                                            "
                                            >{{ course.videoCount }}
                                            {{
                                                course.videoCount === 1
                                                    ? "Lesson"
                                                    : "Lessons"
                                            }}</span
                                        >
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <font-awesome-icon
                                            :icon="['fas', 'clock']"
                                            :class="
                                                isDark
                                                    ? 'text-cyan-400'
                                                    : 'text-cyan-600'
                                            "
                                        />
                                        <span
                                            :class="
                                                isDark
                                                    ? 'text-slate-400'
                                                    : 'text-slate-500'
                                            "
                                            >{{
                                                course.details.durationMinutes
                                            }}
                                            min</span
                                        >
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <font-awesome-icon
                                            :icon="['fas', 'user-friends']"
                                            :class="
                                                isDark
                                                    ? 'text-emerald-400'
                                                    : 'text-emerald-600'
                                            "
                                        />
                                        <span
                                            :class="
                                                isDark
                                                    ? 'text-slate-400'
                                                    : 'text-slate-500'
                                            "
                                            v-if="
                                                course.enrollment.maxStudents >
                                                0
                                            "
                                        >
                                            {{
                                                course.enrollment
                                                    .currentStudents
                                            }}/{{
                                                course.enrollment.maxStudents
                                            }}
                                        </span>
                                        <span
                                            :class="
                                                isDark
                                                    ? 'text-slate-400'
                                                    : 'text-slate-500'
                                            "
                                            v-else
                                            >Unlimited</span
                                        >
                                    </div>
                                </div>

                                <!-- Price info -->
                                <div
                                    class="mt-6 flex items-center justify-between"
                                >
                                    <div
                                        v-if="
                                            course.pricing.discountedPrice >
                                                0 &&
                                            course.pricing.isActiveDiscount
                                        "
                                        :class="[
                                            'font-bold text-lg',
                                            isDark
                                                ? 'text-white'
                                                : 'text-slate-900',
                                        ]"
                                    >
                                        ${{ course.pricing.discountedPrice }}
                                        <span
                                            :class="[
                                                'ml-2 text-sm line-through',
                                                isDark
                                                    ? 'text-slate-400'
                                                    : 'text-slate-500',
                                            ]"
                                            >${{
                                                course.pricing.originalPrice
                                            }}</span
                                        >
                                    </div>
                                    <div
                                        v-else
                                        :class="[
                                            'font-bold text-lg',
                                            isDark
                                                ? 'text-white'
                                                : 'text-slate-900',
                                        ]"
                                    >
                                        ${{ course.pricing.originalPrice }}
                                    </div>

                                    <button
                                        class="px-6 py-3 bg-gradient-to-r from-teal-600 to-purple-600 rounded-xl text-sm font-semibold text-white shadow-lg"
                                    >
                                        <span class="flex items-center gap-2">
                                            <span>View Details</span>
                                            <font-awesome-icon
                                                icon="arrow-right"
                                                class="text-xs"
                                            />
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>

                <!-- Pagination -->
                <div class="mt-16 flex justify-center">
                    <div
                        :class="[
                            'p-4 rounded-2xl shadow-2xl border',
                            isDark
                                ? 'glass-card-premium border-white/20'
                                : 'bg-white/50 border-slate-200/50',
                        ]"
                    >
                        <nav class="flex items-center gap-2">
                            <!-- Previous Button -->
                            <button
                                @click="goToPage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-700 text-white rounded-xl disabled:opacity-50 disabled:cursor-not-allowed shadow-lg"
                            >
                                <font-awesome-icon
                                    icon="chevron-left"
                                    class="text-sm"
                                />
                                <span class="font-medium">Previous</span>
                            </button>

                            <!-- Page numbers -->
                            <div class="flex items-center gap-1 mx-4">
                                <button
                                    v-for="page in visiblePages"
                                    :key="page"
                                    @click="goToPage(page)"
                                    :class="[
                                        'w-12 h-12 rounded-xl flex items-center justify-center font-semibold',
                                        {
                                            'bg-gradient-to-r from-teal-600 to-purple-600 text-white shadow-lg':
                                                currentPage === page,
                                        },
                                        currentPage !== page &&
                                            (isDark
                                                ? 'text-slate-400'
                                                : 'text-slate-600'),
                                    ]"
                                >
                                    {{ page }}
                                </button>
                            </div>

                            <!-- Next Button -->
                            <button
                                @click="goToPage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-700 to-teal-600 text-white rounded-xl disabled:opacity-50 disabled:cursor-not-allowed shadow-lg"
                            >
                                <span class="font-medium">Next</span>
                                <font-awesome-icon
                                    icon="chevron-right"
                                    class="text-sm"
                                />
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { useCourseStore } from "@/stores/coursesStore";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import defaultImage from "@/assets/icons/EduStream.jpg";
import {
    faChevronLeft,
    faChevronRight,
    faSearch,
    faChalkboardTeacher,
    faVideo,
    faClock,
    faUserFriends,
    faArrowLeft,
    faArrowRight,
} from "@fortawesome/free-solid-svg-icons";
import { useRoute, useRouter } from "vue-router";
import { useTheme } from "../composables/useTheme";

library.add(
    faChevronLeft,
    faChevronRight,
    faSearch,
    faChalkboardTeacher,
    faVideo,
    faClock,
    faUserFriends,
    faArrowLeft,
    faArrowRight
);

const coursesStore = useCourseStore();
const currentPage = ref(1);
const itemsPerPage = ref(9);
const route = useRoute();
const router = useRouter();
const { isDark } = useTheme();

const category = route.query.category;
const search = route.query.search;
const searchQuery = ref(search || "");
const hasQuery = computed(() => !!route.query.search || !!route.query.category);
const loading = ref(false);
const error = ref(null);

// Reset filters and go back to main courses page
const resetFilters = () => {
    searchQuery.value = "";
    currentPage.value = 1;
    router.push({ path: "/courses" });
    fetchCourses();
};

// Watch for changes in the search query
watch(searchQuery, (newVal) => {
    router.push({
        query: {
            ...route.query,
            search: newVal || undefined,
        },
    });
});

// Watch for changes in the route query
watch(
    () => route.query,
    (newQuery) => {
        if (newQuery.search !== searchQuery.value) {
            searchQuery.value = newQuery.search || "";
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
const totalPages = computed(() =>
    Math.ceil(filteredCourses.value.length / itemsPerPage.value)
);

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
        window.scrollTo({ top: 0, behavior: "smooth" });
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
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

@keyframes float {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }
    33% {
        transform: translateY(-10px) rotate(1deg);
    }
    66% {
        transform: translateY(5px) rotate(-1deg);
    }
}
@keyframes float-delayed {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }
    33% {
        transform: translateY(-15px) rotate(-1deg);
    }
    66% {
        transform: translateY(8px) rotate(1deg);
    }
}
@keyframes float-slow {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(2deg);
    }
}
.animate-float {
    animation: float 6s ease-in-out infinite;
}
.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
    animation-delay: 2s;
}
.animate-float-slow {
    animation: float-slow 10s ease-in-out infinite;
    animation-delay: 1s;
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

button:focus,
a:focus {
    outline: 2px solid #14b8a6;
    outline-offset: 2px;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.1);
}
button:focus-visible,
a:focus-visible,
router-link:focus-visible {
    outline: 2px solid #14b8a6;
    outline-offset: 4px;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.2);
}
.dark button:focus-visible,
.dark a:focus-visible,
.dark router-link:focus-visible {
    outline: 2px solid #5eead4;
    outline-offset: 4px;
    box-shadow: 0 0 0 4px rgba(94, 234, 212, 0.3);
}

@media (max-width: 768px) {
    .glass-card-premium {
        backdrop-filter: blur(15px);
    }
    .text-5xl {
        font-size: 2.5rem;
    }
    .text-6xl {
        font-size: 3rem;
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
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
