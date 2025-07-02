import { defineStore } from 'pinia';
import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

export const useVideosStore = defineStore('videosStore', {
    state: () => ({
        videos: [],
        title: '',
        loading: false,
        error: null,
    }),

    actions: {
        async fetchVideos(courseId) {
            this.loading = true;
            this.error = null;
            const authStore = useAuthStore();
            try {
                const response = await axios.get(`/api/videos/course/${courseId}`, {
                    headers: {
                        Authorization: `Bearer ${authStore.token}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });
                this.videos = response.data.data;
                this.title = response.data.course_title || 'Videos';
            } catch (error) {
                console.error('Error fetching videos:', error);
                this.error = error.response ?.data ?.message || 'Failed to fetch videos.';
            } finally {
                this.loading = false;
            }
        },

        async fetchVideoDetails(videoId) {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get(`/api/videos/${videoId}`);
                const data = response.data.data;
                const nextVideo = response.data.next_video;
                console.log('Video details:', data);
                console.log("next_video: ", nextVideo)
                return {
                    video: {
                        id: data.video_id,
                        title: data.title,
                        description: data.description,
                        duration: data.duration,
                        order: data.order_in_course,
                        url: data.video_url ? data.video_url : data.video_url,
                        thumbnail: data.thumbnail,
                        course: {
                            id: data.course.course_id,
                            title: data.course.title,
                        },
                        hasQuiz: data.is_have_question,
                        progress: data.user_progress,
                    },
                    nextVideo: nextVideo ? {
                        id: nextVideo.video_id,
                        title: nextVideo.title,
                        duration: nextVideo.duration,
                        order: nextVideo.order_in_course,
                    } : null,
                };
            } catch (error) {
                console.error('Error fetching video details:', error);
                this.error = error.response ?.data ?.message || 'Failed to fetch video details.';
                return null;
            } finally {
                this.loading = false;
            }
        },
    },
});