<script setup>
defineProps({
  restaurant: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <Link
    :href="route('restaurant.show', restaurant)"
    class="w-full flex border border-gray-200 mb-5 rounded-md md:hover:shadow-[0_0_60px_-15px_rgba(0,0,0,0.3)] dark:text-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800"
  >
    <img
      :src="`../storage/${restaurant.logo}`"
      alt="Restaurant Logo"
      class="w-[6rem] h-auto rounded-bl-md rounded-tl-md"
    />

    <div class="flex flex-col sm:grow p-5">
      <!-- Name -->
      <h3
        class="text-xl font-medium mb-3 text-blue-500 hover:underline overflow-hidden"
      >
        #{{ restaurant.name }}
      </h3>
      <!-- Location -->
      <p class="text-sm mb-3 min-h-[2rem] overflow-hidden">
        {{ restaurant.location }}
      </p>
      <!-- Phone -->
      <p class="text-sm overflow-hidden">
        {{ restaurant.phone }}
      </p>
    </div>
    <div class="p-5 sm:flex items-end hidden">
      <button
        class="py-2 px-4 rounded-md border border-gray-300 hover:bg-blue-500 hover:text-white hover:border-none"
      >
        Show Menu
      </button>
    </div>
  </Link>
</template>
