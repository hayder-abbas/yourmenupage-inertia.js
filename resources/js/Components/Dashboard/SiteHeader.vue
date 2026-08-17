<script setup>
import { useDark, useToggle } from "@vueuse/core";
import DarkModeButton from "../Ui/DarkModeButton.vue";
import { ref } from "vue";

const props = defineProps({ user: Object });
const isDark = useDark(true);
const toggleDark = useToggle(isDark);
const src = props.user.userImage
  ? ref(`/storage/${props.user.userImage}`)
  : ref(`/storage/default.png`);
</script>

<template>
  <header
    class="sticky top-0 z-20 bg-white/90 backdrop-blur border-b border-slate-200 dark:bg-[#0B0C11] dark:text-slate-50 dark:border-slate-900"
  >
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center gap-3">
      <div class="flex-1 max-w-xl mx-auto hidden md:block">
        <div class="relative">
          <i
            class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"
          ></i>
          <input
            type="text"
            placeholder="Search orders, items, customers..."
            class="w-full bg-slate-100 dark:bg-[#13141c] border border-transparent dark:border-slate-800 focus:border-orange-400 dark:focus:border-orange-400 focus:bg-white focus:ring-0 rounded-full pl-10 pr-4 py-2 text-sm outline-none transition"
          />
        </div>
      </div>

      <div class="flex items-center gap-2 ml-auto md:ml-0">
        <!-- Dark mode button -->
        <DarkModeButton @click="toggleDark()" :isDark="isDark" />

        <!-- Notification -->
        <button
          class="relative w-10 h-10 rounded-full bg-slate-100 dark:bg-[#13141c] hover:bg-slate-200 transition grid place-items-center"
        >
          <i class="fa-regular fa-bell text-slate-600 dark:text-slate-100"></i>
          <span
            class="absolute top-2 right-2.5 w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"
          ></span>
        </button>

        <!-- User Info -->
        <div
          class="flex items-center gap-2 bg-slate-100 dark:bg-[#13141c] rounded-full pl-1 pr-3 py-1"
        >
          <img
            :src="src"
            alt="Avatar"
            class="w-8 h-8 rounded-full object-cover"
          />
          <div class="hidden sm:block">
            <p
              class="text-xs font-semibold leading-tight"
              v-text="user.fullName"
            ></p>
            <p class="text-[10px] text-slate-500">Manager</p>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>
