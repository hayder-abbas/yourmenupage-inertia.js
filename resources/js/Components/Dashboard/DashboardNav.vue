<script setup>
import DarkModeButton from "@/Components/Ui/DarkModeButton.vue";
import BarsIcon from "../Icons/BarsIcon.vue";
import DropdownLink from "../Global/DropdownLink.vue";
import { useDark, useToggle } from "@vueuse/core";
import { useDashboardStore } from "@/Stores/DashboardStore";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const isDark = useDark(true);
const toggleDark = useToggle(isDark);
const dashboard = useDashboardStore();
const user = ref(usePage().props.auth.user);
const userImg = user.value.user_image
  ? ref(`/storage/${user.value.user_image}`)
  : ref("/storage/default.png");
</script>

<template>
  <nav class="bg-white dark:bg-gray-900">
    <div
      class="flex flex-wrap items-center justify-between xl:justify-end mx-auto p-4 border border-b-gray-200 border-r-transparent border-l-transparent dark:border-none"
    >
      <!-- Sidbar button -->
      <div class="xl:hidden">
        <BarsIcon
          @click="
            dashboard.openDashboardSidebar = !dashboard.openDashboardSidebar
          "
          class="h-7 w-7 text-gray-900 dark:text-gray-50 cursor-pointer"
        />
      </div>
      <div class="flex items-center gap-4 lg:order-2">
        <!-- Dark mode button -->
        <DarkModeButton
          @click="toggleDark()"
          :isDark="isDark"
          class="text-gray-900 dark:text-white"
        />

        <div class="flex justify-end">
          <div
            class="relative flex items-center lg:order-2 space-x-3 lg:space-x-0 rtl:space-x-reverse"
          >
            <button
              @click="
                dashboard.openDashboardUserMenu =
                  !dashboard.openDashboardUserMenu
              "
              type="button"
              class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
            >
              <img
                class="w-8 h-8 p-1 rounded-full bg-gray-50 dark:bg-gray-600"
                :src="userImg"
                alt="user photo"
                loading="lazy"
              />
            </button>
            <!-- Dropdown menu -->
            <div
              class="absolute top-10 right-0 z-50 w-[13rem] text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
              :class="{ hidden: !dashboard.openDashboardUserMenu }"
            >
              <div class="px-4 py-3">
                <div
                  v-text="$page.props.auth.user.name"
                  class="block text-sm text-gray-900 dark:text-white"
                ></div>
                <div
                  v-text="$page.props.auth.user.email"
                  class="block text-sm text-gray-500 truncate dark:text-gray-400"
                ></div>
              </div>
              <ul class="py-2">
                <li>
                  <DropdownLink :href="route('profile.edit')">
                    Profile
                  </DropdownLink>
                </li>
                <li>
                  <DropdownLink
                    :href="route('logout')"
                    method="post"
                    as="button"
                  >
                    Sign out
                  </DropdownLink>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>
