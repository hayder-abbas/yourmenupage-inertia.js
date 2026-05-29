<script setup>
import { reactive, watchEffect } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import Notification from "@/Components/Global/Notification.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

defineOptions({
  layout: DashboardLayout,
});

const status = reactive({
  name: null,
  message: {
    "restaurant-deleted": "Restaurant deleted successfully!",
  },
});

watchEffect(() => {
  status.name = usePage().props.flash?.status;
});
</script>

<template>
  <div>
    <Head title="Dashboard" />

    <!-- Notification Message -->
    <Notification
      :status="status.name"
      :message="status.message[status.name]"
      @closeNotification="status.name = null"
    />

    Dashboard content
  </div>
</template>
