<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
        class="relative px-6 py-12"
    >
        <!-- Enhanced Animated Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Animated Background Orbs -->
            <div class="absolute inset-0">
                <div
                    :class="
                        isDark
                            ? 'absolute top-20 left-10 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl animate-pulse'
                            : 'absolute top-20 left-10 w-72 h-72 bg-blue-200/30 rounded-full blur-3xl animate-pulse'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute top-40 right-20 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000'
                            : 'absolute top-40 right-20 w-80 h-80 bg-purple-200/30 rounded-full blur-3xl animate-pulse delay-1000'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute bottom-20 left-1/3 w-60 h-60 bg-cyan-600/10 rounded-full blur-3xl animate-pulse delay-2000'
                            : 'absolute bottom-20 left-1/3 w-60 h-60 bg-cyan-200/30 rounded-full blur-3xl animate-pulse delay-2000'
                    "
                ></div>
            </div>

            <!-- Geometric Shapes -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <!-- Triangle -->
                <div
                    :class="[
                        'absolute w-24 h-24',
                        isDark
                            ? 'text-blue-400 opacity-20'
                            : 'text-blue-600 opacity-30',
                    ]"
                    style="top: 15%; left: 15%; transform: rotate(45deg)"
                >
                    <svg viewBox="0 0 100 100" fill="currentColor">
                        <polygon points="50,10 90,90 10,90" />
                    </svg>
                </div>

                <!-- Diamond -->
                <div
                    :class="[
                        'absolute w-20 h-20',
                        isDark
                            ? 'text-purple-400 opacity-25'
                            : 'text-purple-600 opacity-35',
                    ]"
                    style="bottom: 20%; right: 5%; transform: rotate(45deg)"
                >
                    <svg viewBox="0 0 100 100" fill="currentColor">
                        <polygon points="50,10 90,50 50,90 10,50" />
                    </svg>
                </div>

                <!-- Hexagon -->
                <div
                    :class="[
                        'absolute w-16 h-16',
                        isDark
                            ? 'text-cyan-400 opacity-20'
                            : 'text-cyan-600 opacity-30',
                    ]"
                    style="top: 70%; left: 5%; transform: rotate(30deg)"
                >
                    <svg viewBox="0 0 100 100" fill="currentColor">
                        <polygon points="50,10 85,25 85,75 50,90 15,75 15,25" />
                    </svg>
                </div>

                <!-- Circle -->
                <div
                    :class="[
                        'absolute w-20 h-20',
                        isDark
                            ? 'text-teal-400 opacity-20'
                            : 'text-teal-600 opacity-30',
                    ]"
                    style="top: 45%; right: 5%"
                >
                    <svg viewBox="0 0 100 100" fill="currentColor">
                        <circle cx="50" cy="50" r="40" />
                    </svg>
                </div>

                <!-- Star -->
                <div
                    :class="[
                        'absolute w-16 h-16',
                        isDark
                            ? 'text-pink-400 opacity-25'
                            : 'text-pink-600 opacity-35',
                    ]"
                    style="bottom: 35%; left: 25%; transform: rotate(15deg)"
                >
                    <svg viewBox="0 0 100 100" fill="currentColor">
                        <polygon
                            points="50,10 61,35 90,35 65,55 75,85 50,65 25,85 35,55 10,35 39,35"
                        />
                    </svg>
                </div>
            </div>

            <!-- Floating Particles -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div
                    :class="[
                        'absolute top-1/3 left-1/4 w-2 h-2 rounded-full animate-float',
                        isDark ? 'bg-blue-400' : 'bg-blue-600',
                    ]"
                ></div>
                <div
                    :class="[
                        'absolute bottom-1/3 right-1/4 w-1.5 h-1.5 rounded-full animate-float-delayed',
                        isDark ? 'bg-purple-400' : 'bg-purple-600',
                    ]"
                ></div>
                <div
                    :class="[
                        'absolute top-2/3 left-1/3 w-1 h-1 rounded-full animate-float-slow',
                        isDark ? 'bg-cyan-400' : 'bg-cyan-600',
                    ]"
                ></div>
            </div>
        </div>

        <!-- Main Content Container -->
        <div class="relative z-10 container mx-auto max-w-6xl">
            <!-- Enhanced Header Section -->
            <div class="text-center mb-16">
                <div
                    :class="[
                        'inline-flex items-center px-6 py-3 border rounded-full backdrop-blur-sm mb-6',
                        isDark
                            ? 'bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-cyan-500/20 border-blue-500/30'
                            : 'bg-gradient-to-r from-blue-200/40 via-purple-200/40 to-cyan-200/40 border-blue-300/50',
                    ]"
                >
                    <span
                        :class="[
                            'text-sm font-bold',
                            isDark ? 'text-blue-300' : 'text-blue-700',
                        ]"
                        >⚙️ Account Management</span
                    >
                </div>
                <h2 class="text-5xl md:text-6xl font-black mb-6">
                    <span
                        :class="[
                            'bg-clip-text text-transparent',
                            isDark
                                ? 'bg-gradient-to-r from-white via-blue-100 to-purple-100'
                                : 'bg-gradient-to-r from-slate-900 via-blue-800 to-purple-800',
                        ]"
                    >
                        Account Settings
                    </span>
                </h2>
                <p
                    :class="[
                        'text-xl max-w-2xl mx-auto leading-relaxed',
                        isDark ? 'text-slate-300' : 'text-slate-600',
                    ]"
                >
                    Manage your personal information, password, and account
                    preferences
                </p>
                <div
                    class="w-24 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-cyan-500 rounded-full mx-auto mt-6"
                ></div>
            </div>

            <!-- Profile Avatar Section -->
            <div class="flex justify-center mb-12">
                <div class="relative group">
                    <div
                        :class="[
                            'w-32 h-32 rounded-full overflow-hidden border-4 shadow-2xl transition-all duration-500 group-hover:scale-105 cursor-pointer',
                            isDark
                                ? 'border-blue-500/50 shadow-blue-500/25'
                                : 'border-blue-300 shadow-blue-500/20',
                        ]"
                        @click="openAvatarModal"
                    >
                        <img
                            :src="avatarPreview || userAvatar"
                            :alt="name"
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <div
                        :class="[
                            'absolute inset-0 rounded-full bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center',
                        ]"
                    >
                        <svg
                            class="w-8 h-8 text-white"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Settings Cards Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Profile Information Card -->
                <div
                    :class="[
                        'group relative overflow-hidden rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:scale-105 hover:-translate-y-2',
                        isDark
                            ? 'glass-card-premium border border-white/10'
                            : 'bg-white/80 backdrop-blur-sm border border-blue-100/50 hover:shadow-2xl hover:shadow-blue-500/10',
                    ]"
                >
                    <!-- Background gradient overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-purple-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                    ></div>

                    <!-- Content -->
                    <div class="relative z-10">
                        <!-- Card Header -->
                        <div class="mb-8">
                            <div class="flex items-center space-x-4 mb-4">
                                <div
                                    :class="[
                                        'w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg',
                                        isDark
                                            ? 'bg-gradient-to-br from-blue-600 to-purple-600'
                                            : 'bg-gradient-to-br from-blue-500 to-purple-500',
                                    ]"
                                >
                                    <svg
                                        class="w-6 h-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        :class="[
                                            'text-2xl font-bold',
                                            isDark
                                                ? 'text-white'
                                                : 'text-slate-900',
                                        ]"
                                    >
                                        Profile Information
                                    </h3>
                                    <p
                                        :class="[
                                            'text-sm',
                                            isDark
                                                ? 'text-slate-300'
                                                : 'text-slate-600',
                                        ]"
                                    >
                                        Update your personal details
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Name Update Form -->
                        <form @submit.prevent="updateName" class="space-y-6">
                            <div>
                                <label
                                    :class="[
                                        'block text-sm font-semibold mb-2',
                                        isDark
                                            ? 'text-slate-200'
                                            : 'text-slate-700',
                                    ]"
                                >
                                    Full Name
                                </label>
                                <input
                                    v-model="name"
                                    type="text"
                                    required
                                    :class="[
                                        'w-full px-4 py-3 rounded-2xl border-2 transition-all duration-300 focus:outline-none focus:ring-4',
                                        isDark
                                            ? 'bg-slate-800/50 border-slate-600/50 text-white focus:border-blue-500 focus:ring-blue-500/20'
                                            : 'bg-white/80 border-slate-200 text-slate-900 focus:border-blue-500 focus:ring-blue-500/20',
                                    ]"
                                    placeholder="Enter your full name"
                                />
                            </div>
                            <button
                                type="submit"
                                :class="[
                                    'w-full px-6 py-3 rounded-2xl font-bold text-white text-lg transition-all duration-300 transform hover:scale-105 shadow-lg',
                                    isDark
                                        ? 'bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 hover:shadow-blue-500/25'
                                        : 'bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 hover:shadow-blue-500/25',
                                ]"
                            >
                                Update Name
                            </button>
                            <div
                                v-if="nameSuccess"
                                class="text-green-500 text-sm font-medium text-center"
                            >
                                ✅ Name updated successfully!
                            </div>
                            <div
                                v-if="nameError"
                                class="text-red-500 text-sm font-medium text-center"
                            >
                                ❌ {{ nameError }}
                            </div>
                        </form>

                        <!-- Avatar Update Form -->
                        <div class="mt-8 pt-8 border-t border-slate-200/50">
                            <form
                                @submit.prevent="updateAvatar"
                                enctype="multipart/form-data"
                                class="space-y-6"
                            >
                                <div>
                                    <label
                                        :class="[
                                            'block text-sm font-semibold mb-2',
                                            isDark
                                                ? 'text-slate-200'
                                                : 'text-slate-700',
                                        ]"
                                    >
                                        Profile Photo
                                    </label>
                                    <input
                                        type="file"
                                        @change="onAvatarChange"
                                        accept="image/*"
                                        :class="[
                                            'w-full px-4 py-3 rounded-2xl border-2 transition-all duration-300 focus:outline-none focus:ring-4',
                                            isDark
                                                ? 'bg-slate-800/50 border-slate-600/50 text-white focus:border-blue-500 focus:ring-blue-500/20'
                                                : 'bg-white/80 border-slate-200 text-slate-900 focus:border-blue-500 focus:ring-blue-500/20',
                                        ]"
                                    />
                                </div>
                                <button
                                    type="submit"
                                    :class="[
                                        'w-full px-6 py-3 rounded-2xl font-bold text-white text-lg transition-all duration-300 transform hover:scale-105 shadow-lg',
                                        isDark
                                            ? 'bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 hover:shadow-cyan-500/25'
                                            : 'bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 hover:shadow-cyan-500/25',
                                    ]"
                                >
                                    Update Photo
                                </button>
                                <div
                                    v-if="avatarSuccess"
                                    class="text-green-500 text-sm font-medium text-center"
                                >
                                    ✅ Photo updated successfully!
                                </div>
                                <div
                                    v-if="avatarError"
                                    class="text-red-500 text-sm font-medium text-center"
                                >
                                    ❌ {{ avatarError }}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Password Change Card -->
                <div
                    :class="[
                        'group relative overflow-hidden rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:scale-105 hover:-translate-y-2',
                        isDark
                            ? 'glass-card-premium border border-white/10'
                            : 'bg-white/80 backdrop-blur-sm border border-blue-100/50 hover:shadow-2xl hover:shadow-blue-500/10',
                    ]"
                >
                    <!-- Background gradient overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-500/5 via-pink-500/5 to-red-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                    ></div>

                    <!-- Content -->
                    <div class="relative z-10">
                        <!-- Card Header -->
                        <div class="mb-8">
                            <div class="flex items-center space-x-4 mb-4">
                                <div
                                    :class="[
                                        'w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg',
                                        isDark
                                            ? 'bg-gradient-to-br from-purple-600 to-pink-600'
                                            : 'bg-gradient-to-br from-purple-500 to-pink-500',
                                    ]"
                                >
                                    <svg
                                        class="w-6 h-6 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        :class="[
                                            'text-2xl font-bold',
                                            isDark
                                                ? 'text-white'
                                                : 'text-slate-900',
                                        ]"
                                    >
                                        Change Password
                                    </h3>
                                    <p
                                        :class="[
                                            'text-sm',
                                            isDark
                                                ? 'text-slate-300'
                                                : 'text-slate-600',
                                        ]"
                                    >
                                        Update your account password
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Password Update Form -->
                        <form
                            @submit.prevent="updatePassword"
                            class="space-y-6"
                        >
                            <div>
                                <label
                                    :class="[
                                        'block text-sm font-semibold mb-2',
                                        isDark
                                            ? 'text-slate-200'
                                            : 'text-slate-700',
                                    ]"
                                >
                                    Current Password
                                </label>
                                <input
                                    v-model="currentPassword"
                                    type="password"
                                    required
                                    :class="[
                                        'w-full px-4 py-3 rounded-2xl border-2 transition-all duration-300 focus:outline-none focus:ring-4',
                                        isDark
                                            ? 'bg-slate-800/50 border-slate-600/50 text-white focus:border-purple-500 focus:ring-purple-500/20'
                                            : 'bg-white/80 border-slate-200 text-slate-900 focus:border-purple-500 focus:ring-purple-500/20',
                                    ]"
                                    placeholder="Enter current password"
                                />
                            </div>
                            <div>
                                <label
                                    :class="[
                                        'block text-sm font-semibold mb-2',
                                        isDark
                                            ? 'text-slate-200'
                                            : 'text-slate-700',
                                    ]"
                                >
                                    New Password
                                </label>
                                <input
                                    v-model="newPassword"
                                    type="password"
                                    required
                                    :class="[
                                        'w-full px-4 py-3 rounded-2xl border-2 transition-all duration-300 focus:outline-none focus:ring-4',
                                        isDark
                                            ? 'bg-slate-800/50 border-slate-600/50 text-white focus:border-purple-500 focus:ring-purple-500/20'
                                            : 'bg-white/80 border-slate-200 text-slate-900 focus:border-purple-500 focus:ring-purple-500/20',
                                    ]"
                                    placeholder="Enter new password"
                                />
                            </div>
                            <div>
                                <label
                                    :class="[
                                        'block text-sm font-semibold mb-2',
                                        isDark
                                            ? 'text-slate-200'
                                            : 'text-slate-700',
                                    ]"
                                >
                                    Confirm New Password
                                </label>
                                <input
                                    v-model="confirmPassword"
                                    type="password"
                                    required
                                    :class="[
                                        'w-full px-4 py-3 rounded-2xl border-2 transition-all duration-300 focus:outline-none focus:ring-4',
                                        isDark
                                            ? 'bg-slate-800/50 border-slate-600/50 text-white focus:border-purple-500 focus:ring-purple-500/20'
                                            : 'bg-white/80 border-slate-200 text-slate-900 focus:border-purple-500 focus:ring-purple-500/20',
                                    ]"
                                    placeholder="Confirm new password"
                                />
                            </div>
                            <button
                                type="submit"
                                :class="[
                                    'w-full px-6 py-3 rounded-2xl font-bold text-white text-lg transition-all duration-300 transform hover:scale-105 shadow-lg',
                                    isDark
                                        ? 'bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 hover:shadow-purple-500/25'
                                        : 'bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 hover:shadow-purple-500/25',
                                ]"
                            >
                                Update Password
                            </button>
                            <div
                                v-if="passwordSuccess"
                                class="text-green-500 text-sm font-medium text-center"
                            >
                                ✅ Password updated successfully!
                            </div>
                            <div
                                v-if="passwordError"
                                class="text-red-500 text-sm font-medium text-center"
                            >
                                ❌ {{ passwordError }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Avatar Modal -->
        <transition name="fade">
            <div
                v-if="showAvatarModal"
                class="modal-overlay"
                @click.self="closeAvatarModal"
            >
                <div
                    :class="[
                        'modal-content rounded-3xl p-8 shadow-2xl backdrop-blur-lg border',
                        isDark
                            ? 'bg-slate-800/90 border-white/20'
                            : 'bg-white/95 border-slate-200/50',
                    ]"
                >
                    <button
                        class="modal-close absolute top-4 right-4 w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300"
                        :class="[
                            isDark
                                ? 'bg-slate-700/50 text-slate-300 hover:bg-red-500/20 hover:text-red-400'
                                : 'bg-slate-100 text-slate-600 hover:bg-red-100 hover:text-red-500',
                        ]"
                        @click="closeAvatarModal"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>

                    <div class="text-center">
                        <div class="mb-6">
                            <div
                                :class="[
                                    'w-32 h-32 rounded-full overflow-hidden border-4 mx-auto shadow-2xl',
                                    isDark
                                        ? 'border-blue-500/50 shadow-blue-500/25'
                                        : 'border-blue-300 shadow-blue-500/20',
                                ]"
                            >
                                <img
                                    :src="avatarPreview || userAvatar"
                                    :alt="name"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>

                        <h3
                            :class="[
                                'text-2xl font-bold mb-4',
                                isDark ? 'text-white' : 'text-slate-900',
                            ]"
                        >
                            Update Profile Photo
                        </h3>

                        <form
                            @submit.prevent="updateAvatar"
                            enctype="multipart/form-data"
                            class="space-y-6"
                        >
                            <div>
                                <input
                                    type="file"
                                    @change="onAvatarChange"
                                    accept="image/*"
                                    :class="[
                                        'w-full px-4 py-3 rounded-2xl border-2 transition-all duration-300 focus:outline-none focus:ring-4',
                                        isDark
                                            ? 'bg-slate-700/50 border-slate-600/50 text-white focus:border-blue-500 focus:ring-blue-500/20'
                                            : 'bg-white/80 border-slate-200 text-slate-900 focus:border-blue-500 focus:ring-blue-500/20',
                                    ]"
                                />
                            </div>
                            <button
                                type="submit"
                                :disabled="!avatarFile"
                                :class="[
                                    'w-full px-6 py-3 rounded-2xl font-bold text-white text-lg transition-all duration-300 transform hover:scale-105 shadow-lg',
                                    avatarFile
                                        ? isDark
                                            ? 'bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 hover:shadow-blue-500/25'
                                            : 'bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 hover:shadow-blue-500/25'
                                        : 'bg-gray-400 cursor-not-allowed opacity-60',
                                ]"
                            >
                                Change Photo
                            </button>
                            <div
                                v-if="avatarSuccess"
                                class="text-green-500 text-sm font-medium"
                            >
                                ✅ Photo updated successfully!
                            </div>
                            <div
                                v-if="avatarError"
                                class="text-red-500 text-sm font-medium"
                            >
                                ❌ {{ avatarError }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useTheme } from "../composables/useTheme";

