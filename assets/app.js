import { registerVueControllerComponents } from '@symfony/ux-vue';
import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)

import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./vue/controllers/App.vue";
import router from './vue/controllers/router/Index';
import DashboardLayout from './vue/controllers/components/ui/templates/DashboardLayout.vue';
import { authStore } from "./vue/controllers/store/auth"; // nuevo import
import './styles/app.css';

const app = createApp(App);
app.component("layout-dashboard", DashboardLayout);

app.use(router);
const pinia = createPinia();
app.use(pinia);

/* router.beforeEach(async (to, from, next) => {
    const store = authStore();
    // Si hay token pero no se ha cargado el usuario, se intenta cargar
    if (store.token && !store.user) {
        await store.checkAuth();
    }
    if (to.path === '/login') {
        return next();
    }
    if (!store.isAuthenticated) {
        return next({ path: '/login' });
    }
    next();
});
 */
router.beforeEach((to, from, next) => {
  next();
});

app.mount("#app");

registerVueControllerComponents(require.context('./vue/controllers', true, /\.vue$/));