import { createRouter, createWebHistory } from 'vue-router';
// import { authStore } from '../store/auth'; // Para autenticación
import Dashboard from '../views/Dashboard.vue';
import Login from '../components/Login.vue';
import DashboardLayout from '../layouts/Dashboard.vue';
import Servicios from '../views/Servicios.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    redirect: '/dashboard',
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: Dashboard,
    meta: { layout: 'dashboard', requiresAuth: false },
  },
  {
    path: '/servicios',
    name: 'Servicios',
    component: Servicios,
    meta: { layout: 'dashboard', requiresAuth: false },
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
  },
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
