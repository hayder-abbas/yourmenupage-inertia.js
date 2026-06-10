<script setup>
import ImageInput from "@/Components/Ui/ImageInput.vue";
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import SelectInput from "@/Components/Ui/SelectInput.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";

defineOptions({
  layout: AppLayout,
});

defineProps({
  cities: Object,
});

const form = useForm({
  rest_name: "",
  rest_phone: "",
  rest_desc: "",
  rest_logo: "",
  location: "",
  open_at: "",
  close_at: "",
  user_id: usePage().props.auth.user.id,
  city_id: null,
});

let previewLogo = ref("/storage/default.png");

watch(
  () => form.city_id,
  (newValue) => {
    form.city_id = newValue;
  },
);

function onChangeInput(e) {
  const file = e.target.files[0];
  if (!file) return;
  form.rest_logo = file;
  previewLogo.value = URL.createObjectURL(e.target.files[0]);
}

function submit() {
  form.post(route("restaurants.store"));
}
</script>

<template>
  <!-- Create Restaurant -->
  <section
    class="min-h-screen py-4 lg:py-8 flex items-center justify-center bg-white dark:bg-gray-800"
  >
    <Head title="Create Restaurant" />

    <div class="p-4 md:p-0 w-full md:max-w-2xl xl:max-w-4xl">
      <header>
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
          Create Restaurant
        </h2>
      </header>

      <form @submit.prevent="submit">
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
          <div class="sm:col-span-2">
            <ImageInput
              @change="onChangeInput($event)"
              :src="previewLogo"
              alt="Restaurant Logo"
            />
            <InputError class="mt-2" :message="form.errors.rest_logo" />
          </div>

          <div class="w-full">
            <InputLabel value="Restaurant Name" for="rest_name" />
            <TextInput
              v-model="form.rest_name"
              type="text"
              id="rest_name"
              placeholder="Type restaurant name..."
            />
            <InputError :message="form.errors.rest_name" class="mt-2" />
          </div>

          <div class="w-full">
            <InputLabel value="Phone" for="phone" />
            <TextInput
              v-model="form.rest_phone"
              id="phone"
              placeholder="Restaurant phone..."
            />
            <InputError :message="form.errors.rest_phone" class="mt-2" />
          </div>

          <div class="w-full">
            <InputLabel value="Location" for="location" />
            <TextInput
              v-model="form.location"
              id="location"
              placeholder="Your location here..."
            />
            <InputError :message="form.errors.location" class="mt-2" />
          </div>

          <div>
            <InputLabel value="City" for="city" />
            <SelectInput v-model="form.city_id" id="city">
              <option
                v-for="c in cities"
                :key="c.id"
                :value="c.id"
                v-text="c.cityName"
              ></option>
            </SelectInput>
            <InputError :message="form.errors.city_id" class="mt-2" />
          </div>

          <div class="w-full">
            <InputLabel value="Open at" for="open_at" />
            <TextInput type="time" id="open_at" v-model="form.open_at" />
            <InputError :message="form.errors.open_at" class="mt-2" />
          </div>

          <div class="w-full">
            <InputLabel value="Close at" for="close_at" />
            <TextInput type="time" id="close_at" v-model="form.close_at" />
            <InputError :message="form.errors.close_at" class="mt-2" />
          </div>

          <div class="sm:col-span-2 mb-5">
            <InputLabel value="Description" for="rest_desc" />
            <TextAreaInput
              v-model="form.rest_desc"
              id="rest_desc"
              placeholder="Your description here..."
            />
            <InputError :message="form.errors.rest_desc" class="mt-2" />
          </div>
        </div>

        <div class="flex items-center gap-4">
          <PrimaryButton type="submit" :disabled="form.processing">
            Create
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
              Created...
            </p>
          </Transition>
        </div>
      </form>
    </div>
  </section>
</template>
