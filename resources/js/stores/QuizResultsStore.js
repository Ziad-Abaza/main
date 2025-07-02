// stores/quizResultsStore.js
import { defineStore } from 'pinia';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

export const useQuizResultsStore = defineStore('quizResultsStore', {
    state: () => ({
        videoId: null,
        videoTitle: '',
        totalQuestions: 0,
        score: 0,
        percentage: 0,
        nextVideo: null,
        attempts: [],
        groupedAttempts: {}, // key: question_id, value: [attempt1, attempt2]
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
        async fetchQuizResults(videoId) {
            this.loading = true;
            this.error = null;
            const authStore = useAuthStore();

            try {
                const response = await axios.get(`/api/quizzes/video/${videoId}/quiz-results`, {
                    headers: {
                        Authorization: `Bearer ${authStore.token}`,
                        'X-Beaker-Token': authStore.beaker_token,
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                });

                const data = response.data.data;
                // console.log(data)
                // Set basic info based on the new API structure
                this.videoId = videoId;
                this.totalQuestions = data.total_questions;
                this.score = data.score;
                this.percentage = data.percentage;
                this.nextVideo = data.next_video;
                // console.log(this.percentage);
                // If attempts are provided in the response, process them
                if (data.attempts) {
                    this.attempts = [...data.attempts];

                    // Group attempts by question_id
                    const grouped = {};
                    data.attempts.forEach(attempt => {
                        if (!grouped[attempt.question_id]) {
                            grouped[attempt.question_id] = [];
                        }
                        grouped[attempt.question_id].push(attempt);
                    });
                    this.groupedAttempts = grouped;
                }

            } catch (error) {
                console.error('Error fetching quiz results:', error);
                this.error = error.response ?.data ?.message || 'Failed to load quiz results.';
                throw error;
            } finally {
                this.loading = false;
            }
        }
    },
});