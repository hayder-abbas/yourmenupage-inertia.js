<script setup>
import { Link } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import PhoneIcon from "../Icons/PhoneIcon.vue";
import MapPinIcon from "../Icons/MapPinIcon.vue";

const props = defineProps({
  restaurant: Object,
});

const restData = reactive(props.restaurant);
const imgSrc = restData.restLogo
  ? ref(`../storage/${restData.restLogo}`)
  : ref("../storage/default.png");
</script>

<template>
  <Link
    :href="route('restaurants.show', restData)"
    class="w-full flex rounded-md border border-gray-200 dark:border-gray-600 hover:shadow-[0_0_20px_4px_#eee] dark:hover:shadow-[0_0_20px_4px_#333] dark:text-white dark:bg-gray-900 dark:hover:bg-gray-800"
  >
    <img
      :src="imgSrc"
      :alt="restData.restName"
      class="w-[6rem] sm:w-[10rem] aspect-square object-cover h-auto rounded-s-md"
      loading="lazy"
    />

    <div class="flex flex-col text-xl sm:grow p-5">
      <div class="font-bold mb-2 text-blue-500">
        {{ restData.restName }}
      </div>
      <div class="flex items-center mb-2">
        <MapPinIcon class="w-4 h-4 mr-2" />
        {{ restData.location }}
      </div>
      <div class="flex items-center mb-2">
        <PhoneIcon class="w-4 h-4 mr-2" />
        {{ restData.restPhone }}
      </div>
    </div>

    <div class="w-32 p-4">
      <div
        class="text-center text-sm font-bold px-2 py-1 rounded-xl"
        :class="
          restData.isOpen
            ? 'bg-green-100 text-green-600'
            : 'bg-red-100 text-red-600'
        "
      >
        {{ restData.isOpen ? "Open now" : "Closed" }}
      </div>
    </div>
  </Link>
</template>
