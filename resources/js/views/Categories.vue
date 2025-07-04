<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
    >
        <section class="relative overflow-hidden">
            <!-- Enhanced Simple Background with Elevation -->
            <div class="absolute inset-0 pointer-events-none">
                <!-- Primary Gradient Orbs with Elevation - Hidden on Mobile -->
                <div
                    :class="
                        isDark
                            ? 'absolute top-8 left-8 w-96 h-96 bg-gradient-to-br from-teal-500/20 via-cyan-500/15 to-teal-600/10 rounded-full blur-4xl animate-float-orb shadow-2xl hidden md:block'
                            : 'absolute top-8 left-8 w-96 h-96 bg-gradient-to-br from-teal-400/40 via-cyan-400/30 to-teal-500/25 rounded-full blur-4xl animate-float-orb shadow-2xl hidden md:block'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute top-24 right-12 w-[500px] h-[500px] bg-gradient-to-bl from-purple-500/20 via-pink-500/15 to-purple-600/10 rounded-full blur-4xl animate-float-orb-delayed shadow-2xl hidden md:block'
                            : 'absolute top-24 right-12 w-[500px] h-[500px] bg-gradient-to-bl from-purple-400/40 via-pink-400/30 to-purple-500/25 rounded-full blur-4xl animate-float-orb-delayed shadow-2xl hidden md:block'
                    "
                ></div>
                <!-- Centered Large Orb with Enhanced Elevation - Hidden on Mobile -->
                <div
                    :class="
                        isDark
                            ? 'absolute bottom-12 left-1/3 w-80 h-80 bg-gradient-to-tr from-cyan-500/15 via-teal-500/10 to-cyan-600/8 rounded-full blur-4xl animate-float-orb-slow shadow-3xl hidden md:block'
                            : 'absolute bottom-12 left-1/3 w-80 h-80 bg-gradient-to-tr from-cyan-400/35 via-teal-400/25 to-cyan-500/20 rounded-full blur-4xl animate-float-orb-slow shadow-3xl hidden md:block'
                    "
                ></div>

                <!-- Mobile Geometric Shapes - Visible only on Mobile -->
                <div class="md:hidden">
                    <!-- Hexagon Shape -->
                    <div
                        :class="
                            isDark
                                ? 'absolute top-8 left-8 w-32 h-32 bg-gradient-to-br from-teal-500/15 to-cyan-500/10 animate-pulse-slow'
                                : 'absolute top-8 left-8 w-32 h-32 bg-gradient-to-br from-teal-400/25 to-cyan-400/20 animate-pulse-slow'
                        "
                        style="
                            clip-path: polygon(
                                50% 0%,
                                100% 25%,
                                100% 75%,
                                50% 100%,
                                0% 75%,
                                0% 25%
                            );
                        "
                    ></div>

                    <!-- Diamond Shape -->
                    <div
                        :class="
                            isDark
                                ? 'absolute top-16 right-8 w-24 h-24 bg-gradient-to-bl from-purple-500/15 to-pink-500/10 animate-pulse-slow delay-1000'
                                : 'absolute top-16 right-8 w-24 h-24 bg-gradient-to-bl from-purple-400/25 to-pink-400/20 animate-pulse-slow delay-1000'
                        "
                        style="
                            clip-path: polygon(
                                50% 0%,
                                100% 50%,
                                50% 100%,
                                0% 50%
                            );
                        "
                    ></div>

                    <!-- Triangle Shape -->
                    <div
                        :class="
                            isDark
                                ? 'absolute bottom-16 left-1/4 w-20 h-20 bg-gradient-to-tr from-cyan-500/12 to-teal-500/8 animate-pulse-slow delay-500'
                                : 'absolute bottom-16 left-1/4 w-20 h-20 bg-gradient-to-tr from-cyan-400/20 to-teal-400/15 animate-pulse-slow delay-500'
                        "
                        style="clip-path: polygon(50% 0%, 0% 100%, 100% 100%)"
                    ></div>

                    <!-- Star Shape -->
                    <div
                        :class="
                            isDark
                                ? 'absolute top-1/3 right-1/4 w-16 h-16 bg-gradient-to-br from-teal-400/10 to-purple-400/8 animate-pulse-slow delay-1500'
                                : 'absolute top-1/3 right-1/4 w-16 h-16 bg-gradient-to-br from-teal-300/18 to-purple-300/15 animate-pulse-slow delay-1500'
                        "
                        style="
                            clip-path: polygon(
                                50% 0%,
                                61% 35%,
                                98% 35%,
                                68% 57%,
                                79% 91%,
                                50% 70%,
                                21% 91%,
                                32% 57%,
                                2% 35%,
                                39% 35%
                            );
                        "
                    ></div>
                </div>

                <!-- Simple Secondary Orbs with Elevation - Smaller on Mobile -->
                <div
                    :class="
                        isDark
                            ? 'absolute top-1/4 left-1/6 w-24 h-24 md:w-48 bg-gradient-to-r from-teal-400/10 to-cyan-400/10 rounded-full blur-3xl animate-pulse-slow shadow-xl'
                            : 'absolute top-1/4 left-1/6 w-24 h-24 md:w-48 bg-gradient-to-r from-teal-300/20 to-cyan-300/20 rounded-full blur-3xl animate-pulse-slow shadow-xl'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute bottom-1/4 right-1/6 w-20 h-20 md:w-40 bg-gradient-to-r from-purple-400/10 to-pink-400/10 rounded-full blur-3xl animate-pulse-slow delay-1000 shadow-xl'
                            : 'absolute bottom-1/4 right-1/6 w-20 h-20 md:w-40 bg-gradient-to-r from-purple-300/20 to-pink-300/20 rounded-full blur-3xl animate-pulse-slow delay-1000 shadow-xl'
                    "
                ></div>

                <!-- Additional Small Scattered Orbs - Smaller on Mobile -->
                <div
                    :class="
                        isDark
                            ? 'absolute top-1/3 right-1/4 w-16 h-16 md:w-32 bg-gradient-to-br from-teal-400/8 to-cyan-400/8 rounded-full blur-2xl animate-pulse-slow delay-500 shadow-lg'
                            : 'absolute top-1/3 right-1/4 w-16 h-16 md:w-32 bg-gradient-to-br from-teal-300/15 to-cyan-300/15 rounded-full blur-2xl animate-pulse-slow delay-500 shadow-lg'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute top-2/3 left-1/5 w-12 h-12 md:w-24 bg-gradient-to-bl from-purple-400/8 to-pink-400/8 rounded-full blur-2xl animate-pulse-slow delay-1500 shadow-lg'
                            : 'absolute top-2/3 left-1/5 w-12 h-12 md:w-24 bg-gradient-to-bl from-purple-300/15 to-pink-300/15 rounded-full blur-2xl animate-pulse-slow delay-1500 shadow-lg'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute top-1/6 right-1/3 w-10 h-10 md:w-20 bg-gradient-to-tr from-cyan-400/8 to-teal-400/8 rounded-full blur-2xl animate-pulse-slow delay-2000 shadow-lg'
                            : 'absolute top-1/6 right-1/3 w-10 h-10 md:w-20 bg-gradient-to-tr from-cyan-300/15 to-teal-300/15 rounded-full blur-2xl animate-pulse-slow delay-2000 shadow-lg'
                    "
                ></div>
            </div>

            <!-- Simple Floating Particles with Elevation -->
            <div class="absolute inset-0 pointer-events-none">
                <div
                    v-for="i in 5"
                    :key="i"
                    :class="[
                        'absolute rounded-full animate-float shadow-lg',
                        isDark
                            ? `bg-teal-400/30 particle-${i}`
                            : `bg-teal-500/50 particle-${i}`,
                        i <= 3 ? 'w-2 h-2' : 'w-1.5 h-1.5',
                    ]"
                    :style="{
                        top: `${20 + i * 15}%`,
                        left: `${10 + i * 18}%`,
                        animationDelay: `${i * 300}ms`,
                        animationDuration: `${3.5 + i * 0.4}s`,
                    }"
                ></div>

                <!-- Additional Glow Particles -->
                <div
                    v-for="i in 3"
                    :key="`glow-${i}`"
                    :class="[
                        'absolute rounded-full animate-glow shadow-lg',
                        isDark
                            ? `bg-cyan-400/25 glow-particle-${i}`
                            : `bg-cyan-500/40 glow-particle-${i}`,
                    ]"
                    :style="{
                        top: `${35 + i * 20}%`,
                        right: `${15 + i * 12}%`,
                        width: `${6 + i * 1.5}px`,
                        height: `${6 + i * 1.5}px`,
                        animationDelay: `${i * 500}ms`,
                        animationDuration: `${4 + i * 0.3}s`,
                    }"
                ></div>
            </div>

            <!-- Hero Section -->
            <div class="container mx-auto px-4 py-12 md:py-16 relative z-10">
                <div class="text-center max-w-3xl mx-auto animate-slide-in">
                    <!-- Badge -->
                    <div
                        :class="[
                            'inline-flex items-center px-5 py-2 border rounded-full backdrop-blur-md mb-6 transition-all duration-300',
                            isDark
                                ? 'bg-gradient-to-r from-teal-500/30 via-cyan-500/30 to-purple-500/30 border-teal-400/40 hover:bg-teal-500/40'
                                : 'bg-gradient-to-r from-teal-100/90 via-cyan-100/90 to-purple-100/90 border-teal-300/70 hover:bg-teal-200/90 shadow-md',
                        ]"
                    >
                        <span
                            :class="[
                                'text-sm font-semibold tracking-wide',
                                isDark ? 'text-teal-200' : 'text-teal-600',
                            ]"
                            >📚 Discover Your Path</span
                        >
                    </div>

                    <!-- Main Heading -->
                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight mb-4 tracking-tight"
                    >
                        <span
                            :class="[
                                'block bg-clip-text text-transparent',
                                isDark
                                    ? 'bg-gradient-to-r from-white via-teal-200 to-purple-200'
                                    : 'bg-gradient-to-r from-slate-900 via-teal-700 to-purple-700',
                            ]"
                        >
                            Explore Our
                        </span>
                        <span
                            :class="[
                                'block bg-clip-text text-transparent',
                                isDark
                                    ? 'bg-gradient-to-r from-teal-300 via-cyan-300 to-purple-300'
                                    : 'bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500',
                            ]"
                        >
                            Categories
                        </span>
                    </h1>

                    <!-- Description -->
                    <p
                        :class="[
                            'text-lg sm:text-xl max-w-2xl mx-auto leading-relaxed mb-8',
                            isDark ? 'text-slate-200' : 'text-slate-600',
                        ]"
                    >
                        Dive into our curated categories and
                        <span
                            :class="
                                isDark
                                    ? 'text-teal-300 font-semibold'
                                    : 'text-teal-500 font-semibold'
                            "
                            >unlock your potential</span
                        >
                        with skills that inspire.
                    </p>

                    <!-- Search Section -->
                    <div class="max-w-xl mx-auto mb-8">
                        <div class="relative group">
                            <div
                                :class="[
                                    'absolute inset-0 rounded-xl blur-lg transition-all duration-300',
                                    isDark
                                        ? 'bg-gradient-to-r from-teal-500/20 to-purple-500/20 group-hover:bg-teal-500/30'
                                        : 'bg-gradient-to-r from-teal-300/30 to-purple-300/30 group-hover:bg-teal-400/40',
                                ]"
                            ></div>
                            <div
                                :class="[
                                    'relative rounded-xl border shadow-lg transition-all duration-300',
                                    isDark
                                        ? 'bg-gradient-to-r from-white/5 to-white/10 border-white/20'
                                        : 'bg-white/95 border-teal-200/70',
                                ]"
                            >
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Search categories, topics, skills..."
                                    :class="[
                                        'w-full p-4 bg-transparent focus:outline-none pl-12 pr-16 text-base sm:text-lg transition-colors duration-300',
                                        isDark
                                            ? 'text-white placeholder:text-slate-400'
                                            : 'text-slate-900 placeholder:text-slate-500',
                                    ]"
                                />
                                <font-awesome-icon
                                    icon="search"
                                    :class="[
                                        'absolute left-4 top-1/2 transform -translate-y-1/2 text-lg',
                                        isDark
                                            ? 'text-teal-300'
                                            : 'text-teal-500',
                                    ]"
                                />
                                <div
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2"
                                >
                                    <span
                                        :class="[
                                            'px-3 py-1 rounded-lg text-xs font-medium',
                                            isDark
                                                ? 'bg-teal-500/30 text-teal-200 border border-teal-400/40'
                                                : 'bg-teal-100/90 text-teal-600 border border-teal-300/70',
                                        ]"
                                    >
                                        {{ filteredCategories?.length || 0 }}
                                        found
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Search Hints -->
                        <div class="flex flex-wrap justify-center gap-2 mt-3">
                            <button
                                v-for="hint in searchHints"
                                :key="hint"
                                @click="searchQuery = hint"
                                :class="[
                                    'px-3 py-1.5 text-xs font-medium rounded-full transition-all duration-300 backdrop-blur-sm',
                                    isDark
                                        ? 'bg-white/10 hover:bg-teal-500/30 border border-white/15 hover:border-teal-400/50 text-slate-300 hover:text-teal-200'
                                        : 'bg-white/70 hover:bg-teal-100/90 border border-teal-200/50 hover:border-teal-400/70 text-slate-600 hover:text-teal-600',
                                ]"
                            >
                                {{ hint }}
                            </button>
                        </div>
                    </div>

                    <!-- Stats Row -->
                    <div class="flex justify-center gap-6 sm:gap-12 py-4">
                        <div class="text-center">
                            <div
                                :class="[
                                    'text-2xl sm:text-3xl font-extrabold',
                                    isDark ? 'text-white' : 'text-slate-800',
                                ]"
                            >
                                {{ filteredCategories?.length || 0 }}+
                            </div>
                            <div
                                :class="[
                                    'text-sm',
                                    isDark
                                        ? 'text-slate-300'
                                        : 'text-slate-500',
                                ]"
                            >
                                {{ searchQuery ? "Found" : "Categories" }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Loading State -->
        <div v-if="Loading" class="container mx-auto px-6 py-20">
            <div class="text-center">
                <div
                    :class="[
                        'inline-flex items-center space-x-3',
                        isDark ? 'text-slate-400' : 'text-slate-600',
                    ]"
                >
                    <div
                        class="animate-spin rounded-full h-8 w-8 border-b-2 border-teal-500"
                    ></div>
                    <span class="text-lg">Loading amazing categories...</span>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <template v-else>
            <section class="relative z-10 container mx-auto px-6 py-8">
                <!-- Section Header with Professional Connection -->
                <div class="text-center mb-16 relative">
                    <!-- Professional Connection Line -->
                    <div
                        class="absolute top-0 left-1/2 transform -translate-x-1/2 w-px h-20 bg-gradient-to-b from-transparent via-teal-400/40 to-transparent"
                    ></div>

                    <!-- Decorative Elements -->
                    <div class="flex justify-center items-center gap-6 mb-8">
                        <div
                            :class="
                                isDark
                                    ? 'w-12 h-px bg-teal-400/30'
                                    : 'w-12 h-px bg-teal-500/50'
                            "
                        ></div>
                        <div
                            :class="
                                isDark
                                    ? 'w-3 h-3 bg-teal-400/50 rounded-full shadow-lg'
                                    : 'w-3 h-3 bg-teal-500/70 rounded-full shadow-lg'
                            "
                        ></div>
                        <div
                            :class="
                                isDark
                                    ? 'w-12 h-px bg-teal-400/30'
                                    : 'w-12 h-px bg-teal-500/50'
                            "
                        ></div>
                    </div>

                    <h2 class="text-3xl md:text-4xl font-bold mb-6">
                        <span
                            :class="[
                                'bg-clip-text text-transparent',
                                isDark
                                    ? 'bg-gradient-to-r from-white to-slate-300'
                                    : 'bg-gradient-to-r from-slate-900 to-slate-700',
                            ]"
                        >
                            {{
                                searchQuery
                                    ? `Search Results for "${searchQuery}"`
                                    : "All Categories"
                            }}
                        </span>
                    </h2>
                    <p
                        :class="[
                            'text-lg max-w-2xl mx-auto leading-relaxed',
                            isDark ? 'text-slate-400' : 'text-slate-600',
                        ]"
                    >
                        {{
                            searchQuery
                                ? `Found ${filteredCategories.length} categories matching your search`
                                : "Start your learning journey in any field that interests you"
                        }}
                    </p>
                </div>

                <!-- No Results Message -->
                <div
                    v-if="filteredCategories.length === 0 && searchQuery"
                    class="text-center py-16"
                >
                    <div class="max-w-md mx-auto">
                        <font-awesome-icon
                            :icon="['fas', 'search-minus']"
                            :class="[
                                'text-5xl mb-4',
                                isDark ? 'text-slate-600' : 'text-slate-400',
                            ]"
                        />
                        <h3
                            :class="[
                                'text-xl font-bold mb-3',
                                isDark ? 'text-white' : 'text-slate-800',
                            ]"
                        >
                            No Categories Found
                        </h3>
                        <p
                            :class="[
                                'mb-4',
                                isDark ? 'text-slate-400' : 'text-slate-600',
                            ]"
                        >
                            We couldn't find any categories matching "{{
                                searchQuery
                            }}". Try a different search term.
                        </p>
                        <button
                            @click="clearSearch"
                            class="px-6 py-3 bg-gradient-to-r from-teal-600 to-purple-600 hover:from-teal-500 hover:to-purple-500 rounded-xl font-semibold text-white transition-all duration-300 transform hover:scale-105 shadow-lg"
                        >
                            Show All Categories
                        </button>
                    </div>
                </div>

                <!-- Enhanced Professional Categories Grid -->
                <div
                    v-else
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
                >
                    <router-link
                        v-for="category in paginatedCategories"
                        :key="category.id"
                        :to="`/courses?category=${category.id}`"
                        class="group block transform transition-all duration-700 hover:scale-105 hover:-translate-y-3"
                    >
                        <div
                            :class="[
                                'rounded-3xl shadow-xl border h-full flex flex-col transition-all duration-500 group overflow-hidden relative backdrop-blur-sm',
                                isDark
                                    ? 'bg-white/8 border-white/15 hover:shadow-2xl hover:shadow-teal-400/20 hover:border-teal-400/40 hover:bg-white/12'
                                    : 'bg-white/95 border-teal-200/50 hover:shadow-2xl hover:shadow-teal-400/30 hover:border-teal-400/60 shadow-lg hover:bg-white',
                            ]"
                        >
                            <!-- Enhanced Category Image -->
                            <div class="relative overflow-hidden">
                                <img
                                    :src="category.image_url"
                                    :alt="category.name"
                                    @error="$event.target.src = defaultImage"
                                    class="w-full h-44 object-cover rounded-t-3xl transition-transform duration-700 group-hover:scale-110"
                                />
                                <!-- Enhanced Gradient Bar -->
                                <div
                                    class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-400"
                                ></div>
                                <!-- Professional Icon with Elevation -->
                                <div
                                    :class="[
                                        'absolute top-3 left-3 p-2.5 rounded-full shadow-xl backdrop-blur-sm transition-all duration-300 group-hover:scale-110',
                                        isDark
                                            ? 'bg-white/15 border border-white/25'
                                            : 'bg-white/95 border border-teal-200/60',
                                    ]"
                                >
                                    <font-awesome-icon
                                        :icon="['fas', 'layer-group']"
                                        :class="
                                            isDark
                                                ? 'text-teal-300'
                                                : 'text-teal-600'
                                        "
                                    />
                                </div>
                                <!-- Enhanced Course Count Badge -->
                                <div
                                    :class="[
                                        'absolute top-3 right-3 text-xs px-3 py-1.5 rounded-full shadow-lg backdrop-blur-sm transition-all duration-300 group-hover:scale-105',
                                        isDark
                                            ? 'bg-teal-500/80 text-white border border-teal-400/50'
                                            : 'bg-teal-500/90 text-white border border-teal-400/70',
                                    ]"
                                >
                                    {{ category.courses_count }} Courses
                                </div>
                                <!-- Enhanced Popular Badge -->
                                <div
                                    v-if="category.courses_count > 10"
                                    :class="[
                                        'absolute top-12 right-3 text-xs px-2 py-1 rounded-full shadow-lg backdrop-blur-sm transition-all duration-300 group-hover:scale-105',
                                        isDark
                                            ? 'bg-orange-500/70 text-white border border-orange-400/50'
                                            : 'bg-orange-500/80 text-white border border-orange-400/70',
                                    ]"
                                >
                                    🔥 Popular
                                </div>
                            </div>
                            <!-- Enhanced Card Content -->
                            <div
                                class="p-6 flex-1 flex flex-col justify-between"
                            >
                                <h3
                                    :class="[
                                        'text-lg font-bold mb-3 transition-colors duration-300',
                                        isDark
                                            ? 'text-white group-hover:text-teal-300'
                                            : 'text-slate-800 group-hover:text-teal-600',
                                    ]"
                                >
                                    {{ category.name }}
                                </h3>
                                <p
                                    :class="[
                                        'text-sm mb-6 line-clamp-2 leading-relaxed',
                                        isDark
                                            ? 'text-slate-300'
                                            : 'text-slate-600',
                                    ]"
                                >
                                    {{ category.description }}
                                </p>
                                <!-- Enhanced Professional Button -->
                                <button
                                    :class="[
                                        'mt-auto w-full py-3 rounded-xl font-semibold flex items-center justify-center gap-2 transition-all duration-500 shadow-lg transform group-hover:scale-105',
                                        isDark
                                            ? 'bg-gradient-to-r from-teal-500 to-purple-500 text-white hover:from-teal-600 hover:to-purple-600 hover:shadow-2xl hover:shadow-teal-400/30'
                                            : 'bg-gradient-to-r from-teal-500 to-purple-500 text-white hover:from-teal-600 hover:to-purple-600 hover:shadow-2xl',
                                    ]"
                                >
                                    Explore Category
                                    <font-awesome-icon
                                        icon="arrow-right"
                                        class="text-xs transition-transform duration-300 group-hover:translate-x-1"
                                    />
                                </button>
                            </div>
                        </div>
                    </router-link>
                </div>

                <!-- Pagination -->
                <div class="mt-16 flex justify-center">
                    <div
                        :class="[
                            'p-4 rounded-2xl shadow-2xl border',
                            isDark
                                ? 'glass-card-premium border-white/20'
                                : 'bg-white/50 border-slate-200/50',
                        ]"
                    >
                        <nav class="flex items-center gap-2">
                            <!-- Previous Button -->
                            <button
                                @click="goToPage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-700 text-white rounded-xl disabled:opacity-50 disabled:cursor-not-allowed shadow-lg"
                            >
                                <font-awesome-icon
                                    icon="chevron-left"
                                    class="text-sm"
                                />
                                <span class="font-medium">Previous</span>
                            </button>

                            <!-- Page numbers -->
                            <div class="flex items-center gap-1 mx-4">
                                <button
                                    v-for="page in visiblePages"
                                    :key="page"
                                    @click="goToPage(page)"
                                    :class="[
                                        'w-12 h-12 rounded-xl flex items-center justify-center font-semibold',
                                        {
                                            'bg-gradient-to-r from-teal-600 to-purple-600 text-white shadow-lg':
                                                currentPage === page,
                                        },
                                        currentPage !== page &&
                                            (isDark
                                                ? 'text-slate-400'
                                                : 'text-slate-600'),
                                    ]"
                                >
                                    {{ page }}
                                </button>
                            </div>

                            <!-- Next Button -->
                            <button
                                @click="goToPage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-700 to-teal-600 text-white rounded-xl disabled:opacity-50 disabled:cursor-not-allowed shadow-lg"
                            >
                                <span class="font-medium">Next</span>
                                <font-awesome-icon
                                    icon="chevron-right"
                                    class="text-sm"
                                />
                            </button>
                        </nav>
                    </div>
                </div>
            </section>
        </template>
    </div>
