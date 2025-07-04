<template>
    <div
        v-if="!isloading"
        :class="[
            'min-h-screen transition-all duration-500',
            isDark
                ? 'bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white'
                : 'bg-gradient-to-br from-slate-50 via-teal-50 to-white text-slate-800',
        ]"
    >
        <!-- Enhanced Animated Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Animated Background Orbs -->
            <div class="absolute inset-0">
                <div
                    :class="
                        isDark
                            ? 'absolute top-20 left-10 w-72 h-72 bg-teal-600/10 rounded-full blur-3xl animate-pulse'
                            : 'absolute top-20 left-10 w-72 h-72 bg-teal-200/30 rounded-full blur-3xl animate-pulse'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute top-40 right-20 w-80 h-80 bg-purple-600/10 rounded-full blur-3xl animate-pulse delay-1000'
                            : 'absolute top-40 right-20 w-80 h-80 bg-purple-200/30 rounded-full blur-3xl animate-pulse delay-1000'
                    "
                ></div>
                <div
                    :class="
                        isDark
                            ? 'absolute bottom-20 left-1/3 w-60 h-60 bg-cyan-600/10 rounded-full blur-3xl animate-pulse delay-2000'
                            : 'absolute bottom-20 left-1/3 w-60 h-60 bg-cyan-200/30 rounded-full blur-3xl animate-pulse delay-2000'
                    "
                ></div>
            </div>

            <!-- Floating Particles -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute top-1/4 left-1/4 w-2 h-2 bg-teal-400 rounded-full animate-float"
                ></div>
                <div
                    class="absolute top-1/3 left-3/4 w-1.5 h-1.5 bg-purple-400 rounded-full animate-float-delayed"
                ></div>
                <div
                    class="absolute top-2/3 left-1/6 w-2.5 h-2.5 bg-cyan-400 rounded-full animate-float-slow"
                ></div>
            </div>

            <!-- Fixed Geometric Shapes Around Quiz Area -->
            <!-- Diamond Shape - Top Left -->
            <div class="absolute inset-0 pointer-events-none">
                <div
                    :class="[
                        'absolute top-12 left-12 w-16 h-16 rotate-45 opacity-20',
                        isDark ? 'bg-teal-400' : 'bg-teal-300',
                    ]"
                ></div>

                <!-- Triangle Shape - Top Right -->
                <div
                    :class="[
                        'absolute top-16 right-16 w-0 h-0 opacity-15',
                        isDark
                            ? 'border-l-[20px] border-l-transparent border-r-[20px] border-r-transparent border-b-[35px] border-b-purple-400'
                            : 'border-l-[20px] border-l-transparent border-r-[20px] border-r-transparent border-b-[35px] border-b-purple-300',
                    ]"
                ></div>

                <!-- Hexagon Shape - Bottom Left -->
                <div
                    :class="[
                        'absolute bottom-20 left-16 w-12 h-12 opacity-25',
                        isDark ? 'bg-cyan-400' : 'bg-cyan-300',
                    ]"
                    style="
                        clip-path: polygon(
                            50% 0%,
                            100% 25%,
                            100% 75%,
                            50% 100%,
                            0% 75%,
                            0% 25%
                        );
                    "
                ></div>

                <!-- Square Shape - Bottom Right -->
                <div
                    :class="[
                        'absolute bottom-24 right-20 w-10 h-10 rotate-12 opacity-18',
                        isDark ? 'bg-teal-400' : 'bg-teal-300',
                    ]"
                ></div>

                <!-- Circle Shape - Middle Left -->
                <div
                    :class="[
                        'absolute top-1/2 left-8 w-8 h-8 rounded-full opacity-12',
                        isDark ? 'bg-purple-400' : 'bg-purple-300',
                    ]"
                ></div>

                <!-- Star Shape - Middle Right -->
                <div
                    :class="[
                        'absolute top-1/2 right-10 w-6 h-6 opacity-20',
                        isDark ? 'bg-cyan-400' : 'bg-cyan-300',
                    ]"
                    style="
                        clip-path: polygon(
                            50% 0%,
                            61% 35%,
                            98% 35%,
                            68% 57%,
                            79% 91%,
                            50% 70%,
                            21% 91%,
                            32% 57%,
                            2% 35%,
                            39% 35%
                        );
                    "
                ></div>

                <!-- Small Triangles - Scattered -->
                <div
                    :class="[
                        'absolute top-1/3 right-8 w-0 h-0 opacity-10',
                        isDark
                            ? 'border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-b-[14px] border-b-teal-400'
                            : 'border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-b-[14px] border-b-teal-300',
                    ]"
                ></div>

                <div
                    :class="[
                        'absolute bottom-1/3 left-6 w-0 h-0 opacity-12',
                        isDark
                            ? 'border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-b-[10px] border-b-purple-400'
                            : 'border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-b-[10px] border-b-purple-300',
                    ]"
                ></div>

                <!-- Abstract Lines -->
                <div
                    :class="[
                        'absolute top-1/4 left-4 w-12 h-0.5 rotate-45 opacity-8',
                        isDark
                            ? 'bg-gradient-to-r from-teal-400 to-transparent'
                            : 'bg-gradient-to-r from-teal-300 to-transparent',
                    ]"
                ></div>

                <div
                    :class="[
                        'absolute bottom-1/4 right-4 w-8 h-0.5 -rotate-30 opacity-8',
                        isDark
                            ? 'bg-gradient-to-r from-purple-400 to-transparent'
                            : 'bg-gradient-to-r from-purple-300 to-transparent',
                    ]"
                ></div>
            </div>
        </div>

        <div class="container mx-auto px-6 py-8 relative z-10 max-w-4xl">
            <!-- Enhanced Header Section -->
            <div class="flex items-center justify-between mb-8">
                <!-- Back Button -->
                <router-link
                    :to="{
                        name: 'video-detail',
                        params: { id: quizStore.quiz.video_id },
                    }"
                    :class="[
                        'group inline-flex items-center gap-3 px-6 py-3 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg',
                        isDark
                            ? 'bg-white/10 backdrop-blur-sm text-slate-300 hover:bg-white/20 hover:text-white border border-white/20 hover:border-teal-400/50'
                            : 'bg-white/90 backdrop-blur-sm text-slate-700 hover:bg-white hover:text-slate-900 border border-slate-200/70 hover:border-teal-400/70 shadow-xl',
                    ]"
                >
                    <font-awesome-icon
                        icon="arrow-left"
                        class="text-sm group-hover:-translate-x-1 transition-transform duration-300"
                    />
                    <span>Back to Video</span>
                </router-link>
            </div>

            <!-- Enhanced Quiz Title -->
            <div class="text-center mb-12">
                <h1
                    :class="[
                        'text-3xl md:text-4xl lg:text-5xl font-black mb-4 tracking-tight',
                        isDark
                            ? 'bg-gradient-to-r from-white via-teal-200 to-purple-200 bg-clip-text text-transparent'
                            : 'bg-gradient-to-r from-slate-900 via-teal-700 to-purple-700 bg-clip-text text-transparent',
                    ]"
                >
                    {{ quizStore.quiz.video_title }}
                </h1>

                <p
                    :class="[
                        'text-lg max-w-2xl mx-auto leading-relaxed',
                        isDark ? 'text-slate-300' : 'text-slate-600',
                    ]"
                >
                    Test your knowledge with this interactive quiz designed to
                    enhance your learning experience
                </p>
            </div>

            <!-- Enhanced Progress Section -->
            <div class="mb-10">
                <div
                    :class="[
                        'rounded-3xl p-8 border transition-all duration-500 shadow-2xl backdrop-blur-sm',
                        isDark
                            ? 'bg-white/8 border-white/15 hover:border-teal-400/40'
                            : 'bg-white/95 border-slate-200/70 hover:border-teal-400/60 shadow-xl',
                    ]"
                >
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div
                                :class="[
                                    'w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg',
                                    isDark
                                        ? 'bg-gradient-to-br from-teal-500/20 to-cyan-500/20 border border-teal-400/30'
                                        : 'bg-gradient-to-br from-teal-100/80 to-cyan-100/80 border border-teal-300/60',
                                ]"
                            >
                                <font-awesome-icon
                                    icon="list-ol"
                                    :class="[
                                        'text-lg',
                                        isDark
                                            ? 'text-teal-300'
                                            : 'text-teal-600',
                                    ]"
                                />
                            </div>
                            <div>
                                <h3
                                    :class="[
                                        'font-bold text-xl',
                                        isDark
                                            ? 'text-white'
                                            : 'text-slate-900',
                                    ]"
                                >
                                    Progress
                                </h3>
                                <p
                                    :class="[
                                        'text-sm',
                                        isDark
                                            ? 'text-slate-300'
                                            : 'text-slate-600',
                                    ]"
                                >
                                    {{ progressLabel }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div
                                :class="[
                                    'text-3xl font-black',
                                    isDark ? 'text-teal-400' : 'text-teal-600',
                                ]"
                            >
                                {{ Math.round(progressWidth) }}%
                            </div>
                            <div
                                :class="[
                                    'text-xs font-medium',
                                    isDark
                                        ? 'text-slate-400'
                                        : 'text-slate-500',
                                ]"
                            >
                                Complete
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Progress Bar -->
                    <div
                        :class="[
                            'w-full rounded-full h-3 shadow-inner',
                            isDark ? 'bg-slate-700/50' : 'bg-slate-200',
                        ]"
                    >
                        <div
                            :class="[
                                'h-3 rounded-full transition-all duration-700 ease-out shadow-lg',
                                isDark
                                    ? 'bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500'
                                    : 'bg-gradient-to-r from-teal-500 via-cyan-500 to-purple-500',
                            ]"
                            :style="{ width: progressWidth + '%' }"
                        ></div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Question Form -->
            <form @submit.prevent="handleSubmit" class="space-y-8">
                <!-- Current Question -->
                <div v-for="q in currentQuestions" :key="q.id" class="relative">
                    <div
                        :class="[
                            'rounded-3xl p-8 border transition-all duration-500 shadow-2xl backdrop-blur-sm',
                            isDark
                                ? 'bg-white/8 border-white/15 hover:border-orange-400/40'
                                : 'bg-white/95 border-slate-200/70 hover:border-orange-400/60 shadow-xl',
                        ]"
                    >
                        <!-- Enhanced Question Header -->
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-4">
                                <div
                                    :class="[
                                        'w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg',
                                        isDark
                                            ? 'bg-gradient-to-br from-orange-500/20 to-red-500/20 border border-orange-400/30'
                                            : 'bg-gradient-to-br from-orange-100/80 to-red-100/80 border border-orange-300/60',
                                    ]"
                                >
                                    <font-awesome-icon
                                        icon="question"
                                        :class="[
                                            'text-lg',
                                            isDark
                                                ? 'text-orange-300'
                                                : 'text-orange-600',
                                        ]"
                                    />
                                </div>
                                <span
                                    :class="[
                                        'px-4 py-2 rounded-full text-sm font-semibold',
                                        isDark
                                            ? 'bg-orange-500/30 text-orange-300 border border-orange-400/40'
                                            : 'bg-orange-100/90 text-orange-700 border border-orange-300/70',
                                    ]"
                                >
                                    Multiple Choice
                                </span>
                            </div>
                            <div class="text-right">
                                <div
                                    :class="[
                                        'text-sm font-medium',
                                        isDark
                                            ? 'text-slate-400'
                                            : 'text-slate-500',
                                    ]"
                                >
                                    Question
                                </div>
                                <div
                                    :class="[
                                        'text-2xl font-black',
                                        isDark
                                            ? 'text-orange-400'
                                            : 'text-orange-600',
                                    ]"
                                >
                                    {{ currentStep + 1 }}/{{
                                        allQuestions.length
                                    }}
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Question Text -->
                        <div class="mb-8">
                            <h2
                                :class="[
                                    'text-xl md:text-2xl font-bold leading-relaxed',
                                    isDark ? 'text-white' : 'text-slate-900',
                                ]"
                            >
                                {{ q.text }}
                            </h2>
                        </div>

                        <!-- Enhanced Options -->
                        <div class="space-y-4">
                            <label
                                v-for="(option, optionIndex) in q.options"
                                :key="option.id"
                                class="block cursor-pointer group"
                            >
                                <input
                                    type="radio"
                                    :name="'q' + q.id"
                                    :value="option.id"
                                    v-model="selectedAnswers[q.id]"
                                    class="sr-only"
                                />
                                <div
                                    :class="[
                                        'flex items-center gap-4 p-6 rounded-2xl border-2 transition-all duration-300 transform hover:scale-105 shadow-lg',
                                        selectedAnswers[q.id] === option.id
                                            ? isDark
                                                ? 'border-teal-500 bg-teal-500/10 shadow-2xl shadow-teal-500/20'
                                                : 'border-teal-500 bg-teal-50 shadow-2xl shadow-teal-500/20'
                                            : isDark
                                            ? 'border-slate-600 bg-slate-700/30 hover:border-slate-500 hover:bg-slate-700/50'
                                            : 'border-slate-200 bg-slate-50 hover:border-slate-300 hover:bg-slate-100',
                                    ]"
                                >
                                    <!-- Enhanced Option Letter Circle -->
                                    <div
                                        :class="[
                                            'w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg transition-all duration-300 shadow-lg',
                                            selectedAnswers[q.id] === option.id
                                                ? 'bg-gradient-to-r from-teal-500 to-cyan-500 text-white scale-110'
                                                : isDark
                                                ? 'bg-slate-600 text-slate-300 border border-slate-500'
                                                : 'bg-white text-slate-600 border border-slate-300 shadow-md',
                                        ]"
                                    >
                                        {{
                                            String.fromCharCode(
                                                65 + optionIndex
                                            )
                                        }}
                                    </div>

                                    <!-- Enhanced Option Text -->
                                    <div class="flex-1">
                                        <p
                                            :class="[
                                                'font-semibold text-lg transition-colors duration-300',
                                                selectedAnswers[q.id] ===
                                                option.id
                                                    ? isDark
                                                        ? 'text-teal-300'
                                                        : 'text-teal-700'
                                                    : isDark
                                                    ? 'text-slate-200'
                                                    : 'text-slate-700',
                                            ]"
                                        >
                                            {{ option.text }}
                                        </p>
                                    </div>

                                    <!-- Enhanced Selected Check Icon -->
                                    <div
                                        :class="[
                                            'w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300 shadow-lg',
                                            selectedAnswers[q.id] === option.id
                                                ? 'bg-gradient-to-r from-teal-500 to-cyan-500 scale-100 opacity-100'
                                                : 'bg-transparent scale-75 opacity-0',
                                        ]"
                                    >
                                        <font-awesome-icon
                                            icon="check"
                                            class="text-white text-sm"
                                        />
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Navigation Controls -->
                <div class="flex justify-between items-center">
                    <button
                        type="button"
                        @click="prev"
                        :disabled="currentStep === 0"
                        :class="[
                            'flex items-center gap-3 px-8 py-4 rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg',
                            currentStep === 0
                                ? 'opacity-50 cursor-not-allowed'
                                : 'hover:-translate-x-1',
                            isDark
                                ? 'bg-slate-700/50 text-slate-300 hover:bg-slate-600/70 border border-slate-600/50'
                                : 'bg-slate-200 text-slate-700 hover:bg-slate-300 border border-slate-300/70',
                        ]"
                    >
                        <font-awesome-icon
                            icon="chevron-left"
                            class="text-sm"
                        />
                        <span>Previous</span>
                    </button>

                    <!-- Enhanced Question Counter -->
                    <div
                        :class="[
                            'px-6 py-4 rounded-2xl border shadow-lg backdrop-blur-sm',
                            isDark
                                ? 'bg-white/10 border-white/20 text-slate-300'
                                : 'bg-white/90 border-slate-200/70 text-slate-600',
                        ]"
                    >
                        <span class="text-lg font-bold">
                            {{ currentStep + 1 }} of {{ allQuestions.length }}
                        </span>
                    </div>

                    <button
                        v-if="currentStep < totalSteps - 1"
                        type="button"
                        @click="next"
                        class="flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 hover:translate-x-1 shadow-2xl shadow-teal-500/25"
                    >
                        <span>Next</span>
                        <font-awesome-icon
                            icon="chevron-right"
                            class="text-sm"
                        />
                    </button>

                    <button
                        v-else
                        type="submit"
                        class="flex items-center gap-3 px-10 py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white rounded-2xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-2xl shadow-green-500/25"
                    >
                        <font-awesome-icon icon="paper-plane" class="text-sm" />
                        <span>Submit Quiz</span>
                    </button>
                </div>
            </form>

            <!-- Enhanced Quiz Stats -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    :class="[
                        'rounded-3xl p-8 border text-center transition-all duration-500 shadow-2xl backdrop-blur-sm hover:scale-105',
                        isDark
                            ? 'bg-white/8 border-white/15 hover:border-blue-400/40'
                            : 'bg-white/95 border-slate-200/70 hover:border-blue-400/60 shadow-xl',
                    ]"
                >
                    <div
                        :class="[
                            'w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg',
                            isDark
                                ? 'bg-gradient-to-br from-blue-500/20 to-cyan-500/20 border border-blue-400/30'
                                : 'bg-gradient-to-br from-blue-100/80 to-cyan-100/80 border border-blue-300/60',
                        ]"
                    >
                        <font-awesome-icon
                            icon="clock"
                            :class="[
                                'text-2xl',
                                isDark ? 'text-blue-300' : 'text-blue-600',
                            ]"
                        />
                    </div>
                    <div
                        :class="[
                            'text-2xl font-black mb-2',
                            isDark ? 'text-white' : 'text-slate-900',
                        ]"
                    >
                        {{ Math.floor(timeSpent / 60) }}:{{
                            String(timeSpent % 60).padStart(2, "0")
                        }}
                    </div>
                    <div
                        :class="[
                            'text-sm font-semibold',
                            isDark ? 'text-slate-400' : 'text-slate-500',
                        ]"
                    >
                        Time Spent
                    </div>
                </div>

                <div
                    :class="[
                        'rounded-3xl p-8 border text-center transition-all duration-500 shadow-2xl backdrop-blur-sm hover:scale-105',
                        isDark
                            ? 'bg-white/8 border-white/15 hover:border-green-400/40'
                            : 'bg-white/95 border-slate-200/70 hover:border-green-400/60 shadow-xl',
                    ]"
                >
                    <div
                        :class="[
                            'w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg',
                            isDark
                                ? 'bg-gradient-to-br from-green-500/20 to-emerald-500/20 border border-green-400/30'
                                : 'bg-gradient-to-br from-green-100/80 to-emerald-100/80 border border-green-300/60',
                        ]"
                    >
                        <font-awesome-icon
                            icon="check-circle"
                            :class="[
                                'text-2xl',
                                isDark ? 'text-green-300' : 'text-green-600',
                            ]"
                        />
                    </div>
                    <div
                        :class="[
                            'text-2xl font-black mb-2',
                            isDark ? 'text-white' : 'text-slate-900',
                        ]"
                    >
                        {{ answeredCount }}
                    </div>
                    <div
                        :class="[
                            'text-sm font-semibold',
                            isDark ? 'text-slate-400' : 'text-slate-500',
                        ]"
                    >
                        Answered
                    </div>
                </div>

                <div
                    :class="[
                        'rounded-3xl p-8 border text-center transition-all duration-500 shadow-2xl backdrop-blur-sm hover:scale-105',
                        isDark
                            ? 'bg-white/8 border-white/15 hover:border-orange-400/40'
                            : 'bg-white/95 border-slate-200/70 hover:border-orange-400/60 shadow-xl',
                    ]"
                >
                    <div
                        :class="[
                            'w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg',
                            isDark
                                ? 'bg-gradient-to-br from-orange-500/20 to-red-500/20 border border-orange-400/30'
                                : 'bg-gradient-to-br from-orange-100/80 to-red-100/80 border border-orange-300/60',
                        ]"
                    >
                        <font-awesome-icon
                            icon="hourglass-half"
                            :class="[
                                'text-2xl',
                                isDark ? 'text-orange-300' : 'text-orange-600',
                            ]"
                        />
                    </div>
                    <div
                        :class="[
                            'text-2xl font-black mb-2',
                            isDark ? 'text-white' : 'text-slate-900',
                        ]"
                    >
                        {{ allQuestions.length - answeredCount }}
                    </div>
                    <div
                        :class="[
                            'text-sm font-semibold',
                            isDark ? 'text-slate-400' : 'text-slate-500',
                        ]"
                    >
                        Remaining
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Loading State -->
    <div
        v-else
        :class="[
            'min-h-screen flex items-center justify-center',
            isDark
                ? 'bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900'
                : 'bg-gradient-to-br from-slate-50 via-teal-50 to-white',
        ]"
    >
        <div class="text-center">
            <div class="relative mb-8">
                <div
                    :class="[
                        'w-20 h-20 border-4 rounded-full animate-spin shadow-2xl',
                        isDark
                            ? 'border-teal-500/30 border-t-teal-500'
                            : 'border-teal-500/30 border-t-teal-500',
                    ]"
                ></div>
            </div>
            <div
                :class="[
                    'rounded-3xl p-8 border shadow-2xl backdrop-blur-sm',
                    isDark
                        ? 'bg-white/8 border-white/15'
                        : 'bg-white/95 border-slate-200/70 shadow-xl',
                ]"
            >
                <h3
                    :class="[
                        'text-xl font-bold mb-3',
                        isDark ? 'text-white' : 'text-slate-900',
                    ]"
                >
                    Loading Quiz
                </h3>
                <p
                    :class="[
                        'text-lg',
                        isDark ? 'text-slate-300' : 'text-slate-600',
                    ]"
                >
                    Preparing your assessment...
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useQuizStore } from "@/stores/quizStore";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faArrowLeft,
    faChevronLeft,
    faChevronRight,
    faBrain,
    faQuestion,
    faCheck,
    faCheckCircle,
    faClock,
    faHourglassHalf,
    faListOl,
    faPaperPlane,
    faMoon,
    faSun,
} from "@fortawesome/free-solid-svg-icons";
import { useTheme } from "@/composables/useTheme";

