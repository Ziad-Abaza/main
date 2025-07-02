import { defineStore } from 'pinia';
import axios from 'axios';

export const useHomeStore = defineStore('home', {
    state: () => ({
        featuredCourses: [],
        popularCategories: [],
        topInstructors: [],
        limitedTimeOffers: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchHomeData() {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get('/api/home');
                if (response.data.success) {
                    const data = response.data.data;

                    // Map API response to state
                    this.featuredCourses = data.featured_courses.map(course => ({
                        id: course.course_id,
                        title: course.title,
                        description: course.description,
                        instructor: course.instructor_name,
                        category: course.category,
                        videoCount: course.video_count,
                        image: course.image || 'default-image.jpg',
                    }));

                    this.popularCategories = data.popular_categories.map(category => ({
                        id: category.category_id,
                        name: category.category_name,
                        icon: category.icon || 'fas fa-folder',
                        courseCount: category.courses_count,
                    }));

                    this.limitedTimeOffers = data.limited_time_offers.map(
                        (offer) => ({
                            id: offer.course_id,
                            title: offer.title,
                            category: offer.category,
                            instructor: offer.instructor_name,
                            originalPrice: parseFloat(offer.original_price),
                            discountedPrice: offer.discounted_price
                                ? parseFloat(offer.discounted_price)
                                : null,
                            discountPercentage: offer.discount
                                ? parseFloat(offer.discount)
                                : 0,
                            timeLeft: offer.timeLeft,
                            enrollments: offer.enrollments,
                            image: offer.image || "default-image.jpg",
                        })
                    );
                    
                    this.topInstructors = data.top_instructors.map(instructor => ({
                        id: instructor.instructor_profile_id,
                        name: instructor.name,
                        specialization: instructor.specialization,
                        image: instructor.image || 'default-image.jpg',
                        experience: instructor.experience,
                        skills: instructor.skills,
                    })); // Assuming this is already in the correct format
                } else {
                    this.error = 'Failed to fetch data';
                }
            } catch (err) {
                this.error = err.message || 'An error occurred';
            } finally {
                this.loading = false;
            }
        },
    },
});
