<script setup>
import SearchIcon from "../Icons/SearchIcon.vue";
import { ref, watch } from "vue";
import { useDebounceFn } from "@vueuse/core";
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
  restaurants: Array,
  filters: Object,
});

let search = ref();
let searchList = ref(false);

watch(
  () => search.value,
  useDebounceFn((value) => {
    if (value !== "") {
      router.get(
        "/",
        { search: value },
        { preserveState: true, preserveScroll: true, replace: true },
      );
      searchList.value = true;
    } else {
      searchList.value = false;
    }
  }, 500),
);
</script>

<template>
  <div>
    <form class="max-w-xl mx-auto relative">
      <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3">
          <SearchIcon class="w-4 h-4 text-gray-500 dark:text-gray-50" />
        </div>
        <input
          v-model="search"
          type="search"
          class="block w-full p-4 ps-10 text-sm text-gray-900 dark:placeholder:text-gray-50 rounded-lg bg-gray-50 dark:bg-gray-400 focus:outline-none focus:border-transparent"
          placeholder="Search Restaurants..."
        />
      </div>

      <div
        v-if="searchList"
        class="bg-gray-50 dark:bg-gray-400 p-2 rounded-md absolute top-14 left-0 w-full"
      >
        <Link
          v-for="restaurant in restaurants"
          :key="restaurant.id"
          :href="route('restaurants.show', restaurant)"
          class="block p-2 text-left hover:bg-gray-200 dark:hover:bg-gray-400 rounded-sm"
        >
          <span class="block font-bold">
            {{ restaurant.restName }}
          </span>
          <span class="text-sm text-gray-500 dark:text-gray-700">
            {{ restaurant.location }}
          </span>
        </Link>
      </div>
    </form>
  </div>
</template>
