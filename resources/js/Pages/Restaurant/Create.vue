<script setup>
import CreateRestaurantForm from "@/Components/Forms/CreateRestaurantForm.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
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

      <CreateRestaurantForm
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
        <div class="flex items-center gap-4">
          <PrimaryButton type="submit" :disabled="form.processing">
            Create
          </PrimaryButton>

          <SecondaryButton>
            <Link :href="route('dashboard')" as="button"> Cancel </Link>
          </SecondaryButton>
        </div>
      </CreateRestaurantForm>
    </div>
  </section>
</template>
