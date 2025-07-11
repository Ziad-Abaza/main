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
import { useNewsStore } from '../stores/NewsStore';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

library.add(faArrowLeft);

const route = useRoute();
const router = useRouter();
const { isDark } = useTheme();
const newsStore = useNewsStore();

// Swiper modules
const SwiperAutoplay = Autoplay;
const SwiperPagination = Pagination;
const SwiperNavigation = Navigation;

const loading = ref(true);
const article = ref(null);

// Get news data from store
const newsData = computed(() => newsStore.newsList);

// Get related articles (excluding current article)
const relatedArticles = computed(() => {
  if (!article.value) return [];
  return newsData.value.filter(news => news.id !== article.value.id).slice(0, 2);
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

  try {
    const articleId = route.params.id;

    // First try to find the article in the existing news list
    let foundArticle = newsData.value.find(news => news.id === articleId);

    if (!foundArticle) {
      // If not found in list, fetch all news first
      await newsStore.fetchNews();
      foundArticle = newsData.value.find(news => news.id === articleId);
    }

    if (foundArticle) {
      article.value = foundArticle;
    } else {
      // Handle article not found
      router.push('/news');
    }
  } catch (error) {
    console.error('Error loading article:', error);
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
