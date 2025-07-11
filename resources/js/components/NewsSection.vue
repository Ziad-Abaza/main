<template>
    <section class="py-16" v-if="newsData.length > 0">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8"> <div class="text-center mb-12">
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8"> <div class="lg:col-span-1">
            <div
              :class="
                isDark
                  ? 'bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 md:p-6 shadow-xl flex flex-col'
                  : 'bg-white rounded-2xl p-4 md:p-6 shadow-xl border border-slate-200 flex flex-col'
              "
              class="h-auto lg:h-[580px]"
            >
              <h4
                :class="
                  isDark
                    ? 'text-xl font-bold text-white mb-4 md:mb-6'
                    : 'text-xl font-bold text-slate-900 mb-4 md:mb-6'
                "
              >
                Recent News
              </h4>

              <div class="flex-1 min-h-0 overflow-y-auto scrollbar-hide">
                <div
                  v-for="news in recentNews"
                  :key="news.id"
                  @click="setFeaturedNews(news)"
                  :class="
                    isDark
                      ? 'cursor-pointer p-3 md:p-4 rounded-xl border mb-3 md:mb-4 transition-all duration-300 transform hover:scale-[1.02]'
                      : 'cursor-pointer p-3 md:p-4 rounded-xl border mb-3 md:mb-4 transition-all duration-300 transform hover:scale-[1.02]'
                  "
                  :style="{
                    borderColor:
                      featuredNews && featuredNews.id === news.id
                        ? isDark
                          ? 'rgba(20, 184, 166, 0.5)'
                          : 'rgba(20, 184, 166, 0.3)'
                        : isDark
                        ? 'rgba(255, 255, 255, 0.1)'
                        : 'rgba(226, 232, 240, 1)',
                    boxShadow:
                      featuredNews && featuredNews.id === news.id
                        ? isDark
                          ? '0 0 20px rgba(20, 184, 166, 0.3)'
                          : '0 0 20px rgba(20, 184, 166, 0.2)'
                        : undefined,
                    backgroundColor:
                      featuredNews && featuredNews.id === news.id
                        ? isDark
                          ? 'rgba(255, 255, 255, 0.05)'
                          : 'rgba(20, 184, 166, 0.05)'
                        : undefined,
                  }"
                >
                  <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                      <img
                        :src="news.image"
                        :alt="news.title"
                        class="w-16 h-16 rounded-lg object-cover transition-transform duration-300 hover:scale-110"
                      />
                    </div>

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

              <div class="mt-4 md:mt-6 pt-4 md:pt-6 border-t border-slate-200 dark:border-white/10">
                <router-link
                  to="/news"
                  :class="
                    isDark
                      ? 'block w-full text-center py-2 md:py-3 px-4 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-300 text-sm md:text-base'
                      : 'block w-full text-center py-2 md:py-3 px-4 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-300 text-sm md:text-base'
                  "
                >
                  View All News
                </router-link>
              </div>
            </div>
          </div>

          <div class="lg:col-span-2">
            <div
              v-if="featuredNews"
              :class="
                isDark
                  ? 'bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500'
                  : 'bg-white rounded-2xl overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-500 border border-slate-200'
              "
              class="h-auto lg:h-[580px]"
            >
              <div class="relative h-60 md:h-80 overflow-hidden">
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

              <div class="p-4 md:p-8">
                <h3
                  :class="
                    isDark
                      ? 'text-lg md:text-2xl font-bold text-white mb-2 md:mb-4 line-clamp-2'
                      : 'text-lg md:text-2xl font-bold text-slate-900 mb-2 md:mb-4 line-clamp-2'
                  "
                >
                  {{ featuredNews.title }}
                </h3>

                <p
                  :class="
                    isDark
                      ? 'text-sm md:text-base text-slate-300 mb-4 md:mb-6 line-clamp-3'
                      : 'text-sm md:text-base text-slate-600 mb-4 md:mb-6 line-clamp-3'
                  "
                >
                  {{ featuredNews.excerpt }}
                </p>

                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-0">
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
                        ? 'inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-300 text-sm'
                        : 'inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-300 text-sm'
                    "
                  >
                    Read More
                    <font-awesome-icon icon="arrow-right" class="ml-2 text-sm" />
                  </router-link>
                </div>
              </div>
            </div>
            <div v-else :class="isDark ? 'text-white' : 'text-slate-900'" class="text-center py-10">
              <p>No news selected to display.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </template>

  <script setup>
  import { ref, onMounted, onUnmounted, computed, watch } from "vue";
  import { useTheme } from "../composables/useTheme";
  import { useHomeStore } from "../stores/homeStore";
  import { Swiper, SwiperSlide } from "swiper/vue";
  import { Autoplay, Pagination, Navigation } from "swiper/modules";
  import "swiper/css";
  import "swiper/css/pagination";
  import "swiper/css/navigation";

  const { isDark } = useTheme();
  const homeStore = useHomeStore();

  // Swiper modules
  const SwiperAutoplay = Autoplay;
  const SwiperPagination = Pagination;
  const SwiperNavigation = Navigation;

  // Get news data from store
  const newsData = computed(() => homeStore.latestNews);

  // Reactive variable to hold the ID of the currently featured news item
  const selectedFeaturedNewsId = ref(null);

  // Computed property for the actual featured news object
  const featuredNews = computed(() => {
    if (newsData.value.length === 0) return null;
    if (selectedFeaturedNewsId.value === null && newsData.value.length > 0) {
      // Set the first news item as featured by default if nothing is selected
      selectedFeaturedNewsId.value = newsData.value[0].id;
    }
    return newsData.value.find(news => news.id === selectedFeaturedNewsId.value);
  });

  // Computed property for recent news (all news items for the sidebar)
  const recentNews = computed(() => {
    return newsData.value;
  });

  // Get featured news images for swiper
  const featuredNewsImages = computed(() => {
    if (!featuredNews.value) return [];
    // Use the images array from the API if available, otherwise fallback to single image
    return featuredNews.value.images && featuredNews.value.images.length > 0
      ? featuredNews.value.images
      : [featuredNews.value.image];
  });

  let autoAdvanceInterval;

  // Function to set featured news
  const setFeaturedNews = (news) => {
    selectedFeaturedNewsId.value = news.id;
    resetAutoAdvance(); // Reset the auto-advance timer when user manually selects
  };

  // Function to auto-advance the featured news
  const autoAdvanceFeaturedNews = () => {
    if (newsData.value.length === 0) return;

    const currentIndex = newsData.value.findIndex(
      (news) => news.id === selectedFeaturedNewsId.value
    );
    const nextIndex = (currentIndex + 1) % newsData.value.length;
    selectedFeaturedNewsId.value = newsData.value[nextIndex].id;
  };

  // Function to reset auto-advance timer
  const resetAutoAdvance = () => {
    if (autoAdvanceInterval) {
      clearInterval(autoAdvanceInterval);
    }
    autoAdvanceInterval = setInterval(autoAdvanceFeaturedNews, 8000); // Auto-advance every 8 seconds
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

  // Watch for changes in newsData and reset selectedFeaturedNewsId if the data changes
  watch(newsData, (newVal) => {
    if (newVal.length > 0 && !selectedFeaturedNewsId.value) {
      selectedFeaturedNewsId.value = newVal[0].id;
    } else if (newVal.length === 0) {
      selectedFeaturedNewsId.value = null;
    }
  }, { immediate: true }); // immediate: true ensures the watcher runs on component mount

  // Start auto-advancing on mount
  onMounted(() => {
    resetAutoAdvance();
  });

  // Cleanup on unmount
  onUnmounted(() => {
    if (autoAdvanceInterval) {
      clearInterval(autoAdvanceInterval);
    }
  });
  </script>

  <style scoped>
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    /* Ensure text doesn't overflow horizontally if it's a very long word */
    word-break: break-word;
  }

  .line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    word-break: break-word; /* Added for long words */
  }

  .shadow-3xl {
    box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
  }

  /* Hide scrollbar for a cleaner look while keeping it scrollable */
  .scrollbar-hide {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
  }

  .scrollbar-hide::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
  }
  </style>
