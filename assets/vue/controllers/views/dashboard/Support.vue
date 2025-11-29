<template>
  <div class="space-y-6">
    <div class="rounded-3xl border border-gray-100 bg-white px-6 py-6 shadow-sm md:px-8">
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div class="space-y-2">
          <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Centro de ayuda</p>
          <h1 class="text-3xl font-bold text-gray-900">Soporte KSPeru</h1>
          <p class="text-gray-600">
            Gestiona solicitudes, reporta incidencias y encuentra guías rápidas sin salir del panel.
          </p>
        </div>
        <Button
          customClass="cursor-pointer flex items-center gap-2 rounded-2xl border border-[#324D68] px-5 py-3 text-sm font-semibold text-[#324D68] hover:bg-[#324D68]/5"
          @click="openTicketCenter"
        >
          <Icon name="file-text" size="16" />
          Ver solicitudes abiertas
        </Button>
      </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
      <Card
        v-for="channel in supportChannels"
        :key="channel.id"
        class="h-full rounded-2xl border border-gray-100 bg-white p-6 shadow-sm hover:shadow-lg transition-shadow"
      >
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[#324D68]/10 text-[#324D68]">
              <Icon :name="channel.icon" size="20" />
            </span>
            <div>
              <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">{{ channel.label }}</p>
              <h3 class="text-lg font-bold text-gray-900">{{ channel.title }}</h3>
            </div>
          </div>
          <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
            {{ channel.badge }}
          </span>
        </div>
        <p class="mt-4 text-sm text-gray-600">{{ channel.description }}</p>
        <div class="mt-4 rounded-2xl bg-gray-50 p-4 text-sm text-gray-700">
          <p class="font-semibold text-gray-900">{{ channel.contactLabel }}</p>
          <p>{{ channel.contactDetail }}</p>
          <p class="text-xs text-gray-500">{{ channel.helper }}</p>
          <p v-if="channel.serviceTime" class="text-xs font-semibold text-gray-600">
            Tiempo de atención: {{ channel.serviceTime }}
          </p>
        </div>
        <Button
          :customClass="`mt-5 w-full cursor-pointer rounded-2xl px-4 py-2 text-sm font-semibold ${channel.ctaClass}`"
          @click="triggerChannelAction(channel)"
        >
          <Icon :name="channel.ctaIcon" size="16" />
          {{ channel.actionLabel }}
        </Button>
      </Card>
    </div>

    <Card class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
      <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">Recursos rápidos</p>
      <h3 class="text-2xl font-bold text-gray-900">Base de conocimientos</h3>
      <p class="mt-2 text-sm text-gray-600">Encuentra tutoriales y guías oficiales de KSPeru.</p>
      <div class="mt-6 space-y-4">
        <RouterLink
          v-for="article in knowledgeBase"
          :key="article.id"
          :to="article.to"
          class="flex items-start gap-3 rounded-2xl border border-gray-100 p-4 text-sm text-gray-700 hover:border-[#324D68] hover:bg-[#324D68]/5 cursor-pointer"
        >
          <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-[#324D68]">
            <Icon :name="article.icon" size="18" />
          </span>
          <div>
            <p class="font-semibold text-gray-900">{{ article.label }}</p>
            <p class="text-xs text-gray-500">{{ article.helper }}</p>
          </div>
        </RouterLink>
      </div>
      <div class="mt-6 rounded-2xl bg-[#324D68]/5 p-4 text-sm text-[#324D68]">
        <p class="font-semibold">¿No encuentras tu respuesta?</p>
        <p>Escríbenos a <a class="font-semibold underline" href="mailto:soporte@ksperu.com">soporte@ksperu.com</a> o agenda una videollamada con nuestros especialistas.</p>
      </div>
    </Card>
  </div>
</template>

<script setup>
import { RouterLink, useRouter } from "vue-router";
import Button from "../../components/ui/atoms/Button.vue";
import Icon from "../../components/ui/atoms/Icon.vue";
import Card from "../../components/ui/atoms/Card.vue";

const router = useRouter();

const supportChannels = [
  {
    id: 1,
    label: "Teléfono",
    title: "Soporte técnico 24/7",
    badge: "Tiempo medio 5 min",
    description: "Reporta incidencias críticas o cortes inesperados con prioridad empresarial.",
    contactLabel: "Central Lima",
    contactDetail: "+51 1 705 8899",
    helper: "Disponible todos los días",
    serviceTime: "24/7",
    icon: "life-buoy",
    ctaIcon: "smartphone",
    actionLabel: "Llamar ahora",
    ctaClass: "bg-[#324D68] text-white hover:bg-[#24384c]",
    action: { type: "tel", value: "+5117058899" },
  },
  {
    id: 2,
    label: "Correo",
    title: "Mesa de ayuda",
    badge: "Respuesta < 2h",
    description: "Envía adjuntos y explica tu caso en detalle para seguimiento documentado.",
    contactLabel: "Correo corporativo",
    contactDetail: "soporte@ksperu.com",
    helper: "Horario hábil 08:00 a 20:00",
    serviceTime: "08:00 – 20:00",
    icon: "mail",
    ctaIcon: "mail",
    actionLabel: "Redactar correo",
    ctaClass: "border border-[#324D68] text-[#324D68] hover:bg-[#324D68]/5",
    action: { type: "mail", value: "soporte@ksperu.com" },
  },
  {
    id: 3,
    label: "Chat",
    title: "Asesor virtual",
    badge: "En línea",
    description: "Conversación guiada para dudas rápidas y seguimiento de tickets abiertos.",
    contactLabel: "Disponible en portal",
    contactDetail: "Chat KSPeru Connect",
    helper: "Tiempo de respuesta instantáneo",
    serviceTime: "08:00 – 22:00",
    icon: "message-square",
    ctaIcon: "chevron-right",
    actionLabel: "Ingresar al chat",
    ctaClass: "border border-[#324D68] text-[#324D68] hover:bg-[#324D68]/5",
    action: { type: "route", value: { path: "/dashboard/solicitudes", query: { tab: "chat" } } },
  },
];

const knowledgeBase = [
  {
    id: 1,
    label: "Reiniciar y diagnosticar el ONT",
    helper: "Guía paso a paso con video",
    icon: "monitor",
    to: { path: "/dashboard/soporte", query: { kb: "ont" } },
  },
  {
    id: 2,
    label: "Checklist de velocidad lenta",
    helper: "Checklist en 5 minutos",
    icon: "gauge",
    to: { path: "/dashboard/soporte", query: { kb: "speed" } },
  },
  {
    id: 3,
    label: "Autorización para visitas técnicas",
    helper: "Formato editable",
    icon: "file-text",
    to: { path: "/dashboard/soporte", query: { kb: "visit" } },
  },
];

const triggerChannelAction = (channel) => {
  if (!channel.action) return;

  if (channel.action.type === "tel") {
    window.location.href = `tel:${channel.action.value}`;
    return;
  }

  if (channel.action.type === "mail") {
    window.location.href = `mailto:${channel.action.value}`;
    return;
  }

  if (channel.action.type === "route") {
    router.push(channel.action.value);
  }
};

const openTicketCenter = () => {
  router.push({ path: "/dashboard/solicitudes" });
};
</script>
