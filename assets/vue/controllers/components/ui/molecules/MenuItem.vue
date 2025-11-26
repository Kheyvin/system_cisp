<template>
  <NavLink :to="to" class="justify-between group">
    <div class="flex items-center">
      <Icon :name="icon" size="20" class="mr-3" />
      <span>{{ label }}</span>
    </div>
    <Badge v-if="badgeCount > 0">{{ badgeCount }}</Badge>
  </NavLink>
</template>

<script setup>
import NavLink from '../atoms/NavLink.vue';
import Icon from '../atoms/Icon.vue';
import Badge from '../atoms/Badge.vue';

defineProps({
  to: {
    type: [String, Object],
    required: true,
  },
  icon: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  badgeCount: {
    type: Number,
    default: 0,
  },
});
</script>
