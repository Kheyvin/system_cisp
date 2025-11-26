import { createRouter, createWebHistory } from 'vue-router';
// import { authStore } from '../store/auth'; // Para autenticación
//import Login from '../components/Login.vue';
import DashboardLayout from '../components/ui/templates/DashboardLayout.vue';

import Home from '../views/dashboard/Home.vue';
import Receipts from '../views/dashboard/Receipts.vue';
import Requests from '../views/dashboard/Requests.vue';
import Promotions from '../views/dashboard/Promotions.vue';
import Payments from '../views/dashboard/Payments.vue';
import Settings from '../views/dashboard/Settings.vue';

const routes = [
  {
    path: '/',
    name: 'HomeRedirect',
    redirect: '/dashboard',
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Home,
    meta: { layout: DashboardLayout, requiresAuth: false },
  },
  {
    path: '/dashboard/recibos',
    name: 'Receipts',
    component: Receipts,
    meta: { layout: DashboardLayout, requiresAuth: false },
  },
  {
    path: '/dashboard/solicitudes',
    name: 'Requests',
    component: Requests,
    meta: { layout: DashboardLayout, requiresAuth: false },
  },
  {
    path: '/dashboard/promociones',
    name: 'Promotions',
    component: Promotions,
    meta: { layout: DashboardLayout, requiresAuth: false },
  },
  {
    path: '/dashboard/pagos',
    name: 'Payments',
    component: Payments,
    meta: { layout: DashboardLayout, requiresAuth: false },
  },
  {
    path: '/dashboard/configuracion',
    name: 'Settings',
    component: Settings,
    meta: { layout: DashboardLayout, requiresAuth: false },
  },
 /*  {
    path: '/login',
    name: 'Login',
    component: Login,
  }, */
];

// 📌 Función para asignar DashboardLayout como predeterminado
function addLayoutToRoute(route, parentLayout = DashboardLayout) {
  route.meta = route.meta || {};
  route.meta.layout = route.meta.layout || parentLayout;

  if (route.children) {
    route.children = route.children.map((childRoute) =>
      addLayoutToRoute(childRoute, route.meta.layout)
    );
  }
  return route;
}

// Asignamos DashboardLayout a todas las rutas
const formattedRoutes = routes.map((route) => addLayoutToRoute(route));

// Creamos el Router
const router = createRouter({
  history: createWebHistory(),
  routes: formattedRoutes,
  scrollBehavior(to, from, savedPosition) {
    if (to.hash) {
      return { el: to.hash, behavior: 'smooth' };
    }
    return savedPosition || { left: 0, top: 0, behavior: 'smooth' };
  },
});

// Middleware para autenticación
router.beforeEach(async (to, from, next) => {
  // const auth = authStore();

  // if (to.meta.requiresAuth && !auth.isAuthenticated) {
  //   await auth.checkAuth();
  //   if (!auth.isAuthenticated) {
  //     return next({ name: 'Login' });
  //   }
  // }
  next();
});

export default router;
