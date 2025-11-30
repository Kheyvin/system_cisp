<template>
  <div class="relative space-y-6">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-3xl font-bold text-ksp-principal">
          Promociones y Planes
        </h2>
        <span class="text-base"
          >Descubre nuestras ofertas especiales, conoce los planes disponibles y
          accede a beneficios exclusivos diseñados para ti.
        </span>
      </div>
      <Button
        customClass="bg-[#324D68] text-white hover:bg-[#24384c] flex items-center px-4 py-2 shadow-sm cursor-pointer"
      >
        <Icon name="gift" size="20" class="mr-2" />
        Ver todas las ofertas
      </Button>
    </div>
    <TabGroup :tabs="promotionsTabs" v-model="activePromotionsTab" />

    <transition name="tab-content" mode="out-in">
      <Card :key="activePromotionsTab" class="mt-6 p-6 bg-white shadow-sm">
        <component :is="currentTabComponent" />
      </Card>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import Icon from "../../components/ui/atoms/Icon.vue";
import Card from "../../components/ui/atoms/Card.vue";
import TabGroup from "../../components/ui/molecules/TabGroup.vue";
import Button from "../../components/ui/atoms/Button.vue";
import AvailablePlansTab from "./tabs-promotions/AvailablePlansTab.vue";
import SpecialPromotionsTab from "./tabs-promotions/SpecialPromotionsTab.vue";
import AdditionalBenefitsTab from "./tabs-promotions/AdditionalBenefitsTab.vue";

const promotionsTabs = [
  { label: "Planes Disponibles", value: "plans", icon: "package" },
  { label: "Promociones Especiales", value: "promotions", icon: "tag" },
  { label: "Beneficios Adicionales", value: "benefits", icon: "gift" },
];

const tabComponentMap = {
  plans: AvailablePlansTab,
  promotions: SpecialPromotionsTab,
  benefits: AdditionalBenefitsTab,
};

const route = useRoute();
const router = useRouter();

const resolveTab = (value) => {
  const exists = promotionsTabs.some((tab) => tab.value === value);
  return exists ? value : promotionsTabs[0].value;
};

const activePromotionsTab = ref(resolveTab(route.query.tab));

const currentTabComponent = computed(() => {
  return tabComponentMap[activePromotionsTab.value] || AvailablePlansTab;
});

watch(
  () => route.query.tab,
  (newTab) => {
    const resolved = resolveTab(newTab);
    if (resolved !== activePromotionsTab.value) {
      activePromotionsTab.value = resolved;
    }
  },
  { immediate: true }
);

watch(
  activePromotionsTab,
  (newTab) => {
    if (route.query.tab === newTab) return;
    router.replace({
      path: route.path,
      query: { ...route.query, tab: newTab },
    });
  },
  { immediate: true }
);
</script>

<style scoped>
.tab-content-enter-active,
.tab-content-leave-active {
  transition: opacity 0.25s ease, transform 0.25s ease;
}

.tab-content-enter-from,
.tab-content-leave-to {
  opacity: 0;
  transform: translateY(14px);
}
</style>
