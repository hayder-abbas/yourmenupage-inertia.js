<script setup>
import ChevronDownIcon from "@/Components/Icons/ChevronDownIcon.vue";
import { useDashboardStore } from "@/Stores/DashboardStore";

const dashboard = useDashboardStore();
</script>

<template>
  <div class="relative">
    <div
      class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 cursor-pointer"
    >
      <ChevronDownIcon class="-ml-1 mr-1.5 w-5 h-5" />
      Actions
    </div>
    <div
      class="absolute top-12 z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
      :class="{ hidden: !dashboard.openActionButton }"
    >
      <div class="py-1">
        <a
          href="#"
          class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
        >
          Delete all
        </a>
      </div>
    </div>
  </div>
</template>
