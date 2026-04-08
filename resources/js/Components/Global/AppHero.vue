<script setup>
import HomeSearchBar from "../Ui/HomeSearchBar.vue";

defineProps({
  restaurants: Object,
  filters: Object,
});
</script>

<template>
  <section
    class="w-full bg-center bg-no-repeat bg-[url(/storage/hero_images/hero1.webp)] bg-gray-500 bg-blend-multiply mb-8"
  >
    <div
      class="sm:max-w-2xl md:max-w-3xl lg:max-w-4xl xl:max-w-5xl text-center py-40 px-4 md:px-0 sm:pt-36 md:pt-52 lg:pt-56 lg:px-0 mx-auto"
    >
      <h1
        class="mb-4 text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-none text-gray-50"
      >
        Order your next meal
      </h1>
      <p
        class="mb-8 text-xl sm:text-2xl md:text-3xl text-gray-200 lg:text-3xl sm:px-16"
      >
        YourMenuPage is your source for restaurant menus
      </p>
      <!-- Search Bar -->
      <HomeSearchBar :restaurants="restaurants" :filters="filters" />
    </div>
  </section>
</template>
