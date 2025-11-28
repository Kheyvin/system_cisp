<template>
  <div>
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-3xl font-bold text-ksp-principal">
          Solicitudes de Servicio
        </h2>
        <span class="text-base"
          >Crea y gestiona tus solicitudes de soporte
        </span>
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
            <span class="text-gray-600 font-medium"> En Progreso </span>
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
            <span class="text-gray-600 font-medium"> Completadas </span>
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
            <span class="text-gray-600 font-medium"> Pendientes </span>
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
      <Card
        class="p-6 bg-white shadow-sm hover:shadow-lg transition-shadow duration-200"
      >
        <div class="mb-4">
          <h3 class="text-lg font-bold text-gray-800">Historial de Facturas</h3>
          <p class="text-sm text-gray-500">Busca y filtra tus facturas</p>
        </div>

        <div
          class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
        >
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
              placeholder="Buscar por número de factura o periodo ..."
            />
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
              <span class="truncate pr-6">{{ selectedStatusLabel }}</span>
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
            :columns="invoiceColumns"
            :data="paginatedInvoices"
            :pagination="paginationState"
            @page-change="handlePageChange"
            @update:itemsPerPage="handleItemsPerPageChange"
          >
            <template #cell-status="{ value }">
              <span
                class="px-3 py-1 rounded-full text-xs font-semibold"
                :class="paymentStatusClass(value)"
              >
                {{ value }}
              </span>
            </template>

            <template #cell-actions="{ row }">
              <div class="flex flex-wrap items-center gap-2 justify-start">
                <template v-if="shouldShowDetailActions(row.status)">
                  <button
                    class="p-2 border border-gray-200 rounded-md text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer"
                    aria-label="Ver factura"
                  >
                    <Icon name="eye" size="18" />
                  </button>
                  <button
                    class="p-2 border border-gray-200 rounded-md text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer"
                    aria-label="Descargar factura"
                  >
                    <Icon name="download" size="18" />
                  </button>
                </template>
                <button
                  v-if="shouldShowPayButton(row.status)"
                  class="px-3 py-1 rounded-md text-sm font-medium bg-[#455D77] text-white hover:bg-[#324D68] transition-colors cursor-pointer"
                >
                  Pagar
                </button>
              </div>
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

const totalRequests = ref(4);
const inProgressRequests = ref(2);
const completedRequests = ref(1);
const pendingRequests = ref(1);

const invoiceColumns = [
  {
    key: "number",
    label: "Número de factura",
    headerClass: "whitespace-nowrap",
  },
  { key: "period", label: "Periodo" },
  {
    key: "issueDate",
    label: "Fecha de emisión",
    headerClass: "whitespace-nowrap",
  },
  { key: "amount", label: "Monto" },
  { key: "status", label: "Estado" },
  {
    key: "paymentDate",
    label: "Fecha de pago",
    headerClass: "whitespace-nowrap",
  },
  {
    key: "paymentMethod",
    label: "Método de pago",
    headerClass: "whitespace-nowrap",
  },
  {
    key: "actions",
    label: "Acciones",
    headerClass: "text-center",
    cellClass: "text-center",
  },
];

const invoices = ref([
  {
    number: "FAC-2024-001",
    period: "Enero 2024",
    issueDate: "2024-01-15",
    amount: "S/ 35.99",
    status: "Pagado",
    paymentDate: "2024-01-16",
    paymentMethod: "Tarjeta de Crédito",
  },
  {
    number: "FAC-2024-002",
    period: "Febrero 2024",
    issueDate: "2024-02-15",
    amount: "S/ 35.99",
    status: "Pagado",
    paymentDate: "2024-02-16",
    paymentMethod: "Débito automático",
  },
  {
    number: "FAC-2024-003",
    period: "Marzo 2024",
    issueDate: "2024-03-15",
    amount: "S/ 37.50",
    status: "Pendiente",
    paymentDate: "-",
    paymentMethod: "Pendiente",
  },
  {
    number: "FAC-2024-004",
    period: "Abril 2024",
    issueDate: "2024-04-15",
    amount: "S/ 37.50",
    status: "Procesando",
    paymentDate: "2024-04-16",
    paymentMethod: "Transferencia",
  },
  {
    number: "FAC-2024-005",
    period: "Mayo 2024",
    issueDate: "2024-05-15",
    amount: "S/ 39.99",
    status: "Vencido",
    paymentDate: "-",
    paymentMethod: "Pendiente",
  },
  {
    number: "FAC-2024-006",
    period: "Junio 2024",
    issueDate: "2024-06-15",
    amount: "S/ 39.99",
    status: "Pagado",
    paymentDate: "2024-06-16",
    paymentMethod: "Tarjeta de Crédito",
  },
  {
    number: "FAC-2024-007",
    period: "Julio 2024",
    issueDate: "2024-07-15",
    amount: "S/ 41.50",
    status: "Pendiente",
    paymentDate: "-",
    paymentMethod: "Tarjeta de Crédito",
  },
  {
    number: "FAC-2024-008",
    period: "Agosto 2024",
    issueDate: "2024-08-15",
    amount: "S/ 41.50",
    status: "Suspendido",
    paymentDate: "-",
    paymentMethod: "Pendiente",
  },
]);

const statusOptions = [
  { label: "Todos los estados", value: "all" },
  { label: "Pagado", value: "Pagado" },
  { label: "Pendiente", value: "Pendiente" },
  { label: "Procesando", value: "Procesando" },
  { label: "Suspendido", value: "Suspendido" },
  { label: "Vencido", value: "Vencido" },
];

const searchQuery = ref("");
const statusFilter = ref("all");
const isStatusDropdownOpen = ref(false);

const itemsPerPage = ref(10);
const currentPage = ref(1);

const selectedStatusLabel = computed(() => {
  const match = statusOptions.find(
    (option) => option.value === statusFilter.value
  );
  return match ? match.label : "Todos los estados";
});

const filteredInvoices = computed(() => {
  const term = searchQuery.value.trim().toLowerCase();
  const filter = statusFilter.value;

  return invoices.value.filter((invoice) => {
    const matchesTerm = term
      ? invoice.number.toLowerCase().includes(term) ||
        invoice.period.toLowerCase().includes(term)
      : true;
    const matchesStatus =
      filter === "all"
        ? true
        : invoice.status.toLowerCase() === filter.toLowerCase();
    return matchesTerm && matchesStatus;
  });
});

const totalPages = computed(() =>
  Math.max(1, Math.ceil(filteredInvoices.value.length / itemsPerPage.value))
);

const paginatedInvoices = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return filteredInvoices.value.slice(start, start + itemsPerPage.value);
});

const paginationState = computed(() => ({
  currentPage: currentPage.value,
  totalPages: totalPages.value,
  itemsPerPage: itemsPerPage.value,
}));

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

watch([searchQuery, statusFilter], () => {
  currentPage.value = 1;
});

const paymentStatusClass = (status) => {
  const map = {
    Pagado: "bg-green-500 text-white",
    Pendiente: "bg-yellow-500 text-white",
    Suspendido: "bg-red-500 text-white",
    Procesando: "bg-blue-600 text-white",
    Vencido: "bg-orange-600 text-white",
  };
  return map[status] || "bg-gray-600 text-white";
};

const shouldShowPayButton = (status) =>
  status === "Pendiente" || status === "Vencido";

const shouldShowDetailActions = (status) =>
  !["Pendiente", "Procesando", "Vencido"].includes(status);
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

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.15s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>