const name = ref("");
const userAvatar = ref("");
const nameSuccess = ref(false);
const nameError = ref("");

const currentPassword = ref("");
const newPassword = ref("");
const confirmPassword = ref("");
const passwordSuccess = ref(false);
const passwordError = ref("");

const avatarFile = ref(null);
const avatarPreview = ref("");
const avatarSuccess = ref(false);
const avatarError = ref("");

const showAvatarModal = ref(false);

const { isDark, toggleTheme } = useTheme();

onMounted(async () => {
    // Fetch user info for avatar and name
    try {
        const res = await axios.get("/api/auth/user");
        name.value = res.data.user.name;
        userAvatar.value =
            res.data.user.avatar_url ||
            res.data.user.avatar ||
            "/assets/image/default-avatar.png";
    } catch {
        userAvatar.value = "/assets/image/default-avatar.png";
    }
});

const openAvatarModal = () => {
    showAvatarModal.value = true;
};
const closeAvatarModal = () => {
    showAvatarModal.value = false;
    avatarError.value = "";
    avatarSuccess.value = false;
};

const updateName = async () => {
    nameSuccess.value = false;
    nameError.value = "";
    try {
        await axios.patch("/api/user/settings?type=name", { name: name.value });
        nameSuccess.value = true;
    } catch (e) {
        nameError.value = e.response?.data?.message || "Failed to update name.";
    }
};

