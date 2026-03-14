<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CardRestaurant from "@/Components/Global/CardRestaurant.vue";

defineOptions({ layout: AppLayout });
defineProps({
  restaurants: {
    type: Object,
    required: true,
  },
  city: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div
    class="w-full md:max-w-2xl lg:max-w-4xl xl:max-w-5xl mx-auto px-4 md:px-0"
  >
    <Head title="Restaurants" />

    <div class="py-6 text-gray-900 dark:text-gray-50">
      <p>Restaurant menus in</p>
      <h1
        class="text-gray-900 text-4xl font-bold dark:text-gray-50"
        v-text="city.name"
      ></h1>
    </div>

    <div class="h-screen py-6">
      <div
        v-if="restaurants.data.length > 0"
        v-for="(restaurant, index) in restaurants.data"
        :key="index"
      >
        <CardRestaurant :restaurant="restaurant" />
      </div>
      <div v-else>
        <p class="text-center text-xl text-gray-900 py-8 dark:text-gray-50">
          No Restaurants yet!
        </p>
      </div>
    </div>
  </div>
</template>
