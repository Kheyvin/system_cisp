<template>
  <div id="app">
    <component :is="layout">
      <router-view :key="$route.fullPath" />
    </component>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";
import { authStore } from "./store/auth";
import DashboardLayout from "../../vue/controllers/components/ui/templates/DashboardLayout.vue";

const route = useRoute();
const store = authStore();

// Si no está autenticado se carga el layout de login
const layout = computed(() => {
  // Habilitar para que salga el login
  // if (!store.isAuthenticated) {
  //   return "layout-login";
  // }
  if (typeof route.meta.layout === "string") {
    return `layout-${route.meta.layout.toLowerCase()}`;
  }
  return DashboardLayout;
});
</script>

<style scoped>
/* Puedes agregar estilos aquí si es necesario */
</style>
