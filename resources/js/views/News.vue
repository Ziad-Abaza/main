<template>
  <div
    :class="
      isDark
        ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
        : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
    "
  >
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
      <!-- Background Elements -->
      <div class="absolute inset-0">
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
      </div>

      <div class="container mx-auto px-6 relative z-10">
        <div class="text-center">
          <h1
            :class="
              isDark
                ? 'text-5xl md:text-7xl font-black leading-tight mb-6'
                : 'text-5xl md:text-7xl font-black leading-tight mb-6'
            "
          >
            <span
              :class="
                isDark
                  ? 'block bg-gradient-to-r from-white via-teal-100 to-cyan-100 bg-clip-text text-transparent'
                  : 'block bg-gradient-to-r from-slate-900 via-teal-800 to-cyan-800 bg-clip-text text-transparent'
              "
            >
              Latest News
            </span>
            <span
              :class="
                isDark
                  ? 'block bg-gradient-to-r from-teal-400 via-cyan-400 to-purple-400 bg-clip-text text-transparent'
                  : 'block bg-gradient-to-r from-slate-900 via-teal-800 to-purple-800 bg-clip-text text-transparent'
              "
            >
              & Updates
            </span>
          </h1>
          <p
            :class="
              isDark
                ? 'text-xl md:text-2xl text-slate-200 max-w-3xl mx-auto leading-relaxed'
                : 'text-xl md:text-2xl text-slate-700 max-w-3xl mx-auto leading-relaxed'
            "
          >
            Stay informed with the latest developments in education, technology, and industry insights
          </p>
        </div>
      </div>
    </section>

    <!-- Featured News Article -->
    <section class="py-16">
      <div class="container mx-auto px-6">
        <div class="mb-12">
          <h2
            :class="
              isDark
                ? 'text-3xl md:text-4xl font-bold text-white mb-4'
                : 'text-3xl md:text-4xl font-bold text-slate-900 mb-4'
            "
          >
            Featured Article
          </h2>
        </div>

        <!-- Featured News Card -->
        <div
          :class="
            isDark
              ? 'bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl overflow-hidden shadow-2xl'
              : 'bg-white rounded-3xl overflow-hidden shadow-2xl border border-slate-200'
          "
        >
          <!-- Image Swiper -->
          <div class="relative h-96 md:h-[500px]">
            <swiper
              :modules="[SwiperAutoplay, SwiperPagination, SwiperNavigation]"
              :slides-per-view="1"
              :loop="true"
              :autoplay="{
                delay: 5000,
                disableOnInteraction: false,
              }"
              :pagination="{ clickable: true }"
              :navigation="true"
              class="h-full"
            >
              <swiper-slide v-for="(image, index) in featuredNews.images" :key="index">
                <img
                  :src="image"
                  :alt="`${featuredNews.title} - Image ${index + 1}`"
                  class="w-full h-full object-cover"
                />
              </swiper-slide>
            </swiper>

            <!-- Category Badge -->
            <div class="absolute top-6 left-6 z-10">
              <span
                :class="
                  isDark
                    ? 'bg-teal-500/90 text-white px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm'
                    : 'bg-teal-500 text-white px-4 py-2 rounded-full text-sm font-medium'
                "
              >
                {{ featuredNews.category }}
              </span>
            </div>

            <!-- Date Badge -->
            <div class="absolute top-6 right-6 z-10">
              <span
                :class="
                  isDark
                    ? 'bg-black/50 text-white px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm'
                    : 'bg-white/90 text-slate-800 px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm'
                "
              >
                {{ formatDate(featuredNews.date) }}
              </span>
            </div>
          </div>

          <!-- Content -->
          <div class="p-8 md:p-12">
            <h3
              :class="
                isDark
                  ? 'text-3xl md:text-4xl font-bold text-white mb-6'
                  : 'text-3xl md:text-4xl font-bold text-slate-900 mb-6'
              "
            >
              {{ featuredNews.title }}
            </h3>

            <!-- Author Info -->
            <div class="flex items-center space-x-4 mb-8">
              <img
                :src="featuredNews.author.avatar"
                :alt="featuredNews.author.name"
                class="w-16 h-16 rounded-full object-cover"
              />
              <div>
                <p
                  :class="
                    isDark
                      ? 'text-lg font-semibold text-white'
                      : 'text-lg font-semibold text-slate-900'
                  "
                >
                  {{ featuredNews.author.name }}
                </p>
                <p
                  :class="
                    isDark
                      ? 'text-slate-400'
                      : 'text-slate-600'
                  "
                >
                  {{ featuredNews.author.role }}
                </p>
              </div>
            </div>

            <!-- Article Content -->
            <div
              :class="
                isDark
                  ? 'prose prose-lg prose-invert max-w-none'
                  : 'prose prose-lg max-w-none'
              "
            >
              <p class="text-lg leading-relaxed mb-6">
                {{ featuredNews.content }}
              </p>

              <p class="text-lg leading-relaxed mb-6">
                The integration of artificial intelligence into educational platforms represents a paradigm shift in how we approach learning. By leveraging machine learning algorithms and data analytics, we can now provide truly personalized educational experiences that adapt to each student's unique learning style, pace, and preferences.
              </p>

              <p class="text-lg leading-relaxed mb-6">
                This technology enables us to identify knowledge gaps, suggest relevant content, and provide real-time feedback that helps students stay engaged and motivated throughout their learning journey. The AI system continuously learns from student interactions, improving its recommendations and making the learning experience more effective over time.
              </p>

              <h4
                :class="
                  isDark
                    ? 'text-2xl font-bold text-white mt-8 mb-4'
                    : 'text-2xl font-bold text-slate-900 mt-8 mb-4'
                "
              >
                Key Benefits of AI-Powered Learning
              </h4>

              <ul class="space-y-3 mb-6">
                <li class="flex items-start space-x-3">
                  <span
                    :class="
                      isDark
                        ? 'text-teal-400 text-xl'
                        : 'text-teal-600 text-xl'
                    "
                  >
                    ✓
                  </span>
                  <span
                    :class="
                      isDark
                        ? 'text-slate-300'
                        : 'text-slate-700'
                    "
                  >
                    Personalized learning paths tailored to individual needs
                  </span>
                </li>
                <li class="flex items-start space-x-3">
                  <span
                    :class="
                      isDark
                        ? 'text-teal-400 text-xl'
                        : 'text-teal-600 text-xl'
                    "
                  >
                    ✓
                  </span>
                  <span
                    :class="
                      isDark
                        ? 'text-slate-300'
                        : 'text-slate-700'
                    "
                  >
                    Real-time progress tracking and performance analytics
                  </span>
                </li>
                <li class="flex items-start space-x-3">
                  <span
                    :class="
                      isDark
                        ? 'text-teal-400 text-xl'
                        : 'text-teal-600 text-xl'
                    "
                  >
                    ✓
                  </span>
                  <span
                    :class="
                      isDark
                        ? 'text-slate-300'
                        : 'text-slate-700'
                    "
                  >
                    Adaptive assessments that adjust difficulty based on performance
                  </span>
                </li>
                <li class="flex items-start space-x-3">
                  <span
                    :class="
                      isDark
                        ? 'text-teal-400 text-xl'
                        : 'text-teal-600 text-xl'
                    "
                  >
                    ✓
                  </span>
                  <span
                    :class="
                      isDark
                        ? 'text-slate-300'
                        : 'text-slate-700'
                    "
                  >
                    Intelligent content recommendations and resource suggestions
                  </span>
                </li>
              </ul>

              <p class="text-lg leading-relaxed">
                As we continue to develop and refine our AI-powered learning platform, we remain committed to maintaining the human element that makes education truly meaningful. Our technology serves as a powerful tool to enhance the learning experience, but it's the combination of cutting-edge technology and expert human guidance that creates the most effective educational environment.
              </p>
            </div>

            <!-- Tags -->
            <div class="flex flex-wrap gap-2 mt-8 pt-8 border-t border-slate-200 dark:border-white/10">
              <span
                v-for="tag in featuredNews.tags"
                :key="tag"
                :class="
                  isDark
                    ? 'px-3 py-1 bg-teal-500/20 text-teal-300 rounded-full text-sm'
                    : 'px-3 py-1 bg-teal-100 text-teal-700 rounded-full text-sm'
                "
              >
                #{{ tag }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- All News Grid -->
    <section class="py-16">
      <div class="container mx-auto px-6">
        <div class="mb-12">
          <h2
            :class="
              isDark
                ? 'text-3xl md:text-4xl font-bold text-white mb-4'
                : 'text-3xl md:text-4xl font-bold text-slate-900 mb-4'
            "
          >
            All News Articles
          </h2>
        </div>

        <!-- News Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="news in allNews"
            :key="news.id"
            :class="
              isDark
                ? 'bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2'
                : 'bg-white rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-slate-200'
            "
          >
            <!-- News Image -->
            <div class="relative h-48 overflow-hidden">
              <img
                :src="news.image"
                :alt="news.title"
                class="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

              <!-- Category Badge -->
              <div class="absolute top-4 left-4">
                <span
                  :class="
                    isDark
                      ? 'bg-teal-500/90 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm'
                      : 'bg-teal-500 text-white px-3 py-1 rounded-full text-sm font-medium'
                  "
                >
                  {{ news.category }}
                </span>
              </div>

              <!-- Date Badge -->
              <div class="absolute top-4 right-4">
                <span
                  :class="
                    isDark
                      ? 'bg-black/50 text-white px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm'
                      : 'bg-white/90 text-slate-800 px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm'
                  "
                >
                  {{ formatDate(news.date) }}
                </span>
              </div>
            </div>

            <!-- Content -->
            <div class="p-6">
              <h3
                :class="
                  isDark
                    ? 'text-xl font-bold text-white mb-3 line-clamp-2'
                    : 'text-xl font-bold text-slate-900 mb-3 line-clamp-2'
                "
              >
                {{ news.title }}
              </h3>

              <p
                :class="
                  isDark
                    ? 'text-slate-300 mb-4 line-clamp-3'
                    : 'text-slate-600 mb-4 line-clamp-3'
                "
              >
                {{ news.excerpt }}
              </p>

              <!-- Author -->
              <div class="flex items-center space-x-3 mb-4">
                <img
                  :src="news.author.avatar"
                  :alt="news.author.name"
                  class="w-8 h-8 rounded-full object-cover"
                />
                <div>
                  <p
                    :class="
                      isDark
                        ? 'text-sm font-medium text-white'
                        : 'text-sm font-medium text-slate-900'
                    "
                  >
                    {{ news.author.name }}
                  </p>
                  <p
                    :class="
                      isDark
                        ? 'text-xs text-slate-400'
                        : 'text-xs text-slate-500'
                    "
                  >
                    {{ news.author.role }}
                  </p>
                </div>
              </div>

              <!-- Read More Button -->
              <router-link
                :to="`/news/${news.id}`"
                :class="
                  isDark
                    ? 'inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-300'
                    : 'inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-300'
                "
              >
                Read More
                <font-awesome-icon
                  icon="arrow-right"
                  class="ml-2 text-sm"
                />
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useTheme } from '../composables/useTheme';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faArrowRight } from '@fortawesome/free-solid-svg-icons';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

