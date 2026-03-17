<script setup>
import DarkModeButton from "@/Components/Ui/DarkModeButton.vue";
import BarsIcon from "../Icons/BarsIcon.vue";
import DropdownLink from "../Global/DropdownLink.vue";
import { useDark, useToggle } from "@vueuse/core";
import { useDashboardStore } from "@/Stores/DashboardStore";
import { Link } from "@inertiajs/vue3";

const isDark = useDark(true);
const toggleDark = useToggle(isDark);
const dashboard = useDashboardStore();
</script>

<template>
  <nav class="bg-white dark:bg-gray-900">
    <div
      class="flex flex-wrap items-center justify-between lg:justify-end mx-auto p-4 border border-b-gray-200 border-r-transparent border-l-transparent dark:border-none"
    >
      <!-- Sidbar button -->
      <div class="lg:hidden">
        <BarsIcon
          @click="
            dashboard.openDashboardSidebar = !dashboard.openDashboardSidebar
          "
          class="h-7 w-7 text-gray-900 dark:text-gray-50 cursor-pointer"
        />
      </div>
      <div
        class="flex items-center lg:order-2 space-x-3 lg:space-x-0 rtl:space-x-reverse"
      >
        <!-- Dark mode button -->
        <DarkModeButton @click="toggleDark()" :isDark="isDark" />
        <div class="flex justify-end">
          <div
            v-if="$page.props.auth.user"
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
                :src="
                  $page.props.auth.user.image
                    ? `/storage/${$page.props.auth.user.image}`
                    : '/storage/default.png'
                "
                alt="user photo"
              />
            </button>
            <!-- Dropdown menu -->
            <div
              class="absolute top-10 right-0 z-50 w-[13rem] text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
              :class="{ hidden: !dashboard.openDashboardUserMenu }"
            >
              <div class="px-4 py-3">
                <span class="block text-sm text-gray-900 dark:text-white">
                  {{ $page.props.auth.user.name }}
                </span>
                <span
                  class="block text-sm text-gray-500 truncate dark:text-gray-400"
                >
                  {{ $page.props.auth.user.email }}
                </span>
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
          <div v-else>
            <Link
              :href="route('login')"
              class="rounded-md text-black text-xl ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
            >
              Log in
            </Link>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>