library.add(
    faArrowLeft,
    faChevronLeft,
    faChevronRight,
    faBrain,
    faQuestion,
    faCheck,
    faCheckCircle,
    faClock,
    faHourglassHalf,
    faListOl,
    faPaperPlane,
    faMoon,
    faSun
);

const isloading = ref(true);
const route = useRoute();
const router = useRouter();
const quizStore = useQuizStore();
const { isDark, toggleTheme } = useTheme();

// Quiz State
const questionsPerPage = 1;
const currentStep = ref(0);
const selectedAnswers = ref({});
const timeSpent = ref(0);
const timer = ref(null);

// Computed Properties
const allQuestions = computed(() => {
    return (quizStore.quiz?.questions || []).map((q) => ({
        id: q.question_id,
        text: q.text,
        options: q.options.map((opt) => ({
            text: opt.option_text,
            id: opt.option_id,
        })),
    }));
});

const totalSteps = computed(() =>
    Math.ceil(allQuestions.value.length / questionsPerPage)
);

const currentQuestions = computed(() => {
    const start = currentStep.value * questionsPerPage;
    return allQuestions.value.slice(start, start + questionsPerPage);
});

const progressWidth = computed(() => {
    return allQuestions.value.length > 0
        ? ((currentStep.value + 1) / allQuestions.value.length) * 100
        : 0;
});

