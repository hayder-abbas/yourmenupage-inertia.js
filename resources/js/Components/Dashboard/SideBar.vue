<script setup>
import AppLogo from "../Global/AppLogo.vue";
import PlusIcon from "../Icons/PlusIcon.vue";
import DropdownLink from "../Global/DropdownLink.vue";
import DarkModeButton from "../Ui/DarkModeButton.vue";
import DashboardIcon from "../Icons/DashboardIcon.vue";
import TrashIcon from "../Icons/TrashIcon.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { useDark, useToggle } from "@vueuse/core";
import { useDashboardStore } from "@/Stores/DashboardStore.js";
import { ref } from "vue";

defineProps({
  restaurants: Object,
});

const dashboard = useDashboardStore();

const isDark = useDark(true);
const toggleDark = useToggle(isDark);

const user = ref(usePage().props.auth?.user);
const userImg = user.value?.user_image
  ? ref(`/storage/${user.value?.user_image}`)
  : ref("/storage/default.png");
</script>

<template>
  <aside class="h-full duration-300 bg-gray-900">
    <!-- LOGO -->
    <div class="absolute w-full flex justify-between items-center p-4">
      <AppLogo class="text-white text-2xl" />
      <!-- Close button -->
      <div class="flex items-center">
        <slot name="close_button"></slot>
      </div>
    </div>

    <div class="h-full pt-14 flex flex-col justify-between">
      <div class="min-h-36 overflow-scroll flex flex-col p-4">
        <div class="flex flex-col gap-1 mb-4 border-b border-b-gray-600">
          <Link
            :href="route('dashboard')"
            class="flex items-center gap-2 text-white font-bold p-2 rounded-md hover:bg-gray-800"
          >
            <DashboardIcon class="w-5 h-5" />
            Dashboard
          </Link>

          <!-- Creat a new restaurant -->
          <Link
            :href="route('restaurants.create')"
            class="flex items-center gap-2 p-2 text-white font-bold rounded-md hover:bg-gray-800"
          >
            <PlusIcon class="w-5 h-5" />
            New restaurant
          </Link>
        </div>

        <!-- Restaurants -->
        <Link
          v-for="r in restaurants"
          :key="r.id"
          :href="route('restaurants.show', r)"
          class="text-white font-bold p-2 hover:bg-gray-800 rounded-md"
        >
          {{ r.restName }}
        </Link>
      </div>

      <div>
        <!-- Trash -->
        <div class="p-4">
          <Link
            :href="route('items.trashed')"
            class="flex items-center gap-2 p-2 text-white font-bold rounded-md hover:bg-gray-800"
          >
            <TrashIcon class="w-5 h-5" />
            Trash
          </Link>
        </div>

        <div
          class="flex justify-between items-center p-4 gap-4 border-t border-t-slate-600 lg:order-2"
        >
          <!-- Dropdown menu -->
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
                class="flex bg-gray-800 rounded-full md:me-0"
              >
                <img
                  class="w-14 h-14 rounded-full object-cover aspect-square"
                  :src="userImg"
                  alt="user photo"
                  loading="lazy"
                />
              </button>

              <div
                class="absolute bottom-20 left-0 z-50 w-[14rem] text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                :class="{ hidden: !dashboard.openDashboardUserMenu }"
              >
                <div class="px-4 py-3">
                  <div class="block text-sm text-gray-900 dark:text-white">
                    {{ $page.props.auth.user.user_name }}
                  </div>
                  <div
                    class="block text-sm text-gray-500 truncate dark:text-gray-400"
                  >
                    {{ $page.props.auth.user.email }}
                  </div>
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

          <!-- Dark mode button -->
          <DarkModeButton
            @click="toggleDark()"
            :isDark="isDark"
            class="text-white"
          />
        </div>
      </div>
    </div>
  </aside>
</template>
