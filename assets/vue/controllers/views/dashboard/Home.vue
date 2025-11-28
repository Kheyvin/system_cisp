<template>
  <div>
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-3xl font-bold text-ksp-principal">Panel de Control</h2>
        <span class="text-base">Bienvenido a tu portal CISP </span>
      </div>
      <Button
        customClass="bg-[#324D68] text-white hover:bg-[#24384c] flex items-center px-4 py-2 shadow-sm cursor-pointer"
      >
        <Icon name="download" size="20" class="mr-2" />
        Descargar Factura
      </Button>
    </div>

    <!-- Hero Slider -->
    <div class="mb-8">
      <ImageSlider :slides="slides" />
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-12 gap-6">
      <!-- Card 1: Estado de conexion -->
      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 bg-ksp-principal text-white min-h-[200px] justify-between"
        >
          <div class="flex items-center mb-4 bg-">
            <div class="bg-white p-2 rounded-full mr-3">
              <Icon :name="wifiIconName" size="24" :class="wifiIconClass" />
            </div>
            <span class="text-white font-medium">Estado de conexion</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-white mb-1">
              {{ connectionStatusText }}
            </h3>
            <p class="text-white/80 text-sm">
              Plan Fibra Premium {{ planSpeed }}MB
            </p>
          </div>
        </Card>
      </div>

      <!-- Card 2: Proximo Pago -->
      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-blue-100 p-2 rounded-full mr-3">
              <Icon name="dollar-sign" size="24" class="text-blue-600" />
            </div>
            <span class="text-gray-600 font-medium">Proximo Pago</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              S/ {{ planPrice }}
            </h3>
            <p class="text-gray-500 text-sm">Vence: {{ nextPaymentDate }}</p>
          </div>
        </Card>
      </div>

      <!-- Card 3: Velocidad Actual -->
      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-purple-100 p-2 rounded-full mr-3">
              <Icon name="gauge" size="24" class="text-purple-600" />
            </div>
            <span class="text-gray-600 font-medium">Velocidad Actual</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 :class="currentSpeedClass">{{ currentSpeedDisplay }}</h3>
            <p class="text-gray-500 text-sm">Download</p>
          </div>
        </Card>
      </div>

      <!-- Card 4: Tiempo Activo -->
      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-orange-100 p-2 rounded-full mr-3">
              <Icon name="clock" size="24" class="text-orange-600" />
            </div>
            <span class="text-gray-600 font-medium">Tiempo Activo</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">{{ uptime }}%</h3>
            <p class="text-gray-500 text-sm">Este mes</p>
          </div>
        </Card>
      </div>

      <!-- Card 5: Plan Actual -->
      <div class="col-span-12 lg:col-span-6">
        <Card
          class="h-full flex flex-col p-6 bg-white shadow-sm hover:shadow-lg transition-shadow duration-200"
        >
          <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-800">Plan Actual</h3>
            <p class="text-sm text-gray-500">
              Detalles de tu servicio de internet
            </p>
          </div>

          <div class="space-y-3 mb-6 grow">
            <div
              class="flex justify-between items-center border-b border-gray-100 pb-2"
            >
              <span class="text-gray-600">Plan:</span>
              <span class="font-medium text-gray-800"
                >Plan Fibra Premium {{ planSpeed }}MB</span
              >
            </div>
            <div
              class="flex justify-between items-center border-b border-gray-100 pb-2"
            >
              <span class="text-gray-600">Velocidad:</span>
              <span class="px-2 py-1 rounded text-white text-sm bg-[#324D68]"
                >{{ planSpeed }}Mbps</span
              >
            </div>
            <div
              class="flex justify-between items-center border-b border-gray-100 pb-2"
            >
              <span class="text-gray-600">Precio mensual:</span>
              <span class="font-medium text-gray-800">S/ {{ planPrice }}</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Estado:</span>
              <span
                :class="statusClasses"
                class="px-2 py-1 rounded text-white text-xs font-bold uppercase"
              >
                {{ status }}
              </span>
            </div>
          </div>

          <Button
            class="w-full border border-[#324D68] bg-white text-gray-900 hover:bg-[#324D68] hover:text-white py-2 rounded-md transition-colors duration-200 cursor-pointer"
          >
            Cambiar plan
          </Button>
        </Card>
      </div>

      <!-- Card 6: Uso de Datos -->
      <div class="col-span-12 lg:col-span-6">
        <Card
          class="h-full flex flex-col p-6 bg-white shadow-sm hover:shadow-lg transition-shadow duration-200"
        >
          <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-800">Uso de Datos</h3>
            <p class="text-sm text-gray-500">Consumo de datos este mes</p>
          </div>

          <div class="mb-4">
            <div
              class="flex justify-between items-center text-sm text-gray-500 mb-2"
            >
              <span>Datos utilizados</span>
              <span>{{ dataUsageLabel }}</span>
            </div>
            <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
              <div
                class="h-full bg-linear-to-r from-ksp-principal to-[#0C4770] rounded-full transition-all duration-300"
                :style="dataUsageFillStyle"
              ></div>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4 mb-4">
            <div
              class="flex items-center p-4 bg-gray-50 rounded-lg justify-center"
            >
              <div class="bg-blue-100 text-blue-600 p-2 rounded-full mr-3">
                <Icon name="download" size="20" />
              </div>
              <div>
                <p class="text-xs uppercase text-gray-500">Download</p>
                <p class="text-lg font-semibold text-gray-800">
                  {{ downloadSpeed }} Mbps
                </p>
              </div>
            </div>
            <div
              class="flex items-center p-4 bg-gray-50 rounded-lg justify-center"
            >
              <div class="bg-purple-100 text-purple-600 p-2 rounded-full mr-3">
                <Icon name="upload" size="20" />
              </div>
              <div>
                <p class="text-xs uppercase text-gray-500">Upload</p>
                <p class="text-lg font-semibold text-gray-800">
                  {{ uploadSpeed }} Mbps
                </p>
              </div>
            </div>
          </div>

          <div class="flex flex-col items-center bg-gray-50 rounded-lg py-4">
            <div class="bg-orange-100 text-orange-600 p-2 rounded-full mb-2">
              <Icon name="activity" size="20" />
            </div>
            <p class="text-xs uppercase text-gray-500">Ping</p>
            <p class="text-lg font-semibold text-gray-800">
              {{ pingValue }} ms
            </p>
          </div>
        </Card>
      </div>

      <!-- Card 7: Pagos Recientes -->
      <div class="col-span-12">
        <Card
          class="h-full flex flex-col p-6 bg-white shadow-sm hover:shadow-lg transition-shadow duration-200"
        >
          <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-800">Pagos Recientes</h3>
            <p class="text-sm text-gray-500">
              Últimas transacciones realizadas
            </p>
          </div>

          <ul class="space-y-3 mb-6">
            <li
              v-for="payment in visiblePayments"
              :key="payment.id"
              class="flex items-center justify-between bg-gray-50 rounded-lg p-4"
            >
              <div class="flex items-center">
                <div class="bg-green-100 text-green-600 p-2 rounded-full mr-3">
                  <Icon name="dollar-sign" size="20" />
                </div>
                <div>
                  <p class="text-base font-semibold text-gray-800">
                    {{ payment.amount }}
                  </p>
                  <p class="text-xs text-gray-500">{{ payment.date }}</p>
                </div>
              </div>
              <span
                class="px-3 py-1 text-xs font-bold rounded-full uppercase"
                :class="paymentStatusClass(payment.status)"
              >
                {{ payment.status }}
              </span>
            </li>
          </ul>

          <Button
            class="w-full border border-[#324D68] bg-white text-gray-900 hover:bg-[#324D68] hover:text-white py-2 rounded-md transition-colors duration-200 focus:outline-none cursor-pointer"
            @click="togglePayments"
          >
            {{ paymentToggleLabel }}
          </Button>
        </Card>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import Button from "../../components/ui/atoms/Button.vue";
