<template>
  <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm md:p-8">
    <div class="mb-6">
      <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">
        Ventajas exclusivas
      </p>
      <h3 class="text-2xl font-bold text-gray-800 mt-1">
        Beneficios Adicionales
      </h3>
      <p class="text-gray-600 mt-2">
        Disfruta de beneficios complementarios incluidos en tu plan para mejorar tu experiencia.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="benefit in benefits"
        :key="benefit.id"
        class="rounded-2xl border border-gray-200 bg-white p-6 hover:shadow-lg transition-all duration-300"
      >
        <div class="flex items-center gap-4 mb-4">
          <div :class="`bg-${benefit.color}-50 p-3 rounded-xl`">
            <Icon :name="benefit.icon" size="24" :class="`text-${benefit.color}-600`" />
          </div>
          <div>
            <h4 class="font-semibold text-gray-900">{{ benefit.title }}</h4>
            <p class="text-xs text-gray-500">{{ benefit.tagline }}</p>
          </div>
        </div>
        <p class="text-gray-600 text-sm mb-4">{{ benefit.description }}</p>
        <ul class="space-y-2 text-sm text-gray-700">
          <li
            v-for="(item, index) in benefit.items"
            :key="index"
            class="flex items-start gap-2"
          >
            <Icon name="check" size="14" class="text-green-500 mt-0.5" />
            <span>{{ item }}</span>
          </li>
        </ul>
        <div class="mt-6 pt-4 border-t border-gray-100">
          <p class="text-xs uppercase tracking-wide text-gray-400 mb-2">
            Disponible en
          </p>
          <div class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
            <Icon name="layers" size="12" />
            {{ benefit.availability }}
          </div>
        </div>
      </div>
    </div>

    <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">
      <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
        <div class="flex items-center gap-3 mb-4">
          <Icon name="phone-call" size="24" class="text-blue-600" />
          <h4 class="text-lg font-semibold text-gray-900">Soporte Premium</h4>
        </div>
        <p class="text-gray-600 text-sm mb-4">
          Acceso prioritario a nuestro equipo de soporte con atención especializada en menos de 10 minutos.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
          <div class="rounded-xl bg-white p-4">
            <p class="text-xs uppercase tracking-wide text-gray-400">Tiempo respuesta</p>
            <p class="text-2xl font-bold text-gray-900">5 min</p>
            <p class="text-gray-500 text-xs mt-1">Promedio mensual</p>
          </div>
          <div class="rounded-xl bg-white p-4">
            <p class="text-xs uppercase tracking-wide text-gray-400">Satisfacción</p>
            <p class="text-2xl font-bold text-gray-900">98%</p>
            <p class="text-gray-500 text-xs mt-1">Clientes felices</p>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-gray-200 bg-white p-6">
        <div class="flex items-center gap-3 mb-4">
          <Icon name="gift" size="24" class="text-purple-600" />
          <h4 class="text-lg font-semibold text-gray-900">Beneficios extra</h4>
        </div>
        <div class="space-y-3 text-sm text-gray-700">
          <div class="flex items-center justify-between">
            <span>Streaming incluido</span>
            <span class="font-semibold text-gray-900">Plataformas seleccionadas</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Backup en la nube</span>
            <span class="font-semibold text-gray-900">100 GB</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Aplicación exclusiva</span>
            <span class="font-semibold text-gray-900">Control total</span>
          </div>
          <div class="flex items-center justify-between">
            <span>Acceso a eventos</span>
            <span class="font-semibold text-gray-900">VIP Pass</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import Icon from '../../../components/ui/atoms/Icon.vue';

const benefits = ref([
  {
    id: 1,
    title: 'Soporte Técnico Prioritario',
    tagline: 'Atención en 5 minutos',
    description: 'Recibe atención inmediata de nuestro equipo especializado para resolver cualquier incidencia.',
    icon: 'headphones',
    color: 'blue',
    availability: 'Planes Hogar, Premium y Empresarial',
    items: [
      'Canales exclusivos 24/7',
      'Seguimiento personalizado',
      'Prioridad en visitas técnicas',
    ]
  },
  {
    id: 2,
    title: 'Wifi Seguro Plus',
    tagline: 'Protege tu red',
    description: 'Monitoreo inteligente que detecta intrusos y te alerta en tiempo real.',
    icon: 'shield',
    color: 'green',
    availability: 'Todos los planes',
    items: [
      'Bloqueo automático de amenazas',
      'Reporte mensual de actividad',
      'Control parental avanzado',
    ]
  },
  {
    id: 3,
    title: 'Experiencia Streaming',
    tagline: 'Conexión optimizada',
    description: 'Optimización automática para plataformas de streaming y gaming.',
    icon: 'tv',
    color: 'purple',
    availability: 'Planes Premium y Empresarial',
    items: [
      'Prioridad de ancho de banda',
      'Modo gaming bajo latencia',
      '3 perfiles premium incluidos',
    ]
  },
  {
    id: 4,
    title: 'Seguridad Digital',
    tagline: 'Protección total',
    description: 'Protege tus dispositivos con antivirus y firewall gestionado.',
    icon: 'lock',
    color: 'red',
    availability: 'Planes Premium y Empresarial',
    items: [
      'Antivirus multi-dispositivo',
      'Firewall de última generación',
      'Reportes de seguridad',
    ]
  },
  {
    id: 5,
    title: 'Asesor Tech',
    tagline: 'Consultoría personalizada',
    description: 'Recibe recomendaciones y configuraciones especiales para tu hogar o negocio.',
    icon: 'user-check',
    color: 'yellow',
    availability: 'Plan Empresarial',
    items: [
      'Visitas técnicas programadas',
      'Configuración de equipos',
      'Capacitaciones breves',
    ]
  },
  {
    id: 6,
    title: 'Garantía de velocidad',
    tagline: 'Compromiso real',
    description: 'Mantenemos tu velocidad contratada y te compensamos si baja del 90% del valor.',
    icon: 'activity',
    color: 'teal',
    availability: 'Todos los planes',
    items: [
      'Medición remota constante',
      'Descuento automático',
      'Póliza de servicio',
    ]
  },
]);
</script>
