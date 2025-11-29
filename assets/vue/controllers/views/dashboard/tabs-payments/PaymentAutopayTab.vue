<template>
  <div class="flex flex-col gap-6">
    <div class="flex flex-col gap-4 border-b border-gray-100 pb-4">
      <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">
        Automatización
      </p>
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div class="flex items-start gap-3">
          <div class="rounded-2xl bg-[#E6FAF7] p-3 text-[#32C1B1]">
            <Icon name="shield-check" size="28" />
          </div>
          <div>
            <h3 class="text-2xl font-bold text-gray-800">
              Configuración de Pago Automático
            </h3>
            <p class="text-gray-600 mt-2">
              Asegura tus servicios con débitos programados, alertas previas y monitoreo en tiempo real de cada cargo.
            </p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <span
            class="text-sm font-semibold"
            :class="autopayEnabled ? 'text-ksp-green' : 'text-ksp-red'"
          >
            {{ autopayEnabled ? 'Activo' : 'Desactivado' }}
          </span>
          <button
            class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors cursor-pointer"
            :class="autopayEnabled ? 'bg-ksp-green' : 'bg-ksp-red'"
            type="button"
            @click="toggleAutopayStatus"
          >
            <span class="sr-only">Cambiar pago automático</span>
            <span
              class="inline-block h-6 w-6 transform rounded-full bg-white shadow transition-transform"
              :class="autopayEnabled ? 'translate-x-5' : 'translate-x-1'"
            ></span>
          </button>
        </div>
      </div>
    </div>

    <div
      class="rounded-2xl border border-gray-100 p-4 flex flex-col gap-3"
      :class="autopayEnabled ? 'bg-[#E6FAF7]' : 'bg-[#FFF5F5] border-red-100'"
    >
      <div class="flex items-start gap-3">
        <div
          class="rounded-full bg-white/70 p-2"
          :class="autopayEnabled ? 'text-ksp-green' : 'text-ksp-red'"
        >
          <Icon name="alert-circle" size="20" />
        </div>
        <div>
          <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">
            Beneficios del Pago Automático
          </p>
          <p class="text-sm text-gray-600">
            {{
              autopayEnabled
                ? 'Mantén estos beneficios mientras el servicio automático está activo.'
                : 'Activa el pago automático para acceder inmediatamente a estos beneficios.'
            }}
          </p>
        </div>
      </div>
      <ul class="space-y-2 text-sm text-gray-700">
        <li
          v-for="(benefit, index) in autopayBenefits"
          :key="`benefit-${index}`"
          class="flex items-start gap-2"
        >
          <span
            class="mt-0.5 inline-flex h-2 w-2 rounded-full"
            :class="autopayEnabled ? 'bg-ksp-green' : 'bg-ksp-red'"
          ></span>
          <span>{{ benefit }}</span>
        </li>
      </ul>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
      <div class="rounded-2xl border border-gray-100 bg-white/60 p-4">
        <p class="text-sm text-gray-500">Método principal</p>
        <p class="mt-1 text-lg font-semibold text-gray-800">
          {{ autopayMethod.label }}
        </p>
        <p class="text-sm text-gray-500">
          {{ autopayMethod.type }} · {{ autopayMethod.additional }}
        </p>
      </div>
      <div class="rounded-2xl border border-gray-100 p-4">
        <p class="text-sm text-gray-500">Día de cargo</p>
        <div class="mt-1 flex flex-wrap items-center gap-3">
          <span class="text-lg font-semibold text-gray-800">
            Día {{ autopayChargeDay }} de cada mes
          </span>
          <span
            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600"
          >
            Próximo cargo: {{ autopayNextCharge }}
          </span>
        </div>
        <p class="text-sm text-gray-500 mt-1">
          Confirmamos el cargo entre 08:00 y 10:00 h.
        </p>
      </div>
    </div>

    <div
      class="rounded-2xl border border-gray-100 p-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between"
    >
      <div>
        <p class="text-sm text-gray-500">Notificaciones</p>
        <p class="text-lg font-semibold text-gray-800">
          {{
            autopayNotificationsEnabled
              ? 'Enviamos alertas 24 h antes'
              : 'Alertas pausadas temporalmente'
          }}
        </p>
        <p class="text-sm text-gray-500">
          Se notificará al correo financiero registrado.
        </p>
      </div>
      <div class="flex items-center gap-3">
        <span
          class="text-sm font-semibold"
          :class="autopayNotificationsEnabled ? 'text-ksp-green' : 'text-ksp-red'"
        >
          {{ autopayNotificationsEnabled ? 'Activadas' : 'Desactivadas' }}
        </span>
        <button
          class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors cursor-pointer"
          :class="autopayNotificationsEnabled ? 'bg-ksp-green' : 'bg-ksp-red'"
          type="button"
          @click="toggleNotificationStatus"
        >
          <span class="sr-only">Cambiar notificaciones</span>
          <span
            class="inline-block h-6 w-6 transform rounded-full bg-white shadow transition-transform"
            :class="autopayNotificationsEnabled ? 'translate-x-5' : 'translate-x-1'"
          ></span>
        </button>
      </div>
    </div>

    <div
      class="flex flex-col gap-3 rounded-2xl border border-dashed border-gray-200 bg-gray-50/60 p-4 md:flex-row md:items-center md:justify-between"
    >
      <div>
        <p class="text-sm font-semibold text-gray-700">Resumen del cargo</p>
        <p class="text-sm text-gray-500 mt-1">
          Usaremos tu método principal y enviaremos el comprobante desde el sistema automático.
        </p>
        <p class="text-xs text-gray-400 mt-1">
          Última modificación: {{ autopayLastUpdated }}
        </p>
      </div>
      <Button
        customClass="bg-[#324D68] text-white hover:bg-[#24384c] px-4 py-2 flex items-center gap-2 cursor-pointer"
      >
        <Icon name="edit" size="18" />
        Modificar configuración
      </Button>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Button from "../../../components/ui/atoms/Button.vue";
import Icon from "../../../components/ui/atoms/Icon.vue";

const autopayEnabled = ref(true);
const autopayNotificationsEnabled = ref(true);
const autopayMethod = ref({
  label: "Visa •••• 7789",
  type: "Tarjeta de Débito",
  additional: "Predeterminada para sistemas",
});
const autopayChargeDay = ref(15);
const autopayNextCharge = ref("15 Jun 2024");
const autopayLastUpdated = ref("12 May 2024 - 09:10 h");
const autopayBenefits = [
  "Nunca te olvides de pagar tu factura",
  "Evita cargos por pago tardío",
  "Mantén tu servicio activo sin interrupciones",
  "Recibe notificaciones antes de cada cargo",
];

const toggleAutopayStatus = () => {
  autopayEnabled.value = !autopayEnabled.value;
};

const toggleNotificationStatus = () => {
  autopayNotificationsEnabled.value = !autopayNotificationsEnabled.value;
};
</script>
