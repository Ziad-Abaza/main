// stores/quizStore.js

import { defineStore } from 'pinia';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

export const useQuizStore = defineStore('quizStore', {
    state: () => ({
        quiz: null,
        loading: false,
        error: null,
    }),

    actions: {
        /**
         * Fetches quiz data for a specific video ID.
         */
        async fetchQuizByVideoId(videoId) {
            this.loading = true;
            this.error = null;
            const authStore = useAuthStore();

            try {
                const response = await axios.get(`/api/quizzes/video/${videoId}`, {
                    headers: {
                        Authorization: `Bearer ${authStore.token}`,
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                });

                const data = response.data.data;

                // Map API response to internal quiz structure
                const mappedQuiz = {
                    video_id: data.video_id,
                    video_title: data.video_title,
                    questions: data.quiz_questions.map(q => ({
                        question_id: q.question_id,
                        text: q.question_text,
                        type: q.question_type === 'true_false' ? 'true_false' : 'single_choice',
                        points: q.points,
                        options: q.question_options || [],
                        user_answer: null, // Will hold selected answer
                    })),
                };

                this.quiz = mappedQuiz;

                return mappedQuiz;

            } catch (error) {
                console.error('Error fetching quiz:', error);
                this.error = error.response?.data?.message || 'Failed to fetch quiz.';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        /**
         * Submit user answers to the backend (can be extended later).
         */
        async submitAnswers(videoId, answers) {
            this.loading = true;
            this.error = null;
            const authStore = useAuthStore();
            console.log('Submitting answers:', answers);
            try {
                const response = await axios.post(
                    `/api/quizzes/video/${videoId}`,
                    { answers },
                    {
                        headers: {
                            Authorization: `Bearer ${authStore.token}`,
                            Accept: 'application/json',
                            'Content-Type': 'application/json',
                        },
                    }
                );
                console.log('Quiz submission response:', response);
                return response.data;
            } catch (error) {
                console.error('Error submitting quiz answers:', error);
                this.error = error.response?.data?.message || 'Failed to submit answers.';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        /**
         * Reset quiz state
         */
        resetQuiz() {
            this.quiz = null;
            this.loading = false;
            this.error = null;
        }
    },
});