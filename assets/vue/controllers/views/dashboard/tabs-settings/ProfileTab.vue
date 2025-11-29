<template>
  <Card class="p-6 shadow-sm bg-white">
    <div class="flex flex-col gap-4 border-b border-gray-100 pb-5">
      <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">
          {{ content.badge }}
        </p>
        <h3 class="text-2xl font-bold text-gray-800 mt-1">
          {{ content.title }}
        </h3>
        <p class="text-gray-600 mt-2">
          {{ content.description }}
        </p>
      </div>
    </div>

    <div class="grid gap-6 py-5 md:grid-cols-3">
      <form
        class="rounded-2xl border border-gray-100 bg-gray-50/60 p-5 md:col-span-2"
        @submit.prevent="handleProfileSave"
      >
        <div class="mb-5 flex flex-col gap-3 rounded-2xl border border-dashed border-gray-200 bg-white/70 p-4 md:flex-row md:items-center md:justify-between">
          <div>
            <p class="text-sm font-semibold text-gray-800">Datos del titular</p>
            <p class="text-xs text-gray-500">Aquí puedes actualizar la información principal del usuario.</p>
          </div>
          <Button
            :customClass="[
              'px-4 py-2 flex items-center gap-2 rounded-xl cursor-pointer',
              isEditingProfile
                ? 'bg-gray-200 text-gray-500 cursor-not-allowed'
                : 'bg-[#324D68] text-white hover:bg-[#24384c]'
            ]"
            :disabled="isEditingProfile"
            @click="enableProfileEditing"
          >
            <Icon name="edit" size="18" />
            {{ content.ctaLabel }}
          </Button>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
          <div class="md:col-span-2">
            <label class="text-sm font-semibold text-gray-700" for="fullName">Nombre completo</label>
            <input
              id="fullName"
              v-model="profileForm.fullName"
              :disabled="!isEditingProfile"
              type="text"
              :class="inputClasses"
            />
          </div>

          <div class="md:col-span-2">
            <label class="text-sm font-semibold text-gray-700" for="documentNumber">Documento de identidad</label>
            <div class="mt-1 flex flex-col gap-3 md:flex-row">
              <select
                v-model="profileForm.documentType"
                :disabled="!isEditingProfile"
                :class="selectClasses"
              >
                <option value="RUC">RUC</option>
                <option value="DNI">DNI</option>
                <option value="PASAPORTE">PASAPORTE</option>
              </select>
              <input
                id="documentNumber"
                v-model="profileForm.documentNumber"
                :disabled="!isEditingProfile"
                type="text"
                :class="['flex-1', inputClasses]"
              />
            </div>
          </div>

          <div>
            <label class="text-sm font-semibold text-gray-700" for="email">Correo electrónico</label>
            <input
              id="email"
              v-model="profileForm.email"
              :disabled="!isEditingProfile"
              type="email"
              :class="inputClasses"
            />
          </div>

          <div>
            <label class="text-sm font-semibold text-gray-700" for="phone">Teléfono</label>
            <input
              id="phone"
              v-model="profileForm.phone"
              :disabled="!isEditingProfile"
              type="tel"
              :class="inputClasses"
            />
          </div>

          <div>
            <label class="text-sm font-semibold text-gray-700" for="mobile">Celular</label>
            <input
              id="mobile"
              v-model="profileForm.mobile"
              :disabled="!isEditingProfile"
              type="tel"
              :class="inputClasses"
            />
          </div>

          <div>
            <label class="text-sm font-semibold text-gray-700" for="installationDate">Fecha de instalación</label>
            <input
              id="installationDate"
              v-model="profileForm.installationDate"
              disabled
              type="date"
              class="mt-1 w-full rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed px-3 py-2"
            />
          </div>

          <div class="md:col-span-2">
            <label class="text-sm font-semibold text-gray-700" for="address">Dirección</label>
            <textarea
              id="address"
              v-model="profileForm.address"
              :disabled="!isEditingProfile"
              rows="2"
              :class="inputClasses"
            ></textarea>
          </div>

          <div v-if="isEditingProfile" class="md:col-span-2 mt-2 flex justify-end gap-3">
            <button
              type="button"
              class="rounded-xl border cursor-pointer border-gray-300 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100"
              @click="handleProfileCancel"
            >
              Cancelar
            </button>
            <button
              type="submit"
              class="rounded-xl cursor-pointer bg-[#324D68] px-4 py-2 text-sm font-semibold text-white hover:bg-[#24384c]"
            >
              Guardar cambios
            </button>
          </div>
        </div>
      </form>

      <div class="md:col-span-1 flex flex-col gap-4">
        <div class="rounded-2xl border border-gray-100 p-5 text-center flex flex-col items-center gap-3">
          <div class="relative h-28 w-28 rounded-full border-4 border-gray-100 bg-[#324D68]/5 text-3xl font-semibold text-[#324D68] flex items-center justify-center">
            {{ profileInitials }}
          </div>
          <p class="text-base font-semibold text-gray-800">Foto de perfil</p>
          <p class="text-sm text-gray-500">Sube una imagen en formato JPG o PNG (máx. 2 MB).</p>
          <div class="flex flex-col gap-2 w-full">
            <button
              type="button"
              class="rounded-xl border border-dashed border-[#324D68] px-4 py-2 text-sm font-semibold text-[#324D68] hover:bg-[#324D68]/5"
            >
              Subir foto
            </button>
            <button
              type="button"
              class="rounded-xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50"
            >
              Quitar foto
            </button>
          </div>
        </div>

        <div class="rounded-2xl bg-ksp-principal p-5 text-white shadow-sm">
          <p class="text-xs uppercase tracking-wide opacity-80">Plan actual</p>
          <p class="mt-1 text-lg font-semibold">{{ profilePlan.name }}</p>
          <p class="text-sm opacity-90">{{ profilePlan.detail }}</p>
          <p class="text-xs mt-3 opacity-80">{{ profilePlan.since }}</p>
        </div>

        <div class="rounded-2xl border border-gray-100 p-5">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500">Estado del servicio</p>
              <p class="text-lg font-semibold text-gray-800">{{ serviceStatus.label }}</p>
            </div>
            <span :class="['rounded-full px-3 py-1 text-xs font-semibold', serviceStatusBadgeClass]">
              {{ serviceStatus.label }}
            </span>
          </div>
          <p class="text-sm text-gray-500 mt-2">{{ serviceStatus.helper }}</p>
        </div>

        <div class="rounded-2xl border border-gray-100 p-5">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500">Pago automático</p>
              <p class="text-base font-semibold text-gray-800">{{ autopayStatus.label }}</p>
            </div>
            <span :class="['rounded-full px-3 py-1 text-xs font-semibold', autopayStatusBadgeClass]">
              {{ autopayStatus.enabled ? 'Activo' : 'Deshabilitado' }}
            </span>
          </div>
          <p class="text-sm text-gray-500 mt-2">{{ autopayStatus.helper }}</p>
          <Button
            customClass="mt-4 w-full border border-[#324D68] text-[#324D68] hover:bg-[#324D68]/5 px-4 py-2 flex items-center justify-center gap-2 cursor-pointer"
            @click="navigateToAutopay"
          >
            Administrar pago automático
            <Icon name="chevron-right" size="16" />
          </Button>
        </div>
      </div>
    </div>
  </Card>
