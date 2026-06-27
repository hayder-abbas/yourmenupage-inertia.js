<script setup>
import { ref, watch } from "vue";
import { useDebounceFn } from "@vueuse/core";
import { Link, router } from "@inertiajs/vue3";
import SearchIcon from "../Icons/SearchIcon.vue";

const props = defineProps({
  restaurants: Array,
  filters: Object,
});

const search = ref();
const isSearchResult = ref(false);

watch(
  () => search.value,
  useDebounceFn((value) => {
    if (value !== "") {
      router.get(
        "/",
        { search: value },
        { preserveState: true, preserveScroll: true, replace: true },
      );
      isSearchResult.value = true;
    } else {
      isSearchResult.value = false;
    }
  }, 500),
);
</script>

<template>
  <div>
    <form class="max-w-2xl mx-auto relative">
      <div>
        <div class="absolute inset-y-0 start-0 flex items-center ps-4">
          <SearchIcon class="w-4 h-4 text-gray-500 dark:text-gray-50" />
        </div>

        <input
          v-model="search"
          type="search"
          class="block w-full p-4 ps-12 text-gray-900 dark:placeholder:text-gray-50 rounded-lg bg-gray-50 dark:bg-gray-400 focus:outline-none focus:border-transparent"
          placeholder="Search Restaurants..."
        />
      </div>

      <div
        v-if="isSearchResult"
        class="bg-gray-50 dark:bg-gray-400 p-2 rounded-md absolute top-16 left-0 w-full"
      >
        <Link
          v-for="restaurant in restaurants"
          :key="restaurant.id"
          :href="route('restaurants.show', restaurant)"
          class="block p-2 text-left hover:bg-gray-200 dark:hover:bg-gray-400 rounded-sm"
        >
          <!-- Restaurant name -->
          <div v-text="restaurant.restName" class="font-bold"></div>
          <!-- Restaurant location -->
          <div
            v-text="restaurant.location"
            class="text-sm text-gray-500 dark:text-gray-700"
          ></div>
        </Link>
      </div>
    </form>
  </div>
</template>
