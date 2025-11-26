<template>
  <router-link
    :to="to"
    class="flex items-center px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-blue-800"
    active-class="bg-blue-900"
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
