<template>
  <div class="flex flex-col gap-4">
    <div>
      <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">
        Seguimiento
      </p>
      <h3 class="text-2xl font-bold text-gray-800 mt-1">
        Historial de transacciones
      </h3>
      <p class="text-gray-600 mt-2">
        Consulta cada pago realizado, revisa estados y descarga los comprobantes cuando los necesites.
      </p>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-gray-100">
      <table class="min-w-full divide-y divide-gray-100 text-left">
        <thead class="bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
          <tr>
            <th class="px-6 py-3">ID Transacción</th>
            <th class="px-6 py-3">Fecha</th>
            <th class="px-6 py-3">Monto</th>
            <th class="px-6 py-3">Método</th>
            <th class="px-6 py-3">Estado</th>
            <th class="px-6 py-3">Descripción</th>
            <th class="px-6 py-3 text-center">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
          <tr v-for="txn in transactionHistory" :key="txn.id" class="bg-white">
            <td class="px-6 py-4 font-semibold text-gray-800">{{ txn.id }}</td>
            <td class="px-6 py-4">{{ txn.date }}</td>
            <td class="px-6 py-4 font-semibold text-gray-900">{{ txn.amount }}</td>
            <td class="px-6 py-4">{{ txn.method }}</td>
            <td class="px-6 py-4">
              <span
                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold"
                :class="transactionStatusClass(txn.status)"
              >
                {{ txn.status }}
              </span>
            </td>
            <td class="px-6 py-4 text-gray-600">{{ txn.description }}</td>
            <td class="px-6 py-4">
              <div class="flex justify-center">
                <button
                  class="p-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer"
                  aria-label="Descargar comprobante"
                >
                  <Icon name="download" size="16" />
                </button>
              </div>
            </td>
          </tr>
        </tbody>
        <tfoot class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
          <tr>
            <td colspan="7" class="px-6 py-3">
              {{ historySummaryLabel }}
            </td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div
      class="flex flex-col gap-3 border-t border-gray-100 pt-4 text-sm text-gray-600 md:flex-row md:items-center md:justify-between"
    >
      <div class="flex items-center gap-2">
        <span class="inline-flex h-2 w-2 rounded-full bg-green-500"></span>
        <span>{{ lastHistoryUpdate }}</span>
      </div>
      <div class="flex flex-wrap items-center gap-3">
        <Button
          customClass="bg-white border border-gray-200 text-[#324D68] hover:bg-gray-50 px-4 py-2 flex items-center gap-2 cursor-pointer"
        >
          <Icon name="download" size="16" />
          Exportar historial
        </Button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import Button from "../../../components/ui/atoms/Button.vue";
import Icon from "../../../components/ui/atoms/Icon.vue";

const transactionHistory = ref([
  {
    id: "PAY-2024-001",
    date: "2024-01-15",
    amount: "S/ 35.99",
    method: "Visa •••• 4532",
    status: "Completado",
    description: "Pago mensual - Plan Premium",
  },
  {
    id: "PAY-2024-002",
    date: "2024-02-15",
    amount: "S/ 35.99",
    method: "Visa •••• 4532",
    status: "Completado",
    description: "Pago mensual - Plan Premium",
  },
  {
    id: "PAY-2024-003",
    date: "2024-03-15",
    amount: "S/ 38.50",
    method: "Mastercard •••• 9011",
    status: "Pendiente",
    description: "Pago mensual - Plan Premium",
  },
  {
    id: "PAY-2024-004",
    date: "2024-04-15",
    amount: "S/ 35.99",
    method: "American Express •••• 3321",
    status: "Fallido",
    description: "Pago mensual - Plan Premium",
  },
  {
    id: "PAY-2024-005",
    date: "2024-05-15",
    amount: "S/ 35.99",
    method: "Visa •••• 7789",
    status: "Reembolsado",
    description: "Pago mensual - Plan Premium",
  },
]);

const lastHistoryUpdate = ref("Actualizado el 18 May 2024 - 10:24 h");

const historySummaryLabel = computed(() => {
  const count = transactionHistory.value.length;
  return `Mostrando ${count} ${count === 1 ? "transacción" : "transacciones"}`;
});

const transactionStatusClass = (status) => {
  const map = {
    Completado: "bg-green-500 text-white",
    Pendiente: "bg-amber-500 text-white",
    Fallido: "bg-red-600 text-white",
    Reembolsado: "bg-blue-600 text-white",
    Procesando: "bg-indigo-500 text-white",
  };

  return map[status] || "bg-gray-600 text-white";
};
</script>
