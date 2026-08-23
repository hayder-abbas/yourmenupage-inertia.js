<script setup>
import { useForm } from "@inertiajs/vue3";
import FormInput from "../Ui/FormInput.vue";
import PrimaryButton from "../Ui/PrimaryButton.vue";

const props = defineProps({
  email: String,
  token: String,
});

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
  <form @submit.prevent="submit" class="p-6 space-y-4 md:space-y-6">
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
      label="New Password"
      inputType="password"
      placeholder="••••••••"
      :error="form.errors.password"
    />

    <!-- Password Confirmation -->
    <FormInput
      v-model.trim="form.password_confirmation"
      inputID="passwordConfirmation"
      label="New Password Confirmation"
      inputType="password"
      placeholder="••••••••"
      :error="form.errors.password_confirmation"
    />

    <div class="flex items-center justify-end mt-4">
      <PrimaryButton
        type="submit"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Reset Password
      </PrimaryButton>
    </div>
  </form>
</template>
