<script setup>
defineProps({
  value: String,
});
</script>

<template>
  <label class="block mb-2 font-medium dark:text-white">
    <span v-if="value">{{ value }}</span>
    <span v-else><slot /></span>
  </label>
</template>
