<script setup>
import { ref } from "vue";

const props = defineProps({
  item: Object,
  can: Object,
});

const imgSrc = props.item.itemImage
  ? ref(`/storage/${props.item.itemImage}`)
  : ref("/storage/default.png");
</script>

<template>
  <div
    class="w-full flex flex-col sm:flex-row items-center bg-white rounded-lg shadow-lg hover:bg-gray-100 dark:bg-gray-900 dark:hover:bg-gray-800"
  >
    <div class="sm:w-[14rem] h-full bg-slate-300 rounded-md">
      <img
        class="object-cover aspect-video sm:aspect-square w-full h-full rounded-md"
        :src="imgSrc"
        :alt="item.itemTitle"
        loading="lazy"
      />
    </div>

    <div class="w-full flex flex-col justify-between p-4 leading-normal">
      <div class="mb-2 font-bold tracking-tight text-blue-500 dark:text-white">
        {{ item.itemTitle }}
      </div>

      <div
        class="max-h-[3.6rem] min-h-[3.6rem] overflow-hidden mb-3 font-medium text-gray-500 dark:text-gray-400"
      >
        {{ item.itemDesc }}
      </div>

      <div
        class="flex justify-between font-semibold text-slate-900 dark:text-gray-400"
      >
        <div>{{ item.itemPrice }}</div>

        <!-- Action Bottons -->
        <slot />
      </div>
    </div>
  </div>
</template>