const updatePassword = async () => {
    passwordSuccess.value = false;
    passwordError.value = "";
    if (newPassword.value !== confirmPassword.value) {
        passwordError.value = "Passwords do not match.";
        return;
    }
    try {
        await axios.patch("/api/user/settings?type=password", {
            current_password: currentPassword.value,
            password: newPassword.value,
            password_confirmation: confirmPassword.value,
        });
        passwordSuccess.value = true;
        currentPassword.value = "";
        newPassword.value = "";
        confirmPassword.value = "";
    } catch (e) {
        passwordError.value =
            e.response?.data?.message || "Failed to update password.";
    }
};

const onAvatarChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        avatarFile.value = file;
        avatarPreview.value = URL.createObjectURL(file);
    }
};

const updateAvatar = async () => {
    avatarSuccess.value = false;
    avatarError.value = "";
    if (!avatarFile.value) {
        avatarError.value = "Please select a photo before submitting.";
        return;
    }
    const formData = new FormData();
    formData.append("avatar", avatarFile.value);
    try {
        const res = await axios.post(
            "/api/user/settings?type=avatar",
            formData,
            {
                headers: { "Content-Type": "multipart/form-data" },
            }
        );
        avatarSuccess.value = true;
        avatarFile.value = null;
        avatarPreview.value = res.data.avatar_url;
        userAvatar.value = res.data.avatar_url;
    } catch (e) {
        avatarError.value =
            e.response?.data?.message || "Failed to update photo.";
    }
};
</script>

