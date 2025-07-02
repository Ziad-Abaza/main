import { defineStore } from "pinia";
import axios from "axios";

export const useCategoryStore = defineStore("category", {
    state: () => ({
        category: null,
        loading: false,
        error: null,
        categories: [],
        total: 0,
        currentPage: 1,
        perPage: 10,
    }),

    actions: {
        async fetchCategoryDetails(categoryId) {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get(`/api/categories/${categoryId}`);
                if (response.data.success) {
                    console.log("Category Details Response:", response.data);
                    this.category = response.data.data;
                } else {
                    this.error =
                        response.data.message ||
                        "Failed to fetch category details";
                }
            } catch (error) {
                this.error = error.message || "An unexpected error occurred";
            } finally {
                this.loading = false;
            }
        },

        async fetchCategories(page = 1, perPage = 10) {
            try {
                const response = await axios.get("/api/categories", {
                    params: { page, per_page: perPage },
                });
                console.log("Categories Response:", response);
                if (response.status == 200) {
                    console.log("mapping")
                    this.categories = response.data.map((category) => ({
                        id: category.id,
                        name: category.name,
                        description: category.description,
                        image_url: category.image_url,
                        courses_count: category.courses_count,
                        students_count: category.students_count,
                        certificates_enabled: category.certificates_enabled,
                        instructors_count: category.instructors_count,
                        average_rating: category.average_rating,
                        reviews_count: category.reviews_count,
                        subscription_available: category.subscription_available,
                        subscription_price: category.subscription_price,
                        active_discount: category.active_discount,
                        max_discount: category.max_discount,
                        has_coupon: category.has_coupon,
                        active_coupons_count: category.active_coupons_count,
                        featured_courses: category.featured_courses,
                    }));
                    // this.total = response?.pagination.total;
                    // this.currentPage = response.data.pagination.current_page;
                    // this.perPage = response.data.pagination.per_page;
                }
            } catch (error) {
                console.error("Error fetching categories:", error);
            }
        },
    },
});