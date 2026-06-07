<script setup>
import Notification from "@/Components/Global/Notification.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import { reactive, watchEffect } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import { useDashboardStore } from "@/Stores/DashboardStore";
import { storeToRefs } from "pinia";

defineOptions({
  layout: DashboardLayout,
});

const props = defineProps({
  restaurants: Array,
  filters: Object,
});

const dashboard = useDashboardStore();
const { userRestaurants } = storeToRefs(dashboard);

const status = reactive({
  name: null,
  message: {
    "restaurant-deleted": "Restaurant deleted successfully!",
  },
});

watchEffect(() => {
  status.name = usePage().props.flash?.status;
  userRestaurants.value = props.restaurants;
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
