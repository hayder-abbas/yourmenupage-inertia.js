<script setup>
import { reactive } from "vue";
import StatCard from "./StatCard.vue";

const props = defineProps({
  state: Object,
});

const cards = reactive([
  {
    icon: "fa-solid fa-receipt",
    iconBg: "bg-orange-100 text-orange-600 dark:bg-[#302420]",
    badge: "+12.4%",
    badgeClass: "text-emerald-600 bg-emerald-50 dark:bg-[#172c2c]",
    label: "Orders",
    value: "1,284",
    deltaHighlight: "+142",
    deltaNote: "vs last week",
  },
  {
    icon: "fa-solid fa-file-invoice-dollar",
    iconBg: "bg-violet-100 text-violet-600 dark:bg-[#212338]",
    badge: "+3.1%",
    badgeClass: "text-emerald-600 bg-emerald-50 dark:bg-[#172c2c]",
    label: "Avg Order Amount",
    value: "$34.75",
    deltaHighlight: "+$1.05",
    deltaNote: "vs last week",
  },
  {
    icon: "fa-solid fa-user-group",
    iconBg: "bg-sky-100 text-sky-600 dark:bg-[#212338]",
    badge: "+8.7%",
    badgeClass: "text-emerald-600 bg-emerald-50 dark:bg-[#172c2c]",
    label: "Unique Customers",
    value: "962",
    deltaHighlight: "+77",
    deltaNote: "vs last week",
  },
  {
    icon: "fa-solid fa-chart-line",
    iconBg: "bg-emerald-100 text-emerald-600 dark:bg-[#172c2c]",
    badge: "-1.2%",
    badgeClass: "text-red-500 bg-red-50 dark:bg-[#302420]",
    label: "Net Sales",
    value: "$44,682",
    deltaHighlight: "-$540",
    deltaNote: "vs last week",
  },
]);
</script>

<template>
  <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <StatCard v-for="card in cards" :key="card.label" v-bind="card" />
  </section>
</template>
