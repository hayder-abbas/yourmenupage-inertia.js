<script setup>
import CardRestaurant from "@/Components/Global/CardRestaurant.vue";
import Pagination from "@/Components/Global/Pagination.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

defineOptions({ layout: AppLayout });

const props = defineProps({
  restaurants: Object,
  cityName: String,
});

const restData = ref(props.restaurants.data);
const restLinks = ref(props.restaurants.links);
const restMeta = ref(props.restaurants.meta);
</script>

<template>
  <div class="w-full md:max-w-2xl lg:max-w-4xl mx-auto px-4 md:px-0">
    <Head :title="`${cityName} - Restaurants`" />

    <div class="py-8 text-gray-900 dark:text-white">
      <div>Restaurant menus in</div>
      <h1 class="text-4xl font-bold">{{ cityName }}</h1>
    </div>

    <div class="flex flex-col gap-4 py-4">
      <div class="p-4 text-xl text-gray-500 dark:text-white">
        {{ restMeta.from }} - {{ restMeta.to }} of {{ restMeta.total }}
      </div>

      <div v-if="restData.length > 0" class="flex flex-col gap-4">
        <!-- Restaurant -->
        <CardRestaurant
          v-for="(r, index) in restData"
          :key="index"
          :restaurant="r"
        />

        <!-- Pagination -->
        <Pagination :meta="restMeta" :links="restLinks" />
      </div>

      <div v-else>
        <p class="text-center text-xl text-gray-900 py-8 dark:text-gray-50">
          No Restaurants yet!
        </p>
      </div>
    </div>
  </div>
</template>
