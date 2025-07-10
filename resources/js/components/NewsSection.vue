<template>
  <section class="py-16">
    <div class="container mx-auto px-6">
      <!-- Section Header -->
      <div class="text-center mb-12">
        <h2
          :class="
            isDark
              ? 'text-4xl md:text-5xl font-bold text-white mb-4'
              : 'text-4xl md:text-5xl font-bold text-slate-900 mb-4'
          "
        >
          Latest News
        </h2>
        <p
          :class="
            isDark
              ? 'text-xl text-slate-300 max-w-2xl mx-auto'
              : 'text-xl text-slate-600 max-w-2xl mx-auto'
          "
        >
          Stay updated with the latest developments in education and technology
        </p>
      </div>

      <!-- News Grid -->
      <div class="grid lg:grid-cols-3 gap-8">
        <!-- Sidebar News List -->
        <div class="lg:col-span-1 h-[580px]">
          <div
            :class="
              isDark
                ? 'bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 shadow-xl h-full overflow-hidden'
                : 'bg-white rounded-2xl p-6 shadow-xl border border-slate-200 h-full overflow-hidden'
            "
          >
            <h4
              :class="
                isDark
                  ? 'text-xl font-bold text-white mb-6'
                  : 'text-xl font-bold text-slate-900 mb-6'
              "
            >
              Recent News
            </h4>

            <div class="relative flex-1 min-h-0 overflow-hidden">
              <!-- Desktop Slider -->
              <div
                v-if="!isMobile"
                class="h-full transition-transform duration-500 ease-in-out"
                :style="{ transform: `translateY(-${currentSlide * slideHeight}px)` }"
              >
                <div
                  v-for="news in recentNews"
                  :key="news.id"
                  @click="setFeaturedNews(news)"
                  :class="
                    isDark
                      ? 'cursor-pointer p-4 rounded-xl border border-white/10 hover:bg-white/10 hover:border-teal-500/30 transition-all duration-300 transform hover:scale-105 mb-5'
                      : 'cursor-pointer p-4 rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-teal-300 transition-all duration-300 transform hover:scale-105 mb-5'
                  "
                  :style="{
                    borderColor:
                      featuredNews.id === news.id
                        ? isDark
                          ? 'rgba(20, 184, 166, 0.5)'
                          : 'rgba(20, 184, 166, 0.3)'
                        : undefined,
                    boxShadow:
                      featuredNews.id === news.id
                        ? isDark
                          ? '0 0 20px rgba(20, 184, 166, 0.3)'
                          : '0 0 20px rgba(20, 184, 166, 0.2)'
                        : undefined,
                    height: '150px',
                  }"
                >
                  <!-- News Item -->
                  <div class="flex space-x-3 h-full">
                    <!-- Thumbnail -->
                    <div class="flex-shrink-0">
                      <img
                        :src="news.image"
                        :alt="news.title"
                        class="w-16 h-16 rounded-lg object-cover transition-transform duration-300 hover:scale-110"
                      />
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                      <h5
                        :class="
                          isDark
                            ? 'text-sm font-semibold text-white line-clamp-2 mb-1'
                            : 'text-sm font-semibold text-slate-900 line-clamp-2 mb-1'
                        "
                      >
                        {{ news.title }}
                      </h5>

                      <p
                        :class="
                          isDark
                            ? 'text-xs text-slate-400 line-clamp-2'
                            : 'text-xs text-slate-600 line-clamp-2'
                        "
                      >
                        {{ news.excerpt }}
                      </p>

                      <div class="flex items-center justify-between mt-2">
                        <span
                          :class="
                            isDark ? 'text-xs text-slate-500' : 'text-xs text-slate-500'
                          "
                        >
                          {{ formatDate(news.date) }}
                        </span>

                        <span
                          :class="
                            isDark
                              ? 'text-xs px-2 py-1 bg-teal-500/20 text-teal-300 rounded-full'
                              : 'text-xs px-2 py-1 bg-teal-100 text-teal-700 rounded-full'
                          "
                        >
                          {{ news.category }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Mobile Scrollable List -->
              <div
                v-else
                class="h-full overflow-y-auto scrollbar-hide"
                @touchstart="handleTouchStart"
                @touchmove="handleTouchMove"
                @touchend="handleTouchEnd"
              >
                <div
                  v-for="news in recentNews"
                  :key="news.id"
                  @click="setFeaturedNews(news)"
                  :class="
                    isDark
                      ? 'cursor-pointer p-4 rounded-xl border border-white/10 hover:bg-white/10 hover:border-teal-500/30 transition-all duration-300 mb-4'
                      : 'cursor-pointer p-4 rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-teal-300 transition-all duration-300 mb-4'
                  "
                  :style="{
                    borderColor:
                      featuredNews.id === news.id
                        ? isDark
                          ? 'rgba(20, 184, 166, 0.5)'
                          : 'rgba(20, 184, 166, 0.3)'
                        : undefined,
                    boxShadow:
                      featuredNews.id === news.id
                        ? isDark
                          ? '0 0 20px rgba(20, 184, 166, 0.3)'
                          : '0 0 20px rgba(20, 184, 166, 0.2)'
                        : undefined,
                  }"
                >
                  <!-- News Item -->
                  <div class="flex space-x-3">
                    <!-- Thumbnail -->
                    <div class="flex-shrink-0">
                      <img
                        :src="news.image"
                        :alt="news.title"
                        class="w-16 h-16 rounded-lg object-cover"
                      />
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                      <h5
                        :class="
                          isDark
                            ? 'text-sm font-semibold text-white line-clamp-2 mb-1'
                            : 'text-sm font-semibold text-slate-900 line-clamp-2 mb-1'
                        "
                      >
                        {{ news.title }}
                      </h5>

                      <p
                        :class="
                          isDark
                            ? 'text-xs text-slate-400 line-clamp-2'
                            : 'text-xs text-slate-600 line-clamp-2'
                        "
                      >
                        {{ news.excerpt }}
                      </p>

                      <div class="flex items-center justify-between mt-2">
                        <span
                          :class="
                            isDark ? 'text-xs text-slate-500' : 'text-xs text-slate-500'
                          "
                        >
                          {{ formatDate(news.date) }}
                        </span>

                        <span
                          :class="
                            isDark
                              ? 'text-xs px-2 py-1 bg-teal-500/20 text-teal-300 rounded-full'
                              : 'text-xs px-2 py-1 bg-teal-100 text-teal-700 rounded-full'
                          "
                        >
                          {{ news.category }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Desktop Navigation Controls -->
              <div
                v-if="!isMobile"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 flex flex-col space-y-2"
              >
                <!-- Up Button -->
                <button
                  @click="previousSlide"
                  :disabled="currentSlide === 0"
                  :class="
                    currentSlide === 0
                      ? 'opacity-50 cursor-not-allowed'
                      : 'hover:bg-teal-500 hover:text-white'
                  "
                  class="w-8 h-8 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center transition-all duration-300"
                >
                  <i class="fas fa-chevron-up text-xs"></i>
                </button>

                <!-- Down Button -->
                <button
                  @click="nextSlide"
                  :disabled="currentSlide >= maxSlides"
                  :class="
                    currentSlide >= maxSlides
                      ? 'opacity-50 cursor-not-allowed'
                      : 'hover:bg-teal-500 hover:text-white'
                  "
                  class="w-8 h-8 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center transition-all duration-300"
                >
                  <i class="fas fa-chevron-down text-xs"></i>
                </button>
              </div>

              <!-- Desktop Progress Indicator -->
              <div
                v-if="!isMobile"
                class="absolute bottom-4 left-1/2 transform -translate-x-1/2"
              >
                <div class="flex space-x-1">
                  <div
                    v-for="(_, index) in recentNews"
                    :key="index"
                    @click="goToSlide(index)"
                    :class="
                      index === currentSlide
                        ? 'bg-teal-500'
                        : isDark
                        ? 'bg-white/30'
                        : 'bg-slate-300'
                    "
                    class="w-2 h-2 rounded-full cursor-pointer transition-all duration-300 hover:bg-teal-400"
                  ></div>
                </div>
              </div>
            </div>

            <!-- View All News Button -->
            <div class="mt-6 pt-6 border-t border-slate-200 dark:border-white/10">
              <router-link
                to="/news"
                :class="
                  isDark
                    ? 'block w-full text-center py-3 px-4 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-300'
                    : 'block w-full text-center py-3 px-4 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-300'
                "
              >
                View All News
              </router-link>
            </div>
          </div>
        </div>

        <!-- Main Featured News Card -->
        <div class="lg:col-span-2">
          <div
            :class="
              isDark
                ? 'bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500 h-[580px]'
                : 'bg-white rounded-2xl overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500 border border-slate-200 h-[580px]'
            "
          >
            <!-- Featured Image with Swiper -->
            <div class="relative h-80 overflow-hidden">
              <swiper
                :modules="[SwiperAutoplay, SwiperPagination, SwiperNavigation]"
                :slides-per-view="1"
                :loop="true"
                :autoplay="{
                  delay: 6000,
                  disableOnInteraction: false,
                }"
                :pagination="{ clickable: true }"
                :navigation="true"
                class="h-full"
              >
                <swiper-slide v-for="(image, index) in featuredNewsImages" :key="index">
                  <img
                    :src="image"
                    :alt="`${featuredNews.title} - Image ${index + 1}`"
                    class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                  />
                </swiper-slide>
              </swiper>
              <div
                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"
              ></div>

              <!-- Category Badge -->
              <div class="absolute top-4 left-4 z-10">
                <span
                  :class="
                    isDark
                      ? 'bg-teal-500/90 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm'
                      : 'bg-teal-500 text-white px-3 py-1 rounded-full text-sm font-medium'
                  "
                >
                  {{ featuredNews.category }}
                </span>
              </div>

              <!-- Date Badge -->
              <div class="absolute top-4 right-4 z-10">
                <span
                  :class="
                    isDark
                      ? 'bg-black/50 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm'
                      : 'bg-white/90 text-slate-800 px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm'
                  "
                >
                  {{ formatDate(featuredNews.date) }}
                </span>
              </div>
            </div>

            <!-- Content -->
            <div class="p-8">
              <h3
                :class="
                  isDark
                    ? 'text-2xl font-bold text-white mb-4 line-clamp-2'
                    : 'text-2xl font-bold text-slate-900 mb-4 line-clamp-2'
                "
              >
                {{ featuredNews.title }}
              </h3>

              <p
                :class="
                  isDark
                    ? 'text-slate-300 mb-6 line-clamp-3'
                    : 'text-slate-600 mb-6 line-clamp-3'
                "
              >
                {{ featuredNews.excerpt }}
              </p>

              <!-- Author and Read More -->
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <img
                    :src="featuredNews.author.avatar"
                    :alt="featuredNews.author.name"
                    class="w-10 h-10 rounded-full object-cover"
                  />
                  <div>
                    <p
                      :class="
                        isDark
                          ? 'text-sm font-medium text-white'
                          : 'text-sm font-medium text-slate-900'
                      "
                    >
                      {{ featuredNews.author.name }}
                    </p>
                    <p
                      :class="
                        isDark ? 'text-xs text-slate-400' : 'text-xs text-slate-500'
                      "
                    >
                      {{ featuredNews.author.role }}
                    </p>
                  </div>
                </div>

                <router-link
                  :to="`/news/${featuredNews.id}`"
                  :class="
                    isDark
                      ? 'inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-300'
                      : 'inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-300'
                  "
                >
                  Read More
                  <font-awesome-icon icon="arrow-right" class="ml-2 text-sm" />
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { useTheme } from "../composables/useTheme";