const progressLabel = computed(
    () => `Question ${currentStep.value + 1} of ${allQuestions.value.length}`
);

const answeredCount = computed(() => {
    return Object.values(selectedAnswers.value).filter(
        (answer) => answer !== null
    ).length;
});

// Timer Management
const startTimer = () => {
    timer.value = setInterval(() => {
        timeSpent.value++;
    }, 1000);
};

const stopTimer = () => {
    if (timer.value) {
        clearInterval(timer.value);
        timer.value = null;
    }
};

// Lifecycle
onMounted(async () => {
    const videoId = route.params.videoId;
    if (!videoId) {
        console.error("No video ID provided in route");
        return;
    }

    try {
        await quizStore.fetchQuizByVideoId(videoId);
        isloading.value = false;

        // Initialize selectedAnswers
        allQuestions.value.forEach((q) => {
            selectedAnswers.value[q.id] = null;
        });

        startTimer();
    } catch (error) {
        console.error("Failed to load quiz:", error);
    }
});

onUnmounted(() => {
    stopTimer();
});

// Methods
function selectAnswer(questionId, option) {
    selectedAnswers.value[questionId] = option.id;
}

function prev() {
    if (currentStep.value > 0) {
        currentStep.value--;
    }
}

function next() {
    if (currentStep.value < totalSteps.value - 1) {
        currentStep.value++;
    }
}

