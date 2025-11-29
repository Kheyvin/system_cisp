<template>
  <Card class="p-6 shadow-sm bg-white">
    <div class="flex flex-col gap-4 border-b border-gray-100 pb-5 md:flex-row md:items-start md:justify-between">
      <div>
        <p class="text-sm font-semibold uppercase tracking-wide text-gray-400">
          {{ content.badge }}
        </p>
        <h3 class="text-2xl font-bold text-gray-800 mt-1">
          {{ content.title }}
        </h3>
        <p class="text-gray-600 mt-2">
          {{ content.description }}
        </p>
      </div>
      <Button
        customClass="bg-[#324D68] text-white hover:bg-[#24384c] px-4 py-2 flex items-center gap-2 cursor-pointer rounded-xl"
      >
        <Icon name="edit" size="18" />
        {{ content.ctaLabel }}
      </Button>
    </div>

    <div class="grid gap-4 py-5 md:grid-cols-2">
      <div
        v-for="(detail, index) in content.details"
        :key="`detail-${index}`"
        class="rounded-2xl border border-gray-100 bg-gray-50/70 p-4"
      >
        <p class="text-sm text-gray-500">{{ detail.label }}</p>
        <p class="mt-1 text-lg font-semibold text-gray-800">{{ detail.value }}</p>
        <p class="text-sm text-gray-500" v-if="detail.helper">{{ detail.helper }}</p>
      </div>
    </div>

    <div class="space-y-3">
      <p class="text-sm font-semibold text-gray-700">Acciones rápidas</p>
      <ul class="grid gap-3 md:grid-cols-2">
        <li
          v-for="(item, index) in content.actions"
          :key="`action-${index}`"
          class="flex items-center gap-3 rounded-xl border border-dashed border-gray-200 p-3 text-sm text-gray-700"
        >
          <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#324D68]/10 text-[#324D68]">
            <Icon name="check" size="16" />
          </span>
          <span>{{ item }}</span>
        </li>
      </ul>
    </div>
  </Card>
</template>

<script setup>
import Card from "../../../components/ui/atoms/Card.vue";
import Button from "../../../components/ui/atoms/Button.vue";
import Icon from "../../../components/ui/atoms/Icon.vue";

defineProps({
  content: {
    type: Object,
    required: true,
  },
});
</script>
