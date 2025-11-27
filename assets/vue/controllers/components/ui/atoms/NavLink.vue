<template>
  <router-link
    :to="to"
    custom
    v-slot="{ href, navigate, isActive }"
  >
    <a
      :href="href"
      @click="navigate"
      class="flex items-center px-4 py-2 text-sm font-medium text-white transition-colors duration-200 rounded-xl cursor-pointer focus:outline-none"
      :class="[
        isActive ? 'bg-[#0D9488]' : 'hover:bg-[#2DBFAF]'
      ]"
    >
      <slot></slot>
    </a>
  </router-link>
</template>

<script setup>
defineProps({
  to: {
    type: [String, Object],
    required: true,
  },
});
</script>
