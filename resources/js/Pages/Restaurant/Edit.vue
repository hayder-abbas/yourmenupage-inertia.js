<script setup>
import ImageInput from "@/Components/Ui/ImageInput.vue";
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import TextAreaInput from "@/Components/Ui/TextAreaInput.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
  restaurant: {
    type: Object,
    required: true,
  },
});

const user = usePage().props.restaurant.data;
const form = useForm({
  name: user.name,
  description: user.description,
  location: user.location,
  phone: user.phone,
  logo: null,
  open_at: user.openAt,
  close_at: user.closeAt,
  previewLogo: null,
  _method: "Patch",
});
let src = ref(`../../storage/${user.logo}`);

function onChangeInput(e) {
  form.logo = e.target.files[0];
  form.previewLogo = URL.createObjectURL(e.target.files[0]);
  src.value = form.previewLogo;
}
</script>

<template>
  <section
    class="min-h-screen flex items-center justify-center bg-white dark:bg-gray-800"
  >
    <Head title="Edit Restaurant" />

    <div class="p-4 md:p-0 w-full md:max-w-2xl xl:max-w-4xl">
      <header>
        <h1 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
          Edit your restaurant
        </h1>
      </header>

      <form
        @submit.prevent="
          form.post(route('restaurants.update', restaurant.data))
        "
      >
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
          <div class="sm:col-span-2">
            <ImageInput
              @change="onChangeInput($event)"
              alt="Restaurant logo"
              :src="src"
            />
            <InputError class="mt-2" :message="form.errors.logo" />
          </div>

          <div class="w-full">
            <InputLabel value="Name" for="name" />
            <TextInput
              v-model="form.name"
              type="text"
              id="name"
              placeholder="Type restaurant name..."
              required
            />
            <InputError :message="form.errors.name" class="mt-2" />
          </div>

          <div class="w-full">
            <InputLabel value="Phone" for="phone" />
            <TextInput
              v-model="form.phone"
              type="text"
              id="phone"
              placeholder="Phone number"
              required
            />
            <InputError :message="form.errors.phone" class="mt-2" />
          </div>

          <div class="sm:col-span-2">
            <InputLabel value="Location" for="location" />
            <TextInput
              v-model="form.location"
              type="text"
              id="location"
              placeholder="Restaurant location"
              required
            />
            <InputError :message="form.errors.location" class="mt-2" />
          </div>

          <div class="w-full">
            <InputLabel value="Open at" for="open_at" />
            <TextInput
              v-model="form.open_at"
              type="time"
              id="open_at"
              required
            />
            <InputError :message="form.errors.open_at" class="mt-2" />
          </div>

          <div class="w-full">
            <InputLabel value="Close at" for="close_at" />
            <TextInput
              v-model="form.close_at"
              type="time"
              id="close_at"
              required
            />
            <InputError :message="form.errors.close_at" class="mt-2" />
          </div>

          <div class="sm:col-span-2 mb-5">
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
            Save
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
              Saved.
            </p>
          </Transition>
        </div>
      </form>
    </div>
  </section>
</template>
