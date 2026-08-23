<script setup>
import ArrowRightIcon from "@/Components/Icons/ArrowRightIcon.vue";
import ResetPasswordForm from "@/Components/Forms/ResetPasswordForm.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
  email: String,
  token: String,
});
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
        <!-- Reset Password Form -->
        <ResetPasswordForm :token="token" :email="email" />
      </div>
    </div>
  </section>
</template>
