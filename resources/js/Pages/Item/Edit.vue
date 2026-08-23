<script setup>
import EditItemForm from "@/Components/Forms/EditItemForm.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";

defineOptions({
  layout: AppLayout,
});

const props = defineProps({
  item: Object,
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
  form.post(route("items.update", props.item));
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

      <EditItemForm
        @submit.prevent="updateItem"
        @onChange="onChangeInput($event)"
        v-model:itemTitle="form.item_title"
        v-model:itemPrice="form.item_price"
        v-model:categoryID="form.category_id"
        v-model:itemDesc="form.item_desc"
        :errors="form.errors"
        :categories="categories"
        :previewImage="previewImage"
      >
        <div class="flex justify-end items-center p-4 pt-0 pb-8 space-x-4">
          <Link :href="route('restaurants.show', item.restaurantId)">
            <SecondaryButton> Cancel </SecondaryButton>
          </Link>

          <PrimaryButton
            type="submit"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Save
          </PrimaryButton>
        </div>
      </EditItemForm>
    </div>
  </section>
</template>
