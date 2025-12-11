<template>
  <div class="-m-4 md:-m-6 bg-[#F4F6F9] p-4 md:p-6 space-y-8 min-h-screen">
    <!-- Encabezado principal -->
    <section class="rounded-3xl bg-white p-6 md:p-8 shadow-sm space-y-8">
      <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center gap-4">
          <div class="rounded-full bg-[#E3EBFA] p-4 text-[#1F4FA0]">
            <Icon name="building-2" size="32" />
          </div>
          <div>
            <p class="text-2xl font-bold text-[#1F4FA0]">KS PERU</p>
            <p class="text-sm uppercase tracking-wide text-[#1F4FA0]/80">
              Excelencia y Calidad
            </p>
          </div>
        </div>
        <div class="text-right text-sm text-gray-600 space-y-1">
          <p class="text-base font-semibold text-gray-800">KS PERU S.A.C.</p>
          <p>RUC: 20123456789</p>
          <p>Dirección: Av. Principal 123 - Lima, Perú</p>
        </div>
      </div>
      <div class="text-center space-y-2">
        <h1 class="text-3xl md:text-4xl font-bold text-[#1F4FA0]">
          LIBRO DE RECLAMACIONES VIRTUAL
        </h1>
        <p class="text-sm text-gray-600 max-w-4xl mx-auto">
          Conforme a lo establecido en el Código de Protección y Defensa del Consumidor
        </p>
        <p class="text-xs text-gray-500 max-w-4xl mx-auto">
          LEY N. 29571 · D.S. N. 011-2011-PCM · D.S N. 042-2011-PCM
        </p>
      </div>
    </section>

    <!-- Datos generales -->
    <section class="grid gap-4 md:grid-cols-3">
      <div class="rounded-2xl bg-white p-5 shadow-sm">
        <p class="text-sm font-semibold text-gray-500">N° Reclamo</p>
        <p class="text-2xl font-bold text-gray-900 mt-2">
          {{ claimCode ? claimCode : '—' }}
        </p>
        <p class="text-xs text-gray-400 mt-1">(Se generará al enviar)</p>
      </div>
      <div class="rounded-2xl bg-white p-5 shadow-sm">
        <p class="text-sm font-semibold text-gray-500">Fecha</p>
        <p class="text-2xl font-bold text-gray-900 mt-2">{{ currentDate }}</p>
        <p class="text-xs text-gray-400 mt-1">Generado automáticamente</p>
      </div>
      <div class="rounded-2xl bg-white p-5 shadow-sm">
        <label class="text-sm font-semibold text-gray-500">Sede</label>
        <select
          v-model="selectedSede"
          class="mt-2 w-full cursor-pointer rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
        >
          <option v-for="sede in sedeOptions" :key="sede" :value="sede">
            {{ sede }}
          </option>
        </select>
      </div>
    </section>

    <!-- Sección 1 -->
    <section class="rounded-3xl bg-white shadow-sm overflow-hidden">
      <div class="flex items-center gap-3 bg-[#1F4FA0] px-6 py-4 text-white">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-lg font-bold">
          1
        </div>
        <p class="font-semibold tracking-wide">
          IDENTIFICACIÓN DEL CONSUMIDOR RECLAMANTE
        </p>
      </div>
      <div class="p-6 space-y-6">
        <div class="grid gap-4 md:grid-cols-2">
          <div>
            <label class="text-sm font-semibold text-gray-700">
              Nombres y Apellidos*
            </label>
            <input
              v-model="consumer.fullName"
              type="text"
              required
              placeholder="Ingrese su nombre completo"
              class="w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
            />
          </div>
          <div>
            <label class="text-sm font-semibold text-gray-700">Domicilio</label>
            <input
              v-model="consumer.address"
              type="text"
              placeholder="Dirección completa"
              class="w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
            />
          </div>
        </div>
        <div class="space-y-4">
          <div>
            <label class="text-sm font-semibold text-gray-700">Documento de Identidad*</label>
            <div class="mt-2 flex flex-wrap items-center gap-6">
              <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
                <input
                  type="radio"
                  class="text-[#1F4FA0] focus:ring-[#1F4FA0] "
                  value="dni"
                  v-model="consumer.docType"
                />
                DNI
              </label>
              <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
                <input
                  type="radio"
                  class="text-[#1F4FA0] focus:ring-[#1F4FA0]"
                  value="ce"
                  v-model="consumer.docType"
                />
                CE
              </label>
              <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
                <input
                  type="radio"
                  class="text-[#1F4FA0] focus:ring-[#1F4FA0]"
                  value="ruc"
                  v-model="consumer.docType"
                />
                RUC
              </label>
            </div>
          </div>
          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="text-sm font-semibold text-gray-700">Número de documento</label>
              <input
                v-model="consumer.docNumber"
                type="text"
                placeholder="00000000"
                class="w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
              />
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Teléfono / Celular</label>
              <input
                v-model="consumer.phone"
                type="text"
                placeholder="999 999 999"
                class="w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
              />
            </div>
          </div>
          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="text-sm font-semibold text-gray-700">Correo Electrónico*</label>
              <input
                v-model="consumer.email"
                type="email"
                required
                placeholder="ejemplo@correo.com"
                class="w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
              />
            </div>
            <div>
              <label class="text-sm font-semibold text-gray-700">Correo adicional (opcional)</label>
              <input
                v-model="consumer.secondaryEmail"
                type="email"
                placeholder="otro@correo.com"
                class="w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
              />
            </div>
          </div>
        </div>
        <div>
          <label class="text-sm font-semibold text-gray-700">¿Es menor de edad?</label>
          <div class="mt-2 flex gap-6">
            <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
              <input
                type="radio"
                class="text-[#1F4FA0] focus:ring-[#1F4FA0]"
                value="si"
                v-model="consumer.isMinor"
              />
              Sí
            </label>
            <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
              <input
                type="radio"
                class="text-[#1F4FA0] focus:ring-[#1F4FA0]"
                value="no"
                v-model="consumer.isMinor"
              />
              No
            </label>
          </div>
        </div>
      </div>
    </section>

    <!-- Sección 2 -->
    <section class="rounded-3xl bg-white shadow-sm overflow-hidden">
      <div class="flex items-center gap-3 bg-[#1F4FA0] px-6 py-4 text-white">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-lg font-bold">
          2
        </div>
        <p class="font-semibold tracking-wide">
          IDENTIFICACIÓN DEL BIEN CONTRATADO
        </p>
      </div>
      <div class="p-6 space-y-6">
        <div>
          <label class="text-sm font-semibold text-gray-700">Tipo de Bien</label>
          <div class="mt-2 flex flex-wrap gap-6">
            <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
              <input
                type="radio"
                class="text-[#1F4FA0] focus:ring-[#1F4FA0]"
                value="producto"
                v-model="contracted.type"
              />
              Producto
            </label>
            <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
              <input
                type="radio"
                class="text-[#1F4FA0] focus:ring-[#1F4FA0]"
                value="servicio"
                v-model="contracted.type"
              />
              Servicio
            </label>
          </div>
        </div>
        <div v-if="contracted.type === 'producto'" class="grid gap-4 md:grid-cols-3">
          <div class="md:col-span-2">
            <label class="text-sm font-semibold text-gray-700">Nombre del producto</label>
            <input
              v-model="productDetails.name"
              type="text"
              placeholder="Router WiFi 6, plan prepago, etc."
              class="w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
            />
          </div>
          <div>
            <label class="text-sm font-semibold text-gray-700">Método de pago</label>
            <select
              v-model="productDetails.paymentMethod"
              class="w-full cursor-pointer rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
            >
              <option v-for="option in paymentMethods" :key="option" :value="option">
                {{ option }}
              </option>
            </select>
          </div>
        </div>
        <div v-if="contracted.type === 'servicio'" class="space-y-4">
          <div>
            <label class="text-sm font-semibold text-gray-700">Servicio contratado</label>
            <select
              v-model="serviceSelection.selected"
              class="mt-2 w-full cursor-pointer rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
            >
              <option v-for="service in serviceOptions" :key="service.id" :value="service.id">
                {{ service.label }}
              </option>
            </select>
          </div>
          <div v-if="serviceSelection.selected === 'otro'">
            <label class="text-sm font-semibold text-gray-700">Describe el servicio</label>
            <input
              v-model="serviceSelection.custom"
              type="text"
              placeholder="Servicio contratado"
              class="w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
            />
          </div>
        </div>
        <div v-if="contracted.type === 'producto'">
          <label class="text-sm font-semibold text-gray-700">Monto Reclamado (S/)</label>
          <input
            v-model="contracted.amount"
            type="number"
            min="0"
            step="0.01"
            class="mt-2 w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
          />
        </div>
        <div>
          <label class="text-sm font-semibold text-gray-700">{{ descriptionLabel }}</label>
          <textarea
            v-model="contracted.description"
            rows="3"
            :placeholder="descriptionPlaceholder"
            class="w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
          ></textarea>
        </div>
      </div>
    </section>

    <!-- Sección 3 -->
    <section class="rounded-3xl bg-white shadow-sm overflow-hidden">
      <div class="flex items-center gap-3 bg-[#1F4FA0] px-6 py-4 text-white">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-lg font-bold">
          3
        </div>
        <p class="font-semibold tracking-wide">
          DETALLE DE LA RECLAMACIÓN Y PEDIDO DEL CONSUMIDOR
        </p>
      </div>
      <div class="p-6 space-y-6">
        <div class="rounded-2xl border border-[#F5D7A3] bg-[#FFF5E5] p-5 space-y-4">
          <p class="text-sm font-semibold text-[#9A6A20]">
            Parte A – Selecciona el tipo de reclamo
          </p>
          <div class="space-y-3">
            <label class="flex cursor-pointer gap-3 text-sm text-gray-800">
              <input
                type="radio"
                class="mt-1 text-[#1F4FA0] focus:ring-[#1F4FA0]"
                value="reclamo"
                v-model="complaint.claimType"
              />
              <span>
                <strong>Reclamo:</strong> Disconformidad relacionada a los productos o servicios.
              </span>
            </label>
            <label class="flex cursor-pointer gap-3 text-sm text-gray-800">
              <input
                type="radio"
                class="mt-1 text-[#1F4FA0] focus:ring-[#1F4FA0]"
                value="queja"
                v-model="complaint.claimType"
              />
              <span>
                <strong>Queja:</strong> Disconformidad NO relacionada a productos o servicios.
              </span>
            </label>
          </div>
        </div>
        <div>
          <label class="text-sm font-semibold text-gray-700">Parte B – Detalle del Reclamo o Queja*</label>
          <textarea
            v-model="complaint.detail"
            rows="4"
            placeholder="Explique detalladamente los hechos…"
            class="mt-2 w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
          ></textarea>
        </div>
        <div>
          <label class="text-sm font-semibold text-gray-700">Parte C – Pedido del Consumidor*</label>
          <textarea
            v-model="complaint.request"
            rows="3"
            placeholder="¿Qué solución espera obtener?"
            class="mt-2 w-full rounded-2xl border border-[#D9D9D9] bg-[#F9FAFB] px-4 py-3 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#1F4FA0]/30"
          ></textarea>
        </div>
        <div>
          <label class="text-sm font-semibold text-gray-700">Adjuntar evidencias (opcional)</label>
          <div
            class="mt-2 flex flex-col items-center justify-center gap-3 rounded-2xl border-2 border-dashed border-[#CAD2E7] bg-[#F9FAFB] px-4 py-6 text-gray-500"
          >
            <Icon name="upload" size="24" class="text-[#1F4FA0]" />
            <p class="text-sm text-center">
              Sube fotos del comprobante, capturas o cualquier evidencia relacionada.
            </p>
            <input
              type="file"
              multiple
              accept="image/*"
              class="text-sm"
              @change="handleAttachmentChange"
            />
          </div>
          <ul v-if="attachments.length" class="mt-3 space-y-2 text-sm text-gray-600">
            <li v-for="file in attachments" :key="file.name" class="flex items-center gap-2">
              <Icon name="check" size="14" class="text-emerald-500" />
              {{ file.name }}
            </li>
          </ul>
        </div>
      </div>
    </section>

    <!-- Sección final -->
    <section class="rounded-3xl bg-white shadow-sm p-6 md:p-8 space-y-6">
      <div class="rounded-[28px] border border-dashed border-[#CAD2E7] bg-linear-to-r from-[#f8fbff] via-[#eff4ff] to-[#e5ecff] px-6 py-8 shadow-sm">
        <div class="flex flex-col gap-8 xl:flex-row xl:items-center">
          <div class="flex-1 space-y-4">
            <p class="text-sm font-semibold uppercase tracking-wide text-[#1F355E]/80">Código de Seguridad</p>
            <div class="flex flex-wrap items-center gap-4">
              <div class="flex-1 min-w-[220px] rounded-2xl bg-white px-6 py-8 text-center shadow-lg">
                <p class="text-3xl font-bold tracking-[0.4em] text-[#1F355E]">
                  {{ captchaDisplay }}
                </p>
                <p class="mt-2 text-xs uppercase tracking-wide text-gray-500">
                  Ingrese los caracteres mostrados
                </p>
              </div>
              <button
                type="button"
                class="h-12 w-12 rounded-full bg-[#1F4FA0] text-white shadow-lg transition hover:scale-105 cursor-pointer flex items-center justify-center"
                @click="refreshCaptcha"
                aria-label="Actualizar código"
              >
                <Icon name="refresh" size="20" />
              </button>
            </div>
          </div>
          <div class="flex-1 min-w-[260px]">
            <label class="text-xs font-semibold uppercase tracking-wide text-[#1F355E]/80">Ingrese el código mostrado</label>
            <div class="mt-3 flex items-center gap-3 rounded-2xl border border-white/70 bg-white/90 px-5 py-4 shadow-lg backdrop-blur">
              <Icon name="shield-check" size="20" class="text-[#1F4FA0]" />
              <input
                v-model="captchaInput"
                type="text"
                placeholder="Escribe los caracteres tal como aparecen"
                class="flex-1 bg-transparent text-lg font-semibold tracking-[0.3em] text-[#1F355E] placeholder:tracking-normal placeholder:text-gray-400 focus:outline-none"
              />
            </div>
            <p class="mt-2 text-xs text-[#1F355E]/70">
              Este paso ayuda a proteger tu solicitud contra envíos automatizados.
            </p>
          </div>
        </div>
      </div>
      <div class="text-center">
        <Button
          customClass="mx-auto flex items-center gap-3 rounded-full bg-[#1F355E] px-8 py-4 text-white text-lg font-semibold shadow-lg transition hover:scale-105 cursor-pointer"
          @click="submitClaim"
        >
          <Icon name="send" size="20" />
          ENVIAR RECLAMO
        </Button>
      </div>
      <div class="space-y-3 text-xs text-gray-500">
        <p>
          En caso de que el consumidor no consigne como mínimo sus nombres y apellidos, DNI/CE, domicilio o correo electrónico, fecha del reclamo o queja y el detalle de los mismos, estos se considerarán como no presentados. (art 5. D.S. 006-2014-PCM).
        </p>
        <p>
          La formulación del reclamo no implica acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.
        </p>
        <p>
          El proveedor debe dar respuesta al reclamo o queja en un plazo no mayor a quince (15) días hábiles, el cual es improrrogable.
        </p>
        <p class="flex items-center gap-2 text-gray-500">
          <Icon name="mail" size="16" class="text-[#1F4FA0]" />
          Si tiene alguna duda puede contactarnos al correo: <span class="font-semibold text-gray-700">reclamos@ksperu.com</span>
        </p>
      </div>
    </section>
  </div>
