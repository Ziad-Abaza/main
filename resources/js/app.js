import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import UiToast from './components/ui/Toast.vue';
import 'flowbite';
import { FwbAlert, FwbButton, FwbCard, FwbAvatar } from 'flowbite-vue';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import {
    faGraduationCap,
    faHouse,
    faUsers,
    faUserShield,
    faChalkboardTeacher,
    faRightFromBracket,
    faBars,
    faXmark,
    faAward,
    faRocket,
    faArrowRight,
    faBookOpen,
    faCertificate,
    faClock,
    faStar
} from "@fortawesome/free-solid-svg-icons";

import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

library.add(
    faGraduationCap,
    faHouse,
    faUsers,
    faUserShield,
    faChalkboardTeacher,
    faRightFromBracket,
    faBars,
    faXmark,
    faAward,
    faRocket,
    faArrowRight,
    faBookOpen,
    faCertificate,
    faClock,
    faStar
);


library.add(faGraduationCap, faHouse, faUsers, faUserShield, faChalkboardTeacher, faRightFromBracket, faBars, faXmark);


const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.component('font-awesome-icon', FontAwesomeIcon);
app.component('UiToast', UiToast);
app.component('FwbAlert', FwbAlert);
app.component('FwbButton', FwbButton);
app.component('FwbCard', FwbCard);
app.component('FwbAvatar', FwbAvatar);
app.mount('#app');
