<script setup>
import AppLogo from "@/Components/Global/AppLogo.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import LoginForm from "@/Components/Forms/LoginForm.vue";
import { Head } from "@inertiajs/vue3";

defineOptions({
  layout: AppLayout,
});

defineProps({
  canResetPassword: Boolean,
  status: String,
});
</script>

<template>
  <!-- Sign-in form -->
  <section
    class="min-h-screen p-4 flex flex-col items-center justify-center dark:bg-gray-800"
  >
    <Head title="Sign-in Page" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <div
      class="w-full bg-white rounded-lg shadow-lg dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
    >
      <div class="p-6 space-y-4 md:space-y-4 sm:p-8">
        <!-- Logo -->
        <div class="p-6 text-center">
          <AppLogo class="text-3xl dark:text-white" />
        </div>
        <h1
          class="text-xl text-center font-bold text-gray-900 md:text-2xl dark:text-white"
        >
          Sign in to your account
        </h1>

        <!-- Login Form -->
        <LoginForm :canResetPassword="canResetPassword" />
      </div>
    </div>
  </section>
</template>
