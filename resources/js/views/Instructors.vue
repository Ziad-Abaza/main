<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
    >
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                :class="
                    isDark
                        ? 'absolute top-20 left-10 w-72 h-72 bg-teal-600/10 rounded-full blur-3xl animate-pulse'
                        : 'absolute top-20 left-10 w-72 h-72 bg-teal-200/30 rounded-full blur-3xl animate-pulse'
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

        <!-- Floating Particles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-1/4 left-1/4 w-2 h-2 bg-teal-400 rounded-full animate-float"
            ></div>
            <div
                class="absolute top-1/3 left-3/4 w-1.5 h-1.5 bg-purple-400 rounded-full animate-float-delayed"
            ></div>
            <div
                class="absolute top-2/3 left-1/6 w-2.5 h-2.5 bg-cyan-400 rounded-full animate-float-slow"
            ></div>
        </div>

        <div class="container mx-auto px-6 py-12 relative z-10">
            <!-- Header Section -->
            <div class="text-center mb-16 animate-fade-in-up">
                <div
                    :class="
                        isDark
                            ? 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-500/20 to-cyan-500/20 border border-teal-500/30 rounded-full backdrop-blur-sm mb-6'
                            : 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-200/30 to-cyan-200/30 border border-teal-200/40 rounded-full backdrop-blur-sm mb-6'
                    "
                >
                    <span
                        :class="
                            isDark
                                ? 'text-sm font-medium text-teal-300'
                                : 'text-sm font-medium text-teal-700'
                        "
                    >
                        🧑‍🏫 Expert Educators
                    </span>
                </div>
                <h1 class="text-5xl md:text-6xl font-black mb-6">
                    <span
                        :class="
                            isDark
                                ? 'bg-gradient-to-r from-white via-teal-100 to-cyan-100 bg-clip-text text-transparent'
                                : 'bg-gradient-to-r from-slate-900 via-teal-800 to-cyan-800 bg-clip-text text-transparent'
                        "
                    >
                        Meet Our Instructors
                    </span>
                </h1>
                <p
                    :class="
                        isDark
                            ? 'text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed'
                            : 'text-xl text-slate-700 max-w-2xl mx-auto leading-relaxed'
                    "
                >
                    Learn from
                    <span
                        :class="
                            isDark
                                ? 'text-teal-400 font-semibold'
                                : 'text-teal-700 font-semibold'
                        "
                    >
                        industry professionals
                    </span>
                    who bring real-world knowledge to every lesson
                </p>
            </div>

            <!-- Search Bar -->
            <div class="mb-12 max-w-2xl mx-auto">
                <div class="relative group">
                    <div
                        :class="
                            isDark
                                ? 'absolute inset-0 bg-gradient-to-r from-teal-600/20 to-cyan-600/20 rounded-2xl blur-lg group-focus-within:blur-xl transition-all duration-300'
                                : 'absolute inset-0 bg-gradient-to-r from-teal-200/40 to-cyan-200/40 rounded-2xl blur-lg group-focus-within:blur-xl transition-all duration-300'
                        "
                    ></div>
                    <div
                        :class="
                            isDark
                                ? 'relative glass-card-premium rounded-2xl border border-white/20 group-focus-within:border-teal-500/50 transition-all duration-300'
                                : 'relative bg-white/90 backdrop-blur-sm rounded-2xl border border-teal-200/50 group-focus-within:border-teal-500/70 transition-all duration-300'
                        "
                    >
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search instructors by name or specialization..."
                            :class="
                                isDark
                                    ? 'w-full p-6 bg-transparent text-white placeholder:text-white/50 focus:outline-none pl-14 pr-6 text-lg'
                                    : 'w-full p-6 bg-transparent text-slate-800 placeholder:text-slate-500 focus:outline-none pl-14 pr-6 text-lg'
                            "
                        />
                        <font-awesome-icon
                            icon="search"
                            :class="
                                isDark
                                    ? 'absolute left-5 top-1/2 transform -translate-y-1/2 text-teal-400 text-xl'
                                    : 'absolute left-5 top-1/2 transform -translate-y-1/2 text-teal-600 text-xl'
                            "
                        />
                        <div
                            class="absolute right-4 top-1/2 transform -translate-y-1/2"
                        >
                            <div
                                :class="
                                    isDark
                                        ? 'px-3 py-1 bg-teal-500/20 rounded-lg text-xs text-teal-300 border border-teal-500/30'
                                        : 'px-3 py-1 bg-teal-100/80 rounded-lg text-xs text-teal-700 border border-teal-300/60'
                                "
                            >
                                {{ filteredInstructors.length }} found
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading state -->
            <div v-if="loading" class="text-center py-16">
                <div
                    :class="
                        isDark
                            ? 'inline-flex items-center gap-3 text-slate-400'
                            : 'inline-flex items-center gap-3 text-slate-600'
                    "
                >
                    <div
                        class="animate-spin rounded-full h-8 w-8 border-b-2 border-teal-500"
                    ></div>
                    <span class="text-lg">Loading instructors...</span>
                </div>
            </div>

            <!-- Error state -->
            <div
                v-else-if="error"
                :class="
                    isDark
                        ? 'text-center py-16 glass-card-premium rounded-2xl p-8 border border-red-500/20'
                        : 'text-center py-16 bg-white/90 backdrop-blur-sm rounded-2xl p-8 border border-red-500/20 shadow-xl'
                "
            >
                <div class="text-red-400 text-lg font-semibold">
                    {{ error }}
                </div>
                <button
                    @click="fetchInstructors"
                    :class="
                        isDark
                            ? 'mt-4 px-4 py-2 bg-teal-500/20 hover:bg-teal-500/30 rounded-lg text-sm text-teal-300 transition-colors'
                            : 'mt-4 px-4 py-2 bg-teal-100/80 hover:bg-teal-200/90 rounded-lg text-sm text-teal-700 transition-colors'
                    "
                >
                    Try Again
                </button>
            </div>

            <!-- Instructors Grid -->
            <div
                v-else
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16"
            >
                <!-- Instructor Card -->
                <div
                    v-for="(instructor, index) in paginatedInstructors"
                    :key="instructor.id"
                    class="group relative transform transition-all duration-700 hover:scale-105 hover:-translate-y-3"
                    :style="{ animationDelay: index * 0.1 + 's' }"
                >
                    <div
                        :class="
                            isDark
                                ? 'glass-card-premium rounded-3xl shadow-2xl overflow-hidden border border-white/10 h-full flex flex-col backdrop-blur-xl hover:shadow-teal-500/20 hover:border-teal-500/30 transition-all duration-500'
                                : 'bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-teal-200/30 h-full flex flex-col hover:shadow-teal-500/20 hover:border-teal-500/50 transition-all duration-500'
                        "
                    >
                        <!-- Decorative Background -->
                        <div
                            :class="
                                isDark
                                    ? 'absolute inset-0 bg-gradient-to-br from-teal-500/5 via-cyan-500/5 to-purple-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                    : 'absolute inset-0 bg-gradient-to-br from-teal-100/30 via-cyan-100/30 to-purple-100/30 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                            "
                        ></div>

                        <!-- Instructor image -->
                        <div
                            class="relative p-6 bg-gradient-to-br from-teal-500/10 to-purple-500/10"
                        >
                            <div
                                :class="
                                    isDark
                                        ? 'w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-teal-500 via-cyan-500 to-purple-500 p-1 group-hover:scale-110 transition-transform duration-500 shadow-xl'
                                        : 'w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-teal-500 via-cyan-500 to-purple-500 p-1 group-hover:scale-110 transition-transform duration-500 shadow-xl'
                                "
                            >
                                <img
                                    :src="instructor.image"
                                    :alt="instructor.name"
                                    @error="$event.target.src = defaultAvatar"
                                    :class="
                                        isDark
                                            ? 'w-full h-full rounded-full border-4 border-slate-800 object-cover group-hover:border-teal-500/50 transition-colors duration-500'
                                            : 'w-full h-full rounded-full border-4 border-white object-cover group-hover:border-teal-500/50 transition-colors duration-500'
                                    "
                                />
                            </div>

                            <!-- Status Indicator -->
                            <div
                                :class="
                                    isDark
                                        ? 'absolute bottom-6 right-1/3 w-6 h-6 bg-teal-500 rounded-full border-4 border-slate-900 animate-pulse shadow-lg'
                                        : 'absolute bottom-6 right-1/3 w-6 h-6 bg-teal-500 rounded-full border-4 border-white animate-pulse shadow-lg'
                                "
                            ></div>

                            <!-- Social Links -->
                            <div class="absolute top-6 right-6">
                                <div class="flex gap-2">
                                    <a
                                        v-if="instructor.linkedinUrl"
                                        :href="instructor.linkedinUrl"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-center hover:from-blue-500 hover:to-blue-600 transition-all duration-300 transform hover:scale-110 opacity-0 group-hover:opacity-100 shadow-lg hover:shadow-blue-500/25"
                                        style="animation-delay: 0.2s"
                                    >
                                        <font-awesome-icon
                                            :icon="['fab', 'linkedin-in']"
                                            class="text-white text-xs"
                                        />
                                    </a>
                                    <a
                                        v-if="instructor.githubUrl"
                                        :href="instructor.githubUrl"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="w-8 h-8 rounded-full bg-gradient-to-r from-gray-800 to-gray-900 flex items-center justify-center hover:from-gray-700 hover:to-gray-800 transition-all duration-300 transform hover:scale-110 opacity-0 group-hover:opacity-100 shadow-lg hover:shadow-gray-500/25"
                                        style="animation-delay: 0.3s"
                                    >
                                        <font-awesome-icon
                                            :icon="['fab', 'github']"
                                            class="text-white text-xs"
                                        />
                                    </a>
                                </div>
                            </div>

                            <!-- Course Count Badge -->
                            <div
                                v-if="instructor.statistics.coursesCount > 0"
                                class="absolute -bottom-2 left-1/2 transform -translate-x-1/2"
                            >
                                <div
                                    :class="
                                        isDark
                                            ? 'bg-white/20 backdrop-blur-md border border-white/30 text-white px-3 py-1 rounded-full shadow-lg group-hover:bg-white/30 group-hover:border-white/50 transition-all duration-300'
                                            : 'bg-white/95 backdrop-blur-md border border-teal-200/70 text-slate-800 px-3 py-1 rounded-full shadow-lg group-hover:bg-white group-hover:border-teal-300/90 transition-all duration-300'
                                    "
                                >
                                    <div class="flex items-center gap-1.5">
                                        <font-awesome-icon
                                            icon="chalkboard-teacher"
                                            :class="
                                                isDark
                                                    ? 'text-teal-300 text-xs'
                                                    : 'text-teal-600 text-xs'
                                            "
                                        />
                                        <span class="text-xs font-semibold">
                                            {{
                                                instructor.statistics
                                                    .coursesCount
                                            }}
                                            {{
                                                instructor.statistics
                                                    .coursesCount === 1
                                                    ? "Course"
                                                    : "Courses"
                                            }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Instructor content -->
                        <div class="p-6 flex-1 flex flex-col relative z-10">
                            <!-- Name -->
                            <h3
                                :class="
                                    isDark
                                        ? 'text-xl font-bold mb-1 text-white line-clamp-1 text-center group-hover:text-teal-400 transition-colors duration-500'
                                        : 'text-xl font-bold mb-1 text-slate-900 line-clamp-1 text-center group-hover:text-teal-700 transition-colors duration-500'
                                "
                            >
                                {{ instructor.name }}
                            </h3>

                            <!-- Specialization -->
                            <p
                                :class="
                                    isDark
                                        ? 'text-teal-400 font-medium mb-2 text-center'
                                        : 'text-teal-600 font-medium mb-2 text-center'
                                "
                            >
                                {{ instructor.specialization }}
                            </p>

                            <!-- Experience -->
                            <div
                                :class="
                                    isDark
                                        ? 'flex items-center justify-center gap-1.5 mb-4 text-slate-400 text-sm text-center'
                                        : 'flex items-center justify-center gap-1.5 mb-4 text-slate-600 text-sm text-center'
                                "
                            >
                                <font-awesome-icon icon="briefcase" />
                                <span
                                    >{{ instructor.experience }} of
                                    experience</span
                                >
                            </div>

                            <!-- Bio -->
                            <p
                                :class="
                                    isDark
                                        ? 'text-slate-300 text-sm mb-6 line-clamp-2 text-center'
                                        : 'text-slate-700 text-sm mb-6 line-clamp-2 text-center'
                                "
                            >
                                {{ instructor.bio }}
                            </p>

                            <!-- Instructor stats -->
                            <div
                                :class="
                                    isDark
                                        ? 'grid grid-cols-3 gap-4 mt-auto pt-4 border-t border-slate-700'
                                        : 'grid grid-cols-3 gap-4 mt-auto pt-4 border-t border-slate-300'
                                "
                            >
                                <div class="text-center group">
                                    <div
                                        :class="
                                            isDark
                                                ? 'text-lg font-bold text-white group-hover:text-teal-400 transition-colors duration-300'
                                                : 'text-lg font-bold text-slate-900 group-hover:text-teal-700 transition-colors duration-300'
                                        "
                                    >
                                        {{ instructor.statistics.coursesCount }}
                                    </div>
                                    <div
                                        :class="
                                            isDark
                                                ? 'text-xs text-slate-400 group-hover:text-slate-300 transition-colors duration-300'
                                                : 'text-xs text-slate-600 group-hover:text-slate-700 transition-colors duration-300'
                                        "
                                    >
                                        Courses
                                    </div>
                                </div>
                                <div class="text-center group">
                                    <div
                                        :class="
                                            isDark
                                                ? 'text-lg font-bold text-white group-hover:text-cyan-400 transition-colors duration-300'
                                                : 'text-lg font-bold text-slate-900 group-hover:text-cyan-700 transition-colors duration-300'
                                        "
                                    >
                                        {{
                                            instructor.statistics.totalStudents
                                        }}
                                    </div>
                                    <div
                                        :class="
                                            isDark
                                                ? 'text-xs text-slate-400 group-hover:text-slate-300 transition-colors duration-300'
                                                : 'text-xs text-slate-600 group-hover:text-slate-700 transition-colors duration-300'
                                        "
                                    >
                                        Students
                                    </div>
                                </div>
                                <div class="text-center group">
                                    <div
                                        :class="
                                            isDark
                                                ? 'text-lg font-bold text-white group-hover:text-purple-400 transition-colors duration-300'
                                                : 'text-lg font-bold text-slate-900 group-hover:text-purple-700 transition-colors duration-300'
                                        "
                                    >
                                        {{ instructor.statistics.totalVideos }}
                                    </div>
                                    <div
                                        :class="
                                            isDark
                                                ? 'text-xs text-slate-400 group-hover:text-slate-300 transition-colors duration-300'
                                                : 'text-xs text-slate-600 group-hover:text-slate-700 transition-colors duration-300'
                                        "
                                    >
                                        Videos
                                    </div>
                                </div>
                            </div>

                            <!-- View Profile Button -->
                            <router-link
                                :to="`/instructors/${instructor.id}`"
                                :class="
                                    isDark
                                        ? 'mt-6 relative inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-teal-500/30 group-hover:scale-105'
                                        : 'mt-6 relative inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white font-semibold rounded-xl transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-teal-500/30 group-hover:scale-105'
                                "
                            >
                                <!-- Button glow effect -->
                                <div
                                    :class="
                                        isDark
                                            ? 'absolute inset-0 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl blur-md opacity-0 group-hover:opacity-30 transition-opacity duration-300 -z-10'
                                            : 'absolute inset-0 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl blur-md opacity-0 group-hover:opacity-30 transition-opacity duration-300 -z-10'
                                    "
                                ></div>

                                <span
                                    class="relative z-10 flex items-center gap-2"
                                >
                                    <span>View Profile</span>
                                    <font-awesome-icon
                                        icon="arrow-right"
                                        class="transition-transform duration-300 group-hover:translate-x-1"
                                    />
                                </span>
                            </router-link>
                        </div>

                        <!-- Decorative Corner Elements -->
                        <div
                            :class="
                                isDark
                                    ? 'absolute top-4 left-4 w-3 h-3 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 transform scale-0 group-hover:scale-100 shadow-lg'
                                    : 'absolute top-4 left-4 w-3 h-3 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 transform scale-0 group-hover:scale-100 shadow-lg'
                            "
                        ></div>
                        <div
                            :class="
                                isDark
                                    ? 'absolute top-4 right-4 w-2 h-2 bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100 transform scale-0 group-hover:scale-100 shadow-lg'
                                    : 'absolute top-4 right-4 w-2 h-2 bg-gradient-to-r from-cyan-500 to-purple-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 delay-100 transform scale-0 group-hover:scale-100 shadow-lg'
                            "
                        ></div>
                        <div
                            :class="
                                isDark
                                    ? 'absolute bottom-4 left-4 w-2.5 h-2.5 bg-gradient-to-r from-purple-500 to-teal-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 delay-200 transform scale-0 group-hover:scale-100 shadow-lg'
                                    : 'absolute bottom-4 left-4 w-2.5 h-2.5 bg-gradient-to-r from-purple-500 to-teal-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 delay-200 transform scale-0 group-hover:scale-100 shadow-lg'
                            "
                        ></div>
                        <div
                            :class="
                                isDark
                                    ? 'absolute bottom-4 right-4 w-3 h-3 bg-gradient-to-r from-teal-500 to-purple-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 delay-300 transform scale-0 group-hover:scale-100 shadow-lg'
                                    : 'absolute bottom-4 right-4 w-3 h-3 bg-gradient-to-r from-teal-500 to-purple-500 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-500 delay-300 transform scale-0 group-hover:scale-100 shadow-lg'
                            "
                        ></div>

                        <!-- Animated Border -->
                        <div
                            :class="
                                isDark
                                    ? 'absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 rounded-b-3xl shadow-lg'
                                    : 'absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 rounded-b-3xl shadow-lg'
                            "
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mb-16">
                <div
                    :class="
                        isDark
                            ? 'glass-card-premium p-4 rounded-2xl shadow-2xl border border-white/20'
                            : 'bg-white/90 backdrop-blur-sm p-4 rounded-2xl shadow-2xl border border-teal-200/30'
                    "
                >
                    <nav class="flex items-center gap-2">
                        <!-- Previous Button -->
                        <button
                            @click="goToPage(currentPage - 1)"
                            :disabled="currentPage === 1"
                            :class="
                                isDark
                                    ? 'group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-700 text-white rounded-xl hover:from-teal-500 hover:to-cyan-600 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed'
                                    : 'group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-700 text-white rounded-xl hover:from-teal-500 hover:to-cyan-600 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed'
                            "
                        >
                            <font-awesome-icon
                                icon="chevron-left"
                                class="text-sm group-hover:-translate-x-1 transition-transform duration-300"
                            />
                            <span class="font-medium">Previous</span>
                        </button>

                        <!-- Page Numbers -->
                        <div class="flex items-center gap-1 mx-4">
                            <button
                                v-for="page in visiblePages"
                                :key="page"
                                @click="goToPage(page)"
                                :class="{
                                    'bg-gradient-to-r from-teal-600 to-cyan-600 text-white shadow-lg':
                                        currentPage === page,
                                    'text-slate-400 hover:text-white hover:bg-white/10':
                                        currentPage !== page,
                                }"
                                class="w-12 h-12 rounded-xl flex items-center justify-center font-semibold transition-all duration-300 hover:scale-105"
                            >
                                {{ page }}
                            </button>
                        </div>

                        <!-- Next Button -->
                        <button
                            @click="goToPage(currentPage + 1)"
                            :disabled="currentPage === totalPages"
                            :class="
                                isDark
                                    ? 'group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-700 to-teal-600 text-white rounded-xl hover:from-cyan-600 hover:to-teal-500 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed'
                                    : 'group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-700 to-teal-600 text-white rounded-xl hover:from-cyan-600 hover:to-teal-500 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed'
                            "
                        >
                            <span class="font-medium">Next</span>
                            <font-awesome-icon
                                icon="chevron-right"
                                class="text-sm group-hover:translate-x-1 transition-transform duration-300"
                            />
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Call to Action -->
            <section
                :class="
                    isDark
                        ? 'text-center glass-card-premium p-12 rounded-3xl shadow-2xl border border-white/10 relative overflow-hidden'
                        : 'text-center bg-white/95 backdrop-blur-sm p-12 rounded-3xl shadow-2xl border border-teal-200/40 relative overflow-hidden'
                "
            >
                <div
                    :class="
                        isDark
                            ? 'absolute inset-0 bg-gradient-to-r from-teal-600/5 to-cyan-600/5'
                            : 'absolute inset-0 bg-gradient-to-r from-teal-200/20 to-cyan-200/20'
                    "
                ></div>
                <div class="relative z-10">
                    <div
                        :class="
                            isDark
                                ? 'w-20 h-20 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-2xl'
                                : 'w-20 h-20 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-2xl'
                        "
                    >
                        <font-awesome-icon
                            icon="chalkboard-teacher"
                            class="text-white text-2xl"
                        />
                    </div>
                    <h2
                        :class="
                            isDark
                                ? 'text-4xl font-bold mb-4 bg-gradient-to-r from-white to-teal-100 bg-clip-text text-transparent'
                                : 'text-4xl font-bold mb-4 bg-gradient-to-r from-slate-900 to-teal-800 bg-clip-text text-transparent'
                        "
                    >
                        Want to Become an Instructor?
                    </h2>
                    <p
                        :class="
                            isDark
                                ? 'text-slate-300 mb-8 text-lg max-w-2xl mx-auto leading-relaxed'
                                : 'text-slate-700 mb-8 text-lg max-w-2xl mx-auto leading-relaxed'
                        "
                    >
                        Join our community of expert instructors and share your
                        knowledge with
                        <span
                            :class="
                                isDark
                                    ? 'text-teal-400 font-semibold'
                                    : 'text-teal-700 font-semibold'
                            "
                        >
                            learners worldwide
                        </span>
                    </p>
                    <button
                        :class="
                            isDark
                                ? 'group px-8 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 rounded-2xl font-semibold transition-all duration-300 shadow-lg hover:shadow-teal-500/25 hover:scale-105 transform'
                                : 'group px-8 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 rounded-2xl font-semibold transition-all duration-300 shadow-lg hover:shadow-teal-500/25 hover:scale-105 transform'
                        "
                    >
                        <span class="flex items-center gap-3">
                            Apply Now
                            <font-awesome-icon
                                icon="arrow-right"
                                class="group-hover:translate-x-1 transition-transform duration-300"
                            />
                        </span>
                    </button>
                </div>
            </section>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faChevronLeft,
    faChevronRight,
    faChalkboardTeacher,
    faBriefcase,
    faSearch,
    faArrowRight,
} from "@fortawesome/free-solid-svg-icons";
import { faLinkedinIn, faGithub } from "@fortawesome/free-brands-svg-icons";
import { useInstructorStore } from "@/stores/InstructorStore";
import { useTheme } from "../composables/useTheme";

