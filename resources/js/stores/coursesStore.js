import { defineStore } from "pinia";
import axios from "axios";
import { useAuthStore } from '@/stores/auth';

// Default images
const defaultImage = "https://i.ibb.co/67ZKPkmK/logo.png";
const defaultIcon = "https://i.ibb.co/67ZKPkmK/logo.png";

export const useCourseStore = defineStore("courseDetails", {
    state: () => ({
        course: {
            info: null,
            instructor: null,
            category: null,
            details: null,
            enrollment: null,
            pricing: null,
            stats: null,
            videos: [],
            certificates: [],
            coupons: [],
        },
        enrolled: false,
        loading: false,
        error: null,
        courses: [],
        total: 0,
        currentPage: 1,
        perPage: 10,
    }),

    actions: {
        async fetchCourseDetails(courseId) {
            this.loading = true;
            this.error = null;
            this.enrolled = false; // Reset enrolled state for course list
            try {
                const response = await axios.get(`/api/courses/${courseId}`);
                if (response.data.success) {
                    console.log("Course Details Response:", response.data);
                    const data = response.data.data;

                    this.course.info = data.course;
                    this.course.instructor = data.instructor;
                    this.course.category = data.category;
                    this.course.details = data.details;
                    this.course.enrollment = data.enrollment;
                    this.course.pricing = data.pricing;
                    this.course.stats = data.stats;
                    this.course.videos = data.relationships.videos || [];
                    this.course.certificates =
                        data.relationships.certificates || [];
                    this.course.coupons = data.relationships.coupons || [];
                    this.course.is_processing_enrollment = data.is_processing_enrollment || false;

                    this.enrolled = response.data.data.enrolled;
                } else {
                    this.error =
                        response.data.message ||
                        "Failed to fetch course details";
                }
            } catch (error) {
                this.error = error.message || "An unexpected error occurred";
            } finally {
                this.loading = false;
            }
        },

        async enrollInCourse(courseId) {
            this.error = null;
            try {
                const authStore = useAuthStore();
                const response = await axios.post(
                    `/api/courses/${courseId}/enroll`, {}, {
                        headers: {
                            Authorization: `Bearer ${authStore.token}`,
                            'X-Beaker-Token': authStore.beaker_token,
                            Accept: 'application/json',
                            'Content-Type': 'application/json'
                        }
                    }
                );
                if (response.data.success) {
                    // Optimistically update the course state
                    this.course.is_processing_enrollment = true;
                } else {
                    this.error = response.data.message || "Failed to enroll in course";
                }
            } catch (error) {
                this.error = error.message || "An unexpected error occurred";
            } finally {
                this.loading = false;
            }
        },

        async fetchCourses(
            page = 1,
            perPage = 10,
            categoryId = null,
            search = null
        ) {
            try {
                this.enrolled = false;
                const params = { page, per_page: perPage };
                if (categoryId) {
                    params.category_id = categoryId;
                }
                if (search) {
                    params.search = search;
                }

                const response = await axios.get("/api/courses", { params });
                console.log("Courses Response:", response.data);

                if (response.data.success) {
                    const now = new Date();

                    this.courses = response.data.data.map((course) => {
                        const originalPrice = parseFloat(
                            course.pricing ?.price || 0
                        );
                        const discountedPrice = parseFloat(
                            course.pricing ?.discount_price || 0
                        );
                        const discountPercentage =
                            originalPrice > 0 ?
                            Math.round(
                                ((originalPrice - discountedPrice) /
                                    originalPrice) *
                                100
                            ) :
                            0;

                        const discountStart = new Date(
                            course.pricing ?.discount_start
                        );
                        const discountEnd = new Date(
                            course.pricing ?.discount_end
                        );
                        const isActiveDiscount = !isNaN(discountStart) &&
                            !isNaN(discountEnd) &&
                            now >= discountStart &&
                            now <= discountEnd;

                        return {
                            id: course.course_id,
                            title: course.title,
                            description: course.description,
                            instructor: course.instructor_name,
                            instructorId: course.instructor_id,
                            instructorImage: course.instructor_image || defaultImage,
                            category: course.category_name,
                            videoCount: course.videos_count,
                            image: course.image || defaultImage,
                            icon: course.icon || defaultIcon,
                            details: {
                                level: course.details ?.level || "Not specified",
                                language: course.details ?.language || "Not specified",
                                status: course.details ?.status || "Unavailable",
                                total_duration: course.details ?.total_duration || "0:00",
                            },
                            pricing: {
                                originalPrice,
                                discountedPrice,
                                discountPercentage,
                                isActiveDiscount,
                                discountStart: course.pricing ?.discount_start,
                                discountEnd: course.pricing ?.discount_end,
                            },
                            enrollment: {
                                maxStudents: course.enrollment ?.max_students || 0,
                                currentStudents: course.enrollment ?.current_students || 0,
                                availableSeats: course.enrollment ?.available_seats || 0,
                            },
                        };
                    });

                    this.total = response.data.pagination.total;
                    this.currentPage = response.data.pagination.current_page;
                    this.perPage = response.data.pagination.per_page;
                }
            } catch (error) {
                console.error("Error fetching courses:", error);
                this.error = "Failed to load courses. Please try again later.";
            }
        },
    },
});