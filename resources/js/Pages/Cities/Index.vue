<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import CardCity from "@/Components/Global/CardCity.vue";

defineOptions({ layout: AppLayout });
defineProps<{
  cities: any;
}>();
</script>

<template>
  <div
    class="grid grid-cols-2 md:grid-cols-3 md:max-w-2xl lg:max-w-4xl xl:max-w-5xl mx-auto gap-3 sm:gap-4 py-8 px-4 md:px-0"
  >
    <Head title="Cities" />

    <CardCity v-for="city in cities.data" :key="city.id" :city="city" />
  </div>
</template>
