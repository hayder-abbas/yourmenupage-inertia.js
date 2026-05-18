<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DeleteRestaurantForm from "./Partial/DeleteRestaurantForm.vue";
import UpdateRestaurantInfoForm from "./Partial/UpdateRestaurantInfoForm.vue";
import { Head } from "@inertiajs/vue3";

defineOptions({ layout: AppLayout });

const props = defineProps({
  restaurant: Object,
  cities: Object,
});
</script>

<template>
  <section
    class="min-h-screen py-8 flex flex-col items-center justify-center bg-white dark:bg-gray-800"
  >
    <Head :title="`Edit ${restaurant.restName}`" />

    <!-- Update Restaurant Form -->
    <div class="p-4 mb-12 md:p-0 w-full md:max-w-2xl xl:max-w-4xl">
      <UpdateRestaurantInfoForm :restaurant="restaurant" :cities="cities" />
    </div>

    <!-- Delete Restaurant Form -->
    <div
      class="p-4 sm:p-8 w-full md:max-w-2xl xl:max-w-4xl bg-white dark:bg-gray-900 shadow md:rounded-lg"
    >
      <DeleteRestaurantForm class="max-w-xl" :restaurant="restaurant" />
    </div>
  </section>
</template>
