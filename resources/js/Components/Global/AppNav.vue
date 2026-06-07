<script setup>
import AppLogo from "./AppLogo.vue";
import DarkModeButton from "@/Components/Ui/DarkModeButton.vue";
import NavLink from "./NavLink.vue";
import Dropdown from "./Dropdown.vue";
import HamburgerIcon from "../Icons/HamburgerIcon.vue";
import { useDark, useToggle } from "@vueuse/core";
import { onUnmounted } from "vue";
import { useAppStore } from "@/Stores/AppStore";
import { Link } from "@inertiajs/vue3";
import PrimaryButton from "../Ui/PrimaryButton.vue";

const app = useAppStore();
const isDark = useDark(true);
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
      <AppLogo
        class="text-3xl"
        :class="
          $page.component === 'Home'
            ? 'text-white'
            : 'text-gray-900 dark:text-white'
        "
      />

      <div class="flex items-center gap-4 lg:order-2">
        <div class="hidden md:flex gap-4 items-center">
          <!-- Dark mode button -->
          <DarkModeButton
            @click="toggleDark()"
            :isDark="isDark"
            class="text-gray-900 dark:text-white"
            :class="{ 'text-white': $page.component === 'Home' }"
          />

          <Link
            v-if="!$page.props.auth.user"
            :href="route('login')"
            class="text-xl font-bold text-gray-900 dark:text-gray-50 hover:text-blue-500 dark:hover:text-blue-500"
            :class="
              $page.component === 'Home' ? 'text-gray-50' : 'text-gray-900'
            "
          >
            <PrimaryButton> Log in </PrimaryButton>
          </Link>
        </div>

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

      <!-- Links -->
      <div
        class="items-center justify-end flex-grow mr-5 w-full lg:flex lg:w-auto lg:order-1"
        :class="{
          hidden: !app.openHamburgerMenu,
          'absolute top-10 lg:relative lg:top-0': $page.component === 'Home',
        }"
      >
        <ul
          class="flex flex-col font-medium p-4 lg:p-0 mt-4 rounded-lg bg-gray-50 dark:bg-gray-600 lg:bg-transparent lg:dark:bg-transparent lg:space-x-8 rtl:space-x-reverse lg:flex-row lg:mt-0"
        >
          <li class="flex justify-between mb-4 items-center md:hidden">
            <Link
              v-if="!$page.props.auth.user"
              :href="route('login')"
              class="text-xl font-bold text-gray-900 dark:text-gray-50"
            >
              <PrimaryButton> Log in </PrimaryButton>
            </Link>
            <!-- Dark mode button -->
            <DarkModeButton
              @click="toggleDark()"
              :isDark="isDark"
              class="text-gray-900 dark:text-white"
            />
          </li>
          <li>
            <NavLink :href="route('home')" :active="route().current('home')">
              Home
            </NavLink>
          </li>
          <li>
            <NavLink
              :href="route('cities.index')"
              :active="route().current('cities.index')"
            >
              All cities
            </NavLink>
          </li>
          <li>
            <NavLink :href="route('about')" :active="route().current('about')">
              About us
            </NavLink>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
