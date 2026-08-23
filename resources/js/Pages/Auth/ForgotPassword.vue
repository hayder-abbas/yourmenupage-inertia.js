<script setup>
import ForgotPasswordForm from "@/Components/Forms/ForgotPasswordForm.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  status: String,
});
</script>

<template>
  <section
    class="h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900"
  >
    <Head title="Forgot Password" />

    <div
      class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
    >
      <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <div class="text-sm text-gray-600 dark:text-gray-300">
          Forgot your password? No problem. Just let us know your email address
          and we will email you a password reset link that will allow you to
          choose a new one.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
          {{ status }}
        </div>

        <!-- Forgot Password Form -->
        <ForgotPasswordForm />
      </div>
    </div>
  </section>
</template>
