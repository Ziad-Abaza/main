import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import Home from '../views/Home.vue';
import Login from '../views/auth/LoginView.vue';
import Register from '../views/auth/RegisterView.vue';
import Logout from '../views/auth/LogoutView.vue';
import Courses from '../views/Courses.vue';
import Course_details from '../views/CourseDetails.vue';
// Instructor Components
import Categories from '../views/Categories.vue';
import Videos from '../views/Videos.vue';
import Videodetails from '../views/Videodetails.vue';
import Instructors from '../views/Instructors.vue';
import Quiz from '../views/Quiz.vue';
import QuizResult from '../views/QuizResults.vue';
import InstructorProfile from '../views/InstructorProfile.vue';
import lms from '../views/Lms.vue';
import About from '../views/About.vue';
import Privacy from '../views/Privacy.vue';
import Terms from '../views/Terms.vue';
import FAQ from '../views/FAQ.vue';
import Blog from '../views/Blog.vue';
import News from '../views/News.vue';
import NewsDetail from '../views/NewsDetail.vue';
import Contact from '../views/Contact.vue';
import Hack from '../views/Hack.vue';
import TeamView from '../views/TeamView.vue';

const routes = [{
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/courses',
        name: 'courses',
        component: Courses,
    },
    {
        path: '/courses/:id',
        name: 'courses-detail',
        component: Course_details,
        props: true,
    },
    {
        path: '/videos/:id',
        name: 'videos',
        component: Videos,
        meta: { requiresAuth: true }
    },
    {
        path: '/video/:id',
        name: 'video-detail',
        component: Videodetails,
        props: true,
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { guest: true }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { guest: true }
    },
    {
        path: '/categories',
        name: 'categories',
        component: Categories,
    },
    {
        path: '/instructors',
        name: 'instructors',
        component: Instructors,
    },
    {
        path: '/quiz/:videoId',
        name: 'quiz',
        component: Quiz,
    },
    {
        path: '/quiz-result/:videoId',
        name: 'quiz-result',
        component: QuizResult,
    },
    {
        path: '/instructors/:id',
        name: 'instructor-profile',
        component: InstructorProfile,
        props: true,
    },
    {
        path: '/lms/:page/:id',
        name: 'lms-page-id',
        component: () =>
            import ('../views/lmsDynamicPage.vue'),
        props: true,
        meta: { requiresAuth: true }
    },
    {
        path: '/lms/:page',
        name: 'lms-page',
        component: lms,
        props: true,
        meta: { requiresAuth: true }
    },
    {
        path: '/lms',
        redirect: '/lms/overview'
    },
    {
        path: '/assignments/:id',
        name: 'assignment-view',
        component: () =>
            import ('../views/AssignmentPage.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/clear',
        name: 'clear',
        component: Logout,
        meta: { requiresAuth: true }
    },
    {
        path: '/about',
        name: 'about',
        component: About,
    },
    {
        path: '/privacy',
        name: 'privacy',
        component: Privacy,
    },
    {
        path: '/terms',
        name: 'terms',
        component: Terms,
    },
    {
        path: '/faq',
        name: 'faq',
        component: FAQ,
    },
    {
        path: '/blog',
        name: 'blog',
        component: Blog,
    },
    {
        path: '/news',
        name: 'news',
        component: News,
    },
    {
        path: '/news/:id',
        name: 'news-detail',
        component: NewsDetail,
        props: true,
    },
    {
        path: '/contact',
        name: 'contact',
        component: Contact,
    },
    {
        path: '/hack',
        name: 'hack',
        component: Hack,
    },
    {
        path: '/team',
        name: 'team',
        component: TeamView,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'not-found',
        component: () =>
            import ('../views/NotFound.vue')
    },
    // Instructor Routes
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach(async(to, from, next) => {
    const authStore = useAuthStore();
    const isAuthenticated = authStore.isAuthenticated;
    const isAdmin = authStore.isAdmin;
    const isInstructor = authStore.isInstructor; // Get instructor status

    // Routes that require authentication
    if (to.meta.requiresAuth) {
        if (!isAuthenticated) {
            next({ name: 'login' });
            return;
        }
    }
    next();
});

export default router;