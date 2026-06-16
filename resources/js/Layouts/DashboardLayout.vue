<script setup>
import AppFooter from "@/Components/Global/AppFooter.vue";
import SideBar from "@/Components/Dashboard/SideBar.vue";
import CloseIcon from "@/Components/Icons/CloseIcon.vue";
import DashboardNav from "@/Components/Dashboard/DashboardNav.vue";
import { useDashboardStore } from "@/Stores/DashboardStore";
import { ref } from "vue";
import { storeToRefs } from "pinia";

const dashboard = useDashboardStore();
const { userRestaurants } = storeToRefs(dashboard);
const openDashboardSidebar = ref(false);

function toggleSidbar() {
  openDashboardSidebar.value = !openDashboardSidebar.value;
}
</script>

<template>
  <div>
    <div class="xl:grid xl:grid-cols-10">
      <!-- Fixed Sidebar -->
      <SideBar
        :restaurants="userRestaurants"
        class="hidden xl:block xl:col-span-2"
      />

      <!-- Floating Sidebar -->
      <SideBar
        :restaurants="userRestaurants"
        class="fixed md:absolute top-0 left-0 xl:hidden w-80"
        :class="{ '-translate-x-full': !openDashboardSidebar }"
      >
        <template #close_button>
          <CloseIcon @click="toggleSidbar" class="w-8 h-8 text-gray-50" />
        </template>
      </SideBar>

      <!-- Dashboard Content -->
      <main class="min-h-screen xl:col-span-8 dark:bg-gray-800">
        <!-- Navbar -->
        <DashboardNav @toggle="toggleSidbar" />
        <slot />
      </main>
    </div>

    <!-- Footer -->
    <AppFooter />
  </div>
</template>
