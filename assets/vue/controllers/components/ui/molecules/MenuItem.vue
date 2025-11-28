<template>
  <NavLink :to="to" :collapsed="collapsed">
    <div class="flex items-center" :class="collapsed ? 'justify-center' : ''">
      <Icon :name="icon" size="20" :class="collapsed ? '' : 'mr-3'" />
      <span v-if="!collapsed">{{ label }}</span>
    </div>
    <Badge v-if="!collapsed && badgeCount > 0">{{ badgeCount }}</Badge>
  </NavLink>
</template>

<script setup>
import NavLink from "../atoms/NavLink.vue";
import Icon from "../atoms/Icon.vue";
import Badge from "../atoms/Badge.vue";

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
  collapsed: {
    type: Boolean,
    default: false,
  },
});
</script>
