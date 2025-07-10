<template>
  <div
    :class="
      isDark
        ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
        : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
    "
  >
    <!-- Back Button -->
    <div class="container mx-auto px-6 py-6">
      <router-link
        to="/news"
        :class="
          isDark
            ? 'inline-flex items-center text-teal-400 hover:text-teal-300 transition-colors duration-300'
            : 'inline-flex items-center text-teal-600 hover:text-teal-700 transition-colors duration-300'
        "
      >
        <font-awesome-icon
          icon="arrow-left"
          class="mr-2"
        />
        Back to News
      </router-link>
    </div>

    <!-- Article Content -->
    <div class="container mx-auto px-6 pb-16">
      <!-- Loading State -->
      <div v-if="loading" class="text-center py-20">
        <div
          :class="
            isDark
              ? 'inline-flex items-center space-x-3 text-slate-400'
              : 'inline-flex items-center space-x-3 text-slate-600'
          "
        >
          <div
            class="animate-spin rounded-full h-8 w-8 border-b-2 border-teal-500"
          ></div>
          <span class="text-lg">Loading article...</span>
        </div>
      </div>

      <!-- Article -->
      <div v-else-if="article" class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
          <div class="flex items-center space-x-4 mb-4">
            <span
              :class="
                isDark
                  ? 'bg-teal-500/90 text-white px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm'
                  : 'bg-teal-500 text-white px-4 py-2 rounded-full text-sm font-medium'
              "
            >
              {{ article.category }}
            </span>
            <span
              :class="
                isDark
                  ? 'text-slate-400'
                  : 'text-slate-600'
              "
            >
              {{ formatDate(article.date) }}
            </span>
          </div>

          <h1
            :class="
              isDark
                ? 'text-4xl md:text-5xl font-bold text-white mb-6'
                : 'text-4xl md:text-5xl font-bold text-slate-900 mb-6'
            "
          >
            {{ article.title }}
          </h1>

          <!-- Author Info -->
          <div class="flex items-center space-x-4 mb-8">
            <img
              :src="article.author.avatar"
              :alt="article.author.name"
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
                {{ article.author.name }}
              </p>
              <p
                :class="
                  isDark
                    ? 'text-slate-400'
                    : 'text-slate-600'
                "
              >
                {{ article.author.role }}
              </p>
            </div>
          </div>
        </div>

        <!-- Main Image with Swiper -->
        <div class="mb-8">
          <div class="relative h-96 md:h-[500px] rounded-2xl overflow-hidden shadow-2xl">
            <swiper
              :modules="[SwiperAutoplay, SwiperPagination, SwiperNavigation]"
              :slides-per-view="1"
              :loop="true"
              :autoplay="{
                delay: 4000,
                disableOnInteraction: false,
              }"
              :pagination="{ clickable: true }"
              :navigation="true"
              class="h-full"
            >
              <swiper-slide v-for="(image, index) in articleImages" :key="index">
                <img
                  :src="image"
                  :alt="`${article.title} - Image ${index + 1}`"
                  class="w-full h-full object-cover"
                />
              </swiper-slide>
            </swiper>
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
          <p class="text-xl leading-relaxed mb-8 text-slate-300 dark:text-slate-200">
            {{ article.excerpt }}
          </p>

          <p class="text-lg leading-relaxed mb-6">
            {{ article.content }}
          </p>

          <!-- Additional content based on article type -->
          <div v-if="article.id === 1">
            <h2
              :class="
                isDark
                  ? 'text-3xl font-bold text-white mt-12 mb-6'
                  : 'text-3xl font-bold text-slate-900 mt-12 mb-6'
              "
            >
              The Future of AI in Education
            </h2>

            <p class="text-lg leading-relaxed mb-6">
              As we look toward the future, the role of artificial intelligence in education will continue to evolve and expand. We're already seeing the benefits of AI-powered learning systems in our platform, with students experiencing more engaging, personalized, and effective learning journeys.
            </p>

            <h3
              :class="
                isDark
                  ? 'text-2xl font-bold text-white mt-8 mb-4'
                  : 'text-2xl font-bold text-slate-900 mt-8 mb-4'
              "
            >
              Key Features of Our AI Platform
            </h3>

            <ul class="space-y-4 mb-8">
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
                <div>
                  <span
                    :class="
                      isDark
                        ? 'text-slate-300 font-semibold'
                        : 'text-slate-700 font-semibold'
                    "
                  >
                    Adaptive Learning Paths:
                  </span>
                  <span
                    :class="
                      isDark
                        ? 'text-slate-400'
                        : 'text-slate-600'
                    "
                  >
                    The AI analyzes your learning patterns and adjusts the curriculum to match your pace and style.
                  </span>
                </div>
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
                <div>
                  <span
                    :class="
                      isDark
                        ? 'text-slate-300 font-semibold'
                        : 'text-slate-700 font-semibold'
                    "
                  >
                    Intelligent Assessments:
                  </span>
                  <span
                    :class="
                      isDark
                        ? 'text-slate-400'
                        : 'text-slate-600'
                    "
                  >
                    Dynamic quizzes and tests that adapt to your knowledge level and learning progress.
                  </span>
                </div>
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
                <div>
                  <span
                    :class="
                      isDark
                        ? 'text-slate-300 font-semibold'
                        : 'text-slate-700 font-semibold'
                    "
                  >
                    Personalized Recommendations:
                  </span>
                  <span
                    :class="
                      isDark
                        ? 'text-slate-400'
                        : 'text-slate-600'
                    "
                  >
                    AI suggests relevant courses, resources, and learning materials based on your interests and goals.
                  </span>
                </div>
              </li>
            </ul>

            <div
              :class="
                isDark
                  ? 'bg-teal-500/10 border border-teal-500/20 rounded-2xl p-8 mb-8'
                  : 'bg-teal-50 border border-teal-200 rounded-2xl p-8 mb-8'
              "
            >
              <h4
                :class="
                  isDark
                    ? 'text-xl font-bold text-teal-300 mb-4'
                    : 'text-xl font-bold text-teal-700 mb-4'
                "
              >
                🚀 What's Next?
              </h4>
              <p
                :class="
                  isDark
                    ? 'text-slate-300'
                    : 'text-slate-700'
                "
              >
                We're continuously working on new AI features including voice recognition for hands-free learning,
                virtual reality integration for immersive experiences, and advanced analytics for deeper insights
                into learning patterns.
              </p>
            </div>
          </div>

          <div v-else>
            <p class="text-lg leading-relaxed mb-6">
              This is a comprehensive article about the latest developments in our educational platform.
              We're committed to providing the best learning experience for our students through continuous
              innovation and improvement.
            </p>

            <p class="text-lg leading-relaxed mb-6">
              Our team works tirelessly to ensure that every feature and update we release enhances the
              learning journey of our students. From improved user interfaces to advanced learning algorithms,
              every change is designed with our students' success in mind.
            </p>
          </div>
        </div>

        <!-- Tags -->
        <div class="flex flex-wrap gap-2 mt-12 pt-8 border-t border-slate-200 dark:border-white/10">
          <span
            v-for="tag in article.tags"
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

        <!-- Related Articles -->
        <div class="mt-16">
          <h3
            :class="
              isDark
                ? 'text-2xl font-bold text-white mb-8'
                : 'text-2xl font-bold text-slate-900 mb-8'
            "
          >
            Related Articles
          </h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
              v-for="relatedArticle in relatedArticles"
              :key="relatedArticle.id"
              class="group cursor-pointer"
              @click="goToArticle(relatedArticle.id)"
            >
              <div
                :class="
                  isDark
                    ? 'bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1'
                    : 'bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-slate-200'
                "
              >
                <img
                  :src="relatedArticle.image"
                  :alt="relatedArticle.title"
                  class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105"
                />
                <div class="p-6">
                  <h4
                    :class="
                      isDark
                        ? 'text-lg font-semibold text-white mb-2 line-clamp-2 group-hover:text-teal-400 transition-colors'
                        : 'text-lg font-semibold text-slate-900 mb-2 line-clamp-2 group-hover:text-teal-600 transition-colors'
                    "
                  >
                    {{ relatedArticle.title }}
                  </h4>
                  <p
                    :class="
                      isDark
                        ? 'text-slate-400 text-sm line-clamp-2'
                        : 'text-slate-600 text-sm line-clamp-2'
                    "
                  >
                    {{ relatedArticle.excerpt }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useTheme } from '../composables/useTheme';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faArrowLeft } from '@fortawesome/free-solid-svg-icons';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

