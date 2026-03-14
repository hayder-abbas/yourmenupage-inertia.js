<script setup lang="ts">
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import ArrowRightIcon from "@/Components/Icons/ArrowRightIcon.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps<{
  email: string;
  token: string;
}>();

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("password.store"), {
    onFinish: () => {
      form.reset("password", "password_confirmation");
    },
  });
};
</script>

<template>
  <Head title="Reset Password" />

  <section class="h-screen bg-gray-50 dark:bg-gray-900">
    <div
      class="flex flex-col items-center justify-start px-6 py-8 mx-auto lg:py-0"
    >
      <Link
        href="/"
        class="flex self-end py-8 px-4 font-bold text-primary-600 hover:underline"
      >
        <span>Go to home</span>
        <ArrowRightIcon class="w-6 h-6 ml-1" />
      </Link>

      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
      >
        <form @submit.prevent="submit" class="p-6">
          <div>
            <InputLabel for="email" value="Email" />

            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              required
              autofocus
              autocomplete="username"
            />

            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div class="mt-4">
            <InputLabel for="password" value="Password" />

            <TextInput
              id="password"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password"
              required
              autocomplete="new-password"
            />

            <InputError class="mt-2" :message="form.errors.password" />
          </div>

          <div class="mt-4">
            <InputLabel for="password_confirmation" value="Confirm Password" />

            <TextInput
              id="password_confirmation"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password_confirmation"
              required
              autocomplete="new-password"
            />

            <InputError
              class="mt-2"
              :message="form.errors.password_confirmation"
            />
          </div>

          <div class="flex items-center justify-end mt-4">
            <PrimaryButton
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Reset Password
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>
