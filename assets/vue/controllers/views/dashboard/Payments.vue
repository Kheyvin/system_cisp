<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-3xl font-bold text-ksp-principal">Gestión de Pagos</h2>
        <span class="text-base"
          >Crea y gestiona tus solicitudes de soporte</span
        >
      </div>
      <Button
        customClass="bg-[#324D68] text-white hover:bg-[#24384c] flex items-center px-4 py-2 shadow-sm cursor-pointer"
      >
        <Icon name="dollar-sign" size="20" class="mr-2" />
        Realizar Pago
      </Button>
    </div>

    <div class="grid grid-cols-12 gap-6">
      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-green-50 p-2 mr-3 rounded-full">
              <Icon name="dollar-sign" size="24" class="text-ksp-green" />
            </div>
            <span class="text-gray-600 font-medium">Gasto Anual</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              S/ {{ totalRequests }}
            </h3>
            <p class="text-gray-500 text-sm">Total este año</p>
          </div>
        </Card>
      </div>

      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-[#E6FAF7] p-2 mr-3 rounded-full">
              <Icon name="trend-up" size="24" class="text-[#32C1B1]" />
            </div>
            <span class="text-gray-600 font-medium">Promedio Mensual</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
             S/ {{ averageMonthly }}
            </h3>
            <p class="text-gray-500 text-sm">Gasto promedio</p>
          </div>
        </Card>
      </div>

      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-[#EEF2F7] p-2 mr-3 rounded-full">
              <Icon name="calendar" size="24" class="text-[#4C637B]" />
            </div>
            <span class="text-gray-600 font-medium">Próximo Pago</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
            S/  {{ nextPayment }}
            </h3>
            <p class="text-gray-500 text-sm">{{ nextPaymentDate }}</p>
          </div>
        </Card>
      </div>

      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-[#E4FFFA] p-2 mr-3 rounded-full">
              <Icon name="clock" size="24" class="text-[#4FCABC]" />
            </div>
            <span class="text-gray-600 font-medium">Mes actual</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              S/ {{ currentMonth }}
            </h3>
            <p class="text-gray-500 text-sm">Gastado este mes</p>
          </div>
        </Card>
      </div>
    </div>

    <div class="mt-10">
      <TabGroup :tabs="paymentTabs" v-model="activePaymentTab" />

      <transition name="tab-content" mode="out-in">
        <Card :key="activePaymentTab" class="mt-6 p-6 bg-white shadow-sm">
          <template v-if="activePaymentTab === 'methods'">
            <div class="flex flex-col gap-4">
              <div
                class="flex flex-col gap-4 border-b border-gray-100 pb-4 md:flex-row md:items-center md:justify-between"
              >
                <div>
                  <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">
                    Métodos de Pago
                  </p>
                  <h3 class="text-2xl font-bold text-gray-800 mt-1">
                    Administra tus tarjetas y cuentas bancarias
                  </h3>
                  <p class="text-gray-600 mt-2">
                    Revisa el estado de cada tarjeta afiliada, actualiza datos y controla qué método se usa por defecto.
                  </p>
                </div>
                <Button
                  customClass="bg-white border border-gray-300 text-[#324D68] hover:bg-gray-50 px-4 py-2 flex items-center gap-2 cursor-pointer"
                >
                  <Icon name="plus" size="18" />
                  Agregar método de pago
                </Button>
              </div>

              <div class="flex flex-col gap-3">
                <div
                  v-for="method in displayedMethods"
                  :key="method.id"
                  class="flex flex-col gap-3 rounded-2xl border border-gray-200 bg-white/80 p-4 md:flex-row md:items-center"
                >
                  <div class="flex items-center justify-center md:w-20">
                    <Icon name="credit-card" size="30" class="text-[#324D68]" />
                  </div>

                  <div class="flex flex-1 flex-col gap-2 md:flex-row md:items-center">
                    <div class="flex flex-col gap-2 md:flex-1">
                      <div class="flex flex-wrap items-center gap-3">
                        <p class="text-lg font-semibold text-gray-800">
                          {{ method.label }}
                        </p>
                        <div class="flex items-center gap-2">
                          <span
                            class="rounded-full px-3 py-1 text-xs font-semibold"
                            :class="methodStatusClass(method.status)"
                          >
                            {{ method.status }}
                          </span>
                          <PaymentBrandIcon
                            :brand="method.brand"
                            customClass="h-5 w-9"
                          />
                        </div>
                      </div>
                      <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                        <p>{{ method.type }}</p>
                        <p>Vence: {{ method.expiration }}</p>
                      </div>
                    </div>

                    <div class="flex flex-col gap-2 md:w-48">
                      <button
                        class="flex items-center justify-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-600 hover:border-[#324D68] hover:bg-[#324D68]/10 hover:text-[#324D68] transition-colors cursor-pointer"
                        aria-label="Editar método"
                        title="Editar método"
                      >
                        <Icon name="edit" size="16" class="text-[#324D68]" />
                        Editar
                      </button>
                      <button
                        class="flex items-center justify-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-600 hover:border-red-400 hover:bg-red-50 hover:text-red-600 transition-colors cursor-pointer"
                        aria-label="Eliminar método"
                        title="Eliminar método"
                      >
                        <Icon name="trash" size="16" class="text-red-500" />
                        Borrar
                      </button>
                      <button
                        class="flex items-center justify-center gap-2 rounded-lg border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-600 hover:border-amber-400 hover:bg-amber-50 hover:text-amber-600 transition-colors cursor-pointer"
                        aria-label="Deshabilitar método"
                        title="Deshabilitar método"
                      >
                        <Icon name="slash-circle" size="16" class="text-amber-500" />
                        Deshabilitar
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="pt-2">
                <button
                  class="text-sm font-semibold text-[#324D68] hover:text-[#24384c] cursor-pointer"
                  @click="toggleMethodsExpansion"
                >
                  {{ showAllMethods ? 'Ver menos' : 'Ver más' }}
                </button>
              </div>
            </div>
          </template>

          <template v-else>
            <div class="flex flex-col gap-4">
              <div>
                <p
                  class="text-sm uppercase tracking-wide text-gray-400 font-semibold"
                >
                  {{ currentTabContent.badge }}
                </p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">
                  {{ currentTabContent.title }}
                </h3>
                <p class="text-gray-600 mt-2">
                  {{ currentTabContent.description }}
                </p>
              </div>

              <ul class="space-y-3">
                <li
                  v-for="(item, index) in currentTabContent.items"
                  :key="index"
                  class="flex items-center gap-3 text-gray-700"
                >
                  <span
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#324D68]/10 text-[#324D68]"
                  >
                    <Icon name="check" size="16" />
                  </span>
                  <span>{{ item }}</span>
                </li>
              </ul>

              <div>
                <Button
                  customClass="bg-[#324D68] text-white hover:bg-[#24384c] px-4 py-2 cursor-pointer"
                >
                  {{ currentTabContent.ctaLabel }}
                </Button>
              </div>
            </div>
          </template>
        </Card>
      </transition>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import Button from "../../components/ui/atoms/Button.vue";
import Icon from "../../components/ui/atoms/Icon.vue";
import Card from "../../components/ui/atoms/Card.vue";
import TabGroup from "../../components/ui/molecules/TabGroup.vue";
import PaymentBrandIcon from "./components/PaymentBrandIcon.vue";

const averageMonthly = ref(1042);
const nextPayment = ref(1200);
const nextPaymentDate = ref("2024-08-15");
const totalRequests = ref(12500);
const currentMonth = ref(35.9);

const paymentTabs = [
  { label: "Métodos de pago", value: "methods" },
  { label: "Historial", value: "history" },
  { label: "Pago Automático", value: "autopay" },
];

const activePaymentTab = ref(paymentTabs[0].value);

const tabContentMap = {
  history: {
    badge: "Seguimiento",
    title: "Consulta tu historial completo",
    description:
      "Revisa pagos confirmados, pendientes y exporta reportes detallados de cada periodo.",
    items: [
      "Filtros por fecha y estado",
      "Descarga en CSV o PDF",
      "Alertas de pagos vencidos",
    ],
    ctaLabel: "Ver historial",
  },
  autopay: {
    badge: "Automatización",
    title: "Activa el pago automático",
    description:
      "Configura débitos programados y olvídate de los vencimientos. Te notificaremos en cada cargo.",
    items: [
      "Frecuencias mensuales o personalizadas",
      "Notificaciones previas al débito",
      "Control de topes y reglas",
    ],
    ctaLabel: "Configurar pago automático",
  },
};

const currentTabContent = computed(() => {
  return tabContentMap[activePaymentTab.value] ?? tabContentMap.history;
});

const paymentMethods = ref([
  {
    id: "card-1",
    label: "Visa •••• 4532",
    status: "Activo",
    type: "Tarjeta de Crédito",
    brand: "Visa",
    expiration: "12/26",
  },
  {
    id: "card-2",
    label: "Mastercard •••• 9011",
    status: "En validación",
    type: "Tarjeta de Crédito",
    brand: "Mastercard",
    expiration: "04/27",
  },
  {
    id: "card-3",
    label: "BBVA Cuenta Corriente",
    status: "Deshabilitado",
    type: "Cuenta Bancaria",
    brand: "BBVA",
    expiration: "-",
  },
  {
    id: "card-4",
    label: "Visa •••• 7789",
    status: "Predeterminado",
    type: "Tarjeta de Débito",
    brand: "Visa",
    expiration: "08/25",
  },
  {
    id: "card-5",
    label: "American Express •••• 3321",
    status: "Activo",
    type: "Tarjeta de Crédito",
    brand: "American Express",
    expiration: "01/28",
  },
  {
    id: "card-6",
    label: "Cuenta Interbank",
    status: "Suspendido",
    type: "Cuenta Bancaria",
    brand: "Interbank",
    expiration: "-",
  },
  {
    id: "card-7",
    label: "Visa •••• 1188",
    status: "Expirado",
    type: "Tarjeta de Crédito",
    brand: "Visa",
    expiration: "09/23",
  },
]);

const showAllMethods = ref(false);

const orderedMethods = computed(() => {
  const preferred = [];
  const rest = [];

  paymentMethods.value.forEach((method) => {
    if (method.status === "Predeterminado") {
      preferred.push(method);
    } else {
      rest.push(method);
    }
  });

  return [...preferred, ...rest];
});

const displayedMethods = computed(() => {
  const list = orderedMethods.value;
  return showAllMethods.value ? list : list.slice(0, 5);
});

const toggleMethodsExpansion = () => {
  showAllMethods.value = !showAllMethods.value;
};

const methodStatusClass = (status) => {
  const map = {
    Activo: "bg-green-500 text-white",
    Predeterminado: "bg-blue-600 text-white",
    "En validación": "bg-amber-500 text-white",
    Deshabilitado: "bg-gray-600 text-white",
    Suspendido: "bg-orange-500 text-white",
    Expirado: "bg-red-600 text-white",
  };

  return map[status] || "bg-gray-100 text-gray-600";
};

</script>

<style scoped>
.tab-content-enter-active,
.tab-content-leave-active {
  transition: opacity 0.25s ease, transform 0.25s ease;
}

.tab-content-enter-from,
.tab-content-leave-to {
  opacity: 0;
  transform: translateY(14px);
}
</style>
