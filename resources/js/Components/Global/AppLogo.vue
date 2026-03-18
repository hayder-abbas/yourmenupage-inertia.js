<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <Link
    href="/"
    class="flex items-center space-x-3 cursor-pointer rounded-full rtl:space-x-reverse"
  >
    <span
      class="font-bold italic"
      :class="
        $page.component === 'Dashboard'
          ? 'text-xl sm:text-2xl text-gray-50'
          : $page.component === 'Home'
            ? 'text-xl sm:text-3xl text-gray-50'
            : 'text-2xl sm:text-3xl text-gray-900 dark:text-gray-50'
      "
    >
      YourMenuPage
    </span>
  </Link>
</template>
