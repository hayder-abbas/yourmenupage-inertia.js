import { defineStore } from "pinia";
import { ref } from "vue";

export const useDashboardStore = defineStore(
    "dashboardStore",
    () => {
        const userRestaurants = ref(null);

        return {
            userRestaurants,
        };
    },
    { persist: true },
);
