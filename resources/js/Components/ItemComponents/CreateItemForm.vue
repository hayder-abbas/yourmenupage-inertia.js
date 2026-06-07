<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import NumberInput from "@/Components/Ui/NumberInput.vue";
import ImageInput from "@/Components/Ui/ImageInput.vue";
import SelectInput from "@/Components/Ui/SelectInput.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import PlusIcon from "@/Components/Icons/PlusIcon.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref, watch } from "vue";

const props = defineProps({
  restID: Number,
  categories: Array,
});

const openingAddItemForm = ref(false);
const itemTitle = ref(null);
const previewImage = ref("/storage/default.png");
const form = useForm({
  item_title: "",
  item_price: 0,
  item_desc: "",
  item_image: null,
  restaurant_id: props.restID,
  category_id: "",
});

watch(
  () => form.category_id,
  (newValue) => {
    form.category_id = newValue;
  },
);

function onChangeInput(e) {
  const file = e.target.files[0];
  if (!file) return;
  form.item_image = file;
  previewImage.value = URL.createObjectURL(file);
}

function openAddItemForm() {
  openingAddItemForm.value = true;
  nextTick(() => itemTitle.value.focus());
}

function addItem() {
  form.post(route("items.store"), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      form.reset();
      previewImage.value = "/storage/default.png";
    },
    onError: () => {
      itemTitle.value.focus();
    },
  });
}

function closeModal() {
  openingAddItemForm.value = false;
  previewImage.value = "/storage/default.png";
  form.clearErrors();
  form.reset();
}
</script>

<template>
  <div class="flex">
    <PrimaryButton class="w-full" @click="openAddItemForm">
      <PlusIcon class="w-5 h-5 mr-2" /> Add Item
    </PrimaryButton>

    <Modal :show="openingAddItemForm" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
          Add a new Item
        </h2>
        <div>
          <div class="mt-6">
            <ImageInput
              @change="onChangeInput($event)"
              :src="previewImage"
              label="Image"
            />
            <InputError :message="form.errors.item_image" class="mt-2" />
          </div>

          <div class="mt-6">
            <InputLabel for="item_title" value="Item title" />
            <TextInput
              id="item_title"
              ref="itemTitle"
              v-model="form.item_title"
              class="mt-1 block w-3/4"
              placeholder="Item title..."
              @keyup.enter="addItem"
            />
            <InputError :message="form.errors.item_title" class="mt-2" />
          </div>

          <div class="mt-6">
            <InputLabel for="item_price" value="Item price" />
            <NumberInput
              id="item_price"
              v-model="form.item_price"
              class="mt-1 block w-3/4"
              placeholder="Item price..."
            />
            <InputError :message="form.errors.item_price" class="mt-2" />
          </div>

          <div class="mt-6">
            <InputLabel for="category" value="Category" />
            <SelectInput v-model="form.category_id" id="category">
              <option
                v-for="c in categories"
                :key="c.id"
                :value="c.id"
                v-text="c.categoryName"
              ></option>
            </SelectInput>
            <InputError :message="form.errors.category_id" class="mt-2" />
          </div>

          <div class="mt-6">
            <InputLabel for="item_desc" value="Item description" />
            <TextAreaInput
              v-model="form.item_desc"
              id="item_desc"
              placeholder="Your description here..."
            />
            <InputError :message="form.errors.item_desc" class="mt-2" />
          </div>
        </div>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

          <PrimaryButton
            class="ms-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="addItem"
          >
            Add
          </PrimaryButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
