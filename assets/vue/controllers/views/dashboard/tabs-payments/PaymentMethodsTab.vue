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
        @click="openAddMethodModal"
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

    <transition
      name="modal-entrar"
      enter-active-class="modal-entrar-activo"
      leave-active-class="modal-salir-activo"
      enter-from-class="modal-entrar-desde"
      leave-to-class="modal-salir-hacia"
    >
      <div
        v-if="showAddMethodModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/55 px-4"
        @click.self="closeAddMethodModal"
      >
        <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl">
          <div class="flex items-start justify-between" style="padding: 21px 21px 0 21px">
            <div class="flex-1 flex flex-col gap-2 text-center sm:text-left">
              <h3 class="text-lg leading-none font-semibold">
                Agregar Método de Pago
              </h3>
              <p class="text-sm" style="color: #64748b">
                Agrega una nueva tarjeta o cuenta bancaria
              </p>
            </div>
            <button
              type="button"
              class="ml-4 text-gray-400 hover:text-gray-600 transition-colors cursor-pointer"
              @click="closeAddMethodModal"
              aria-label="Cerrar"
            >
              <Icon name="x" size="20" />
            </button>
          </div>

          <form @submit.prevent="handleAddMethod" class="space-y-5" style="padding: 21px">
            <div class="flex items-center gap-4">
              <label class="w-32 text-sm font-semibold text-gray-700">
                Tipo
              </label>
              <div class="relative flex-1">
                <select
                  v-model="newMethod.type"
                  class="select-pago w-full rounded-lg border-0 px-4 py-2 pr-10 focus:border focus:border-[#4FCABC] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#4FCABC]/50 appearance-none cursor-pointer"
                  :class="newMethod.type ? 'text-gray-900' : 'text-gray-400'"
                  style="background-color: #f8fafc"
                  required
                >
                  <option value="" disabled hidden>Seleccionar tipo</option>
                  <option 
                    v-for="option in paymentTypeOptions" 
                    :key="option.value" 
                    :value="option.value"
                  >
                    {{ option.label }}
                  </option>
                </select>
                <Icon
                  name="chevron-down"
                  size="20"
                  class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                />
              </div>
            </div>

            <div class="flex items-center gap-4">
              <label class="w-32 text-sm font-semibold text-gray-700">
                Número
              </label>
              <div class="flex-1">
                <input
                  v-model="newMethod.number"
                  type="text"
                  placeholder="1234 5678 9012 3456"
                  :class="[
                    'w-full rounded-lg border-0 px-4 py-2 text-gray-900 placeholder-gray-400 focus:border focus:border-[#4FCABC] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#4FCABC]/50',
                    cardNumberError ? 'border border-red-500 focus:border-red-500' : ''
                  ]"
                  style="background-color: #f8fafc"
                  maxlength="19"
                  @input="formatCardNumber"
                  @blur="validarNumeroTarjeta"
                  required
                />
                <p v-if="cardNumberError" class="text-red-500 text-xs mt-1">
                  {{ cardNumberError }}
                </p>
              </div>
            </div>

            <div class="flex items-center gap-4">
              <label class="w-32 text-sm font-semibold text-gray-700">
                Nombre
              </label>
              <input
                v-model="newMethod.name"
                type="text"
                placeholder="Nombre en la tarjeta"
                class="flex-1 rounded-lg border-0 px-4 py-2 text-gray-900 placeholder-gray-400 focus:border focus:border-[#4FCABC] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#4FCABC]/50"
                style="background-color: #f8fafc"
                required
              />
            </div>

            <div class="flex items-center gap-4">
              <label class="w-32 text-sm font-semibold text-gray-700">
                Vencimiento
              </label>
              <input
                v-model="newMethod.expiration"
                type="text"
                placeholder="MM/AA"
                class="flex-1 rounded-lg border-0 px-4 py-2 text-gray-900 placeholder-gray-400 focus:border focus:border-[#4FCABC] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#4FCABC]/50"
                style="background-color: #f8fafc"
                maxlength="5"
                @input="formatExpiration"
                required
              />
            </div>

            <div class="flex justify-end pt-4">
              <Button
                type="submit"
                customClass="bg-[#15b8a6] text-white hover:bg-[#16c4b0] px-4 py-2.5 rounded-xl font-semibold transition-colors cursor-pointer text-sm"
              >
                Agregar Método
              </Button>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import Button from "../../../components/ui/atoms/Button.vue";
