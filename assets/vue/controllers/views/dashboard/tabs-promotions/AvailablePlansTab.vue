<template>
  <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm md:p-8">
    <div class="mb-8">
      <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">
        Encuentra el plan perfecto
      </p>
      <h3 class="text-2xl font-bold text-gray-900 mt-1">Planes de Internet</h3>
      <p class="text-gray-600 mt-2">
        Compara nuestros planes destacados y mejora tu experiencia con descuentos exclusivos y beneficios reales.
      </p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
      <article
        v-for="plan in highlightedPlans"
        :key="plan.id"
        class="group flex h-full flex-col overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
        :class="plan.featured ? 'border-ksp-principal shadow-lg' : ''"
      >
        <div class="relative">
          <img :src="plan.image" :alt="plan.name" class="h-48 w-full object-cover" />
          <span
            v-if="plan.featured"
            class="absolute top-4 right-4 rounded-full bg-ksp-principal px-4 py-1 text-xs font-semibold uppercase tracking-wide text-white"
          >
            Más Popular
          </span>
          <div
            class="absolute bottom-4 left-4 flex items-center gap-3 rounded-2xl bg-white/90 px-4 py-2 shadow-md"
          >
            <div class="rounded-2xl bg-[#E5F8F1] p-2">
              <Icon name="wifi" size="20" class="text-ksp-principal" />
            </div>
            <div>
              <p class="text-xs uppercase tracking-wide text-gray-400">{{ plan.tagline }}</p>
              <p class="text-lg font-semibold text-gray-900">{{ plan.name }}</p>
            </div>
          </div>
        </div>

        <div class="flex flex-1 flex-col gap-6 p-6">
          <div>
            <p class="text-sm font-semibold text-gray-500">{{ plan.speed }}</p>
            <div class="mt-2 flex items-center gap-3">
              <span class="text-sm text-gray-400 line-through">S/ {{ plan.oldPrice }}</span>
              <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-500">
                -{{ plan.discount }}%
              </span>
            </div>
            <div class="mt-2 flex items-baseline gap-2">
              <span class="text-4xl font-bold text-gray-900">S/ {{ plan.price }}</span>
              <span class="text-sm text-gray-500">/mes</span>
            </div>
            <p class="mt-1 text-sm font-semibold text-ksp-principal">{{ plan.note }}</p>
          </div>

          <div class="flex-1">
            <ul class="space-y-2 text-sm text-gray-700">
              <li
                v-for="(feature, index) in plan.features"
                :key="index"
                class="flex items-start gap-2"
              >
                <Icon name="check" size="16" class="mt-0.5 text-ksp-principal" />
                <span>{{ feature }}</span>
              </li>
            </ul>
          </div>

          <div>
            <Button
              v-if="plan.current"
              customClass="group w-full bg-ksp-principal text-white hover:bg-ksp-principal/90 py-3 font-semibold rounded-xl cursor-pointer"
            >
              Cambiar a este plan
            </Button>
            <Button
              v-else
              customClass="group w-full bg-gray-900/5 text-gray-900 hover:bg-ksp-principal hover:text-white py-3 font-semibold rounded-xl cursor-pointer transition-colors"
            >
              <span class="block group-hover:hidden">Seleccionar Plan</span>
              <span class="hidden group-hover:block">Elegir plan</span>
            </Button>
          </div>
        </div>
      </article>
    </div>

    <div class="mt-10 grid grid-cols-1 gap-4 md:grid-cols-3">
      <div
        v-for="highlight in valueHighlights"
        :key="highlight.id"
        class="rounded-2xl border border-gray-100 bg-gray-50 p-5"
      >
        <div class="flex items-center gap-3 mb-3">
          <div class="rounded-2xl bg-white p-3 shadow-sm">
            <Icon :name="highlight.icon" size="20" class="text-ksp-principal" />
          </div>
          <div>
            <p class="text-xs uppercase tracking-wide text-gray-400">{{ highlight.tagline }}</p>
            <h4 class="text-lg font-semibold text-gray-900">{{ highlight.title }}</h4>
          </div>
        </div>
        <p class="text-sm text-gray-600">{{ highlight.description }}</p>
        <p class="mt-3 text-2xl font-bold text-gray-900">{{ highlight.stat }}</p>
      </div>
    </div>

    <div
      class="mt-6 flex flex-col gap-4 rounded-3xl border border-gray-100 bg-linear-to-r from-[#324D68] to-[#1F7A4D] p-6 text-white md:flex-row md:items-center md:justify-between"
    >
      <div>
        <p class="text-sm uppercase tracking-wide text-white/70">¿Aún tienes dudas?</p>
        <h4 class="text-2xl font-bold">Habla con un asesor especializado</h4>
        <p class="text-white/80 mt-1">
          Te ayudamos a elegir el plan ideal y configuramos tu servicio sin costo adicional.
        </p>
      </div>
      <Button
        customClass="flex items-center justify-center gap-2 rounded-2xl bg-white px-6 py-3 font-semibold text-ksp-principal hover:bg-white/90 cursor-pointer"
      >
        <Icon name="phone-call" size="18" class="text-ksp-principal" />
        Contactar ahora
      </Button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Button from '../../../components/ui/atoms/Button.vue';
