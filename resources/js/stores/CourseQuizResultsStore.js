import { defineStore } from 'pinia';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

export const useCourseQuizResultsStore = defineStore('courseQuizResultsStore', {
    state: () => ({
        courseId: null,
        courseTitle: '',
        quizId: null,
        quizTitle: '',
        totalQuestions: 0,
        score: 0,
        percentage: 0,
        attempts: [],
        groupedAttempts: {},
        loading: false,
        error: null,
    }),
    getters: {
        passed: (state) => state.percentage >= 70,
        scorePercentage: (state) => state.percentage,
        getAttemptsByQuestionId: (state) => (questionId) =>
            state.groupedAttempts[questionId] || [],
    },
    actions: {
        async fetchQuizResults(courseId) {
            this.loading = true;
            this.error = null;
            const authStore = useAuthStore();
            try {
                const response = await axios.get(`/api/quizzes/course/${courseId}/quiz-results`, {
                    headers: {
                        Authorization: `Bearer ${authStore.token}`,
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                });
                const data = response.data.data;
                this.courseId = courseId;
                this.totalQuestions = data.total_questions;
                this.score = data.score;
                this.percentage = data.percentage;
                this.attempts = [...(data.attempts || [])];
                const grouped = {};
                (data.attempts || []).forEach(attempt => {
                    if (!grouped[attempt.question_id]) {
                        grouped[attempt.question_id] = [];
                    }
                    grouped[attempt.question_id].push(attempt);
                });
                this.groupedAttempts = grouped;
            } catch (error) {
                console.error('Error fetching course quiz results:', error);
                this.error = error.response ? .data ? .message || 'Failed to load course quiz results.';
                throw error;
            } finally {
                this.loading = false;
            }
        }
    }
});
