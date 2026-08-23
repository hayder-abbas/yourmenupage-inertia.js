<script setup>
import { useForm } from "@inertiajs/vue3";
import TrashIcon from "../Icons/TrashIcon.vue";
import CameraIcon from "../Icons/CameraIcon.vue";
import InputError from "./InputError.vue";

defineProps({
  src: String,
  error: String,
});

const emit = defineEmits(["change"]);

const form = useForm({});

function resetProfileImage() {
  if (confirm("Are you sure?")) {
    form.post(route("reset.profile.image"), {
      preserveScroll: true,
    });
  }
}
</script>

<template>
  <div>
    <label for="imageInput" class="relative inline-block">
      <div
        class="absolute flex items-center justify-center z-10 bg-black bg-opacity-25 hover:bg-opacity-35 w-full h-full rounded-full cursor-pointer"
      >
        <CameraIcon class="w-10 text-white" />
      </div>

      <img
        :src="src"
        alt="Image"
        class="w-32 h-32 rounded-full border-2 border-gray-300 dark:border-gray-500 bg-gray-50 dark:bg-gray-600"
      />

      <input
        id="imageInput"
        type="file"
        accept="image/*"
        @input="emit('change', $event)"
        hidden
      />

      <!-- Reset Image Button -->
      <button
        type="button"
        v-if="$page.component === 'Profile/Edit'"
        @click.prevent="resetProfileImage"
        class="absolute bottom-3 left-[6.3em] z-20 p-1 bg-gray-300 hover:bg-gray-400 rounded-full cursor-pointer"
      >
        <TrashIcon class="text-red-500 w-5 h-5" />
      </button>
    </label>

    <!-- Image Error Message -->
    <InputError :message="error" class="mt-2" />
  </div>
</template>
