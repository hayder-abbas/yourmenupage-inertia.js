<script setup>
import UpdateProfileForm from "@/Components/Forms/UpdateProfileForm.vue";
import Notification from "@/Components/Global/Notification.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { reactive, ref, watchEffect } from "vue";

const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
});

const user = ref(usePage().props.auth.user);
const setProfileImg = (img) => `/storage/${img || "default.png"}`;
let previewImage = ref(setProfileImg(user.value.userImage));

const form = useForm({
  first_name: user.value.firstName,
  last_name: user.value.lastName,
  email: user.value.email,
  user_image: null,
  _method: "patch",
});

const profileStatus = reactive({
  name: null,
  message: {
    "profile-updated": "Profile updated successfully!",
    "profile-image-deleted": "Profile image has been reset.",
  },
});

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

watchEffect(() => (profileStatus.name = props.status));
</script>

<template>
  <section class="max-w-xl mx-auto">
    <!-- Notification Message -->
    <Notification
      :status="profileStatus.name"
      :message="profileStatus.message[profileStatus.name]"
      @closeNotification="profileStatus.name = null"
    />

    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-300">
        Profile Information
      </h2>

      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
        Update your account's profile information and email address.
      </p>
    </header>

    <UpdateProfileForm
      @submit.prevent="submit"
      @onChange="onChangeInput($event)"
      v-model:firstName="form.first_name"
      v-model:lastName="form.last_name"
      v-model:email="form.email"
      :errors="form.errors"
      :previewImage="previewImage"
    >
      <div class="w-full">
        <PrimaryButton
          class="w-full md:w-1/2"
          type="submit"
          :disabled="form.processing"
        >
          Save
        </PrimaryButton>
      </div>
    </UpdateProfileForm>
  </section>
</template>