const { isDark } = useTheme();

// Fake news data
const newsData = [
  {
    id: 1,
    title: "New AI-Powered Learning Platform Launches at CTU",
    excerpt:
      "Revolutionary artificial intelligence technology is now integrated into our educational platform, providing personalized learning experiences for every student.",
    content:
      "The CTU Educational Platform has taken a giant leap forward with the introduction of our new AI-powered learning system. This revolutionary technology analyzes each student's learning patterns, strengths, and areas for improvement to create truly personalized educational experiences. The AI system adapts in real-time, providing targeted recommendations, adaptive assessments, and intelligent content curation that matches each learner's unique needs and pace.",
    image:
      "https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop",
    category: "Technology",
    date: "2024-01-15",
    author: {
      name: "Dr. Sarah Johnson",
      role: "Head of Technology",
      avatar:
        "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100&h=100&fit=crop&crop=face",
    },
  },
  {
    id: 2,
    title: "Record-Breaking Student Enrollment for Spring Semester",
    excerpt:
      "CTU celebrates unprecedented growth with over 50,000 students enrolled across all programs, marking a 25% increase from last year.",
    content:
      "The Spring 2024 semester has brought unprecedented success to CTU Educational Platform with a record-breaking enrollment of over 50,000 students. This represents a remarkable 25% increase from the previous year, demonstrating the growing trust and recognition of our platform's quality education. The surge in enrollment spans across all our programs, with particular growth in technology, business, and creative arts courses.",
    image:
      "https://images.unsplash.com/photo-1523240794102-9ebd0b167d56?w=800&h=600&fit=crop",
    category: "Education",
    date: "2024-01-12",
    author: {
      name: "Prof. Michael Chen",
      role: "Dean of Admissions",
      avatar:
        "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face",
    },
  },
  {
    id: 3,
    title: "Partnership Announced with Leading Tech Companies",
    excerpt:
      "Strategic collaboration with Google, Microsoft, and Amazon to provide industry-relevant curriculum and internship opportunities for students.",
    content:
      "CTU Educational Platform is proud to announce groundbreaking partnerships with industry leaders Google, Microsoft, and Amazon. These strategic collaborations will bring cutting-edge curriculum directly from the tech industry to our students, ensuring they learn the most current and relevant skills. The partnerships also include exclusive internship opportunities, mentorship programs, and direct pathways to employment at these prestigious companies.",
    image:
      "https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop",
    category: "Partnerships",
    date: "2024-01-10",
    author: {
      name: "Lisa Rodriguez",
      role: "Partnership Director",
      avatar:
        "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face",
    },
  },
  {
    id: 4,
    title: "New Mobile App Enhances Learning Experience",
    excerpt:
      "Students can now access courses, submit assignments, and participate in discussions seamlessly from their mobile devices.",
    content:
      "Learning just got more convenient with the launch of our new mobile application. The CTU mobile app provides students with seamless access to all platform features, including course content, assignment submissions, discussion forums, and real-time notifications. The app features an intuitive interface designed specifically for mobile learning, with offline capabilities for course materials and progress tracking across all devices.",
    image:
      "https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=600&fit=crop",
    category: "Technology",
    date: "2024-01-08",
    author: {
      name: "Alex Thompson",
      role: "Mobile Development Lead",
      avatar:
        "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face",
    },
  },
  {
    id: 5,
    title: "Student Success Stories: From Beginner to Industry Expert",
    excerpt:
      "Meet the inspiring journey of students who transformed their careers through CTU's comprehensive learning programs.",
    content:
      "Success stories from our platform continue to inspire and motivate. This month, we highlight several remarkable transformations where students went from complete beginners to industry experts. These stories showcase the power of dedicated learning, quality instruction, and the comprehensive support system that CTU provides. From career changers to skill upgraders, our platform has been the catalyst for countless professional transformations.",
    image:
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop",
    category: "Success Stories",
    date: "2024-01-05",
    author: {
      name: "Emma Wilson",
      role: "Student Success Manager",
      avatar:
        "https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&h=100&fit=crop&crop=face",
    },
  },
  {
    id: 6,
    title: "New Course Categories Added to Platform",
    excerpt:
      "Expanding our curriculum with cutting-edge courses in blockchain, cybersecurity, and sustainable development.",
    content:
      "CTU Educational Platform is expanding its course offerings with three exciting new categories: Blockchain Technology, Cybersecurity, and Sustainable Development. These additions reflect the growing demand for skills in emerging fields and our commitment to providing education that prepares students for the future job market. Each category features expert instructors, hands-on projects, and industry-recognized certifications.",
    image:
      "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop",
    category: "Curriculum",
    date: "2024-01-03",
    author: {
      name: "Dr. James Miller",
      role: "Curriculum Director",
      avatar:
        "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=face",
    },
  },
];