</template>

<script setup>
import { computed, ref } from "vue";
import { useRouter } from "vue-router";
import Card from "../../../components/ui/atoms/Card.vue";
import Button from "../../../components/ui/atoms/Button.vue";
import Icon from "../../../components/ui/atoms/Icon.vue";

const props = defineProps({
  content: {
    type: Object,
    required: true,
  },
});

const router = useRouter();

const initialProfileData = {
  fullName: "María Fernanda Quispe",
  documentType: "RUC",
  documentNumber: "20609988771",
  email: "mfernanda@empresa.com",
  phone: "(01) 705 8899",
  mobile: "+51 999 555 444",
  address: "Av. Primavera 123, Torre B, Oficina 702 - Lima",
  installationDate: "2023-04-12",
};

const profileForm = ref({ ...initialProfileData });
const profileSnapshot = ref({ ...initialProfileData });
const isEditingProfile = ref(false);

const profilePlan = ref({
  name: "Plan Premium 100 MB",
  detail: "Fibra óptica simétrica 100 Mbps",
  since: "Instalado el 12 Ene 2024",
});

const serviceStatus = ref({
  label: "Activo",
  helper: "Operativo sin incidencias reportadas",
  tone: "success",
});

const autopayStatus = ref({
  label: "Débito Visa •••• 7789",
  enabled: true,
  helper: "Cargo mensual el día 15",
});

const profileInitials = computed(() => {
  if (!profileForm.value.fullName) return "";
  return profileForm.value.fullName
    .split(" ")
    .filter(Boolean)
    .slice(0, 2)
    .map((word) => word[0]?.toUpperCase() ?? "")
    .join("");
});

const toneBadges = {
  success: "bg-ksp-green text-white",
  warning: "bg-amber-500 text-white",
  danger: "bg-ksp-red text-white",
  info: "bg-blue-600 text-white",
};

const serviceStatusBadgeClass = computed(() => {
  return toneBadges[serviceStatus.value.tone] || "bg-gray-100 text-gray-600";
});

const autopayStatusBadgeClass = computed(() => {
  return autopayStatus.value.enabled
    ? "bg-ksp-green text-white"
    : "bg-ksp-red text-white";
});

const baseInputClasses = "mt-1 w-full rounded-xl border px-3 py-2 focus:border-[#324D68] focus:ring-[#324D68]";
const inputClasses = computed(() => (
  isEditingProfile.value
    ? `${baseInputClasses} bg-white text-gray-800 border-gray-200`
    : `${baseInputClasses} bg-gray-100 text-gray-500 border-gray-200 cursor-not-allowed`
));

const selectClasses = computed(() => (
  isEditingProfile.value
    ? "rounded-xl border border-gray-200 bg-white px-3 py-2 text-gray-800 focus:border-[#324D68] focus:ring-[#324D68] md:w-40"
    : "rounded-xl border border-gray-200 bg-gray-100 text-gray-500 cursor-not-allowed px-3 py-2 md:w-40"
));

const enableProfileEditing = () => {
  isEditingProfile.value = true;
};

const handleProfileSave = () => {
  profileSnapshot.value = { ...profileForm.value };
  isEditingProfile.value = false;
};

const handleProfileCancel = () => {
  profileForm.value = { ...profileSnapshot.value };
  isEditingProfile.value = false;
};

const navigateToAutopay = () => {
  router.push({ path: "/dashboard/pagos", query: { tab: "autopay" } });
};
</script>
