<script setup>
import FormInput from "../Ui/FormInput.vue";
import ImageInput from "../Ui/ImageInput.vue";
import SelectInput from "../Ui/SelectInput.vue";
import TextAreaInput from "../Ui/TextAreaInput.vue";

const emit = defineEmits(["onChange"]);

defineProps({
  cities: Object,
  previewLogo: String,
  errors: {
    type: Object,
    default: () => ({}),
  },
});

const restName = defineModel("restName");
const restPhone = defineModel("restPhone");
const restDesc = defineModel("restDesc");
const location = defineModel("location");
const cityID = defineModel("cityID");
const openAt = defineModel("openAt");
const closeAt = defineModel("closeAt");
</script>

<template>
  <form class="space-y-4 md:space-y-6">
    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
      <!-- Restaurant Logo -->
      <ImageInput
        @change="emit('onChange', $event)"
        :src="previewLogo"
        :error="errors.item_image"
        class="sm:col-span-2 text-center"
      />

      <!-- Restaurant Name -->
      <FormInput
        v-model.trim="restName"
        inputID="restName"
        label="Restaurant Name"
        inputType="text"
        placeholder="Type restaurant name..."
        :error="errors.rest_name"
      />

      <!-- Phone -->
      <FormInput
        v-model.trim="restPhone"
        inputID="restPhone"
        label="Phone"
        inputType="text"
        placeholder="Restaurant phone..."
        :error="errors.rest_phone"
      />

      <!-- Location -->
      <FormInput
        v-model.trim="location"
        inputID="location"
        label="Location"
        inputType="text"
        placeholder="Your location here..."
        :error="errors.location"
      />

      <!-- Cities -->
      <SelectInput v-model="cityID" label="City" :error="errors.category_id">
        <option
          v-for="c in cities"
          :key="c.id"
          :value="c.id"
          v-text="c.cityName"
        ></option>
      </SelectInput>

      <!-- Open at -->
      <FormInput
        v-model.trim="openAt"
        inputID="openAt"
        label="Open at"
        inputType="time"
        :error="errors.open_at"
      />

      <!-- Close at -->
      <FormInput
        v-model.trim="closeAt"
        inputID="closeAt"
        label="Close at"
        inputType="time"
        :error="errors.close_at"
      />

      <!-- Restaurant description -->
      <TextAreaInput
        v-model="restDesc"
        inputID="restDesc"
        label="Description"
        :error="errors.rest_desc"
        placeholder="Your description here..."
        class="sm:col-span-2 mb-5"
      />
    </div>

    <slot />
  </form>
</template>
