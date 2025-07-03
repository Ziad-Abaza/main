<template>
    <div
        :class="isDark ? 'min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white' : 'min-h-screen bg-gradient-to-br from-blue-50 via-blue-100 to-white text-slate-900'"
    >
        <!-- Static Background Elements - تحديث مواقع العناصر -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                :class="isDark ? 'absolute top-10 right-[20%] w-96 h-96 bg-indigo-600/10 rounded-full blur-3xl opacity-50 rotate-12' : 'absolute top-10 right-[20%] w-96 h-96 bg-indigo-200/30 rounded-full blur-3xl opacity-50 rotate-12'"
            ></div>
            <div
                :class="isDark ? 'absolute bottom-40 left-20 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl opacity-40 -rotate-12' : 'absolute bottom-40 left-20 w-80 h-80 bg-purple-200/30 rounded-full blur-3xl opacity-40 -rotate-12'"
            ></div>
            <div
                :class="isDark ? 'absolute top-1/3 left-1/4 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl opacity-30' : 'absolute top-1/3 left-1/4 w-72 h-72 bg-blue-200/30 rounded-full blur-3xl opacity-30'"
            ></div>
        </div>

        <!-- Static Particles - تحديث مواقع النقاط المضيئة -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-1/3 right-1/4 w-2 h-2 bg-indigo-400 rounded-full opacity-70 animate-pulse"
            ></div>
            <div
                class="absolute bottom-1/4 left-1/2 w-1.5 h-1.5 bg-purple-400 rounded-full opacity-60 animate-pulse delay-300"
            ></div>
            <div
                class="absolute top-1/2 right-1/3 w-2.5 h-2.5 bg-blue-400 rounded-full opacity-50 animate-pulse delay-700"
            ></div>
            <div
                class="absolute bottom-1/3 left-1/4 w-2 h-2 bg-violet-400 rounded-full opacity-60 animate-pulse delay-1000"
            ></div>
        </div>

        <!-- Floating geometric shapes - تحديث مواقع وأحجام الأشكال الهندسية -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                :class="isDark ? 'absolute top-1/4 right-1/3 w-10 h-10 border border-indigo-400/30 rotate-45 animate-float' : 'absolute top-1/4 right-1/3 w-10 h-10 border border-indigo-200/40 rotate-45 animate-float'"
            ></div>
            <div
                :class="isDark ? 'absolute bottom-1/4 left-1/3 w-8 h-8 border border-purple-400/30 -rotate-12 animate-float-delayed' : 'absolute bottom-1/4 left-1/3 w-8 h-8 border border-purple-200/40 -rotate-12 animate-float-delayed'"
            ></div>
            <div
                :class="isDark ? 'absolute top-2/3 right-1/4 w-6 h-6 border border-blue-400/30 rotate-90 animate-float' : 'absolute top-2/3 right-1/4 w-6 h-6 border border-blue-200/40 rotate-90 animate-float'"
            ></div>
        </div>

        <!-- Main Container -->
        <div
            class="relative z-10 min-h-screen flex items-center justify-center p-4"
        >
            <div class="w-full max-w-4xl">
                <!-- Register Card -->
                <div
                    :class="isDark ? 'glass-card-premium rounded-2xl overflow-hidden shadow-xl border border-white/10 backdrop-blur-xl relative group animate-slide-up' : 'bg-white rounded-2xl overflow-hidden shadow-xl border border-blue-100 relative group animate-slide-up'"
                >
                    <!-- Gradient Overlay -->
                    <div
                        :class="isDark ? 'absolute inset-0 bg-gradient-to-br from-purple-500/5 via-transparent to-blue-500/5 opacity-60 pointer-events-none' : 'absolute inset-0 bg-gradient-to-br from-purple-200/10 via-transparent to-blue-200/10 opacity-60 pointer-events-none'"
                    ></div>

                    <!-- Shimmer Effect -->
                    <div
                        class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-700"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent -skew-x-12 animate-shimmer"
                        ></div>
                    </div>

                    <div class="relative z-10 p-8 lg:p-10">
                        <!-- Header with Icon -->
                        <div class="text-center mb-8">
                            <div
                                :class="isDark ? 'inline-flex items-center justify-center w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-br from-purple-600 to-blue-600 rounded-2xl mb-4 shadow-lg group-hover:scale-110 transition-all duration-500' : 'inline-flex items-center justify-center w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-br from-purple-200 to-blue-200 rounded-2xl mb-4 shadow-lg group-hover:scale-110 transition-all duration-500'"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="28"
                                    height="28"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="text-white lg:w-8 lg:h-8"
                                >
                                    <path
                                        d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                                    />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="m19 8 2 2-2 2" />
                                    <path d="m17 10 4 0" />
                                </svg>
                            </div>
                            <h2
                                :class="isDark ? 'text-xl lg:text-2xl font-bold text-white mb-1' : 'text-xl lg:text-2xl font-bold text-blue-900 mb-1'"
                            >
                                Create Your Account
                            </h2>
                            <p :class="isDark ? 'text-slate-400 text-sm lg:text-base' : 'text-slate-500 text-sm lg:text-base'">
                                Join our learning community today
                            </p>
                        </div>

                        <!-- Registration Form -->
                        <form
                            @submit.prevent="handleRegister"
                            class="space-y-8"
                            enctype="multipart/form-data"
                        >
                            <!-- Name and Email Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Name Input -->
                                <div class="space-y-2">
                                    <label
                                        class="block text-sm lg:text-base font-semibold text-slate-200"
                                        >Full Name</label
                                    >
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10"
                                        >
                                            <div
                                                class="p-2 bg-gradient-to-r from-purple-500/20 to-blue-500/20 rounded-lg backdrop-blur-sm border border-purple-500/30 group-focus-within:border-purple-400/60 transition-all duration-300"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="16"
                                                    height="16"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="text-purple-400 group-focus-within:text-purple-300"
                                                >
                                                    <path
                                                        d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"
                                                    />
                                                    <circle
                                                        cx="12"
                                                        cy="7"
                                                        r="4"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                        <input
                                            type="text"
                                            v-model="name"
                                            required
                                            class="w-full pl-16 pr-4 py-4 bg-white/10 backdrop-blur-lg border border-white/20 rounded-xl text-white placeholder-slate-400 focus:border-purple-500/60 focus:bg-white/15 focus:shadow-lg focus:shadow-purple-500/20 transition-all duration-300 group-hover:bg-white/12 group-hover:border-white/30"
                                            placeholder="Enter your full name"
                                        />
                                    </div>
                                </div>

                                <!-- Email Input -->
                                <div class="space-y-2">
                                    <label
                                        class="block text-sm lg:text-base font-semibold text-slate-200"
                                        >Email Address</label
                                    >
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10"
                                        >
                                            <div
                                                class="p-2 bg-gradient-to-r from-purple-500/20 to-blue-500/20 rounded-lg backdrop-blur-sm border border-purple-500/30 group-focus-within:border-purple-400/60 transition-all duration-300"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="16"
                                                    height="16"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="text-purple-400 group-focus-within:text-purple-300"
                                                >
                                                    <path
                                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                                                    />
                                                    <polyline
                                                        points="22,6 12,13 2,6"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                        <input
                                            type="email"
                                            v-model="email"
                                            required
                                            class="w-full pl-16 pr-4 py-4 bg-white/10 backdrop-blur-lg border border-white/20 rounded-xl text-white placeholder-slate-400 focus:border-purple-500/60 focus:bg-white/15 focus:shadow-lg focus:shadow-purple-500/20 transition-all duration-300 group-hover:bg-white/12 group-hover:border-white/30"
                                            placeholder="Enter your email address"
                                        />
                                    </div>
                                </div>
                            </div>

                            <!-- Avatar Input -->
                            <div class="space-y-2">
                                <label class="block text-sm lg:text-base font-semibold text-slate-200">Profile Image (optional)</label>
                                <input type="file" accept="image/*" @change="onAvatarChange" class="w-full text-white" />
                                <div v-if="avatarPreview" class="mt-2">
                                    <img :src="avatarPreview" alt="Avatar Preview" class="h-20 w-20 rounded-full object-cover border border-white/20" />
                                </div>
                            </div>

                            <!-- Password Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Password Input -->
                                <div class="space-y-2">
                                    <label
                                        class="block text-sm lg:text-base font-semibold text-slate-200"
                                    >
                                        Password
                                    </label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10"
                                        >
                                            <div
                                                class="p-2 bg-gradient-to-r from-purple-500/20 to-blue-500/20 rounded-lg backdrop-blur-sm border border-purple-500/30 group-focus-within:border-purple-400/60 transition-all duration-300"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="16"
                                                    height="16"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="text-purple-400 group-focus-within:text-purple-300"
                                                >
                                                    <rect
                                                        width="18"
                                                        height="11"
                                                        x="3"
                                                        y="11"
                                                        rx="2"
                                                        ry="2"
                                                    />
                                                    <path
                                                        d="m7 11 0-5a5 5 0 0 1 10 0l0 5"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                        <input
                                            :type="
                                                showPassword
                                                    ? 'text'
                                                    : 'password'
                                            "
                                            v-model="password"
                                            required
                                            class="w-full pl-16 pr-12 py-4 bg-white/10 backdrop-blur-lg border border-white/20 rounded-xl text-white placeholder-slate-400 focus:border-purple-500/60 focus:bg-white/15 focus:shadow-lg focus:shadow-purple-500/20 transition-all duration-300 group-hover:bg-white/12 group-hover:border-white/30"
                                            placeholder="Create a strong password"
                                        />
                                        <button
                                            type="button"
                                            @click="
                                                showPassword = !showPassword
                                            "
                                            class="absolute right-4 top-1/2 -translate-y-1/2 p-2 hover:bg-white/10 rounded-lg transition-colors duration-200"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="16"
                                                height="16"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="text-purple-400 transition-colors"
                                            >
                                                <path
                                                    v-if="!showPassword"
                                                    d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"
                                                />
                                                <circle
                                                    v-if="!showPassword"
                                                    cx="12"
                                                    cy="12"
                                                    r="3"
                                                />
                                                <path
                                                    v-if="showPassword"
                                                    d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"
                                                />
                                                <path
                                                    v-if="showPassword"
                                                    d="M14.12 14.12a3 3 0 1 1-4.24-4.24"
                                                />
                                                <path
                                                    v-if="showPassword"
                                                    d="M1 1 23 23"
                                                />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Password Strength Indicator -->
                                    <div
                                        v-if="password"
                                        class="mt-1.5 space-y-1.5"
                                    >
                                        <div
                                            class="flex items-center justify-between text-xs"
                                        >
                                            <div
                                                class="flex items-center gap-2"
                                            >
                                                <div
                                                    class="w-1.5 h-4 rounded-sm bg-gradient-to-t transition-all duration-300"
                                                    :class="{
                                                        'from-rose-500 to-pink-500':
                                                            passwordStrength <
                                                            40,
                                                        'from-purple-500 to-indigo-500':
                                                            passwordStrength >=
                                                                40 &&
                                                            passwordStrength <
                                                                70,
                                                        'from-blue-500 to-purple-500':
                                                            passwordStrength >=
                                                            70,
                                                    }"
                                                ></div>
                                                <span
                                                    class="text-slate-300 font-medium"
                                                    >Password Strength</span
                                                >
                                            </div>
                                            <span
                                                class="font-medium tracking-wide"
                                                :class="{
                                                    'text-rose-400':
                                                        passwordStrength < 40,
                                                    'text-purple-400':
                                                        passwordStrength >=
                                                            40 &&
                                                        passwordStrength < 70,
                                                    'text-blue-400':
                                                        passwordStrength >= 70,
                                                }"
                                            >
                                                {{ passwordStrengthText }}
                                            </span>
                                        </div>
                                        <div
                                            class="h-1 bg-white/5 rounded-full overflow-hidden"
                                        >
                                            <div
                                                class="h-full transition-all duration-300 rounded-full"
                                                :class="{
                                                    'bg-gradient-to-r from-rose-500 via-pink-500 to-rose-500':
                                                        passwordStrength < 40,
                                                    'bg-gradient-to-r from-purple-500 via-indigo-500 to-purple-500':
                                                        passwordStrength >=
                                                            40 &&
                                                        passwordStrength < 70,
                                                    'bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500':
                                                        passwordStrength >= 70,
                                                }"
                                                :style="{
                                                    width: passwordStrengthWidth,
                                                }"
                                            ></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Confirm Password Input -->
                                <div class="space-y-2">
                                    <label
                                        class="block text-sm lg:text-base font-semibold text-slate-200"
                                    >
                                        Confirm Password
                                    </label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10"
                                        >
                                            <div
                                                class="p-2 bg-gradient-to-r from-purple-500/20 to-blue-500/20 rounded-lg backdrop-blur-sm border border-purple-500/30 group-focus-within:border-purple-400/60 transition-all duration-300"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="16"
                                                    height="16"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="text-purple-400 group-focus-within:text-purple-300"
                                                >
                                                    <path d="M9 12l2 2 4-4" />
                                                    <path
                                                        d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7"
                                                    />
                                                    <path d="M5 12h14" />
                                                    <path
                                                        d="M5 12a2 2 0 1 1 0-4h14a2 2 0 1 1 0 4"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                        <input
                                            :type="
                                                showConfirmPassword
                                                    ? 'text'
                                                    : 'password'
                                            "
                                            v-model="password_confirmation"
                                            required
                                            class="w-full pl-16 pr-12 py-4 bg-white/10 backdrop-blur-lg border border-white/20 rounded-xl text-white placeholder-slate-400 focus:border-purple-500/60 focus:bg-white/15 focus:shadow-lg focus:shadow-purple-500/20 transition-all duration-300 group-hover:bg-white/12 group-hover:border-white/30"
                                            placeholder="Confirm your password"
                                        />
                                        <button
                                            type="button"
                                            @click="
                                                showConfirmPassword =
                                                    !showConfirmPassword
                                            "
                                            class="absolute right-4 top-1/2 -translate-y-1/2 p-2 hover:bg-white/10 rounded-lg transition-colors duration-200"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="16"
                                                height="16"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="text-purple-400 transition-colors"
                                            >
                                                <path
                                                    v-if="!showConfirmPassword"
                                                    d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"
                                                />
                                                <circle
                                                    v-if="!showConfirmPassword"
                                                    cx="12"
                                                    cy="12"
                                                    r="3"
                                                />
                                                <path
                                                    v-if="showConfirmPassword"
                                                    d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"
                                                />
                                                <path
                                                    v-if="showConfirmPassword"
                                                    d="M14.12 14.12a3 3 0 1 1-4.24-4.24"
                                                />
                                                <path
                                                    v-if="showConfirmPassword"
                                                    d="M1 1 23 23"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="flex items-center space-x-3">
                                <label
                                    class="relative flex items-center cursor-pointer group"
                                >
                                    <input
                                        type="checkbox"
                                        v-model="agreeToTerms"
                                        required
                                        class="sr-only peer"
                                    />
                                    <div
                                        class="w-5 h-5 border-2 rounded transition-all duration-300 flex items-center justify-center"
                                        :class="
                                            agreeToTerms
                                                ? 'border-purple-500 bg-gradient-to-r from-purple-500 to-blue-500'
                                                : 'border-slate-400 bg-transparent group-hover:border-purple-400'
                                        "
                                    >
                                        <svg
                                            v-if="agreeToTerms"
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="12"
                                            height="12"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="3"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="text-white"
                                        >
                                            <polyline points="20 6 9 17 4 12" />
                                        </svg>
                                    </div>
                                    <span
                                        class="ml-3 text-sm text-slate-300 group-hover:text-white transition-colors duration-300"
                                    >
                                        I agree to the
                                        <a
                                            href="#"
                                            class="text-purple-400 hover:text-purple-300 underline"
                                            >Terms & Conditions</a
                                        >
                                    </span>
                                </label>
                            </div>

                            <!-- Error Message -->
                            <div
                                v-if="error"
                                class="bg-red-500/15 border border-red-500/30 rounded-xl p-4 backdrop-blur-sm animate-shake"
                            >
                                <div class="flex items-center space-x-3">
                                    <div class="p-1 bg-red-500/20 rounded-lg">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="text-red-400"
                                        >
                                            <circle cx="12" cy="12" r="10" />
                                            <line
                                                x1="15"
                                                x2="9"
                                                y1="9"
                                                y2="15"
                                            />
                                            <line
                                                x1="9"
                                                x2="15"
                                                y1="9"
                                                y2="15"
                                            />
                                        </svg>
                                    </div>
                                    <span
                                        class="text-red-300 text-sm font-medium"
                                        >{{ error }}</span
                                    >
                                </div>
                            </div>

                            <!-- Register Button -->
                            <button
                                type="submit"
                                class="w-full py-4 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 rounded-xl font-bold text-white transition-all duration-300 transform hover:scale-[1.02] hover:-translate-y-0.5 shadow-lg hover:shadow-purple-500/30 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none relative overflow-hidden group"
                                :disabled="loading || !agreeToTerms"
                            >
                                <!-- Button Shimmer Effect -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 group-hover:animate-shimmer"
                                ></div>

                                <span
                                    v-if="!loading"
                                    class="flex items-center justify-center space-x-2 relative z-10"
                                >
                                    <span>Create Account</span>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="transform group-hover:translate-x-1 transition-transform duration-300"
                                    >
                                        <path d="M5 12h14" />
                                        <path d="m12 5 7 7-7 7" />
                                    </svg>
                                </span>

                                <div
                                    v-else
                                    class="flex items-center justify-center space-x-3 relative z-10"
                                >
                                    <div
                                        class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"
                                    ></div>
                                    <span>Creating Account...</span>
                                </div>
                            </button>
                        </form>

                        <!-- Login Link -->
                        <div class="text-center pt-6 mt-6 relative">
                            <div
                                class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-slate-600 to-transparent"
                            ></div>
                            <div
                                class="inline-flex items-center gap-x-4 bg-slate-900/50 -translate-y-1/2 px-4 backdrop-blur-sm"
                            >
                                <div
                                    class="h-px w-8 bg-gradient-to-r from-transparent to-slate-600"
                                ></div>
                                <p class="text-slate-400 text-sm">
                                    Already have an account?
                                </p>
                                <div
                                    class="h-px w-8 bg-gradient-to-l from-transparent to-slate-600"
                                ></div>
                            </div>
                            <router-link
                                to="/login"
                                class="inline-flex items-center mt-4 px-6 py-2 bg-gradient-to-r from-indigo-600/80 to-purple-600/80 hover:from-indigo-500 hover:to-purple-500 rounded-xl font-semibold text-white transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-indigo-500/30 backdrop-blur-sm border border-white/10 text-sm group"
                            >
                                <span>Sign In</span>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="ml-2 transform group-hover:translate-x-1 transition-transform duration-300"
                                >
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useTheme } from '../../composables/useTheme';

