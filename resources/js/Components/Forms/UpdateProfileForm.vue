<script setup>
import FormInput from "../Ui/FormInput.vue";
import ImageInput from "../Ui/ImageInput.vue";

defineProps({
  previewImage: String,
  errors: {
    type: Object,
    default: () => {},
  },
});

const emit = defineEmits(["onChange"]);

const firstName = defineModel("firstName");
const lastName = defineModel("lastName");
const email = defineModel("email");
</script>

<template>
  <form class="mt-6 space-y-6 flex flex-col items-center">
    <!-- Profile Image -->
    <ImageInput
      @change="emit('onChange', $event)"
      :src="previewImage"
      :error="errors.user_image"
      alt="User Image"
    />

    <!-- First Name -->
    <FormInput
      v-model="firstName"
      inputID="firstName"
      inputType="text"
      label="First Name"
      placeholder="Your First Name..."
      :error="errors.first_name"
    />

    <!-- last Name -->
    <FormInput
      v-model="lastName"
      inputID="lastNaame"
      inputType="text"
      label="Last Name"
      placeholder="Your Last Name..."
      :error="errors.last_name"
    />

    <!-- Email -->
    <FormInput
      v-model="email"
      inputID="email"
      inputType="email"
      label="Email"
      placeholder="Your Email..."
      :error="errors.email"
    />

    <slot />
  </form>
</template>
