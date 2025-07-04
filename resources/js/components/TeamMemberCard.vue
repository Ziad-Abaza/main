<template>
  <div
    class="relative w-full h-[28rem] perspective-1000"
    @click="handleClick"
    @mouseenter="handleHover"
    @mouseleave="handleHover"
    @touchstart="handleTouchStart"
    @touchend="handleTouchEnd"
  >
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
        'text-center mb-4 flex-grow',
        isDark ? 'text-slate-300' : 'text-gray-500'
      ]">{{ member.bio }}</p>
    <div class="flex space-x-3 mt-auto">
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
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
      </a>
        <a v-if="member.socials.facebook" :href="member.socials.facebook" target="_blank" rel="noopener" :class="[
          'transition',
          isDark ? 'text-blue-400 hover:text-blue-300' : 'text-blue-600 hover:text-blue-800'
        ]" aria-label="Facebook" @click.stop>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.367-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </a>
        <a v-if="member.socials.instagram" :href="member.socials.instagram" target="_blank" rel="noopener" :class="[
          'transition',
          isDark ? 'text-pink-400 hover:text-pink-300' : 'text-pink-500 hover:text-pink-700'
        ]" aria-label="Instagram" @click.stop>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
        </a>
        <a v-if="member.socials.whatsapp" :href="member.socials.whatsapp" target="_blank" rel="noopener" :class="[
          'transition',
          isDark ? 'text-green-400 hover:text-green-300' : 'text-green-600 hover:text-green-700'
        ]" aria-label="WhatsApp" @click.stop>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
        </a>
        <a v-if="member.socials.gmail" :href="member.socials.gmail" target="_blank" rel="noopener" :class="[
          'transition',
          isDark ? 'text-red-400 hover:text-red-300' : 'text-red-600 hover:text-red-700'
        ]" aria-label="Gmail" @click.stop>
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-.904.732-1.636 1.636-1.636h.014L12 10.5l10.35-6.679h.014c.904 0 1.636.732 1.636 1.636z"/></svg>
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
      <div class="w-full mb-4 flex-grow">
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
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
        </a>
        <a v-if="member.socials.facebook" :href="member.socials.facebook" target="_blank" rel="noopener" :class="[
          'transition p-2 rounded-full',
          isDark ? 'bg-slate-700 text-blue-400 hover:bg-slate-600' : 'bg-blue-100 text-blue-600 hover:bg-blue-200'
        ]" aria-label="Facebook" @click.stop>
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.367-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </a>
        <a v-if="member.socials.instagram" :href="member.socials.instagram" target="_blank" rel="noopener" :class="[
          'transition p-2 rounded-full',
          isDark ? 'bg-slate-700 text-pink-400 hover:bg-slate-600' : 'bg-pink-100 text-pink-600 hover:bg-pink-200'
        ]" aria-label="Instagram" @click.stop>
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
        </a>
        <a v-if="member.socials.whatsapp" :href="member.socials.whatsapp" target="_blank" rel="noopener" :class="[
          'transition p-2 rounded-full',
          isDark ? 'bg-slate-700 text-green-400 hover:bg-slate-600' : 'bg-green-100 text-green-600 hover:bg-green-200'
        ]" aria-label="WhatsApp" @click.stop>
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/></svg>
        </a>
        <a v-if="member.socials.gmail" :href="member.socials.gmail" target="_blank" rel="noopener" :class="[
          'transition p-2 rounded-full',
          isDark ? 'bg-slate-700 text-red-400 hover:bg-slate-600' : 'bg-red-100 text-red-600 hover:bg-red-200'
        ]" aria-label="Gmail" @click.stop>
          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-.904.732-1.636 1.636-1.636h.014L12 10.5l10.35-6.679h.014c.904 0 1.636.732 1.636 1.636z"/></svg>
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
const touchStartTime = ref(0)
const isTouchDevice = ref(false)

defineProps({
  member: {
    type: Object,
    required: true
  }
})

// Detect touch device
const detectTouchDevice = () => {
  isTouchDevice.value = 'ontouchstart' in window || navigator.maxTouchPoints > 0
}

// Initialize touch detection
detectTouchDevice()

// Handle click events
const handleClick = (event) => {
  // Only handle click on non-touch devices or if it's not a touch event
  if (!isTouchDevice.value) {
    flipCard()
  }
}

// Handle touch events
const handleTouchStart = (event) => {
  touchStartTime.value = Date.now()
}

const handleTouchEnd = (event) => {
  const touchDuration = Date.now() - touchStartTime.value

  // Only flip if it's a quick tap (less than 300ms) and not a long press
  if (touchDuration < 300) {
    flipCard()
  }
}

// Flip card
const flipCard = () => {
  isFlipped.value = !isFlipped.value
}

// Handle hover for desktop only
const handleHover = (event) => {
  // Only handle hover on non-touch devices
  if (!isTouchDevice.value) {
    if (event.type === 'mouseenter') {
      isHovered.value = true
      isFlipped.value = true
    } else if (event.type === 'mouseleave') {
      isHovered.value = false
      isFlipped.value = false
    }
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

/* Prevent text selection on touch devices */
.perspective-1000 {
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
</style>
