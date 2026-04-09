<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { onUnmounted } from "vue";
import { useAppStore } from "@/Stores/AppStore";

defineOptions({ layout: AppLayout });

const app = useAppStore();

onUnmounted(() => {
  app.openUserMenu = false;
  app.openHamburgerMenu = false;
});
</script>

<template>
  <Head title="About us" />

  <h1>About Us Page</h1>
</template>
