<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import CardCity from "@/Components/Global/CardCity.vue";

defineOptions({ layout: AppLayout });
defineProps<{
  cities: any;
}>();
</script>

<template>
  <div class="md:max-w-2xl lg:max-w-4xl xl:max-w-5xl mx-auto px-4 md:px-0">
    <Head title="Cities" />

    <h1 class="py-8 font-extrabold text-4xl dark:text-white">Popular cities</h1>
    <!-- Cities -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
      <CardCity v-for="city in cities.data" :key="city.id" :city="city" />
    </div>
  </div>
</template>
