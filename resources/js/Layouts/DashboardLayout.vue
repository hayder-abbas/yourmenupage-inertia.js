<script setup>
import AppFooter from "@/Components/Global/AppFooter.vue";
import SideBar from "@/Components/Dashboard/SideBar.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import DashboardNav from "@/Components/Dashboard/DashboardNav.vue";
import { useDashboardStore } from "@/Stores/DashboardStore";
import { onUnmounted, ref } from "vue";

defineProps({
  restaurants: Object,
  filters: Object,
});

const dashboard = useDashboardStore();
const openDashboardSidebar = ref(false);

function toggleSidbar() {
  openDashboardSidebar.value = !openDashboardSidebar.value;
}

onUnmounted(() => {
  dashboard.openDashboardUserMenu = false;
});
</script>

<template>
  <div class="flex flex-col">
    <div class="h-screen xl:grid xl:grid-cols-10">
      <!-- Fixed Sidebar -->
      <SideBar
        :restaurants="restaurants"
        class="hidden xl:block xl:col-span-2"
      />

      <!-- Floating Sidebar -->
      <SideBar
        :restaurants="restaurants"
        class="absolute top-0 left-0 xl:hidden w-80"
        :class="{ '-translate-x-full': !openDashboardSidebar }"
      >
        <template #close_button>
          <CloseIcon
            @click="toggleSidbar"
            class="text-gray-50 cursor-pointer"
          />
        </template>
      </SideBar>

      <div class="flex flex-col xl:col-span-8 dark:bg-gray-800">
        <!-- Navbar -->
        <DashboardNav @toggle="toggleSidbar" />

        <!-- Dashboard Content -->
        <main class="min-h-dvh">
          <slot />
        </main>
      </div>
    </div>

    <!-- Footer -->
    <AppFooter />
  </div>
</template>
