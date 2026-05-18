<script setup>
import ImageInput from "@/Components/Ui/ImageInput.vue";
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import NumberInput from "@/Components/Ui/NumberInput.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import SelectInput from "@/Components/Ui/SelectInput.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";

defineOptions({
  layout: AppLayout,
});

const props = defineProps({
  item: Object,
  restaurants: Array,
  categories: Array,
});

const previewImage = props.item.itemImage
  ? ref(`/storage/${props.item.itemImage}`)
  : ref("/storage/default.png");

const form = useForm({
  item_title: props.item.itemTitle,
  item_price: props.item.itemPrice,
  item_desc: props.item.itemDesc,
  item_image: null,
  restaurant_id: props.item.restaurantId,
  category_id: props.item.categoryId,
  _method: "PATCH",
});

function onChangeInput(e) {
  const file = e.target.files[0];
  if (!file) return;
  form.item_image = file;
  previewImage.value = URL.createObjectURL(file);
}

watch(
  () => form.category_id,
  (newValue) => {
    form.category_id = newValue;
  },
);

function updateItem() {
  form.post(route("item.update", props.item));
}
</script>

<template>
  <section class="min-h-screen mx-auto w-full md:max-w-xl dark:bg-gray-800">
    <Head :title="`Edit ${item.itemTitle}`" />

    <div class="">
      <header>
        <h2 class="text-4xl text-center font-bold p-4 my-6 dark:text-white">
          Edit your item
        </h2>
      </header>

      <form @submit.prevent="updateItem">
        <div class="p-4 flex flex-col items-center">
          <div class="w-full mb-4 text-center">
            <ImageInput
              @change="onChangeInput($event)"
              :src="previewImage"
              label="Image"
            />
            <InputError :message="form.errors.item_image" class="mt-2" />
          </div>

          <div class="w-full mb-4">
            <InputLabel for="item_title" value="Item title" />
            <TextInput
              id="item_title"
              ref="itemTitle"
              v-model="form.item_title"
              class="mt-1 block w-3/4"
              placeholder="Item title..."
            />
            <InputError :message="form.errors.item_title" class="mt-2" />
          </div>

          <div class="w-full mb-4">
            <InputLabel for="item_price" value="Item price" />
            <NumberInput
              id="item_price"
              v-model="form.item_price"
              class="mt-1 block w-3/4"
              placeholder="Item price..."
            />
            <InputError :message="form.errors.item_price" class="mt-2" />
          </div>

          <div class="w-full mb-4">
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

          <div class="w-full mb-4">
            <InputLabel for="item_desc" value="Item description" />
            <TextAreaInput
              v-model="form.item_desc"
              id="item_desc"
              placeholder="Your description here..."
            />
            <InputError :message="form.errors.item_desc" class="mt-2" />
          </div>
        </div>

        <div class="flex justify-end items-center p-4 mb-4">
          <Link :href="route('restaurant.show', item.restaurantId)">
            <SecondaryButton> Cancel </SecondaryButton>
          </Link>

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
    </div>
  </section>
</template>
