<script setup>
import { Link } from "@inertiajs/vue3";
import AppLogo from "../Global/AppLogo.vue";
import EditIcon from "../Icons/EditIcon.vue";
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

    <!-- Restaurants list -->
    <div class="p-4 mb-5">
      <h5 class="text-gray-50 text-lg py-2">Restaurans</h5>

      <ul>
        <li v-for="r in restaurants" :key="r.id">
          <Link
            :href="route('restaurant.show', r)"
            class="flex items-center justify-between text-gray-400 mb-2 px-4 py-1 hover:bg-gray-800"
          >
            {{ r.name }}
            <Link
              :href="route('restaurants.edit', r)"
              class="bg-blue-600 p-1 rounded-md hover:bg-blue-700"
            >
              <EditIcon class="w-4 h-4 text-white" />
            </Link>
          </Link>
        </li>
      </ul>

      <!-- Creat a new restaurant -->
      <Link
        :href="route('restaurants.create')"
        class="text-gray-50 bg-blue-600 hover:bg-blue-700 rounded-md py-2 block text-center"
      >
        <PlusIcon class="inline" />
        Add restaurant
      </Link>
    </div>
  </aside>
</template>
