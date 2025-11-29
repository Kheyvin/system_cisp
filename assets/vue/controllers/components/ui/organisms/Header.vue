<template>
  <header
    class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200 shadow-sm"
  >
    <div class="flex items-center">
      <Button
        class="cursor-pointer"
        @click="$emit('toggle-sidebar')"
        :class="[
          'mr-4 p-2 focus:outline-none outline-none focus:ring-0 focus:ring-offset-0 transition-colors duration-200',
          isSidebarOpen
            ? 'text-[#324D68] hover:bg-[#324D68] hover:text-white'
            : 'bg-[#324D68] text-white',
        ]"
      >
        <Icon name="sidebar" size="24" />
      </Button>
      <h2 class="text-xl font-semibold text-gray-800">CONECTICA</h2>
    </div>
    <div class="flex items-center">
      <!-- User profile or other header items could go here -->
    </div>
  </header>
</template>

<script setup>
import Button from "../atoms/Button.vue";
import Icon from "../atoms/Icon.vue";

defineProps({
  isSidebarOpen: {
    type: Boolean,
    default: true,
  },
});

defineEmits(["toggle-sidebar"]);
</script>
<style  scoped>
button,
.btn {
  outline: none !important;
}

button:focus,
button:focus-visible,
button:active {
  outline: none !important;
  box-shadow: none !important;
}
</style>