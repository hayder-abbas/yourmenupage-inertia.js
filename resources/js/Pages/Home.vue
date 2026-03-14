<script setup>
import AppHero from "@/Components/Global/AppHero.vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";
import { provide } from "vue";

defineOptions({ layout: HomeLayout });
const props = defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  restaurants: {
    type: Object,
  },
  filters: {
    type: Object,
  },
});

provide("canLogin", props.canLogin);
</script>

<template>
  <Head title="Home" />
  <AppHero :restaurants="restaurants" :filters="filters" />
</template>
