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
          <component :is="currentTabComponent" />
        </Card>
      </transition>
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import Button from "../../components/ui/atoms/Button.vue";
import Icon from "../../components/ui/atoms/Icon.vue";
import Card from "../../components/ui/atoms/Card.vue";
import TabGroup from "../../components/ui/molecules/TabGroup.vue";
import PaymentMethodsTab from "./tabs-payments/PaymentMethodsTab.vue";
import PaymentHistoryTab from "./tabs-payments/PaymentHistoryTab.vue";
import PaymentAutopayTab from "./tabs-payments/PaymentAutopayTab.vue";

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

const tabComponentMap = {
  methods: PaymentMethodsTab,
  history: PaymentHistoryTab,
  autopay: PaymentAutopayTab,
};

const route = useRoute();
const router = useRouter();

const resolveTab = (value) => {
  const exists = paymentTabs.some((tab) => tab.value === value);
  return exists ? value : paymentTabs[0].value;
};

const activePaymentTab = ref(resolveTab(route.query.tab));

const currentTabComponent = computed(() => {
  return tabComponentMap[activePaymentTab.value] || PaymentMethodsTab;
});

watch(
  () => route.query.tab,
  (newTab) => {
    const resolved = resolveTab(newTab);
    if (resolved !== activePaymentTab.value) {
      activePaymentTab.value = resolved;
    }
  },
  { immediate: true }
);

watch(
  activePaymentTab,
  (newTab) => {
    if (route.query.tab === newTab) return;
    router.replace({ path: route.path, query: { ...route.query, tab: newTab } });
  },
  { immediate: true }
);

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
