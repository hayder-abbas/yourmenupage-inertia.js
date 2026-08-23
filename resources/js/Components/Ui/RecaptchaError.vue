<script setup>
defineProps({
  error: String,
});
</script>

<template>
  <div class="text-sm text-red-600" v-text="error"></div>
</template>
