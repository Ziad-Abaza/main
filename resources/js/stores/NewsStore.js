import { defineStore } from "pinia";
import axios from "axios";

export const useNewsStore = defineStore("news", {
    state: () => ({
        news: null,
        newsList: [],
        loading: false,
        error: null,
        total: 0,
        currentPage: 1,
        perPage: 10,
    }),

    actions: {
        async fetchNewsDetails(newsId) {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get(`/api/news/${newsId}`);
                if (response.data) {
                    console.log("News Details Response:", response.data);
                    this.news = response.data.data;
                } else {
                    this.error = "Failed to fetch news details";
                }
            } catch (error) {
                this.error = error.message || "An unexpected error occurred";
            } finally {
                this.loading = false;
            }
        },

        async fetchNews(page = 1, perPage = 10) {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get("/api/news", {
                    params: { page, per_page: perPage },
                });
                console.log("News Response:", response.data);

                if (response.data && response.data.data) {
                    this.newsList = response.data.data.map((article) => ({
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
                    }));

                    // If pagination data is available
                    if (response.data.pagination) {
                        this.total = response.data.pagination.total;
                        this.currentPage = response.data.pagination.current_page;
                        this.perPage = response.data.pagination.per_page;
                    }
                }
            } catch (error) {
                console.error("Error fetching news:", error);
                this.error = "Failed to load news. Please try again later.";
            } finally {
                this.loading = false;
            }
        },

        clearNews() {
            this.news = null;
            this.newsList = [];
            this.error = null;
        },

        clearError() {
            this.error = null;
        },
    },

    getters: {
        getNewsById: (state) => (id) => state.newsList.find(article => article.id === id),
        getNewsByCategory: (state) => (category) => state.newsList.filter(article => article.category === category),
        getNewsByTag: (state) => (tag) => state.newsList.filter(article =>
            article.tags.some(t => t.toLowerCase().includes(tag.toLowerCase()))
        ),
        getLatestNews: (state) => (limit = 5) => state.newsList
            .sort((a, b) => new Date(b.date) - new Date(a.date))
            .slice(0, limit),
    },
});
