<script setup>
defineProps({
  icon: { type: String, required: true },
  iconBg: { type: String, required: true },
  badge: { type: String, required: true },
  badgeClass: { type: String, required: true },
  label: { type: String, required: true },
  value: { type: String, required: true },
  deltaHighlight: { type: String, required: true },
  deltaNote: { type: String, required: true },
});
</script>

<template>
  <div
    class="bg-white dark:bg-[#13141C] rounded-2xl p-5 shadow-sm border border-slate-200 dark:border-slate-900 hover:shadow-md dark:shadow-slate-900 transition"
  >
    <div class="flex items-center justify-between mb-3">
      <div class="w-11 h-11 rounded-xl grid place-items-center" :class="iconBg">
        <i :class="icon"></i>
      </div>
      <span
        class="text-[11px] font-semibold rounded-full px-2 py-1"
        :class="badgeClass"
      >
        {{ badge }}
      </span>
    </div>
    <p class="text-sm text-slate-500">{{ label }}</p>
    <p class="text-2xl font-bold mt-0.5">{{ value }}</p>
    <p class="text-xs text-slate-400 mt-1">
      <span class="text-slate-600 font-medium">{{ deltaHighlight }}</span>
      {{ deltaNote }}
    </p>
  </div>
</template>