<style scoped>
/* Glass Card Premium Effect */
.glass-card-premium {
    background: rgba(30, 41, 59, 0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

/* Floating Animations */
@keyframes float {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.7;
    }
    50% {
        transform: translateY(-20px) rotate(180deg);
        opacity: 1;
    }
}

@keyframes float-delayed {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.5;
    }
    50% {
        transform: translateY(-15px) rotate(-180deg);
        opacity: 0.8;
    }
}

@keyframes float-slow {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-25px) rotate(90deg);
        opacity: 1;
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
    animation-delay: 2s;
}

.animate-float-slow {
    animation: float-slow 10s ease-in-out infinite;
    animation-delay: 4s;
}

/* Pulse Animation */
@keyframes pulse {
    0%,
    100% {
        opacity: 0.3;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-pulse {
    animation: pulse 3s ease-in-out infinite;
}

/* Modal Overlay */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.8);
    backdrop-filter: blur(8px);
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

/* Enhanced Card Hover Effects */
.group:hover .glass-card-premium {
    background: rgba(30, 41, 59, 0.8);
    border-color: rgba(255, 255, 255, 0.2);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

/* Input Focus Enhancements */
input:focus {
    transform: scale(1.02);
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Button Hover Enhancements */
button:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2), 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Success/Error Message Animations */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.text-green-500,
.text-red-500 {
    animation: slideIn 0.3s ease-out;
}

/* Responsive Design Improvements */
@media (max-width: 768px) {
    .text-5xl {
        font-size: 2.5rem;
    }

    .text-6xl {
        font-size: 3rem;
    }

    .w-32 {
        width: 6rem;
    }

    .h-32 {
        height: 6rem;
    }
}

/* Enhanced Typography */
.font-black {
    font-weight: 900;
    letter-spacing: -0.025em;
}

/* Smooth Transitions */
* {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #2563eb, #7c3aed);
}
</style>