</template>

<script setup>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { useCategoryStore } from "../stores/CategoryStore";
import { ref, computed, watch } from "vue";
import defaultImage from "@/assets/icons/EduStream.jpg";
import { useTheme } from "../composables/useTheme";

library.add(fas);

const categoryStore = useCategoryStore();
const { isDark } = useTheme();
const Loading = ref(true);
const searchQuery = ref("");
const currentPage = ref(1);
const categoriesPerPage = 12;

// Search hints for better UX
const searchHints = ref([
    "Programming",
    "Design",
    "Business",
    "Marketing",
    "Art",
    "Science",
]);

// Computed properties
const filteredCategories = computed(() => {
    if (!categoryStore.categories) return [];

    if (!searchQuery.value.trim()) {
        return categoryStore.categories;
    }

    const query = searchQuery.value.toLowerCase().trim();
    return categoryStore.categories.filter(
        (category) =>
            category.name.toLowerCase().includes(query) ||
            category.description.toLowerCase().includes(query)
    );
});

const totalPages = computed(() => {
    return Math.ceil(filteredCategories.value.length / categoriesPerPage);
});

const paginatedCategories = computed(() => {
    const start = (currentPage.value - 1) * categoriesPerPage;
    const end = start + categoriesPerPage;
    return filteredCategories.value.slice(start, end);
});

