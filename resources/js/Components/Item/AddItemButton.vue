<script setup>
import PlusIcon from "@/Components/Icons/PlusIcon.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import AddItemForm from "../Forms/AddItemForm.vue";
import { ref } from "vue";

defineProps({
  restID: Number,
  categories: Array,
});

const openingAddItemForm = ref(false);

const openModal = () => (openingAddItemForm.value = true);

const closeModal = () => (openingAddItemForm.value = false);
</script>

<template>
  <div class="flex">
    <PrimaryButton class="w-full" @click="openModal">
      <PlusIcon class="w-5 h-5 mr-2" /> Add Item
    </PrimaryButton>

    <Modal :show="openingAddItemForm" @close="closeModal">
      <div class="p-6">
        <h2
          class="text-lg text-center font-medium text-gray-900 dark:text-white"
        >
          Add a new item
        </h2>

        <AddItemForm
          @close="closeModal"
          :restID="restID"
          :categories="categories"
        />
      </div>
    </Modal>
  </div>
</template>
