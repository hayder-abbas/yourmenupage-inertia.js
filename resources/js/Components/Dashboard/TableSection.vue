<script setup>
import DeleteConfirmation from "@/Components/Ui/DeleteConfirmation.vue";
import PrimaryButton from "../Ui/PrimaryButton.vue";
import SecondaryButton from "../Ui/SecondaryButton.vue";
import DangerButton from "../Ui/DangerButton.vue";
import Pagination from "./Pagination.vue";
import ActionsButton from "./ActionsButton.vue";
import SearchBar from "./SearchBar.vue";
import AddItemButton from "./AddItemButton.vue";
import SortIcon from "../Icons/SortIcon.vue";
import RecordDropdown from "./RecordDropdown.vue";
import EyeIcon from "../Icons/EyeIcon.vue";
import EditIcon from "../Icons/EditIcon.vue";
import TrashIcon from "../Icons/TrashIcon.vue";
import TData from "../Table/TData.vue";
import THeader from "../Table/THeader.vue";
import { reactive, ref, watch } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { useDebounceFn } from "@vueuse/core";
import { useDashboardStore } from "@/Stores/DashboardStore";
import { useAppStore } from "@/Stores/AppStore";

const props = defineProps({
  items: Object,
  filters: Object,
});

const app = useAppStore();
const dashboard = useDashboardStore();
const itemClicked = ref(null);

let params = reactive({
  search: props.filters.search,
  field: props.filters.field ?? "id",
  direction: props.filters.direction ?? "asc",
});

function sort(field) {
  params.field = field;
  params.direction = params.direction === "asc" ? "desc" : "asc";
}

watch(
  params,
  useDebounceFn(() => {
    let p = params;

    Object.keys(p).forEach((key) => {
      if (p[key] === "") {
        delete p[key];
      }
    });

    router.get(route("dashboard"), p, {
      preserveState: true,
      replace: true,
    });
  }, 300),
);

function openActionsRecord(item) {
  dashboard.openRecordDropdown = !dashboard.openRecordDropdown;
  itemClicked.value = item;
}

// function updatePaginateNumber(link: any) {
//   let pageNum = link.url.split("=")[1];
//   router.visit("/dashboard?page=" + pageNum, {
//     preserveScroll: true,
//   });
// }
</script>

<template>
  <section class="bg-gray-50 dark:bg-gray-800 p-4 sm:p-0 sm:rounded-lg mx-auto">
    <div class="mx-auto w-full">
      <!-- Start coding here -->
      <div class="bg-white dark:bg-gray-800 relative sm:rounded-lg">
        <div
          class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4"
        >
          <!-- Search -->
          <SearchBar v-model="params.search" />

          <div
            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0"
          >
            <!-- Add Item Button -->
            <AddItemButton />

            <!-- Actions Button -->
            <div class="flex items-center space-x-3 w-full md:w-auto">
              <ActionsButton
                @click="
                  dashboard.openActionButton = !dashboard.openActionButton
                "
              />
            </div>
          </div>
        </div>

        <!-- Start Table -->
        <div class="w-full overflow-scroll">
          <table
            class="relative w-[56rem] lg:w-full min-h-36 text-gray-500 dark:text-gray-400"
          >
            <thead
              class="w-full text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr class="flex justify-between items-center">
                <THeader @click="sort('id')" class="flex-none">
                  <span>#ID</span>
                  <SortIcon />
                </THeader>

                <THeader @click="sort('title')">
                  <span>Title</span>
                  <SortIcon />
                </THeader>

                <THeader @click="sort('category')">
                  <span>Category</span>
                  <SortIcon />
                </THeader>

                <THeader @click="sort('price')">
                  <span>Price</span>
                  <SortIcon />
                </THeader>

                <THeader @click="sort('restaurant')">
                  <span>Restaurant</span>
                  <SortIcon />
                </THeader>

                <THeader class="hidden lg:flex"> Action </THeader>
              </tr>
            </thead>

            <tbody class="w-full">
              <tr
                v-if="items.data.length > 0"
                v-for="(item, index) in items.data"
                :key="index"
                @click="openActionsRecord(item)"
                class="w-full flex justify-between items-center border-b dark:border-gray-700 dark:hover:bg-gray-900 hover:bg-gray-100"
              >
                <THeader class="flex-none w-20">
                  {{ item.id }}
                </THeader>

                <TData>
                  {{ item.title }}
                </TData>

                <TData>
                  {{ item.category.name }}
                </TData>

                <TData>
                  {{ item.price }}
                </TData>

                <TData>
                  {{ item.restaurant.name }}
                </TData>

                <TData class="hidden lg:flex">
                  <!-- Show Item Button -->
                  <SecondaryButton type="button" class="w-6 h-8">
                    <Link :href="route('item.show', item)">
                      <EyeIcon class="w-5 h-5" />
                    </Link>
                  </SecondaryButton>

                  <!-- Edit Item Button -->
                  <PrimaryButton type="button" class="w-6 h-8">
                    <Link :href="route('items.edit', item)">
                      <EditIcon class="w-5 h-5" />
                    </Link>
                  </PrimaryButton>

                  <!-- Delete Item Button -->
                  <DangerButton
                    type="button"
                    @click="app.openDeleteConfirmation = true"
                    class="w-6 h-8"
                  >
                    <div>
                      <TrashIcon class="w-5 h-5" />
                    </div>
                  </DangerButton>
                </TData>
              </tr>
              <tr
                v-else
                class="w-full border-b dark:border-gray-700 dark:hover:bg-gray-700 hover:bg-gray-100"
              >
                <th class="px-4 py-3 text-center">Table is empty!</th>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Record Dropdown -->
        <RecordDropdown v-if="itemClicked" :item="itemClicked" />

        <!-- Pagination -->
        <Pagination :meta="items.meta" />
      </div>
    </div>

    <!-- Delete Modal -->
    <DeleteConfirmation :item="itemClicked" />
  </section>
</template>
