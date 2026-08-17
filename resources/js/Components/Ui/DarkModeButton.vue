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
    class="rounded-full p-2 text-orange-400 dark:text-slate-100 bg-slate-100 dark:bg-[#13141c]"
  >
    <MoonIcon class="w-5 h-5" :class="{ hidden: !isDark }" />
    <SunIcon class="w-5 h-5" :class="{ hidden: isDark }" />
  </button>
</template>
