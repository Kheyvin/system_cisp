<template>
  <div class="space-y-8">
    <header class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm md:p-8 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
      <div class="space-y-3">
        <p class="text-xs uppercase tracking-wide text-gray-400">Ecosistema de alertas</p>
        <h1 class="text-3xl font-bold text-gray-900">Centro de notificaciones</h1>
        <p class="text-gray-600 max-w-2xl">
          Consolidamos los avisos operativos, comerciales y de soporte para que tengas trazabilidad de todo
          lo que sucede con tu servicio. Así justificamos su presencia: evitas sorpresas, mantienes registro
          y puedes actuar a tiempo.
        </p>
      </div>
      <div class="w-full rounded-2xl bg-linear-to-r from-[#1F4FA0] to-[#32C1B1] text-white p-6 md:max-w-sm">
        <p class="text-sm uppercase tracking-wide text-white/70">¿Por qué existe?</p>
        <p class="mt-2 text-lg font-semibold">Transparencia y toma de acción.</p>
        <p class="mt-2 text-sm text-white/90">
          Centralizar avisos permite justificar decisiones, respaldar reclamos y coordinar con soporte sin depender del correo.
        </p>
      </div>
    </header>

    <section class="grid gap-4 md:grid-cols-3">
      <Card class="p-6 bg-white">
        <div class="flex items-center gap-3">
          <Icon name="bell" size="24" class="text-[#1F4FA0]" />
          <p class="text-sm font-semibold text-gray-500">Alertas activas</p>
        </div>
        <p class="mt-4 text-3xl font-bold text-gray-900">{{ activeAlerts }}</p>
        <p class="text-sm text-gray-500">En las últimas 24 horas</p>
      </Card>
      <Card class="p-6 bg-white">
        <div class="flex items-center gap-3">
          <Icon name="file-text" size="24" class="text-[#1F4FA0]" />
          <p class="text-sm font-semibold text-gray-500">Relevancia comercial</p>
        </div>
        <p class="mt-4 text-3xl font-bold text-gray-900">{{ commercialNotices }}%</p>
        <p class="text-sm text-gray-500">Avisos con impacto en facturación</p>
      </Card>
      <Card class="p-6 bg-white">
        <div class="flex items-center gap-3">
          <Icon name="clock" size="24" class="text-[#1F4FA0]" />
          <p class="text-sm font-semibold text-gray-500">Tiempo de reacción</p>
        </div>
        <p class="mt-4 text-3xl font-bold text-gray-900">{{ responseTime }} min</p>
        <p class="text-sm text-gray-500">Promedio de atención</p>
      </Card>
    </section>

    <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm space-y-6">
      <div class="flex flex-wrap items-center gap-4 justify-between">
        <div>
          <h2 class="text-xl font-semibold text-gray-900">Bandeja de notificaciones</h2>
          <p class="text-sm text-gray-500">Filtra por tipo para enfocarte en lo realmente importante.</p>
        </div>
        <div class="flex flex-wrap gap-2">
          <button
            v-for="filter in filters"
            :key="filter.value"
            @click="activeFilter = filter.value"
            class="rounded-full border px-4 py-2 text-sm font-semibold cursor-pointer transition"
            :class="activeFilter === filter.value
              ? 'border-[#1F4FA0] bg-[#1F4FA0]/10 text-[#1F4FA0]'
              : 'border-gray-200 text-gray-600 hover:text-[#1F4FA0]'"
          >
            {{ filter.label }}
          </button>
        </div>
      </div>

      <div class="divide-y divide-gray-100">
        <article
          v-for="notification in filteredNotifications"
          :key="notification.id"
          class="flex flex-col gap-3 py-4 md:flex-row md:items-center md:justify-between"
        >
          <div class="flex items-start gap-4">
            <div class="rounded-2xl bg-[#F0F4FF] p-3 text-[#1F4FA0]">
              <Icon :name="notification.icon" size="20" />
            </div>
            <div>
              <p class="text-sm uppercase tracking-wide text-gray-400">{{ notification.category }}</p>
              <h3 class="text-lg font-semibold text-gray-900">{{ notification.title }}</h3>
              <p class="text-sm text-gray-600 mt-1">{{ notification.message }}</p>
              <div class="mt-3 flex flex-wrap gap-3 text-xs font-semibold">
                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                  <Icon name="clock" size="14" /> {{ notification.time }}
                </span>
                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-3 py-1 text-gray-600">
                  <Icon name="user" size="14" /> {{ notification.source }}
                </span>
              </div>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <span class="text-xs uppercase tracking-wide text-gray-400">Impacto</span>
            <span
              class="rounded-full px-3 py-1 text-sm font-semibold"
              :class="notification.impact === 'alto'
                ? 'bg-red-50 text-red-600'
                : notification.impact === 'medio'
                ? 'bg-yellow-50 text-yellow-600'
                : 'bg-emerald-50 text-emerald-600'"
            >
              {{ notification.impactLabel }}
            </span>
          </div>
        </article>
      </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-2">
      <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm space-y-4">
        <h3 class="text-xl font-semibold text-gray-900">Historico y respaldo</h3>
        <p class="text-gray-600 text-sm">
          Mantener esta vista permite auditar decisiones comerciales o técnicas: cada evento queda sellado
          con su fuente, impacto y tiempo de respuesta. Sirve como evidencia ante reclamos y auditorías.
        </p>
        <ul class="space-y-3 text-sm text-gray-700">
          <li class="flex items-start gap-3">
            <Icon name="check" size="16" class="text-emerald-500 mt-1" />
            <span>Registra acciones correctivas con fecha exacta.</span>
          </li>
          <li class="flex items-start gap-3">
            <Icon name="check" size="16" class="text-emerald-500 mt-1" />
            <span>Comparte contexto con soporte y facturación en un solo vistazo.</span>
          </li>
          <li class="flex items-start gap-3">
            <Icon name="check" size="16" class="text-emerald-500 mt-1" />
            <span>Demuestra cumplimiento en auditorías o INDECOPI.</span>
          </li>
        </ul>
      </div>
      <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
        <h3 class="text-xl font-semibold text-gray-900">Próximos pasos</h3>
        <p class="text-sm text-gray-600">
          Configura recordatorios automáticos y vincula tus reclamos con la bandeja de notificaciones para seguir el ciclo completo.
        </p>
        <div class="mt-6 space-y-4">
          <div class="rounded-2xl bg-gray-50 p-4">
            <p class="text-sm font-semibold text-gray-800">Automatiza avisos críticos</p>
            <p class="text-sm text-gray-500">Define reglas por nivel de impacto y asigna responsables.</p>
          </div>
          <div class="rounded-2xl bg-gray-50 p-4">
            <p class="text-sm font-semibold text-gray-800">Integra con Libro de Reclamaciones</p>
            <p class="text-sm text-gray-500">Cuando un cliente registre un reclamo, genera una notificación para seguimiento.</p>
          </div>
          <Button
            customClass="w-full rounded-xl bg-[#1F4FA0] px-4 py-3 text-white font-semibold hover:bg-[#163676] cursor-pointer"
          >
            Configurar reglas
          </Button>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import Button from '../../components/ui/atoms/Button.vue';
