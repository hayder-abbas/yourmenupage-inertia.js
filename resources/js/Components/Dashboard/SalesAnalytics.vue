<script setup>
import { ref, onMounted, watch } from "vue";
import Chart from "chart.js/auto";
import AnalyticsSummary from "./AnalyticsSummary.vue";

const period = ref("7d");
const canvasEl = ref(null);
let chart = null;

const salesData = {
  "7d": {
    labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
    values: [5200, 6800, 4100, 7900, 6200, 9400, 8100],
  },
  "30d": {
    labels: Array.from({ length: 30 }, (_, i) => `D${i + 1}`),
    values: Array.from(
      { length: 30 },
      () => Math.floor(Math.random() * 5000) + 3000,
    ),
  },
  year: {
    labels: [
      "Jan",
      "Feb",
      "Mar",
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ],
    values: [
      42000, 38500, 45100, 49800, 52600, 61200, 58300, 63900, 59800, 67400,
      72100, 76400,
    ],
  },
};

const chartConfig = (data) => ({
  type: "bar",
  data: {
    labels: data.labels,
    datasets: [
      {
        label: "Net Sales",
        data: data.values,
        backgroundColor: (c) => {
          const g = c.chart.ctx.createLinearGradient(0, 0, 0, 400);
          g.addColorStop(0, "#fb923c");
          g.addColorStop(1, "rgba(251, 146, 60, 0.15)");
          return c.dataIndex === 3 ? "#f97316" : g;
        },
        borderRadius: 8,
        borderSkipped: false,
        maxBarThickness: 36,
      },
    ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: "#0f172a",
        padding: 10,
        cornerRadius: 10,
        displayColors: false,
        callbacks: {
          label: (item) => " $" + Number(item.parsed.y).toLocaleString(),
        },
      },
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { color: "#64748b", font: { size: 11 } },
      },
      y: {
        grid: { color: "#f1f5f9" },
        border: { display: false },
        ticks: {
          color: "#94a3b8",
          font: { size: 11 },
          callback: (v) => "$" + v / 1000 + "k",
        },
      },
    },
  },
});

function renderChart(p) {
  if (chart) chart.destroy();
  chart = new Chart(canvasEl.value, chartConfig(salesData[p]));
}

onMounted(() => renderChart(period.value));
watch(period, (p) => renderChart(p));
</script>

<template>
  <section
    class="bg-white dark:bg-[#13141C] rounded-2xl p-5 shadow-sm border border-slate-200 dark:border-slate-900"
  >
    <div
      class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6"
    >
      <div>
        <h2 class="font-bold text-lg">Sales Analytics</h2>
        <p class="text-sm text-slate-500">Net sales for the last 7 days</p>
      </div>
      <div class="flex items-center gap-2">
        <select
          v-model="period"
          class="text-sm bg-slate-100 dark:bg-[#0B0C11] rounded-lg outline-none focus:ring-2 focus:ring-orange-400 border-none"
        >
          <option value="7d">Last 7 days</option>
          <option value="30d">Last 30 days</option>
          <option value="year">This year</option>
        </select>
        <div
          class="flex items-center gap-1.5 text-xs text-slate-500 bg-slate-100 dark:bg-[#0B0C11] rounded-lg px-3 py-2"
        >
          <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Sales
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
      <!-- Bar chart -->
      <div class="lg:col-span-3">
        <div class="relative h-56 sm:h-64">
          <canvas ref="canvasEl"></canvas>
        </div>
      </div>

      <AnalyticsSummary class="lg:col-span-2" />
    </div>
  </section>
</template>