const featuredNews = ref(newsData[0]);
const recentNews = ref(newsData.slice(1, 7)); // Top 6 recent news (excluding featured)
let autoSlideInterval;

// Mobile detection
const isMobile = ref(false);

// Custom slider variables
const currentSlide = ref(0);
const slideHeight = 170; // Height of each news item + margin (580px / 3 items ≈ 193px, accounting for spacing)
const maxSlides = computed(() => Math.max(0, recentNews.value.length - 3)); // Show 3 items at a time

// Touch handling variables
const touchStartY = ref(0);
const touchEndY = ref(0);
const minSwipeDistance = 50;

// Get featured news images for swiper
const featuredNewsImages = computed(() => {
  if (!featuredNews.value) return [];
  // For now, use the main image as the only image
  // Later this can be replaced with actual images array from backend
  return [featuredNews.value.image];
});

// Function to set featured news
const setFeaturedNews = (news) => {
  featuredNews.value = news;
  // Reset auto-slide timer
  resetAutoSlide();
};

// Custom slider functions
const nextSlide = () => {
  if (currentSlide.value < maxSlides.value) {
    currentSlide.value++;
  }
};

const previousSlide = () => {
  if (currentSlide.value > 0) {
    currentSlide.value--;
  }
};

const goToSlide = (index) => {
  currentSlide.value = index;
};

