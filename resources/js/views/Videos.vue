<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
    >
        <!-- Floating particles background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute w-2 h-2 bg-teal-400 rounded-full animate-pulse opacity-40"
                style="top: 20%; left: 10%; animation-delay: 0s"
            ></div>
            <div
                class="absolute w-1 h-1 bg-cyan-400 rounded-full animate-pulse opacity-30"
                style="top: 60%; left: 85%; animation-delay: 1s"
            ></div>
            <div
                class="absolute w-1.5 h-1.5 bg-purple-400 rounded-full animate-pulse opacity-40"
                style="top: 40%; left: 20%; animation-delay: 2s"
            ></div>
            <div
                class="absolute w-1 h-1 bg-blue-400 rounded-full animate-pulse opacity-35"
                style="top: 80%; left: 70%; animation-delay: 3s"
            ></div>
            <div
                class="absolute w-2 h-2 bg-pink-400 rounded-full animate-pulse opacity-30"
                style="top: 30%; left: 80%; animation-delay: 4s"
            ></div>
        </div>

        <div class="relative z-10 container mx-auto px-6 py-8 max-w-7xl">
            <!-- Header Section -->
            <div class="mb-8">
                <router-link
                    to="/courses"
                    :class="[
                        'inline-flex items-center space-x-2 mb-6 px-4 py-2 rounded-full transition-all duration-300 hover:scale-105',
                        isDark
                            ? 'bg-white/10 hover:bg-white/20 text-blue-300 hover:text-blue-200'
                            : 'bg-white/80 hover:bg-white text-blue-600 hover:text-blue-700 shadow-lg',
                    ]"
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
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                    <span class="font-medium">Back to Course</span>
                </router-link>

                <div class="text-center mb-8">
                    <h1
                        class="text-5xl md:text-6xl font-black mb-4 bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-500 bg-clip-text text-transparent drop-shadow-2xl tracking-tight"
                    >
                        {{ title || "Course Videos" }}
                    </h1>
                    <div
                        class="w-24 h-1 bg-gradient-to-r from-teal-400 to-purple-500 rounded-full mx-auto mb-4"
                    ></div>
                    <p
                        :class="
                            isDark
                                ? 'text-gray-300 text-lg'
                                : 'text-gray-600 text-lg'
                        "
                    >
                        Watch and interact with the course videos below
                    </p>
                </div>

                <!-- Enhanced Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div
                        :class="[
                            'group rounded-2xl p-6 shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 relative overflow-hidden',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-teal-100 hover:shadow-2xl',
                        ]"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-teal-500/5 via-transparent to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>
                        <div
                            class="relative z-10 flex items-center justify-between"
                        >
                            <div>
                                <div
                                    class="text-3xl font-black text-teal-500 mb-1"
                                >
                                    {{ videos.length }}
                                </div>
                                <div
                                    :class="
                                        isDark
                                            ? 'text-gray-300'
                                            : 'text-gray-600'
                                    "
                                    class="font-medium"
                                >
                                    Total Videos
                                </div>
                            </div>
                            <div
                                :class="
                                    isDark
                                        ? 'p-3 bg-gradient-to-br from-teal-900 to-teal-800 rounded-xl'
                                        : 'p-3 bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl'
                                "
                                class="group-hover:scale-110 transition-transform duration-300"
                            >
                                <svg
                                    class="w-8 h-8 text-teal-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        :class="[
                            'group rounded-2xl p-6 shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 relative overflow-hidden',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-green-100 hover:shadow-2xl',
                        ]"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-green-500/5 via-transparent to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>
                        <div
                            class="relative z-10 flex items-center justify-between"
                        >
                            <div>
                                <div
                                    class="text-3xl font-black text-green-500 mb-1"
                                >
                                    {{ watchedCount }}
                                </div>
                                <div
                                    :class="
                                        isDark
                                            ? 'text-gray-300'
                                            : 'text-gray-600'
                                    "
                                    class="font-medium"
                                >
                                    Watched
                                </div>
                            </div>
                            <div
                                :class="
                                    isDark
                                        ? 'p-3 bg-gradient-to-br from-green-900 to-green-800 rounded-xl'
                                        : 'p-3 bg-gradient-to-br from-green-50 to-green-100 rounded-xl'
                                "
                                class="group-hover:scale-110 transition-transform duration-300"
                            >
                                <svg
                                    class="w-8 h-8 text-green-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        :class="[
                            'group rounded-2xl p-6 shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 relative overflow-hidden',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-purple-100 hover:shadow-2xl',
                        ]"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-purple-500/5 via-transparent to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>
                        <div
                            class="relative z-10 flex items-center justify-between"
                        >
                            <div>
                                <div
                                    class="text-3xl font-black text-purple-500 mb-1"
                                >
                                    {{ quizCount }}
                                </div>
                                <div
                                    :class="
                                        isDark
                                            ? 'text-gray-300'
                                            : 'text-gray-600'
                                    "
                                    class="font-medium"
                                >
                                    Quizzes
                                </div>
                            </div>
                            <div
                                :class="
                                    isDark
                                        ? 'p-3 bg-gradient-to-br from-purple-900 to-purple-800 rounded-xl'
                                        : 'p-3 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl'
                                "
                                class="group-hover:scale-110 transition-transform duration-300"
                            >
                                <svg
                                    class="w-8 h-8 text-purple-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        :class="[
                            'group rounded-2xl p-6 shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 relative overflow-hidden',
                            isDark
                                ? 'glass-card-premium border border-white/10'
                                : 'bg-white border border-orange-100 hover:shadow-2xl',
                        ]"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-orange-500/5 via-transparent to-red-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>
                        <div
                            class="relative z-10 flex items-center justify-between"
                        >
                            <div>
                                <div
                                    class="text-3xl font-black text-orange-500 mb-1"
                                >
                                    {{ totalDuration }}
                                </div>
                                <div
                                    :class="
                                        isDark
                                            ? 'text-gray-300'
                                            : 'text-gray-600'
                                    "
                                    class="font-medium"
                                >
                                    Total Hours
                                </div>
                            </div>
                            <div
                                :class="
                                    isDark
                                        ? 'p-3 bg-gradient-to-br from-orange-900 to-orange-800 rounded-xl'
                                        : 'p-3 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl'
                                "
                                class="group-hover:scale-110 transition-transform duration-300"
                            >
                                <svg
                                    class="w-8 h-8 text-orange-500"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter and Sort Options -->
                <div
                    class="flex flex-wrap items-center justify-between mb-8 gap-4"
                >
                    <div class="flex items-center space-x-4">
                        <button
                            @click="filterBy = 'all'"
                            :class="[
                                'px-4 py-2 rounded-full font-medium transition-all duration-300',
                                filterBy === 'all'
                                    ? 'bg-gradient-to-r from-teal-500 to-cyan-500 text-white shadow-lg'
                                    : isDark
                                    ? 'bg-white/10 text-gray-300 hover:bg-white/20'
                                    : 'bg-white text-gray-600 hover:bg-gray-50',
                            ]"
                        >
                            All Videos
                        </button>
                        <button
                            @click="filterBy = 'watched'"
                            :class="[
                                'px-4 py-2 rounded-full font-medium transition-all duration-300',
                                filterBy === 'watched'
                                    ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg'
                                    : isDark
                                    ? 'bg-white/10 text-gray-300 hover:bg-white/20'
                                    : 'bg-white text-gray-600 hover:bg-gray-50',
                            ]"
                        >
                            Watched
                        </button>
                        <button
                            @click="filterBy = 'unwatched'"
                            :class="[
                                'px-4 py-2 rounded-full font-medium transition-all duration-300',
                                filterBy === 'unwatched'
                                    ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-lg'
                                    : isDark
                                    ? 'bg-white/10 text-gray-300 hover:bg-white/20'
                                    : 'bg-white text-gray-600 hover:bg-gray-50',
                            ]"
                        >
                            Unwatched
                        </button>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button
                                @click="toggleSortDropdown"
                                :class="[
                                    'flex items-center space-x-3 px-6 py-3 rounded-2xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105',
                                    isDark
                                        ? 'bg-gradient-to-r from-slate-700 to-slate-600 text-white hover:from-slate-600 hover:to-slate-500 border border-white/10'
                                        : 'bg-gradient-to-r from-white to-gray-50 text-gray-700 hover:from-gray-50 hover:to-white border border-gray-200',
                                ]"
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
                                        d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"
                                    />
                                </svg>
                                <span>{{ getSortLabel(sortBy) }}</span>
                                <svg
                                    class="w-4 h-4 transition-transform duration-300"
                                    :class="
                                        showSortDropdown ? 'rotate-180' : ''
                                    "
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>

                            <!-- Enhanced Dropdown Menu -->
                            <div
                                v-if="showSortDropdown"
                                :class="[
                                    'absolute top-full right-0 mt-3 w-64 rounded-2xl shadow-2xl z-50 overflow-hidden border',
                                    isDark
                                        ? 'bg-slate-800 border-white/20 shadow-black/50'
                                        : 'bg-white border-gray-200 shadow-gray-200/50',
                                ]"
                            >
                                <div class="p-2">
                                    <div class="px-3 py-2 mb-2">
                                        <h4
                                            :class="
                                                isDark
                                                    ? 'text-gray-300'
                                                    : 'text-gray-500'
                                            "
                                            class="text-xs font-semibold uppercase tracking-wider"
                                        >
                                            Sort Options
                                        </h4>
                                    </div>
                                    <div
                                        v-for="option in sortOptions"
                                        :key="option.value"
                                        @click="selectSortOption(option.value)"
                                        :class="[
                                            'flex items-center space-x-4 px-4 py-3 cursor-pointer transition-all duration-200 rounded-xl mx-1',
                                            sortBy === option.value
                                                ? isDark
                                                    ? 'bg-gradient-to-r from-blue-500/20 to-purple-500/20 text-blue-300 border border-blue-500/30'
                                                    : 'bg-gradient-to-r from-blue-50 to-purple-50 text-blue-600 border border-blue-200'
                                                : isDark
                                                ? 'text-gray-300 hover:bg-white/10 hover:text-white'
                                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800',
                                        ]"
                                    >
                                        <div
                                            :class="[
                                                'w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200',
                                                sortBy === option.value
                                                    ? isDark
                                                        ? 'bg-blue-500/20'
                                                        : 'bg-blue-100'
                                                    : isDark
                                                    ? 'bg-white/10'
                                                    : 'bg-gray-100',
                                            ]"
                                        >
                                            <svg
                                                class="w-4 h-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    :d="option.icon"
                                                />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <span class="font-medium text-sm">{{
                                                option.label
                                            }}</span>
                                            <p
                                                :class="
                                                    isDark
                                                        ? 'text-gray-400'
                                                        : 'text-gray-500'
                                                "
                                                class="text-xs mt-0.5"
                                            >
                                                {{ option.description }}
                                            </p>
                                        </div>
                                        <svg
                                            v-if="sortBy === option.value"
                                            class="w-5 h-5 text-blue-500"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex items-center justify-center py-16">
                <div class="flex items-center space-x-4">
                    <div
                        class="animate-spin rounded-full h-12 w-12 border-b-2 border-teal-500"
                    ></div>
                    <span
                        :class="isDark ? 'text-gray-300' : 'text-gray-600'"
                        class="text-xl font-medium"
                    >
                        Loading videos...
                    </span>
                </div>
            </div>

            <!-- Videos Grid -->
            <div
                v-else
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
            >
                <div
                    v-for="video in filteredAndSortedVideos"
                    :key="video.video_id"
                    :class="[
                        'group relative overflow-hidden rounded-2xl shadow-xl transition-all duration-500 hover:scale-105 hover:-translate-y-2 cursor-pointer',
                        isDark
                            ? 'glass-card-premium border border-white/10'
                            : 'bg-white border border-gray-100 hover:shadow-2xl',
                    ]"
                    @click="playVideo(video)"
                >
                    <!-- Background gradient overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500/5 via-purple-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                    ></div>

                    <!-- Video Thumbnail -->
                    <div class="relative aspect-video overflow-hidden">
                        <img
                            v-if="video.thumbnail"
                            :src="video.thumbnail"
                            :alt="video.title"
                            @error="$event.target.src = defaultImage"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        />
                        <img
                            v-else
                            :src="defaultImage"
                            alt="Default Thumbnail"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        />

                        <!-- Play Button Overlay -->
                        <div
                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center"
                        >
                            <div
                                class="w-16 h-16 bg-white/95 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-2xl"
                            >
                                <svg
                                    class="w-8 h-8 text-red-600 ml-1"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Duration Badge -->
                        <div
                            class="absolute bottom-2 right-2 bg-black/90 text-white text-xs px-2 py-1 rounded-md font-medium"
                        >
                            {{ formatDuration(video.duration) }}
                        </div>

                        <!-- Watched Badge -->
                        <div
                            v-if="video.watched"
                            class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-md flex items-center space-x-1 font-medium"
                        >
                            <svg
                                class="w-3 h-3"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Watched</span>
                        </div>

                        <!-- Progress Bar -->
                        <div
                            v-if="video.watched"
                            class="absolute bottom-0 left-0 right-0 h-1 bg-green-500"
                        ></div>
                    </div>

                    <!-- Video Info -->
                    <div class="p-4 relative z-10">
                        <div class="flex items-start justify-between mb-2">
                            <h3
                                class="text-sm font-bold group-hover:text-blue-500 transition-colors duration-300 line-clamp-2 flex-1 mr-2"
                            >
                                {{ video.title }}
                            </h3>
                            <div class="flex items-center space-x-1">
                                <span
                                    :class="[
                                        'text-xs px-2 py-1 rounded-full font-medium',
                                        isDark
                                            ? 'bg-slate-700 text-slate-300'
                                            : 'bg-slate-100 text-slate-600',
                                    ]"
                                >
                                    #{{ video.order }}
                                </span>
                            </div>
                        </div>

                        <!-- Video Meta -->
                        <div
                            class="flex items-center justify-between text-xs mb-3"
                        >
                            <div
                                :class="
                                    isDark ? 'text-gray-400' : 'text-gray-500'
                                "
                                class="flex items-center space-x-3"
                            >
                                <span class="flex items-center space-x-1">
                                    <svg
                                        class="w-3 h-3"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    <span>{{
                                        formatDuration(video.duration)
                                    }}</span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <svg
                                        class="w-3 h-3"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                        />
                                    </svg>
                                    <span>{{ getRandomViews() }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-2">
                            <button
                                @click.stop="playVideo(video)"
                                :class="[
                                    'flex-1 px-3 py-2 rounded-lg font-semibold text-white text-xs transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center space-x-1',
                                    isDark
                                        ? 'bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 hover:shadow-red-500/25'
                                        : 'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-400 hover:to-red-500 hover:shadow-red-500/25',
                                ]"
                            >
                                <svg
                                    class="w-3 h-3"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                                <span>Watch</span>
                            </button>

                            <button
                                v-if="video.hasQuiz"
                                @click.stop="startQuiz(video.video_id)"
                                :class="[
                                    'px-3 py-2 rounded-lg font-semibold text-xs transition-all duration-300 transform hover:scale-105 shadow-lg',
                                    isDark
                                        ? 'bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white'
                                        : 'bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-400 hover:to-emerald-400 text-white',
                                ]"
                            >
                                <svg
                                    class="w-3 h-3"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Decorative elements -->
                    <div
                        class="absolute top-3 right-3 w-2 h-2 bg-blue-400 rounded-full opacity-30 group-hover:opacity-60 transition-opacity duration-300"
                    ></div>
                    <div
                        class="absolute bottom-3 left-3 w-1 h-1 bg-purple-400 rounded-full opacity-40 group-hover:opacity-80 transition-opacity duration-300"
                    ></div>
                </div>
            </div>

            <!-- Empty State -->
            <div
                v-if="!loading && filteredAndSortedVideos.length === 0"
                class="flex flex-col items-center justify-center py-16"
            >
                <div
                    :class="isDark ? 'bg-slate-800/50' : 'bg-slate-100'"
                    class="w-24 h-24 rounded-full flex items-center justify-center mb-6"
                >
                    <svg
                        class="w-12 h-12 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                        />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2 text-slate-500">
                    No videos found
                </h3>
                <p class="text-slate-400 text-center max-w-md">
                    {{
                        filterBy === "all"
                            ? "This course doesn't have any videos yet. Check back later for new content!"
                            : `No ${filterBy} videos found.`
                    }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useVideosStore } from "@/stores/videosStore";
