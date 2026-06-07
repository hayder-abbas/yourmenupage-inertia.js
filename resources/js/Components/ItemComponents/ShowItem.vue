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
          <div class="w-full rounded-t-md mb-6">
            <img
              :src="imgSrc"
              :alt="item.itemTitle"
              class="w-full h-full rounded-t-md object-cover aspect-video"
              loading="lazy"
            />
          </div>

          <div class="py-8 px-4 lg:py-16 lg:col-span-2">
            <h2
              class="mb-2 text-xl font-bold leading-none text-gray-900 py-3 border border-b-gray-400 border-l-transparent border-r-transparent border-t-transparent md:text-2xl dark:text-white"
            >
              {{ item.itemTitle }}
            </h2>

            <div
              class="mb-4 text-xl font-bold leading-none text-gray-900 py-3 border border-b-gray-400 border-l-transparent border-r-transparent border-t-transparent md:text-2xl dark:text-white"
            >
              {{ item.itemPrice }}
              <span class="text-sm text-gray-500 dark:text-gray-400">
                dinar
              </span>
            </div>

            <div
              class="mb-4 font-semibold text-gray-500 py-3 border border-b-gray-400 border-l-transparent border-r-transparent border-t-transparent sm:mb-5 dark:text-gray-400"
            >
              {{ item.itemDesc }}
            </div>

            <div class="flex flex-col mb-8">
              <div
                class="font-semibold py-3 border border-b-gray-400 border-l-transparent border-r-transparent border-t-transparent text-gray-500 sm:mb-5 dark:text-gray-400"
              >
                <!-- #{{ item.category.name }} -->
                Category name
              </div>
            </div>

            <div class="flex items-center justify-between">
              <div class="flex items-center gap-4">
                <PrimaryButton v-if="can.manageItems" type="submit">
                  <Link
                    :href="route('items.edit', item)"
                    class="flex items-center"
                  >
                    <EditIcon class="mr-1 w-5 h-5" />
                    Edit
                  </Link>
                </PrimaryButton>

                <SecondaryButton @click="closeModal"> Close </SecondaryButton>
              </div>

              <DangerButton
                v-if="can.manageItems"
                @click="deleteItemConfirmation = true"
              >
                <TrashIcon class="w-5 h-5 mr-1" />
                Trash
              </DangerButton>
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
