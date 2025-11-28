<template>
  <div>
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-3xl font-bold text-ksp-principal">
          Solicitudes de Servicio
        </h2>
        <span class="text-base">Crea y gestiona tus solicitudes de soporte</span>
      </div>
      <Button
        customClass="bg-[#324D68] text-white hover:bg-[#24384c] flex items-center px-4 py-2 shadow-sm cursor-pointer"
      >
        <Icon name="plus" size="20" class="mr-2" />
        Nueva solicitud
      </Button>
    </div>

    <div class="grid grid-cols-12 gap-6">
      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-blue-100 p-2 mr-3 rounded-full">
              <Icon name="chat-bubble" size="24" class="text-blue-600" />
            </div>
            <span class="text-gray-600 font-medium">Total Solicitudes</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              {{ totalRequests }}
            </h3>
            <p class="text-gray-500 text-sm">Este mes</p>
          </div>
        </Card>
      </div>

      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-yellow-100 p-2 mr-3 rounded-full">
              <Icon name="clock" size="24" class="text-yellow-600" />
            </div>
            <span class="text-gray-600 font-medium">En Progreso</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              {{ inProgressRequests }}
            </h3>
            <p class="text-gray-500 text-sm">Siendo atendidas</p>
          </div>
        </Card>
      </div>

      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-green-100 p-2 mr-3 rounded-full">
              <Icon name="check-round" size="24" class="text-green-600" />
            </div>
            <span class="text-gray-600 font-medium">Completadas</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              {{ completedRequests }}
            </h3>
            <p class="text-gray-500 text-sm">Resueltas</p>
          </div>
        </Card>
      </div>

      <div class="col-span-12 md:col-span-6 lg:col-span-3">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-red-100 p-2 mr-3 rounded-full">
              <Icon name="alert-circle" size="24" class="text-red-500" />
            </div>
            <span class="text-gray-600 font-medium">Pendientes</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              {{ pendingRequests }}
            </h3>
            <p class="text-gray-500 text-sm">Esperando respuesta</p>
          </div>
        </Card>
      </div>
    </div>

    <div class="mt-8">
      <Card class="p-6 bg-white shadow-sm hover:shadow-lg transition-shadow duration-200">
        <div class="mb-4">
          <h3 class="text-lg font-bold text-gray-800">Historial de Solicitudes</h3>
          <p class="text-sm text-gray-500">Busca y filtra tus solicitudes</p>
        </div>

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
          <div class="relative w-full lg:max-w-sm">
            <Icon
              name="search"
              size="18"
              class="text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"
            />
            <input
              v-model="searchQuery"
              type="text"
              class="w-full border border-gray-200 rounded-md py-2 pl-10 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-ksp-principal/30 focus:border-ksp-principal"
              placeholder="Buscar por ID o asunto ..."
            />
          </div>

          <div class="relative w-full lg:w-60 ml-auto">
            <button
              type="button"
              @click="togglePriorityDropdown"
              class="w-full border border-gray-200 rounded-md py-2 pl-12 pr-3 text-sm text-left focus:outline-none focus:ring-2 focus:ring-ksp-principal/30 focus:border-ksp-principal cursor-pointer flex items-center"
            >
              <Icon
                name="filter"
                size="20"
                class="text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"
              />
              <span class="truncate pr-6">Prioridad: {{ selectedPriorityLabel }}</span>
              <Icon
                name="chevron-down"
                size="16"
                :class="[
                  'ml-auto text-gray-500 transition-transform duration-200',
                  isPriorityDropdownOpen ? 'rotate-180' : 'rotate-0',
                ]"
              />
            </button>

            <transition name="fade">
              <ul
                v-if="isPriorityDropdownOpen"
                class="absolute z-10 mt-2 w-full bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto text-sm"
              >
                <li
                  v-for="option in priorityOptions"
                  :key="option.value"
                  @click="handlePrioritySelect(option.value)"
                  class="flex items-center justify-between px-4 py-2 hover:bg-gray-50 cursor-pointer"
                >
                  <span>{{ option.label }}</span>
                  <Icon
                    v-if="priorityFilter === option.value"
                    name="check"
                    size="16"
                    class="text-ksp-green"
                  />
                </li>
              </ul>
            </transition>
          </div>
          
          <div class="relative w-full lg:w-60">
            <button
              type="button"
              @click="toggleStatusDropdown"
              class="w-full border border-gray-200 rounded-md py-2 pl-12 pr-3 text-sm text-left focus:outline-none focus:ring-2 focus:ring-ksp-principal/30 focus:border-ksp-principal cursor-pointer flex items-center"
            >
              <Icon
                name="filter"
                size="20"
                class="text-gray-500 absolute left-3 top-1/2 -translate-y-1/2"
              />
              <span class="truncate pr-6">Estado: {{ selectedStatusLabel }}</span>
              <Icon
                name="chevron-down"
                size="16"
                :class="[
                  'ml-auto text-gray-500 transition-transform duration-200',
                  isStatusDropdownOpen ? 'rotate-180' : 'rotate-0',
                ]"
              />
            </button>

            <transition name="fade">
              <ul
                v-if="isStatusDropdownOpen"
                class="absolute z-10 mt-2 w-full bg-white border border-gray-200 rounded-md shadow-lg max-h-60 overflow-y-auto text-sm"
              >
                <li
                  v-for="option in statusOptions"
                  :key="option.value"
                  @click="handleStatusSelect(option.value)"
                  class="flex items-center justify-between px-4 py-2 hover:bg-gray-50 cursor-pointer"
                >
                  <span>{{ option.label }}</span>
                  <Icon
                    v-if="statusFilter === option.value"
                    name="check"
                    size="16"
                    class="text-ksp-green"
                  />
                </li>
              </ul>
            </transition>
          </div>
        </div>

        <div class="mt-4">
          <DataTable
            :columns="requestColumns"
            :data="paginatedRequests"
            :pagination="paginationState"
            @page-change="handlePageChange"
            @update:itemsPerPage="handleItemsPerPageChange"
          >
            <template #cell-priority="{ value }">
              <span
                class="px-3 py-1 rounded-full text-xs font-semibold capitalize"
                :class="priorityBadgeClass(value)"
              >
                {{ value }}
              </span>
            </template>

            <template #cell-status="{ value }">
              <span
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold"
                :class="statusBadgeClass(value)"
              >
                <Icon :name="statusIconName(value)" size="14" />
                {{ value }}
              </span>
            </template>

            <template #cell-actions>
              <button
                class="inline-flex items-center gap-2 px-4 py-2 rounded-md text-sm font-medium text-white bg-[#465E77] hover:bg-[#324D68] transition-colors cursor-pointer"
              >
                <Icon name="eye" size="16" />
                Ver detalles
              </button>
            </template>
          </DataTable>
        </div>
      </Card>
    </div>
  </div>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import Button from "../../components/ui/atoms/Button.vue";
