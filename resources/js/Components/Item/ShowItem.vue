<script setup>
import EditIcon from "@/Components/Icons/EditIcon.vue";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/Ui/DangerButton.vue";
import DeleteConfirmation from "@/Components/Ui/DeleteConfirmation.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import CloseIcon from "../Icons/CloseIcon.vue";

const props = defineProps({
  item: Object,
  can: Object,
});

const openingShowItemForm = ref(false);
const deleteItemConfirmation = ref(false);
const imgSrc = props.item.itemImage
  ? ref(`../storage/${props.item.itemImage}`)
  : ref("../storage/default.png");

function openShowItemForm() {
  openingShowItemForm.value = true;
}

function closeModal() {
  openingShowItemForm.value = false;
}

function cancelingDeleteItem() {
  deleteItemConfirmation.value = false;
}
</script>

<template>
  <div class="flex">
    <PrimaryButton class="w-full" @click="openShowItemForm">
      Show
    </PrimaryButton>

    <Modal :show="openingShowItemForm" @close="closeModal">
      <div class="relative flex min-h-screen sm:p-4 dark:bg-gray-700">
        <div class="w-full md:w-2xl lg:w-6xl rounded-lg">
          <div class="relative w-full rounded-t-md">
            <img
              :src="imgSrc"
              :alt="item.itemTitle"
              class="w-full h-full rounded-t-md aspect-video"
              loading="lazy"
            />
            <div
              class="absolute top-0 left-0 bg-gradient-to-b rounded-t-md from-gray-800 w-full h-[50%] z-10"
            >
              <div @click="closeModal" class="p-2 w-fit cursor-pointer">
                <CloseIcon class="w-10 h-10 text-white z-30" />
              </div>
            </div>
          </div>

          <div class="py-8 px-4 lg:py-16 lg:col-span-2">
            <h2 class="text-xl font-bold text-gray-900 mb-2 dark:text-white">
              {{ item.itemTitle }}
            </h2>

            <div class="text-gray-600 mb-2 dark:text-white">
              {{ item.itemDesc }}
            </div>

            <div class="font-bold text-xl mb-2 text-gray-900 dark:text-white">
              {{ item.itemPrice }}
              <span class="text-sm text-gray-600 dark:text-white"> dinar </span>
            </div>

            <!-- Actions buttons -->
            <div class="flex items-center justify-end gap-2 py-6">
              <DangerButton
                v-if="can.manageItems"
                @click="deleteItemConfirmation = true"
              >
                <TrashIcon class="w-5 h-5 mr-1" />
                Trash
              </DangerButton>

              <PrimaryButton v-if="can.manageItems" type="submit">
                <Link
                  :href="route('items.edit', item)"
                  class="flex items-center"
                >
                  <EditIcon class="mr-1 w-5 h-5" />
                  Edit
                </Link>
              </PrimaryButton>
            </div>
          </div>
        </div>

        <!-- Delete Item Modal -->
        <DeleteConfirmation
          :show="deleteItemConfirmation"
          @close="cancelingDeleteItem"
          :item="item"
        />
      </div>
    </Modal>
  </div>
</template>
