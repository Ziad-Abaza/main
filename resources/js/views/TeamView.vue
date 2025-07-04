<template>
  <div :class="[
    'min-h-screen py-16 px-4',
    isDark
      ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white'
      : 'bg-gradient-to-br from-blue-50 to-purple-100 text-gray-800'
  ]">
    <h1 :class="[
      'text-4xl font-extrabold text-center mb-12',
      isDark ? 'text-white' : 'text-gray-800'
    ]">Our Team</h1>
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
import { useTheme } from '../composables/useTheme'

const { isDark } = useTheme()

const teamMembers = [
  {
    id: 1,
    name: 'Alex Johnson',
    role: 'Lead Developer',
    photo: 'https://randomuser.me/api/portraits/men/32.jpg',
    bio: 'Passionate about building scalable web apps and leading teams to success.',
    skills: ['Vue.js', 'Laravel', 'Node.js', 'AWS', 'Docker'],
    experience: '8+ years in full-stack development with expertise in modern web technologies.',
    email: 'alex.johnson@company.com',
    location: 'San Francisco, CA',
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
    skills: ['Figma', 'Adobe XD', 'Sketch', 'Prototyping', 'User Research'],
    experience: '6+ years creating intuitive and beautiful user interfaces.',
    email: 'samantha.lee@company.com',
    location: 'New York, NY',
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
    skills: ['Vue.js', 'React', 'TypeScript', 'CSS3', 'WebGL'],
    experience: '5+ years specializing in frontend development and animations.',
    email: 'michael.chen@company.com',
    location: 'Seattle, WA',
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
    skills: ['Laravel', 'Python', 'PostgreSQL', 'Redis', 'Microservices'],
    experience: '7+ years building robust backend systems and APIs.',
    email: 'priya.patel@company.com',
    location: 'Austin, TX',
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
    skills: ['Selenium', 'Jest', 'Cypress', 'Manual Testing', 'Test Planning'],
    experience: '4+ years in quality assurance and automated testing.',
    email: 'carlos.rivera@company.com',
    location: 'Miami, FL',
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
    skills: ['Product Strategy', 'Agile', 'User Stories', 'Analytics', 'Roadmapping'],
    experience: '9+ years in product management and team leadership.',
    email: 'emily.smith@company.com',
    location: 'Boston, MA',
    socials: {
      twitter: 'https://twitter.com/',
      linkedin: 'https://linkedin.com/'
    }
  }
]
</script>