import { useRoute, useRouter } from "vue-router";
import { useTheme } from "../composables/useTheme";
import defaultImage from "@/assets/icons/EduStream.jpg";

const { isDark } = useTheme();
const route = useRoute();
const router = useRouter();
const id = route.params.id;

const videosStore = useVideosStore();
const videos = ref([]);
const title = ref("");
const loading = ref(true);
const filterBy = ref("all");
const sortBy = ref("order");
const showSortDropdown = ref(false);

// Sort options configuration
const sortOptions = ref([
    {
        value: "order",
        label: "Sort by Order",
        description: "Default course sequence",
        icon: "M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12",
    },
    {
        value: "duration",
        label: "Sort by Duration",
        description: "Longest to shortest",
        icon: "M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z",
    },
    {
        value: "watched",
        label: "Sort by Watched",
        description: "Watched videos first",
        icon: "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z",
    },
]);

// Dropdown methods
const toggleSortDropdown = () => {
    showSortDropdown.value = !showSortDropdown.value;
};

const selectSortOption = (value) => {
    sortBy.value = value;
    showSortDropdown.value = false;
};

const getSortLabel = (value) => {
    const option = sortOptions.value.find((opt) => opt.value === value);
    return option ? option.label : "Sort by Order";
};

// Close dropdown when clicking outside
const closeDropdown = (event) => {
    if (!event.target.closest(".relative")) {
        showSortDropdown.value = false;
    }
};

