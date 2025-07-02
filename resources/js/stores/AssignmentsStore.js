import { defineStore } from "pinia";
import axios from "axios";

export const useAssignmentsStore = defineStore("assignments", {
    state: () => ({
        assignments: [], // list of assignments assigned to user
        submissions: [], // submissions by user
        loading: false,
        error: null,
    }),

    actions: {
        async fetchUserAssignments() {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get("/api/assignments");
                if (response.data.success) {
                    this.assignments = response.data.data;
                } else {
                    this.error = response.data.message || "Failed to fetch assignments";
                }
            } catch (err) {
                this.error = err.message || "An error occurred";
            } finally {
                this.loading = false;
            }
        },

        async fetchUserSubmissions() {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get("/api/submissions");
                if (response.data.success) {
                    this.submissions = response.data.data;
                } else {
                    this.error = response.data.message || "Failed to fetch submissions";
                }
            } catch (err) {
                this.error = err.message || "An error occurred";
            } finally {
                this.loading = false;
            }
        },
    },
});