async function handleSubmit() {
    const answers = allQuestions.value.map((q) => {
        const selectedOptionId = selectedAnswers.value[q.id];
        return {
            question_id: q.id,
            selected_option_id: selectedOptionId,
        };
    });

    if (answers.some((a) => a.selected_option_id === null)) {
        alert("Please answer all questions before submitting.");
        return;
    }

    try {
        stopTimer();
        await quizStore.submitAnswers(route.params.videoId, answers);
        await router.push({
            name: "quiz-result",
            params: { videoId: route.params.videoId },
        });
    } catch (err) {
        console.error("Failed to submit quiz:", err);
        alert("Failed to submit quiz. Please try again.");
    }
}
</script>

<style scoped>
/* Enhanced Professional Animations */
@keyframes float {
    0% {
        transform: translateY(0);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-15px);
        opacity: 1;
    }
    100% {
        transform: translateY(0);
        opacity: 0.6;
    }
}

@keyframes float-orb {
    0% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-20px) scale(1.1);
        opacity: 0.9;
    }
    100% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
}

@keyframes float-orb-delayed {
    0% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-30px) scale(1.15);
        opacity: 0.9;
    }
    100% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
}

@keyframes float-orb-slow {
    0% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-15px) scale(1.05);
        opacity: 0.8;
    }
    100% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
}