import Icon from "../../components/ui/atoms/Icon.vue";
import Card from "../../components/ui/atoms/Card.vue";
import ImageSlider from "../../components/ui/organisms/ImageSlider.vue";

// Data Refs
const status = ref("activo");
const planSpeed = ref(100);
const dataUsed = ref(75);
const planPrice = ref(35.99);
const nextPaymentDate = ref("15 Feb 2024");
const downloadSpeed = ref(95.2);
const uploadSpeed = ref(48.7);
const pingValue = ref(12);
const uptime = ref(99.8);
const payments = ref([
  { id: 1, amount: "S/ 35.99", date: "2024-01-22", status: "Pagado" },
  { id: 2, amount: "S/ 42.50", date: "2024-02-20", status: "Pendiente" },
  { id: 3, amount: "S/ 35.99", date: "2024-03-22", status: "Pagado" },
  { id: 4, amount: "S/ 37.10", date: "2024-04-20", status: "Procesando" },
  { id: 5, amount: "S/ 35.99", date: "2024-05-22", status: "Suspendido" },
]);
const showAllPayments = ref(false);

// Computed Properties
const connectionStatusText = computed(() => {
  if (status.value === "activo") return "CONECTADO";
  if (status.value === "cargando") return "CONECTANDO...";
  if (status.value === "inactivo") return "DESCONECTADO";
  return status.value.toUpperCase();
});

