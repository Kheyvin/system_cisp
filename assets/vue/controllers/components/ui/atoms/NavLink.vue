<template>
  <router-link
    :to="to"
    class="flex items-center px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-[#0D9488] focus:outline-none rounded-xl cursor-pointer"
    active-class="bg-[#0D9488] hover:bg-[#0D9488]"
  >
    <slot></slot>
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
