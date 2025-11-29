<template>
  <header class="relative z-40 flex h-20 items-center justify-between border-b border-gray-200 bg-white px-6 shadow-sm">
    <div class="flex items-center gap-4">
      <Button
        class="cursor-pointer"
        @click="$emit('toggle-sidebar')"
        :class="[
          'p-2 transition-colors duration-200 rounded-2xl',
          isSidebarOpen
            ? 'text-[#324D68] hover:bg-[#324D68] hover:text-white'
            : 'bg-[#324D68] text-white',
        ]"
      >
        <Icon name="sidebar" size="22" />
      </Button>

      <div class="flex flex-col space-y-1">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">KSPeru</p>
        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
          <span class="font-semibold text-gray-900">Cliente ID: #12345</span>
          <span class="text-gray-300">•</span>
          <span>Plan: Premium 100MB</span>
        </div>
      </div>
    </div>

    <div class="flex items-center gap-5">
      <div ref="notificationMenuRef" class="relative">
        <button
          type="button"
          class="relative flex h-11 w-11 items-center justify-center rounded-2xl border border-gray-200 bg-white text-gray-600 transition hover:border-gray-300 hover:text-[#324D68] cursor-pointer"
          @click.stop="toggleNotifications"
          aria-label="Abrir notificaciones"
        >
          <Icon name="bell" size="20" />
          <span
            v-if="unreadNotifications > 0"
            class="absolute -right-0.5 -top-0.5 inline-flex h-5  items-center justify-center rounded-full bg-[#324D68] px-1 text-xs font-semibold text-white"
          >
            {{ unreadNotifications }}
          </span>
        </button>

        <transition name="fade-scale">
          <div
            v-if="showNotifications"
            class="absolute right-0 z-50 mt-3 w-80 rounded-2xl border border-gray-100 bg-white shadow-2xl"
          >
            <div class="flex items-center justify-between border-b border-gray-100 p-4">
              <div>
                <p class="text-sm font-semibold text-gray-900">Notificaciones</p>
                <p class="text-xs text-gray-500">Recibos, solicitudes y promociones</p>
              </div>
              <button
                type="button"
                class="cursor-pointer text-xs font-semibold text-[#324D68] hover:underline"
                @click.stop="markNotificationsRead"
              >
                Marcar leído
              </button>
            </div>
            <ul class="divide-y divide-gray-100">
              <li v-for="item in notifications" :key="item.id">
                <button
                  type="button"
                  class="flex w-full items-start gap-3 p-4 text-left hover:bg-gray-50 cursor-pointer"
                  @click.stop="handleNotificationClick(item)"
                >
                  <span :class="['mt-1 inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold', notificationTypeClasses[item.type]]">
                    {{ notificationTypeLabels[item.type] }}
                  </span>
                  <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-900">{{ item.title }}</p>
                    <p class="text-sm text-gray-500">{{ item.description }}</p>
                    <span v-if="item.meta" class="mt-1 inline-flex text-xs font-semibold text-[#324D68]">
                      {{ item.meta }}
                    </span>
                  </div>
                  <Icon name="chevron-right" size="16" class="text-gray-300" />
                </button>
              </li>
            </ul>
            <div class="border-t border-gray-100 p-3 text-center">
              <RouterLink
                to="/dashboard/notificaciones"
                class="text-sm font-semibold text-[#324D68] hover:underline cursor-pointer"
                @click="closeMenus"
              >
                Ver todas las notificaciones
              </RouterLink>
            </div>
          </div>
        </transition>
      </div>

      <div ref="userMenuRef" class="relative">
        <button
          type="button"
          class="flex items-center gap-3 rounded-2xl border border-gray-100 bg-white px-3 py-2 text-left shadow-sm transition hover:shadow-md cursor-pointer"
          @click.stop="toggleUserMenu"
        >
          <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#324D68]/10 text-base font-semibold text-[#324D68]">
            {{ userInitials }}
          </div>
          <div class="hidden sm:flex sm:flex-col">
            <span class="text-sm font-semibold text-gray-900">{{ user.name }}</span>
            <span class="text-xs text-gray-500">{{ user.email }}</span>
          </div>
          <Icon name="chevron-down" size="16" class="text-gray-400" />
        </button>

        <transition name="fade-scale">
          <div
            v-if="showUserMenu"
            class="absolute right-0 z-50 mt-3 w-64 rounded-2xl border border-gray-100 bg-white shadow-2xl"
          >
            <div class="border-b border-gray-100 p-4">
              <p class="text-sm font-semibold text-gray-900">{{ user.name }}</p>
              <p class="text-xs text-gray-500">{{ user.role }}</p>
            </div>
            <ul class="divide-y divide-gray-100">
              <li v-for="option in userMenuOptions" :key="option.label">
                <button
                  type="button"
                  class="flex w-full items-center gap-3 p-4 text-left text-sm text-gray-700 hover:bg-gray-50 cursor-pointer"
                  @click.stop="handleUserOption(option)"
                >
                  <Icon :name="option.icon" size="18" class="text-[#324D68]" />
                  <div class="flex flex-col">
                    <span class="font-semibold">{{ option.label }}</span>
                    <span class="text-xs text-gray-500">{{ option.helper }}</span>
                  </div>
                </button>
              </li>
            </ul>
            <div class="border-t border-gray-100 p-4 text-center">
              <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">Portal KSPeru</p>
              <p class="text-xs font-semibold text-gray-600">Versión 1.1.3</p>
            </div>
          </div>
        </transition>
      </div>
    </div>
  </header>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from "vue";
