<template>
  <button
    type="button"
    @click="$emit('select')"
    class="tab-button relative flex-1 overflow-hidden rounded-xl px-4 py-1 text-center text-sm font-semibold transition-all duration-300 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-[#324D68]/40"
    :class="[
      active
        ? 'text-[#324D68] animate-tab-switch'
        : 'text-gray-500 hover:text-[#324D68]'
    ]"
    :aria-pressed="active"
  >
    <span
      class="absolute inset-0 rounded-xl border transition-all duration-300"
      :class="[
        active
          ? 'opacity-100 scale-100 shadow-lg border-transparent bg-white'
          : 'opacity-40 scale-95 border-dashed border-gray-300 bg-transparent'
      ]"
    ></span>
    <span class="relative z-10"><slot>{{ label }}</slot></span>
  </button>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    default: '',
  },
  active: {
    type: Boolean,
    default: false,
  },
});

defineEmits(['select']);

</script>

<style scoped>
.tab-button {
  will-change: transform, box-shadow;
}

.tab-button:active {
  transform: scale(0.97);
}

@keyframes tab-switch-move {
  0% {
    transform: translateY(6px);
    opacity: 0.4;
  }
  100% {
    transform: translateY(0);
    opacity: 1;
  }
}

.animate-tab-switch {
  animation: tab-switch-move 0.3s ease;
}
</style>
