<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <Link
    href="/"
    class="flex items-center space-x-3 cursor-pointer rounded-full rtl:space-x-reverse"
  >
    <span
      class="font-extrabold italic"
      :class="
        $page.component === 'Home'
          ? 'text-white text-3xl'
          : $page.component === 'Dashboard'
            ? 'text-white text-2xl'
            : 'text-gray-900 dark:text-white text-3xl'
      "
    >
      YourMenuPage
    </span>
  </Link>
</template>
