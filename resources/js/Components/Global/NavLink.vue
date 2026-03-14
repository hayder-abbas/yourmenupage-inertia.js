<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  href: {
    type: String,
    required: true,
  },
  active: Boolean,
});

const classes = computed(() =>
  usePage().component === "Home"
    ? props.active
      ? "block py-2 px-3 text-xl font-bold text-blue-500 rounded hover:bg-gray-200 hover:text-gray-900 lg:hover:bg-transparent lg:hover:text-blue-500 lg:p-0 lg:dark:hover:text-blue-500 dark:hover:bg-gray-500 dark:hover:text-gray-50 lg:dark:hover:bg-transparent"
      : "block py-2 px-3 text-xl font-bold text-gray-900 lg:text-gray-50 dark:text-gray-50 rounded hover:bg-gray-200 lg:hover:bg-transparent lg:hover:text-blue-500 lg:p-0 lg:dark:hover:text-blue-500 dark:hover:bg-gray-500 dark:hover:text-gray-50 lg:dark:hover:bg-transparent"
    : props.active
    ? "block py-2 px-3 text-xl font-bold text-blue-500 rounded hover:bg-gray-200 hover:text-gray-900 lg:hover:bg-transparent lg:hover:text-blue-500 lg:p-0 lg:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-gray-50 lg:dark:hover:bg-transparent"
    : "block py-2 px-3 text-xl font-bold text-gray-900 rounded hover:bg-gray-200 lg:hover:bg-transparent lg:hover:text-blue-500 lg:p-0 dark:text-gray-50 lg:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-gray-50 lg:dark:hover:bg-transparent"
);
</script>

<template>
  <Link :href="href" :class="classes">
    <slot />
  </Link>
</template>
