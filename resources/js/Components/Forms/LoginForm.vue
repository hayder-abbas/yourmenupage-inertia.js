<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";
import Checkbox from "../Ui/Checkbox.vue";
import FormInput from "../Ui/FormInput.vue";
import RecaptchaError from "../Ui/RecaptchaError.vue";
import RecaptchaTerms from "../Global/RecaptchaTerms.vue";
import PrimaryButton from "../Ui/PrimaryButton.vue";

defineProps({
  canResetPassword: Boolean,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();

const form = useForm({
  email: "",
  password: "",
  remember: false,
  captcha_token: null, // Holds the generated token
});

async function submit() {
  // 1. Wait for reCAPTCHA to load
  await recaptchaLoaded();

  // 2. Execute and get the token (the string 'login' is the action name)
  form.captcha_token = await executeRecaptcha("login");

  form.post(route("login"), {
    onFinish: () => {
      form.reset("password");
    },
  });
}
</script>

<template>
  <form @submit.prevent="submit" class="space-y-4 md:space-y-6">
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

    <!-- Remember -->
    <div class="flex items-center justify-between">
      <div class="flex items-start">
        <div class="flex items-center h-5">
          <Checkbox
            id="remember"
            name="remember"
            aria-describedby="remember"
            v-model:checked="form.remember"
          />
        </div>
        <div class="ml-3 text-sm">
          <label for="remember" class="text-gray-500 dark:text-gray-300">
            Remember me
          </label>
        </div>
      </div>

      <!-- Forgot password link -->
      <Link
        v-if="canResetPassword"
        :href="route('password.request')"
        class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500"
      >
        Forgot password?
      </Link>
    </div>

    <PrimaryButton
      type="submit"
      class="w-full"
      :class="{ 'opacity-25': form.processing }"
      :disabled="form.processing"
    >
      Sign in
    </PrimaryButton>

    <!-- Sign up link -->
    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
      Don't have an account yet?
      <Link
        :href="route('register')"
        class="font-medium text-blue-600 hover:underline dark:text-blue-500"
      >
        Sign up
      </Link>
    </p>

    <!-- Recaptcha Error -->
    <RecaptchaError
      v-if="form.errors.captcha_token"
      :error="form.errors.captcha_token"
    />

    <!-- Google Required Privacy Disclaimer -->
    <RecaptchaTerms />
  </form>
</template>
