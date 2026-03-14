<script setup>
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
  status: String,
});

const form = useForm({
  email: "",
});

// const submit = () => {
//   form.post(route("password.email"));
// };
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

        <form @submit.prevent="form.post(route('password.email'))">
          <div>
            <InputLabel for="email" value="Email" />

            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              autofocus
              autocomplete="username"
            />

            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div class="flex items-center justify-end mt-4">
            <PrimaryButton
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Email Password Reset Link
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </section>
</template>
