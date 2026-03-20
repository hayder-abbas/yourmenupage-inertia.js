<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  city: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div
    class="relative rounded-sm hover:shadow-[-10px_20px_30px_0_rgba(0,0,0,0.6)] hover:scale-105 duration-300 hover:z-10"
  >
    <Link :href="route('city.show', city)">
      <img
        :src="`/storage/city_images/${city.image}`"
        :alt="city.name"
        class="w-full h-full object-cover rounded-sm"
        loading="lazy"
      />

      <div
        class="absolute bottom-0 left-0 w-full h-24 rounded-sm flex items-end bg-gradient-to-t from-slate-900 to-transparent bg-opacity-20 px-5 py-3"
      >
        <div class="w-full text-white font-bold">
          <div v-text="city.name" class="text-2xl"></div>
          <div class="text-gray-300">Restaurants</div>
        </div>
      </div>
    </Link>
  </div>
</template>
