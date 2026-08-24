<script setup>
import { onMounted, ref } from "vue";
import InputError from "./InputError.vue";

defineProps({
  inputID: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: false,
  },
  inputType: {
    type: String,
    required: true,
  },
  placeholder: {
    type: String,
    required: false,
  },
  error: {
    type: String,
    required: true,
    default: () => "",
  },
});

const model = defineModel({ required: true });
const input = ref(null);

onMounted(() => {
  if (input.value?.hasAttribute("autofocus")) {
    input.value?.focus();
  }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
  <div class="w-full">
    <label
      :for="inputID"
      v-text="label"
      class="block mb-2 font-medium dark:text-white"
    ></label>

    <input
      v-model="model"
      :id="inputID"
      :type="inputType"
      :placeholder="placeholder"
      ref="input"
      class="bg-gray-50 mb-2 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
    />

    <InputError :message="error" />
  </div>
</template>