import Icon from "../../components/ui/atoms/Icon.vue";
import Card from "../../components/ui/atoms/Card.vue";
import DataTable from "../../components/ui/organisms/DataTable.vue";

const requests = ref([
  {
    id: "SOL-2301",
    type: "Soporte técnico",
    subject: "Error al iniciar sesión",
    date: "2024-07-05",
    priority: "Alta",
    status: "En progreso",
  },
  {
    id: "SOL-2299",
    type: "Facturación",
    subject: "Revisión de factura automática",
    date: "2024-07-02",
    priority: "Media",
    status: "Pendiente",
  },
  {
    id: "SOL-2295",
    type: "Implementación",
    subject: "Configuración multi-sede",
    date: "2024-06-28",
    priority: "Alta",
    status: "Resuelto",
  },
  {
    id: "SOL-2292",
    type: "Integraciones",
    subject: "API retorna error 500",
    date: "2024-06-25",
    priority: "Crítica",
    status: "Abierta",
  },
  {
    id: "SOL-2288",
    type: "Capacitación",
    subject: "Sesión para nuevos usuarios",
    date: "2024-06-20",
    priority: "Baja",
    status: "Cerrado",
  },
  {
    id: "SOL-2281",
    type: "Soporte técnico",
    subject: "Migración de base de datos",
    date: "2024-06-18",
    priority: "Crítica",
    status: "En espera",
  },
  {
    id: "SOL-2275",
    type: "Facturación",
    subject: "Nota de crédito",
    date: "2024-06-12",
    priority: "Media",
    status: "Resuelto",
  },
  {
    id: "SOL-2269",
    type: "Seguridad",
    subject: "Revisión de accesos",
    date: "2024-06-08",
    priority: "Alta",
    status: "Pendiente",
  },
]);

const requestColumns = [
  { key: "id", label: "ID solicitud", headerClass: "whitespace-nowrap" },
  { key: "type", label: "Tipo" },
  {
    key: "subject",
    label: "Asunto",
    headerClass: "min-w-[200px]",
  },
  { key: "date", label: "Fecha", headerClass: "whitespace-nowrap" },
  { key: "priority", label: "Prioridad" },
  { key: "status", label: "Estado" },
  {
    key: "actions",
    label: "Acciones",
    headerClass: "text-right",
    cellClass: "text-right",
  },
];

