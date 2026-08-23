<script setup>
import EditRestaurantForm from "@/Components/Forms/EditRestaurantForm.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
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

    <EditRestaurantForm
      @submit.prevent="submit"
      @onChange="onChangeInput($event)"
      v-model:restName="form.rest_name"
      v-model:restPhone="form.rest_phone"
      v-model:location="form.location"
      v-model:cityID="form.city_id"
      v-model:openAt="form.open_at"
      v-model:closeAt="form.close_at"
      v-model:restDesc="form.rest_desc"
      :errors="form.errors"
      :cities="cities"
      :previewLogo="previewLogo"
    >
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
    </EditRestaurantForm>
  </div>
</template>
