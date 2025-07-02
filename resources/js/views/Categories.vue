<template>
    <div :class="[
        'min-h-screen transition-colors duration-500',
        isDark
            ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-gray-900'
            : 'bg-gradient-to-br from-slate-100 via-blue-100 to-purple-100'
    ]">
        <!-- Static Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div :class="[
                'absolute top-20 left-10 w-72 h-72 rounded-full blur-3xl opacity-60',
                isDark ? 'bg-blue-600/10' : 'bg-blue-600/20'
            ]"></div>
            <div :class="[
                'absolute top-40 right-20 w-80 h-80 rounded-full blur-3xl opacity-50',
                isDark ? 'bg-purple-600/10' : 'bg-purple-600/20'
            ]"></div>
            <div :class="[
                'absolute bottom-20 left-1/3 w-60 h-60 rounded-full blur-3xl opacity-40',
                isDark ? 'bg-indigo-600/10' : 'bg-indigo-600/20'
            ]"></div>
        </div>

        <!-- Static Particles -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div :class="[
                'absolute top-1/4 left-1/4 w-2 h-2 rounded-full opacity-70',
                isDark ? 'bg-blue-400' : 'bg-blue-600'
            ]"></div>
            <div :class="[
                'absolute top-1/3 left-3/4 w-1.5 h-1.5 rounded-full opacity-60',
                isDark ? 'bg-purple-400' : 'bg-purple-600'
            ]"></div>
            <div :class="[
                'absolute top-2/3 left-1/6 w-2.5 h-2.5 rounded-full opacity-50',
                isDark ? 'bg-indigo-400' : 'bg-indigo-600'
            ]"></div>
        </div>

        <!-- Hero Section -->
        <section class="relative z-10 container mx-auto px-6 py-16 md:py-20">
            <div class="text-center max-w-4xl mx-auto animate-fade-in-up">
                <!-- Badge -->
                <div :class="[
                    'inline-flex items-center px-4 py-2 border rounded-full backdrop-blur-sm mb-6',
                    isDark
                        ? 'bg-gradient-to-r from-purple-500/20 to-blue-500/20 border-purple-500/30'
                        : 'bg-gradient-to-r from-purple-500/10 to-blue-500/10 border-purple-500/20'
                ]">
                    <span :class="[
                        'text-sm font-medium',
                        isDark ? 'text-purple-300' : 'text-purple-700'
                    ]">📚 Discover Your Path</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl md:text-6xl font-black leading-tight mb-4">
                    <span :class="[
                        'block bg-clip-text text-transparent',
                        isDark
                            ? 'bg-gradient-to-r from-white via-blue-100 to-purple-100'
                            : 'bg-gradient-to-r from-slate-900 via-blue-900 to-purple-900'
                    ]">
                        Explore Our
                    </span>
                    <span :class="[
                        'block bg-clip-text text-transparent',
                        isDark
                            ? 'bg-gradient-to-r from-purple-400 via-blue-400 to-indigo-400'
                            : 'bg-gradient-to-r from-purple-600 via-blue-600 to-indigo-600'
                    ]">
                        Categories
                    </span>
                </h1>

                <!-- Description -->
                <p :class="[
                    'text-lg md:text-xl max-w-2xl mx-auto leading-relaxed mb-6',
                    isDark ? 'text-slate-300' : 'text-slate-600'
                ]">
                    Choose from our diverse range of expertly curated categories and
                    <span :class="[
                        'font-semibold',
                        isDark ? 'text-purple-300' : 'text-purple-600'
                    ]">unlock your potential</span> in the skills that matter most.
                </p>

                <!-- Search Section -->
                <div class="max-w-2xl mx-auto mb-6">
                    <div class="relative group">
                        <!-- Search Icon -->
                        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none z-10">
                            <div :class="[
                                'p-2 rounded-lg backdrop-blur-sm border',
                                isDark
                                    ? 'bg-gradient-to-r from-purple-500/20 to-blue-500/20 border-purple-500/30'
                                    : 'bg-gradient-to-r from-purple-500/10 to-blue-500/10 border-purple-500/20'
                            ]">
                                <font-awesome-icon :icon="['fas', 'search']" :class="[
                                    'text-lg',
                                    isDark ? 'text-purple-400' : 'text-purple-600'
                                ]" />
                            </div>
                        </div>

                        <!-- Search Input -->
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Search categories, topics, skills..."
                            :class="[
                                'w-full pl-20 pr-16 py-5 backdrop-blur-lg border rounded-2xl focus:outline-none focus:shadow-lg transition-all duration-300 text-lg group-hover:border-purple-500/60',
                                isDark
                                    ? 'bg-white/10 border-white/20 text-white placeholder-slate-400 focus:border-purple-500/60 focus:bg-white/15 focus:shadow-purple-500/20 group-hover:bg-white/12 group-hover:border-white/30'
                                    : 'bg-white/50 border-slate-200/50 text-slate-900 placeholder-slate-500 focus:border-purple-500/60 focus:bg-white/70 focus:shadow-purple-500/20 group-hover:bg-white/60 group-hover:border-slate-300/50'
                            ]"
                        />

                        <!-- Clear Search Button -->
                        <button
                            v-if="searchQuery"
                            @click="clearSearch"
                            class="absolute inset-y-0 right-0 pr-6 flex items-center z-10"
                        >
                            <div class="p-2 bg-red-500/20 hover:bg-red-500/30 rounded-lg backdrop-blur-sm border border-red-500/30 hover:border-red-500/50 transition-all duration-200 group">
                                <font-awesome-icon :icon="['fas', 'times']" class="text-red-400 hover:text-red-300 transition-colors duration-200" />
                            </div>
                        </button>

                        <!-- Search Button (when no text) -->
                        <div v-else class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none">
                            <div :class="[
                                'p-2 rounded-lg backdrop-blur-sm border',
                                isDark
                                    ? 'bg-gradient-to-r from-purple-500/10 to-blue-500/10 border-purple-500/20'
                                    : 'bg-gradient-to-r from-purple-500/5 to-blue-500/5 border-purple-500/10'
                            ]">
                                <font-awesome-icon :icon="['fas', 'arrow-right']" :class="[
                                    'text-sm',
                                    isDark ? 'text-purple-300/60' : 'text-purple-600/60'
                                ]" />
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
                                'px-3 py-1.5 text-xs border rounded-full transition-all duration-200 backdrop-blur-sm',
                                isDark
                                    ? 'bg-white/5 hover:bg-white/10 border-white/10 hover:border-purple-500/30 text-slate-400 hover:text-purple-300'
                                    : 'bg-white/30 hover:bg-white/50 border-slate-200/50 hover:border-purple-500/30 text-slate-600 hover:text-purple-700'
                            ]"
                        >
                            {{ hint }}
                        </button>
                    </div>
                </div>

                <!-- Stats Row - Dynamic only -->
                <div class="flex flex-wrap justify-center gap-8 py-2">
                    <div class="text-center">
                        <div :class="[
                            'text-2xl font-bold',
                            isDark ? 'text-white' : 'text-slate-800'
                        ]">{{ filteredCategories?.length || 0 }}+</div>
                        <div :class="[
                            'text-sm',
                            isDark ? 'text-slate-400' : 'text-slate-600'
                        ]">{{ searchQuery ? 'Found' : 'Categories' }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Loading State -->
        <div v-if="Loading" class="container mx-auto px-6 py-20">
            <div class="text-center">
                <div :class="[
                    'inline-flex items-center space-x-3',
                    isDark ? 'text-slate-400' : 'text-slate-600'
                ]">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-500"></div>
                    <span class="text-lg">Loading amazing categories...</span>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <template v-else>
            <section class="relative z-10 container mx-auto px-6 py-8">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">
                        <span :class="[
                            'bg-clip-text text-transparent',
                            isDark
                                ? 'bg-gradient-to-r from-white to-slate-300'
                                : 'bg-gradient-to-r from-slate-900 to-slate-700'
                        ]">
                            {{ searchQuery ? `Search Results for "${searchQuery}"` : 'All Categories' }}
                        </span>
                    </h2>
                    <p :class="[
                        'text-lg max-w-2xl mx-auto',
                        isDark ? 'text-slate-400' : 'text-slate-600'
                    ]">
                        {{ searchQuery ? `Found ${filteredCategories.length} categories matching your search` : 'Start your learning journey in any field that interests you' }}
                    </p>
                </div>

                <!-- No Results Message -->
                <div v-if="filteredCategories.length === 0 && searchQuery" class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <font-awesome-icon :icon="['fas', 'search-minus']" :class="[
                            'text-5xl mb-4',
                            isDark ? 'text-slate-600' : 'text-slate-400'
                        ]" />
                        <h3 :class="[
                            'text-xl font-bold mb-3',
                            isDark ? 'text-white' : 'text-slate-800'
                        ]">No Categories Found</h3>
                        <p :class="[
                            'mb-4',
                            isDark ? 'text-slate-400' : 'text-slate-600'
                        ]">We couldn't find any categories matching "{{ searchQuery }}". Try a different search term.</p>
                        <button
                            @click="clearSearch"
                            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 rounded-xl font-semibold text-white transition-all duration-300 transform hover:scale-105"
                        >
                            Show All Categories
                        </button>
                    </div>
                </div>

                <!-- Categories Grid -->
                <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <router-link
                        v-for="category in paginatedCategories"
                        :key="category.id"
                        :to="`/courses?category=${category.id}`"
                        class="group block transform transition-all duration-500 hover:scale-[1.02] hover:-translate-y-1"
                    >
                        <div :class="[
                            'rounded-2xl overflow-hidden shadow-xl border h-full flex flex-col backdrop-blur-xl hover:shadow-purple-500/20 hover:border-purple-500/40 transition-all duration-500 relative',
                            isDark
                                ? 'glass-card-premium border-white/10'
                                : 'bg-white/50 border-slate-200/50 hover:bg-white/70'
                        ]">
                            <!-- Gradient Overlay for premium look -->
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 via-transparent to-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                            <!-- Image Section -->
                            <div class="relative overflow-hidden rounded-t-2xl">
                                <img
                                    :src="category.image_url"
                                    :alt="category.name"
                                    @error="$event.target.src = defaultImage"
                                    class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-500"
                                />
                                <!-- Dark overlay for better text readability -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

                                <!-- Course Count Badge -->
                                <div class="absolute top-3 right-3 bg-gradient-to-r from-purple-600/90 to-blue-600/90 backdrop-blur-sm text-white text-xs px-3 py-1.5 rounded-full font-bold border border-white/20 shadow-lg">
                                    {{ category.courses_count }} Courses
                                </div>

                                <!-- Popular Badge -->
                                <div v-if="category.courses_count > 10" class="absolute top-3 left-3 bg-gradient-to-r from-orange-500/90 to-red-500/90 backdrop-blur-sm text-white text-xs px-3 py-1 rounded-full font-bold shadow-lg animate-pulse">
                                    🔥 Popular
                                </div>

                                <!-- Category Icon Overlay -->
                                <div class="absolute bottom-3 left-3 p-2 bg-white/10 backdrop-blur-sm rounded-lg border border-white/20">
                                    <font-awesome-icon :icon="['fas', 'layer-group']" class="text-white text-sm" />
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-5 flex-1 flex flex-col justify-between relative z-10">
                                <div class="space-y-3">
                                    <!-- Category Name -->
                                    <h3 :class="[
                                        'text-lg font-bold transition-colors duration-300 line-clamp-2 leading-tight',
                                        isDark
                                            ? 'text-white group-hover:text-purple-300'
                                            : 'text-slate-800 group-hover:text-purple-600'
                                    ]">
                                        {{ category.name }}
                                    </h3>

                                    <!-- Description -->
                                    <p :class="[
                                        'leading-relaxed line-clamp-2 text-sm opacity-90',
                                        isDark ? 'text-slate-300' : 'text-slate-600'
                                    ]">
                                        {{ category.description }}
                                    </p>

                                    <!-- Category Stats -->
                                    <div class="flex items-center justify-between text-xs">
                                        <div class="flex items-center space-x-1.5">
                                            <div class="w-2 h-2 bg-purple-400 rounded-full"></div>
                                            <span :class="[
                                                isDark ? 'text-slate-400' : 'text-slate-500'
                                            ]">Category</span>
                                        </div>
                                        <div class="flex items-center space-x-1.5">
                                            <font-awesome-icon :icon="['fas', 'users']" :class="[
                                                'text-xs',
                                                isDark ? 'text-blue-400' : 'text-blue-600'
                                            ]" />
                                            <span :class="[
                                                isDark ? 'text-slate-400' : 'text-slate-500'
                                            ]">{{ category.courses_count }} courses</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-4">
                                    <div :class="[
                                        'w-full py-2 px-4 rounded-lg text-center text-sm font-semibold transition-all duration-300 transform group-hover:scale-105',
                                        isDark
                                            ? 'bg-gradient-to-r from-purple-600/20 to-blue-600/20 text-purple-300 group-hover:from-purple-600/30 group-hover:to-blue-600/30'
                                            : 'bg-gradient-to-r from-purple-600/10 to-blue-600/10 text-purple-700 group-hover:from-purple-600/20 group-hover:to-blue-600/20'
                                    ]">
                                        Explore Category
                                    </div>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </div>

                <!-- Pagination -->
                <div class="mt-16 flex justify-center">
                    <div :class="[
                        'p-4 rounded-2xl shadow-2xl border',
                        isDark
                            ? 'glass-card-premium border-white/20'
                            : 'bg-white/50 border-slate-200/50'
                    ]">
                        <nav class="flex items-center gap-2">
                            <!-- Previous Button -->
                            <button
                                @click="goToPage(currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-xl hover:from-purple-500 hover:to-blue-500 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 shadow-lg"
                            >
                                <font-awesome-icon icon="chevron-left" class="text-sm group-hover:-translate-x-1 transition-transform duration-300" />
                                <span class="font-medium">Previous</span>
                            </button>

                            <!-- Page numbers -->
                            <div class="flex items-center gap-1 mx-4">
                                <button
                                    v-for="page in visiblePages"
                                    :key="page"
                                    @click="goToPage(page)"
                                    :class="[
                                        'w-12 h-12 rounded-xl flex items-center justify-center font-semibold transition-all duration-300 hover:scale-105',
                                        {
                                            'bg-gradient-to-r from-purple-600 to-blue-600 text-white shadow-lg': currentPage === page,
                                            'hover:bg-white/10': currentPage !== page
                                        },
                                        currentPage !== page && (isDark ? 'text-slate-400 hover:text-white' : 'text-slate-600 hover:text-slate-800')
                                    ]"
                                >
                                    {{ page }}
                                </button>
                            </div>

                            <!-- Next Button -->
                            <button
                                @click="goToPage(currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:from-blue-500 hover:to-purple-500 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 shadow-lg"
                            >
                                <span class="font-medium">Next</span>
                                <font-awesome-icon icon="chevron-right" class="text-sm group-hover:translate-x-1 transition-transform duration-300" />
                            </button>
                        </nav>
                    </div>
                </div>
            </section>
        </template>

        <!-- Footer Enhancement -->
        <footer class="mt-16 border-t border-white/10 bg-black/50 backdrop-blur-sm relative z-10">
            <div class="container mx-auto px-6 py-8">
                <div class="text-center text-slate-400">
                    <p class="text-base mb-2">
                        Made with <span class="text-red-500">❤️</span> by EduStream Team
                    </p>
                    <p class="text-sm">
                        © 2024 EduStream. Empowering learners worldwide.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { useCategoryStore } from '../stores/CategoryStore';
