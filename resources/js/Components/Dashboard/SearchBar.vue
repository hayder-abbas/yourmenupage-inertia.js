<script setup>
import SearchIcon from "@/Components/Icons/SearchIcon.vue";

const model = defineModel({ required: true });
</script>

<template>
  <div class="w-full md:w-1/2">
    <form class="flex items-center">
      <div class="relative w-full">
        <div
          class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
        >
          <SearchIcon class="w-5 h-5 text-gray-500 dark:text-gray-400" />
        </div>
        <input
          v-model="model"
          type="text"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          placeholder="Search"
        />
      </div>
    </form>
  </div>
</template>
