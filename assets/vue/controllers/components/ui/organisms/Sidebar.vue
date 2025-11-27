<template>
  <aside
    class="fixed inset-y-0 left-0 z-30 w-64 transition-transform duration-300 transform bg-principal text-white overflow-y-auto"
    :class="{ '-translate-x-full': !isOpen, 'translate-x-0': isOpen }"
  >
    <div class="flex items-center justify-center h-16 border-b border-blue-800">
      <h1 class="text-xl font-bold">CONECTICA</h1>
    </div>
    <nav class="mt-5 px-2">
      <MenuGroup title="Servicios Principales">
        <MenuItem
          to="/dashboard"
          icon="home"
          label="Panel principal"
        />
        <MenuItem
          to="/dashboard/recibos"
          icon="file-text"
          label="Recibos"
          :badgeCount="3"
        />
        <MenuItem
          to="/dashboard/solicitudes"
          icon="message-square"
          label="Solicitudes"
          :badgeCount="5"
        />
        <MenuItem
          to="/dashboard/promociones"
          icon="tag"
          label="Promociones"
          :badgeCount="2"
        />
      </MenuGroup>

      <MenuGroup title="Gestion">
        <MenuItem
          to="/dashboard/pagos"
          icon="credit-card"
          label="Pagos"
        />
        <MenuItem
          to="/dashboard/configuracion"
          icon="settings"
          label="Configuracion"
        />
        <button
          @click="$emit('logout')"
          class="flex items-center w-full px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-[#0D9488] focus:outline-none rounded-xl cursor-pointer group"
        >
          <Icon name="log-out" size="20" class="mr-3" />
          <span>Cerrar sesion</span>
        </button>
      </MenuGroup>
    </nav>
  </aside>
</template>

<script setup>
import MenuGroup from '../molecules/MenuGroup.vue';
import MenuItem from '../molecules/MenuItem.vue';
import Icon from '../atoms/Icon.vue';

defineProps({
  isOpen: {
    type: Boolean,
    default: true,
  },
});

defineEmits(['logout']);
</script>
