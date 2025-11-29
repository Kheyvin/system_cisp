<template>
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

<script setup>
import { computed, ref } from "vue";
import Button from "../../../components/ui/atoms/Button.vue";
import Icon from "../../../components/ui/atoms/Icon.vue";
import PaymentBrandIcon from "../components/PaymentBrandIcon.vue";

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
