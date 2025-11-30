<template>
  <div class="relative space-y-6">
    <div
      class="rounded-3xl border border-gray-100 bg-white px-6 py-6 shadow-sm md:px-8"
    >
      <div
        class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between"
      >
        <div class="space-y-4">
          <div>
            <p class="text-xs uppercase tracking-wide text-gray-400">
              Centro de configuración
            </p>
            <h1 class="text-3xl font-bold text-gray-900">Panel principal</h1>
          </div>
          <p class="text-gray-600">
            Administra tu perfil, credenciales, notificaciones y preferencias de
            privacidad desde un mismo lugar.
          </p>
        </div>
        <div class="flex w-full flex-col gap-2 md:w-auto md:items-end">
          <div class="flex flex-wrap items-center gap-3">
            <span class="text-xs uppercase tracking-wide text-gray-400"
              >Estado de verificación</span
            >
            <span
              :class="[
                'inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold border',
                verificationBadge.classes,
              ]"
            >
              {{ verificationBadge.label }}
            </span>
          </div>
          <Button
            v-if="showVerifyButton"
            customClass="bg-transparent border border-[#1F7A4D] text-[#1F7A4D] hover:bg-[#1F7A4D]/10 px-4 py-2 flex items-center gap-2 rounded-xl text-sm font-semibold cursor-pointer"
            @click="openVerificationModal"
          >
            <Icon name="shield-check" size="16" />
            Verificar usuario
          </Button>
          <p v-else class="text-xs text-gray-500">
            Verificación completada con éxito.
          </p>
        </div>
      </div>
    </div>

    <TabGroup :tabs="settingsTabs" v-model="activeSettingsTab" />

    <component :is="currentTabComponent" :content="currentTabContent" />

    <transition name="modal-fade">
      <div
        v-if="showVerifyModal"
        class="fixed inset-0 z-999 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4"
      >
        <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">
          <div
            class="flex items-start justify-between border-b border-gray-100 p-5"
          >
            <div>
              <p
                class="text-xs font-semibold uppercase tracking-wide text-gray-400"
              >
                Verificación segura
              </p>
              <h3 class="mt-1 text-2xl font-bold text-gray-900">
                Confirma tu identidad
              </h3>
              <p class="mt-1 text-sm text-gray-600">
                Envía un código único a tu correo o celular para verificar que
                eres el administrador de la cuenta.
              </p>
            </div>
            <button
              type="button"
              class="text-gray-400 hover:text-gray-600 cursor-pointer"
              @click="closeVerificationModal"
              aria-label="Cerrar"
            >
              <Icon name="x" size="18" />
            </button>
          </div>

          <div class="space-y-5 p-5">
            <div>
              <p class="mb-3 text-sm font-semibold text-gray-700">
                ¿Dónde quieres recibir el código?
              </p>
              <div class="grid gap-3 md:grid-cols-2">
                <label
                  class="flex cursor-pointer items-center gap-2 rounded-xl border px-3 py-3 text-sm font-semibold"
                  :class="
                    verificationMethod === 'email'
                      ? 'border-[#1F7A4D] bg-[#1F7A4D]/5 text-[#1F7A4D]'
                      : 'border-gray-200 text-gray-600'
                  "
                >
                  <input
                    type="radio"
                    class="sr-only"
                    value="email"
                    v-model="verificationMethod"
                  />
                  <Icon name="message-square" size="16" />
                  Correo electrónico
                </label>
                <label
                  class="flex cursor-pointer items-center gap-2 rounded-xl border px-3 py-3 text-sm font-semibold"
                  :class="
                    verificationMethod === 'sms'
                      ? 'border-[#1F7A4D] bg-[#1F7A4D]/5 text-[#1F7A4D]'
                      : 'border-gray-200 text-gray-600'
                  "
                >
                  <input
                    type="radio"
                    class="sr-only"
                    value="sms"
                    v-model="verificationMethod"
                  />
                  <Icon name="smartphone" size="16" />
                  SMS / WhatsApp
                </label>
              </div>
            </div>

            <div class="space-y-3">
              <label
                class="text-sm font-semibold text-gray-700"
                :for="`contact-${verificationMethod}`"
              >
                {{
                  verificationMethod === "email"
                    ? "Correo electrónico"
                    : "Número de celular"
                }}
              </label>
              <input
                :id="`contact-${verificationMethod}`"
                v-model.trim="contactValue"
                :placeholder="
                  verificationMethod === 'email'
                    ? 'tucorreo@empresa.com'
                    : '+51 999 888 777'
                "
                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-gray-900 focus:border-[#1F7A4D] focus:ring-[#1F7A4D]"
                type="text"
              />
              <p class="text-xs text-gray-500">
                Usaremos este dato únicamente para enviarte el código de
                seguridad. El código tiene una vigencia de 3 minutos.
              </p>
              <Button
                customClass="w-full justify-center bg-[#1F7A4D] text-white hover:bg-[#17603B] px-4 py-2 rounded-xl text-sm font-semibold cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed"
                :disabled="!canSendCode"
                @click="sendVerificationCode"
              >
                {{
                  countdownSeconds > 0
                    ? "Código enviado"
                    : "Enviar código de verificación"
                }}
              </Button>
              <p
                v-if="countdownSeconds > 0"
                class="text-xs font-semibold text-[#1F7A4D]"
              >
                Puedes volver a solicitar un código en {{ formattedCountdown }}.
              </p>
            </div>

            <div class="space-y-3">
              <label
                class="text-sm font-semibold text-gray-700"
                for="verificationCode"
                >Código recibido</label
              >
              <input
                id="verificationCode"
                v-model.trim="verificationCode"
                maxlength="6"
                placeholder="Ingresa el código de 6 dígitos"
                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-center text-lg font-semibold tracking-[0.4em] text-gray-900 focus:border-[#1F7A4D] focus:ring-[#1F7A4D]"
              />
            </div>

            <div class="flex flex-col gap-3 md:flex-row md:justify-end">
              <Button
                customClass="w-full justify-center border border-gray-200 text-gray-600 hover:bg-gray-50 px-4 py-2 rounded-xl cursor-pointer"
                @click="closeVerificationModal"
              >
                Cancelar
              </Button>
              <Button
                customClass="w-full justify-center bg-[#1F7A4D] text-white hover:bg-[#17603B] px-4 py-2 rounded-xl cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed"
                :disabled="!canConfirmVerification"
                @click="handleVerificationConfirm"
              >
                Confirmar verificación
              </Button>
            </div>
          </div>
        </div>
      </div>
    </transition>

    <transition name="toast-slide">
      <div
        v-if="showVerificationToast"
        class="fixed bottom-6 right-6 z-20 w-full max-w-sm rounded-2xl border border-amber-200 bg-white shadow-lg"
      >
        <div class="flex items-start gap-3 p-4">
          <span
            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-50 text-amber-600"
          >
            <Icon name="alert-circle" size="20" />
          </span>
          <div class="flex-1">
            <p class="text-sm font-semibold text-amber-800">
              Debes verificar tu usuario
            </p>
            <p class="text-sm text-amber-700">
              Por seguridad, completa el proceso de verificación para seguir
              administrando la cuenta sin restricciones.
            </p>
          </div>
          <button
            class="rounded-full p-1 text-gray-400 hover:text-gray-600 cursor-pointer"
            type="button"
            @click="dismissVerificationToast"
          >
            <Icon name="x" size="16" />
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { computed, onBeforeUnmount, ref, watch } from "vue";
import TabGroup from "../../components/ui/molecules/TabGroup.vue";
import Button from "../../components/ui/atoms/Button.vue";
import Icon from "../../components/ui/atoms/Icon.vue";
import ProfileTab from "./tabs-settings/ProfileTab.vue";
import SecurityTab from "./tabs-settings/SecurityTab.vue";
import NotificationTab from "./tabs-settings/NotificationTab.vue";
import PrivacyTab from "./tabs-settings/PrivacyTab.vue";
import BillingTab from "./tabs-settings/BillingTab.vue";
import InfoTab from "./tabs-settings/InfoTab.vue";

const settingsTabs = [
  { label: "Perfil", value: "profile" },
  { label: "Seguridad", value: "security" },
  { label: "Notificaciones", value: "notifications" },
  { label: "Privacidad", value: "privacy" },
  { label: "Facturación", value: "billing" },
];

const activeSettingsTab = ref(settingsTabs[0].value);
const verificationStatus = ref("unverified");
const verificationToastDismissed = ref(false);
const showVerifyModal = ref(false);
const verificationMethod = ref("email");
const contactValue = ref("");
const verificationCode = ref("");
const countdownSeconds = ref(0);
let countdownTimer = null;

const tabContentMap = {
  profile: {
    badge: "Información Personal",
    title: "Perfil del titular",
    description:
      "Actualiza tu nombre, datos de contacto y preferencias básicas.",
    ctaLabel: "Editar perfil",
    details: [
      { label: "Nombre", value: "María Fernanda Quispe" },
      { label: "Correo principal", value: "mfernanda@empresa.com" },
      { label: "Teléfono", value: "+51 999 555 444", helper: "Verificado" },
      { label: "Cargo", value: "Administradora TI" },
    ],
    actions: [
      "Actualizar foto y datos generales",
      "Gestionar contactos autorizados",
      "Definir horario de atención preferido",
      "Sincronizar datos con directorio corporativo",
    ],
  },
  security: {
    badge: "Protección",
    title: "Seguridad y acceso",
    description:
      "Refuerza tus credenciales y métodos de acceso para resguardar la cuenta.",
    ctaLabel: "Configurar seguridad",
    details: [
      { label: "Estado de MFA", value: "Activo", helper: "App Authenticator" },
      { label: "Último cambio de contraseña", value: "12 Abr 2024" },
      { label: "Sesiones abiertas", value: "2 dispositivos" },
      { label: "IP de acceso reciente", value: "190.40.55.18" },
    ],
    actions: [
      "Cambiar contraseña",
      "Revisar dispositivos conectados",
      "Regenerar códigos de respaldo",
      "Configurar políticas de expiración",
    ],
  },
  notifications: {
    badge: "Alertas",
    title: "Preferencias de notificación",
    description:
      "Controla qué avisos recibes por correo, SMS o dentro de la plataforma.",
    ctaLabel: "Editar notificaciones",
    details: [
      { label: "Canal principal", value: "Correo corporativo" },
      { label: "Alertas críticas", value: "Activas 24/7" },
      { label: "Resumen semanal", value: "Enviado los lunes 08:00" },
      { label: "SMS operativos", value: "Solo incidencias" },
    ],
    actions: [
      "Personalizar frecuencia de reportes",
      "Añadir correos de respaldo",
      "Configurar alertas push",
      "Silenciar temporalmente campañas",
    ],
  },
  privacy: {
    badge: "Control de datos",
    title: "Configuración de Privacidad",
    description: "Controla cómo se usa tu información personal.",
    ctaLabel: "Gestionar privacidad",
    details: [
      { label: "Visibilidad del perfil", value: "Solo equipo financiero" },
      {
        label: "Compartición de datos",
        value: "Limitada",
        helper: "Fuentes internas",
      },
      { label: "Logs auditables", value: "Retención 12 meses" },
      { label: "Consentimientos", value: "4 aceptados" },
    ],
    actions: [
      "Actualizar consentimiento legal",
      "Descargar reporte de actividad",
      "Solicitar anonimización",
      "Configurar acceso por roles",
    ],
  },
  billing: {
    badge: "Finanzas",
    title: "Configuración de Facturación",
    description: "Personaliza cómo recibes y gestionas tus facturas.",
    ctaLabel: "Gestionar facturación",
    details: [],
    actions: [],
  },
};

const currentTabContent = computed(
  () => tabContentMap[activeSettingsTab.value] ?? tabContentMap.profile
);

const verificationBadge = computed(() => {
  if (verificationStatus.value === "verified") {
    return {
      label: "Cliente verificado",
      classes: "bg-[#14804A] text-white border-transparent",
    };
  }

  return {
    label: "Verificación pendiente",
    classes: "bg-[#B34700] text-white border-transparent",
  };
});

const showVerifyButton = computed(
  () => verificationStatus.value === "unverified"
);
const showVerificationToast = computed(
  () => showVerifyButton.value && !verificationToastDismissed.value
);
const canSendCode = computed(
  () => !!contactValue.value && countdownSeconds.value === 0
);
const canConfirmVerification = computed(
  () =>
    verificationCode.value.length >= 4 &&
    contactValue.value !== "" &&
    countdownSeconds.value > 0
);
const formattedCountdown = computed(() => {
  const minutes = Math.floor(countdownSeconds.value / 60)
    .toString()
    .padStart(2, "0");
  const seconds = (countdownSeconds.value % 60).toString().padStart(2, "0");
  return `${minutes}:${seconds}`;
});

const openVerificationModal = () => {
  showVerifyModal.value = true;
  verificationMethod.value = "email";
  contactValue.value = "";
  verificationCode.value = "";
  resetCountdown();
};

const closeVerificationModal = () => {
  showVerifyModal.value = false;
  resetCountdown();
};

const sendVerificationCode = () => {
  if (!canSendCode.value) return;
  countdownSeconds.value = 180;
  if (countdownTimer) clearInterval(countdownTimer);
  countdownTimer = setInterval(() => {
    if (countdownSeconds.value <= 1) {
      resetCountdown();
      return;
    }
    countdownSeconds.value -= 1;
  }, 1000);
};

const handleVerificationConfirm = () => {
  verificationStatus.value = "verified";
  verificationToastDismissed.value = true;
  closeVerificationModal();
};

const dismissVerificationToast = () => {
  verificationToastDismissed.value = true;
};

const resetCountdown = () => {
  countdownSeconds.value = 0;
  if (countdownTimer) {
    clearInterval(countdownTimer);
    countdownTimer = null;
  }
};

watch(verificationStatus, (status) => {
  if (status === "unverified") {
    verificationToastDismissed.value = false;
  }
  if (status === "verified") {
    closeVerificationModal();
  }
});

onBeforeUnmount(() => {
  resetCountdown();
});

const tabComponentMap = {
  profile: ProfileTab,
  security: SecurityTab,
  notifications: NotificationTab,
  privacy: PrivacyTab,
  billing: BillingTab,
};

const currentTabComponent = computed(
  () => tabComponentMap[activeSettingsTab.value] ?? InfoTab
);
</script>

<style scoped>
.toast-slide-enter-active,
.toast-slide-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.toast-slide-enter-from,
.toast-slide-leave-to {
  opacity: 0;
  transform: translateY(12px);
}

.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.25s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}
</style>
