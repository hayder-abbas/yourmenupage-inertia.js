<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <footer class="shadow bg-slate-900">
    <div
      class="flex flex-col justify-center items-center gap-4 w-full max-w-screen-xl mx-auto px-4 py-10"
    >
      <div class="font-bold italic text-2xl sm:text-3xl text-white">
        YourMenuPage
      </div>

      <Link
        href="https://hayderabbasdev.web.app"
        class="hover:underline text-amber-400 font-bold"
      >
        https://hayderabbasdev.web.app
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