</template>

<script setup>
import { computed, reactive, ref, watch } from 'vue';
import Button from '../../components/ui/atoms/Button.vue';
import Icon from '../../components/ui/atoms/Icon.vue';

const sedeOptions = [
  'KS Peru - Sede Principal',
  'KS Peru - Sede Norte',
  'KS Peru - Cusco',
];

const selectedSede = ref(sedeOptions[0]);

const consumer = reactive({
  fullName: '',
  address: '',
  docType: 'dni',
  docNumber: '',
  phone: '',
  email: '',
   secondaryEmail: '',
  isMinor: 'no',
});

const contracted = reactive({
  type: 'servicio',
  amount: '0.00',
  description: '',
});

const paymentMethods = [
  'Efectivo',
  'Tarjeta',
  'Billetera virtual (Yape, Plin)',
];

const productDetails = reactive({
  name: '',
  paymentMethod: paymentMethods[0],
});

const serviceOptions = [
  { id: 'internet-fibra', label: 'Internet Fibra Hogar' },
  { id: 'internet-empresarial', label: 'Internet Corporativo' },
  { id: 'telefonia', label: 'Telefonía fija' },
  { id: 'tv-digital', label: 'TV digital' },
  { id: 'soporte-dedicado', label: 'Soporte técnico dedicado' },
  { id: 'otro', label: 'Otro servicio' },
];