const fetchVideos = async () => {
    if (id) {
        await videosStore.fetchVideos(id);
        videos.value = videosStore.videos;
        title.value = videosStore.title;
        loading.value = false;
    }
};

onMounted(() => {
    fetchVideos();
    // Add click outside listener
    document.addEventListener("click", closeDropdown);
});

// Cleanup on unmount
onUnmounted(() => {
    document.removeEventListener("click", closeDropdown);
});

// Computed properties for stats
const watchedCount = computed(() => {
    return videos.value.filter((video) => video.watched).length;
});

const quizCount = computed(() => {
    return videos.value.filter((video) => video.hasQuiz).length;
});

const totalDuration = computed(() => {
    const totalSeconds = videos.value.reduce(
        (sum, video) => sum + (video.duration || 0),
        0
    );
    const hours = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    return hours > 0 ? `${hours}h ${minutes}m` : `${minutes}m`;
});

// Filter and sort videos
const filteredAndSortedVideos = computed(() => {
    let filtered = videos.value;

    // Filter
    if (filterBy.value === "watched") {
        filtered = filtered.filter((video) => video.watched);
    } else if (filterBy.value === "unwatched") {
        filtered = filtered.filter((video) => !video.watched);
    }

    // Sort
    filtered = [...filtered].sort((a, b) => {
        switch (sortBy.value) {
            case "duration":
                return (b.duration || 0) - (a.duration || 0);
            case "watched":
                return (b.watched ? 1 : 0) - (a.watched ? 1 : 0);
            default:
                return (a.order || 0) - (b.order || 0);
        }
    });

    return filtered;
});

