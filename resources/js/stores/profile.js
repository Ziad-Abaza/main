import { defineStore } from "pinia";
import axios from "axios";

export const useProfileStore = defineStore("profile", {
    state: () => ({
        assignments: [],
        submissions: [],
        loading: false,
        error: null,
        loadingSubs: false,
        errorSubs: null,
    }),

    getters: {
        pendingAssignmentsCount: (state) => {
            if (!state.assignments) return 0;
            return state.assignments.length;
        }
    },

    actions: {
        async fetchAssignments() {
            this.loading = true;
            this.error = null;
            try {
                const res = await axios.get(
                    "/api/assignments?status=unsubmitted&per_page=50"
                );
                this.assignments = res.data.data;
            } catch (e) {
                this.error =
                    e.response?.data?.message || "Failed to load assignments";
            } finally {
                this.loading = false;
            }
        },

        async fetchSubmissions() {
            this.loadingSubs = true;
            this.errorSubs = null;
            try {
                const res = await axios.get(
                    "/api/assignments?status=submitted&per_page=50"
                );
                this.submissions = res.data.data.map((a) => ({
                    id: a.submission?.id ?? a.id,
                    assignment_title: a.title,
                    created_at: a.submission?.created_at,
                    file_url: a.submission?.file_url,
                }));
            } catch (e) {
                this.errorSubs =
                    e.response?.data?.message || "Failed to load submissions";
            } finally {
                this.loadingSubs = false;
            }
        },
    },
});
