<script setup>
import ImageInput from "@/Components/Ui/ImageInput.vue";
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import SelectInput from "@/Components/Ui/SelectInput.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import { toTimeUTC } from "@/helpers";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { reactive, ref, watch } from "vue";

const props = defineProps({
  restaurant: Object,
  cities: Object,
});

const restData = reactive(props.restaurant);
const previewLogo = restData.restLogo
  ? ref(`/storage/${restData.restLogo}`)
  : ref("/storage/default.png");

const form = useForm({
  user_id: usePage().props.auth.user.id,
  city_id: restData.cityId,
  rest_name: restData.restName,
  rest_phone: restData.restPhone,
  rest_desc: restData.restDesc,
  rest_logo: null,
  location: restData.location,
  open_at: toTimeUTC(restData.openAt),
  close_at: toTimeUTC(restData.closeAt),
  _method: "Patch",
});

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
  previewLogo.value = URL.createObjectURL(file);
}

function submit() {
  form.post(route("restaurants.update", restData));
}
</script>

<template>
  <div class="p-4 md:p-0 mb-12 mx-auto w-full md:max-w-2xl xl:max-w-4xl">
    <header>
      <h1 class="p-4 mb-4 text-center text-3xl font-bold dark:text-white">
        Edit your restaurant
      </h1>
    </header>

    <form @submit.prevent="submit">
      <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
        <div class="sm:col-span-2 text-center">
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

      <div class="flex flex-col sm:flex-row sm:justify-end gap-4">
        <SecondaryButton>
          <Link :href="route('restaurants.show', restData)" as="button">
            Cancel
          </Link>
        </SecondaryButton>

        <PrimaryButton type="submit" :disabled="form.processing">
          Save
        </PrimaryButton>
      </div>
    </form>
  </div>
</template>