const router = useRouter();
const authStore = useAuthStore();
const { isDark } = useTheme();

const name = ref("");
const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const error = ref("");
const loading = ref(false);
const showPassword = ref(false);
const showConfirmPassword = ref(false);
const agreeToTerms = ref(false);
const avatar = ref(null);
const avatarPreview = ref(null);

const passwordStrength = computed(() => {
    const pwd = password.value;
    if (!pwd) return 0;

    let strength = 0;
    // Length check
    if (pwd.length >= 8) strength += 20;
    if (pwd.length >= 12) strength += 10;

    // Character types
    if (/[a-z]/.test(pwd)) strength += 20;
    if (/[A-Z]/.test(pwd)) strength += 20;
    if (/[0-9]/.test(pwd)) strength += 20;
    if (/[^A-Za-z0-9]/.test(pwd)) strength += 20;

    // Strong password: at least 8 chars, contains lower, upper, number, special
    if (
        pwd.length >= 8 &&
        /[a-z]/.test(pwd) &&
        /[A-Z]/.test(pwd) &&
        /[0-9]/.test(pwd) &&
        /[^A-Za-z0-9]/.test(pwd)
    ) {
        return 100;
    }

    return Math.min(strength, 99); // Never 100 unless all strong criteria
});

const passwordStrengthClass = computed(() => {
    const strength = passwordStrength.value;
    if (strength < 40) return "strength-weak";
    if (strength < 70) return "strength-medium";
    return "strength-strong";
});