const statusOptions = computed(() => {
  const uniqueStatuses = Array.from(
    new Set(requests.value.map((request) => request.status))
  );

  return [
    { label: "Todos", value: "all" },
    ...uniqueStatuses.map((status) => ({ label: status, value: status })),
  ];
});

const priorityOptions = computed(() => {
  const uniquePriorities = Array.from(
    new Set(requests.value.map((request) => request.priority))
  );

  return [
    { label: "Todas", value: "all" },
    ...uniquePriorities.map((priority) => ({ label: priority, value: priority })),
  ];
});

const searchQuery = ref("");
const statusFilter = ref("all");
const priorityFilter = ref("all");
const isStatusDropdownOpen = ref(false);
const isPriorityDropdownOpen = ref(false);
const itemsPerPage = ref(10);
const currentPage = ref(1);

const totalRequests = computed(() => requests.value.length);
const inProgressRequests = computed(
  () => requests.value.filter((request) => request.status === "En progreso").length
);
const completedRequests = computed(
  () =>
    requests.value.filter((request) => ["Resuelto", "Cerrado"].includes(request.status)).length
);
const pendingRequests = computed(
  () =>
    requests.value.filter((request) => ["Pendiente", "Abierta", "En espera"].includes(request.status)).length
);

const selectedStatusLabel = computed(() => {
  const option = statusOptions.value.find(
    (item) => item.value === statusFilter.value
  );
  return option ? option.label : "Todos los estados";
});

const selectedPriorityLabel = computed(() => {
  const option = priorityOptions.value.find(
    (item) => item.value === priorityFilter.value
  );
  return option ? option.label : "Todas las prioridades";
});

const filteredRequests = computed(() => {
  const term = searchQuery.value.trim().toLowerCase();
  const status = statusFilter.value;
  const priority = priorityFilter.value;

  return requests.value.filter((request) => {
    const matchesTerm = term
      ? request.id.toLowerCase().includes(term) ||
        request.subject.toLowerCase().includes(term) ||
        request.type.toLowerCase().includes(term)
      : true;

    const matchesStatus =
      status === "all"
        ? true
        : request.status.toLowerCase() === status.toLowerCase();

    const matchesPriority =
      priority === "all"
        ? true
        : request.priority.toLowerCase() === priority.toLowerCase();

    return matchesTerm && matchesStatus && matchesPriority;
  });
});

const totalPages = computed(() =>
  Math.max(1, Math.ceil(filteredRequests.value.length / itemsPerPage.value))
);

const paginatedRequests = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return filteredRequests.value.slice(start, start + itemsPerPage.value);
});

const paginationState = computed(() => ({
  currentPage: currentPage.value,
  totalPages: totalPages.value,
  itemsPerPage: itemsPerPage.value,
}));

watch([searchQuery, statusFilter, priorityFilter], () => {
  currentPage.value = 1;
});

const handlePageChange = (page) => {
  if (page < 1 || page > totalPages.value) return;
  currentPage.value = page;
};

const handleItemsPerPageChange = (value) => {
  itemsPerPage.value = value;
  currentPage.value = 1;
};

const toggleStatusDropdown = () => {
  isStatusDropdownOpen.value = !isStatusDropdownOpen.value;
};

const handleStatusSelect = (value) => {
  statusFilter.value = value;
  isStatusDropdownOpen.value = false;
};

const togglePriorityDropdown = () => {
  isPriorityDropdownOpen.value = !isPriorityDropdownOpen.value;
};

const handlePrioritySelect = (value) => {
  priorityFilter.value = value;
  isPriorityDropdownOpen.value = false;
};

const priorityBadgeClass = (priority) => {
  const map = {
    critica: "bg-red-600 text-white",
    alta: "bg-orange-500 text-white",
    media: "bg-yellow-500 text-white",
    baja: "bg-emerald-600 text-white",
  };

  return map[priority.toLowerCase()] || "bg-gray-500 text-white";
};

const statusBadgeClass = (status) => {
  const map = {
    resuelto: "bg-green-600 text-white",
    "en progreso": "bg-blue-600 text-white",
    pendiente: "bg-amber-500 text-white",
    "en espera": "bg-orange-600 text-white",
    abierta: "bg-slate-600 text-white",
    cerrado: "bg-zinc-600 text-white",
  };

  return map[status.toLowerCase()] || "bg-gray-500 text-white";
};

const statusIconName = (status) => {
  const map = {
    resuelto: "check-round",
    "en progreso": "clock-round",
    pendiente: "alert-circle",
    "en espera": "pause",
    abierta: "chat-bubble",
    cerrado: "check-round",
  };

  return map[status.toLowerCase()] || "chat-bubble";
};
</script>
