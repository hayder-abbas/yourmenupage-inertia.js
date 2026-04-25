<script setup>
import { onUnmounted, reactive, ref, watchEffect } from "vue";
import { useDashboardStore } from "@/Stores/DashboardStore";
import { useAppStore } from "@/Stores/AppStore";
import { Head, usePage } from "@inertiajs/vue3";
import SideBar from "@/Components/Dashboard/SideBar.vue";
import TableSection from "@/Components/Dashboard/TableSection.vue";
import DashboardNav from "@/Components/Dashboard/DashboardNav.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import Notification from "@/Components/Global/Notification.vue";

defineProps({
  restaurants: Array,
  items: Object,
  filters: Object,
});

onUnmounted(() => {
  dashboard.openDashboardSidebar = false;
  dashboard.openDashboardUserMenu = false;
  dashboard.openActionButton = false;
  dashboard.openFilterButton = false;
  dashboard.openRecordDropdown = false;
  app.openDeleteConfirmation = false;
});

const app = useAppStore();
const dashboard = useDashboardStore();
const status = ref(null);
const message = reactive({
  "item-created": "Item created successfully!",
  "item-deleted": "Item deleted successfully!",
});

watchEffect(() => {
  /**
   * When you delete an item from the Show page,
   * flash-status becomes "item-deleted", so the notification appears.
   *
   * But if you delete an item from the Dashboard page,
   * flash-status stays null, so no notification is shown.
   *
   * `watchEffect` is used to detect changes in flash-status
   * and update the status-state.
   */
  status.value = usePage().props.flash?.status;
});
</script>

<template>
  <div class="relative flex flex-col xl:flex-row">
    <Head title="Dashboard" />

    <!-- Notification Message -->
    <Notification
      :status="status"
      :message="message"
      @closeNotification="status = null"
    />

    <!-- Main Sidebar -->
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

    <div class="flex flex-col w-full xl:basis-4/5 bg-gray-50 dark:bg-gray-800">
      <!-- Navbar -->
      <DashboardNav />

      <!-- Content -->
      <div class="py-4 sm:p-4 h-screen xl:h-auto sm:overflow-auto">
        <!-- Table section -->
        <TableSection :items="items" :filters="filters" />
      </div>
    </div>
  </div>
</template>