import Card from '../../components/ui/atoms/Card.vue';
import Icon from '../../components/ui/atoms/Icon.vue';

const activeAlerts = 6;
const commercialNotices = 42;
const responseTime = 18;

const filters = [
  { label: 'Todos', value: 'all' },
  { label: 'Operativos', value: 'operativo' },
  { label: 'Comerciales', value: 'comercial' },
  { label: 'Soporte', value: 'soporte' },
];

const activeFilter = ref('all');

const notifications = ref([
  {
    id: 1,
    title: 'Mantenimiento programado en tu zona',
    message: 'Trabajos preventivos el 12/12 de 02:00 a 04:00 am. Tu servicio podría experimentar intermitencias.',
    category: 'Operativo',
    impact: 'medio',
    impactLabel: 'Medio',
    time: 'Hace 2 horas',
    source: 'Centro de Red',
    icon: 'activity',
    type: 'operativo',
  },
  {
    id: 2,
    title: 'Pago pendiente detectado',
    message: 'Tu recibo de noviembre vencerá en 3 días. Evita la suspensión programando tu pago automático.',
    category: 'Comercial',
    impact: 'alto',
    impactLabel: 'Alto',
    time: 'Hace 6 horas',
    source: 'Facturación',
    icon: 'credit-card',
    type: 'comercial',
  },
  {
    id: 3,
    title: 'Caso de soporte actualizado',
    message: 'El ticket #4589 pasó a estado “Resuelto”. Revisa el detalle y confirma si el inconveniente fue solucionado.',
    category: 'Soporte',
    impact: 'bajo',
    impactLabel: 'Bajo',
    time: 'Ayer 18:30',
    source: 'Mesa de ayuda',
    icon: 'life-buoy',
    type: 'soporte',
  },
]);

const filteredNotifications = computed(() => {
  if (activeFilter.value === 'all') return notifications.value;
  return notifications.value.filter((item) => item.type === activeFilter.value);
});
</script>