const visiblePages = computed(() => {
    const pages = [];
    const total = totalPages.value;
    const current = currentPage.value;

    if (total <= 7) {
        for (let i = 1; i <= total; i++) {
            pages.push(i);
        }
    } else {
        if (current <= 4) {
            for (let i = 1; i <= 5; i++) {
                pages.push(i);
            }
            pages.push("...");
            pages.push(total);
        } else if (current >= total - 3) {
            pages.push(1);
            pages.push("...");
            for (let i = total - 4; i <= total; i++) {
                pages.push(i);
            }
        } else {
            pages.push(1);
            pages.push("...");
            for (let i = current - 1; i <= current + 1; i++) {
                pages.push(i);
            }
            pages.push("...");
            pages.push(total);
        }
    }

    return pages;
});

const clearSearch = () => {
    searchQuery.value = "";
    currentPage.value = 1;
};

const goToPage = (page) => {
    if (page !== "..." && page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
};

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
};

watch(searchQuery, () => {
    currentPage.value = 1;
});

const mount = async () => {
    try {
        await categoryStore.fetchCategories();
        console.log(categoryStore.categories);
        Loading.value = false;
    } catch (error) {
        console.error("Error loading categories:", error);
        Loading.value = false;
    }
};

mount();
</script>

<style scoped>
.glass-card-premium {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

@keyframes slide-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-in {
    animation: slide-in 0.6s ease-out forwards;
}

@keyframes pulse-slow {
    0% {
        transform: scale(1);
        opacity: 0.7;
    }
    50% {
        transform: scale(1.2);
        opacity: 1;
    }
    100% {
        transform: scale(1);
        opacity: 0.7;
    }
}

.animate-pulse-slow {
    animation: pulse-slow 4s ease-in-out infinite;
}

@keyframes float {
    0% {
        transform: translateY(0);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-15px);
        opacity: 1;
    }
    100% {
        transform: translateY(0);
        opacity: 0.6;
    }
}