// Helper function to format duration
const formatDuration = (seconds) => {
    if (!seconds) return "0:00";
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = seconds % 60;

    if (hours > 0) {
        return `${hours}:${String(minutes).padStart(2, "0")}:${String(
            remainingSeconds
        ).padStart(2, "0")}`;
    }
    return `${minutes}:${String(remainingSeconds).padStart(2, "0")}`;
};

// Generate random view count for YouTube-like feel
const getRandomViews = () => {
    const views = Math.floor(Math.random() * 1000) + 100;
    if (views >= 1000) {
        return `${(views / 1000).toFixed(1)}K views`;
    }
    return `${views} views`;
};

const playVideo = (video) => {
    router.push(`/video/${video.video_id}`);
};

const startQuiz = (videoId) => {
    console.log(`Starting quiz for video ID: ${videoId}`);
    // Add logic to navigate to the quiz page or handle quiz start
};
</script>

<style scoped>
.glass-card-premium {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom scrollbar for select */
select {
    scrollbar-width: thin;
    scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
}

select::-webkit-scrollbar {
    width: 6px;
}

select::-webkit-scrollbar-track {
    background: transparent;
}

select::-webkit-scrollbar-thumb {
    background-color: rgba(156, 163, 175, 0.5);
    border-radius: 3px;
}

select::-webkit-scrollbar-thumb:hover {
    background-color: rgba(156, 163, 175, 0.7);
}
</style>
