<script setup>
import MoonIcon from "../Icons/MoonIcon.vue";
import SunIcon from "../Icons/SunIcon.vue";
defineProps({
  isDark: Boolean,
});
</script>

<template>
  <button
    type="button"
    class="rounded-lg p-1 hover:bg-gray-200 dark:hover:bg-gray-600"
  >
    <MoonIcon class="w-5 h-5" :class="{ hidden: !isDark }" />
    <SunIcon class="w-5 h-5 text-amber-400" :class="{ hidden: isDark }" />
  </button>
</template>
