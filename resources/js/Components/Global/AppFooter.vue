<script setup>
import { Link } from "@inertiajs/vue3";
import AppLogo from "./AppLogo.vue";
</script>

<template>
  <footer class="bg-gray-900">
    <div class="flex flex-col justify-center items-center gap-4 w-full py-10">
      <AppLogo class="text-2xl text-white" />

      <Link
        href="https://hayderabbasdev.web.app"
        class="hover:underline text-white font-bold"
      >
        hayderabbasdev.web.app
      </Link>

      <div
        class="block text-sm text-gray-500 sm:text-center dark:text-gray-400"
      >
        <span>© {{ new Date().getFullYear() }} - </span>
        <span>Hayder Abbas</span>
        <span> - All Rights Reserved</span>
      </div>
    </div>
  </footer>
</template>
