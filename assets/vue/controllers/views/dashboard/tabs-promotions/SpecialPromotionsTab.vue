<template>
  <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm md:p-8">
    <div class="mb-6">
      <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">
        Ofertas por tiempo limitado
      </p>
      <h3 class="text-2xl font-bold text-gray-800 mt-1">
        Promociones Especiales
      </h3>
      <p class="text-gray-600 mt-2">
        Aprovecha nuestras promociones exclusivas y obtén increíbles descuentos en tus servicios favoritos.
      </p>
    </div>

    <!-- Promoción destacada principal -->
    <div class="mb-8 rounded-2xl bg-linear-to-r from-[#1F7A4D] to-[#32C1B1] p-8 text-white shadow-lg">
      <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex-1">
          <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-1 mb-4">
            <Icon name="zap" size="16" class="mr-2" />
            <span class="text-sm font-semibold">Oferta Flash</span>
          </div>
          <h3 class="text-3xl font-bold mb-2">¡Duplica tu velocidad!</h3>
          <p class="text-white/90 mb-4">
            Por tiempo limitado, duplicamos la velocidad de tu plan actual sin costo adicional durante los primeros 3 meses.
          </p>
          <div class="flex items-center gap-4 mb-4">
            <div class="flex items-center gap-2">
              <Icon name="clock" size="20" />
              <span class="font-semibold">Válido hasta: 31 Dic 2025</span>
            </div>
          </div>
          <Button
            customClass="bg-white text-[#1F7A4D] hover:bg-gray-100 px-6 py-3 font-semibold rounded-xl cursor-pointer shadow-md"
          >
            Activar Promoción
          </Button>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
          <div class="text-center">
            <p class="text-sm opacity-90 mb-2">Ahorra hasta</p>
            <p class="text-5xl font-bold">50%</p>
            <p class="text-sm opacity-90 mt-2">En los primeros meses</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Lista de promociones -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div
        v-for="promo in promotions"
        :key="promo.id"
        class="rounded-2xl border border-gray-200 bg-white p-6 hover:shadow-lg transition-all duration-300 hover:border-[#32C1B1]"
      >
        <div class="flex items-start justify-between mb-4">
          <div class="flex items-center gap-3">
            <div :class="`bg-${promo.color}-50 p-3 rounded-xl`">
              <Icon :name="promo.icon" size="24" :class="`text-${promo.color}-600`" />
            </div>
            <div>
              <h4 class="font-bold text-gray-900">{{ promo.title }}</h4>
              <p class="text-xs text-gray-500">{{ promo.validUntil }}</p>
            </div>
          </div>
          <span
            v-if="promo.discount"
            class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold"
          >
            -{{ promo.discount }}%
          </span>
        </div>

        <p class="text-gray-600 text-sm mb-4">{{ promo.description }}</p>

        <div class="space-y-2 mb-4">
          <div
            v-for="(condition, index) in promo.conditions"
            :key="index"
            class="flex items-start gap-2 text-sm"
          >
            <Icon name="check-circle" size="16" class="text-green-600 mt-0.5" />
            <span class="text-gray-700">{{ condition }}</span>
          </div>
        </div>

        <div class="flex gap-2">
          <Button
            customClass="flex-1 bg-[#32C1B1] text-white hover:bg-[#28a89a] py-2 font-semibold rounded-lg cursor-pointer text-sm"
          >
            Aplicar Ahora
          </Button>
          <Button
            customClass="bg-gray-100 text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-lg cursor-pointer"
          >
            <Icon name="info" size="16" />
          </Button>
        </div>
      </div>
    </div>

    <!-- Banner de referidos -->
    <div class="mt-8 rounded-2xl bg-linear-to-r from-purple-500 to-pink-500 p-8 text-white">
      <div class="flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex-1">
          <div class="flex items-center gap-2 mb-3">
            <Icon name="users" size="28" />
            <h3 class="text-2xl font-bold">Programa de Referidos</h3>
          </div>
          <p class="text-white/90 mb-4">
            Recomienda nuestro servicio y gana S/ 30 por cada amigo que se suscriba. ¡Sin límite de referidos!
          </p>
          <div class="flex flex-wrap gap-4">
            <Button
              customClass="bg-white text-purple-600 hover:bg-gray-100 px-6 py-3 font-semibold rounded-xl cursor-pointer"
            >
              Invitar Amigos
            </Button>
            <Button
              customClass="bg-white/20 backdrop-blur-sm text-white hover:bg-white/30 px-6 py-3 font-semibold rounded-xl cursor-pointer border border-white/30"
            >
              Ver Mis Referidos
            </Button>
          </div>
        </div>
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 text-center">
          <p class="text-sm opacity-90 mb-2">Has ganado</p>
          <p class="text-4xl font-bold">S/ 0</p>
          <p class="text-xs opacity-90 mt-2">0 referidos activos</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Button from '../../../components/ui/atoms/Button.vue';
import Icon from '../../../components/ui/atoms/Icon.vue';

const promotions = ref([
  {
    id: 1,
    title: 'Instalación Gratis',
    description: 'No pagues por la instalación de tu servicio. Válido para nuevos clientes.',
    icon: 'home',
    color: 'blue',
    discount: null,
    validUntil: 'Válido todo diciembre',
    conditions: [
      'Solo para nuevos clientes',
      'Aplica a planes desde 60 Mbps',
      'Sujeto a evaluación técnica'
    ]
  },
  {
    id: 2,
    title: 'Primer Mes 50% OFF',
    description: 'Paga solo la mitad durante tu primer mes de servicio.',
    icon: 'percent',
    color: 'red',
    discount: 50,
    validUntil: 'Válido hasta 31/12/2025',
    conditions: [
      'Nuevos clientes únicamente',
      'Todos los planes',
      'Descuento automático'
    ]
  },
  {
    id: 3,
    title: 'Upgrade Gratis',
    description: 'Mejora a un plan superior y disfruta del primer mes sin cargo adicional.',
    icon: 'trending-up',
    color: 'green',
    discount: null,
    validUntil: 'Oferta permanente',
    conditions: [
      'Para clientes actuales',
      'Mínimo 6 meses de servicio',
      'Una vez por año'
    ]
  },
  {
    id: 4,
    title: 'Netflix Premium Gratis',
    description: 'Suscríbete al plan Premium y obtén 3 meses de Netflix Premium sin costo.',
    icon: 'tv',
    color: 'purple',
    discount: null,
    validUntil: 'Válido hasta 15/01/2026',
    conditions: [
      'Solo plan Premium o superior',
      'Permanencia mínima 12 meses',
      'Términos y condiciones aplican'
    ]
  }
]);
</script>
