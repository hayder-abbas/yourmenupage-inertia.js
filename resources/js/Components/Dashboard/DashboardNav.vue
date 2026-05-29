<script setup>
import BarsIcon from "../Icons/BarsIcon.vue";
import { useDashboardStore } from "@/Stores/DashboardStore";

const dashboard = useDashboardStore();
</script>

<template>
  <nav>
    <div class="flex items-center mx-auto p-4">
      <!-- Sidbar button -->
      <div class="xl:hidden">
        <BarsIcon
          @click="
            dashboard.openDashboardSidebar = !dashboard.openDashboardSidebar
          "
          class="h-7 w-7 text-gray-900 dark:text-gray-50 cursor-pointer"
        />
      </div>
    </div>
  </nav>
</template>
