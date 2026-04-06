<script setup>
import AppHero from "@/Components/Global/AppHero.vue";
import Card from "@/Components/Ui/Card.vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { Head } from "@inertiajs/vue3";

defineOptions({ layout: HomeLayout });
const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  restaurants: Object,
  filters: Object,
});
</script>

<template>
  <Head title="Home" />
  <!-- Hero -->
  <AppHero :restaurants="restaurants" :filters="filters" />

  <!-- How it works -->
  <section
    class="md:max-w-2xl lg:max-w-4xl xl:max-w-5xl mx-auto px-4 mb-8 md:px-0 lg:py-8"
  >
    <h1 class="py-8 font-extrabold text-4xl dark:text-white">How it works</h1>

    <div class="grid gap-4 lg:grid-cols-3">
      <Card
        img="/storage/kebab.png"
        title="Discover local menus"
        desc="See menus for popular restaurants near you."
      />

      <Card
        img="/storage/coal.png"
        title="Order delivery or takeout"
        desc="Enjoy your go-to restaurant or find something new to love."
      />

      <Card
        img="/storage/knife.png"
        title="Easy to use anytime, anywhere"
        desc="Menus, restaurant info, and ordering - all in one place."
      />
    </div>
  </section>
</template>
