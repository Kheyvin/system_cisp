<template>
  <div class="w-full">
    <div
      class="flex flex-col gap-2 rounded-2xl border border-gray-200 bg-ksp-dark-100 p-1 md:flex-row"
    >
      <TabButton
        v-for="tab in tabs"
        :key="tab.value"
        :label="tab.label"
        :active="tab.value === modelValue"
        @select="handleSelect(tab.value)"
      />
    </div>
  </div>
</template>

<script setup>
import TabButton from "../atoms/TabButton.vue";

const props = defineProps({
  tabs: {
    type: Array,
    required: true,
  },
  modelValue: {
    type: [String, Number],
    required: true,
  },
});

const emit = defineEmits(["update:modelValue"]);

const handleSelect = (value) => {
  if (value === props.modelValue) return;
  emit("update:modelValue", value);
};
</script>
