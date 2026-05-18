<script setup>
import EditIcon from "@/Components/Icons/EditIcon.vue";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/Ui/DangerButton.vue";
import DeleteConfirmation from "@/Components/Ui/DeleteConfirmation.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import { useAppStore } from "@/Stores/AppStore";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  item: Object,
});

const app = useAppStore();
const openingShowItemForm = ref(false);
const imgSrc = props.item.itemImage
  ? ref(`../storage/${props.item.itemImage}`)
  : ref("../storage/default.png");

function openShowItemForm() {
  openingShowItemForm.value = true;
}

function closeModal() {
  openingShowItemForm.value = false;
}
</script>

<template>
  <div class="flex">
    <PrimaryButton class="w-full" @click="openShowItemForm">
      Show
    </PrimaryButton>

    <Modal :show="openingShowItemForm" @close="closeModal">
      <div
        class="relative flex justify-center items-center min-h-screen p-4 bg-gray-50 dark:bg-gray-700"
      >
        <div class="w-full md:w-2xl lg:w-6xl">
          <div class="w-full grid lg:grid-cols-3 rounded-lg">
            <div class="w-full shadow-xl lg:col-span-1">
              <img
                :src="imgSrc"
                :alt="item.itemTitle"
                class="w-full rounded-md object-cover h-full aspect-square"
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
                <span class="text-sm text-gray-500 dark:text-gray-400"
                  >dinar</span
                >
              </div>

              <div
                class="mb-4 font-semibold text-gray-500 py-3 border border-b-gray-400 border-l-transparent border-r-transparent border-t-transparent sm:mb-5 dark:text-gray-400"
              >
                {{ item.itemDesc }}
              </div>

              <div class="flex flex-col">
                <div
                  class="mb-4 font-semibold py-3 border border-b-gray-400 border-l-transparent border-r-transparent border-t-transparent text-gray-500 sm:mb-5 dark:text-gray-400"
                >
                  <!-- #{{ item.category.name }} -->
                  Category name
                </div>
              </div>

              <div class="flex items-center justify-between space-x-4">
                <div class="flex items-center gap-4">
                  <PrimaryButton type="submit">
                    <Link
                      :href="route('item.edit', item)"
                      class="flex items-center"
                    >
                      <EditIcon class="mr-1 -ml-1 w-4 h-4" />
                      Edit
                    </Link>
                  </PrimaryButton>

                  <SecondaryButton @click="closeModal"> Close </SecondaryButton>

                  <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                  >
                  </Transition>
                </div>

                <DangerButton
                  @click="
                    app.openDeleteConfirmation = !app.openDeleteConfirmation
                  "
                >
                  <TrashIcon class="w-4 h-4 mr-1.5 -ml-1" />
                  Delete
                </DangerButton>
              </div>

              <!-- <SecondaryButton onclick="history.back()"> Back </SecondaryButton> -->
            </div>
          </div>
        </div>
        <!-- Delete Modal -->
        <DeleteConfirmation :item="item" />
      </div>
    </Modal>
  </div>
</template>
