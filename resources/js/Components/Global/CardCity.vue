<script setup>
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
        alt="City image"
        class="w-full h-full object-cover rounded-sm"
      />

      <p
        class="absolute bottom-0 left-0 w-full h-24 rounded-sm flex items-end bg-gradient-to-t from-slate-900 to-transparent bg-opacity-20 px-5 py-3"
      >
        <span class="w-full text-white font-bold">
          <h4 class="text-2xl">{{ city.name }}</h4>
          <p class="text-gray-300">Restaurants</p>
        </span>
      </p>
    </Link>
  </div>
</template>
