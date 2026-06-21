<script setup>
import Notification from "@/Components/Global/Notification.vue";
import RestoreIcon from "@/Components/Icons/RestoreIcon.vue";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";
import CardItem from "@/Components/Item/CardItem.vue";
import DangerButton from "@/Components/Ui/DangerButton.vue";
import DeleteConfirmation from "@/Components/Ui/DeleteConfirmation.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { reactive, ref, watchEffect } from "vue";

defineOptions({
  layout: DashboardLayout,
});

defineProps({
  trashedItems: Array,
});

const deleteItemConfirmation = ref(false);
const form = useForm({});
let currentItem = ref(null);
const status = reactive({
  name: null,
  message: {
    "item-deleted": "Item deleted successfully!",
    "item-restored": "Item restored successfully!",
  },
});

watchEffect(() => {
  status.name = usePage().props.flash?.status;
});

function deleteItem(item) {
  deleteItemConfirmation.value = true;
  currentItem.value = item;
}

function cancelingDeleteItem() {
  deleteItemConfirmation.value = false;
}

function restoreItem(itemId) {
  form.patch(route("items.restore", itemId), {
    preserveScroll: true,
  });
}
</script>

<template>
  <div>
    <Head title="Trashed Items" />

    <!-- Notification Message -->
    <Notification
      :status="status.name"
      :message="status.message[status.name]"
      @closeNotification="status.name = null"
    />

    <section class="p-4 lg:col-span-4 xl:col-span-6">
      <h2 class="font-bold text-3xl mb-6 dark:text-white">Trashed Items</h2>
      <!-- Items -->
      <div class="grid xl:grid-cols-2 gap-4">
        <CardItem v-for="item in trashedItems" :key="item.id" :item="item">
          <div class="flex gap-2">
            <PrimaryButton @click="restoreItem(item)">
              <RestoreIcon class="w-5 h-5 mr-1" />
              Restore
            </PrimaryButton>

            <DangerButton @click="deleteItem(item)">
              <TrashIcon class="w-4 h-4 mr-1" />
              Delete
            </DangerButton>
          </div>
        </CardItem>

        <!-- Delete Item Modal -->
        <DeleteConfirmation
          :show="deleteItemConfirmation"
          @close="cancelingDeleteItem"
          :item="currentItem"
          :forceDelete="true"
        />
      </div>
    </section>
  </div>
</template>
