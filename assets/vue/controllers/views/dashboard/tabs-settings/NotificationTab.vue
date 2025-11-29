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

    <div class="grid gap-6 py-6 md:grid-cols-2">
      <div class="rounded-2xl border border-gray-100 bg-gray-50/60 p-5 flex flex-col gap-5">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Notificaciones por Email</p>
          <h4 class="text-xl font-semibold text-gray-900">Configura qué notificaciones quieres recibir por email</h4>
        </div>

        <div class="space-y-5">
          <div
            v-for="pref in emailPreferences"
            :key="pref.id"
            class="flex flex-col gap-2 border-b border-gray-100 pb-4 last:border-b-0 last:pb-0"
          >
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-base font-semibold text-gray-800">{{ pref.title }}</p>
                <p class="text-sm text-gray-500">{{ pref.description }}</p>
              </div>
              <button
                class="relative inline-flex h-6 w-10 items-center rounded-full transition-colors cursor-pointer"
                :class="pref.enabled ? 'bg-ksp-green' : 'bg-ksp-red'"
                type="button"
                @click="toggleEmailPreference(pref.id)"
              >
                <span class="sr-only">Cambiar preferencia {{ pref.title }}</span>
                <span
                  class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"
                  :class="pref.enabled ? 'translate-x-4' : 'translate-x-1'"
                ></span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-gray-100 bg-gray-50/60 p-5 flex flex-col gap-5">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Notificaciones SMS y Push</p>
          <h4 class="text-xl font-semibold text-gray-900">Alertas inmediatas en tu dispositivo móvil</h4>
        </div>

        <div class="space-y-5">
          <div
            v-for="pref in mobilePreferences"
            :key="pref.id"
            class="flex flex-col gap-2 border-b border-gray-100 pb-4 last:border-b-0 last:pb-0"
          >
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-base font-semibold text-gray-800">{{ pref.title }}</p>
                <p class="text-sm text-gray-500">{{ pref.description }}</p>
              </div>
              <button
                class="relative inline-flex h-6 w-10 items-center rounded-full transition-colors cursor-pointer"
                :class="pref.enabled ? 'bg-ksp-green' : 'bg-ksp-red'"
                type="button"
                @click="toggleMobilePreference(pref.id)"
              >
                <span class="sr-only">Cambiar preferencia {{ pref.title }}</span>
                <span
                  class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"
                  :class="pref.enabled ? 'translate-x-4' : 'translate-x-1'"
                ></span>
              </button>
            </div>
          </div>
        </div>

        <div class="rounded-2xl border border-dashed border-amber-200 bg-amber-50/70 p-4 flex items-start gap-3">
          <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-amber-600">
            <Icon name="bell" size="18" />
          </span>
          <div>
            <p class="text-sm font-semibold text-amber-800">Configuración recomendada</p>
            <p class="text-sm text-amber-700">
              Te recomendamos mantener activas las notificaciones de facturas para no perder fechas de vencimiento.
            </p>
          </div>
        </div>
      </div>
    </div>
  </Card>
</template>

<script setup>
import { ref } from "vue";
import Card from "../../../components/ui/atoms/Card.vue";
import Button from "../../../components/ui/atoms/Button.vue";
import Icon from "../../../components/ui/atoms/Icon.vue";

const props = defineProps({
  content: {
    type: Object,
    required: true,
  },
});

const emailPreferences = ref([
  {
    id: "billing",
    title: "Facturas y Pagos",
    description: "Recibos y recordatorios de pago",
    enabled: true,
  },
  {
    id: "promotions",
    title: "Promociones y Ofertas",
    description: "Descuentos y planes especiales",
    enabled: false,
  },
  {
    id: "maintenance",
    title: "Mantenimiento y Actualizaciones",
    description: "Información técnica del servicio",
    enabled: true,
  },
  {
    id: "marketing",
    title: "Emails de Marketing",
    description: "Noticias y contenido promocional",
    enabled: false,
  },
]);

const mobilePreferences = ref([
  {
    id: "smsBilling",
    title: "SMS - Facturas y Pagos",
    description: "Alertas urgentes de pagos",
    enabled: true,
  },
  {
    id: "smsPromotions",
    title: "SMS - Promociones",
    description: "Ofertas limitadas por SMS",
    enabled: false,
  },
  {
    id: "push",
    title: "Notificaciones Push",
    description: "Alertas en tiempo real",
    enabled: true,
  },
]);

const toggleEmailPreference = (id) => {
  emailPreferences.value = emailPreferences.value.map((pref) =>
    pref.id === id ? { ...pref, enabled: !pref.enabled } : pref
  );
};

const toggleMobilePreference = (id) => {
  mobilePreferences.value = mobilePreferences.value.map((pref) =>
    pref.id === id ? { ...pref, enabled: !pref.enabled } : pref
  );
};
</script>