// Add icons to library
library.add(
    faChevronLeft,
    faChevronRight,
    faChalkboardTeacher,
    faBriefcase,
    faSearch,
    faArrowRight,
    faLinkedinIn,
    faGithub
);

const instructorStore = useInstructorStore();
const { isDark } = useTheme();
const currentPage = ref(1);
const itemsPerPage = ref(9);
const searchQuery = ref("");
const loading = ref(true);
const error = ref(null);
const defaultAvatar = ref(
    "data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjEwMCIgaGVpZ2h0PSIxMDAiIHJ4PSI1MCIgZmlsbD0iIzQBNzY4OCIvPjxjaXJjbGUgY3g9IjUwIiBjeT0iNDAiIHI9IjE1IiBmaWxsPSJ3aGl0ZSIgZmlsbC1vcGFjaXR5PSIwLjgiLz48cGF0aCBkPSJNMjUgNzVjMC0xMy44IDExLjItMjUgMjUtMjVzMjUgMTEuMiAyNSAyNXYxMEgyNVY3NXoiIGZpbGw9IndoaXRlIiBmaWxsLW9wYWNpdHk9IjAuOCIvPjwvc3ZnPg=="
);

// Computed properties
const filteredInstructors = computed(() => {
    const query = searchQuery.value.toLowerCase();
    return instructorStore.instructors.filter(
        (instructor) =>
            instructor.name.toLowerCase().includes(query) ||
            instructor.specialization.toLowerCase().includes(query) ||
            instructor.bio.toLowerCase().includes(query)
    );
});

