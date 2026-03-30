import { defineStore } from "pinia";
import { ref } from "vue";

export const useDashboardStore = defineStore(
  "dashboardStore",
  () => {
    const openDashboardSidebar = ref(false);
    const openDashboardUserMenu = ref(false);
    const openActionButton = ref(false);
    const openFilterButton = ref(false);
    const openRecordDropdown = ref(false);

    return {
      openDashboardSidebar,
      openDashboardUserMenu,
      openActionButton,
      openFilterButton,
      openRecordDropdown,
    };
  },
  { persist: true },
);
