<template>
  <div
    :class="[
      'rounded-2xl transition-colors duration-300',
      padding,
      shadow,
      isDark
        ? 'bg-dark-surface-card border border-dark-border'
        : 'bg-light-surface-card border border-light-border',
      customClass
    ]"
  >
    <slot />
  </div>
</template>

<script setup>
import { useTheme } from '../../composables/useTheme';
import { computed } from 'vue';

const props = defineProps({
  padding: {
    type: String,
    default: 'p-6',
  },
  shadow: {
    type: String,
    default: 'shadow-card',
  },
  customClass: {
    type: String,
    default: '',
  },
});

const { isDark } = useTheme();
</script>
