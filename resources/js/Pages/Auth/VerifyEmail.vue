<script setup>
import { computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";

defineOptions({ layout: AppLayout });

const props = defineProps({
  status: {
    type: String,
    required: false,
  },
});

const form = useForm({});

function submit() {
  form.post(route("verification.send"));
}

const verificationLinkSent = computed(
  () => props.status === "verification-link-sent",
);
</script>

<template>
  <div
    class="p-4 mx-auto bg-white sm:max-w-lg dark:text-white dark:bg-gray-800"
  >
    <Head title="Email Verification" />

    <p>
      Thanks for signing up! Before getting started, could you verify your email
      address by clicking on the link we just emailed to you? If you didn't
      receive the email, we will gladly send you another.
    </p>

    <div
      class="mb-4 font-medium text-sm text-green-600"
      v-if="verificationLinkSent"
    >
      A new verification link has been sent to the email address you provided
      during registration.
    </div>

    <form @submit.prevent="submit">
      <div class="mt-4 text-center">
        <PrimaryButton
          type="submit"
          class="w-full md:max-w-[50%] mx-auto mb-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Resend Verification Email
        </PrimaryButton>

        <Link
          :href="route('logout')"
          method="post"
          as="button"
          class="hover:underline rounded-md"
          >Log Out</Link
        >
      </div>
    </form>
  </div>
</template>
