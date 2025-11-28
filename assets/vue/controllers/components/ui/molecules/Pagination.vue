<template>
  <div class="flex flex-col md:flex-row justify-between items-center p-4 border-t border-gray-200 bg-white">
    <!-- Left: Page Info -->
    <div class="text-sm text-gray-600 mb-4 md:mb-0">
      Página {{ currentPage }} de {{ totalPages }}
    </div>

    <!-- Center: Navigation -->
    <div class="flex items-center space-x-2 mb-4 md:mb-0">
      <button
        @click="$emit('page-change', currentPage - 1)"
        :disabled="currentPage <= 1"
        class="p-2 rounded-md hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
        :class="{ 'cursor-pointer': currentPage > 1 }"
        aria-label="Página anterior"
      >
        <Icon name="chevron-left" size="20" class="text-gray-600" />
      </button>
      
      <button
        @click="$emit('page-change', currentPage + 1)"
        :disabled="currentPage >= totalPages"
        class="p-2 rounded-md hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
        :class="{ 'cursor-pointer': currentPage < totalPages }"
        aria-label="Página siguiente"
      >
        <Icon name="chevron-right" size="20" class="text-gray-600" />
      </button>
    </div>

    <!-- Right: Rows per page -->
    <div class="flex items-center text-sm text-gray-600">
      <span class="mr-2">Filas por página:</span>
      <select
        :value="itemsPerPage"
        @change="$emit('update:itemsPerPage', Number($event.target.value))"
        class="border-gray-300 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 p-1 cursor-pointer"
      >
        <option v-for="opt in [5, 10, 20, 50]" :key="opt" :value="opt">
          {{ opt }}
        </option>
      </select>
    </div>
  </div>
</template>

<script setup>
import Icon from "../atoms/Icon.vue";

defineProps({
  currentPage: {
    type: Number,
    required: true,
  },
  totalPages: {
    type: Number,
    required: true,
  },
  itemsPerPage: {
    type: Number,
    required: true,
  },
});

defineEmits(["page-change", "update:itemsPerPage"]);
</script>
