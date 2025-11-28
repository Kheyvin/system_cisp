<template>
  <div>
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-3xl font-bold text-ksp-principal">
          Recibos y Facturas
        </h2>
        <span class="text-base">Gestiona tus facturas y recibos de pago </span>
      </div>
      <Button
        customClass="bg-[#324D68] text-white hover:bg-[#24384c] flex items-center px-4 py-2 shadow-sm cursor-pointer"
      >
        <Icon name="file-text" size="20" class="mr-2" />
        Generar Reporte
      </Button>
    </div>

    <div class="grid grid-cols-12 gap-6">
      <div class="col-span-12 md:col-span-6 lg:col-span-4">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-ksp-green/10 p-2 mr-3 rounded-full">
              <Icon name="credit-card" size="24" class="text-ksp-green" />
            </div>
            <span class="text-gray-600 font-medium">Total pagado</span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              S/ {{ totalPaid }}
            </h3>
            <p class="text-gray-500 text-sm">Este año</p>
          </div>
        </Card>
      </div>

      <div class="col-span-12 md:col-span-6 lg:col-span-4">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-ksp-yellow/10 p-2 mr-3 rounded-full">
              <Icon name="credit-card" size="24" class="text-ksp-yellow" />
            </div>
            <span class="text-gray-600 font-medium"> Pendiente de pago </span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              S/ {{ pendingAmount }}
            </h3>
            <p class="text-gray-500 text-sm">Por pagar</p>
          </div>
        </Card>
      </div>

      <div class="col-span-12 md:col-span-6 lg:col-span-4">
        <Card
          class="h-full flex flex-col p-6 hover:shadow-lg transition-shadow duration-200 min-h-[200px] justify-between bg-white"
        >
          <div class="flex items-center mb-4">
            <div class="bg-red-100 p-2 mr-3 rounded-full">
              <Icon name="credit-card" size="24" class="text-red-500" />
            </div>
            <span class="text-gray-600 font-medium"> Facturas vencidas </span>
          </div>
          <div class="grow flex flex-col justify-end">
            <h3 class="text-xl font-bold text-gray-800 mb-1">
              S/ {{ overdueAmount }}
            </h3>
            <p class="text-gray-500 text-sm">Requiere atención</p>
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
import { computed, ref } from "vue";
import Button from "../../components/ui/atoms/Button.vue";
import Icon from "../../components/ui/atoms/Icon.vue";
import Card from "../../components/ui/atoms/Card.vue";
import DataTable from "../../components/ui/organisms/DataTable.vue";

const totalPaid = ref("1,245.50");
const pendingAmount = ref("129.99");
const overdueAmount = ref("258.40");

const invoiceColumns = [
  { key: "number", label: "Número de factura", headerClass: "whitespace-nowrap" },
  { key: "period", label: "Periodo" },
  { key: "issueDate", label: "Fecha de emisión", headerClass: "whitespace-nowrap" },
  { key: "amount", label: "Monto" },
  { key: "status", label: "Estado" },
  { key: "paymentDate", label: "Fecha de pago", headerClass: "whitespace-nowrap" },
  { key: "paymentMethod", label: "Método de pago", headerClass: "whitespace-nowrap" },
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

const itemsPerPage = ref(10);
const currentPage = ref(1);

const totalPages = computed(() =>
  Math.max(1, Math.ceil(invoices.value.length / itemsPerPage.value))
);

const paginatedInvoices = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  return invoices.value.slice(start, start + itemsPerPage.value);
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
</style>