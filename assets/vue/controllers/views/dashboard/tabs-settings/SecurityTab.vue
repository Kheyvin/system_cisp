<template>
  <Card class="p-6 shadow-sm bg-white">
    <div class="flex flex-col gap-4 border-b border-gray-100 pb-5 md:flex-row md:items-start md:justify-between">
      <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">
          {{ content.badge }}
        </p>
        <h3 class="text-2xl font-bold text-gray-800 mt-1">
          {{ content.title }}
        </h3>
        <p class="text-gray-600 mt-2">
          {{ content.description }}
        </p>
      </div>
    </div>

    <div class="grid gap-6 py-5 md:grid-cols-2">
      <div class="rounded-2xl border border-gray-100 bg-gray-50/60 p-5 flex flex-col gap-5">
        <div>
          <h4 class="text-xl font-semibold text-gray-900">Configuración de Seguridad</h4>
          <p class="text-sm text-gray-600">Protege tu cuenta con configuraciones avanzadas.</p>
        </div>

        <div class="space-y-5">
          <div class="flex items-start justify-between gap-4">
            <div>
              <p class="text-base font-semibold text-gray-800">Autenticación de dos factores</p>
              <p class="text-sm text-gray-500">Agrega una capa extra de seguridad.</p>
            </div>
            <button
              class="relative inline-flex h-6 w-10 items-center rounded-full transition-colors cursor-pointer"
              :class="twoFactorEnabled ? 'bg-ksp-green' : 'bg-ksp-red'"
              type="button"
              @click="toggleTwoFactor"
            >
              <span class="sr-only">Cambiar autenticación de dos factores</span>
              <span
                class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"
                :class="twoFactorEnabled ? 'translate-x-4' : 'translate-x-1'"
              ></span>
            </button>
          </div>

          <div class="border-t border-gray-200"></div>

          <div class="flex items-start justify-between gap-4">
            <div>
              <p class="text-base font-semibold text-gray-800">Notificaciones de inicio de sesión</p>
              <p class="text-sm text-gray-500">Recibe alertas de nuevos accesos.</p>
            </div>
            <button
              class="relative inline-flex h-6 w-10 items-center rounded-full transition-colors cursor-pointer"
              :class="loginAlertsEnabled ? 'bg-ksp-green' : 'bg-ksp-red'"
              type="button"
              @click="toggleLoginAlerts"
            >
              <span class="sr-only">Cambiar notificaciones de inicio de sesión</span>
              <span
                class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"
                :class="loginAlertsEnabled ? 'translate-x-4' : 'translate-x-1'"
              ></span>
            </button>
          </div>

          <div class="border-t border-gray-200"></div>

          <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <label class="text-sm font-semibold text-gray-700" for="sessionDuration">
              Tiempo de sesión
            </label>
            <select
              id="sessionDuration"
              v-model.number="securitySessionDuration"
              class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-gray-800 focus:border-[#324D68] focus:ring-[#324D68] md:w-56"
            >
              <option
                v-for="option in securitySessionOptions"
                :key="option.value"
                :value="option.value"
              >
                {{ option.label }}
              </option>
            </select>
          </div>

          <div class="border-t border-gray-200"></div>

          <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
            <div>
              <p class="text-base font-semibold text-gray-800">Contraseña</p>
              <p class="text-sm text-gray-500">Última actualización: {{ securityLastPasswordUpdate }}</p>
            </div>
            <Button
              customClass="px-4 py-2 flex items-center gap-2 rounded-xl bg-[#324D68] text-white hover:bg-[#24384c] cursor-pointer"
            >
              <Icon name="lock" size="18" />
              Cambiar contraseña
            </Button>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-gray-100 p-5 bg-white flex flex-col gap-4">
        <div class="flex items-start justify-between">
          <div>
            <h4 class="text-xl font-semibold text-gray-900">Sesiones activas</h4>
            <p class="text-sm text-gray-600">Dispositivos con acceso a tu cuenta.</p>
          </div>
          <span class="rounded-full bg-ksp-principal/10 px-3 py-1 text-xs font-semibold text-ksp-principal">
            {{ activeSessions.length }} dispositivos
          </span>
        </div>

        <div class="max-h-80 overflow-y-auto pr-1 space-y-3">
          <div
            v-for="session in displayedSessions"
            :key="session.id"
            class="rounded-2xl border border-gray-100 p-4 flex flex-col gap-2"
          >
            <div class="flex items-start justify-between gap-3">
              <div class="flex items-start gap-3">
                <div class="rounded-xl bg-gray-100 p-2 text-[#324D68]">
                  <Icon :name="getSessionIcon(session.type)" size="20" />
                </div>
                <div>
                  <p class="text-base font-semibold text-gray-900">
                    {{ session.device }}
                  </p>
                  <p class="text-sm text-gray-500">{{ session.browser }}</p>
                </div>
              </div>
              <span
                v-if="session.current"
                class="rounded-full bg-ksp-green px-3 py-1 text-xs font-semibold text-white"
              >
                Actual
              </span>
            </div>
            <div class="text-sm text-gray-500">
              <p>{{ session.location }}</p>
              <p>{{ session.timestamp }}</p>
            </div>
            <div class="flex justify-end">
              <button
                v-if="!session.current"
                class="rounded-xl cursor-pointer border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-50"
                type="button"
                @click="handleCloseSession(session.id)"
              >
                Cerrar
              </button>
              <span
                v-else
                class="rounded-xl bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white"
              >
                Sesión activa
              </span>
            </div>
          </div>
        </div>

        <div class="flex flex-col gap-3">
          <div class="flex flex-wrap items-center justify-between gap-2">
            <Button
              customClass="px-4 py-2 rounded-xl border border-red-300 text-red-600 hover:bg-red-50 cursor-pointer"
              @click="handleCloseAllSessions"
            >
              Cerrar todas las sesiones
            </Button>
            <button
              v-if="hasMoreSessions"
              class="rounded-xl cursor-pointer border border-[#324D68] px-4 py-2 text-sm font-semibold text-[#324D68] hover:bg-[#324D68]/5"
              type="button"
              @click="toggleSessionsVisibility"
            >
              {{ showAllSessions ? 'Ver menos' : 'Ver todas las sesiones' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </Card>
</template>

<script setup>
import { computed, ref } from "vue";
import Card from "../../../components/ui/atoms/Card.vue";
import Button from "../../../components/ui/atoms/Button.vue";
import Icon from "../../../components/ui/atoms/Icon.vue";

defineProps({
  content: {
    type: Object,
    required: true,
  },
});

const twoFactorEnabled = ref(true);
const loginAlertsEnabled = ref(true);
const securitySessionDuration = ref(60);
const securitySessionOptions = [
  { value: 30, label: "30 minutos" },
  { value: 60, label: "60 minutos (1 hora)" },
  { value: 120, label: "120 minutos (2 horas)" },
  { value: 240, label: "240 minutos (4 horas)" },
];
const securityLastPasswordUpdate = ref("Hace 3 meses");

const activeSessions = ref([
  {
    id: "session-1",
    device: "Windows PC - Chrome",
    browser: "Windows 11 · Chrome 120",
    location: "Santiago, Chile",
    timestamp: "2024-01-22 14:30",
    type: "desktop",
    current: true,
  },
  {
    id: "session-2",
    device: "iPhone 12 - Safari",
    browser: "iOS 17 · Safari",
    location: "Santiago, Chile",
    timestamp: "2024-01-22 09:15",
    type: "mobile",
    current: false,
  },
  {
    id: "session-3",
    device: "Android - Chrome",
    browser: "Android 14 · Chrome 119",
    location: "Valparaíso, Chile",
    timestamp: "2024-01-21 20:45",
    type: "mobile",
    current: false,
  },
  {
    id: "session-4",
    device: "MacBook Pro - Safari",
    browser: "macOS 14 · Safari",
    location: "Buenos Aires, Argentina",
    timestamp: "2024-01-20 11:05",
    type: "desktop",
    current: false,
  },
]);

const showAllSessions = ref(false);

const displayedSessions = computed(() => {
  return showAllSessions.value ? activeSessions.value : activeSessions.value.slice(0, 3);
});

const hasMoreSessions = computed(() => activeSessions.value.length > 3);

const toggleTwoFactor = () => {
  twoFactorEnabled.value = !twoFactorEnabled.value;
};

const toggleLoginAlerts = () => {
  loginAlertsEnabled.value = !loginAlertsEnabled.value;
};

const getSessionIcon = (type) => {
  return type === "mobile" ? "smartphone" : "monitor";
};

const handleCloseSession = (sessionId) => {
  activeSessions.value = activeSessions.value.filter((session) => session.id !== sessionId);
};

const handleCloseAllSessions = () => {
  activeSessions.value = activeSessions.value.filter((session) => session.current);
  showAllSessions.value = false;
};

const toggleSessionsVisibility = () => {
  showAllSessions.value = !showAllSessions.value;
};
</script>
