<script setup>
import ImageInput from "@/Components/Ui/ImageInput.vue";
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import SelectInput from "@/Components/Ui/SelectInput.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";

defineEmits(["change"]);
defineProps({ restaurants: Object, categories: Object });

const form = useForm({
  restaurant_id: "",
  user_id: usePage().props.auth.user.id,
  category_id: "",
  title: "",
  price: "",
  description: "",
  image: "",
  previewImage: "",
});
const src = ref("../storage/item_image/default.png");

watch(
  () => form.restaurant_id,
  (newValue) => {
    form.restaurant_id = newValue;
  }
);

watch(
  () => form.category_id,
  (newValue) => {
    form.category_id = newValue;
  }
);

function onChangeInput(e) {
  form.image = e.target.files[0];
  form.previewImage = URL.createObjectURL(e.target.files[0]);
  src.value = form.previewImage;
}
</script>

<template>
  <section
    class="min-h-screen flex items-center justify-center bg-white dark:bg-gray-800"
  >
    <Head title="Create item" />

    <div class="p-4 md:p-0 w-full md:max-w-2xl xl:max-w-4xl">
      <header>
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
          Add a new item
        </h2>
      </header>

      <form @submit.prevent="form.post(route('items.store'))">
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6 mb-5">
          <div class="sm:col-span-2">
            <ImageInput
              @change="onChangeInput($event)"
              :src="src"
              label="Image"
            />
            <InputError class="mt-2" :message="form.errors.image" />
          </div>

          <div class="w-full">
            <InputLabel value="Item Title" for="title" />
            <TextInput
              v-model="form.title"
              type="text"
              id="title"
              placeholder="Type item title..."
              required
            />
            <InputError :message="form.errors.title" class="mt-2" />
          </div>

          <div class="w-full">
            <InputLabel value="Price" for="price" />
            <TextInput
              v-model="form.price"
              type="text"
              id="price"
              placeholder="$2999"
              required
            />
            <InputError :message="form.errors.price" class="mt-2" />
          </div>

          <div class="w-full">
            <InputLabel value="Category" for="category" />
            <SelectInput v-model="form.category_id" id="category" required>
              <option
                v-for="c in categories.data"
                :key="c.id"
                :value="c.id"
                v-text="c.name"
              ></option>
            </SelectInput>
            <InputError :message="form.errors.category_id" class="mt-2" />
          </div>

          <div class="w-full">
            <InputLabel value="Restaurants" for="restaurant" />
            <SelectInput v-model="form.restaurant_id" id="restaurant" required>
              <option
                v-for="r in restaurants.data"
                :key="r.id"
                :value="r.id"
                v-text="r.name"
              ></option>
            </SelectInput>
            <InputError :message="form.errors.restaurant_id" class="mt-2" />
          </div>

          <div class="sm:col-span-2">
            <InputLabel value="Description" for="description" />
            <TextAreaInput
              v-model="form.description"
              id="description"
              placeholder="Your description here..."
              required
            />
            <InputError :message="form.errors.description" class="mt-2" />
          </div>
        </div>

        <div class="flex items-center gap-4">
          <PrimaryButton type="submit" :disabled="form.processing">
            Add Item
          </PrimaryButton>

          <SecondaryButton>
            <Link :href="route('dashboard')" as="button"> Cancel </Link>
          </SecondaryButton>

          <Transition
            enter-active-class="transition ease-in-out"
            enter-from-class="opacity-0"
            leave-active-class="transition ease-in-out"
            leave-to-class="opacity-0"
          >
            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
              Added.
            </p>
          </Transition>
        </div>
      </form>
    </div>
  </section>
</template>
