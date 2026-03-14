<script setup>
import PlusIcon from '../Icons/PlusIcon.vue';
</script>

<template>
  <Link
    :href="route('items.create')"
    class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
  >
    <PlusIcon class="w-5 h-5 mr-2 text-white" />
    Add new Item
  </Link>
</template>
