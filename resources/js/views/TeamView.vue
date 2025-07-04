<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-100 py-16 px-4">
    <h1 class="text-4xl font-extrabold text-center mb-12 text-gray-800">Our Team</h1>
    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 max-w-6xl mx-auto">
      <TeamMemberCard
        v-for="member in teamMembers"
        :key="member.id"
        :member="member"
      />
    </div>
  </div>
</template>

<script setup>
import TeamMemberCard from '../components/TeamMemberCard.vue'

const teamMembers = [
  {
    id: 1,
    name: 'Alex Johnson',
    role: 'Lead Developer',
    photo: 'https://randomuser.me/api/portraits/men/32.jpg',
    bio: 'Passionate about building scalable web apps and leading teams to success.',
    socials: {
      twitter: 'https://twitter.com/',
      linkedin: 'https://linkedin.com/',
      github: 'https://github.com/'
    }
  },
  {
    id: 2,
    name: 'Samantha Lee',
    role: 'UI/UX Designer',
    photo: 'https://randomuser.me/api/portraits/women/44.jpg',
    bio: 'Designing delightful user experiences with a modern touch.',
    socials: {
      twitter: 'https://twitter.com/',
      linkedin: 'https://linkedin.com/',
      dribbble: 'https://dribbble.com/'
    }
  },
  {
    id: 3,
    name: 'Michael Chen',
    role: 'Frontend Engineer',
    photo: 'https://randomuser.me/api/portraits/men/85.jpg',
    bio: 'Loves Vue.js, animations, and pixel-perfect interfaces.',
    socials: {
      twitter: 'https://twitter.com/',
      linkedin: 'https://linkedin.com/',
      github: 'https://github.com/'
    }
  },
  {
    id: 4,
    name: 'Priya Patel',
    role: 'Backend Engineer',
    photo: 'https://randomuser.me/api/portraits/women/68.jpg',
    bio: 'API wizard and database enthusiast. Keeps things running smoothly.',
    socials: {
      twitter: 'https://twitter.com/',
      linkedin: 'https://linkedin.com/',
      github: 'https://github.com/'
    }
  },
  {
    id: 5,
    name: 'Carlos Rivera',
    role: 'QA Specialist',
    photo: 'https://randomuser.me/api/portraits/men/41.jpg',
    bio: 'Ensures every release is bug-free and high quality.',
    socials: {
      twitter: 'https://twitter.com/',
      linkedin: 'https://linkedin.com/'
    }
  },
  {
    id: 6,
    name: 'Emily Smith',
    role: 'Product Manager',
    photo: 'https://randomuser.me/api/portraits/women/12.jpg',
    bio: 'Brings vision and strategy to the team. Loves agile and coffee.',
    socials: {
      twitter: 'https://twitter.com/',
      linkedin: 'https://linkedin.com/'
    }
  }
]
</script>
