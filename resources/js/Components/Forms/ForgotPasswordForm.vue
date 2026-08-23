<script setup>
import { useForm } from "@inertiajs/vue3";
import FormInput from "../Ui/FormInput.vue";
import PrimaryButton from "../Ui/PrimaryButton.vue";

defineProps({
  errors: {
    type: Object,
    default: () => ({}),
  },
});

const form = useForm({
  email: "",
});

function submit() {
  form.post(route("password.email"));
}
</script>

<template>
  <form @submit.prevent="submit" class="p-6 space-y-4 md:space-y-6">
    <FormInput
      v-model.trim="form.email"
      inputID="email"
      label="Email"
      inputType="email"
      placeholder="email@example.com"
      :error="form.errors.email"
    />

    <div class="flex items-center justify-end mt-4">
      <PrimaryButton
        type="submit"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Email Password Reset Link
      </PrimaryButton>
    </div>
  </form>
</template>
