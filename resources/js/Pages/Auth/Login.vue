<script setup>
import AppLogo from "@/Components/Global/AppLogo.vue";
import Checkbox from "@/Components/Ui/Checkbox.vue";
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";

defineOptions({
  layout: AppLayout,
});

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => {
      form.reset("password");
    },
  });
};
</script>

<template>
  <!-- Login form -->
  <section
    class="min-h-screen p-4 flex flex-col items-center justify-center dark:bg-gray-800"
  >
    <Head title="Login Page" />

    <!-- Logo -->
    <div class="p-6">
      <AppLogo />
    </div>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <div
      class="w-full bg-white rounded-lg shadow-lg dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
    >
      <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1
          class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
        >
          Sign in to your account
        </h1>
        <form class="space-y-4 md:space-y-6" @submit.prevent="submit">
          <div>
            <InputLabel for="email" value="Email" />

            <TextInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              autofocus
              autocomplete="username"
              placeholder="name@company.com"
            />

            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div>
            <InputLabel for="password" value="Password" />

            <TextInput
              id="password"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password"
              autocomplete="current-password"
              placeholder="••••••••"
            />

            <InputError class="mt-2" :message="form.errors.password" />
          </div>
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
            <Link
              v-if="canResetPassword"
              :href="route('password.request')"
              class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500"
            >
              Forgot password?
            </Link>
          </div>
          <button
            type="submit"
            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Sign in
          </button>
          <p class="text-sm font-light text-gray-500 dark:text-gray-400">
            Don't have an account yet?
            <Link
              :href="route('register')"
              class="font-medium text-blue-600 hover:underline dark:text-blue-500"
            >
              Sign up
            </Link>
          </p>
        </form>
      </div>
    </div>
  </section>
</template>
