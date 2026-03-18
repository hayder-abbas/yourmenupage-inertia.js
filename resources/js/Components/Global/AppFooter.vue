<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <footer class="shadow bg-slate-900">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
      <div class="sm:flex sm:items-center sm:justify-between">
        <div
          class="mb-4 sm:m-0 font-bold italic text-2xl sm:text-3xl text-gray-50"
        >
          YourMenuPage
        </div>

        <ul
          class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400"
        >
          <li>
            <Link href="#" class="hover:underline me-4 md:me-6">About</Link>
          </li>
          <li>
            <Link href="#" class="hover:underline me-4 md:me-6">
              Privacy Policy
            </Link>
          </li>
          <li>
            <Link href="#" class="hover:underline me-4 md:me-6">Licensing</Link>
          </li>
          <li>
            <Link href="#" class="hover:underline">Contact</Link>
          </li>
        </ul>
      </div>
      <hr
        class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8"
      />
      <span
        class="block text-sm text-gray-500 sm:text-center dark:text-gray-400"
      >
        © 2024
        <a href="https://flowbite.com/" class="hover:underline">Hayder Abbas</a>
        .All Rights Reserved.
      </span>
    </div>
  </footer>
</template>