const totalPages = computed(() =>
    Math.ceil(filteredInstructors.value.length / itemsPerPage.value)
);

const paginatedInstructors = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    return filteredInstructors.value.slice(start, start + itemsPerPage.value);
});

const visiblePages = computed(() => {
    const pages = [];
    const maxVisible = 5;
    let start = Math.max(1, currentPage.value - Math.floor(maxVisible / 2));
    let end = Math.min(totalPages.value, start + maxVisible - 1);

    if (end - start + 1 < maxVisible) {
        start = Math.max(1, end - maxVisible + 1);
    }

    for (let i = start; i <= end; i++) {
        pages.push(i);
    }
    return pages;
});

// Methods
const fetchInstructors = async () => {
    loading.value = true;
    try {
        await instructorStore.fetchInstructors(
            currentPage.value,
            itemsPerPage.value
        );
        loading.value = false;
    } catch (err) {
        error.value = "Failed to load instructors. Please try again later.";
        loading.value = false;
    }
};

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
};

// Lifecycle
onMounted(async () => {
    await fetchInstructors();
});
</script>

<style scoped>
.glass-card-premium {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }
    33% {
        transform: translateY(-10px) rotate(1deg);
    }
    66% {
        transform: translateY(5px) rotate(-1deg);
    }
}

@keyframes float-delayed {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }
    33% {
        transform: translateY(-15px) rotate(-1deg);
    }
    66% {
        transform: translateY(8px) rotate(1deg);
    }
}

@keyframes float-slow {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(2deg);
    }
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
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
    animation-delay: 1s;
}

@media (max-width: 768px) {
    .glass-card-premium {
        backdrop-filter: blur(15px);
    }
    .text-5xl {
        font-size: 2.5rem;
    }
    .text-6xl {
        font-size: 3rem;
    }
}

/* Enhanced focus states for better accessibility */
button:focus-visible,
a:focus-visible,
router-link:focus-visible {
    outline: 2px solid #0d9488;
    outline-offset: 4px;
    box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.2);
}

/* High contrast focus states for dark mode */
.dark button:focus-visible,
.dark a:focus-visible,
.dark router-link:focus-visible {
    outline: 2px solid #5eead4;
    outline-offset: 4px;
    box-shadow: 0 0 0 4px rgba(94, 234, 212, 0.3);
}

.glass-card-premium:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}
</style>
