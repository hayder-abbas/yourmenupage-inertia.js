<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <Link
    href="/"
    class="flex items-center space-x-3 cursor-pointer rounded-full rtl:space-x-reverse"
  >
    <span
      class="font-extrabold italic text-2xl"
      :class="
        $page.component === 'Home'
          ? 'text-white'
          : $page.component === 'Dashboard'
            ? 'text-white'
            : 'text-gray-900 dark:text-white'
      "
    >
      YourMenuPage
    </span>
  </Link>
</template>
