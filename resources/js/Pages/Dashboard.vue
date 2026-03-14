<script setup>
import SideBar from "@/Components/Dashboard/SideBar.vue";
import TableSection from "@/Components/Dashboard/TableSection.vue";
import DashboardNav from "@/Components/Dashboard/DashboardNav.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import { onUnmounted, provide } from "vue";
import { useDashboardStore } from "@/Stores/DashboardStore";
import { useAppStore } from "@/Stores/AppStore";

const app = useAppStore();
const dashboard = useDashboardStore();
const props = defineProps({
  restaurants: {
    type: Object,
    required: true,
  },
  items: Object,
  categories: Object,
  filters: Object,
});
provide("restaurants", props.restaurants.data);

onUnmounted(() => {
  dashboard.openDashboardSidebar = false;
  dashboard.openDashboardUserMenu = false;
  dashboard.openActionButton = false;
  dashboard.openFilterButton = false;
  dashboard.openRecordDropdown = false;
  app.openDeleteConfirmation = false;
});
</script>

<template>
  <div class="relative flex flex-col lg:flex-row">
    <Head title="Dashboard" />

    <!-- Main Sidebar -->
    <SideBar class="hidden lg:block lg:basis-1/4 xl:basis-1/5" />

    <!-- Floating Sidebar -->
    <SideBar
      class="fixed top-0 left-0 z-50 lg:hidden w-64 duration-300"
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

    <div
      class="flex flex-col w-full lg:basis-3/4 xl:basis-4/5 bg-gray-50 dark:bg-gray-800"
    >
      <!-- Navbar -->
      <DashboardNav />

      <!-- Content -->
      <div class="py-4 sm:p-4 h-screen lg:h-auto sm:overflow-auto">
        <!-- Table section -->
        <TableSection
          :items="items"
          :restaurants="restaurants"
          :categories="categories"
          :filters="filters"
        />
      </div>
    </div>
  </div>
</template>
