<template>
  <div class="relative w-full h-80 perspective-1000" @click="flipCard" @mouseenter="handleHover" @mouseleave="handleHover">
    <!-- Front of card -->
    <div :class="[
      'absolute inset-0 rounded-2xl shadow-lg p-6 flex flex-col items-center transition-all duration-500 transform-style-preserve-3d backface-hidden cursor-pointer',
      isDark
        ? 'bg-slate-800/50 border border-slate-700/50 backdrop-blur-sm'
        : 'bg-white',
      isFlipped ? 'rotate-y-180' : ''
    ]">
      <div class="relative w-28 h-28 mb-4">
        <img :src="member.photo" :alt="member.name" :class="[
          'w-full h-full object-cover rounded-full border-4 transition duration-300',
          isDark
            ? 'border-slate-600 group-hover:border-purple-400'
            : 'border-blue-200 group-hover:border-purple-400'
        ]" />
        <span class="absolute bottom-0 right-0 w-5 h-5 bg-gradient-to-tr from-blue-400 to-purple-500 rounded-full border-2 border-white"></span>
      </div>
      <h2 :class="[
        'text-xl font-bold mb-1',
        isDark ? 'text-white' : 'text-gray-800'
      ]">{{ member.name }}</h2>
      <p class="text-sm text-purple-600 font-semibold mb-2">{{ member.role }}</p>
      <p :class="[
        'text-center mb-4',
        isDark ? 'text-slate-300' : 'text-gray-500'
      ]">{{ member.bio }}</p>
      <div class="flex space-x-3">
        <a v-if="member.socials.twitter" :href="member.socials.twitter" target="_blank" rel="noopener" :class="[
          'transition',
          isDark ? 'text-blue-400 hover:text-blue-300' : 'text-blue-400 hover:text-blue-600'
        ]" aria-label="Twitter" @click.stop>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.47.69a4.3 4.3 0 0 0 1.88-2.37 8.59 8.59 0 0 1-2.72 1.04A4.28 4.28 0 0 0 16.11 4c-2.37 0-4.29 1.92-4.29 4.29 0 .34.04.67.11.99C7.69 9.13 4.07 7.38 1.64 4.7c-.37.64-.58 1.39-.58 2.19 0 1.51.77 2.84 1.95 3.62-.72-.02-1.39-.22-1.98-.55v.06c0 2.11 1.5 3.87 3.5 4.27-.36.1-.74.16-1.13.16-.28 0-.54-.03-.8-.08.54 1.7 2.12 2.94 3.99 2.97A8.6 8.6 0 0 1 2 19.54c-.32 0-.63-.02-.94-.06A12.13 12.13 0 0 0 8.29 21.5c7.55 0 11.68-6.26 11.68-11.68 0-.18-.01-.36-.02-.54A8.18 8.18 0 0 0 24 4.59a8.36 8.36 0 0 1-2.54.7z"/></svg>
        </a>
        <a v-if="member.socials.linkedin" :href="member.socials.linkedin" target="_blank" rel="noopener" :class="[
          'transition',
          isDark ? 'text-blue-400 hover:text-blue-300' : 'text-blue-700 hover:text-blue-900'
        ]" aria-label="LinkedIn" @click.stop>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.28c-.97 0-1.75-.79-1.75-1.75s.78-1.75 1.75-1.75 1.75.79 1.75 1.75-.78 1.75-1.75 1.75zm13.5 10.28h-3v-4.5c0-1.08-.02-2.47-1.5-2.47-1.5 0-1.73 1.17-1.73 2.39v4.58h-3v-9h2.88v1.23h.04c.4-.75 1.38-1.54 2.84-1.54 3.04 0 3.6 2 3.6 4.59v4.72z"/></svg>
        </a>
        <a v-if="member.socials.github" :href="member.socials.github" target="_blank" rel="noopener" :class="[
          'transition',
          isDark ? 'text-slate-300 hover:text-white' : 'text-gray-800 hover:text-black'
        ]" aria-label="GitHub" @click.stop>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.387.6.113.82-.262.82-.582 0-.288-.012-1.243-.018-2.25-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.729.083-.729 1.205.085 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.54 2.84-1.54 3.04 0 3.6 2 3.6 4.59v4.72z"/></svg>
        </a>
        <a v-if="member.socials.dribbble" :href="member.socials.dribbble" target="_blank" rel="noopener" :class="[
          'transition',
          isDark ? 'text-pink-400 hover:text-pink-300' : 'text-pink-500 hover:text-pink-700'
        ]" aria-label="Dribbble" @click.stop>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.371 0 0 5.371 0 12c0 6.629 5.371 12 12 12s12-5.371 12-12c0-6.629-5.371-12-12-12zm7.938 7.5c2.104 2.563 2.396 6.229.771 9.063-.271-.086-2.396-.729-4.938-.563-.084-.188-.146-.354-.229-.542-.062-.146-.125-.292-.188-.438 4.021-1.771 5.646-4.229 5.646-4.229zm-1.354-1.479c1.021 1.104 1.771 2.479 2.021 3.979-.021.021-1.479 2.354-5.188 3.771-.167-.354-.334-.708-.521-1.063-.042-.083-.083-.167-.125-.25 4.021-1.646 5.021-3.646 5.021-3.646-.417-.646-.938-1.229-1.521-1.521zm-6.188-2.021c.938-.188 1.896-.188 2.833 0 .021.021 1.646 1.938 3.229 5.021-3.938 1.354-7.896 1.354-11.833 0 1.583-3.083 3.208-5 3.229-5zm-7.021 7.021c.25-1.5 1-2.875 2.021-3.979-.583.542-1.104 1.125-1.521 1.771 0 0 1 2 5.021 3.646-.042.083-.083.167-.125.25-.188.354-.354.708-.521 1.063-3.708-1.417-5.167-3.75-5.188-3.771zm.021 7.021c-.021-.021-.021-.042-.042-.063-1.625-2.833-1.333-6.5.771-9.063 0 0 1.625 2.458 5.646 4.229-.062.146-.125.292-.188.438-.083.188-.146.354-.229.542-2.542-.167-4.667.479-4.938.563zm1.479 1.354c.021-.021 2.354-1.479 3.771-5.188.354.167.708.334 1.063.521.083.042.167.083.25.125-1.646 4.021-3.646 5.021-3.646 5.021-.646-.417-1.229-.938-1.771-1.521zm6.063 2.021c-1.5-.25-2.875-1-3.979-2.021.542.583 1.125 1.104 1.771 1.521 0 0 2-1 3.646-5.021.083.042.167.083.25.125.354.188.708.354 1.063.521-1.417 3.708-3.75 5.167-3.771 5.188zm1.938.188c-.021 0-.042 0-.063-.021 2.833-1.625 6.5-1.333 9.063.771 0 0-2.458-1.625-4.229-5.646.146-.062.292-.125.438-.188.188-.083.354-.146.542-.229.167 2.542-.479 4.667-.563 4.938zm2.021-1.479c.021-.021 1.479-2.354 5.188-3.771.167.354.334.708.521 1.063.042.083.083.167.125.25-4.021 1.646-5.021 3.646-5.021 3.646.417.646.938 1.229 1.521 1.771zm-2.021-1.479c-.021.021-1.479 2.354-5.188 3.771-.167-.354-.334-.708-.521-1.063-.042-.083-.083-.167-.125-.25 4.021-1.646 5.021-3.646 5.021-3.646-.417-.646-.938-1.229-1.521-1.771zm1.479-2.021c-.021.021-2.354 1.479-3.771 5.188-.354-.167-.708-.334-1.063-.521-.083-.042-.167-.083-.25-.125 1.646-4.021 3.646-5.021 3.646-5.021.646.417 1.229.938 1.771 1.521zm2.021 1.479c.021-.021 1.479-2.354 5.188-3.771.167.354.334.708.521 1.063.042.083.083.167.125.25-4.021 1.646-5.021 3.646-5.021 3.646.417.646.938 1.229 1.521 1.771zm-2.021-1.479c-.021.021-1.479 2.354-5.188 3.771-.167-.354-.334-.708-.521-1.063-.042-.083-.083-.167-.125-.25 4.021-1.646 5.021-3.646 5.021-3.646-.417-.646-.938-1.229-1.521-1.771zm1.479-2.021c-.021.021-2.354 1.479-3.771 5.188-.354-.167-.708-.334-1.063-.521-.083-.042-.167-.083-.25-.125 1.646-4.021 3.646-5.021 3.646-5.021.646.417 1.229.938 1.771 1.521zm2.021 1.479c.021-.021 1.479-2.354 5.188-3.771.167.354.334.708.521 1.063.042.083.083.167.125.25-4.021 1.646-5.021 3.646-5.021 3.646.417.646.938 1.229 1.521 1.771z"/></svg>
        </a>
      </div>
    </div>

    <!-- Back of card -->
    <div :class="[
      'absolute inset-0 rounded-2xl shadow-lg p-6 flex flex-col items-center transition-all duration-500 transform-style-preserve-3d backface-hidden rotate-y-180 cursor-pointer',
      isDark
        ? 'bg-gradient-to-br from-slate-800/80 to-slate-900/80 border border-slate-700/50 backdrop-blur-sm'
        : 'bg-gradient-to-br from-blue-50 to-purple-100',
      isFlipped ? 'rotate-y-0' : ''
    ]">
      <h3 :class="[
        'text-lg font-bold mb-4 text-center',
        isDark ? 'text-white' : 'text-gray-800'
      ]">{{ member.name }}</h3>

      <!-- Skills Section -->
      <div class="w-full mb-4">
        <h4 :class="[
          'text-sm font-semibold mb-2',
          isDark ? 'text-slate-300' : 'text-gray-700'
        ]">Skills</h4>
        <div class="flex flex-wrap gap-1">
          <span v-for="skill in member.skills" :key="skill" :class="[
            'px-2 py-1 text-xs rounded-full',
            isDark ? 'bg-slate-700 text-slate-200' : 'bg-blue-100 text-blue-800'
          ]">
            {{ skill }}
          </span>
        </div>
      </div>

      <!-- Experience Section -->
      <div class="w-full mb-4">
        <h4 :class="[
          'text-sm font-semibold mb-2',
          isDark ? 'text-slate-300' : 'text-gray-700'
        ]">Experience</h4>
        <p :class="[
          'text-xs',
          isDark ? 'text-slate-400' : 'text-gray-600'
        ]">{{ member.experience }}</p>
      </div>

      <!-- Contact Section -->
      <div class="w-full mb-4">
        <h4 :class="[
          'text-sm font-semibold mb-2',
          isDark ? 'text-slate-300' : 'text-gray-700'
        ]">Contact</h4>
        <div class="space-y-1">
          <div v-if="member.email" :class="[
            'text-xs flex items-center gap-2',
            isDark ? 'text-slate-400' : 'text-gray-600'
          ]">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
            </svg>
            {{ member.email }}
          </div>
          <div v-if="member.location" :class="[
            'text-xs flex items-center gap-2',
            isDark ? 'text-slate-400' : 'text-gray-600'
          ]">
            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
            </svg>
            {{ member.location }}
          </div>
        </div>
      </div>

      <!-- Social Links on Back -->
      <div class="flex space-x-3 mt-auto">
        <a v-if="member.socials.twitter" :href="member.socials.twitter" target="_blank" rel="noopener" :class="[
          'transition p-2 rounded-full',
          isDark ? 'bg-slate-700 text-blue-400 hover:bg-slate-600' : 'bg-blue-100 text-blue-600 hover:bg-blue-200'
        ]" aria-label="Twitter" @click.stop>
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22.46 6c-.77.35-1.6.58-2.47.69a4.3 4.3 0 0 0 1.88-2.37 8.59 8.59 0 0 1-2.72 1.04A4.28 4.28 0 0 0 16.11 4c-2.37 0-4.29 1.92-4.29 4.29 0 .34.04.67.11.99C7.69 9.13 4.07 7.38 1.64 4.7c-.37.64-.58 1.39-.58 2.19 0 1.51.77 2.84 1.95 3.62-.72-.02-1.39-.22-1.98-.55v.06c0 2.11 1.5 3.87 3.5 4.27-.36.1-.74.16-1.13.16-.28 0-.54-.03-.8-.08.54 1.7 2.12 2.94 3.99 2.97A8.6 8.6 0 0 1 2 19.54c-.32 0-.63-.02-.94-.06A12.13 12.13 0 0 0 8.29 21.5c7.55 0 11.68-6.26 11.68-11.68 0-.18-.01-.36-.02-.54A8.18 8.18 0 0 0 24 4.59a8.36 8.36 0 0 1-2.54.7z"/></svg>
        </a>
        <a v-if="member.socials.linkedin" :href="member.socials.linkedin" target="_blank" rel="noopener" :class="[
          'transition p-2 rounded-full',
          isDark ? 'bg-slate-700 text-blue-400 hover:bg-slate-600' : 'bg-blue-100 text-blue-600 hover:bg-blue-200'
        ]" aria-label="LinkedIn" @click.stop>
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-9h3v9zm-1.5-10.28c-.97 0-1.75-.79-1.75-1.75s.78-1.75 1.75-1.75 1.75.79 1.75 1.75-.78 1.75-1.75 1.75zm13.5 10.28h-3v-4.5c0-1.08-.02-2.47-1.5-2.47-1.5 0-1.73 1.17-1.73 2.39v4.58h-3v-9h2.88v1.23h.04c.4-.75 1.38-1.54 2.84-1.54 3.04 0 3.6 2 3.6 4.59v4.72z"/></svg>
        </a>
        <a v-if="member.socials.github" :href="member.socials.github" target="_blank" rel="noopener" :class="[
          'transition p-2 rounded-full',
          isDark ? 'bg-slate-700 text-slate-300 hover:bg-slate-600' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
        ]" aria-label="GitHub" @click.stop>
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.387.6.113.82-.262.82-.582 0-.288-.012-1.243-.018-2.25-3.338.726-4.042-1.61-4.042-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.729.083-.729 1.205.085 1.84 1.237 1.84 1.237 1.07 1.834 2.807 1.304 3.492.997.108-.775.418-1.54 2.84-1.54 3.04 0 3.6 2 3.6 4.59v4.72z"/></svg>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useTheme } from '../composables/useTheme'

const { isDark } = useTheme()
const isFlipped = ref(false)
const isHovered = ref(false)

defineProps({
  member: {
    type: Object,
    required: true
  }
})

// Flip card on click
const flipCard = () => {
  isFlipped.value = !isFlipped.value
}

// Handle hover for desktop
const handleHover = (event) => {
  if (event.type === 'mouseenter') {
    isHovered.value = true
    isFlipped.value = true
  } else if (event.type === 'mouseleave') {
    isHovered.value = false
    isFlipped.value = false
  }
}
</script>

<style scoped>
.perspective-1000 {
  perspective: 1000px;
}

.transform-style-preserve-3d {
  transform-style: preserve-3d;
}

.backface-hidden {
  backface-visibility: hidden;
}

.rotate-y-180 {
  transform: rotateY(180deg);
}

.rotate-y-0 {
  transform: rotateY(0deg);
}
</style>
