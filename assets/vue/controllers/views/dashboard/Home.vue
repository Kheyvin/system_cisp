<template>
  <div>
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-3xl font-bold text-principal">Panel de Control</h2>
        <span class="text-base">Bienvenido a tu portal CISP </span>
      </div>
      <Button
        customClass="bg-[#324D68] text-white hover:bg-[#24384c] flex items-center px-4 py-2 shadow-sm"
      >
        <Icon name="download" size="20" class="mr-2" />
        Descargar Factura
      </Button>
    </div>

    <!-- Hero Slider -->
    <div class="mb-8">
      <ImageSlider :slides="slides" />
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-12 gap-6">
      <div
        class="col-span-12 md:col-span-6 lg:col-span-3"
        v-for="i in 4"
        :key="i"
      >
        <Card
          class="h-full flex flex-col justify-center items-center text-center p-6 hover:shadow-lg transition-shadow duration-200"
        >
          <div class="bg-gray-100 p-4 rounded-full mb-4">
            <Icon name="file-text" size="32" class="text-gray-500" />
          </div>
          <h3 class="font-bold text-lg mb-2 text-gray-800">Card {{ i }}</h3>
          <p class="text-gray-600 text-sm">Contenido pendiente de definir.</p>
        </Card>
      </div>
    </div>
  </div>
</template>

<script setup>
import Button from "../../components/ui/atoms/Button.vue";
import Icon from "../../components/ui/atoms/Icon.vue";
import Card from "../../components/ui/atoms/Card.vue";
import ImageSlider from "../../components/ui/organisms/ImageSlider.vue";

const slides = [
  {
    image: "https://picsum.photos/1200/400?random=1",
    link: "#details1",
    title: "Promocion 1",
  },
  {
    image: "https://picsum.photos/1200/400?random=2",
    link: "#details2",
    title: "Promocion 2",
  },
  {
    image: "https://picsum.photos/1200/400?random=3",
    link: "#details3",
    title: "Promocion 3",
  },
];
</script>
