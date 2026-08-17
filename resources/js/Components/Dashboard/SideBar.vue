<script setup>
import { Link } from "@inertiajs/vue3";
import AppLogo from "../Global/AppLogo.vue";

defineProps({
  restaurants: Object,
  open: { type: Boolean, default: false },
});

defineEmits(["close"]);
</script>

<template>
  <aside
    class="fixed top-0 left-0 z-40 w-64 h-full bg-white dark:bg-[#0B0C11] dark:text-slate-50 border-r border-slate-200 dark:border-slate-900 flex flex-col transform transition-transform duration-300 lg:translate-x-0"
    :class="open ? 'translate-x-0' : '-translate-x-full'"
  >
    <!-- Logo -->
    <div
      class="flex justify-between items-center gap-3 px-5 pt-5 pb-4 border-b border-slate-100 dark:border-slate-900"
    >
      <AppLogo class="text-lg" />
      <button
        class="lg:hidden w-8 h-8 rounded-lg bg-slate-100 dark:bg-[#0b0c11] hover:bg-slate-200 grid place-items-center text-slate-500 transition"
        @click="$emit('close')"
      >
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-6">
      <div>
        <p
          class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400"
        >
          Overview
        </p>
        <ul class="space-y-1">
          <li>
            <Link
              :href="route('dashboard')"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-orange-50 text-orange-600 dark:bg-[#302420] font-semibold text-sm"
            >
              <i class="fa-solid fa-gauge-high w-5 text-center"></i>
              Dashboard
            </Link>
          </li>
          <li>
            <a
              href="#"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:hover:bg-slate-800 dark:hover:text-slate-500 font-medium text-sm transition"
            >
              <i class="fa-solid fa-chart-line w-5 text-center"></i>
              Analytics
            </a>
          </li>
        </ul>
      </div>

      <div>
        <p
          class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400"
        >
          Management
        </p>
        <ul class="space-y-1">
          <li>
            <a
              href="#"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:hover:bg-slate-800 dark:hover:text-slate-500 font-medium text-sm transition"
            >
              <i class="fa-solid fa-receipt w-5 text-center"></i>
              Orders
              <span
                class="ml-auto text-[10px] font-bold bg-red-100 text-red-600 dark:bg-[#302420] rounded-full px-2 py-0.5"
              >
                12
              </span>
            </a>
          </li>
          <li>
            <a
              href="#"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:hover:bg-slate-800 dark:hover:text-slate-500 font-medium text-sm transition"
            >
              <i class="fa-solid fa-bowl-food w-5 text-center"></i>
              Menu Items
            </a>
          </li>
          <li>
            <a
              href="#"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:hover:bg-slate-800 dark:hover:text-slate-500 font-medium text-sm transition"
            >
              <i class="fa-solid fa-user-group w-5 text-center"></i>
              Customers
            </a>
          </li>
          <li>
            <a
              href="#"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:hover:bg-slate-800 dark:hover:text-slate-500 font-medium text-sm transition"
            >
              <i class="fa-solid fa-calendar-check w-5 text-center"></i>
              Reservations
            </a>
          </li>
        </ul>
      </div>

      <div>
        <p
          class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400"
        >
          Insights
        </p>
        <ul class="space-y-1">
          <li>
            <a
              href="#"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:hover:bg-slate-800 dark:hover:text-slate-500 font-medium text-sm transition"
            >
              <i class="fa-solid fa-star w-5 text-center"></i>
              Reviews
              <span
                class="ml-auto text-[10px] font-bold bg-emerald-100 text-emerald-600 dark:bg-[#172c2c] rounded-full px-2 py-0.5"
              >
                4.8
              </span>
            </a>
          </li>
          <li>
            <a
              href="#"
              class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:hover:bg-slate-800 dark:hover:text-slate-500 font-medium text-sm transition"
            >
              <i class="fa-solid fa-tag w-5 text-center"></i>
              Promotions
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Bottom -->
    <div
      class="px-3 pb-4 space-y-1 border-t border-slate-100 dark:border-slate-900 pt-3"
    >
      <a
        href="#"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-slate-800 dark:hover:bg-slate-800 dark:hover:text-slate-500 font-medium text-sm transition"
      >
        <i class="fa-solid fa-gear w-5 text-center"></i> Settings
      </a>
      <Link
        :href="route('items.trashed')"
        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-500 hover:bg-red-50 dark:hover:bg-[#302420] font-medium text-sm transition"
      >
        <i class="fa-solid fa-trash w-5 text-center"></i> Trash
      </Link>
    </div>
  </aside>
</template>

<style scoped>
:root {
  --scrollbar-thumb: #f1f5f9;
}

@media (prefers-color-scheme: dark) {
  :root {
    --scrollbar-thumb: #13141c;
  }
}

::-webkit-scrollbar {
  width: 3px;
}

::-webkit-scrollbar-thumb {
  background: var(--scrollbar-thumb);
}

::-webkit-scrollbar-thumb:hover {
  background: #f46600;
}
</style>
