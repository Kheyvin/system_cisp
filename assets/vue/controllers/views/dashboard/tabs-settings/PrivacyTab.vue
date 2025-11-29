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

    <div class="py-6 space-y-6">
      <div class="rounded-2xl border border-gray-100 bg-gray-50/60 p-5 space-y-5">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Preferencias de privacidad</p>
          <h4 class="text-xl font-semibold text-gray-900">Controla tu visibilidad y uso de datos</h4>
        </div>

        <div class="space-y-5">
          <div
            v-for="control in privacyControls"
            :key="control.id"
            class="flex flex-col gap-2"
          >
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-base font-semibold text-gray-800">{{ control.title }}</p>
                <p class="text-sm text-gray-500">{{ control.description }}</p>
              </div>
              <button
                class="relative inline-flex h-6 w-10 items-center rounded-full transition-colors cursor-pointer"
                :class="control.enabled ? 'bg-ksp-green' : 'bg-ksp-red'"
                type="button"
                @click="togglePrivacyControl(control.id)"
              >
                <span class="sr-only">Cambiar {{ control.title }}</span>
                <span
                  class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"
                  :class="control.enabled ? 'translate-x-4' : 'translate-x-1'"
                ></span>
              </button>
            </div>
            <div class="border-t border-gray-100" v-if="control.id !== privacyControls[privacyControls.length - 1].id"></div>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-gray-100 p-5 space-y-4">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Gestión de datos</p>
          <h4 class="text-xl font-semibold text-gray-900">Herramientas para tus datos personales</h4>
          <p class="text-sm text-gray-600">Descarga tu información o solicita la eliminación definitiva de tu cuenta.</p>
        </div>
        <div class="flex flex-col gap-3 md:flex-row">
          <Button
            customClass="bg-white border border-gray-200 text-[#324D68] hover:bg-gray-50 px-4 py-2 flex items-center gap-2 cursor-pointer rounded-xl justify-center"
          >
            <Icon name="download" size="18" />
            Descargar datos
          </Button>
          <Button
            customClass="bg-red-50 text-red-600 hover:bg-red-100 border border-red-200 px-4 py-2 flex items-center gap-2 cursor-pointer rounded-xl justify-center"
          >
            <Icon name="alert-circle" size="18" />
            Eliminar cuenta
          </Button>
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

const privacyControls = ref([
  {
    id: "publicProfile",
    title: "Perfil público",
    description: "Hacer visible tu perfil básico a otros usuarios",
    enabled: false,
  },
  {
    id: "dataSharing",
    title: "Compartir datos para mejoras",
    description: "Ayudar a mejorar el servicio compartiendo datos anónimos",
    enabled: true,
  },
  {
    id: "analytics",
    title: "Análisis y estadísticas",
    description: "Permitir recopilación de datos de uso para análisis",
    enabled: true,
  },
]);

const togglePrivacyControl = (id) => {
  privacyControls.value = privacyControls.value.map((control) =>
    control.id === id ? { ...control, enabled: !control.enabled } : control
  );
};
</script>
