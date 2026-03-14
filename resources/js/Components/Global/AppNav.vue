<script setup>
import AppLogo from "./AppLogo.vue";
import DarkModeButton from "@/Components/Ui/DarkModeButton.vue";
import NavLink from "./NavLink.vue";
import Dropdown from "./Dropdown.vue";
import HamburgerIcon from "../Icons/HamburgerIcon.vue";
import { useDark, useToggle } from "@vueuse/core";
import { onUnmounted } from "vue";
import { useAppStore } from "@/Stores/AppStore";

const app = useAppStore();
const isDark = useDark();
const toggleDark = useToggle(isDark);

onUnmounted(() => {
  app.openHamburgerMenu = false;
});
</script>

<template>
  <nav
    class="py-8 border-b-2"
    :class="
      $page.component === 'Home' ? 'border-b-gray-600' : 'border-b-gray-300'
    "
  >
    <div class="relative flex flex-wrap items-center justify-between">
      <!-- LOGO -->
      <AppLogo />
      <div
        class="flex items-center lg:order-2 space-x-3 lg:space-x-0 rtl:space-x-reverse"
      >
        <!-- Dark mode button -->
        <DarkModeButton @click="toggleDark()" :isDark="isDark" />
        <!-- Dropdown User -->
        <Dropdown />
        <button
          @click="app.openHamburgerMenu = !app.openHamburgerMenu"
          type="button"
          class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
          :class="
            $page.component === 'Home'
              ? 'text-gray-50'
              : 'text-gray-900 dark:text-gray-50'
          "
        >
          <HamburgerIcon class="w-5 h-5" />
        </button>
      </div>
      <div
        class="items-center justify-between w-full lg:flex lg:w-auto lg:order-1"
        :class="{
          hidden: !app.openHamburgerMenu,
          'absolute top-10 lg:relative lg:top-0': $page.component === 'Home',
        }"
      >
        <ul
          class="flex flex-col font-medium p-4 lg:p-0 mt-4 rounded-lg bg-gray-50 dark:bg-gray-600 lg:bg-transparent lg:dark:bg-transparent lg:space-x-8 rtl:space-x-reverse lg:flex-row lg:mt-0"
        >
          <li>
            <NavLink :href="route('home')" :active="route().current('home')">
              Home
            </NavLink>
          </li>
          <li>
            <NavLink
              :href="route('cities')"
              :active="route().current('cities')"
            >
              All cities
            </NavLink>
          </li>
          <li>
            <NavLink :href="route('about')" :active="route().current('about')">
              About
            </NavLink>
          </li>
          <li>
            <NavLink
              :href="route('contact')"
              :active="route().current('contact')"
            >
              Contact
            </NavLink>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