const serviceSelection = reactive({
  selected: serviceOptions[0].id,
  custom: '',
});

const complaint = reactive({
  claimType: 'reclamo',
  detail: '',
  request: '',
});

const attachments = ref([]);

const claimCode = ref(null);

const currentDate = computed(() =>
  new Intl.DateTimeFormat('es-PE', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  }).format(new Date())
);

const generateCaptcha = () => {
  const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
  return Array.from({ length: 4 }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
};

const captchaCode = ref(generateCaptcha());
const captchaInput = ref('');

const captchaDisplay = computed(() => captchaCode.value.split('').join(' '));

const descriptionLabel = computed(() =>
  contracted.type === 'producto' ? 'Descripción del producto' : 'Descripción del servicio contratado'
);

const descriptionPlaceholder = computed(() =>
  contracted.type === 'producto'
    ? 'Describe el producto, estado, serie y cualquier detalle relevante…'
    : 'Describe el servicio contratado, fechas, horarios u observaciones…'
);

const refreshCaptcha = () => {
  captchaCode.value = generateCaptcha();
  captchaInput.value = '';
};

const handleAttachmentChange = (event) => {
  const files = Array.from(event.target.files || []);
  attachments.value = files;
};

watch(
  () => serviceSelection.selected,
  (value) => {
    if (value !== 'otro') {
      serviceSelection.custom = '';
    }
  }
);

const submitClaim = () => {
  if (!claimCode.value) {
    const unique = `KR-${Date.now().toString().slice(-6)}`;
    claimCode.value = unique;
  }
  // Aquí se podría integrar el envío real al backend
};
</script>
