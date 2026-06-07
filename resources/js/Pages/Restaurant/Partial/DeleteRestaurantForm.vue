<script setup>
import DangerButton from "@/Components/Ui/DangerButton.vue";
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";

const props = defineProps({
  restaurant: Object,
});

const confirmingRestaurantDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
  password: "",
});

function confirmRestaurantDeletion() {
  confirmingRestaurantDeletion.value = true;
  nextTick(() => passwordInput.value.focus());
}

function deleteRestaurant() {
  form.delete(route("restaurants.destroy", props.restaurant), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
}

function closeModal() {
  confirmingRestaurantDeletion.value = false;
  form.clearErrors();
  form.reset();
}
</script>

<template>
  <div
    class="p-4 sm:p-8 mx-auto md:max-w-2xl dark:bg-gray-900 shadow-lg md:rounded-lg space-y-6"
  >
    <header>
      <h2 class="text-lg font-medium text-gray-900">Delete Account</h2>

      <p class="mt-1 text-sm text-gray-600">
        Once your restaurant is deleted, all of its resources and data will be
        permanently deleted. Before deleting your restaurant, please download
        any data or information that you wish to retain.
      </p>
    </header>

    <DangerButton @click="confirmRestaurantDeletion">
      Delete Restaurant
    </DangerButton>

    <Modal :show="confirmingRestaurantDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
          Are you sure you want to delete your restaurant?
        </h2>

        <p class="mt-1 text-sm text-gray-600">
          Once your restaurant is deleted, all of its resources and data will be
          permanently deleted. Please enter your password to confirm you would
          like to permanently delete your restaurant.
        </p>

        <div class="mt-6">
          <InputLabel for="password" value="Password" class="sr-only" />

          <TextInput
            id="password"
            ref="passwordInput"
            v-model="form.password"
            type="password"
            class="mt-1 block w-3/4"
            placeholder="Password"
            @keyup.enter="deleteRestaurant"
          />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

          <DangerButton
            class="ms-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="deleteRestaurant"
          >
            Delete Restaurant
          </DangerButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
