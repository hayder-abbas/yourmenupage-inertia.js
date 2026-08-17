<script setup>
import DropdownLink from "./DropdownLink.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const user = computed(() => usePage().props.auth?.user);
const authLinks = ref(false);
const userImg = user.value?.userImage
  ? ref(`/storage/${user.value?.userImage}`)
  : ref("/storage/default.png");

function handleAuthLinks() {
  authLinks.value = !authLinks.value;
}
</script>

<template>
  <div class="flex justify-end">
    <div
      v-if="user"
      class="relative flex items-center lg:order-2 space-x-3 lg:space-x-0 rtl:space-x-reverse"
    >
      <button
        @click="handleAuthLinks"
        class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
      >
        <img
          class="w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-600"
          :src="userImg"
          alt="user photo"
          loading="lazy"
        />
      </button>

      <!-- Auth links dropdown -->
      <div
        class="absolute top-10 right-0 z-50 w-[13rem] text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
        :class="{ hidden: !authLinks }"
      >
        <!-- User info -->
        <div class="px-4 py-3">
          <div
            v-text="user.fullName"
            class="block text-sm text-gray-900 dark:text-white"
          ></div>
          <div
            v-text="user.email"
            class="block text-sm text-gray-500 truncate dark:text-gray-400"
          ></div>
        </div>

        <ul class="py-2">
          <li>
            <DropdownLink :href="route('dashboard')" @click="handleAuthLinks">
              Dashboard
            </DropdownLink>
          </li>
          <li>
            <DropdownLink
              :href="route('profile.edit')"
              @click="handleAuthLinks"
            >
              Profile
            </DropdownLink>
          </li>
          <li>
            <DropdownLink
              :href="route('logout')"
              @click="handleAuthLinks"
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
</template>
