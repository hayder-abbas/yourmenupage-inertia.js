<script setup>
import InputError from "./InputError.vue";

defineProps({
  label: String,
  error: String,
});

const model = defineModel({ required: true });
</script>

<template>
  <div>
    <label class="block mb-2 font-medium dark:text-white" v-text="label">
    </label>

    <select
      class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
      v-model="model"
    >
      <slot />
    </select>

    <!-- Error Message -->
    <InputError :message="error" class="mt-2" />
  </div>
</template>
