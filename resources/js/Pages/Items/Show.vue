<script setup>
import EditIcon from "@/Components/Icons/EditIcon.vue";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";
import DangerButton from "@/Components/Ui/DangerButton.vue";
import DeleteConfirmation from "@/Components/Ui/DeleteConfirmation.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import SecondaryButton from "@/Components/Ui/SecondaryButton.vue";
import { useAppStore } from "@/Stores/AppStore";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  item: Object,
});

const app = useAppStore();
const page = usePage();
const item = ref(props.item.data);
const isAuth = ref(
  page.props.auth.user && page.props.auth.user.id === item.value.userID,
);
</script>

<template>
  <div
    class="relative flex justify-center items-center min-h-screen bg-gray-50 dark:bg-gray-700"
  >
    <Head :title="item.title" />

    <div class="w-full md:max-w-2xl lg:max-w-4xl">
      <section
        class="w-full rounded-lg sm:grid grid-flow-row-dense grid-cols-3"
      >
        <div class="w-full shadow-xl">
          <img
            :src="`../storage/${item.image}`"
            :alt="item.title"
            class="h-80 w-96 sm:h-96 md:h-full md:rounded-lg object-cover"
            loading="lazy"
          />
        </div>

        <div class="sm:col-span-2 py-8 px-4 lg:py-16">
          <h2
            class="mb-2 text-xl font-bold leading-none text-gray-900 py-3 border border-b-gray-400 border-l-transparent border-r-transparent border-t-transparent md:text-2xl dark:text-white"
          >
            {{ item.title }}
          </h2>
          <div
            class="mb-4 text-xl font-bold leading-none text-gray-900 py-3 border border-b-gray-400 border-l-transparent border-r-transparent border-t-transparent md:text-2xl dark:text-white"
          >
            {{ item.price }}
            <span class="text-sm text-gray-500 dark:text-gray-400">dinar</span>
          </div>
          <dl>
            <dd
              class="mb-4 font-semibold text-gray-500 py-3 border border-b-gray-400 border-l-transparent border-r-transparent border-t-transparent sm:mb-5 dark:text-gray-400"
            >
              {{ item.description }}
            </dd>
          </dl>
          <dl class="flex flex-col">
            <dd
              class="mb-4 font-semibold py-3 border border-b-gray-400 border-l-transparent border-r-transparent border-t-transparent text-gray-500 sm:mb-5 dark:text-gray-400"
            >
              #{{ item.category.name }}
            </dd>
          </dl>

          <div
            v-if="isAuth"
            class="flex items-center justify-between space-x-4"
          >
            <div class="flex items-center gap-4">
              <PrimaryButton type="submit">
                <Link
                  :href="route('items.edit', item)"
                  class="flex items-center"
                >
                  <EditIcon class="mr-1 -ml-1 w-4 h-4" />
                  Edit
                </Link>
              </PrimaryButton>

              <SecondaryButton onclick="history.back()"> Back </SecondaryButton>

              <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
              >
              </Transition>
            </div>

            <DangerButton
              @click="app.openDeleteConfirmation = !app.openDeleteConfirmation"
            >
              <TrashIcon class="w-4 h-4 mr-1.5 -ml-1" />
              Delete
            </DangerButton>
          </div>

          <SecondaryButton v-else onclick="history.back()">
            Back
          </SecondaryButton>
        </div>
      </section>
    </div>
    <!-- Delete Modal -->
    <DeleteConfirmation :item="item" />
  </div>
</template>