@keyframes glow {
    0% {
        transform: scale(1);
        opacity: 0.4;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 0.4;
    }
}

.animate-float {
    animation: float 4s ease-in-out infinite;
}

.animate-float-orb {
    animation: float-orb 6s ease-in-out infinite;
}

.animate-float-orb-delayed {
    animation: float-orb-delayed 8s ease-in-out infinite;
    animation-delay: 2s;
}

.animate-float-orb-slow {
    animation: float-orb-slow 10s ease-in-out infinite;
    animation-delay: 1s;
}

.animate-glow {
    animation: glow 4s ease-in-out infinite;
}

/* Particle Animations */
.particle-1 {
    animation: float 3.5s ease-in-out infinite;
}
.particle-2 {
    animation: float 4s ease-in-out infinite;
}
.particle-3 {
    animation: float 4.5s ease-in-out infinite;
}
.particle-4 {
    animation: float 3.8s ease-in-out infinite;
}
.particle-5 {
    animation: float 4.2s ease-in-out infinite;
}

.glow-particle-1 {
    animation: glow 4.5s ease-in-out infinite;
}
.glow-particle-2 {
    animation: glow 5s ease-in-out infinite;
}
.glow-particle-3 {
    animation: glow 4.8s ease-in-out infinite;
}

/* Enhanced Glass Card Effect */
.glass-card-premium {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.15);
}

/* Enhanced Focus States */
button:focus,
input:focus,
label:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.3);
    border-radius: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .glass-card-premium {
        backdrop-filter: blur(15px);
    }

    .text-3xl {
        font-size: 1.875rem;
    }

    .text-4xl {
        font-size: 2.25rem;
    }

    .text-5xl {
        font-size: 3rem;
    }
}

/* Accessibility Improvements */
.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

/* Enhanced Hover Effects */
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.group:hover .group-hover\:translate-x-1 {
    transform: translateX(0.25rem);
}

/* Smooth Transitions */
* {
    transition: all 0.2s ease;
}

/* Professional Shadow Effects */
.shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.shadow-3xl {
    box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
</style>
