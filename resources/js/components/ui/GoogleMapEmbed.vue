<template>
  <div :class="['google-map-embed', customClass]">
    <iframe
      :src="computedSrc"
      width="100%"
      height="160"
      style="border:0;"
      loading="lazy"
      allowfullscreen
      referrerpolicy="no-referrer-when-downgrade"
      :title="title"
    ></iframe>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  lat: {
    type: [String, Number],
    required: true,
  },
  lng: {
    type: [String, Number],
    required: true,
  },
  zoom: {
    type: [String, Number],
    default: 16,
  },
  title: {
    type: String,
    default: 'Google Map',
  },
  customClass: {
    type: String,
    default: '',
  },
});

const computedSrc = computed(() => {
  return `https://www.google.com/maps?q=${props.lat},${props.lng}&z=${props.zoom}&output=embed`;
});
</script>

<style scoped>
.google-map-embed {
  min-width: 200px;
  min-height: 120px;
  max-width: 320px;
  border-radius: 0.75rem;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
  border: 1px solid var(--tw-prose-border, #e5e7eb);
}
</style>
