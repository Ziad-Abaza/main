<template>
    <div :class="isDark
            ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
            : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        ">
        <section class="relative overflow-hidden">
            <!-- Animated Background  -->
            <div class="absolute inset-0">
                <div :class="isDark
                        ? 'absolute top-20 left-10 w-72 h-72 bg-teal-600/10 rounded-full blur-3xl animate-pulse'
                        : 'absolute top-20 left-10 w-72 h-72 bg-teal-200/30 rounded-full blur-3xl animate-pulse'
                    "></div>
                <div :class="isDark
                        ? 'absolute top-40 right-20 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000'
                        : 'absolute top-40 right-20 w-80 h-80 bg-purple-200/30 rounded-full blur-3xl animate-pulse delay-1000'
                    "></div>
                <div :class="isDark
                        ? 'absolute bottom-20 left-1/3 w-60 h-60 bg-cyan-600/10 rounded-full blur-3xl animate-pulse delay-2000'
                        : 'absolute bottom-20 left-1/3 w-60 h-60 bg-cyan-200/30 rounded-full blur-3xl animate-pulse delay-2000'
                    "></div>
            </div>

            <!-- Floating Particles -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-teal-400 rounded-full animate-float"></div>
                <div class="absolute top-1/3 left-3/4 w-1.5 h-1.5 bg-purple-400 rounded-full animate-float-delayed">
                </div>
                <div class="absolute top-2/3 left-1/6 w-2.5 h-2.5 bg-cyan-400 rounded-full animate-float-slow"></div>
            </div>

            <div class="container mx-auto px-6 py-12 md:py-20 relative z-10">
                <!-- Main Hero Content -->
                <div class="flex flex-col lg:flex-row items-center justify-between gap-16">
                    <!-- Enhanced Left Side - Text Content -->
                    <div class="lg:w-1/2 text-center lg:text-left space-y-8 animate-fade-in-up">
                        <!-- Badge -->
                        <div :class="isDark
                                ? 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-500/20 to-cyan-500/20 border border-teal-500/30 rounded-full backdrop-blur-sm'
                                : 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-200/30 to-cyan-200/30 border border-teal-200/40 rounded-full backdrop-blur-sm'
                            ">
                            <span :class="isDark
                                    ? 'text-sm font-medium text-teal-300'
                                    : 'text-sm font-medium text-teal-700'
                                ">
                                🚀 New Platform Launch
                            </span>
                        </div>

                        <!-- Main Heading -->
                        <h1 class="text-5xl md:text-7xl font-black leading-tight">
                            <span :class="isDark
                                    ? 'block bg-gradient-to-r from-white via-teal-100 to-cyan-100 bg-clip-text text-transparent'
                                    : 'block bg-gradient-to-r from-slate-900 via-teal-800 to-cyan-800 bg-clip-text text-transparent'
                                ">
                                CTU Educational Platform
                            </span>
                            <span :class="isDark
                                    ? 'block bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-400 bg-clip-text text-transparent'
                                    : 'block bg-gradient-to-r from-slate-900 via-teal-800 to-purple-800 bg-clip-text text-transparent'
                                ">
                                Shape Future
                            </span>
                        </h1>

                        <!-- Description -->
                        <p :class="isDark
                                ? 'text-xl md:text-2xl text-slate-200 max-w-2xl mx-auto lg:mx-0 leading-relaxed'
                                : 'text-xl md:text-2xl text-slate-700 max-w-2xl mx-auto lg:mx-0 leading-relaxed'
                            ">
                            Transform your career with cutting-edge courses from industry experts.
                            <span :class="isDark ? 'text-teal-300 font-semibold' : 'text-teal-700 font-semibold'
                                ">
                                Learn, Build, Succeed
                            </span>
                            — all at your own pace.
                        </p>

                        <!-- Stats Row -->
                        <div class="flex flex-wrap justify-center lg:justify-start gap-8 py-6">
                            <!-- Store Stats (Debug Info) -->
                            <div v-if="false" :class="isDark
                                    ? 'group p-4 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-sm'
                                    : 'group p-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-200/50'
                                ">
                                <div class="text-center">
                                    <div :class="isDark ? 'text-sm text-slate-300' : 'text-sm text-slate-600'">
                                        Store Stats
                                    </div>
                                    <div class="grid grid-cols-2 gap-2 mt-2 text-xs">
                                        <div>Courses: {{ totalCourses }}</div>
                                        <div>Categories: {{ totalCategories }}</div>
                                        <div>Instructors: {{ totalInstructors }}</div>
                                        <div>Offers: {{ totalOffers }}</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Quality Education Card -->
                            <div :class="isDark
                                    ? 'group p-4 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-sm hover:bg-white/15 hover:border-teal-500/40 transition-all duration-300 transform hover:scale-105'
                                    : 'group p-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-teal-200/50 hover:bg-white hover:border-teal-300 transition-all duration-300 transform hover:scale-105 shadow-lg'
                                ">
                                <div class="relative">
                                    <div class="flex items-center gap-3">
                                        <div :class="isDark
                                                ? 'p-3 rounded-xl bg-gradient-to-br from-teal-500/20 to-cyan-500/20 border border-white/20'
                                                : 'p-3 rounded-xl bg-gradient-to-br from-teal-100/80 to-cyan-100/80 border border-teal-200/60'
                                            ">
                                            <font-awesome-icon :icon="['fas', 'award']" :class="isDark ? 'text-2xl text-teal-400' : 'text-2xl text-teal-700'
                                                " />
                                        </div>
                                        <div class="text-left">
                                            <div :class="isDark
                                                    ? 'text-lg font-bold text-white group-hover:text-teal-400 transition-colors'
                                                    : 'text-lg font-bold text-slate-900 group-hover:text-teal-700 transition-colors'
                                                ">
                                                Premium Quality
                                            </div>
                                            <div :class="isDark ? 'text-sm text-slate-300' : 'text-sm text-slate-700'
                                                ">
                                                Expert-Led Courses
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Interactive Learning Card -->
                            <div :class="isDark
                                    ? 'group p-4 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-sm hover:bg-white/15 hover:border-purple-500/40 transition-all duration-300 transform hover:scale-105'
                                    : 'group p-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-purple-200/50 hover:bg-white hover:border-purple-300 transition-all duration-300 transform hover:scale-105 shadow-lg'
                                ">
                                <div class="relative">
                                    <div class="flex items-center gap-3">
                                        <div :class="isDark
                                                ? 'p-3 rounded-xl bg-gradient-to-br from-purple-500/20 to-violet-500/20 border border-white/20'
                                                : 'p-3 rounded-xl bg-gradient-to-br from-purple-100/80 to-violet-100/80 border border-purple-200/60'
                                            ">
                                            <font-awesome-icon :icon="['fas', 'lightbulb']" :class="isDark ? 'text-2xl text-purple-400' : 'text-2xl text-purple-700'
                                                " />
                                        </div>
                                        <div class="text-left">
                                            <div :class="isDark
                                                    ? 'text-lg font-bold text-white group-hover:text-purple-400 transition-colors'
                                                    : 'text-lg font-bold text-slate-900 group-hover:text-purple-700 transition-colors'
                                                ">
                                                Interactive
                                            </div>
                                            <div :class="isDark ? 'text-sm text-slate-300' : 'text-sm text-slate-700'
                                                ">
                                                Hands-on Learning
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modern Platform Card -->
                            <div :class="isDark
                                    ? 'group p-4 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-sm hover:bg-white/15 hover:border-cyan-500/40 transition-all duration-300 transform hover:scale-105'
                                    : 'group p-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-cyan-200/50 hover:bg-white hover:border-cyan-300 transition-all duration-300 transform hover:scale-105 shadow-lg'
                                ">
                                <div class="relative">
                                    <div class="flex items-center gap-3">
                                        <div :class="isDark
                                                ? 'p-3 rounded-xl bg-gradient-to-br from-cyan-500/20 to-teal-500/20 border border-white/20'
                                                : 'p-3 rounded-xl bg-gradient-to-br from-cyan-100/80 to-teal-100/80 border border-cyan-200/60'
                                            ">
                                            <font-awesome-icon :icon="['fas', 'rocket']" :class="isDark ? 'text-2xl text-cyan-400' : 'text-2xl text-cyan-700'
                                                " />
                                        </div>
                                        <div class="text-left">
                                            <div :class="isDark
                                                    ? 'text-lg font-bold text-white group-hover:text-cyan-400 transition-colors'
                                                    : 'text-lg font-bold text-slate-900 group-hover:text-cyan-700 transition-colors'
                                                ">
                                                Modern Platform
                                            </div>
                                            <div :class="isDark ? 'text-sm text-slate-300' : 'text-sm text-slate-700'
                                                ">
                                                Latest Technologies
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                            <router-link to="/courses"
                                class="group relative px-8 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 rounded-2xl font-semibold text-white shadow-2xl shadow-teal-500/25 hover:shadow-teal-500/40 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-offset-4">
                                <span class="relative z-10">Start Learning Now</span>
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </router-link>
                            <router-link to="/categories" :class="isDark
                                    ? 'inline-flex items-center px-8 py-4 bg-white text-cyan-700 font-bold rounded-2xl shadow-2xl shadow-cyan-500/25 border border-cyan-400 hover:bg-cyan-700 hover:text-white hover:shadow-cyan-500/40 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-slate-900'
                                    : 'inline-flex items-center px-8 py-4 bg-slate-800/10 backdrop-blur-sm border border-slate-800/20 text-slate-800 font-bold rounded-2xl hover:bg-slate-800/15 hover:border-slate-800/30 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:ring-offset-2 focus:ring-offset-white'
                                ">
                                <span class="mr-2">Explore All Categories</span>
                                <font-awesome-icon icon="arrow-right"
                                    class="transition-transform duration-300 group-hover:translate-x-1" />
                            </router-link>
                        </div>
                    </div>

                    <!-- Right Side - interactive visual -->
                    <div class="lg:w-1/2 w-full max-w-lg mx-auto lg:mx-0 relative">
                        <div v-if="randomCourse" class="relative">
                            <!-- Main Card -->
                            <div
                                class="glass-card-premium rounded-3xl p-8 shadow-2xl transform transition-all duration-700 hover:scale-105 hover:rotate-1">
                                <!-- Course Image and Badge -->
                                <div class="relative mb-6">
                                    <img v-if="featuredCourses.length > 0" :src="randomCourse.image"
                                        :alt="randomCourse.title"
                                        class="w-full h-48 object-cover rounded-2xl shadow-lg" />
                                    <div v-else
                                        class="w-full h-48 bg-gradient-to-br from-teal-500 to-purple-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                        CTU Educational Platform
                                    </div>

                                    <div class="absolute top-4 right-4 flex gap-2">
                                        <span
                                            class="bg-teal-500 text-white text-xs px-3 py-1 rounded-full animate-bounce">New</span>
                                        <span v-if="featuredCourses.length > 0 && randomCourse.videoCount > 0"
                                            class="bg-orange-500 text-white text-xs px-3 py-1 rounded-full">Videos
                                            Available</span>
                                    </div>
                                </div>

                                <!-- Course Title -->
                                <h3 v-if="randomCourse" :class="isDark
                                        ? 'text-xl font-bold text-white group-hover:text-teal-400 transition-colors duration-300 line-clamp-2'
                                        : 'text-xl font-bold text-slate-900 group-hover:text-teal-700 transition-colors duration-300 line-clamp-2'
                                    ">
                                    {{ randomCourse.title }}
                                </h3>
                                <h3 v-else class="text-xl font-extrabold text-white truncate mb-2">
                                    <span :class="isDark
                                            ? 'text-2xl font-bold text-white'
                                            : 'text-2xl font-bold text-slate-900'
                                        ">
                                        Start Your Journey Today
                                    </span>
                                </h3>

                                <!-- Course Description -->
                                <p v-if="randomCourse" :class="isDark
                                        ? 'text-slate-300 leading-relaxed line-clamp-3'
                                        : 'text-slate-700 leading-relaxed line-clamp-3'
                                    ">
                                    {{ randomCourse.description }}
                                </p>
                                <p v-else class="text-sm text-slate-300 mb-4">
                                    Choose from our premium courses and start learning at your own pace.
                                </p>

                                <!-- Instructor & Info -->
                                <div :class="isDark
                                        ? 'flex justify-between items-center mt-4 text-xs text-slate-400'
                                        : 'flex justify-between items-center mt-4 text-xs text-slate-600'
                                    ">
                                    <span v-if="featuredCourses.length > 0">
                                        Instructor:
                                        {{ randomCourse.instructor }}
                                    </span>
                                    <span v-else>Instructor: Our Experts</span>
                                    <span v-if="featuredCourses.length > 0">{{ randomCourse.videoCount }} Lessons</span>
                                    <span v-else>Explore All</span>
                                </div>

                                <!-- Progress Bar -->
                                <div v-if="false" class="mt-6 space-y-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-300">Course Progress</span>
                                        <span class="text-teal-400 font-semibold">65%</span>
                                    </div>
                                    <div class="w-full bg-slate-700 rounded-full h-2">
                                        <div
                                            class="bg-gradient-to-r from-teal-500 to-purple-500 h-2 rounded-full w-[65%]">
                                        </div>
                                    </div>
                                </div>

                                <!-- Category Tag -->
                                <div class="mt-6 flex justify-start">
                                    <span class="bg-teal-900/50 text-teal-300 text-xs px-3 py-1 rounded-full"
                                        v-if="featuredCourses.length > 0">
                                        {{ randomCourse.category }}
                                    </span>
                                    <span v-else class="bg-teal-900/50 text-teal-300 text-xs px-3 py-1 rounded-full">
                                        Web Development
                                    </span>
                                </div>

                                <!-- CTA Button -->
                                <div class="mt-8">
                                    <router-link to="/courses"
                                        class="block w-full text-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 text-white font-semibold rounded-xl hover:from-teal-500 hover:to-cyan-500 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-teal-500/30 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-offset-4">
                                        Start Learning
                                    </router-link>
                                </div>
                            </div>

                            <!-- Decorative Elements -->
                            <div class="absolute -top-6 -left-6 w-12 h-12 bg-teal-500/20 rounded-full animate-ping">
                            </div>
                            <div
                                class="absolute -bottom-4 -right-8 w-8 h-8 bg-purple-500/30 rounded-full animate-bounce">
                            </div>
                        </div>
                        <div v-else class="text-center py-10">
                            <div :class="isDark
                                    ? 'inline-flex items-center space-x-2 text-slate-400'
                                    : 'inline-flex items-center space-x-2 text-slate-600'
                                ">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-teal-500"></div>
                                <span>Loading course...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="container mx-auto px-6 py-24 relative">
            <!-- section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    <span :class="isDark
                            ? 'bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent'
                            : 'bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent'
                        ">Who We Are</span>
                </h2>
                <p :class="isDark
                        ? 'text-xl text-slate-400 max-w-2xl mx-auto'
                        : 'text-xl text-slate-600 max-w-2xl mx-auto'
                    ">
                    Pioneering the future of online education with innovation and expertise
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- vision Card -->
                <div :class="isDark
                        ? 'glass-card-premium rounded-3xl p-10 shadow-2xl border border-white/10 relative overflow-hidden group hover:scale-105 transition-all duration-500'
                        : 'bg-white/90 backdrop-blur-sm rounded-3xl p-10 shadow-2xl border border-teal-200/30 relative overflow-hidden group hover:scale-105 transition-all duration-500'
                    ">
                    <!-- background Pattern -->
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-transparent"></div>

                    <!-- icon -->
                    <div class="relative z-10 mb-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <font-awesome-icon :icon="['fas', 'lightbulb']" class="text-2xl text-white" />
                        </div>
                    </div>

                    <h3 :class="isDark
                            ? 'text-2xl font-bold mb-4 text-white'
                            : 'text-2xl font-bold mb-4 text-slate-900'
                        ">
                        Our Vision
                    </h3>
                    <p :class="isDark
                            ? 'text-slate-300 leading-relaxed text-lg'
                            : 'text-slate-700 leading-relaxed text-lg'
                        ">
                        At CTU Educational Platform, we believe that education should be accessible to
                        everyone. Our vision is to empower learners worldwide through high-quality,
                        engaging online courses taught by industry experts.
                    </p>

                    <!-- Decorative element -->
                    <div
                        class="absolute bottom-4 -right-8 w-32 h-32 opacity-10 group-hover:opacity-20 transition-opacity">
                        <font-awesome-icon :icon="['fas', 'lightbulb']" class="text-9xl text-teal-500" />
                    </div>
                </div>

                <!-- mission Card -->
                <div :class="isDark
                        ? 'glass-card-premium rounded-3xl p-10 shadow-2xl border border-white/10 relative overflow-hidden group hover:scale-105 transition-all duration-500'
                        : 'bg-white/90 backdrop-blur-sm rounded-3xl p-10 shadow-2xl border border-purple-200/30 relative overflow-hidden group hover:scale-105 transition-all duration-500'
                    ">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent"></div>

                    <!-- icon -->
                    <div class="relative z-10 mb-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <font-awesome-icon :icon="['fas', 'bullseye']" class="text-2xl text-white" />
                        </div>
                    </div>

                    <h3 :class="isDark
                            ? 'text-2xl font-bold mb-4 text-white'
                            : 'text-2xl font-bold mb-4 text-slate-900'
                        ">
                        Our Mission
                    </h3>
                    <p :class="isDark
                            ? 'text-slate-300 leading-relaxed text-lg'
                            : 'text-slate-700 leading-relaxed text-lg'
                        ">
                        We strive to deliver a seamless learning experience by combining modern
                        technology with real-world knowledge. Whether you're starting your career or
                        upgrading your skills, CTU Educational Platform has something for you.
                    </p>

                    <div
                        class="absolute bottom-4 right-1 w-32 h-32 opacity-10 group-hover:opacity-20 transition-opacity">
                        <font-awesome-icon :icon="['fas', 'bullseye']" class="text-9xl text-purple-500" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Courses -->
        <section class="container mx-auto px-6 py-24">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    <span :class="isDark
                            ? 'bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent'
                            : 'bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent'
                        ">Featured Courses</span>
                </h2>
                <p :class="isDark
                        ? 'text-xl text-slate-400 max-w-2xl mx-auto'
                        : 'text-xl text-slate-600 max-w-2xl mx-auto'
                    ">
                    Handpicked courses designed to accelerate your career growth
                </p>
            </div>

            <!-- Loading and Error States -->
            <div v-if="loading" class="text-center">
                <div :class="isDark
                        ? 'inline-flex items-center space-x-2 text-slate-400'
                        : 'inline-flex items-center space-x-2 text-slate-600'
                    ">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-teal-500"></div>
                    <span>Loading courses...</span>
                </div>
            </div>

            <div v-if="error" class="text-center p-8 glass-card-premium rounded-2xl border border-red-500/20">
                <div class="text-red-400 text-lg font-semibold mb-4">
                    {{ error }}
                </div>
                <div class="flex justify-center gap-4">
                    <button @click="refreshData" :class="isDark
                            ? 'px-4 py-2 bg-teal-600 hover:bg-teal-500 text-white rounded-lg transition-colors'
                            : 'px-4 py-2 bg-teal-600 hover:bg-teal-500 text-white rounded-lg transition-colors'
                        ">
                        Refresh Data
                    </button>
                    <button @click="clearError" :class="isDark
                            ? 'px-4 py-2 bg-slate-600 hover:bg-slate-500 text-white rounded-lg transition-colors'
                            : 'px-4 py-2 bg-slate-600 hover:bg-slate-500 text-white rounded-lg transition-colors'
                        ">
                        Dismiss
                    </button>
                </div>
            </div>

            <!--  course Grid -->
            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <router-link v-for="course in featuredCourses" :key="course.id" :to="`/courses/${course.id}`"
                    class="block group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2">
                    <div :class="isDark
                            ? 'glass-card-premium rounded-3xl shadow-2xl overflow-hidden border border-white/10 h-full flex flex-col backdrop-blur-xl hover:shadow-teal-500/20 hover:border-teal-500/30 transition-all duration-500'
                            : 'bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-teal-200/30 h-full flex flex-col hover:shadow-teal-500/20 hover:border-teal-500/50 transition-all duration-500'
                        ">
                        <div class="relative p-6 bg-gradient-to-br from-teal-500/10 to-purple-500/10 object-cover"
                            :style="{
                                backgroundImage: `url(${course.image})`,
                                backgroundSize: 'cover',
                                backgroundPosition: 'center',
                                backgroundRepeat: 'no-repeat',
                            }">
                            <div
                                class="absolute top-4 right-4 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs px-3 py-1 rounded-full font-bold">
                                Popular
                            </div>

                            <div
                                class="w-16 h-16 bg-gradient-to-br from-teal-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <font-awesome-icon :icon="['fas', 'video']" class="text-xl text-white" />
                            </div>
                        </div>

                        <!-- course content -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div class="space-y-4">
                                <h3 :class="isDark
                                        ? 'text-xl font-bold text-white group-hover:text-teal-400 transition-colors duration-300 line-clamp-2'
                                        : 'text-xl font-bold text-slate-900 group-hover:text-teal-700 transition-colors duration-300 line-clamp-2'
                                    ">
                                    {{ course.title }}
                                </h3>

                                <p :class="isDark
                                        ? 'text-slate-300 leading-relaxed line-clamp-3'
                                        : 'text-slate-700 leading-relaxed line-clamp-3'
                                    ">
                                    {{ course.description }}
                                </p>

                                <!-- Course Meta -->
                                <div class="grid grid-cols-1 gap-3 text-sm">
                                    <div :class="isDark
                                            ? 'flex items-center space-x-2 text-slate-400'
                                            : 'flex items-center space-x-2 text-slate-600'
                                        ">
                                        <font-awesome-icon :icon="['fas', 'chalkboard-teacher']"
                                            class="text-teal-400" />
                                        <span>{{ course.instructor }}</span>
                                    </div>
                                    <div :class="isDark
                                            ? 'flex items-center space-x-2 text-slate-400'
                                            : 'flex items-center space-x-2 text-slate-600'
                                        ">
                                        <font-awesome-icon :icon="['fas', 'layer-group']" class="text-purple-400" />
                                        <span>{{ course.category }}</span>
                                    </div>
                                    <div :class="isDark
                                            ? 'flex items-center space-x-2 text-slate-400'
                                            : 'flex items-center space-x-2 text-slate-600'
                                        ">
                                        <font-awesome-icon :icon="['fas', 'video']" class="text-purple-400" />
                                        <span>{{ course.videoCount }} Videos</span>
                                    </div>
                                </div>
                            </div>

                            <!-- action button -->
                            <button
                                class="mt-6 w-full py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 rounded-xl font-semibold text-white transition-all duration-300 transform group-hover:scale-105 shadow-lg">
                                View Course Details
                            </button>
                        </div>
                    </div>
                </router-link>
            </div>
        </section>

        <!-- Popular Categories Section -->
        <section class="container mx-auto px-6 py-24 relative">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div :class="isDark
                        ? 'absolute top-10 left-10 w-32 h-32 bg-cyan-600/10 rounded-full blur-3xl animate-pulse'
                        : 'absolute top-10 left-10 w-32 h-32 bg-cyan-200/30 rounded-full blur-3xl animate-pulse'
                    "></div>
                <div :class="isDark
                        ? 'absolute bottom-10 right-10 w-40 h-40 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000'
                        : 'absolute bottom-10 right-10 w-40 h-40 bg-purple-200/30 rounded-full blur-3xl animate-pulse delay-1000'
                    "></div>
            </div>

            <!-- Section Header -->
            <div class="text-center mb-16 relative z-10">
                <div :class="isDark
                        ? 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500/20 via-teal-500/20 to-purple-500/20 border border-cyan-500/30 rounded-full backdrop-blur-sm mb-6 animate-pulse'
                        : 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-200/40 via-teal-200/40 to-purple-200/40 border border-cyan-300/50 rounded-full backdrop-blur-sm mb-6 animate-pulse'
                    ">
                    <span :class="isDark
                            ? 'text-sm font-bold text-cyan-300'
                            : 'text-sm font-bold text-cyan-700'
                        ">
                        🚀 Explore Your Path
                    </span>
                </div>

                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    <span :class="isDark
                            ? 'bg-gradient-to-r from-cyan-400 via-teal-400 to-purple-400 bg-clip-text text-transparent'
                            : 'bg-gradient-to-r from-cyan-700 via-teal-700 to-purple-700 bg-clip-text text-transparent'
                        ">
                        Popular Categories
                    </span>
                </h2>
                <p :class="isDark
                        ? 'text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed'
                        : 'text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed'
                    ">
                    Discover curated learning paths designed to help you achieve your goals and
                    unlock your potential
                </p>
            </div>

            <!-- Category Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">
                <template v-for="(category, index) in popularCategories" :key="category.id">
                    <router-link :to="'/courses?category=' + category.id" :class="isDark
                            ? 'group relative glass-card-premium rounded-3xl border border-white/10 p-8 transition-all duration-700 hover:bg-white/15 hover:border-cyan-500/40 hover:shadow-2xl hover:shadow-cyan-500/20 hover:scale-105 hover:-translate-y-3 transform'
                            : 'group relative bg-white/90 backdrop-blur-sm rounded-3xl border border-cyan-200/40 p-8 transition-all duration-700 hover:bg-white hover:border-cyan-500/60 hover:shadow-2xl hover:shadow-cyan-500/30 hover:scale-105 hover:-translate-y-3 transform'
                        " :style="{ animationDelay: index * 0.1 + 's' }">
                        <!-- Decorative Background -->
                        <div :class="isDark
                                ? 'absolute inset-0 bg-gradient-to-br from-cyan-500/5 via-teal-500/5 to-purple-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                : 'absolute inset-0 bg-gradient-to-br from-cyan-100/30 via-teal-100/30 to-purple-100/30 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                            "></div>

                        <!-- Category Image Container -->
                        <div class="relative flex items-center justify-center mb-8">
                            <div :class="isDark
                                    ? 'w-28 h-28 rounded-2xl overflow-hidden bg-gradient-to-br from-cyan-500/20 via-teal-500/20 to-purple-500/20 flex items-center justify-center shadow-xl group-hover:shadow-2xl group-hover:scale-110 transition-all duration-500 border border-white/20'
                                    : 'w-28 h-28 rounded-2xl overflow-hidden bg-gradient-to-br from-cyan-100/60 via-teal-100/60 to-purple-100/60 flex items-center justify-center shadow-xl group-hover:shadow-2xl group-hover:scale-110 transition-all duration-500 border border-cyan-200/50'
                                ">
                                <img :src="category.icon" :alt="category.name"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                            </div>

                            <!-- Floating Icon Overlay -->
                            <div :class="isDark
                                    ? 'absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 transform scale-0 group-hover:scale-100'
                                    : 'absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-cyan-600 to-teal-600 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 transform scale-0 group-hover:scale-100'
                                ">
                                <font-awesome-icon icon="arrow-right" class="text-white text-xs" />
                            </div>
                        </div>

                        <!-- Category Name -->
                        <h3 :class="isDark
                                ? 'text-xl font-bold text-white text-center group-hover:text-cyan-400 transition-colors duration-500 mb-4'
                                : 'text-xl font-bold text-slate-900 text-center group-hover:text-cyan-700 transition-colors duration-500 mb-4'
                            ">
                            {{ category.name }}
                        </h3>

                        <!-- Course Count Badge -->
                        <div :class="isDark
                                ? 'flex items-center justify-center px-6 py-2 bg-gradient-to-r from-cyan-500/20 to-teal-500/20 border border-cyan-500/30 rounded-full mx-auto w-fit group-hover:scale-110 transition-transform duration-500'
                                : 'flex items-center justify-center px-6 py-2 bg-gradient-to-r from-cyan-100/80 to-teal-100/80 border border-cyan-300/60 rounded-full mx-auto w-fit group-hover:scale-110 transition-transform duration-500'
                            ">
                            <span :class="isDark
                                    ? 'text-sm font-semibold text-cyan-300'
                                    : 'text-sm font-semibold text-cyan-700'
                                ">
                                {{ category.courses_count }} courses
                            </span>
                        </div>

                        <!-- Animated Border -->
                        <div :class="isDark
                                ? 'absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-500 via-teal-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 rounded-b-3xl'
                                : 'absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-500 via-teal-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-700 rounded-b-3xl'
                            "></div>

                        <!-- Decorative Corner Elements -->
                        <div :class="isDark
                                ? 'absolute top-4 left-4 w-3 h-3 bg-cyan-500/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                : 'absolute top-4 left-4 w-3 h-3 bg-cyan-500/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                            "></div>
                        <div :class="isDark
                                ? 'absolute top-4 right-4 w-2 h-2 bg-teal-500/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100'
                                : 'absolute top-4 right-4 w-2 h-2 bg-teal-500/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100'
                            "></div>
                    </router-link>
                </template>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-12 relative z-10">
                <router-link to="/categories" :class="isDark
                        ? 'inline-flex items-center px-8 py-4 bg-white text-cyan-700 font-bold rounded-2xl shadow-2xl shadow-cyan-500/25 border border-cyan-400 hover:bg-cyan-700 hover:text-white hover:shadow-cyan-500/40 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-slate-900'
                        : 'inline-flex items-center px-8 py-4 bg-gradient-to-r from-cyan-600 to-teal-600 text-white font-bold rounded-2xl shadow-2xl shadow-cyan-500/25 hover:shadow-cyan-500/40 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 focus:ring-offset-white'
                    ">
                    <span class="mr-2">Explore All Categories</span>
                    <font-awesome-icon icon="arrow-right"
                        class="transition-transform duration-300 group-hover:translate-x-1" />
                </router-link>
            </div>
        </section>

        <!-- deals section -->
        <section class="container mx-auto px-4 py-16 relative">
            <!-- Section Header with enhanced animation -->
            <div class="text-center mb-16 animate-fade-in-up">
                <div
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-500/20 to-amber-500/20 border border-yellow-500/30 rounded-full backdrop-blur-sm mb-4 animate-pulse">
                    <span class="text-sm font-medium text-yellow-300">🔥 Limited Time Offers</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    <span :class="isDark
                            ? 'bg-gradient-to-r from-yellow-300 via-amber-200 to-yellow-100 bg-clip-text text-transparent'
                            : 'bg-gradient-to-r from-yellow-700 via-amber-600 to-yellow-600 bg-clip-text text-transparent'
                        ">Exclusive Deals</span>
                </h2>
                <p :class="isDark
                        ? 'text-xl text-slate-400 max-w-2xl mx-auto'
                        : 'text-xl text-slate-600 max-w-2xl mx-auto'
                    ">
                    Don't miss out on these amazing opportunities to enhance your skills
                </p>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="text-center">
                <div :class="isDark
                        ? 'inline-flex items-center space-x-3 text-slate-400'
                        : 'inline-flex items-center space-x-3 text-slate-600'
                    ">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-yellow-500"></div>
                    <span class="text-lg">Loading amazing offers...</span>
                </div>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="text-center p-8 glass-card-premium rounded-2xl border border-red-500/20">
                <div class="text-red-400 text-lg font-semibold">
                    {{ error }}
                </div>
            </div>

            <!-- Offers Grid -->
            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <router-link v-for="offer in limitedTimeOffers" :key="offer.id" :to="`/courses/${offer.id}`"
                    class="group block transform transition-all duration-500 hover:-translate-y-2">
                    <div
                        class="glass-card-premium rounded-xl overflow-hidden shadow-xl border border-white/10 backdrop-blur-xl group-hover:shadow-yellow-500/20 group-hover:border-yellow-500/40 transition-all duration-500 relative">
                        <!-- Gradient Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 via-transparent to-amber-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <!-- Content -->
                        <div class="flex flex-col md:flex-row p-4 md:p-6 gap-4">
                            <!-- Image Section -->
                            <div class="relative w-full md:w-32 h-40 md:h-32 flex-shrink-0 rounded-xl overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-yellow-500/30 to-amber-500/30 blur-xl group-hover:opacity-75 transition-opacity duration-500">
                                </div>
                                <img :src="offer.image || defaultLogo" alt="Course Image"
                                    class="relative w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                                <!-- Discount Badge -->
                                <div
                                    class="absolute top-2 right-2 bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-2.5 py-0.5 rounded-full font-bold text-xs shadow-md transform group-hover:scale-110 transition-transform duration-300">
                                    {{ offer.discount }}% OFF
                                </div>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-1 flex flex-col justify-between">
                                <!-- Title -->
                                <h3
                                    class="font-bold text-lg text-white mb-2 line-clamp-2 group-hover:text-yellow-300 transition-colors duration-300">
                                    {{ offer.title }}
                                </h3>

                                <!-- Instructor & Category -->
                                <div :class="isDark
                                        ? 'flex flex-col sm:flex-row sm:items-center gap-2 mb-3 text-sm text-slate-400'
                                        : 'flex flex-col sm:flex-row sm:items-center gap-2 mb-3 text-sm text-slate-600'
                                    " class="flex flex-col sm:flex-row sm:items-center gap-2 mb-3 text-sm text-slate-400">
                                    <div class="flex items-center gap-1.5 bg-white/5 px-2.5 py-1 rounded-full">
                                        <font-awesome-icon :icon="['fas', 'chalkboard-teacher']"
                                            class="text-yellow-400" />
                                        <span>{{ offer.instructor }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 bg-white/5 px-2.5 py-1 rounded-full">
                                        <font-awesome-icon :icon="['fas', 'layer-group']" class="text-amber-400" />
                                        <span>{{ offer.category }}</span>
                                    </div>
                                </div>

                                <!-- Pricing -->
                                <div class="flex items-end gap-4 mb-3">
                                    <div class="space-y-1">
                                        <div class="text-xs text-slate-400">Regular Price</div>
                                        <div class="text-sm text-slate-300 line-through opacity-75">
                                            ${{ offer.originalPrice }}
                                        </div>
                                    </div>
                                    <div v-if="offer.discountedPrice" class="space-y-1">
                                        <div class="text-xs text-yellow-400 font-medium">Special Offer</div>
                                        <div
                                            class="text-xl font-bold text-yellow-300 group-hover:scale-110 transition-transform duration-300">
                                            ${{ offer.discountedPrice }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Timer + Enrollments + Button -->
                                <div
                                    class="mt-4 flex flex-wrap items-center justify-between pt-3 border-t border-white/5">
                                    <!-- Time Left -->
                                    <div :class="isDark
                                            ? 'flex items-center gap-1.5 text-sm text-slate-400 mb-2 sm:mb-0'
                                            : 'flex items-center gap-1.5 text-sm text-slate-600 mb-2 sm:mb-0'
                                        ">
                                        <font-awesome-icon :icon="['fas', 'clock']"
                                            class="text-amber-400 animate-pulse" />
                                        <span>Ends in {{ offer.timeLeft }}</span>
                                    </div>

                                    <!-- Enrollments -->
                                    <div :class="isDark
                                            ? 'flex items-center gap-1.5 text-sm text-slate-400 mb-2 sm:mb-0'
                                            : 'flex items-center gap-1.5 text-sm text-slate-600 mb-2 sm:mb-0'
                                        ">
                                        <font-awesome-icon :icon="['fas', 'users']" class="text-yellow-400" />
                                        <span>{{ offer.enrollments }} enrolled</span>
                                    </div>

                                    <!-- Enroll Now Button -->
                                    <button
                                        class="px-4 py-2 bg-gradient-to-r from-yellow-500 to-amber-500 rounded-lg text-white text-sm font-semibold shadow-md transform transition-all duration-300 group-hover:scale-105 group-hover:shadow-yellow-500/25 whitespace-nowrap">
                                        Enroll Now →
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </router-link>
            </div>
        </section>

        <!-- Instructors Section -->
        <section class="container mx-auto px-6 py-24 relative">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div :class="isDark
                        ? 'absolute top-20 left-20 w-40 h-40 bg-teal-600/10 rounded-full blur-3xl animate-pulse'
                        : 'absolute top-20 left-20 w-40 h-40 bg-teal-200/30 rounded-full blur-3xl animate-pulse'
                    "></div>
                <div :class="isDark
                        ? 'absolute bottom-20 right-20 w-32 h-32 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000'
                        : 'absolute bottom-20 right-20 w-32 h-32 bg-purple-200/30 rounded-full blur-3xl animate-pulse delay-1000'
                    "></div>
            </div>


            <!-- News Section -->
            <NewsSection />

            <!-- Section Header -->
            <div class="text-center mb-16 relative z-10">
                <div :class="isDark
                        ? 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500/20 via-purple-500/20 to-cyan-500/20 border border-teal-500/30 rounded-full backdrop-blur-sm mb-6 animate-pulse'
                        : 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-200/40 via-purple-200/40 to-cyan-200/40 border border-teal-300/50 rounded-full backdrop-blur-sm mb-6 animate-pulse'
                    ">
                    <span :class="isDark
                            ? 'text-sm font-bold text-teal-300'
                            : 'text-sm font-bold text-teal-700'
                        ">
                        👨‍🏫 Expert Team
                    </span>
                </div>

                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    <span :class="isDark
                            ? 'bg-gradient-to-r from-teal-400 via-purple-400 to-cyan-400 bg-clip-text text-transparent'
                            : 'bg-gradient-to-r from-teal-700 via-purple-700 to-cyan-700 bg-clip-text text-transparent'
                        ">
                        Meet Our Expert Instructors
                    </span>
                </h2>
                <p :class="isDark
                        ? 'text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed'
                        : 'text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed'
                    ">
                    Learn from industry leaders and experienced professionals who are passionate
                    about sharing their knowledge
                </p>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="text-center relative z-10">
                <div :class="isDark
                        ? 'inline-flex items-center space-x-3 text-slate-400'
                        : 'inline-flex items-center space-x-3 text-slate-600'
                    ">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-teal-500"></div>
                    <span class="text-lg">Loading our amazing instructors...</span>
                </div>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="text-center relative z-10">
                <div :class="isDark
                        ? 'p-8 glass-card-premium rounded-2xl border border-red-500/20'
                        : 'p-8 bg-white/90 backdrop-blur-sm rounded-2xl border border-red-500/20 shadow-xl'
                    ">
                    <div class="text-red-400 text-lg font-semibold">
                        {{ error }}
                    </div>
                </div>
            </div>

            <!-- Instructors Grid -->
            <template v-else>
                <template v-if="topInstructors">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
                        <!-- Instructor Cards -->
                        <template v-for="(instructor, index) in topInstructors" :key="instructor.id">
                            <router-link :to="`/instructors/${instructor.id}`" :class="isDark
                                    ? 'group relative glass-card-premium rounded-3xl p-8 text-center hover:scale-105 transition-all duration-700 shadow-2xl border border-white/10 hover:border-teal-500/40 hover:shadow-teal-500/20 transform'
                                    : 'group relative bg-white/90 backdrop-blur-sm rounded-3xl p-8 text-center hover:scale-105 transition-all duration-700 shadow-2xl border border-teal-200/30 hover:border-teal-500/60 hover:shadow-teal-500/30 transform'
                                " :style="{ animationDelay: index * 0.2 + 's' }">
                                <!-- Decorative Background -->
                                <div :class="isDark
                                        ? 'absolute inset-0 bg-gradient-to-br from-teal-500/5 via-purple-500/5 to-cyan-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                        : 'absolute inset-0 bg-gradient-to-br from-teal-100/30 via-purple-100/30 to-cyan-100/30 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                    "></div>

                                <!-- Profile Image Container -->
                                <div class="relative mb-8">
                                    <div :class="isDark
                                            ? 'w-28 h-28 mx-auto rounded-full bg-gradient-to-br from-teal-500 via-purple-500 to-cyan-500 p-1 group-hover:scale-110 transition-transform duration-500 shadow-xl'
                                            : 'w-28 h-28 mx-auto rounded-full bg-gradient-to-br from-teal-500 via-purple-500 to-cyan-500 p-1 group-hover:scale-110 transition-transform duration-500 shadow-xl'
                                        ">
                                        <img :src="instructor.image" :alt="instructor.name"
                                            @error="$event.target.src = defaultImage"
                                            class="w-full h-full rounded-full object-cover border-4 border-slate-800 group-hover:border-teal-500/50 transition-colors duration-500" />
                                    </div>

                                    <!-- Status Indicator -->
                                    <div :class="isDark
                                            ? 'absolute bottom-2 right-1/3 w-6 h-6 bg-teal-500 rounded-full border-4 border-slate-900 animate-pulse shadow-lg'
                                            : 'absolute bottom-2 right-1/3 w-6 h-6 bg-teal-500 rounded-full border-4 border-white animate-pulse shadow-lg'
                                        "></div>

                                    <!-- Floating Badge -->
                                    <div :class="isDark
                                            ? 'absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-purple-500 to-cyan-500 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 transform scale-0 group-hover:scale-100 shadow-lg'
                                            : 'absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-purple-600 to-cyan-600 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 transform scale-0 group-hover:scale-100 shadow-lg'
                                        ">
                                        <font-awesome-icon icon="star" class="text-white text-xs" />
                                    </div>
                                </div>

                                <!-- Instructor Info -->
                                <div class="relative z-10">
                                    <h3 :class="isDark
                                            ? 'font-bold text-xl text-white mb-3 group-hover:text-teal-400 transition-colors duration-500'
                                            : 'font-bold text-xl text-slate-900 mb-3 group-hover:text-teal-700 transition-colors duration-500'
                                        ">
                                        {{ instructor.name }}
                                    </h3>

                                    <p :class="isDark
                                            ? 'text-teal-400 font-semibold mb-3 text-lg'
                                            : 'text-teal-700 font-semibold mb-3 text-lg'
                                        ">
                                        {{ instructor.specialization }}
                                    </p>

                                    <p :class="isDark
                                            ? 'text-slate-400 text-sm mb-6'
                                            : 'text-slate-600 text-sm mb-6'
                                        ">
                                        {{ instructor.experience }} of experience
                                    </p>

                                    <!-- Skills Grid -->
                                    <div :class="isDark
                                            ? 'grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-slate-700/50'
                                            : 'grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-slate-300/50'
                                        ">
                                        <template v-for="skill in instructor.skills" :key="skill">
                                            <div :class="isDark
                                                    ? 'text-center p-2 bg-white/5 rounded-lg hover:bg-white/10 transition-colors duration-300'
                                                    : 'text-center p-2 bg-slate-100/60 rounded-lg hover:bg-slate-200/80 transition-colors duration-300'
                                                ">
                                                <div :class="isDark
                                                        ? 'text-xs text-slate-300 font-medium'
                                                        : 'text-xs text-slate-700 font-medium'
                                                    ">
                                                    {{ skill }}
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- View Profile Button -->
                                    <div class="mt-6">
                                        <div :class="isDark
                                                ? 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-500/20 to-purple-500/20 border border-teal-500/30 rounded-full text-sm font-semibold text-teal-300 group-hover:scale-105 transition-transform duration-300'
                                                : 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-teal-100/80 to-purple-100/80 border border-teal-300/60 rounded-full text-sm font-semibold text-teal-700 group-hover:scale-105 transition-transform duration-300'
                                            ">
                                            <span class="mr-2">View Profile</span>
                                            <font-awesome-icon icon="arrow-right"
                                                class="text-xs transition-transform duration-300 group-hover:translate-x-1" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Decorative Corner Elements -->
                                <div :class="isDark
                                        ? 'absolute top-4 left-4 w-3 h-3 bg-teal-500/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                        : 'absolute top-4 left-4 w-3 h-3 bg-teal-500/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                    "></div>
                                <div :class="isDark
                                        ? 'absolute top-4 right-4 w-2 h-2 bg-purple-500/30 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100'
                                        : 'absolute top-4 right-4 w-2 h-2 bg-purple-500/50 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100'
                                    "></div>
                            </router-link>
                        </template>
                    </div>

                    <!-- Call to Action -->
                    <div class="text-center mt-12 relative z-10">
                        <router-link to="/instructors" :class="isDark
                                ? 'inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-600 to-purple-600 text-white font-bold rounded-2xl shadow-2xl shadow-teal-500/25 hover:shadow-teal-500/40 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-slate-900'
                                : 'inline-flex items-center px-8 py-4 bg-gradient-to-r from-teal-600 to-purple-600 text-white font-bold rounded-2xl shadow-2xl shadow-teal-500/25 hover:shadow-teal-500/40 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-white'
                            ">
                            <span class="mr-2">Meet All Instructors</span>
                            <font-awesome-icon icon="arrow-right"
                                class="transition-transform duration-300 group-hover:translate-x-1" />
                        </router-link>
                    </div>
                </template>
                <template v-else>
                    <div :class="isDark
                            ? 'text-center text-slate-400 py-12'
                            : 'text-center text-slate-600 py-12'
                        ">
                        <div class="inline-flex items-center space-x-2">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-teal-500"></div>
                            <span>Loading instructors...</span>
                        </div>
                    </div>
                </template>
            </template>
        </section>

        <!-- Enhanced Call to Action Section -->
        <section class="container mx-auto px-6 py-24 relative">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div :class="isDark
                        ? 'absolute top-10 left-10 w-48 h-48 bg-gradient-to-br from-teal-600/15 via-cyan-600/15 to-purple-600/15 rounded-full blur-3xl animate-pulse'
                        : 'absolute top-10 left-10 w-48 h-48 bg-gradient-to-br from-teal-200/40 via-cyan-200/40 to-purple-200/40 rounded-full blur-3xl animate-pulse'
                    "></div>
                <div :class="isDark
                        ? 'absolute bottom-10 right-10 w-40 h-40 bg-gradient-to-br from-purple-600/15 via-cyan-600/15 to-teal-600/15 rounded-full blur-3xl animate-pulse delay-1000'
                        : 'absolute bottom-10 right-10 w-40 h-40 bg-gradient-to-br from-purple-200/40 via-cyan-200/40 to-teal-200/40 rounded-full blur-3xl animate-pulse delay-1000'
                    "></div>
                <div :class="isDark
                        ? 'absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-cyan-600/10 rounded-full blur-2xl animate-ping'
                        : 'absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-cyan-200/30 rounded-full blur-2xl animate-ping'
                    "></div>
            </div>

            <!-- Main Content Container -->
            <div class="relative z-10">
                <!-- Decorative Background -->
                <div :class="isDark
                        ? 'absolute inset-0 bg-gradient-to-r from-teal-600/20 via-cyan-600/20 via-purple-600/20 to-purple-600/20 rounded-3xl blur-xl'
                        : 'absolute inset-0 bg-gradient-to-r from-teal-200/30 via-cyan-200/30 via-purple-200/30 to-purple-200/30 rounded-3xl blur-xl'
                    "></div>
                <div :class="isDark
                        ? 'absolute inset-0 backdrop-blur-3xl rounded-3xl'
                        : 'absolute inset-0 backdrop-blur-2xl rounded-3xl'
                    "></div>

                <!-- Main Content Card -->
                <div :class="isDark
                        ? 'glass-card-premium rounded-3xl p-16 shadow-2xl text-center relative border border-white/20 hover:border-teal-500/40 transition-all duration-500'
                        : 'bg-white/95 backdrop-blur-sm rounded-3xl p-16 shadow-2xl text-center relative border border-teal-200/40 hover:border-teal-500/60 transition-all duration-500'
                    ">
                    <!-- Floating Animated Elements -->
                    <div :class="isDark
                            ? 'absolute top-8 left-8 w-16 h-16 bg-teal-500/20 rounded-full animate-pulse'
                            : 'absolute top-8 left-8 w-16 h-16 bg-teal-500/30 rounded-full animate-pulse'
                        "></div>
                    <div :class="isDark
                            ? 'absolute bottom-8 right-8 w-12 h-12 bg-purple-500/20 rounded-full animate-ping'
                            : 'absolute bottom-8 right-8 w-12 h-12 bg-purple-500/30 rounded-full animate-ping'
                        "></div>
                    <div :class="isDark
                            ? 'absolute top-1/2 right-8 w-8 h-8 bg-cyan-500/20 rounded-full animate-bounce'
                            : 'absolute top-1/2 right-8 w-8 h-8 bg-cyan-500/30 rounded-full animate-bounce'
                        "></div>

                    <!-- Content -->
                    <div class="relative z-10 max-w-4xl mx-auto">
                        <!-- Enhanced Badge -->
                        <div :class="isDark
                                ? 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-500/20 via-cyan-500/20 to-purple-500/20 border border-teal-500/30 rounded-full backdrop-blur-sm mb-8 animate-pulse'
                                : 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-200/40 via-cyan-200/40 to-purple-200/40 border border-teal-300/50 rounded-full backdrop-blur-sm mb-8 animate-pulse'
                            ">
                            <span :class="isDark
                                    ? 'text-sm font-bold text-teal-300'
                                    : 'text-sm font-bold text-teal-700'
                                ">
                                🚀 Start Your Journey Today
                            </span>
                        </div>

                        <!-- Enhanced Main Heading -->
                        <h2 class="text-4xl md:text-6xl lg:text-7xl font-black mb-8">
                            <span :class="isDark
                                    ? 'bg-gradient-to-r from-white via-teal-100 via-cyan-100 to-purple-100 bg-clip-text text-transparent'
                                    : 'bg-gradient-to-r from-slate-900 via-teal-800 via-cyan-800 to-purple-800 bg-clip-text text-transparent'
                                ">
                                Transform Your Future
                            </span>
                            <br />
                            <span :class="isDark
                                    ? 'bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-400 bg-clip-text text-transparent'
                                    : 'bg-gradient-to-r from-teal-600 via-cyan-600 to-purple-600 bg-clip-text text-transparent'
                                ">
                                With Us
                            </span>
                        </h2>

                        <!-- Enhanced Description -->
                        <p :class="isDark
                                ? 'text-xl md:text-2xl text-slate-300 mb-10 max-w-3xl mx-auto leading-relaxed'
                                : 'text-xl md:text-2xl text-slate-700 mb-10 max-w-3xl mx-auto leading-relaxed'
                            ">
                            Join our growing community of learners and unlock your potential with
                            <span :class="isDark ? 'text-teal-400 font-bold' : 'text-teal-700 font-bold'">
                                cutting-edge courses
                            </span>
                            designed for the modern world. Your success story starts here.
                        </p>

                        <!-- Enhanced Action Buttons -->
                        <div class="flex flex-wrap justify-center gap-6 mt-10 mb-16">
                            <router-link to="/courses" :class="isDark
                                    ? 'group relative px-12 py-5 bg-gradient-to-r from-teal-600 via-cyan-600 to-purple-600 rounded-2xl font-bold text-lg text-white shadow-2xl shadow-teal-500/25 hover:shadow-teal-500/40 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-offset-4'
                                    : 'group relative px-12 py-5 bg-gradient-to-r from-teal-600 via-cyan-600 to-purple-600 rounded-2xl font-bold text-lg text-white shadow-2xl shadow-teal-500/25 hover:shadow-teal-500/40 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-white focus:ring-offset-4'
                                ">
                                <span class="relative z-10 flex items-center space-x-3">
                                    <span>Begin Your Journey</span>
                                    <font-awesome-icon icon="arrow-right"
                                        class="transition-transform duration-300 transform group-hover:translate-x-1" />
                                </span>
                                <div :class="isDark
                                        ? 'absolute inset-0 bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300'
                                        : 'absolute inset-0 bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300'
                                    "></div>
                            </router-link>

                            <router-link to="/about" :class="isDark
                                    ? 'px-12 py-5 bg-white/5 backdrop-blur-sm border border-white/20 rounded-2xl font-bold text-lg text-white hover:bg-white/10 hover:border-white/30 transition-all duration-300 transform hover:scale-105 flex items-center space-x-3 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-offset-4'
                                    : 'px-12 py-5 bg-slate-800/10 backdrop-blur-sm border border-slate-800/20 rounded-2xl font-bold text-lg text-slate-800 hover:bg-slate-800/15 hover:border-slate-800/30 transition-all duration-300 transform hover:scale-105 flex items-center space-x-3 focus:outline-none focus:ring-2 focus:ring-slate-800 focus:ring-offset-2 focus:ring-offset-white focus:ring-offset-4'
                                ">
                                <span>Browse Success Stories</span>
                                <font-awesome-icon icon="book-open" />
                            </router-link>
                        </div>

                        <!-- Enhanced Key Features -->
                        <div :class="isDark
                                ? 'grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 pt-12 border-t border-white/10'
                                : 'grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 pt-12 border-t border-slate-300/30'
                            ">
                            <!-- Feature 1 -->
                            <div class="flex flex-col items-center group">
                                <div :class="isDark
                                        ? 'w-16 h-16 bg-gradient-to-br from-teal-500/20 to-teal-600/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 border border-teal-500/30'
                                        : 'w-16 h-16 bg-gradient-to-br from-teal-100/60 to-teal-200/60 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 border border-teal-300/50'
                                    ">
                                    <font-awesome-icon icon="certificate"
                                        :class="isDark ? 'text-3xl text-teal-400' : 'text-3xl text-teal-600'" />
                                </div>
                                <h3 :class="isDark
                                        ? 'text-xl font-bold text-white mb-2 group-hover:text-teal-400 transition-colors duration-300'
                                        : 'text-xl font-bold text-slate-900 mb-2 group-hover:text-teal-700 transition-colors duration-300'
                                    ">
                                    Expert Certificates
                                </h3>
                                <p :class="isDark
                                        ? 'text-slate-400 text-center leading-relaxed'
                                        : 'text-slate-600 text-center leading-relaxed'
                                    ">
                                    Industry-recognized achievements that boost your career
                                </p>
                            </div>

                            <!-- Feature 2 -->
                            <div class="flex flex-col items-center group">
                                <div :class="isDark
                                        ? 'w-16 h-16 bg-gradient-to-br from-cyan-500/20 to-cyan-600/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 border border-cyan-500/30'
                                        : 'w-16 h-16 bg-gradient-to-br from-cyan-100/60 to-cyan-200/60 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 border border-cyan-300/50'
                                    ">
                                    <font-awesome-icon icon="clock"
                                        :class="isDark ? 'text-3xl text-cyan-400' : 'text-3xl text-cyan-600'" />
                                </div>
                                <h3 :class="isDark
                                        ? 'text-xl font-bold text-white mb-2 group-hover:text-cyan-400 transition-colors duration-300'
                                        : 'text-xl font-bold text-slate-900 mb-2 group-hover:text-cyan-700 transition-colors duration-300'
                                    ">
                                    Flexible Learning
                                </h3>
                                <p :class="isDark
                                        ? 'text-slate-400 text-center leading-relaxed'
                                        : 'text-slate-600 text-center leading-relaxed'
                                    ">
                                    Learn at your own pace, anytime, anywhere
                                </p>
                            </div>

                            <!-- Feature 3 -->
                            <div class="flex flex-col items-center group">
                                <div :class="isDark
                                        ? 'w-16 h-16 bg-gradient-to-br from-purple-500/20 to-purple-600/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 border border-purple-500/30'
                                        : 'w-16 h-16 bg-gradient-to-br from-purple-100/60 to-purple-200/60 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300 border border-purple-300/50'
                                    ">
                                    <font-awesome-icon icon="users" :class="isDark ? 'text-3xl text-purple-400' : 'text-3xl text-purple-600'
                                        " />
                                </div>
                                <h3 :class="isDark
                                        ? 'text-xl font-bold text-white mb-2 group-hover:text-purple-400 transition-colors duration-300'
                                        : 'text-xl font-bold text-slate-900 mb-2 group-hover:text-purple-700 transition-colors duration-300'
                                    ">
                                    Community Support
                                </h3>
                                <p :class="isDark
                                        ? 'text-slate-400 text-center leading-relaxed'
                                        : 'text-slate-600 text-center leading-relaxed'
                                    ">
                                    Connect with peers and mentors worldwide
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
</template>

<script setup>
import { ref, onMounted, computed, onUnmounted } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import defaultImage from "@/assets/icons/EduStream.jpg";
import {
    faLightbulb,
    faBullseye,
    faChalkboardTeacher,
    faLayerGroup,
    faVideo,
    faFolder,
    faAward,
    faRocket,
    faArrowRight,
    faBookOpen,
    faCertificate,
    faClock,
    faUsers,
} from "@fortawesome/free-solid-svg-icons";
import { useHomeStore } from "@/stores/homeStore";
import { useTheme } from "../composables/useTheme";
import NewsSection from "../components/NewsSection.vue";

library.add(
    faLightbulb,
    faBullseye,
    faChalkboardTeacher,
    faLayerGroup,
    faVideo,
    faFolder
);

const homeStore = useHomeStore();
const defaultLogo = "@/assets/icons/logo.png";

// Random course selection
const randomCourse = ref(null);

// Computed properties from store
const featuredCourses = computed(() => homeStore.featuredCourses);
const popularCategories = computed(() => homeStore.popularCategories);
const limitedTimeOffers = computed(() => homeStore.limitedTimeOffers);
const topInstructors = computed(() => homeStore.topInstructors);
const latestNews = computed(() => homeStore.latestNews);
const loading = computed(() => homeStore.isLoading);
const error = computed(() => homeStore.getError);

// Additional computed properties for enhanced functionality
const totalCourses = computed(() => homeStore.totalFeaturedCourses);
const totalCategories = computed(() => homeStore.totalCategories);
const totalInstructors = computed(() => homeStore.totalInstructors);
const totalOffers = computed(() => homeStore.totalOffers);
const totalNews = computed(() => homeStore.totalNews);

// Get top rated courses
const topRatedCourses = computed(() => homeStore.getTopRatedCourses(3));

// Get most enrolled courses
const mostEnrolledCourses = computed(() => homeStore.getMostEnrolledCourses(3));

// Function to get a random course
const getRandomCourse = () => {
    return homeStore.getRandomCourse();
};

// Initialize data
const initializeData = async () => {
    try {
        await homeStore.fetchHomeData();
        randomCourse.value = getRandomCourse();
    } catch (err) {
        console.error("Error initializing home data:", err);
    }
};

// Refresh data function
const refreshData = async () => {
    try {
        await homeStore.refreshData();
        randomCourse.value = getRandomCourse();
    } catch (err) {
        console.error("Error refreshing home data:", err);
    }
};

// Clear error function
const clearError = () => {
    homeStore.clearError();
};

// Auto-refresh random course every 10 seconds
let randomCourseInterval;

onMounted(async () => {
    await initializeData();

    // Set up interval for random course rotation
    randomCourseInterval = setInterval(() => {
        randomCourse.value = getRandomCourse();
    }, 10000);
});

// Cleanup interval on unmount
onUnmounted(() => {
    if (randomCourseInterval) {
        clearInterval(randomCourseInterval);
    }
});

const { isDark } = useTheme();
</script>

<style scoped>
.glass-card-premium {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.15);
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.group:hover .group-hover\:rotate-12 {
    transform: rotate(12deg);
}

.group:hover .group-hover\:translate-x-1 {
    transform: translateX(0.25rem);
}

::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #0d9488, #0891b2);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #0f766e, #0e7490);
}

@media (max-width: 768px) {
    .glass-card-premium {
        backdrop-filter: blur(15px);
    }

    .text-5xl {
        font-size: 2.5rem;
    }

    .text-7xl {
        font-size: 3.5rem;
    }
}

button:focus,
a:focus {
    outline: 2px solid #0d9488;
    outline-offset: 2px;
    box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1);
}

button:focus-visible,
a:focus-visible,
router-link:focus-visible {
    outline: 2px solid #0d9488;
    outline-offset: 4px;
    box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.2);
}

.dark button:focus-visible,
.dark a:focus-visible,
.dark router-link:focus-visible {
    outline: 2px solid #5eead4;
    outline-offset: 4px;
    box-shadow: 0 0 0 4px rgba(94, 234, 212, 0.3);
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

.shadow-glow {
    box-shadow: 0 0 20px rgba(13, 148, 136, 0.3);
}

.text-shadow {
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.glass-card-premium:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.2);
}
</style>
