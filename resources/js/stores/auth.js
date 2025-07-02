import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: (() => {
            const raw = localStorage.getItem("user") ?? "null";
            try {
                return JSON.parse(raw);
            } catch {
                return null;
            }
        })(),
        token: localStorage.getItem("token") ?? null,
        loading: false,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
        getUser: (state) => state.user,
        name: (state) => {
            return state.user ? state.user.name : null;
        },
    },

    actions: {
        async login(credentials) {
            try {
                await this.clearStorage();
                const response = await axios.post(
                    "/api/auth/login",
                    credentials
                );
                console.log("Login response:", response);
                this.token = response.data.token;
                this.user = response.data.user;
                localStorage.setItem("token", this.token);
                localStorage.setItem("user", JSON.stringify(this.user));
                // Set the token in axios headers
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${this.token}`;
                return response;
            } catch (error) {
                this.token = null;
                this.user = null;
                localStorage.removeItem("token");
                localStorage.removeItem("user");
                throw error;
            }
        },

        async register(userData) {
            try {
                const response = await axios.post(
                    "/api/auth/register",
                    userData
                );
                this.token = response.data.token;
                this.user = response.data.user;
                localStorage.setItem("token", this.token);
                localStorage.setItem("user", JSON.stringify(this.user));
                // Set the token in axios headers
                axios.defaults.headers.common[
                    "Authorization"
                ] = `Bearer ${this.token}`;
                return response;
            } catch (error) {
                this.token = null;
                this.user = null;
                localStorage.removeItem("token");
                localStorage.removeItem("user");
                throw error;
            }
        },

        async clearStorage() {
            this.token = null;
            this.user = null;
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            delete axios.defaults.headers.common["Authorization"];
        },

        async logout() {
            try {
                if (this.token) {
                    await axios.post("/api/auth/logout");
                }
            } catch (error) {
                console.error("Logout failed:", error);
            } finally {
                await this.clearStorage();
                window.location.assign("/login");
            }
        },

        async fetchUser() {
            try {
              if (!this.token) {
                throw new Error("No token found");
              }
              const response = await axios.get("/api/auth/user");
              // response.data = { success, code, user }
              this.user = response.data.user;
              localStorage.setItem("user", JSON.stringify(this.user));
              return response;
            } catch (error) {
              this.token = null;
              this.user = null;
              localStorage.removeItem("token");
              localStorage.removeItem("user");
              throw error;
            }
          },
    },
});
