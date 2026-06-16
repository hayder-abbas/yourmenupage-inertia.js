import { defineStore } from "pinia";

export const useAppStore = defineStore(
    "appStore",
    () => {
        return {};
    },
    { persist: true },
);