const currentSpeedDisplay = computed(() => {
  switch (status.value) {
    case "activo":
      return `${downloadSpeed.value} Mbps`;
    case "cargando":
      return "0 Mbps";
    case "inactivo":
      return "Error de Red";
    case "suspendido":
    case "cancelado":
      return "Regularizar Pago";
    default:
      return "---";
  }
});

const currentSpeedClass = computed(() => {
  const base = "text-xl font-bold mb-1";
  const alertBase =
    "text-base font-bold px-2 py-1 rounded mb-1 inline-block rounded-xl";

  switch (status.value) {
    case "activo":
      return `${base} text-gray-800`;
    case "cargando":
      return `${base} text-gray-400`;
    case "inactivo":
      return `${alertBase} text-red-600 bg-red-100`;
    case "suspendido":
    case "cancelado":
      return `${alertBase} text-orange-600 bg-orange-100`;
    default:
      return `${base} text-gray-800`;
  }
});

const statusClasses = computed(() => {
  const map = {
    activo: "bg-green-500",
    inactivo: "bg-red-500",
    cargando: "bg-blue-400",
    cancelado: "bg-gray-500",
    suspendido: "bg-orange-500",
  };
  return map[status.value] || "bg-gray-500";
});

const wifiIconName = computed(() => {
  return status.value === "activo" ? "wifi" : "wifi-off";
});

const wifiIconClass = computed(() => {
  return status.value === "activo" ? "text-ksp-green" : "text-ksp-red";
});

const parseNumericValue = (value) => {
  const parsed = parseFloat(typeof value === "number" ? String(value) : value);
  return Number.isFinite(parsed) ? parsed : 0;
};

const numericPlanCapacity = computed(() => parseNumericValue(planSpeed.value));

const numericDataUsed = computed(() => parseNumericValue(dataUsed.value));

const dataUsagePercent = computed(() => {
  const total = numericPlanCapacity.value;
  if (!total) return 0;
  return Math.max(
    0,
    Math.min(100, Math.round((numericDataUsed.value / total) * 100))
  );
});

const dataUsageLabel = computed(() => {
  return `${numericDataUsed.value}GB de ${numericPlanCapacity.value}GB`;
});

const dataUsageFillStyle = computed(() => ({
  width: `${dataUsagePercent.value}%`,
}));

const visiblePayments = computed(() => {
  if (showAllPayments.value) {
    return payments.value;
  }
  return payments.value.slice(0, 3);
});

const paymentToggleLabel = computed(() =>
  showAllPayments.value ? "Ocultar pagos" : "Ver todos los pagos"
);

const paymentStatusClass = (status) => {
  const map = {
    Pagado: "bg-green-500 text-white",
    Pendiente: "bg-yellow-500 text-white",
    Suspendido: "bg-red-500 text-white",
    Procesando: "bg-blue-600 text-white",
  };
  return map[status] || "bg-gray-600 text-white";
};

const togglePayments = () => {
  showAllPayments.value = !showAllPayments.value;
};

const slides = [
  {
    image: "https://picsum.photos/1200/400?random=1",
    link: "#details1",
    title: "Promocion 1",
  },
  {
    image: "https://picsum.photos/1200/400?random=2",
    link: "#details2",
    title: "Promocion 2",
  },
  {
    image: "https://picsum.photos/1200/400?random=3",
    link: "#details3",
    title: "Promocion 3",
  },
  {
    image: "https://picsum.photos/1200/400?random=4",
    link: "#details4",
    title: "Promocion 4",
  },
];
</script>
<style  scoped>
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
</style>