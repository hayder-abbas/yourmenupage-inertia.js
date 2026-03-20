<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import CardItem from "@/Components/Global/CardItem.vue";
import { Head } from "@inertiajs/vue3";

defineOptions({ layout: AppLayout });
defineProps({
  items: Object,
  restaurant: Object,
});
</script>

<template>
  <div>
    <Head title="Restaurant Menu" />

    <section
      class="antialiased px-4 mb-8 lg:px-0 mx-auto w-full md:max-w-2xl lg:max-w-4xl xl:max-w-5xl"
    >
      <div class="mx-auto px-4 py-8 md:px-0">
        <h1
          class="font-extrabold dark:text-gray-50 text-4xl text-gray-900 leading-tight"
        >
          {{ restaurant?.name }} Menu
        </h1>
      </div>

      <div>
        <!-- Heading & Filters -->
        <div
          class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8"
        >
          <div class="flex items-center space-x-4">
            <button
              id="sortDropdownButton1"
              data-dropdown-toggle="dropdownSort1"
              type="button"
              class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto"
            >
              <svg
                class="-ms-0.5 me-2 h-4 w-4"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M7 4v16M7 4l3 3M7 4 4 7m9-3h6l-6 6h6m-6.5 10 3.5-7 3.5 7M14 18h4"
                />
              </svg>
              Sort
              <svg
                class="-me-0.5 ms-2 h-4 w-4"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="m19 9-7 7-7-7"
                />
              </svg>
            </button>
            <div
              id="dropdownSort1"
              class="z-50 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700"
              data-popper-placement="bottom"
            >
              <ul
                class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400"
                aria-labelledby="sortDropdownButton"
              >
                <li>
                  <a
                    href="#"
                    class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                  >
                    The most popular
                  </a>
                </li>
                <li>
                  <a
                    href="#"
                    class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                  >
                    Newest
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="mb-4 md:mb-8 grid sm:grid-cols-2 gap-4">
          <!-- Card Item -->
          <CardItem v-for="item in items?.data" :key="item.id" :item="item" />
        </div>
        <div class="w-full text-center">
          <button
            type="button"
            class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
          >
            Show more
          </button>
        </div>
      </div>
    </section>
  </div>
</template>