import { ref, computed, watch } from 'vue';
import defaultImage from '@/assets/icons/EduStream.jpg';
import { useTheme } from '../composables/useTheme';

library.add(fas)

const categoryStore = useCategoryStore();
const { isDark } = useTheme();
const Loading = ref(true);
const searchQuery = ref('');
const currentPage = ref(1);
const categoriesPerPage = 12;

// Search hints for better UX
const searchHints = ref(['Programming', 'Design', 'Business', 'Marketing', 'Art', 'Science']);

// Computed properties
const filteredCategories = computed(() => {
    if (!categoryStore.categories) return [];

    if (!searchQuery.value.trim()) {
        return categoryStore.categories;
    }

    const query = searchQuery.value.toLowerCase().trim();
    return categoryStore.categories.filter(category =>
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
            pages.push('...');
            pages.push(total);
        } else if (current >= total - 3) {
            pages.push(1);
            pages.push('...');
            for (let i = total - 4; i <= total; i++) {
                pages.push(i);
            }
        } else {
            pages.push(1);
            pages.push('...');
            for (let i = current - 1; i <= current + 1; i++) {
                pages.push(i);
            }
            pages.push('...');
            pages.push(total);
        }
    }

    return pages;
});

const clearSearch = () => {
    searchQuery.value = '';
    currentPage.value = 1;
};

const goToPage = (page) => {
    if (page !== '...' && page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const previousPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
        window.scrollTo({ top: 0, behavior: 'smooth' });
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
        console.error('Error loading categories:', error);
        Loading.value = false;
    }
}

mount();
</script>

<style scoped>
.glass-card-premium {
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow:
        0 8px 32px rgba(0, 0, 0, 0.3),
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

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
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

.group:hover .group-hover\:scale-105 {
    transform: scale(1.05);
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
    box-shadow:
        0 15px 35px rgba(0, 0, 0, 0.4),
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

    .animate-fade-in-up {
        animation: none;
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
