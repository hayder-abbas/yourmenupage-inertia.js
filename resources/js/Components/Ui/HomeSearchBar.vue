<script setup>
import SearchIcon from "../Icons/SearchIcon.vue";
import { ref, watch } from "vue";
import { useDebounceFn } from "@vueuse/core";
import { Link, router } from "@inertiajs/vue3";

const props = defineProps({
  restaurants: Object,
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
        <div
          class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
        >
          <SearchIcon class="w-4 h-4 text-gray-500 dark:text-gray-50" />
        </div>
        <input
          v-model="search"
          type="search"
          class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 dark:border-gray-500 dark:placeholder:text-gray-50 rounded-lg bg-gray-50 dark:bg-gray-400 focus:ring-blue-500 focus:border-blue-500"
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
          :href="route('restaurant.show', restaurant)"
          class="block p-2 text-left hover:bg-blue-300 dark:hover:bg-gray-500 rounded-sm"
        >
          <span class="block font-bold text-blue-600 dark:text-gray-50">
            {{ restaurant.name }}
          </span>
          <span class="text-sm text-gray-500 dark:text-gray-700">
            {{ restaurant.location }}
          </span>
        </Link>
      </div>
    </form>
  </div>
</template>
