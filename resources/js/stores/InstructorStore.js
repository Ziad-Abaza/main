import { defineStore } from "pinia";
import axios from "axios";

export const useInstructorStore = defineStore("instructors", {
    state: () => ({
        instructors: [],
        instructor: null,
        total: 0,
        currentPage: 1,
        perPage: 10,
        loading: false,
        error: null,
    }),

    actions: {
        /**
         * Fetches a paginated list of instructors with their statistics
         */
        async fetchInstructors(page = 1, perPage = 10) {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.get("/api/instructors", {
                    params: { page, per_page: perPage },
                });

                console.log("Instructors Response:", response.data);

                if (response.data.success) {
                    this.instructors = response.data.data.map((instructor) => ({
                        id: instructor.instructor_profile_id,
                        userId: instructor.user_id,
                        name: instructor.name,
                        image:
                            instructor.image ||
                            "https://i.ibb.co/67ZKPkmK/logo.png ",
                        bio: instructor.bio || "No bio available",
                        specialization:
                            instructor.specialization || "Not specified",
                        experience: instructor.experience || "0 years",
                        linkedinUrl: instructor.linkedin_url || null,
                        githubUrl: instructor.github_url || null,
                        websiteUrl: instructor.website_url || null,
                        skills: Array.isArray(instructor.skills)
                            ? instructor.skills
                            : [],
                        statistics: {
                            coursesCount:
                                instructor.statistics?.courses_count || 0,
                            totalStudents:
                                instructor.statistics?.total_students || 0,
                            totalVideos:
                                instructor.statistics?.total_videos || 0,
                            latestCourse: instructor.statistics?.latest_course
                                ? {
                                      title:
                                          instructor.statistics.latest_course
                                              .title || "N/A",
                                      createdAt: instructor.statistics
                                          .latest_course.created_at
                                          ? new Date(
                                                instructor.statistics.latest_course.created_at
                                            )
                                          : null,
                                  }
                                : null,
                        },
                    }));

                    this.total =
                        response.data.pagination?.total ||
                        this.instructors.length;
                    this.currentPage =
                        response.data.pagination?.current_page || page;
                    this.perPage =
                        response.data.pagination?.per_page || perPage;
                } else {
                    this.error =
                        response.data.message || "Failed to fetch instructors";
                }
            } catch (error) {
                console.error("Error fetching instructors:", error);
                this.error = error.message || "An unexpected error occurred";
            } finally {
                this.loading = false;
            }
        },

        /**
         * Fetches a single instructor by ID including their statistics
         */
        async getInstructorbyId(instructor_profile_id) {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.get(
                    `/api/instructors/${instructor_profile_id}`
                );
                console.log("Instructor Details Response:", response.data);

                if (response.data.success) {
                    const instructorData = response.data.data;

                    this.instructor = {
                        id: instructorData.instructor_profile_id,
                        userId: instructorData.user_id,
                        name: instructorData.name,
                        image:
                            instructorData.image ||
                            "https://i.ibb.co/67ZKPkmK/logo.png ",
                        bio: instructorData.bio || "No bio available",
                        specialization:
                            instructorData.specialization || "Not specified",
                        experience: instructorData.experience || "0 years",
                        linkedinUrl: instructorData.linkedin_url || null,
                        githubUrl: instructorData.github_url || null,
                        websiteUrl: instructorData.website_url || null,
                        skills: Array.isArray(instructorData.skills)
                            ? instructorData.skills
                            : [],
                        statistics: {
                            coursesCount:
                                instructorData.statistics?.courses_count || 0,
                            totalStudents:
                                instructorData.statistics?.total_students || 0,
                            totalVideos:
                                instructorData.statistics?.total_videos || 0,
                            latestCourse: instructorData.statistics
                                ?.latest_course
                                ? {
                                      title:
                                          instructorData.statistics
                                              .latest_course.title || "N/A",
                                        image: instructorData.statistics.latest_course.image || "N/A",
                                      createdAt: instructorData.statistics
                                          .latest_course.created_at
                                          ? new Date(
                                                instructorData.statistics.latest_course.created_at
                                            )
                                          : null,
                                  }
                                : null,
                        },
                    };
                } else {
                    this.error =
                        response.data.message || "Failed to fetch instructor";
                }
            } catch (error) {
                console.error("Error fetching instructor details:", error);
                this.error = error.message || "An unexpected error occurred";
            } finally {
                this.loading = false;
            }
        },
    },
});
