<script setup>
import TrashIcon from "../Icons/TrashIcon.vue";
import { useAppStore } from "@/Stores/AppStore";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps(["item"]);
const app = useAppStore();
const deleteForm = useForm({});

function deleteItem() {
  deleteForm.delete(route("items.destroy", props.item), {
    onSuccess() {
      app.openDeleteConfirmation = false;
      router.visit("/dashboard", {
        preserveScroll: true,
      });
    },
  });
}
</script>

<template>
  <div
    class="absolute top-0 right-0 left-0 z-50 flex justify-center items-center w-full min-h-full"
    :class="{ hidden: !app.openDeleteConfirmation }"
  >
    <div class="p-4 w-full max-w-md h-full md:h-auto">
      <div
        class="p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5"
      >
        <TrashIcon
          class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto"
        />
        <p class="mb-4 text-gray-500 dark:text-gray-300">
          Are you sure you want to delete this item?
        </p>
        <div class="flex justify-center items-center space-x-4">
          <button
            @click="app.openDeleteConfirmation = false"
            type="button"
            class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
          >
            No, cancel
          </button>
          <button
            @click="deleteItem"
            type="submit"
            class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900"
          >
            Yes, I'm sure
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
