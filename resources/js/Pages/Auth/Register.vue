<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import Checkbox from "@/Components/Ui/Checkbox.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLogo from "@/Components/Global/AppLogo.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";

defineOptions({
  layout: AppLayout,
});

const form = useForm({
  user_name: "",
  email: "",
  password: "",
  password_confirmation: "",
  terms: false,
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => {
      form.reset("password", "password_confirmation");
    },
  });
};
</script>

<template>
  <section
    class="min-h-screen p-4 flex flex-col items-center justify-center dark:bg-gray-800"
  >
    <Head title="Create Account Form" />

    <!-- Logo -->
    <div class="p-6">
      <AppLogo class="text-3xl dark:text-white" />
    </div>

    <div
      class="w-full bg-white rounded-lg shadow-lg dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
    >
      <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1
          class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
        >
          Create an account
        </h1>
        <form class="space-y-4 md:space-y-6" @submit.prevent="submit">
          <div>
            <InputLabel for="user_name" value="Name" />
            <TextInput
              id="user_name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.user_name"
              autocomplete="user_name"
              placeholder="Your name"
            />
            <InputError class="mt-2" :message="form.errors.user_name" />
          </div>

          <div class="mt-4">
            <InputLabel for="email" value="Email" />
            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              autocomplete="email"
              placeholder="name@company.com"
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
              autocomplete="new-password"
              placeholder="••••••••"
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
              autocomplete="new-password"
              placeholder="••••••••"
            />
            <InputError
              class="mt-2"
              :message="form.errors.password_confirmation"
            />
          </div>

          <div class="flex items-start">
            <div class="flex items-center h-5">
              <Checkbox
                id="terms"
                name="terms"
                aria-describedby="terms"
                v-model:checked="form.terms"
              />
            </div>
            <div class="ml-3 text-sm">
              <label
                for="terms"
                class="font-light text-gray-500 dark:text-gray-300"
              >
                I accept the
                <a
                  class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                  href="#"
                >
                  Terms and Conditions
                </a>
              </label>
            </div>
          </div>

          <PrimaryButton
            type="submit"
            class="w-full"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Create an account
          </PrimaryButton>

          <!-- Sign-in link -->
          <p class="text-sm font-light text-gray-500 dark:text-gray-400">
            Already have an account?
            <Link
              :href="route('login')"
              class="font-medium text-blue-600 hover:underline dark:text-blue-500"
            >
              Sign in here
            </Link>
          </p>
        </form>
      </div>
    </div>
  </section>
</template>
