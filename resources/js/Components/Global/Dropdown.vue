<script setup>
import DropdownLink from "./DropdownLink.vue";
import { onUnmounted } from "vue";
import { useAppStore } from "@/Stores/AppStore";

const app = useAppStore();

onUnmounted(() => {
  app.openUserMenu = false;
});
</script>

<template>
  <div class="flex justify-end">
    <div
      v-if="$page.props.auth.user"
      class="relative flex items-center lg:order-2 space-x-3 lg:space-x-0 rtl:space-x-reverse"
    >
    <button
      @click="app.openUserMenu = !app.openUserMenu"
        class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
      >
        <img
          class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-600"
          :src="
            $page.props.auth.user.image
              ? `storage/${$page.props.auth.user.image}`
              : 'storage/user_image/default.png'
          "
          alt="user photo"
        />
      </button>
      <!-- Dropdown menu -->
      <div
        class="absolute top-10 right-0 z-50 w-[13rem] text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
        :class="{ hidden: !app.openUserMenu }"
        >
        <div class="px-4 py-3">
          <span class="block text-sm text-gray-900 dark:text-white">
            {{ $page.props.auth.user.name }}
          </span>
          <span class="block text-sm text-gray-500 truncate dark:text-gray-400">
            {{ $page.props.auth.user.email }}
          </span>
        </div>
        <ul class="py-2">
          <li>
            <DropdownLink :href="route('dashboard')"> Dashboard </DropdownLink>
          </li>
          <li>
            <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
          </li>
          <li>
            <DropdownLink :href="route('logout')" method="post" as="button">
              Sign out
            </DropdownLink>
          </li>
        </ul>
      </div>
    </div>
    <div v-else>
      <Link
        :href="route('login')"
        class="text-xl font-bold dark:text-gray-50 hover:text-blue-500 dark:hover:text-blue-500"
        :class="$page.component === 'Home' ? 'text-gray-50' : 'text-gray-900'"
      >
        Log in
      </Link>
    </div>
  </div>
</template>
