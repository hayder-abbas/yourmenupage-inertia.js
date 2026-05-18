<script setup>
import CardRestaurant from "@/Components/Global/CardRestaurant.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useAppStore } from "@/Stores/AppStore";
import { Head } from "@inertiajs/vue3";
import { onUnmounted } from "vue";

defineOptions({ layout: AppLayout });

defineProps({
  restaurants: Object,
  cityName: String,
});

const app = useAppStore();

onUnmounted(() => {
  app.openUserMenu = false;
  app.openHamburgerMenu = false;
});
</script>

<template>
  <div class="w-full md:max-w-2xl lg:max-w-4xl mx-auto px-4 md:px-0">
    <Head :title="`${cityName} - Restaurants`" />

    <div class="py-8 text-gray-900 dark:text-white">
      <div>Restaurant menus in</div>
      <h1 class="text-4xl font-bold">{{ cityName }}</h1>
    </div>

    <div class="h-screen flex flex-col gap-4">
      <CardRestaurant
        v-if="restaurants.length > 0"
        v-for="(r, index) in restaurants"
        :key="index"
        :restaurant="r"
      />

      <div v-else>
        <p class="text-center text-xl text-gray-900 py-8 dark:text-gray-50">
          No Restaurants yet!
        </p>
      </div>
    </div>
  </div>
</template>