const passwordStrengthWidth = computed(() => {
    const strength = passwordStrength.value;
    if (strength >= 70) {
        return "100%";
    }
    return `${strength}%`;
});

const passwordStrengthText = computed(() => {
    const strength = passwordStrength.value;
    if (strength < 40) return "Weak";
    if (strength < 70) return "Medium";
    return "Strong";
});

function onAvatarChange(e) {
    const file = e.target.files[0];
    avatar.value = file;
    if (file) {
        const reader = new FileReader();
        reader.onload = (ev) => {
            avatarPreview.value = ev.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        avatarPreview.value = null;
    }
}

const handleRegister = async () => {
    try {
        loading.value = true;
        error.value = "";

        if (password.value !== password_confirmation.value) {
            error.value = "Passwords do not match";
            return;
        }

        const formData = new FormData();
        formData.append("name", name.value);
        formData.append("email", email.value);
        formData.append("password", password.value);
        formData.append("password_confirmation", password_confirmation.value);
        if (avatar.value) {
            formData.append("avatar", avatar.value);
        }

        await authStore.register(formData);
        router.push("/");
    } catch (err) {
        error.value =
            err.response?.data?.message ||
            "Registration failed. Please try again.";
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
@keyframes float {
    0%,
    100% {
        transform: translateY(0) rotate(0deg) scale(1);
    }
    50% {
        transform: translateY(-15px) rotate(180deg) scale(1.1);
    }
}

@keyframes float-delayed {
    0%,
    100% {
        transform: translateY(0) rotate(0deg) scale(1);
    }
    50% {
        transform: translateY(-20px) rotate(-180deg) scale(0.9);
    }
}

.glass-card-premium {
    background: linear-gradient(
        135deg,
        rgba(255, 255, 255, 0.05),
        rgba(255, 255, 255, 0.01)
    );
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 4px 24px -1px rgba(0, 0, 0, 0.2),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

@keyframes shimmer {
    0% {
        transform: translateX(-100%) skewX(-12deg);
    }
    100% {
        transform: translateX(200%) skewX(-12deg);
    }
}

.animate-slide-up {
    animation: slide-up 0.6s ease-out forwards;
}

.animate-shimmer {
    animation: shimmer 2s linear infinite;
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
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

@keyframes shake {
    0%,
    100% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-5px);
    }
    75% {
        transform: translateX(5px);
    }
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

@media (max-width: 768px) {
    .glass-card-premium {
        backdrop-filter: blur(8px);
        margin: 1rem;
    }
}
</style>
