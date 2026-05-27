<script setup>
import Notification from "@/Components/Global/Notification.vue";
import ImageInput from "@/Components/Ui/ImageInput.vue";
import InputError from "@/Components/Ui/InputError.vue";
import InputLabel from "@/Components/Ui/InputLabel.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import TextInput from "@/Components/Ui/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { reactive, ref, watchEffect } from "vue";

const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
});

defineEmits(["change"]);

const user = ref(usePage().props.auth.user);
const form = useForm({
  user_name: user.value.user_name,
  email: user.value.email,
  user_image: null,
  _method: "patch",
});
const status = reactive({
  name: null,
  message: {
    "profile-updated": "Profile updated successfully!",
    "profile-image-deleted": "Profile image deleted successfully!",
  },
});
let previewImage = user.value.user_image
  ? ref(`/storage/${user.value.user_image}`)
  : ref(`/storage/default.png`);

function onChangeInput(e) {
  const file = e.target.files[0];
  if (!file) return;
  form.user_image = file;
  previewImage.value = URL.createObjectURL(file);
}

function submit() {
  form.post(route("profile.update"), {
    preserveScroll: true,
  });
}

watchEffect(() => {
  status.name = props.status;
});
</script>

<template>
  <section>
    <!-- Notification Message -->
    <Notification
      :status="status.name"
      :message="status.message[status.name]"
      @closeNotification="status.name = null"
    />

    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-300">
        Profile Information
      </h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Update your account's profile information and email address.
      </p>
    </header>

    <form @submit.prevent="submit" class="mt-6 space-y-6">
      <div>
        <ImageInput
          @change="onChangeInput($event)"
          name="user_image"
          :src="previewImage"
          alt="User Image"
        />
        <InputError class="mt-2" :message="form.errors.user_image" />
      </div>

      <div>
        <InputLabel for="user_name" value="User Name" />

        <TextInput
          id="user_name"
          name="user_name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.user_name"
        />

        <InputError class="mt-2" :message="form.errors.user_name" />
      </div>

      <div>
        <InputLabel for="email" value="Email" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div v-if="mustVerifyEmail && user.email_verified_at === null">
        <p class="text-sm mt-2 text-gray-800">
          Your email address is unverified.
          <Link
            :href="route('verification.send')"
            method="post"
            as="button"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            Click here to re-send the verification email.
          </Link>
        </p>
        <div
          v-show="status === 'verification-link-sent'"
          class="mt-2 font-medium text-green-600"
        >
          A new verification link has been sent to your email address.
        </div>
      </div>

      <!-- Status Notification -->
      <Transition
        enter-active-class="transition ease-in-out"
        enter-from-class="opacity-0"
        leave-active-class="transition ease-in-out"
        leave-to-class="opacity-0"
      >
        <p
          v-if="status === 'image-reset'"
          class="mt-2 font-bold text-green-600"
        >
          Profile image has been reset.
        </p>
      </Transition>

      <div class="flex items-center gap-4">
        <PrimaryButton type="submit" :disabled="form.processing">
          Save
        </PrimaryButton>

        <Transition
          enter-active-class="transition ease-in-out"
          enter-from-class="opacity-0"
          leave-active-class="transition ease-in-out"
          leave-to-class="opacity-0"
        >
          <p v-if="form.recentlySuccessful" class="font-bold text-green-600">
            Saved.
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>
