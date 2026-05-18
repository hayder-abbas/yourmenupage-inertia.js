<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CardCity from "@/Components/Global/CardCity.vue";
import { useAppStore } from "@/Stores/AppStore";
import { onUnmounted } from "vue";
import { Head } from "@inertiajs/vue3";

defineOptions({ layout: AppLayout });
defineProps({
  cities: Object,
});

const app = useAppStore();
onUnmounted(() => {
  app.openUserMenu = false;
  app.openHamburgerMenu = false;
});
</script>

<template>
  <div class="md:max-w-2xl lg:max-w-4xl mx-auto p-4 md:px-0">
    <Head title="All cities" />

    <h1 class="py-8 font-extrabold text-4xl dark:text-white">Popular cities</h1>
    <!-- Cities -->
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-4">
      <CardCity v-for="city in cities" :key="city.id" :city="city" />
    </div>
  </div>
</template>
