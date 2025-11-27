<template>
  <div class="mb-2">
    <button
      @click="toggle"
      class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-white hover:bg-[#0D9488] focus:outline-none rounded-xl cursor-pointer"
    >
      <span>{{ title }}</span>
      <Icon :name="isOpen ? 'chevron-down' : 'chevron-right'" size="16" />
    </button>
    <div v-show="isOpen" class="mt-1 space-y-1">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Icon from "../atoms/Icon.vue";

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  initialOpen: {
    type: Boolean,
    default: true,
  },
});

const isOpen = ref(props.initialOpen);

const toggle = () => {
  isOpen.value = !isOpen.value;
};
</script>
