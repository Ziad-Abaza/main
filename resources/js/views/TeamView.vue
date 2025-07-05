<template>
    <div
        :class="[
            'min-h-screen py-16 px-4',
            isDark
                ? 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 text-white'
                : 'bg-gradient-to-br from-blue-50 to-purple-100 text-gray-800',
        ]"
    >
        <h1
            :class="[
                'text-4xl font-extrabold text-center mb-12',
                isDark ? 'text-white' : 'text-gray-800',
            ]"
        >
            Our Team
        </h1>
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
import TeamMemberCard from "../components/TeamMemberCard.vue";
import { useTheme } from "../composables/useTheme";
import ossamaPhoto from "@/assets/team/ossama.jpg";
import omarPhoto from "@/assets/team/omar.jpg";
import ziadPhoto from "@/assets/team/ziad.jpg";
import yosifPhoto from "@/assets/team/yosif.jpg";

const { isDark } = useTheme();

const teamMembers = [
    {
        id: 1,
        name: "ossama el-nahas",
        role: "supervisor",
        photo: ossamaPhoto,
        bio: "It college Dean at BATU.",
        // skills: ['Vue.js', 'Laravel', 'Node.js', 'AWS', 'Docker'],
        // experience: '8+ years in full-stack development with expertise in modern web technologies.',
        email: "osamaelnahhas2@gmail.com",
        location: "Borg el-arab, Egypt",
        socials: {
            // twitter: 'https://twitter.com/',
            // linkedin: 'https://linkedin.com/',
            facebook: "https://www.facebook.com/osama.e.helaly",
            // instagram: 'https://instagram.com/',
            whatsapp: "https://wa.me/+201013101727",
            gmail: "mailto:osamaelnahhas2@gmail.com",
        },
    },
    {
        id: 2,
        name: "omar algamel",
        role: "full stack developer",
        photo: omarPhoto,
        bio: "Full-stack developer & AI engineer designing delightful user experiences with a modern touch. Passionate about solving real-world problems through clean design and intelligent automation.",
        skills: [
            "Laravel",
            "Vue",
            "Flutter",
            "Python",
            "AI",
            "REST APIs",
            "OpenCV",
            "TensorFlow",
        ],
        experience:
            "3+ years building websites · 2+ years creating and deploying AI models",
        email: "omeralgamel@gmail.com",
        location: "alexandria egypt",
        socials: {
            //   twitter: 'https://twitter.com/',
            //   linkedin: 'https://linkedin.com/',
            //   dribbble: 'https://dribbble.com/',
            facebook: "https://www.facebook.com/algamel.omer",
            instagram: "https://www.instagram.com/algamel.omar/",
            whatsapp: "https://wa.me/+201126642884",
            gmail: "mailto:omeralgamel@gmail.com",
            github: "https://github.com/algamelomer",
        },
    },
    {
        id: 3,
        name: "ziad hassan",
        role: "backend developer",
        photo: ziadPhoto,
        bio: "Passionate Full Stack Web Developer, AI Enthusiast, and IoT Innovator. Currently pursuing Information Technology degree, focused on building real-world applications that blend web development, artificial intelligence, and embedded systems.",
        skills: [
            "Laravel",
            "Vue.js",
            "Python",
            "TensorFlow",
            "OpenCV",
            "IoT",
            "MySQL",
            "REST APIs",
            "Deep Learning",
            "Computer Vision",
        ],
        experience:
            "Building full stack applications, AI systems, and IoT solutions. Co-founder of IT Club promoting digital innovation.",
        email: "zeyad.h.abaza@gmail.com",
        location: "alexandria, egypt",
        socials: {
            linkedin: "https://www.linkedin.com/in/ziad-h-abaza-82276331b/",
            github: "https://github.com/Ziad-Abaza",
            facebook: "https://www.facebook.com/ziad.hassan.148116",
            instagram: "https://www.instagram.com/3_p0ox/",
            whatsapp: "https://wa.me/+201006403927",
            gmail: "mailto:zeyad.h.abaza@gmail.com",
        },
    },
    {
        id: 4,
        name: "youssef mohamed",
        role: "frontend dev",
        photo: yosifPhoto,
        bio: "Software developer with strong focus on Artificial Intelligence and advanced applications in Computer Vision and Neural Networks. Currently studying Information Technology at Borg El Arab University, working on AI-powered smart city graduation project.",
        skills: [
            "C++",
            "Python",
            "OpenCV",
            "YOLO",
            "TensorFlow",
            "Machine Learning",
            "Computer Vision",
            "Vue.js",
            "JavaScript",
            "Data Analysis",
        ],
        experience:
            "Developing AI-powered solutions for smart cities, autonomous systems, and computer vision applications. Building ML models and neural networks.",
        email: "youssafmohamed2002@gmail.com",
        location: "alexandria, egypt",
        socials: {
            github: "https://github.com/Youssaf-Mohamed",
            facebook: "https://www.facebook.com/share/1PYfDtMjbi/",
            instagram:
                "https://www.instagram.com/youssaf_kabbary?igsh=MXQ4d2dqcmRhOGpoYw==",
            whatsapp: "https://wa.me/+201150531800",
            gmail: "mailto:youssafmohamed2002@gmail.com",
        },
    },
];
</script>