import Icon from "../../../components/ui/atoms/Icon.vue";
import PaymentBrandIcon from "../components/PaymentBrandIcon.vue";

const paymentTypeOptions = [
  { value: "Tarjeta de Crédito", label: "Tarjeta de Crédito" },
  { value: "Tarjeta de Débito", label: "Tarjeta de Débito" },
  { value: "Cuenta Bancaria", label: "Cuenta Bancaria" },
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

const showAllMethods = ref(false);
const showAddMethodModal = ref(false);
const cardNumberError = ref("");

const newMethod = ref({
  type: "",
  number: "",
  name: "",
  expiration: "",
});

const openAddMethodModal = () => {
  showAddMethodModal.value = true;
  newMethod.value = {
    type: "",
    number: "",
    name: "",
    expiration: "",
  };
  cardNumberError.value = "";
};

const closeAddMethodModal = () => {
  showAddMethodModal.value = false;
};

const formatCardNumber = (event) => {
  let value = event.target.value.replace(/\s/g, "").replace(/[^0-9]/gi, "");
  let formattedValue = value.match(/.{1,4}/g)?.join(" ") || value;
  if (formattedValue.length <= 19) {
    newMethod.value.number = formattedValue;
    cardNumberError.value = "";
  }
};

const validarNumeroTarjeta = () => {
  const numeroTarjeta = newMethod.value.number.replace(/\s/g, "");
  
  if (!numeroTarjeta) {
    cardNumberError.value = "";
    return false;
  }
  
  if (numeroTarjeta.length < 13 || numeroTarjeta.length > 19) {
    cardNumberError.value = "El numero de tarjeta debe tener entre 13 y 19 digitos";
    return false;
  }
  
  let suma = 0;
  let esPar = false;
  for (let i = numeroTarjeta.length - 1; i >= 0; i--) {
    let digito = parseInt(numeroTarjeta[i]);
    if (esPar) {
      digito *= 2;
      if (digito > 9) {
        digito -= 9;
      }
    }
    suma += digito;
    esPar = !esPar;
  }
  
  if (suma % 10 !== 0) {
    cardNumberError.value = "Numero de tarjeta invalido";
    return false;
  }
  
  cardNumberError.value = "";
  return true;
};

const formatExpiration = (event) => {
  let value = event.target.value.replace(/\D/g, "");
  if (value.length >= 2) {
    value = value.substring(0, 2) + "/" + value.substring(2, 4);
  }
  newMethod.value.expiration = value;
};

const handleAddMethod = () => {
  if (!validarNumeroTarjeta()) {
    return;
  }
  
  console.log("Nuevo metodo de pago:", newMethod.value);
  closeAddMethodModal();
};

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
.modal-entrar-activo,
.modal-salir-activo {
  transition: opacity 0.3s ease;
}

.modal-entrar-desde,
.modal-salir-hacia {
  opacity: 0;
}

.select-pago {
  color: #1f2937;
}

.select-pago:invalid,
.select-pago option[value=""] {
  color: #9ca3af !important;
}

.select-pago option {
  background-color: white !important;
  color: #1f2937 !important;
  padding: 8px 12px;
  padding-right: 40px;
  text-align: left;
}

.select-pago option:hover {
  background-color: #1e3a8a !important;
  color: white !important;
}

.select-pago option:checked,
.select-pago option[selected] {
  background-color: white !important;
  color: #1f2937 !important;
  position: relative;
}

.select-pago option:checked::after,
.select-pago option[selected]::after {
  content: "✓";
  color: #1e3a8a;
  font-weight: 900;
  font-size: 18px;
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  line-height: 1;
}
</style>
