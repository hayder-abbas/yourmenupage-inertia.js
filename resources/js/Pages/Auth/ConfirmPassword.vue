<script setup lang="ts">
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  password: "",
});

const submit = () => {
  form.post(route("password.confirm"), {
    onFinish: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <Head title="Confirm Password" />

  <section class="h-screen bg-gray-50 dark:bg-gray-900">
    <div
      class="flex flex-col items-center justify-start px-6 py-8 mx-auto lg:py-0"
    >
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
      >
        <div class="mb-4 text-sm text-gray-600">
          This is a secure area of the application. Please confirm your password
          before continuing.
        </div>

        <form @submit.prevent="submit">
          <div>
            <InputLabel for="password" value="Password" />
            <TextInput
              id="password"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password"
              required
              autocomplete="current-password"
              autofocus
            />
            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div class="flex justify-end mt-4">
            <PrimaryButton
              class="ms-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Confirm
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>
