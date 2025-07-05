<template>
    <div
        :class="
            isDark
                ? 'min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800'
        "
    >
        <section class="relative overflow-hidden">
            <div class="container mx-auto px-6 py-16 relative z-10">
                <!-- Header section -->
                <div class="text-center mb-16">
                    <h1 class="text-5xl md:text-6xl font-black mb-6">
                        <span
                            :class="[
                                'bg-clip-text text-transparent',
                                isDark
                                    ? 'bg-gradient-to-r from-white via-teal-100 to-purple-100'
                                    : 'bg-gradient-to-r from-slate-900 via-teal-800 to-purple-800',
                            ]"
                        >
                            Contact Us
                        </span>
                    </h1>
                    <p
                        :class="[
                            'text-xl max-w-2xl mx-auto leading-relaxed',
                            isDark ? 'text-slate-300' : 'text-slate-600',
                        ]"
                    >
                        We'd love to hear from you! Reach out with questions,
                        feedback, or just to say hello.
                        <span
                            :class="
                                isDark
                                    ? 'text-teal-400 font-semibold'
                                    : 'text-teal-700 font-semibold'
                            "
                            >Let's connect</span
                        >
                        and start a conversation.
                    </p>
                </div>

                <!-- Contact Content -->
                <div class="max-w-6xl mx-auto grid lg:grid-cols-2 gap-12">
                    <!-- Contact Form -->
                    <div
                        :class="[
                            'group relative transform transition-all duration-700 hover:scale-105 hover:-translate-y-2',
                            isDark
                                ? 'glass-card-premium rounded-3xl shadow-2xl overflow-hidden border border-white/10 backdrop-blur-xl hover:shadow-teal-500/20 hover:border-teal-500/30'
                                : 'bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-teal-200/40 hover:shadow-teal-500/20 hover:border-teal-500/50',
                        ]"
                    >
                        <!-- Decorative Background -->
                        <div
                            :class="
                                isDark
                                    ? 'absolute inset-0 bg-gradient-to-br from-teal-500/5 via-cyan-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                    : 'absolute inset-0 bg-gradient-to-br from-teal-100/30 via-cyan-100/30 to-purple-100/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                            "
                        ></div>

                        <div class="relative z-10 p-8">
                            <!-- Form Header -->
                            <div class="flex items-center gap-4 mb-8">
                                <div
                                    :class="
                                        isDark
                                            ? 'w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg'
                                            : 'w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg'
                                    "
                                >
                                    <font-awesome-icon
                                        icon="envelope"
                                        class="text-white text-xl"
                                    />
                                </div>
                                <div>
                                    <h3
                                        :class="
                                            isDark
                                                ? 'text-2xl font-bold text-white'
                                                : 'text-2xl font-bold text-slate-900'
                                        "
                                    >
                                        Send Message
                                    </h3>
                                    <p
                                        :class="
                                            isDark
                                                ? 'text-slate-400'
                                                : 'text-slate-600'
                                        "
                                    >
                                        Fill out the form below
                                    </p>
                                </div>
                            </div>

                            <!-- Contact Form -->
                            <form
                                @submit.prevent="submitForm"
                                class="space-y-6"
                            >
                                <!-- Name Field -->
                                <div>
                                    <label
                                        :class="
                                            isDark
                                                ? 'block text-sm font-semibold text-slate-300 mb-2'
                                                : 'block text-sm font-semibold text-slate-700 mb-2'
                                        "
                                    >
                                        Full Name
                                    </label>
                                    <div class="relative">
                                        <div
                                            :class="
                                                isDark
                                                    ? 'absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400'
                                                    : 'absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-500'
                                            "
                                        >
                                            <font-awesome-icon icon="user" />
                                        </div>
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            required
                                            :class="[
                                                'w-full pl-12 pr-4 py-4 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2',
                                                isDark
                                                    ? 'bg-white/10 border-white/20 text-white placeholder:text-slate-400 focus:border-teal-500/50 focus:bg-white/15'
                                                    : 'bg-white/80 border-slate-200 text-slate-900 placeholder:text-slate-500 focus:border-teal-500 focus:bg-white',
                                            ]"
                                            placeholder="Enter your full name"
                                        />
                                    </div>
                                </div>

                                <!-- Email Field -->
                                <div>
                                    <label
                                        :class="
                                            isDark
                                                ? 'block text-sm font-semibold text-slate-300 mb-2'
                                                : 'block text-sm font-semibold text-slate-700 mb-2'
                                        "
                                    >
                                        Email Address
                                    </label>
                                    <div class="relative">
                                        <div
                                            :class="
                                                isDark
                                                    ? 'absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400'
                                                    : 'absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-500'
                                            "
                                        >
                                            <font-awesome-icon
                                                icon="envelope"
                                            />
                                        </div>
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            required
                                            :class="[
                                                'w-full pl-12 pr-4 py-4 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2',
                                                isDark
                                                    ? 'bg-white/10 border-white/20 text-white placeholder:text-slate-400 focus:border-teal-500/50 focus:bg-white/15'
                                                    : 'bg-white/80 border-slate-200 text-slate-900 placeholder:text-slate-500 focus:border-teal-500 focus:bg-white',
                                            ]"
                                            placeholder="Enter your email address"
                                        />
                                    </div>
                                </div>

                                <!-- Message Field -->
                                <div>
                                    <label
                                        :class="
                                            isDark
                                                ? 'block text-sm font-semibold text-slate-300 mb-2'
                                                : 'block text-sm font-semibold text-slate-700 mb-2'
                                        "
                                    >
                                        Message
                                    </label>
                                    <div class="relative">
                                        <div
                                            :class="
                                                isDark
                                                    ? 'absolute left-4 top-4 text-slate-400'
                                                    : 'absolute left-4 top-4 text-slate-500'
                                            "
                                        >
                                            <font-awesome-icon icon="comment" />
                                        </div>
                                        <textarea
                                            v-model="form.message"
                                            required
                                            rows="5"
                                            :class="[
                                                'w-full pl-12 pr-4 py-4 rounded-xl border transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 resize-none',
                                                isDark
                                                    ? 'bg-white/10 border-white/20 text-white placeholder:text-slate-400 focus:border-teal-500/50 focus:bg-white/15'
                                                    : 'bg-white/80 border-slate-200 text-slate-900 placeholder:text-slate-500 focus:border-teal-500 focus:bg-white',
                                            ]"
                                            placeholder="Tell us about your inquiry..."
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button
                                    type="submit"
                                    :disabled="loading"
                                    :class="[
                                        'w-full py-4 px-8 rounded-xl font-semibold text-white shadow-lg transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2',
                                        loading
                                            ? 'bg-slate-500 cursor-not-allowed'
                                            : 'bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 hover:shadow-teal-500/25',
                                    ]"
                                >
                                    <span
                                        v-if="loading"
                                        class="flex items-center justify-center gap-2"
                                    >
                                        <div
                                            class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"
                                        ></div>
                                        Sending Message...
                                    </span>
                                    <span
                                        v-else
                                        class="flex items-center justify-center gap-2"
                                    >
                                        <font-awesome-icon icon="paper-plane" />
                                        Send Message
                                    </span>
                                </button>

                                <!-- Success/Error Messages -->
                                <div
                                    v-if="success"
                                    class="p-4 rounded-xl bg-green-500/20 border border-green-500/30"
                                >
                                    <div
                                        class="flex items-center gap-2 text-green-400"
                                    >
                                        <font-awesome-icon
                                            icon="check-circle"
                                        />
                                        <span class="font-semibold"
                                            >Thank you for contacting us! We'll
                                            get back to you soon.</span
                                        >
                                    </div>
                                </div>

                                <div
                                    v-if="error"
                                    class="p-4 rounded-xl bg-red-500/20 border border-red-500/30"
                                >
                                    <div
                                        class="flex items-center gap-2 text-red-400"
                                    >
                                        <font-awesome-icon
                                            icon="exclamation-circle"
                                        />
                                        <span class="font-semibold">{{
                                            error
                                        }}</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Information & Map -->
                    <div class="space-y-8">
                        <!-- Contact Info Card -->
                        <div
                            :class="[
                                'group relative transform transition-all duration-700 hover:scale-105 hover:-translate-y-2',
                                isDark
                                    ? 'glass-card-premium rounded-3xl shadow-2xl overflow-hidden border border-white/10 backdrop-blur-xl hover:shadow-purple-500/20 hover:border-purple-500/30'
                                    : 'bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-purple-200/40 hover:shadow-purple-500/20 hover:border-purple-500/50',
                            ]"
                        >
                            <!-- Decorative Background -->
                            <div
                                :class="
                                    isDark
                                        ? 'absolute inset-0 bg-gradient-to-br from-purple-500/5 via-cyan-500/5 to-teal-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                        : 'absolute inset-0 bg-gradient-to-br from-purple-100/30 via-cyan-100/30 to-teal-100/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                "
                            ></div>

                            <div class="relative z-10 p-8">
                                <!-- Card Header -->
                                <div class="flex items-center gap-4 mb-8">
                                    <div
                                        :class="
                                            isDark
                                                ? 'w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg'
                                                : 'w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg'
                                        "
                                    >
                                        <font-awesome-icon
                                            icon="map-marker-alt"
                                            class="text-white text-xl"
                                        />
                                    </div>
                                    <div>
                                        <h3
                                            :class="
                                                isDark
                                                    ? 'text-2xl font-bold text-white'
                                                    : 'text-2xl font-bold text-slate-900'
                                            "
                                        >
                                            Visit Us
                                        </h3>
                                        <p
                                            :class="
                                                isDark
                                                    ? 'text-slate-400'
                                                    : 'text-slate-600'
                                            "
                                        >
                                            Our location & contact details
                                        </p>
                                    </div>
                                </div>

                                <!-- Contact Details -->
                                <div class="space-y-6">
                                    <!-- Address -->
                                    <div class="flex items-start gap-4">
                                        <div
                                            :class="
                                                isDark
                                                    ? 'w-10 h-10 bg-teal-500/20 rounded-lg flex items-center justify-center'
                                                    : 'w-10 h-10 bg-teal-100/60 rounded-lg flex items-center justify-center'
                                            "
                                        >
                                            <font-awesome-icon
                                                icon="building"
                                                :class="
                                                    isDark
                                                        ? 'text-teal-400'
                                                        : 'text-teal-600'
                                                "
                                            />
                                        </div>
                                        <div>
                                            <h4
                                                :class="
                                                    isDark
                                                        ? 'font-semibold text-white mb-1'
                                                        : 'font-semibold text-slate-900 mb-1'
                                                "
                                            >
                                                Borg El-Arab Technological
                                                University
                                            </h4>
                                            <p
                                                :class="
                                                    isDark
                                                        ? 'text-slate-400 text-sm leading-relaxed'
                                                        : 'text-slate-600 text-sm leading-relaxed'
                                                "
                                            >
                                                VH5C+8H8, Unnamed Road, Hod
                                                Sakrah WA Abu Hamad,<br />
                                                Borg El Arab, Alexandria
                                                Governorate 5220211, Egypt
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="flex items-center gap-4">
                                        <div
                                            :class="
                                                isDark
                                                    ? 'w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center'
                                                    : 'w-10 h-10 bg-purple-100/60 rounded-lg flex items-center justify-center'
                                            "
                                        >
                                            <font-awesome-icon
                                                icon="envelope"
                                                :class="
                                                    isDark
                                                        ? 'text-purple-400'
                                                        : 'text-purple-600'
                                                "
                                            />
                                        </div>
                                        <div>
                                            <h4
                                                :class="
                                                    isDark
                                                        ? 'font-semibold text-white mb-1'
                                                        : 'font-semibold text-slate-900 mb-1'
                                                "
                                            >
                                                Email Us
                                            </h4>
                                            <a
                                                href="mailto:info@ctu.edu.eg"
                                                :class="
                                                    isDark
                                                        ? 'text-purple-400 hover:text-purple-300 transition-colors duration-300'
                                                        : 'text-purple-600 hover:text-purple-700 transition-colors duration-300'
                                                "
                                            >
                                                info@ctu.edu.eg
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="flex items-center gap-4">
                                        <div
                                            :class="
                                                isDark
                                                    ? 'w-10 h-10 bg-cyan-500/20 rounded-lg flex items-center justify-center'
                                                    : 'w-10 h-10 bg-cyan-100/60 rounded-lg flex items-center justify-center'
                                            "
                                        >
                                            <font-awesome-icon
                                                icon="phone"
                                                :class="
                                                    isDark
                                                        ? 'text-cyan-400'
                                                        : 'text-cyan-600'
                                                "
                                            />
                                        </div>
                                        <div>
                                            <h4
                                                :class="
                                                    isDark
                                                        ? 'font-semibold text-white mb-1'
                                                        : 'font-semibold text-slate-900 mb-1'
                                                "
                                            >
                                                Call Us
                                            </h4>
                                            <a
                                                href="tel:+201234567890"
                                                :class="
                                                    isDark
                                                        ? 'text-cyan-400 hover:text-cyan-300 transition-colors duration-300'
                                                        : 'text-cyan-600 hover:text-cyan-700 transition-colors duration-300'
                                                "
                                            >
                                                +20 115 053 1800
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Working Hours -->
                                    <div class="flex items-center gap-4">
                                        <div
                                            :class="
                                                isDark
                                                    ? 'w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center'
                                                    : 'w-10 h-10 bg-emerald-100/60 rounded-lg flex items-center justify-center'
                                            "
                                        >
                                            <font-awesome-icon
                                                icon="clock"
                                                :class="
                                                    isDark
                                                        ? 'text-emerald-400'
                                                        : 'text-emerald-600'
                                                "
                                            />
                                        </div>
                                        <div>
                                            <h4
                                                :class="
                                                    isDark
                                                        ? 'font-semibold text-white mb-1'
                                                        : 'font-semibold text-slate-900 mb-1'
                                                "
                                            >
                                                Working Hours
                                            </h4>
                                            <p
                                                :class="
                                                    isDark
                                                        ? 'text-slate-400 text-sm'
                                                        : 'text-slate-600 text-sm'
                                                "
                                            >
                                                All week: 9:00 AM - 2:00 PM
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Map Card -->
                        <div
                            :class="[
                                'group relative transform transition-all duration-700 hover:scale-105 hover:-translate-y-2',
                                isDark
                                    ? 'glass-card-premium rounded-3xl shadow-2xl overflow-hidden border border-white/10 backdrop-blur-xl hover:shadow-cyan-500/20 hover:border-cyan-500/30'
                                    : 'bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-cyan-200/40 hover:shadow-cyan-500/20 hover:border-cyan-500/50',
                            ]"
                        >
                            <!-- Decorative Background -->
                            <div
                                :class="
                                    isDark
                                        ? 'absolute inset-0 bg-gradient-to-br from-cyan-500/5 via-teal-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                        : 'absolute inset-0 bg-gradient-to-br from-cyan-100/30 via-teal-100/30 to-purple-100/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500'
                                "
                            ></div>

                            <div class="relative z-10 p-8">
                                <!-- Map Header -->
                                <div class="flex items-center gap-4 mb-6">
                                    <div
                                        :class="
                                            isDark
                                                ? 'w-10 h-10 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg'
                                                : 'w-10 h-10 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-xl flex items-center justify-center shadow-lg'
                                        "
                                    >
                                        <font-awesome-icon
                                            icon="map"
                                            class="text-white text-lg"
                                        />
                                    </div>
                                    <div>
                                        <h3
                                            :class="
                                                isDark
                                                    ? 'text-xl font-bold text-white'
                                                    : 'text-xl font-bold text-slate-900'
                                            "
                                        >
                                            Our Location
                                        </h3>
                                        <p
                                            :class="
                                                isDark
                                                    ? 'text-slate-400 text-sm'
                                                    : 'text-slate-600 text-sm'
                                            "
                                        >
                                            Find us on the map
                                        </p>
                                    </div>
                                </div>

                                <!-- Google Map -->
                                <div
                                    class="rounded-2xl overflow-hidden shadow-lg"
                                >
                                    <GoogleMapEmbed
                                        :lat="30.8582961"
                                        :lng="29.5713993"
                                        :zoom="16"
                                        title="Borg El-Arab Technological University, Alexandria, Egypt"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faEnvelope,
    faUser,
    faComment,
    faPaperPlane,
    faMapMarkerAlt,
    faBuilding,
    faPhone,
    faClock,
    faMap,
    faCheckCircle,
    faExclamationCircle,
} from "@fortawesome/free-solid-svg-icons";
import GoogleMapEmbed from "../components/ui/GoogleMapEmbed.vue";
import { useTheme } from "../composables/useTheme";

