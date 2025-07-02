<template>
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white">
        <!-- Static Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute top-40 right-20 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute bottom-20 left-1/3 w-60 h-60 bg-indigo-600/10 rounded-full blur-3xl opacity-40"></div>
        </div>

        <!-- Static Particles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-400 rounded-full opacity-70 animate-pulse"></div>
            <div class="absolute top-1/3 left-3/4 w-1.5 h-1.5 bg-purple-400 rounded-full opacity-60 animate-pulse delay-300"></div>
            <div class="absolute top-2/3 left-1/6 w-2.5 h-2.5 bg-indigo-400 rounded-full opacity-50 animate-pulse delay-700"></div>
            <div class="absolute bottom-1/4 right-1/4 w-2 h-2 bg-pink-400 rounded-full opacity-60 animate-pulse delay-1000"></div>
        </div>

        <!-- Floating geometric shapes -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/5 right-1/5 w-8 h-8 border border-purple-400/30 rotate-45 animate-float"></div>
            <div class="absolute bottom-1/3 left-1/5 w-6 h-6 border border-blue-400/30 rotate-12 animate-float-delayed"></div>
        </div>

        <!-- Main Container -->
        <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
            <div class="w-full max-w-md lg:max-w-lg xl:max-w-xl">
                <!-- Login Card -->
                <div class="glass-card-premium rounded-2xl overflow-hidden shadow-xl border border-white/10 backdrop-blur-xl relative group animate-slide-up">
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 via-transparent to-blue-500/5 opacity-60 pointer-events-none"></div>
                    
                    <!-- Shimmer Effect -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -skew-x-12 animate-shimmer"></div>
                    </div>

                    <div class="relative z-10 p-8 lg:p-10 xl:p-12">
                        <!-- Header with Icon -->
                        <div class="text-center mb-8 lg:mb-10">
                            <div class="inline-flex items-center justify-center w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl mb-4 shadow-lg group-hover:scale-110 transition-all duration-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="text-white lg:w-8 lg:h-8">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                    <polyline points="10,17 15,12 10,7" />
                                    <line x1="15" y1="12" x2="3" y2="12" />
                                </svg>
                            </div>
                            <h2 class="text-xl lg:text-2xl font-bold text-white mb-1">Welcome Back!</h2>
                            <p class="text-slate-400 text-sm lg:text-base">Please sign in to your account</p>
                        </div>

                        <form @submit.prevent="handleLogin" class="space-y-6 lg:space-y-8">
                            <!-- Email Input -->
                            <div class="space-y-2">
                                <label for="email" class="block text-sm lg:text-base font-semibold text-slate-200">Email Address</label>
                                <div class="relative group">
                                    <!-- Email Icon -->
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                        <div class="p-2 bg-gradient-to-r from-purple-500/20 to-blue-500/20 rounded-lg backdrop-blur-sm border border-purple-500/30 group-focus-within:border-purple-400/60 transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="text-purple-400 group-focus-within:text-purple-300 transition-colors duration-300">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                                <polyline points="22,6 12,13 2,6" />
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <input 
                                        type="email" 
                                        id="email" 
                                        v-model="email" 
                                        required 
                                        class="w-full pl-16 pr-4 py-4 bg-white/10 backdrop-blur-lg border border-white/20 rounded-xl text-white placeholder-slate-400 focus:border-purple-500/60 focus:bg-white/15 focus:shadow-lg focus:shadow-purple-500/20 transition-all duration-300 group-hover:bg-white/12 group-hover:border-white/30"
                                        placeholder="Enter your email address"
                                    />
                                </div>
                            </div>

                            <!-- Password Input -->
                            <div class="space-y-2">
                                <label for="password" class="block text-sm lg:text-base font-semibold text-slate-200">Password</label>
                                <div class="relative group">
                                    <!-- Lock Icon -->
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                        <div class="p-2 bg-gradient-to-r from-purple-500/20 to-blue-500/20 rounded-lg backdrop-blur-sm border border-purple-500/30 group-focus-within:border-purple-400/60 transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="text-purple-400 group-focus-within:text-purple-300 transition-colors duration-300">
                                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                                <circle cx="12" cy="16" r="1" />
                                                <path d="m7 11 0-5a5 5 0 0 1 10 0l0 5" />
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <input 
                                        :type="showPassword ? 'text' : 'password'" 
                                        id="password" 
                                        v-model="password" 
                                        required
                                        class="w-full pl-16 pr-16 py-4 bg-white/10 backdrop-blur-lg border border-white/20 rounded-xl text-white placeholder-slate-400 focus:border-purple-500/60 focus:bg-white/15 focus:shadow-lg focus:shadow-purple-500/20 transition-all duration-300 group-hover:bg-white/12 group-hover:border-white/30"
                                        placeholder="Enter your password"
                                    />
                                    
                                    <!-- Password Toggle -->
                                    <button 
                                        type="button" 
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center z-10"
                                        @click="showPassword = !showPassword"
                                        tabindex="-1"
                                    >
                                        <div class="p-2 bg-white/10 hover:bg-white/20 rounded-lg backdrop-blur-sm border border-white/20 hover:border-white/40 transition-all duration-200 group">
                                            <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 hover:text-slate-300 transition-colors duration-200">
                                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                            <svg v-else xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400 hover:text-slate-300 transition-colors duration-200">
                                                <path d="m9.88 9.88a3 3 0 1 0 4.24 4.24" />
                                                <path d="m10.73 5.08a10.43 10.43 0 0 1 1.27-.08c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68" />
                                                <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61" />
                                                <line x1="2" y1="2" x2="22" y2="22" />
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember & Forgot -->
                            <div class="flex items-center justify-between">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="checkbox" v-model="rememberMe" class="sr-only">
                                    <div class="relative flex items-center justify-center w-5 h-5 border-2 rounded transition-all duration-300"
                                         :class="rememberMe ? 'border-purple-500 bg-gradient-to-r from-purple-500 to-blue-500' : 'border-slate-400 bg-transparent group-hover:border-purple-400'">
                                        <svg v-if="rememberMe" class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <span class="ml-3 text-sm text-slate-300 group-hover:text-white transition-colors duration-300">Remember me</span>
                                </label>
                                <a href="#" class="text-sm text-purple-400 hover:text-purple-300 transition-colors duration-300 font-medium hover:underline">
                                    Forgot password?
                                </a>
                            </div>

                            <!-- Error Message -->
                            <div v-if="error" class="bg-red-500/15 border border-red-500/30 rounded-xl p-4 backdrop-blur-sm animate-shake">
                                <div class="flex items-center space-x-3">
                                    <div class="p-1 bg-red-500/20 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-400">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="15" y1="9" x2="9" y2="15" />
                                            <line x1="9" y1="9" x2="15" y2="15" />
                                        </svg>
                                    </div>
                                    <span class="text-red-300 text-sm font-medium">{{ error }}</span>
                                </div>
                            </div>

                            <!-- Sign In Button -->
                            <button 
                                type="submit" 
                                class="w-full py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 rounded-xl font-bold text-white transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-0.5 shadow-lg hover:shadow-purple-500/30 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none relative overflow-hidden group"
                                :disabled="loading"
                            >
                                <!-- Button Shimmer Effect -->
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 group-hover:animate-shimmer"></div>
                                
                                <span v-if="!loading" class="flex items-center justify-center space-x-2 relative z-10">
                                    <span>Sign In</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="transform group-hover:translate-x-1 transition-transform duration-300">
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </span>
                                
                                <div v-else class="flex items-center justify-center space-x-3 relative z-10">
                                    <div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                                    <span>Signing in...</span>
                                </div>
                            </button>
                        </form>

                        <!-- Register Link -->
                        <div class="text-center pt-6 mt-6 border-t border-slate-600">
                            <p class="text-slate-400 text-sm mb-3">Don't have an account?</p>
                            <router-link 
                                to="/register" 
                                class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-indigo-600/80 to-purple-600/80 hover:from-indigo-500 hover:to-purple-500 rounded-xl font-semibold text-white transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-indigo-500/30 backdrop-blur-sm border border-white/10 text-sm group"
                            >
                                <span>Create Account</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="ml-2 transform group-hover:translate-x-1 transition-transform duration-300">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="relative z-10 border-t border-white/10 bg-black/30 backdrop-blur-sm">
            <div class="container mx-auto px-6 py-6">
                <div class="text-center text-slate-400">
                    <p class="text-sm">
                        Made with <span class="text-red-500">❤️</span> by EduStream Team
                    </p>
                    <p class="text-xs mt-1 text-slate-500">
                        © 2024 EduStream. Empowering learners worldwide.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const email = ref('');
