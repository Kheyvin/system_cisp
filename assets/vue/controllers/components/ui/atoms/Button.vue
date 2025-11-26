<template>
  <button
    class="p-2 rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-white"
    @click="$emit('click')"
  >
    <slot></slot>
  </button>
</template>

<script setup>
defineEmits(['click']);
</script>
