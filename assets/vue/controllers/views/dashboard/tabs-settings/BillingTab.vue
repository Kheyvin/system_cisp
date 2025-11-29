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
      <div class="rounded-2xl border border-gray-100 bg-gray-50/60 p-5 space-y-6">
        <div class="grid gap-4 md:grid-cols-2">
          <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-gray-700" for="billingCurrency">Tipo de Moneda</label>
            <select
              id="billingCurrency"
              v-model="billingCurrency"
              class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-gray-800 focus:border-[#324D68] focus:ring-[#324D68]"
            >
              <option v-for="option in currencyOptions" :key="option.value" :value="option.value">
                {{ option.label }}
              </option>
            </select>
          </div>
          <div class="flex flex-col gap-2">
            <label class="text-sm font-semibold text-gray-700" for="invoiceLanguage">Idioma de facturas</label>
            <select
              id="invoiceLanguage"
              v-model="invoiceLanguage"
              class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-gray-800 focus:border-[#324D68] focus:ring-[#324D68]"
            >
              <option v-for="option in languageOptions" :key="option.value" :value="option.value">
                {{ option.label }}
              </option>
            </select>
          </div>
        </div>

        <div class="border-t border-gray-200"></div>

        <div class="space-y-5">
          <div
            v-for="channel in billingChannels"
            :key="channel.id"
            class="flex flex-col gap-2"
          >
            <div class="flex items-start justify-between gap-4">
              <div>
                <p class="text-base font-semibold text-gray-800">{{ channel.title }}</p>
                <p class="text-sm text-gray-500">{{ channel.description }}</p>
              </div>
              <button
                class="relative inline-flex h-6 w-10 items-center rounded-full transition-colors cursor-pointer"
                :class="channel.enabled ? 'bg-ksp-green' : 'bg-ksp-red'"
                type="button"
                @click="toggleBillingChannel(channel.id)"
              >
                <span class="sr-only">Cambiar {{ channel.title }}</span>
                <span
                  class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"
                  :class="channel.enabled ? 'translate-x-4' : 'translate-x-1'"
                ></span>
              </button>
            </div>
            <div class="border-t border-gray-100" v-if="channel.id !== billingChannels[billingChannels.length - 1].id"></div>
          </div>
        </div>
      </div>

      <div
        class="rounded-2xl border p-4 flex items-start gap-3"
        :class="[billingAlertState.border, billingAlertState.background]"
      >
        <span
          class="inline-flex h-10 w-10 items-center justify-center rounded-full"
          :class="billingAlertState.iconWrapper"
        >
          <Icon :name="billingAlertState.icon" size="18" />
        </span>
        <div>
          <p class="text-sm font-semibold" :class="billingAlertState.titleColor">
            {{ billingAlertState.title }}
          </p>
          <p class="text-sm" :class="billingAlertState.descriptionColor">
            {{ billingAlertState.description }}
          </p>
        </div>
      </div>

      <div class="pt-2">
        <Button
          customClass="w-full justify-center bg-[#324D68] text-white hover:bg-[#24384c] px-5 py-2.5 flex items-center gap-2 cursor-pointer rounded-xl"
        >
          <Icon name="check" size="18" />
          Guardar configuración de facturación
        </Button>
      </div>
    </div>
  </Card>
</template>

<script setup>
import { computed, ref } from "vue";
import Card from "../../../components/ui/atoms/Card.vue";
import Button from "../../../components/ui/atoms/Button.vue";
import Icon from "../../../components/ui/atoms/Icon.vue";

const props = defineProps({
  content: {
    type: Object,
    required: true,
  },
});

const currencyOptions = [
  { value: "PEN", label: "PER - Soles (S/)" },
  { value: "USD", label: "USA - Dólares ($)" },
  { value: "EUR", label: "EUR - Euro (€)" },
];

const languageOptions = [
  { value: "es", label: "Español" },
  { value: "en", label: "Inglés" },
  { value: "pt", label: "Portugués" },
];

const billingCurrency = ref(currencyOptions[0].value);
const invoiceLanguage = ref(languageOptions[0].value);

const billingChannels = ref([
  {
    id: "digitalInvoice",
    title: "Factura electrónica",
    description: "Recibir facturas en formato digital",
    enabled: true,
  },
  {
    id: "physicalInvoice",
    title: "Facturas empresa",
    description: "Recibir facturas físicas por correo postal",
    enabled: false,
  },
]);

const toggleBillingChannel = (id) => {
  billingChannels.value = billingChannels.value.map((channel) =>
    channel.id === id ? { ...channel, enabled: !channel.enabled } : channel
  );
};

const hasActiveChannel = computed(() => billingChannels.value.some((channel) => channel.enabled));

const billingAlertState = computed(() => {
  if (hasActiveChannel.value) {
    return {
      icon: "check",
      title: "Facturación automática activa",
      description:
        "Tu siguiente factura se generará automáticamente el 15 de febrero. El pago se procesará usando tu método de pago principal.",
      border: "border-green-100",
      background: "bg-green-50/80",
      iconWrapper: "bg-white text-ksp-green",
      titleColor: "text-green-800",
      descriptionColor: "text-green-700",
    };
  }

  return {
    icon: "x",
    title: "Facturación automática detenida",
    description: "Activa al menos una modalidad de envío para reanudar la emisión automática de facturas.",
    border: "border-red-100",
    background: "bg-red-50/80",
    iconWrapper: "bg-white text-red-600",
    titleColor: "text-red-800",
    descriptionColor: "text-red-700",
  };
});
</script>