library.add(faArrowRight);

const { isDark } = useTheme();

// Swiper modules
const SwiperAutoplay = Autoplay;
const SwiperPagination = Pagination;
const SwiperNavigation = Navigation;

// Enhanced fake news data with multiple images for swiper
const newsData = [
  {
    id: 1,
    title: "New AI-Powered Learning Platform Launches at CTU",
    excerpt: "Revolutionary artificial intelligence technology is now integrated into our educational platform, providing personalized learning experiences for every student.",
    content: "The CTU Educational Platform has taken a giant leap forward with the introduction of our new AI-powered learning system. This revolutionary technology analyzes each student's learning patterns, strengths, and areas for improvement to create truly personalized educational experiences. The AI system adapts in real-time, providing targeted recommendations, adaptive assessments, and intelligent content curation that matches each learner's unique needs and pace.",
    images: [
      "https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop"
    ],
    image: "https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop",
    category: "Technology",
    date: "2024-01-15",
    tags: ["AI", "Education", "Technology", "Innovation"],
    author: {
      name: "Dr. Sarah Johnson",
      role: "Head of Technology",
      avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100&h=100&fit=crop&crop=face"
    }
  },
  {
    id: 2,
    title: "Record-Breaking Student Enrollment for Spring Semester",
    excerpt: "CTU celebrates unprecedented growth with over 50,000 students enrolled across all programs, marking a 25% increase from last year.",
    content: "The Spring 2024 semester has brought unprecedented success to CTU Educational Platform with a record-breaking enrollment of over 50,000 students. This represents a remarkable 25% increase from the previous year, demonstrating the growing trust and recognition of our platform's quality education. The surge in enrollment spans across all our programs, with particular growth in technology, business, and creative arts courses.",
    images: [
      "https://images.unsplash.com/photo-1523240794102-9ebd0b167d56?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop"
    ],
    image: "https://images.unsplash.com/photo-1523240794102-9ebd0b167d56?w=800&h=600&fit=crop",
    category: "Education",
    date: "2024-01-12",
    tags: ["Enrollment", "Growth", "Education"],
    author: {
      name: "Prof. Michael Chen",
      role: "Dean of Admissions",
      avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face"
    }
  },
  {
    id: 3,
    title: "Partnership Announced with Leading Tech Companies",
    excerpt: "Strategic collaboration with Google, Microsoft, and Amazon to provide industry-relevant curriculum and internship opportunities for students.",
    content: "CTU Educational Platform is proud to announce groundbreaking partnerships with industry leaders Google, Microsoft, and Amazon. These strategic collaborations will bring cutting-edge curriculum directly from the tech industry to our students, ensuring they learn the most current and relevant skills. The partnerships also include exclusive internship opportunities, mentorship programs, and direct pathways to employment at these prestigious companies.",
    images: [
      "https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop"
    ],
    image: "https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop",
    category: "Partnerships",
    date: "2024-01-10",
    tags: ["Partnerships", "Tech", "Internships"],
    author: {
      name: "Lisa Rodriguez",
      role: "Partnership Director",
      avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop&crop=face"
    }
  },
  {
    id: 4,
    title: "New Mobile App Enhances Learning Experience",
    excerpt: "Students can now access courses, submit assignments, and participate in discussions seamlessly from their mobile devices.",
    content: "Learning just got more convenient with the launch of our new mobile application. The CTU mobile app provides students with seamless access to all platform features, including course content, assignment submissions, discussion forums, and real-time notifications. The app features an intuitive interface designed specifically for mobile learning, with offline capabilities for course materials and progress tracking across all devices.",
    images: [
      "https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop"
    ],
    image: "https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=600&fit=crop",
    category: "Technology",
    date: "2024-01-08",
    tags: ["Mobile", "App", "Technology"],
    author: {
      name: "Alex Thompson",
      role: "Mobile Development Lead",
      avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face"
    }
  },
  {
    id: 5,
    title: "Student Success Stories: From Beginner to Industry Expert",
    excerpt: "Meet the inspiring journey of students who transformed their careers through CTU's comprehensive learning programs.",
    content: "Success stories from our platform continue to inspire and motivate. This month, we highlight several remarkable transformations where students went from complete beginners to industry experts. These stories showcase the power of dedicated learning, quality instruction, and the comprehensive support system that CTU provides. From career changers to skill upgraders, our platform has been the catalyst for countless professional transformations.",
    images: [
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop"
    ],
    image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop",
    category: "Success Stories",
    date: "2024-01-05",
    tags: ["Success", "Students", "Careers"],
    author: {
      name: "Emma Wilson",
      role: "Student Success Manager",
      avatar: "https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=100&h=100&fit=crop&crop=face"
    }
  },
  {
    id: 6,
    title: "New Course Categories Added to Platform",
    excerpt: "Expanding our curriculum with cutting-edge courses in blockchain, cybersecurity, and sustainable development.",
    content: "CTU Educational Platform is expanding its course offerings with three exciting new categories: Blockchain Technology, Cybersecurity, and Sustainable Development. These additions reflect the growing demand for skills in emerging fields and our commitment to providing education that prepares students for the future job market. Each category features expert instructors, hands-on projects, and industry-recognized certifications.",
    images: [
      "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop"
    ],
    image: "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop",
    category: "Curriculum",
    date: "2024-01-03",
    tags: ["Curriculum", "New Courses", "Blockchain"],
    author: {
      name: "Dr. James Miller",
      role: "Curriculum Director",
      avatar: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop&crop=face"
    }
  }
];

const featuredNews = ref(newsData[0]);
const allNews = ref(newsData);

// Format date function
const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

onMounted(() => {
  // Set featured news to the first article
  featuredNews.value = newsData[0];
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

/* Swiper custom styles */
:deep(.swiper-pagination-bullet) {
  background: #0d9488;
  opacity: 0.5;
}

:deep(.swiper-pagination-bullet-active) {
  opacity: 1;
  background: #0d9488;
}

:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
  color: #0d9488;
}

:deep(.swiper-button-next:hover),
:deep(.swiper-button-prev:hover) {
  color: #0f766e;
}

/* Dark mode swiper styles */
.dark :deep(.swiper-pagination-bullet) {
  background: #5eead4;
  opacity: 0.5;
}

.dark :deep(.swiper-pagination-bullet-active) {
  opacity: 1;
  background: #5eead4;
}

.dark :deep(.swiper-button-next),
.dark :deep(.swiper-button-prev) {
  color: #5eead4;
}

.dark :deep(.swiper-button-next:hover),
.dark :deep(.swiper-button-prev:hover) {
  color: #2dd4bf;
}
</style>
