<script setup>
import ImageInput from "@/Components/Ui/ImageInput.vue";
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import SelectInput from "@/Components/Ui/SelectInput.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
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
  <div class="p-4 md:p-0 mb-12 mx-auto md:max-w-2xl">
    <header>
      <h1 class="p-4 mb-4 text-center text-3xl font-bold dark:text-white">
        Edit your restaurant
      </h1>
    </header>

    <form @submit.prevent="submit">
      <div class="flex flex-col gap-4 mb-6">
        <div class="text-center">
          <ImageInput
            @change="onChangeInput($event)"
            alt="Restaurant logo"
            :src="previewLogo"
          />
          <InputError class="mt-2" :message="form.errors.rest_logo" />
        </div>

        <div>
          <InputLabel value="Restaurant Name" for="rest_name" />
          <TextInput
            v-model="form.rest_name"
            type="text"
            id="rest_name"
            placeholder="Type restaurant name..."
            required
          />
          <InputError :message="form.errors.rest_name" class="mt-2" />
        </div>

        <div>
          <InputLabel value="Phone" for="phone" />
          <TextInput id="phone" v-model="form.rest_phone" />
          <InputError :message="form.errors.rest_phone" class="mt-2" />
        </div>

        <div>
          <InputLabel value="City" for="city" />
          <SelectInput v-model="form.city_id" id="city">
            <option
              v-for="(c, index) in cities"
              :key="index"
              :value="c.id"
              v-text="c.cityName"
            ></option>
          </SelectInput>
          <InputError :message="form.errors.city_id" class="mt-2" />
        </div>

        <div class="sm:col-span-2 mb-5">
          <InputLabel value="Description" for="rest_desc" />
          <TextAreaInput
            v-model="form.rest_desc"
            id="rest_desc"
            placeholder="Your description here..."
            required
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

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
            Saved...
          </p>
        </Transition>
      </div>
    </form>
  </div>
</template>
