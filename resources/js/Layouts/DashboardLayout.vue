<script setup>
import AppFooter from "@/Components/Global/AppFooter.vue";
import SideBar from "@/Components/Dashboard/SideBar.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import DashboardNav from "@/Components/Dashboard/DashboardNav.vue";
import { useAppStore } from "@/Stores/AppStore";
import { useDashboardStore } from "@/Stores/DashboardStore";
import { onUnmounted } from "vue";

defineProps({
  restaurants: Object,
  filters: Object,
});

const app = useAppStore();
const dashboard = useDashboardStore();

onUnmounted(() => {
  dashboard.openDashboardSidebar = false;
  dashboard.openDashboardUserMenu = false;
  app.openDeleteConfirmation = false;
});
</script>

<template>
  <div class="relative flex flex-col xl:flex-row">
    <!-- Fixed Sidebar -->
    <SideBar :restaurants="restaurants" class="hidden xl:block xl:basis-1/5" />

    <!-- Floating Sidebar -->
    <SideBar
      :restaurants="restaurants"
      class="fixed top-0 left-0 z-50 xl:hidden w-64 duration-300"
      :class="{ '-translate-x-full': !dashboard.openDashboardSidebar }"
    >
      <template #close_button>
        <CloseIcon
          @click="
            dashboard.openDashboardSidebar = !dashboard.openDashboardSidebar
          "
          class="text-gray-50 cursor-pointer"
        />
      </template>
    </SideBar>

    <!-- Page Content -->
    <div class="flex flex-col w-full xl:basis-4/5 bg-gray-50 dark:bg-gray-800">
      <!-- Navbar -->
      <DashboardNav />

      <!-- Dashboard Content -->
      <main class="min-h-dvh">
        <slot />
      </main>
    </div>

    <!-- Page Footer -->
    <AppFooter />
  </div>
</template>
