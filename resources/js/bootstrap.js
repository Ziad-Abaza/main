import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

// Add a request interceptor for the auth token
axios.interceptors.request.use(function(config) {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, function(error) {
    return Promise.reject(error);
});

import { useAuthStore } from './stores/auth'; // Import the auth store
axios.interceptors.response.use(
    response => response,
    async error => {
        if (error.response) {
            const status = error.response.status;
            const authStore = useAuthStore();
            if (status === 401) {
                // Only clear user data, do not redirect
                await authStore.clearStorage();
                localStorage.setItem('showLoginToast', '1');
                window.location.assign('/login');
            } else if (status === 405) {
                // Clear user data and redirect to login
                await authStore.clearStorage();
                window.location.assign('/login');
            }
        }
        return Promise.reject(error);
    }
);