library.add(
    faEnvelope,
    faUser,
    faComment,
    faPaperPlane,
    faMapMarkerAlt,
    faBuilding,
    faPhone,
    faClock,
    faMap,
    faCheckCircle,
    faExclamationCircle
);

const { isDark } = useTheme();

const form = ref({ name: "", email: "", message: "" });
const loading = ref(false);
const success = ref(false);
const error = ref("");

async function submitForm() {
    loading.value = true;
    error.value = "";
    success.value = false;

    try {
        await axios.post("/api/contact", form.value);
        success.value = true;
        form.value = { name: "", email: "", message: "" };
    } catch (e) {
        error.value =
            e.response?.data?.message ||
            "Failed to send message. Please try again later.";
    } finally {
        loading.value = false;
    }
}
</script>

<style scoped>
.glass-card-premium {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

@keyframes float {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }
    33% {
        transform: translateY(-10px) rotate(1deg);
    }
    66% {
        transform: translateY(5px) rotate(-1deg);
    }
}

@keyframes float-delayed {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }
    33% {
        transform: translateY(-15px) rotate(-1deg);
    }
    66% {
        transform: translateY(8px) rotate(1deg);
    }
}

@keyframes float-slow {
    0%,
    100% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(2deg);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

.animate-float-delayed {
    animation: float-delayed 8s ease-in-out infinite;
    animation-delay: 2s;
}

.animate-float-slow {
    animation: float-slow 10s ease-in-out infinite;
    animation-delay: 1s;
}

.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

button:focus,
a:focus {
    outline: 2px solid #14b8a6;
    outline-offset: 2px;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.1);
}

button:focus-visible,
a:focus-visible,
router-link:focus-visible {
    outline: 2px solid #14b8a6;
    outline-offset: 4px;
    box-shadow: 0 0 0 4px rgba(20, 184, 166, 0.2);
}

.dark button:focus-visible,
.dark a:focus-visible,
.dark router-link:focus-visible {
    outline: 2px solid #5eead4;
    outline-offset: 4px;
    box-shadow: 0 0 0 4px rgba(94, 234, 212, 0.3);
}

@media (max-width: 768px) {
    .glass-card-premium {
        backdrop-filter: blur(15px);
    }
    .text-5xl {
        font-size: 2.5rem;
    }
    .text-6xl {
        font-size: 3rem;
    }
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.glass-card-premium:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.2);
}
</style>