// Function to auto-slide to next news
const autoSlideNext = () => {
  const currentIndex = recentNews.value.findIndex(
    (news) => news.id === featuredNews.value.id
  );
  const nextIndex = (currentIndex + 1) % recentNews.value.length;
  setFeaturedNews(recentNews.value[nextIndex]);

  // Also update the sidebar slider
  if (nextIndex > currentSlide.value + 2) {
    currentSlide.value = Math.min(nextIndex - 2, maxSlides.value);
  }
};

// Function to reset auto-slide timer
const resetAutoSlide = () => {
  if (autoSlideInterval) {
    clearInterval(autoSlideInterval);
  }
  autoSlideInterval = setInterval(autoSlideNext, 8000); // Auto-slide every 8 seconds
};

// Format date function
const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString("en-US", {
    year: "numeric",
    month: "short",
    day: "numeric",
  });
};

// Start auto-sliding on mount
onMounted(() => {
  resetAutoSlide();
});

// Cleanup on unmount
onUnmounted(() => {
  if (autoSlideInterval) {
    clearInterval(autoSlideInterval);
  }
});
</script>

<style scoped>
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

.shadow-3xl {
  box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
}

/* Custom slider styles */
.news-slider-container {
  overflow: hidden;
}

.news-slider-track {
  transition: transform 0.5s ease-in-out;
}

/* Navigation button styles */
.nav-button {
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
}

.nav-button:hover:not(:disabled) {
  transform: scale(1.1);
}

.nav-button:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

/* Progress indicator styles */
.progress-dot {
  transition: all 0.3s ease;
}

.progress-dot:hover {
  transform: scale(1.2);
}
</style>
