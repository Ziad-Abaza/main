<template>
  <section class="min-h-screen py-16 px-4 md:px-0 flex flex-col items-center bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-950 dark:to-indigo-950 transition-colors duration-500">
    <div class="max-w-3xl w-full text-center mb-12">
      <h1 class="text-4xl md:text-5xl font-extrabold mb-4 bg-gradient-to-r from-blue-500 to-purple-600 bg-clip-text text-transparent">About CTU</h1>
      <p class="text-lg md:text-xl text-slate-600 dark:text-slate-300 mb-6">Borg El-Arab Technological University is dedicated to empowering learners and inspiring innovation in Alexandria, Egypt and beyond.</p>
      <div class="flex justify-center gap-4 flex-wrap">
        <span class="inline-block px-4 py-2 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200 text-xs font-semibold">Innovation</span>
        <span class="inline-block px-4 py-2 rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-200 text-xs font-semibold">Excellence</span>
        <span class="inline-block px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-200 text-xs font-semibold">Community</span>
      </div>
    </div>
    <div class="max-w-4xl w-full grid md:grid-cols-2 gap-10 mb-16">
      <div class="bg-white/80 dark:bg-slate-900/80 rounded-2xl shadow p-8 flex flex-col gap-4">
        <h2 class="text-2xl font-bold mb-2 text-blue-600 dark:text-blue-300">Our Mission</h2>
        <p class="text-slate-700 dark:text-slate-300">To provide world-class education, foster research and innovation, and prepare students to become leaders in technology and society.</p>
      </div>
      <div class="bg-white/80 dark:bg-slate-900/80 rounded-2xl shadow p-8 flex flex-col gap-4">
        <h2 class="text-2xl font-bold mb-2 text-purple-600 dark:text-purple-300">Our Vision & Values</h2>
        <ul class="list-disc list-inside text-slate-700 dark:text-slate-300">
          <li>Empowering students to reach their full potential</li>
          <li>Promoting diversity, inclusion, and collaboration</li>
          <li>Commitment to academic excellence and integrity</li>
        </ul>
      </div>
    </div>
    <div class="max-w-4xl w-full bg-white/80 dark:bg-slate-900/80 rounded-2xl shadow p-8 flex flex-col gap-4">
      <h2 class="text-2xl font-bold mb-2 text-emerald-600 dark:text-emerald-300">Our Team</h2>
      <p class="text-slate-700 dark:text-slate-300 mb-4">Meet the passionate educators, researchers, and leaders who make CTU a center of excellence. (Team bios and photos coming soon.)</p>
      <div class="flex flex-wrap gap-4 justify-center">
        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-200 to-purple-200 dark:from-blue-900 dark:to-purple-900 flex items-center justify-center text-3xl font-bold text-white">CT</div>
        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-emerald-200 to-blue-200 dark:from-emerald-900 dark:to-blue-900 flex items-center justify-center text-3xl font-bold text-white">U</div>
      </div>
    </div>
  </section>
</template>

<script setup>
// No logic needed for placeholder
</script>
