<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import Checkbox from "../Ui/Checkbox.vue";
import FormInput from "../Ui/FormInput.vue";
import PrimaryButton from "../Ui/PrimaryButton.vue";

defineProps({
  errors: {
    type: Object,
    default: () => ({}),
  },
});

const form = useForm({
  first_name: "",
  last_name: "",
  email: "",
  password: "",
  password_confirmation: "",
  terms: false,
});

function submit() {
  form.post(route("register"), {
    onFinish: () => {
      form.reset("password", "password_confirmation");
    },
  });
}
</script>

<template>
  <form @submit.prevent="submit" class="space-y-4 md:space-y-6">
    <!-- First Name -->
    <FormInput
      v-model.trim="form.first_name"
      inputID="firstName"
      label="First Name"
      inputType="text"
      placeholder="John"
      :error="form.errors.first_name"
    />

    <!-- Last Name -->
    <FormInput
      v-model.trim="form.last_name"
      inputID="lastName"
      label="Last Name"
      inputType="text"
      placeholder="Doe"
      :error="form.errors.last_name"
    />

    <!-- Email -->
    <FormInput
      v-model.trim="form.email"
      inputID="email"
      label="Email"
      inputType="email"
      placeholder="email@example.com"
      :error="form.errors.email"
    />

    <!-- Password -->
    <FormInput
      v-model.trim="form.password"
      inputID="password"
      label="Password"
      inputType="password"
      placeholder="••••••••"
      :error="form.errors.password"
    />

    <!-- Password Confirmation -->
    <FormInput
      v-model.trim="form.password_confirmation"
      inputID="passwordConfirmation"
      label="Password Confirmation"
      inputType="password"
      placeholder="••••••••"
      :error="form.errors.password_confirmation"
    />

    <!-- Terms -->
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
        <label for="terms" class="font-light text-gray-500 dark:text-gray-300">
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
      Create Account
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
</template>