import Icon from '../../../components/ui/atoms/Icon.vue';

const highlightedPlans = ref([
  {
    id: 'basic',
    name: 'Plan Básico',
    tagline: 'Uso esencial',
    speed: '25 Mbps de velocidad',
    oldPrice: 89,
    price: 59,
    discount: 30,
    note: 'Primer mes gratis',
    image:
      'https://images.unsplash.com/photo-1487017159836-4e23ece2e4cf?auto=format&fit=crop&w=900&q=80',
    featured: false,
    current: false,
    features: [
      '25 Mbps de velocidad',
      'Sin límite de datos',
      'Soporte 24/7',
      'Instalación gratuita'
    ]
  },
  {
    id: 'premium',
    name: 'Plan Premium',
    tagline: 'Entretenimiento total',
    speed: '100 Mbps de velocidad',
    oldPrice: 189,
    price: 119,
    discount: 35,
    note: '3 meses al 50% de descuento',
    image:
      'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=900&q=80',
    featured: true,
    current: true,
    features: [
      '100 Mbps de velocidad',
      'Sin límite de datos',
      'Soporte 24/7 prioritario',
      'Instalación gratuita',
      'Router WiFi 6 incluido',
      'IP estática opcional'
    ]
  },
  {
    id: 'business',
    name: 'Plan Empresarial',
    tagline: 'Operaciones críticas',
    speed: '500 Mbps simétricos',
    oldPrice: 399,
    price: 329,
    discount: 18,
    note: 'Sin costo de instalación – Ahorra S/150',
    image:
      'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=900&q=80&sat=-50',
    featured: false,
    current: false,
    features: [
      '500 Mbps simétricos',
      'Sin límite de datos',
      'Soporte técnico dedicado',
      'Instalación y configuración gratuita',
      'Router empresarial incluido',
      'IP estática incluida',
      'SLA 99.9% uptime',
      'Backup 4G'
    ]
  }
]);

const valueHighlights = [
  {
    id: 'experience',
    title: 'Trayectoria comprobada',
    tagline: '10+ años',
    description: 'Más de una década conectando hogares y empresas en todo el país.',
    stat: '4,500+ instalaciones',
    icon: 'shield-check'
  },
  {
    id: 'benefits',
    title: 'Beneficios exclusivos',
    tagline: 'Clientes felices',
    description: 'Planes con streaming, respaldo 4G y upgrades gratuitos por temporada.',
    stat: '92% nos recomienda',
    icon: 'gift'
  },
  {
    id: 'support',
    title: 'Soporte dedicado',
    tagline: 'Atención 24/7',
    description: 'Equipo especializado listo para ayudarte en menos de 10 minutos.',
    stat: '98% satisfacción',
    icon: 'phone-call'
  }
];
</script>
