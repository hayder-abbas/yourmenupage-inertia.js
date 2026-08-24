<script setup>
import FormInput from "@/Components/Ui/FormInput.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const updatePassword = () => {
  form.put(route("password.update"), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.password) {
        form.reset("password", "password_confirmation");
        passwordInput.value.focus();
      }
      if (form.errors.current_password) {
        form.reset("current_password");
        currentPasswordInput.value.focus();
      }
    },
  });
};
</script>

<template>
  <section class="max-w-xl mx-auto">
    <header>
      <h2 class="text-lg font-medium text-gray-900">Update Password</h2>

      <p class="mt-1 text-sm text-gray-400">
        Ensure your account is using a long, random password to stay secure.
      </p>
    </header>

    <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
      <!-- Current Password -->
      <FormInput
        v-model="form.current_password"
        ref="currentPasswordInput"
        inputID="current_password"
        inputType="password"
        label="Current Password"
        :error="form.errors.current_password"
      />

      <!-- New Password -->
      <FormInput
        v-model="form.password"
        ref="passwordInput"
        inputID="password"
        inputType="password"
        label="New Password"
        :error="form.errors.password"
      />

      <!-- Confirm Password -->
      <FormInput
        v-model="form.password_confirmation"
        inputID="password_confirmation"
        inputType="password"
        label="Confirm Password"
        :error="form.errors.password_confirmation"
      />

      <div class="w-full md:flex items-center gap-4">
        <PrimaryButton
          class="w-full md:w-1/2"
          type="submit"
          :disabled="form.processing"
        >
          Save
        </PrimaryButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="text-sm text-green-600">
            Saved...
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>
