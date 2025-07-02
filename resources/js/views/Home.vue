<template>
    <div
        class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-gray-900"
    >
        <section class="relative overflow-hidden">
            <!-- Animated Background  -->
            <div class="absolute inset-0">
                <div
                    class="absolute top-20 left-10 w-72 h-72 bg-blue-600/10 rounded-full blur-3xl animate-pulse"
                ></div>
                <div
                    class="absolute top-40 right-20 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000"
                ></div>
                <div
                    class="absolute bottom-20 left-1/3 w-60 h-60 bg-indigo-600/10 rounded-full blur-3xl animate-pulse delay-2000"
                ></div>
            </div>

            <!-- Floating Particles -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-400 rounded-full animate-float"
                ></div>
                <div
                    class="absolute top-1/3 left-3/4 w-1.5 h-1.5 bg-purple-400 rounded-full animate-float-delayed"
                ></div>
                <div
                    class="absolute top-2/3 left-1/6 w-2.5 h-2.5 bg-indigo-400 rounded-full animate-float-slow"
                ></div>
            </div>

            <div class="container mx-auto px-6 py-20 md:py-32 relative z-10">
                <!-- Main Hero Content -->
                <div
                    class="flex flex-col lg:flex-row items-center justify-between gap-16"
                >
                    <!-- Enhanced Left Side - Text Content -->
                    <div
                        class="lg:w-1/2 text-center lg:text-left space-y-8 animate-fade-in-up"
                    >
                        <!-- Badge -->
                        <div
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500/20 to-purple-500/20 border border-blue-500/30 rounded-full backdrop-blur-sm"
                        >
                            <span class="text-sm font-medium text-blue-300"
                                >🚀 New Platform Launch</span
                            >
                        </div>

                        <!-- Main Heading -->
                        <h1
                            class="text-5xl md:text-7xl font-black leading-tight"
                        >
                            <span
                                class="block bg-gradient-to-r from-white via-blue-100 to-purple-100 bg-clip-text text-transparent"
                            >
                            EduStream
                            </span>
                            <span
                                class="block bg-gradient-to-r from-blue-400 via-purple-400 to-indigo-400 bg-clip-text text-transparent"
                            >
                                Shape Future
                            </span>
                        </h1>

                        <!-- Description -->
                        <p
                            class="text-xl md:text-2xl text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed"
                        >
                            Transform your career with cutting-edge courses from
                            industry experts.
                            <span class="text-blue-300 font-semibold"
                                >Learn, Build, Succeed</span
                            >
                            — all at your own pace.
                        </p>

                        <!-- Stats Row -->
                        <div
                            class="flex flex-wrap justify-center lg:justify-start gap-8 py-6"
                        >
                            <!-- Quality Education Card -->
                            <div
                                class="group p-4 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-sm hover:bg-white/10 hover:border-blue-500/30 transition-all duration-300 transform hover:scale-105"
                            >
                                <div class="relative">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="p-3 rounded-xl bg-gradient-to-br from-blue-500/20 to-purple-500/20 border border-white/10"
                                        >
                                            <font-awesome-icon
                                                :icon="['fas', 'award']"
                                                class="text-2xl text-blue-400"
                                            />
                                        </div>
                                        <div class="text-left">
                                            <div
                                                class="text-lg font-bold text-white group-hover:text-blue-400 transition-colors"
                                            >
                                                Premium Quality
                                            </div>
                                            <div class="text-sm text-slate-400">
                                                Expert-Led Courses
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Interactive Learning Card -->
                            <div
                                class="group p-4 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-sm hover:bg-white/10 hover:border-purple-500/30 transition-all duration-300 transform hover:scale-105"
                            >
                                <div class="relative">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="p-3 rounded-xl bg-gradient-to-br from-purple-500/20 to-pink-500/20 border border-white/10"
                                        >
                                            <font-awesome-icon
                                                :icon="['fas', 'lightbulb']"
                                                class="text-2xl text-purple-400"
                                            />
                                        </div>
                                        <div class="text-left">
                                            <div
                                                class="text-lg font-bold text-white group-hover:text-purple-400 transition-colors"
                                            >
                                                Interactive
                                            </div>
                                            <div class="text-sm text-slate-400">
                                                Hands-on Learning
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modern Platform Card -->
                            <div
                                class="group p-4 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-sm hover:bg-white/10 hover:border-emerald-500/30 transition-all duration-300 transform hover:scale-105"
                            >
                                <div class="relative">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="p-3 rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 border border-white/10"
                                        >
                                            <font-awesome-icon
                                                :icon="['fas', 'rocket']"
                                                class="text-2xl text-emerald-400"
                                            />
                                        </div>
                                        <div class="text-left">
                                            <div
                                                class="text-lg font-bold text-white group-hover:text-emerald-400 transition-colors"
                                            >
                                                Modern Platform
                                            </div>
                                            <div class="text-sm text-slate-400">
                                                Latest Technologies
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div
                            class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4"
                        >
                            <router-link
                                to="/courses"
                                class="group relative px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl font-semibold text-white shadow-2xl shadow-blue-500/25 hover:shadow-blue-500/40 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1"
                            >
                                <span class="relative z-10"
                                    >Start Learning Now</span
                                >
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                ></div>
                            </router-link>
                            <router-link
                                to="/categories"
                                class="px-8 py-4 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl font-semibold text-white hover:bg-white/10 hover:border-white/20 transition-all duration-300 transform hover:scale-105"
                            >
                                Explore Categories
                            </router-link>
                        </div>
                    </div>

                    <!-- Right Side - interactive visual -->
                    <div
                        class="lg:w-1/2 w-full max-w-lg mx-auto lg:mx-0 relative"
                    >
                        <div  v-if="randomCourse" class="relative">
                           <!-- Main Card -->
                            <div class="glass-card-premium rounded-3xl p-8 shadow-2xl transform transition-all duration-700 hover:scale-105 hover:rotate-1">
                                <!-- Course Image and Badge -->
                                <div class="relative mb-6">
                                    <img
                                        v-if="featuredCourses.length > 0"
                                        :src="randomCourse.image"
                                        :alt="randomCourse.title"
                                        class="w-full h-48 object-cover rounded-2xl shadow-lg"
                                    />
                                    <div
                                        v-else
                                        class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg"
                                    >
                                        EduStream
                                    </div>

                                    <div class="absolute top-4 right-4 flex gap-2">
                                        <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full animate-bounce">New</span>
                                        <span v-if="featuredCourses.length > 0 && randomCourse.videoCount > 0" class="bg-orange-500 text-white text-xs px-3 py-1 rounded-full">Videos Available</span>
                                    </div>
                                </div>

                                <!-- Course Title -->
                                <h3 class="text-xl font-extrabold text-white truncate mb-2" v-if="featuredCourses.length > 0">
                                    {{ randomCourse.title }}
                                </h3>
                                <h3 v-else class="text-xl font-extrabold text-white truncate mb-2">Start Your Journey Today</h3>

                                <!-- Course Description -->
                                <p class="text-sm text-slate-300 mb-4 line-clamp-2" v-if="featuredCourses.length > 0">
                                    {{ randomCourse.description }}
                                </p>
                                <p v-else class="text-sm text-slate-300 mb-4">
                                    Choose from our premium courses and start learning at your own pace.
                                </p>

                                <!-- Instructor & Info -->
                                <div class="flex justify-between items-center mt-4 text-xs text-slate-400">
                                    <span v-if="featuredCourses.length > 0">
                                        Instructor: {{ randomCourse.instructor }}
                                    </span>
                                    <span v-else>Instructor: Our Experts</span>
                                    <span v-if="featuredCourses.length > 0">{{ randomCourse.videoCount }} Lessons</span>
                                    <span v-else>Explore All</span>
                                </div>

                                <!-- Progress Bar -->
                                <div v-if="false" class="mt-6 space-y-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-300">Course Progress</span>
                                        <span class="text-blue-400 font-semibold">65%</span>
                                    </div>
                                    <div class="w-full bg-slate-700 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full w-[65%]"></div>
                                    </div>
                                </div>

                                <!-- Category Tag -->
                                <div class="mt-6 flex justify-start">
                                    <span class="bg-blue-900/50 text-blue-300 text-xs px-3 py-1 rounded-full" v-if="featuredCourses.length > 0">
                                        {{ randomCourse.category }}
                                    </span>
                                    <span v-else class="bg-blue-900/50 text-blue-300 text-xs px-3 py-1 rounded-full">
                                        Web Development
                                    </span>
                                </div>

                                <!-- CTA Button -->
                                <div class="mt-8">
                                    <router-link
                                        to="/courses"
                                        class="block w-full text-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-500 hover:to-purple-500 transition-all duration-300 transform hover:-translate-y-0.5 shadow-lg hover:shadow-blue-500/30"
                                    >
                                        Start Learning
                                    </router-link>
                                </div>
                            </div>

                            <!-- Decorative Elements -->
                            <div class="absolute -top-6 -left-6 w-12 h-12 bg-blue-500/20 rounded-full animate-ping"></div>
                            <div class="absolute -bottom-4 -right-8 w-8 h-8 bg-purple-500/30 rounded-full animate-bounce"></div>
                        </div>
                        <div v-else class="text-center py-10">
                            <div class="inline-flex items-center space-x-2 text-slate-400">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"></div>
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
                    <span
                        class="bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent"
                        >Who We Are</span
                    >
                </h2>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Pioneering the future of online education with innovation
                    and expertise
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- vision Card -->
                <div
                    class="glass-card-premium rounded-3xl p-10 shadow-2xl border border-white/10 relative overflow-hidden group hover:scale-105 transition-all duration-500"
                >
                    <!-- background Pattern -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent"
                    ></div>

                    <!-- icon -->
                    <div class="relative z-10 mb-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'lightbulb']"
                                class="text-2xl text-white"
                            />
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold mb-4 text-white">
                        Our Vision
                    </h3>
                    <p class="text-slate-300 leading-relaxed text-lg">
                        At EduStream, we believe that education should be
                        accessible to everyone. Our vision is to empower
                        learners worldwide through high-quality, engaging online
                        courses taught by industry experts.
                    </p>

                    <!-- Decorative element -->
                    <div
                        class="absolute bottom-4 -right-8 w-32 h-32 opacity-10 group-hover:opacity-20 transition-opacity"
                    >
                        <font-awesome-icon
                            :icon="['fas', 'lightbulb']"
                            class="text-9xl text-blue-500"
                        />
                    </div>
                </div>

                <!-- mission Card -->
                <div
                    class="glass-card-premium rounded-3xl p-10 shadow-2xl border border-white/10 relative overflow-hidden group hover:scale-105 transition-all duration-500"
                >
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent"
                    ></div>

                    <!-- icon -->
                    <div class="relative z-10 mb-6">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'bullseye']"
                                class="text-2xl text-white"
                            />
                        </div>
                    </div>

                    <h3 class="text-2xl font-bold mb-4 text-white">
                        Our Mission
                    </h3>
                    <p class="text-slate-300 leading-relaxed text-lg">
                        We strive to deliver a seamless learning experience by
                        combining modern technology with real-world knowledge.
                        Whether you're starting your career or upgrading your
                        skills, EduStream has something for you.
                    </p>

                    <div
                        class="absolute bottom-4 right-1 w-32 h-32 opacity-10 group-hover:opacity-20 transition-opacity"
                    >
                        <font-awesome-icon
                            :icon="['fas', 'bullseye']"
                            class="text-9xl text-purple-500"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Courses -->
        <section class="container mx-auto px-6 py-24">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    <span
                        class="bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent"
                        >Featured Courses</span
                    >
                </h2>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Handpicked courses designed to accelerate your career growth
                </p>
            </div>

            <!-- loading and Error States -->
            <div v-if="loading" class="text-center">
                <div class="inline-flex items-center space-x-2 text-slate-400">
                    <div
                        class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-500"
                    ></div>
                    <span>Loading amazing courses...</span>
                </div>
            </div>

            <div
                v-if="error"
                class="text-center p-8 glass-card-premium rounded-2xl border border-red-500/20"
            >
                <div class="text-red-400 text-lg font-semibold">
                    {{ error }}
                </div>
            </div>

            <!--  course Grid -->
            <div
                v-else
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
            >
                <router-link
                    v-for="course in featuredCourses"
                    :key="course.id"
                    :to="`/courses/${course.id}`"
                    class="block group relative transform transition-all duration-300 hover:scale-105 hover:-translate-y-2"
                >
                    <div
                        class="glass-card-premium rounded-3xl shadow-2xl overflow-hidden border border-white/10 h-full flex flex-col backdrop-blur-xl hover:shadow-blue-500/20 hover:border-blue-500/30 transition-all duration-500"
                    >
                        <div
                            class="relative p-6 bg-gradient-to-br from-blue-500/10 to-purple-500/10 object-cover"
                            :style="{backgroundImage: `url(${course.image})`,backgroundSize: 'cover',backgroundPosition: 'center',backgroundRepeat: 'no-repeat'}"
                        >
                            <div
                                class="absolute top-4 right-4 bg-gradient-to-r from-orange-500 to-red-500 text-white text-xs px-3 py-1 rounded-full font-bold"
                            >
                                Popular
                            </div>

                            <div
                                class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300"
                            >
                                <font-awesome-icon
                                    :icon="['fas', 'video']"
                                    class="text-xl text-white"
                                />
                            </div>
                        </div>

                        <!-- course content -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div class="space-y-4">
                                <h3
                                    class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors duration-300 line-clamp-2"
                                >
                                    {{ course.title }}
                                </h3>

                                <p
                                    class="text-slate-300 leading-relaxed line-clamp-3"
                                >
                                    {{ course.description }}
                                </p>

                                <!-- Course Meta -->
                                <div class="grid grid-cols-1 gap-3 text-sm">
                                    <div
                                        class="flex items-center space-x-2 text-slate-400"
                                    >
                                        <font-awesome-icon
                                            :icon="[
                                                'fas',
                                                'chalkboard-teacher',
                                            ]"
                                            class="text-blue-400"
                                        />
                                        <span>{{ course.instructor }}</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div
                                            class="flex items-center space-x-2 text-slate-400"
                                        >
                                            <font-awesome-icon
                                                :icon="['fas', 'layer-group']"
                                                class="text-purple-400"
                                            />
                                            <span>{{ course.category }}</span>
                                        </div>
                                        <div
                                            class="flex items-center space-x-2 text-slate-400"
                                        >
                                            <font-awesome-icon
                                                :icon="['fas', 'video']"
                                                class="text-indigo-400"
                                            />
                                            <span
                                                >{{
                                                    course.videoCount
                                                }}
                                                Videos</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- action button -->
                            <button
                                class="mt-6 w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 rounded-xl font-semibold text-white transition-all duration-300 transform group-hover:scale-105 shadow-lg"
                            >
                                View Course Details
                            </button>
                        </div>
                    </div>
                </router-link>
            </div>
        </section>

        <!-- Popular Categories Section -->
        <section class="container mx-auto px-6 py-24">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500/20 to-purple-500/20 border border-blue-500/30 rounded-full backdrop-blur-sm mb-6"
                >
                    <span class="text-sm font-medium text-blue-300"
                        >📚 Explore Your Path</span
                    >
                </div>

                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    <span
                        class="bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent"
                    >
                        Popular Categories
                    </span>
                </h2>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Discover curated learning paths designed to help you achieve
                    your goals
                </p>
            </div>

            <!-- Category Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <template v-for="category in popularCategories" :key="category.id">
                    <router-link
                        :to="'/courses?category=' + category.id"
                        class="group relative bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 p-6 transition-all duration-500 hover:bg-white/10 hover:border-blue-500/30 hover:shadow-lg hover:shadow-blue-500/10 hover:scale-105 hover:-translate-y-2"
                    >
                        <!-- Category Image -->
                        <div class="flex items-center justify-center mb-6">
                            <div
                                class="w-24 h-24 rounded-xl overflow-hidden bg-gradient-to-br from-blue-500/10 to-purple-500/10 flex items-center justify-center shadow-md group-hover:shadow-xl group-hover:scale-110 transition-all duration-300"
                            >
                                <img
                                    :src="category.icon"
                                    :alt="category.name"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>

                        <!-- Category Name -->
                        <h3
                            class="text-xl font-bold text-white text-center group-hover:text-blue-400 transition-colors duration-300"
                        >
                            {{ category.name }}
                        </h3>

                        <!-- Course Count Badge -->
                        <div
                            class="mt-3 flex items-center justify-center px-4 py-1.5 bg-blue-500/20 rounded-full mx-auto w-fit"
                        >
                            <span class="text-sm text-blue-300">
                                {{ category.courses_count }} courses
                            </span>
                        </div>

                        <!-- Hover Indicator -->
                        <div
                            class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-purple-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 rounded-b-2xl"
                        ></div>
                    </router-link>
                </template>
            </div>
        </section>

        <!-- deals section -->
        <section class="container mx-auto px-4 py-16 relative">
            <!-- Section Header with enhanced animation -->
            <div class="text-center mb-16 animate-fade-in-up">
                <div
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-500/20 to-amber-500/20 border border-yellow-500/30 rounded-full backdrop-blur-sm mb-4 animate-pulse"
                >
                    <span class="text-sm font-medium text-yellow-300">🔥 Limited Time Offers</span>
                </div>
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    <span
                        class="bg-gradient-to-r from-yellow-300 via-amber-200 to-yellow-100 bg-clip-text text-transparent"
                    >Exclusive Deals</span>
                </h2>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Don't miss out on these amazing opportunities to enhance your skills
                </p>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="text-center">
                <div class="inline-flex items-center space-x-3 text-slate-400">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-yellow-500"></div>
                    <span class="text-lg">Loading amazing offers...</span>
                </div>
            </div>

            <!-- Error State -->
            <div
                v-else-if="error"
                class="text-center p-8 glass-card-premium rounded-2xl border border-red-500/20"
            >
                <div class="text-red-400 text-lg font-semibold">{{ error }}</div>
            </div>

            <!-- Offers Grid -->
            <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <router-link
                    v-for="offer in limitedTimeOffers"
                    :key="offer.id"
                    :to="`/courses/${offer.id}`"
                    class="group block transform transition-all duration-500 hover:-translate-y-2"
                >
                    <div
                        class="glass-card-premium rounded-xl overflow-hidden shadow-xl border border-white/10 backdrop-blur-xl group-hover:shadow-yellow-500/20 group-hover:border-yellow-500/40 transition-all duration-500 relative"
                    >
                        <!-- Gradient Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 via-transparent to-amber-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                        ></div>

                        <!-- Content -->
                        <div class="flex flex-col md:flex-row p-4 md:p-6 gap-4">
                            <!-- Image Section -->
                            <div class="relative w-full md:w-32 h-40 md:h-32 flex-shrink-0 rounded-xl overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-gradient-to-br from-yellow-500/30 to-amber-500/30 blur-xl group-hover:opacity-75 transition-opacity duration-500"
                                ></div>
                                <img
                                    :src="offer.image || defaultLogo"
                                    alt="Course Image"
                                    class="relative w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                />
                                <!-- Discount Badge -->
                                <div
                                    class="absolute top-2 right-2 bg-gradient-to-r from-yellow-500 to-amber-500 text-white px-2.5 py-0.5 rounded-full font-bold text-xs shadow-md transform group-hover:scale-110 transition-transform duration-300"
                                >
                                    {{ offer.discount }}% OFF
                                </div>
                            </div>

                            <!-- Text Content -->
                            <div class="flex-1 flex flex-col justify-between">
                                <!-- Title -->
                                <h3
                                    class="font-bold text-lg text-white mb-2 line-clamp-2 group-hover:text-yellow-300 transition-colors duration-300"
                                >
                                    {{ offer.title }}
                                </h3>

                                <!-- Instructor & Category -->
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-3 text-sm text-slate-400">
                                    <div class="flex items-center gap-1.5 bg-white/5 px-2.5 py-1 rounded-full">
                                        <font-awesome-icon :icon="['fas', 'chalkboard-teacher']" class="text-yellow-400" />
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
                                        <div
                                            class="text-sm text-slate-300 line-through opacity-75"
                                        >
                                            ${{ offer.originalPrice }}
                                        </div>
                                    </div>
                                    <div v-if="offer.discountedPrice" class="space-y-1">
                                        <div class="text-xs text-yellow-400 font-medium">Special Offer</div>
                                        <div class="text-xl font-bold text-yellow-300 group-hover:scale-110 transition-transform duration-300">
                                            ${{ offer.discountedPrice }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Timer + Enrollments + Button -->
                                <div class="mt-4 flex flex-wrap items-center justify-between pt-3 border-t border-white/5">
                                    <!-- Time Left -->
                                    <div class="flex items-center gap-1.5 text-sm text-slate-400 mb-2 sm:mb-0">
                                        <font-awesome-icon :icon="['fas', 'clock']" class="text-amber-400 animate-pulse" />
                                        <span>Ends in {{ offer.timeLeft }}</span>
                                    </div>

                                    <!-- Enrollments -->
                                    <div class="flex items-center gap-1.5 text-sm text-slate-400 mb-2 sm:mb-0">
                                        <font-awesome-icon :icon="['fas', 'users']" class="text-yellow-400" />
                                        <span>{{ offer.enrollments }} enrolled</span>
                                    </div>

                                    <!-- Enroll Now Button -->
                                    <button
                                        class="px-4 py-2 bg-gradient-to-r from-yellow-500 to-amber-500 rounded-lg text-white text-sm font-semibold shadow-md transform transition-all duration-300 group-hover:scale-105 group-hover:shadow-yellow-500/25 whitespace-nowrap"
                                    >
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
        <section class="container mx-auto px-6 py-24">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    <span
                        class="bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent"
                        >Meet Our Expert Instructors</span
                    >
                </h2>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Learn from industry leaders and experienced professionals
                </p>
            </div>
            <div v-if="loading" class="text-center text-gray-500">
                Loading...
            </div>
            <div v-if="error" class="text-center text-red-500">{{ error }}</div>
            <template v-else>
                <template v-if="topInstructors">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                    >
                        <!-- Instructor Cards -->
                        <template
                            v-for="instructor in topInstructors"
                            :key="instructor.id"
                        >
                            <router-link
                                :to="`/instructors/${instructor.id}`"
                                class="glass-card-premium rounded-3xl p-8 text-center group hover:scale-105 transition-all duration-500 shadow-2xl"
                            >
                                <!-- profile image -->
                                <div class="relative mb-6">
                                    <div
                                        class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-blue-500 to-purple-600 p-1 group-hover:scale-110 transition-transform duration-300"
                                    >
                                        <img
                                            :src="instructor.image"
                                            :alt="instructor.name"
                                            @error="
                                                $event.target.src = defaultImage
                                            "
                                            class="w-full h-full rounded-full object-cover border-2 border-slate-800"
                                        />
                                    </div>
                                    <!-- Status indicator -->
                                    <div
                                        class="absolute bottom-0 right-1/3 w-6 h-6 bg-green-500 rounded-full border-4 border-slate-900 animate-pulse"
                                    ></div>
                                </div>

                                <h3
                                    class="font-bold text-xl text-white mb-2 group-hover:text-blue-400 transition-colors duration-300"
                                >
                                    {{ instructor.name }}
                                </h3>
                                <p class="text-blue-400 font-semibold mb-2">
                                    {{ instructor.specialization }}
                                </p>
                                <p class="text-slate-400 text-sm mb-4">
                                    {{ instructor.experience }} of experience
                                </p>

                                <!-- Instructor stats -->
                                <div
                                    class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-slate-700"
                                >
                                    <template
                                        v-for="skill in instructor.skills"
                                        :key="skill"
                                    >
                                        <div class="text-center">
                                            <!-- <div class="text-lg font-bold text-white">15K+</div> -->
                                            <div class="text-xs text-slate-400">
                                                {{ skill }}
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </router-link>
                        </template>
                    </div>
                </template>
                <template v-else> </template>
            </template>
        </section>

        <!-- Enhanced Call to Action Section -->
        <section class="container mx-auto px-6 py-24">
            <div class="relative">
                <!-- Decorative Background  -->
                <div
                    class="absolute inset-0 bg-gradient-to-r from-blue-600/20 via-purple-600/20 to-indigo-600/20 rounded-3xl blur-xl"
                ></div>
                <div
                    class="absolute inset-0 backdrop-blur-3xl rounded-3xl"
                ></div>

                <!-- Main Content -->
                <div
                    class="glass-card-premium rounded-3xl p-16 shadow-2xl text-center relative border border-white/20"
                >
                    <!-- Animated Background -->
                    <div
                        class="absolute top-8 left-8 w-16 h-16 bg-blue-500/20 rounded-full animate-pulse"
                    ></div>
                    <div
                        class="absolute bottom-8 right-8 w-12 h-12 bg-purple-500/20 rounded-full animate-ping"
                    ></div>

                    <!-- Content -->
                    <div class="relative z-10 max-w-4xl mx-auto">
                        <div
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500/20 to-purple-500/20 border border-blue-500/30 rounded-full backdrop-blur-sm mb-8"
                        >
                            <span class="text-sm font-medium text-blue-300"
                                >🚀 Start Your Journey</span
                            >
                        </div>

                        <h2 class="text-4xl md:text-6xl font-bold mb-6">
                            <span
                                class="bg-gradient-to-r from-white via-blue-100 to-purple-100 bg-clip-text text-transparent"
                            >
                                Transform Your Future With Us
                            </span>
                        </h2>

                        <p
                            class="text-xl md:text-2xl text-slate-300 mb-8 max-w-2xl mx-auto leading-relaxed"
                        >
                            Join our growing community of learners and unlock
                            your potential with
                            <span class="text-blue-400 font-semibold"
                                >cutting-edge courses</span
                            >
                            designed for the modern world.
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap justify-center gap-6 mt-8">
                            <button
                                class="group relative px-10 py-4 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl font-bold text-lg text-white shadow-2xl shadow-blue-500/25 hover:shadow-blue-500/40 transition-all duration-300 transform hover:scale-105 hover:-translate-y-1"
                            >
                                <span
                                    class="relative z-10 flex items-center space-x-2"
                                >
                                    <span>Begin Your Journey</span>
                                    <font-awesome-icon
                                        icon="arrow-right"
                                        class="transition-transform duration-300 transform group-hover:translate-x-1"
                                    />
                                </span>
                            </button>

                            <button
                                class="px-10 py-4 bg-white/5 backdrop-blur-sm border border-white/20 rounded-2xl font-bold text-lg text-white hover:bg-white/10 hover:border-white/30 transition-all duration-300 transform hover:scale-105 flex items-center space-x-2"
                            >
                                <span>Browse Success Stories</span>
                                <font-awesome-icon icon="book-open" />
                            </button>
                        </div>

                        <!-- Key Features -->
                        <div
                            class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16 pt-8 border-t border-white/10"
                        >
                            <div class="flex flex-col items-center">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-blue-600/20 rounded-xl flex items-center justify-center mb-3"
                                >
                                    <font-awesome-icon
                                        icon="certificate"
                                        class="text-2xl text-blue-400"
                                    />
                                </div>
                                <h3 class="text-lg font-semibold text-white">
                                    Expert Certificates
                                </h3>
                                <p class="text-slate-400 text-sm">
                                    Industry-recognized achievements
                                </p>
                            </div>

                            <div class="flex flex-col items-center">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-purple-500/20 to-purple-600/20 rounded-xl flex items-center justify-center mb-3"
                                >
                                    <font-awesome-icon
                                        icon="clock"
                                        class="text-2xl text-purple-400"
                                    />
                                </div>
                                <h3 class="text-lg font-semibold text-white">
                                    Flexible Learning
                                </h3>
                                <p class="text-slate-400 text-sm">
                                    Learn at your own pace
                                </p>
                            </div>

                            <div class="flex flex-col items-center">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center mb-3"
                                >
                                    <font-awesome-icon
                                        icon="users"
                                        class="text-2xl text-emerald-400"
                                    />
                                </div>
                                <h3 class="text-lg font-semibold text-white">
                                    Community Support
                                </h3>
                                <p class="text-slate-400 text-sm">
                                    Learn together, grow together
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
import { ref, onMounted } from "vue";
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

library.add(
    faLightbulb,
    faBullseye,
    faChalkboardTeacher,
    faLayerGroup,
    faVideo,
    faFolder
);

const homeStore = useHomeStore();
const featuredCourses = ref([]);
const popularCategories = ref([]);
const limitedTimeOffers = ref([]);
const topInstructors = ref([]);
const loading = ref(true);
const error = ref(null);
const defaultLogo = "https://i.ibb.co/67ZKPkmK/logo.png";

// Random course selection
const randomCourse = ref(null);

// Function to get a random course
const getRandomCourse = () => {
    if (!featuredCourses.value || featuredCourses.value.length === 0) return null;
    const randomIndex = Math.floor(Math.random() * featuredCourses.value.length);
    return featuredCourses.value[randomIndex];
};

const fetchHomeData = async () => {
    try {
        await homeStore.fetchHomeData();
        featuredCourses.value = homeStore.featuredCourses;
        popularCategories.value = homeStore.popularCategories;
        limitedTimeOffers.value = homeStore.limitedTimeOffers;
        topInstructors.value = homeStore.topInstructors;
        loading.value = false;
        error.value = null;
    } catch (err) {
        console.error("Error fetching home data:", err);
        error.value = "Failed to load data. Please try again later.";
        loading.value = false;
    }
};

fetchHomeData();

onMounted(async () => {
    await fetchHomeData();
    randomCourse.value = getRandomCourse();
    setInterval(() => {
        randomCourse.value = getRandomCourse();
    }, 10000);
});
</script>

<style scoped>
.glass-card-premium {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
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
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #2563eb, #7c3aed);
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
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
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
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
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
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}
</style>