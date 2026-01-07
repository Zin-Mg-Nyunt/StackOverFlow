import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import axios from 'axios';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import Layout from './layouts/Layout.vue';
import { Ziggy } from './ziggy.js';

const appName = import.meta.env.VITE_APP_NAME || 'Stack Overflow';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => {
        const pages = import.meta.glob('./pages/**/*.vue', { eager: true });
        let page = pages[`./pages/${name}.vue`];
        page.default.layout = page.default.layout === null ? null : Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// Axios Interceptor ကို setup လုပ်ခြင်း
axios.interceptors.response.use(
    (response) => response,
    (error) => {
        // အကယ်၍ Backend က Middleware ကနေ 401 (Unauthorized) ပြန်လာရင်
        if (error.response && error.response.status === 401) {
            const currentUrl = window.location.href;
            const loginPath = '/login';

            // Login page ကို redirect parameter နဲ့အတူ လွှတ်လိုက်မယ်
            window.location.href = `${loginPath}?redirect=${currentUrl}`;
        }
        return Promise.reject(error);
    },
);

// This will set light / dark mode on page load...
initializeTheme();
