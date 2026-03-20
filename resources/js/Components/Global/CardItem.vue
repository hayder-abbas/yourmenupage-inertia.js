<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  item: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <Link
    :href="route('item.show', item)"
    class="flex flex-col items-center bg-white border border-gray-200 rounded-md shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:hover:bg-gray-800"
  >
    <img
      class="object-cover w-full max-h-52 md:w-28 md:h-full rounded-md"
      :src="`../storage/${item.image}`"
      :alt="item.title"
      loading="lazy"
    />

    <div class="w-full flex flex-col justify-between p-4 leading-normal">
      <div
        v-text="item.title"
        class="mb-2 text-2xl font-bold tracking-tight text-blue-500 dark:text-white"
      ></div>

      <div
        v-text="item.description"
        class="max-h-[3.6rem] min-h-[3.6rem] overflow-hidden mb-3 text-md font-medium text-gray-500 dark:text-gray-400"
      ></div>

      <div
        v-text="item.price"
        class="font-semibold text-slate-900 dark:text-gray-400"
      ></div>
    </div>
  </Link>
</template>
