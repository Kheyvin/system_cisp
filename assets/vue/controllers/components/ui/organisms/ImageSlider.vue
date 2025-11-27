<template>
  <div class="relative w-full overflow-hidden rounded-lg shadow-lg group h-64 md:h-80 lg:h-96">
    <!-- Slides -->
    <div
      v-for="(slide, index) in slides"
      :key="index"
      class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
      :class="{ 'opacity-100 z-10': index === currentIndex, 'opacity-0 z-0': index !== currentIndex }"
    >
      <img :src="slide.image" :alt="slide.title" class="object-cover w-full h-full" />
      
      <!-- Overlay Content -->
      <div class="absolute bottom-0 left-0 p-8 bg-linear-to-t from-black/70 to-transparent w-full">
        <div class="text-white">
          <h3 class="text-lg font-bold uppercase tracking-wider mb-2">Promocion Especial</h3>
          <a
            :href="slide.link"
            class="inline-block px-6 py-2 text-white font-semibold rounded transition-colors duration-200 hover:bg-keppel-600 bg-principal"
          >
            Ver detalles
          </a>
        </div>
      </div>
    </div>

    <!-- Controls -->
    <button
      @click="prev"
      class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/30 text-white p-2 rounded-full hover:bg-black/50 focus:outline-none z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
    >
      <Icon name="chevron-left" size="24" />
    </button>
    <button
      @click="next"
      class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/30 text-white p-2 rounded-full hover:bg-black/50 focus:outline-none z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
    >
      <Icon name="chevron-right" size="24" />
    </button>

    <!-- Indicators -->
    <div class="absolute bottom-4 right-4 flex space-x-2 z-20">
      <button
        v-for="(_, index) in slides"
        :key="index"
        @click="goTo(index)"
        class="w-3 h-3 rounded-full transition-colors duration-200"
        :class="index === currentIndex ? 'bg-white' : 'bg-white/50 hover:bg-white/80'"
      ></button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import Icon from '../atoms/Icon.vue';

const props = defineProps({
  slides: {
    type: Array,
    required: true,
    // Expected format: [{ image: 'url', link: 'url' }]
  },
  autoPlayInterval: {
    type: Number,
    default: 10000, // 10 seconds
  },
});

const currentIndex = ref(0);
let intervalId = null;

const next = () => {
  currentIndex.value = (currentIndex.value + 1) % props.slides.length;
};

const prev = () => {
  currentIndex.value = (currentIndex.value - 1 + props.slides.length) % props.slides.length;
};

const goTo = (index) => {
  currentIndex.value = index;
};

const startAutoPlay = () => {
  stopAutoPlay();
  intervalId = setInterval(next, props.autoPlayInterval);
};

const stopAutoPlay = () => {
  if (intervalId) {
    clearInterval(intervalId);
    intervalId = null;
  }
};

onMounted(() => {
  startAutoPlay();
});

onUnmounted(() => {
  stopAutoPlay();
});
</script>
