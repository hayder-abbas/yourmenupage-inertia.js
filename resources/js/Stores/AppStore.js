import { defineStore } from "pinia";
import { ref } from "vue";

export const useAppStore = defineStore(
  "app_store",
  () => {
    const openHamburgerMenu = ref(false);
    const openUserMenu = ref(false);
    const openDeleteConfirmation = ref(false);

    return { openHamburgerMenu, openUserMenu, openDeleteConfirmation };
  }
  // {persist: true}  it's not work with ssr
);
