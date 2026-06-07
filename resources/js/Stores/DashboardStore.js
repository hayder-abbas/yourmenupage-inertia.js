import { defineStore } from "pinia";
import { ref } from "vue";

export const useDashboardStore = defineStore(
    "dashboardStore",
    () => {
        const openDashboardUserMenu = ref(false);
        const userRestaurants = ref(null);

        return {
            openDashboardUserMenu,
            userRestaurants,
        };
    },
    { persist: true },
);
