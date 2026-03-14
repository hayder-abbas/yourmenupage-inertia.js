<script setup>
import TrashIcon from "../Icons/TrashIcon.vue";
import CameraIcon from "../Icons/CameraIcon.vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
  src: String,
  alt: String,
  resetRoute: String,
});

const form = useForm({});

function resetInput() {
  form.post(route(props.resetRoute), {
    onSuccess: () => router.reload(),
  });
}
</script>

<template>
  <label for="image" class="relative inline-block">
    <div
      class="absolute flex items-center justify-center z-10 bg-black bg-opacity-25 hover:bg-opacity-35 w-full h-full rounded-full cursor-pointer"
    >
      <CameraIcon class="w-10 text-white" />
    </div>

    <img
      :src="src"
      :alt="alt"
      class="w-32 h-32 rounded-full border-2 border-gray-300 dark:border-gray-500 bg-gray-50 dark:bg-gray-600"
    />

    <input
      id="image"
      type="file"
      accept="image/*"
      @input="$emit('change', $event)"
      hidden
    />

    <div
      v-if="$page.component === 'Profile/Edit'"
      @click.prevent="resetInput"
      class="absolute bottom-3 left-[6.3em] z-20 p-1 bg-gray-300 hover:bg-gray-400 rounded-full cursor-pointer"
    >
      <TrashIcon class="text-red-500 w-5 h-5" />
    </div>
  </label>
</template>
