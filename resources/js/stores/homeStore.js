import { defineStore } from "pinia";
import axios from "axios";

export const useHomeStore = defineStore("home", {
    state: () => ({
        featuredCourses: [],
        popularCategories: [],
        topInstructors: [],
        limitedTimeOffers: [],
        latestNews: [],
        loading: false,
        error: null,
        lastFetched: null,
    }),

    getters: {
        // Get total number of featured courses
        totalFeaturedCourses: (state) => state.featuredCourses.length,

        // Get total number of categories
        totalCategories: (state) => state.popularCategories.length,

        // Get total number of instructors
        totalInstructors: (state) => state.topInstructors.length,

        // Get total number of offers
        totalOffers: (state) => state.limitedTimeOffers.length,

        // Get total number of news articles
        totalNews: (state) => state.latestNews.length,

        // Get courses by category
        getCoursesByCategory: (state) => (categoryId) => {
            return state.featuredCourses.filter(
                (course) => course.categoryId === categoryId
            );
        },

        // Get instructor by ID
        getInstructorById: (state) => (instructorId) => {
            return state.topInstructors.find(
                (instructor) => instructor.id === instructorId
            );
        },

        // Get course by ID
        getCourseById: (state) => (courseId) => {
            return state.featuredCourses.find(
                (course) => course.id === courseId
            );
        },

        // Check if data is stale (older than 5 minutes)
        isDataStale: (state) => {
            if (!state.lastFetched) return true;
            const fiveMinutesAgo = new Date(Date.now() - 5 * 60 * 1000);
            return new Date(state.lastFetched) < fiveMinutesAgo;
        },

        // Get loading status
        isLoading: (state) => state.loading,

        // Get error message
        getError: (state) => state.error,
    },

    actions: {
        async fetchHomeData(forceRefresh = false) {
            // Don't fetch if already loading
            if (this.loading) return;

            // Don't fetch if data is fresh and not forcing refresh
            if (!forceRefresh &&
                !this.isDataStale &&
                this.featuredCourses.length > 0
            ) {
                return;
            }

            this.loading = true;
            this.error = null;

            try {
                const response = await axios.get("/api/home");

                if (response.data.success) {
                    const data = response.data.data;

                    // Map API response to state
                    this.featuredCourses = data.featured_courses.map(
                        (course) => ({
                            id: course.course_id,
                            title: course.title,
                            description: course.description,
                            instructor: course.instructor_name,
                            category: course.category,
                            categoryId: course.category_id,
                            videoCount: course.video_count,
                            image: course.image || "default-image.jpg",
                            price: course.price || 0,
                            rating: course.rating || 0,
                            enrolledCount: course.enrolled_count || 0,
                        })
                    );

                    this.popularCategories = data.popular_categories.map(
                        (category) => ({
                            id: category.category_id,
                            name: category.category_name,
                            icon: category.icon || "fas fa-folder",
                            courses_count: category.courses_count,
                            description: category.description || "",
                        })
                    );

                    this.limitedTimeOffers = data.limited_time_offers.map(
                        (offer) => ({
                            id: offer.course_id,
                            title: offer.title,
                            category: offer.category,
                            instructor: offer.instructor_name,
                            originalPrice: parseFloat(offer.original_price),
                            discountedPrice: offer.discounted_price ?
                                parseFloat(offer.discounted_price) : null,
                            discount: offer.discount ?
                                parseFloat(offer.discount) : 0,
                            timeLeft: offer.timeLeft,
                            enrollments: offer.enrollments,
                            image: offer.image || "default-image.jpg",
                        })
                    );

                    this.topInstructors = data.top_instructors.map(
                        (instructor) => ({
                            id: instructor.instructor_profile_id,
                            name: instructor.name,
                            specialization: instructor.specialization,
                            image: instructor.image || "default-image.jpg",
                            experience: instructor.experience,
                            skills: instructor.skills || [],
                            rating: instructor.rating || 0,
                            coursesCount: instructor.courses_count || 0,
                            studentsCount: instructor.students_count || 0,
                        })
                    );

                    // Map latest news data
                    this.latestNews = data.latest_news ? data.latest_news.map(
                        (article) => ({
                            id: article.id,
                            title: article.title,
                            excerpt: article.excerpt,
                            content: article.content,
                            images: article.images || [],
                            image: article.image,
                            category: article.category,
                            date: article.date,
                            tags: article.tags || [],
                            author: {
                                name: article.author ?.name || "Unknown",
                                role: article.author ?.role || "Author",
                                avatar: article.author ?.avatar || null,
                            },
                        })
                    ) : [];

                    // Update last fetched timestamp
                    this.lastFetched = new Date().toISOString();
                } else {
                    this.error =
                        response.data.message || "Failed to fetch data";
                }
            } catch (err) {
                console.error("Error fetching home data:", err);
                this.error =
                    err.response ?.data ?.message ||
                    err.message ||
                    "An error occurred while fetching data";
            } finally {
                this.loading = false;
            }
        },

        // Clear all data
        clearData() {
            this.featuredCourses = [];
            this.popularCategories = [];
            this.topInstructors = [];
            this.limitedTimeOffers = [];
            this.error = null;
            this.lastFetched = null;
        },

        // Clear error
        clearError() {
            this.error = null;
        },

        // Refresh data
        async refreshData() {
            await this.fetchHomeData(true);
        },

        // Get random course
        getRandomCourse() {
            if (this.featuredCourses.length === 0) return null;
            const randomIndex = Math.floor(
                Math.random() * this.featuredCourses.length
            );
            return this.featuredCourses[randomIndex];
        },

        // Get courses by instructor
        getCoursesByInstructor(instructorName) {
            return this.featuredCourses.filter(
                (course) => course.instructor === instructorName
            );
        },

        // Get top rated courses
        getTopRatedCourses(limit = 5) {
            return [...this.featuredCourses]
                .sort((a, b) => (b.rating || 0) - (a.rating || 0))
                .slice(0, limit);
        },

        // Get most enrolled courses
        getMostEnrolledCourses(limit = 5) {
            return [...this.featuredCourses]
                .sort((a, b) => (b.enrolledCount || 0) - (a.enrolledCount || 0))
                .slice(0, limit);
        },
    },
});