const password = ref('');
const error = ref('');
const loading = ref(false);
const showPassword = ref(false);
const rememberMe = ref(false);

const handleLogin = async () => {
    try {
        loading.value = true;
        error.value = '';
        await authStore.login({
            email: email.value,
            password: password.value
        });
        router.push('/');
    } catch (err) {
        error.value = err.response?.data?.message || 'Login failed. Please try again.';
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
.glass-card-premium {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.01));
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow:
        0 4px 24px -1px rgba(0, 0, 0, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes soft-shimmer {
    0% {
        background-position: -100% 0;
    }
    100% {
        background-position: 200% 0;
    }
}

.input-focus-effect {
    background-size: 200% 100%;
    background-image: linear-gradient(
        to right,
        rgba(255, 255, 255, 0.05) 0%,
        rgba(255, 255, 255, 0.1) 50%,
        rgba(255, 255, 255, 0.05) 100%
    );
    transition: all 0.3s ease;
}

.input-focus-effect:focus {
    background-position: -100% 0;
    box-shadow: 0 0 0 2px rgba(139, 92, 246, 0.2);
}

.button-gradient {
    background-size: 200% 100%;
    background-image: linear-gradient(
        to right,
        rgb(124, 58, 237) 0%,
        rgb(99, 102, 241) 50%,
        rgb(124, 58, 237) 100%
    );
    transition: all 0.3s ease;
}

.button-gradient:hover {
    background-position: 100% 0;
    transform: translateY(-2px);
}

input::placeholder {
    transition: color 0.3s ease;
}

input:focus::placeholder {
    color: rgba(255, 255, 255, 0.3);
}

/* تحسين مظهر السكرول */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
}

::-webkit-scrollbar-thumb {
    background: rgba(139, 92, 246, 0.5);
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(139, 92, 246, 0.7);
}

@media (max-width: 768px) {
    .glass-card-premium {
        backdrop-filter: blur(8px);
        margin: 0.5rem;
    }
}

@media (prefers-reduced-motion: reduce) {
    * {
        animation: none !important;
        transition: none !important;
    }
    
    .animate-slide-up {
        opacity: 1;
        transform: none;
    }
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}
</style>