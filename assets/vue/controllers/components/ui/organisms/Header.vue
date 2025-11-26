<template>
  <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200 shadow-sm">
    <div class="flex items-center">
      <Button @click="$emit('toggle-sidebar')" class="text-gray-500 hover:text-gray-700 hover:bg-gray-100 mr-4">
        <Icon name="menu" size="24" />
      </Button>
      <h2 class="text-xl font-semibold text-gray-800">CONECTICA</h2>
    </div>
    <div class="flex items-center">
      <!-- User profile or other header items could go here -->
    </div>
  </header>
</template>

<script setup>
import Button from '../atoms/Button.vue';
import Icon from '../atoms/Icon.vue';

defineEmits(['toggle-sidebar']);
</script>
