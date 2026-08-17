<script setup>
import { reactive, ref, watchEffect } from "vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import Notification from "@/Components/Global/Notification.vue";
import OverviewCards from "@/Components/Dashboard/OverviewCards.vue";
import SalesAnalytics from "@/Components/Dashboard/SalesAnalytics.vue";
import PopularItems from "@/Components/Dashboard/PopularItems.vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";

defineOptions({
  layout: DashboardLayout,
});

defineProps({
  restaurant: Object | null,
  canCreateRestaurant: Boolean,
});

const user = ref(usePage().props.auth?.user);
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
  <Head title="Dashboard" />

  <!-- Notification Message -->
  <Notification
    :status="status.name"
    :message="status.message[status.name]"
    @closeNotification="status.name = null"
  />

  <!-- Dashboard Content -->
  <div class="flex flex-col md:flex-row items-center">
    <div class="flex-1">
      <h1 class="text-2xl font-bold">Dashboard</h1>
      <p class="text-sm text-slate-500">
        Good evening, {{ user.firstName }} — here's how your restaurant is doing
        today.
      </p>
    </div>
    <div class="pt-6 md:pt-0">
      <!-- Create Restaurant Button -->
      <Link
        v-if="canCreateRestaurant"
        :href="route('restaurants.create')"
        class="px-4 py-2 bg-orange-500 text-sm text-white font-bold rounded-lg"
      >
        Create Restaurant
      </Link>
      <!-- Show Restaurant Button -->
      <Link
        v-else
        :href="route('restaurants.show', restaurant)"
        class="px-4 py-2 bg-orange-500 text-sm text-white font-bold rounded-lg"
      >
        Show Restaurant
      </Link>
    </div>
  </div>

  <OverviewCards />

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <SalesAnalytics class="xl:col-span-2" />
    <PopularItems class="xl:col-span-1 self-start" />
  </div>
</template>
