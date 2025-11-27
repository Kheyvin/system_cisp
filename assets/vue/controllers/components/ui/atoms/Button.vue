<template>
  <button
    class="rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200"
    :class="[
      variantClasses,
      customClass
    ]"
    @click="$emit('click')"
  >
    <slot></slot>
  </button>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  variant: {
    type: String,
    default: 'default', // default, primary, secondary, etc.
  },
  customClass: {
    type: String,
    default: '',
  },
});

defineEmits(['click']);

const variantClasses = computed(() => {
  switch (props.variant) {
    case 'ghost':
      return 'p-2 hover:bg-blue-800 focus:ring-white'; // Sidebar style
    case 'header':
      return 'p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100'; // Header toggle style
    default:
      return '';
  }
});
</script>
