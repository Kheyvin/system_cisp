<template>
  <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th
              v-for="col in columns"
              :key="col.key"
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
              :class="col.headerClass"
            >
              {{ col.label }}
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="(row, rowIndex) in data" :key="rowIndex" class="hover:bg-gray-50 transition-colors">
            <td
              v-for="col in columns"
              :key="col.key"
              class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
              :class="col.cellClass"
            >
              <slot :name="`cell-${col.key}`" :row="row" :value="row[col.key]">
                {{ row[col.key] }}
              </slot>
            </td>
          </tr>
          <tr v-if="data.length === 0">
            <td :colspan="columns.length" class="px-6 py-4 text-center text-sm text-gray-500">
              No hay datos disponibles
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <Pagination
      v-if="pagination"
      :current-page="pagination.currentPage"
      :total-pages="pagination.totalPages"
      :items-per-page="pagination.itemsPerPage"
      @page-change="$emit('page-change', $event)"
      @update:items-per-page="$emit('update:itemsPerPage', $event)"
    />
  </div>
</template>

<script setup>
import Pagination from "../molecules/Pagination.vue";

defineProps({
  columns: {
    type: Array,
    required: true,
    // Expected format: { key: string, label: string, headerClass?: string, cellClass?: string }
  },
  data: {
    type: Array,
    required: true,
  },
  pagination: {
    type: Object,
    default: null,
    // Expected format: { currentPage: number, totalPages: number, itemsPerPage: number }
  },
});

defineEmits(["page-change", "update:itemsPerPage"]);
</script>