library.add(faArrowLeft);

const route = useRoute();
const router = useRouter();
const { isDark } = useTheme();

// Swiper modules
const SwiperAutoplay = Autoplay;
const SwiperPagination = Pagination;
const SwiperNavigation = Navigation;

const loading = ref(true);
const article = ref(null);

// Fake news data with multiple images for each article
const newsData = [
  {
    id: 1,
    title: "New AI-Powered Learning Platform Launches at CTU",
    excerpt: "Revolutionary artificial intelligence technology is now integrated into our educational platform, providing personalized learning experiences for every student.",
    content: "The CTU Educational Platform has taken a giant leap forward with the introduction of our new AI-powered learning system. This revolutionary technology analyzes each student's learning patterns, strengths, and areas for improvement to create truly personalized educational experiences. The AI system adapts in real-time, providing targeted recommendations, adaptive assessments, and intelligent content curation that matches each learner's unique needs and pace.",
    image: "https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop"
    ],
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
    image: "https://images.unsplash.com/photo-1523240794102-9ebd0b167d56?w=800&h=600&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1523240794102-9ebd0b167d56?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop"
    ],
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
    image: "https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop"
    ],
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
    image: "https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=600&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop"
    ],
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
    image: "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop"
    ],
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
    image: "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop",
    images: [
      "https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop",
      "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&h=600&fit=crop"
    ],
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

// Get related articles (excluding current article)
const relatedArticles = computed(() => {
  if (!article.value) return [];
  return newsData.filter(news => news.id !== article.value.id).slice(0, 2);
});

// Get article images for swiper
const articleImages = computed(() => {
  if (!article.value) return [];
  return article.value.images || [article.value.image];
});

// Format date function
const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

// Navigate to article
const goToArticle = (id) => {
  router.push(`/news/${id}`);
};

// Load article data
const loadArticle = async () => {
  loading.value = true;

  // Simulate API call delay
  await new Promise(resolve => setTimeout(resolve, 500));

  const articleId = parseInt(route.params.id);
  const foundArticle = newsData.find(news => news.id === articleId);

  if (foundArticle) {
    article.value = foundArticle;
  } else {
    // Handle article not found
    router.push('/news');
  }

  loading.value = false;
};

onMounted(() => {
  loadArticle();
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
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
