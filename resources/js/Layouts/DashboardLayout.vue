<script setup>
import SideBar from "@/Components/Dashboard/SideBar.vue";
import SiteHeader from "@/Components/Dashboard/SiteHeader.vue";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const user = ref(usePage().props.auth?.user);
const sidebarOpen = ref(false);
</script>

<template>
  <div
    class="bg-slate-100 min-h-screen text-slate-800 lg:pl-64 dark:bg-[#0B0C11] dark:text-slate-50"
  >
    <!-- Site Header -->
    <SiteHeader :user="user" />
    <!-- Sidebar -->
    <SideBar :open="sidebarOpen" @close="sidebarOpen = false" />

    <div
      class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 transition-opacity duration-300"
      :class="
        sidebarOpen
          ? 'opacity-100 pointer-events-auto'
          : 'opacity-0 pointer-events-none'
      "
      @click="sidebarOpen = false"
    ></div>

    <button
      class="lg:hidden fixed z-40 bottom-5 left-5 w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 text-white grid place-items-center shadow-lg shadow-orange-500/40 active:scale-95 transition"
      @click="sidebarOpen = true"
    >
      <i class="fa-solid fa-bars"></i>
    </button>

    <main class="max-w-6xl mx-auto px-4 py-6 space-y-6">
      <slot />

      <!-- Dashboard Footer -->
      <footer class="text-center text-xs text-slate-400">
        © {{ new Date().getFullYear() }} YourMenuPage — Dashboard
      </footer>
    </main>
  </div>
</template>