@keyframes float-orb {
    0% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-20px) scale(1.1);
        opacity: 0.9;
    }
    100% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
}

@keyframes float-orb-delayed {
    0% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-30px) scale(1.15);
        opacity: 0.9;
    }
    100% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
}

@keyframes float-orb-slow {
    0% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-15px) scale(1.05);
        opacity: 0.8;
    }
    100% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
}

.particle-1 {
    animation: float 4s ease-in-out infinite;
}
.particle-2 {
    animation: float 4.5s ease-in-out infinite;
}
.particle-3 {
    animation: float 5s ease-in-out infinite;
}

/* Enhanced Professional Particle Animations */
.particle-1 {
    animation: float 3.5s ease-in-out infinite;
}
.particle-2 {
    animation: float 4s ease-in-out infinite;
}
.particle-3 {
    animation: float 4.5s ease-in-out infinite;
}
.particle-4 {
    animation: float 3.8s ease-in-out infinite;
}
.particle-5 {
    animation: float 4.2s ease-in-out infinite;
}

/* Glow Particle Animations */
.glow-particle-1 {
    animation: glow 4.5s ease-in-out infinite;
}
.glow-particle-2 {
    animation: glow 5s ease-in-out infinite;
}
.glow-particle-3 {
    animation: glow 4.8s ease-in-out infinite;
}

