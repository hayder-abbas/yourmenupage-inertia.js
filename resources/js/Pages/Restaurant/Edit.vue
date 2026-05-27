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
  <div class="min-h-screen py-8 flex flex-col dark:bg-gray-800">
    <Head :title="`Edit ${restaurant.restName}`" />

    <!-- Update Restaurant Form -->
    <section>
      <UpdateRestaurantInfoForm :restaurant="restaurant" :cities="cities" />
    </section>

    <!-- Delete Restaurant Form -->
    <section>
      <DeleteRestaurantForm :restaurant="restaurant" />
    </section>
  </div>
</template>
