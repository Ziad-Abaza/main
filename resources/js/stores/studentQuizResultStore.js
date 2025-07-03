import { defineStore } from "pinia";
import axios from "axios";
import { useAuthStore } from "@/stores/auth";

export const useStudentQuizResultStore = defineStore("studentQuizResultStore", {
    state: () => ({
        results: [],
        loading: false,
        error: null,
        currentResult: null,
    }),

    actions: {
        async fetchStudentResultsByQuizId(quizId) {
            this.loading = true;
            this.error = null;
            this.results = [];

            const authStore = useAuthStore();

            try {
                const response = await axios.get(
                    `/api/lms/quizzes/${quizId}/results`,
                    {
                        headers: {
                            Authorization: `Bearer ${authStore.token}`,
                            Accept: "application/json",
                            "Content-Type": "application/json",
                        },
                    }
                );

                const data = response.data.data;
                this.results = data;
                return data;
            } catch (error) {
                console.error("Error fetching student quiz results:", error);
                this.error =
                    error.response?.data?.message ||
                    "Failed to fetch quiz results.";
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchAllStudentResults() {
            this.loading = true;
            this.error = null;
            this.results = [];

            const authStore = useAuthStore();

            try {
                const response = await axios.get(`/api/lms/quizzes/results`, {
                    headers: {
                        Authorization: `Bearer ${authStore.token}`,
                        Accept: "application/json",
                        "Content-Type": "application/json",
                    },
                });

                const data = response.data.data;
                this.results = data;
                return data;
            } catch (error) {
                console.error(
                    "Error fetching all student quiz results:",
                    error
                );
                this.error =
                    error.response?.data?.message ||
                    "Failed to fetch quiz results.";
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchStudentResultsByCourseId(courseId) {
            this.loading = true;
            this.error = null;
            this.results = [];

            const authStore = useAuthStore();

            try {
                const response = await axios.get(
                    `/api/lms/quizzes/course/${courseId}/results`,
                    {
                        headers: {
                            Authorization: `Bearer ${authStore.token}`,
                            Accept: "application/json",
                            "Content-Type": "application/json",
                        },
                    }
                );

                const data = response.data.data;
                this.results = data;
                return data;
            } catch (error) {
                console.error(
                    "Error fetching student quiz results by course:",
                    error
                );
                this.error =
                    error.response?.data?.message ||
                    "Failed to fetch course quiz results.";
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchSingleStudentResult(quizId, studentId) {
            this.loading = true;
            this.error = null;
            this.currentResult = null;

            const authStore = useAuthStore();

            try {
                const response = await axios.get(
                    `/api/lms/quizzes/${quizId}/results?student_id=${studentId}`,
                    {
                        headers: {
                            Authorization: `Bearer ${authStore.token}`,
                            Accept: "application/json",
                            "Content-Type": "application/json",
                        },
                    }
                );

                const data = response.data.data;
                this.currentResult = data;
                return data;
            } catch (error) {
                console.error(
                    "Error fetching single student quiz result:",
                    error
                );
                this.error =
                    error.response?.data?.message ||
                    "Failed to fetch student quiz result.";
                throw error;
            } finally {
                this.loading = false;
            }
        },

        resetResults() {
            this.results = [];
            this.loading = false;
            this.error = null;
            this.currentResult = null;
        },
    },
});
