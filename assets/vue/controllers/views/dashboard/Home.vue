<template>
  <div>
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-3xl font-bold text-principal">Panel de Control</h2>
        <span class="text-base">Bienvenido a tu portal CISP </span>
      </div>
      <Button
        customClass="bg-[#324D68] text-white hover:bg-[#24384c] flex items-center px-4 py-2 shadow-sm"
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
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 bg-principal text-white min-h-[200px] justify-between"
        >
          <div class="flex items-center mb-4 bg-">
            <div class="bg-white p-2 rounded-full mr-3">
              <Icon :name="wifiIconName" size="24" :class="wifiIconClass" />
            </div>
            <span class="text-white font-medium">Estado de conexion</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-2xl font-bold text-white mb-1">
              {{ connectionStatusText }}
            </h3>
            <p class="text-white/80 text-sm">{{ planName }}</p>
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
            <h3 class="text-2xl font-bold text-gray-800 mb-1">
              {{ planPrice }}
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
            <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ uptime }}</h3>
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
              <span class="font-medium text-gray-800">{{ planName }}</span>
            </div>
            <div
              class="flex justify-between items-center border-b border-gray-100 pb-2"
            >
              <span class="text-gray-600">Velocidad:</span>
              <span class="px-2 py-1 rounded text-white text-sm bg-[#324D68]">{{
                planSpeed
              }}</span>
            </div>
            <div
              class="flex justify-between items-center border-b border-gray-100 pb-2"
            >
              <span class="text-gray-600">Precio mensual:</span>
              <span class="font-medium text-gray-800">{{ planPrice }}</span>
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
            class="w-full bg-[#324D68] text-white hover:bg-[#24384c] py-2 rounded-md transition-colors duration-200"
          >
            Cambiar plan
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
const planName = ref("Plan Fibra Premium 100MB");
const planSpeed = ref("100 Mbps");
const planPrice = ref("S/ 35.99");
const nextPaymentDate = ref("15 Feb 2024");
const measuredSpeed = ref("95.2 Mbps");
const uptime = ref("99.8%");

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
      return measuredSpeed.value;
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
  switch (status.value) {
    case "activo":
      return "text-2xl font-bold text-gray-800 mb-1";
    case "cargando":
      return "text-2xl font-bold text-gray-400 mb-1";
    case "inactivo":
      return "text-lg font-bold text-red-600 bg-red-100 px-2 py-1 rounded mb-1 inline-block rounded-xl";
    case "suspendido":
    case "cancelado":
      return "text-lg font-bold text-orange-600 bg-orange-100 px-2 py-1 rounded mb-1 inline-block rounded-xl";
    default:
      return "text-2xl font-bold text-gray-800 mb-1";
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
  return status.value === "activo" ? "text-green-400" : "text-red-500";
});

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
