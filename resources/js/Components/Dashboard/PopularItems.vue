<script setup>
import { reactive } from "vue";

const items = reactive([
  {
    name: "Margherita Pizza",
    sold: 368,
    price: "$18.00",
    img: "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=100&h=100&fit=crop",
  },
  {
    name: "Classic Cheeseburger",
    sold: 312,
    price: "$14.50",
    img: "https://images.unsplash.com/photo-1551782450-a2132b4ba21d?w=100&h=100&fit=crop",
  },
  {
    name: "Chicken Caesar Salad",
    sold: 256,
    price: "$12.00",
    img: "https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=100&h=100&fit=crop",
  },
  {
    name: "Spaghetti Bolognese",
    sold: 196,
    price: "$16.50",
    img: "https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=100&h=100&fit=crop",
  },
  {
    name: "Tiramisu",
    sold: 140,
    price: "$9.00",
    img: "https://images.unsplash.com/photo-1551024506-0bccd828d307?w=100&h=100&fit=crop",
  },
]);
</script>

<template>
  <section
    class="bg-white dark:bg-[#13141C] rounded-2xl p-5 shadow-sm border border-slate-200 dark:border-slate-900"
  >
    <div class="flex items-center justify-between mb-5">
      <div>
        <h2 class="font-bold text-lg">Most Popular Items</h2>
        <p class="text-sm text-slate-500">Top sellers this week</p>
      </div>
      <a
        href="#"
        class="text-sm font-semibold text-orange-600 hover:text-orange-700"
      >
        View all →
      </a>
    </div>

    <div class="space-y-3">
      <div
        v-for="item in items"
        :key="item.name"
        class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition"
      >
        <img
          :src="item.img"
          :alt="item.name"
          class="w-11 h-11 rounded-xl object-cover shrink-0"
        />
        <div class="flex-1 min-w-0">
          <p class="font-semibold text-sm truncate">{{ item.name }}</p>
          <p class="text-xs text-slate-400">{{ item.sold }} sold</p>
        </div>
        <p class="text-sm font-bold text-orange-600 whitespace-nowrap">
          {{ item.price }}
        </p>
      </div>
    </div>
  </section>
</template>