import { RouterLink, useRouter } from "vue-router";
import Button from "../atoms/Button.vue";
import Icon from "../atoms/Icon.vue";

defineProps({
  isSidebarOpen: {
    type: Boolean,
    default: true,
  },
});

const emit = defineEmits(["toggle-sidebar", "logout"]);

const router = useRouter();

const notifications = ref([
  {
    id: 1,
    title: "Recibo de noviembre disponible",
    description: "Descarga tu recibo antes del 05 de diciembre.",
    type: "recibo",
    meta: "Factura #98711",
    route: { path: "/dashboard/pagos", query: { tab: "billing" } },
    read: false,
  },
  {
    id: 2,
    title: "Solicitud de soporte respondida",
    description: "Nuestro equipo contestó tu ticket #4589.",
    type: "solicitud",
    meta: "Ver detalle",
    route: { path: "/dashboard/soporte", query: { ticket: "4589" } },
    read: false,
  },
  {
    id: 3,
    title: "Promoción exclusiva",
    description: "Obtén un upgrade a 200MB por 3 meses.",
    type: "promocion",
    meta: "Aprovechar ahora",
    route: null,
    read: false,
  },
]);

const notificationTypeLabels = {
  recibo: "Recibo",
  solicitud: "Solicitud",
  promocion: "Promo",
};

const notificationTypeClasses = {
  recibo: "bg-emerald-50 text-emerald-700",
  solicitud: "bg-sky-50 text-sky-700",
  promocion: "bg-amber-50 text-amber-700",
};

const showNotifications = ref(false);
const showUserMenu = ref(false);
const notificationMenuRef = ref(null);
const userMenuRef = ref(null);

const unreadNotifications = computed(() => notifications.value.filter((item) => !item.read).length);

const user = ref({
  name: "María Fernanda Quispe",
  email: "mfernanda@ksperu.com",
  role: "Administradora",
});

const userMenuOptions = [
  {
    label: "Ver perfil",
    helper: "Gestiona tus datos",
    icon: "user",
    route: { path: "/dashboard/configuracion", query: { tab: "profile" } },
  },
  {
    label: "Centro de ayuda",
    helper: "Resuelve dudas rápidamente",
    icon: "message-square",
    route: { path: "/dashboard/soporte" },
  },
  {
    label: "Cerrar sesión",
    helper: "Salir de KSPeru",
    icon: "log-out",
    action: "logout",
  },
];

const userInitials = computed(() => {
  return user.value.name
    .split(" ")
    .filter(Boolean)
    .slice(0, 2)
    .map((word) => word[0]?.toUpperCase() ?? "")
    .join("");
});

const toggleNotifications = () => {
  showNotifications.value = !showNotifications.value;
  if (showNotifications.value) {
    showUserMenu.value = false;
  }
};

const toggleUserMenu = () => {
  showUserMenu.value = !showUserMenu.value;
  if (showUserMenu.value) {
    showNotifications.value = false;
  }
};

const closeMenus = () => {
  showNotifications.value = false;
  showUserMenu.value = false;
};

const handleNotificationClick = (item) => {
  if (!item.read) {
    item.read = true;
  }
  if (item.route) {
    router.push(item.route);
  }
  closeMenus();
};

const markNotificationsRead = () => {
  notifications.value = notifications.value.map((notification) => ({
    ...notification,
    read: true,
  }));
};

const handleUserOption = (option) => {
  if (option.action === "logout") {
    emit("logout");
    closeMenus();
    return;
  }

  if (option.route) {
    router.push(option.route);
  }

  closeMenus();
};

const handleClickOutside = (event) => {
  const notificationEl = notificationMenuRef.value;
  const userEl = userMenuRef.value;

  if (notificationEl && notificationEl.contains(event.target)) {
    return;
  }
  if (userEl && userEl.contains(event.target)) {
    return;
  }
  closeMenus();
};

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>

<style scoped>
button,
.btn {
  outline: none !important;
}

button:focus,
button:focus-visible,
button:active {
  outline: none !important;
  box-shadow: none !important;
}

.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.fade-scale-enter-from,
.fade-scale-leave-to {
  opacity: 0;
  transform: translateY(6px) scale(0.98);
}
</style>