import { defineStore } from 'pinia';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

export const useCourseQuizStore = defineStore('courseQuizStore', {
    state: () => ({
        quizzes: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchQuizzesByCourseId(courseId) {
            this.loading = true;
            this.error = null;
            const authStore = useAuthStore();
            try {
                const response = await axios.get(`/api/quizzes/course/${courseId}`, {
                    headers: {
                        Authorization: `Bearer ${authStore.token}`,
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                });
                const data = response.data.data;
                this.quizzes = data.quizzes || [];
                return this.quizzes;
            } catch (error) {
                console.error('Error fetching course quizzes:', error);
                this.error = error.response ?.data ?.message || 'Failed to fetch course quizzes.';
                throw error;
            } finally {
                this.loading = false;
            }
        },
        async fetchAllQuizzes() {
            this.loading = true;
            this.error = null;
            const authStore = useAuthStore();
            try {
                const response = await axios.get(`/api/quizzes/all`, {
                    headers: {
                        Authorization: `Bearer ${authStore.token}`,
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                });
                const data = response.data.data;
                this.quizzes = data.quizzes || [];
                return this.quizzes;
            } catch (error) {
                console.error('Error fetching all quizzes:', error);
                this.error = error.response ?.data ?.message || 'Failed to fetch all quizzes.';
                throw error;
            } finally {
                this.loading = false;
            }
        },
        async submitAnswers(quizId, answers) {
            this.loading = true;
            this.error = null;
            const authStore = useAuthStore();
            try {
                const response = await axios.post(
                    `/api/quizzes/${quizId}/submit`, { answers }, {
                        headers: {
                            Authorization: `Bearer ${authStore.token}`,
                            Accept: 'application/json',
                            'Content-Type': 'application/json',
                        },
                    }
                );
                return response.data;
            } catch (error) {
                console.error('Error submitting quiz answers:', error);
                this.error = error.response ?.data ?.message || 'Failed to submit answers.';
                throw error;
            } finally {
                this.loading = false;
            }
        },
        resetQuizzes() {
            this.quizzes = [];
            this.loading = false;
            this.error = null;
        },
        async fetchQuizById(quizId) {
            this.loading = true;
            this.error = null;
            const authStore = useAuthStore();
            try {
                const response = await axios.get(`/api/quizzes/${quizId}`, {
                    headers: {
                        Authorization: `Bearer ${authStore.token}`,
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                });
                const data = response.data.data;
                return data;
            } catch (error) {
                console.error('Error fetching quiz by ID:', error);
                this.error = error.response ?.data ?.message || 'Failed to fetch quiz.';
                throw error;
            } finally {
                this.loading = false;
            }
        },
    },
});
