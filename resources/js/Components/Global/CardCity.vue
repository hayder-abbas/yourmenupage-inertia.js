<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  city: Object,
});
</script>

<template>
  <Link
    :href="route('city.show', city)"
    class="relative w-full lg:w-72 rounded-md hover:shadow-[-10px_20px_30px_0_rgba(0,0,0,0.6)] hover:scale-105 duration-300 hover:z-10"
  >
    <img
      :src="`/storage/city_images/${city.cityImage}`"
      :alt="city.cityName"
      class="w-full h-full object-cover rounded-md"
      loading="lazy"
    />

    <div
      class="absolute bottom-0 left-0 w-full h-24 rounded-md flex items-end bg-gradient-to-t from-slate-900 to-transparent bg-opacity-20 px-5 py-3"
    >
      <div class="w-full text-white font-bold">
        <div v-text="city.cityName" class="text-2xl"></div>
        <div class="text-gray-300">Restaurants</div>
      </div>
    </div>
  </Link>
</template>
