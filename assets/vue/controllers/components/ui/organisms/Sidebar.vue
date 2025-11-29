<template>
  <aside
    class="fixed inset-y-0 left-0 z-30 transition-all duration-300 text-white overflow-y-auto bg-[linear-gradient(133deg,rgb(21,184,166)_0%,rgb(12,71,112)_100%)]"
    :class="isOpen ? 'w-64' : 'w-20'"
  >
    <div class="flex items-center justify-center h-16">
      <img
        :src="isOpen ? '/images/ksperu.svg' : '/images/ksperulogo.png'"
        alt="Logo KSPeru"
        :class="isOpen ? 'w-fit p-4' : 'w-10'"
      />
    </div>
    <nav class="mt-5 px-2 space-y-6">
      <template v-if="isOpen">
        <MenuGroup
          v-for="section in sections"
          :key="section.title"
          :title="section.title"
        >
          <MenuItem
            v-for="item in section.items"
            :key="item.to"
            :to="item.to"
            :icon="item.icon"
            :label="item.label"
            :badge-count="item.badgeCount"
          />
        </MenuGroup>
      </template>
      <template v-else>
        <div
          v-for="section in sections"
          :key="section.title"
          class="text-center"
        >
          <p class="text-xl font-semibold tracking-wide text-white/70">
            {{ section.short }}
          </p>
          <div class="mt-4 flex flex-col space-y-2">
            <MenuItem
              v-for="item in section.items"
              :key="item.to"
              :to="item.to"
              :icon="item.icon"
              :label="item.label"
              :badge-count="item.badgeCount"
              :collapsed="true"
            />
          </div>
        </div>
      </template>

      <button
        @click="$emit('logout')"
        class="flex items-center w-full px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-[#2DBFAF] focus:outline-none rounded-xl cursor-pointer group"
        :class="isOpen ? 'justify-start' : 'justify-center px-2'"
      >
        <Icon name="log-out" size="20" :class="isOpen ? 'mr-3' : ''" />
        <span v-if="isOpen">Cerrar sesion</span>
      </button>
    </nav>
  </aside>
</template>

<script setup>
import MenuGroup from "../molecules/MenuGroup.vue";
import MenuItem from "../molecules/MenuItem.vue";
import Icon from "../atoms/Icon.vue";

const sections = [
  {
    title: "Servicios Principales",
    short: "SP",
    items: [
      { to: "/dashboard", icon: "home", label: "Panel principal" },
      {
        to: "/dashboard/recibos",
        icon: "file-text",
        label: "Recibos",
        badgeCount: 3,
      },
      {
        to: "/dashboard/solicitudes",
        icon: "message-square",
        label: "Solicitudes",
        badgeCount: 5,
      },
      {
        to: "/dashboard/promociones",
        icon: "tag",
        label: "Promociones",
        badgeCount: 2,
      },
    ],
  },
  {
    title: "Gestion",
    short: "G",
    items: [
      { to: "/dashboard/pagos", icon: "credit-card", label: "Pagos" },
      {
        to: "/dashboard/configuracion",
        icon: "settings",
        label: "Configuracion",
      },
    ],
  },
];

defineProps({
  isOpen: {
    type: Boolean,
    default: true,
  },
});

defineEmits(["logout"]);
</script>
