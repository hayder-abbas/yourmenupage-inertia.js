<script setup>
import FormInput from "../Ui/FormInput.vue";
import ImageInput from "../Ui/ImageInput.vue";
import SelectInput from "../Ui/SelectInput.vue";
import TextAreaInput from "../Ui/TextAreaInput.vue";

const emit = defineEmits(["onChange"]);

defineProps({
  categories: Array,
  previewImage: String,
  errors: {
    type: Object,
    default: () => ({}),
  },
});

const itemTitle = defineModel("itemTitle");
const itemPrice = defineModel("itemPrice");
const itemDesc = defineModel("itemDesc");
const categoryID = defineModel("categoryID");
</script>

<template>
  <form>
    <div class="p-4 flex flex-col items-center">
      <!-- Item image -->
      <ImageInput
        @change="emit('onChange', $event)"
        :src="previewImage"
        :error="errors.item_image"
      />

      <!-- Item title -->
      <FormInput
        v-model.trim="itemTitle"
        inputID="itemTitle"
        label="Item title"
        inputType="text"
        placeholder="Item title..."
        :error="errors.item_title"
      />

      <!-- Item price -->
      <FormInput
        v-model.number.trim="itemPrice"
        inputID="itemPrice"
        label="Item price"
        inputType="number"
        placeholder="Item price..."
        :error="errors.item_price"
      />

      <!-- Item category -->
      <SelectInput
        v-model="categoryID"
        label="Item price"
        :error="errors.category_id"
        class="w-full mb-2"
      >
        <option
          v-for="c in categories"
          :key="c.id"
          :value="c.id"
          v-text="c.categoryName"
        ></option>
      </SelectInput>

      <!-- Item description -->
      <TextAreaInput
        v-model="itemDesc"
        inputID="itemDesc"
        label="Item description"
        :error="errors.item_desc"
        placeholder="Your description here..."
        class="w-full mb-2"
      />
    </div>

    <slot />
  </form>
</template>
