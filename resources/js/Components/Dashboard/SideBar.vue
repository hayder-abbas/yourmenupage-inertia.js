<script setup>
import { Link } from "@inertiajs/vue3";
import AppLogo from "../Global/AppLogo.vue";
import PlusIcon from "../Icons/PlusIcon.vue";

defineProps({
  restaurants: Object,
});
</script>

<template>
  <aside class="h-screen bg-gray-900">
    <div class="flex justify-between p-4">
      <AppLogo />
      <!-- Close button -->
      <div class="flex items-center">
        <slot name="close_button"></slot>
      </div>
    </div>

    <div class="flex flex-col p-4 mb-6">
      <!-- Creat a new restaurant -->
      <Link
        :href="route('restaurant.create')"
        class="flex justify-center items-center px-1 py-2 mb-4 text-white bg-blue-600 hover:bg-blue-700 rounded-md font-bold"
      >
        <PlusIcon class="w-5 h-5" />
        New restaurant
      </Link>

      <!-- Restaurants -->
      <Link
        v-for="r in restaurants"
        :key="r.id"
        :href="route('restaurant.show', r)"
        class="flex px-4 py-2 mb-2 rounded-md text-blue-600 bg-white"
      >
        {{ r.restName }}
      </Link>
    </div>
  </aside>
</template>
