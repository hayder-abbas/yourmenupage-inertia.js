<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import FormInput from "../Ui/FormInput.vue";
import ImageInput from "../Ui/ImageInput.vue";
import SelectInput from "../Ui/SelectInput.vue";
import TextAreaInput from "../Ui/TextAreaInput.vue";
import SecondaryButton from "../Ui/SecondaryButton.vue";
import PrimaryButton from "../Ui/PrimaryButton.vue";

const props = defineProps({
  restID: Number,
  categories: Array,
});

const emit = defineEmits(["close"]);

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

const previewImage = ref("/storage/default.png");

function onChangeInput(e) {
  const file = e.target.files[0];
  if (!file) return;
  form.item_image = file;
  previewImage.value = URL.createObjectURL(file);
}

function addItem() {
  form.post(route("items.store"), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
    },
    onError: () => {
      console.error("Add item error");
    },
  });
}

function closeModal() {
  previewImage.value = "/storage/default.png";
  form.clearErrors();
  form.reset();
  emit("close");
}
</script>

<template>
  <form @submit.prevent="addItem" class="space-y-4 md:space-y-6">
    <!-- Item image -->
    <ImageInput
      @change="onChangeInput($event)"
      :src="previewImage"
      :error="form.errors.item_image"
      class="mt-6 text-center"
    />

    <!-- Item title -->
    <FormInput
      v-model.trim="form.item_title"
      inputID="itemTitle"
      label="Title"
      inputType="text"
      placeholder="Item title..."
      :error="form.errors.item_title"
    />

    <!-- Item price -->
    <FormInput
      v-model.number.trim="form.item_price"
      inputID="itemPrice"
      label="Price"
      inputType="number"
      placeholder="Item price..."
      :error="form.errors.item_price"
    />

    <!-- Item category -->
    <SelectInput
      v-model="form.category_id"
      label="Category"
      :error="form.errors.category_id"
      class="mt-6"
    >
      <option
        v-for="c in categories"
        :key="c.id"
        :value="c.id"
        v-text="c.categoryName"
      ></option>
    </SelectInput>

    <!-- Item description -->
    <TextAreaInput
      v-model="form.item_desc"
      inputID="itemDesc"
      label="Description"
      :error="form.errors.item_desc"
      placeholder="Your description here..."
      class="mt-6"
    />

    <div class="mt-6 flex justify-end">
      <SecondaryButton @click="emit('close')"> Cancel </SecondaryButton>

      <PrimaryButton
        type="submit"
        class="ms-3"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </PrimaryButton>
    </div>
  </form>
</template>
