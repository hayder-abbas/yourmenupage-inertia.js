<script setup>
import CloseIcon from "../Icons/CloseIcon.vue";

defineProps({
  status: String,
  message: String,
});
</script>

<template>
  <div
    v-if="status"
    class="fixed top-4 left-4 z-10 w-80 sm:w-96 flex justify-between items-center font-bold bg-green-300 text-green-600 px-4 py-2 rounded"
  >
    <div>{{ message }}</div>
    <div @click="$emit('closeNotification')">
      <CloseIcon class="w-5 h-5 cursor-pointer" />
    </div>
  </div>
</template>