/* Enhanced Shadow Styles */
.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.shadow-3xl {
    box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
}

.shadow-xl {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Professional Card Enhancements */
.backdrop-blur-sm {
    backdrop-filter: blur(4px);
}

/* Enhanced Transition Effects */
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
}

.group:hover .group-hover\:-translate-y-3 {
    transform: translateY(-0.75rem);
}

/* Professional Loading Animation */
@keyframes shimmer {
    0% {
        background-position: -200px 0;
    }
    100% {
        background-position: calc(200px + 100%) 0;
    }
}

.animate-shimmer {
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.1),
        transparent
    );
    background-size: 200px 100%;
    animation: shimmer 2s infinite;
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

::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #8b5cf6, #3b82f6);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #7c3aed, #2563eb);
}

@media (max-width: 768px) {
    .glass-card-premium {
        backdrop-filter: blur(10px);
    }

    .text-5xl {
        font-size: 2.5rem;
    }

    .text-7xl {
        font-size: 3.5rem;
    }
}

button:focus,
a:focus,
input:focus {
    outline: 2px solid #8b5cf6;
    outline-offset: 2px;
}

.glass-card-premium:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

button:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

/* Card Grid Improvements */
@media (min-width: 1280px) {
    .grid-cols-1.sm\:grid-cols-2.lg\:grid-cols-3.xl\:grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

.container {
    max-width: 1200px;
}

input::placeholder {
    color: rgb(148 163 184);
}

input:focus::placeholder {
    color: rgb(100 116 139);
}

* {
    will-change: auto;
}

.group {
    will-change: transform;
}

@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }

    .animate-slide-in {
        animation: none;
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
