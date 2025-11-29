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
                  :class="[
                    'flex flex-col gap-3 rounded-2xl border border-gray-200 bg-white/80 p-4 md:flex-row md:items-center',
                    method.status === 'Predeterminado' ? 'border-2 border-ksp-principal' : ''
                  ]"
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
                  class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-center text-sm font-semibold text-[#324D68] transition-colors hover:bg-[#324D68]/5 hover:text-[#24384c] cursor-pointer"
                  @click="toggleMethodsExpansion"
                >
                  {{ showAllMethods ? 'Ver menos' : 'Ver más' }}
                </button>
              </div>
            </div>
          </template>

          <template v-else-if="activePaymentTab === 'history'">
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

          <template v-else>
            <div class="flex flex-col gap-6">
              <div class="flex flex-col gap-4 border-b border-gray-100 pb-4">
                <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">
                  Automatización
                </p>
                <div
                  class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
                >
                  <div class="flex items-start gap-3">
                    <div class="rounded-2xl bg-[#E6FAF7] p-3 text-[#32C1B1]">
                      <Icon name="shield-check" size="28" />
                    </div>
                    <div>
                      <h3 class="text-2xl font-bold text-gray-800">
                        Configuración de Pago Automático
                      </h3>
                      <p class="text-gray-600 mt-2">
                        Asegura tus servicios con débitos programados, alertas previas y monitoreo en tiempo real de cada cargo.
                      </p>
                    </div>
                  </div>
                  <div class="flex items-center gap-3">
                    <span
                      class="text-sm font-semibold"
                      :class="autopayEnabled ? 'text-ksp-green' : 'text-ksp-red'"
                    >
                      {{ autopayEnabled ? 'Activo' : 'Desactivado' }}
                    </span>
                    <button
                      class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors cursor-pointer"
                      :class="autopayEnabled ? 'bg-ksp-green' : 'bg-ksp-red'"
                      type="button"
                      @click="toggleAutopayStatus"
                    >
                      <span class="sr-only">Cambiar pago automático</span>
                      <span
                        class="inline-block h-6 w-6 transform rounded-full bg-white shadow transition-transform"
                        :class="autopayEnabled ? 'translate-x-5' : 'translate-x-1'"
                      ></span>
                    </button>
                  </div>
                </div>
              </div>

              <div
                class="rounded-2xl border border-gray-100 p-4 flex flex-col gap-3"
                :class="autopayEnabled ? 'bg-[#E6FAF7]' : 'bg-[#FFF5F5] border-red-100'"
              >
                <div class="flex items-start gap-3">
                  <div
                    class="rounded-full bg-white/70 p-2"
                    :class="autopayEnabled ? 'text-ksp-green' : 'text-ksp-red'"
                  >
                    <Icon name="alert-circle" size="20" />
                  </div>
                  <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-gray-500">
                      Beneficios del Pago Automático
                    </p>
                    <p class="text-sm text-gray-600">
                      {{
                        autopayEnabled
                          ? 'Mantén estos beneficios mientras el servicio automático está activo.'
                          : 'Activa el pago automático para acceder inmediatamente a estos beneficios.'
                      }}
                    </p>
                  </div>
                </div>
                <ul class="space-y-2 text-sm text-gray-700">
                  <li
                    v-for="(benefit, index) in autopayBenefits"
                    :key="`benefit-${index}`"
                    class="flex items-start gap-2"
                  >
                    <span
                      class="mt-0.5 inline-flex h-2 w-2 rounded-full"
                      :class="autopayEnabled ? 'bg-ksp-green' : 'bg-ksp-red'"
                    ></span>
                    <span>{{ benefit }}</span>
                  </li>
                </ul>
              </div>

              <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-gray-100 bg-white/60 p-4">
                  <p class="text-sm text-gray-500">Método principal</p>
                  <p class="mt-1 text-lg font-semibold text-gray-800">
                    {{ autopayMethod.label }}
                  </p>
                  <p class="text-sm text-gray-500">
                    {{ autopayMethod.type }} · {{ autopayMethod.additional }}
                  </p>
                </div>
                <div class="rounded-2xl border border-gray-100 p-4">
                  <p class="text-sm text-gray-500">Día de cargo</p>
                  <div class="mt-1 flex flex-wrap items-center gap-3">
                    <span class="text-lg font-semibold text-gray-800">
                      Día {{ autopayChargeDay }} de cada mes
                    </span>
                    <span
                      class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600"
                    >
                      Próximo cargo: {{ autopayNextCharge }}
                    </span>
                  </div>
                  <p class="text-sm text-gray-500 mt-1">
                    Confirmamos el cargo entre 08:00 y 10:00 h.
                  </p>
                </div>
              </div>

              <div
                class="rounded-2xl border border-gray-100 p-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between"
              >
                <div>
                  <p class="text-sm text-gray-500">Notificaciones</p>
                  <p class="text-lg font-semibold text-gray-800">
                    {{
                      autopayNotificationsEnabled
                        ? 'Enviamos alertas 24 h antes'
                        : 'Alertas pausadas temporalmente'
                    }}
                  </p>
                  <p class="text-sm text-gray-500">
                    Se notificará al correo financiero registrado.
                  </p>
                </div>
                <div class="flex items-center gap-3">
                  <span
                    class="text-sm font-semibold"
                    :class="autopayNotificationsEnabled ? 'text-ksp-green' : 'text-ksp-red'"
                  >
                    {{ autopayNotificationsEnabled ? 'Activadas' : 'Desactivadas' }}
                  </span>
                  <button
                    class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors cursor-pointer"
                    :class="autopayNotificationsEnabled ? 'bg-ksp-green' : 'bg-ksp-red'"
                    type="button"
                    @click="toggleNotificationStatus"
                  >
                    <span class="sr-only">Cambiar notificaciones</span>
                    <span
                      class="inline-block h-6 w-6 transform rounded-full bg-white shadow transition-transform"
                      :class="autopayNotificationsEnabled ? 'translate-x-5' : 'translate-x-1'"
                    ></span>
                  </button>
                </div>
              </div>

              <div
                class="flex flex-col gap-3 rounded-2xl border border-dashed border-gray-200 bg-gray-50/60 p-4 md:flex-row md:items-center md:justify-between"
              >
                <div>
                  <p class="text-sm font-semibold text-gray-700">Resumen del cargo</p>
                  <p class="text-sm text-gray-500 mt-1">
                    Usaremos tu método principal y enviaremos el comprobante desde el sistema automático.
                  </p>
                  <p class="text-xs text-gray-400 mt-1">
                    Última modificación: {{ autopayLastUpdated }}
                  </p>
                </div>
                <Button
                  customClass="bg-[#324D68] text-white hover:bg-[#24384c] px-4 py-2 flex items-center gap-2 cursor-pointer"
                >
                  <Icon name="edit" size="18" />
                  Modificar configuración
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

const autopayEnabled = ref(true);
const autopayNotificationsEnabled = ref(true);
const autopayMethod = ref({
  label: "Visa •••• 7789",
  type: "Tarjeta de Débito",
  additional: "Predeterminada para sistemas",
});
const autopayChargeDay = ref(15);
const autopayNextCharge = ref("15 Jun 2024");
const autopayLastUpdated = ref("12 May 2024 - 09:10 h");
const autopayBenefits = [
  "Nunca te olvides de pagar tu factura",
  "Evita cargos por pago tardío",
  "Mantén tu servicio activo sin interrupciones",
  "Recibe notificaciones antes de cada cargo",
];

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

const showAllMethods = ref(false);

const historySummaryLabel = computed(() => {
  const count = transactionHistory.value.length;
  return `Mostrando ${count} ${count === 1 ? "transacción" : "transacciones"}`;
});

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

const toggleAutopayStatus = () => {
  autopayEnabled.value = !autopayEnabled.value;
};

const toggleNotificationStatus = () => {
  autopayNotificationsEnabled.value = !autopayNotificationsEnabled.value;
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
