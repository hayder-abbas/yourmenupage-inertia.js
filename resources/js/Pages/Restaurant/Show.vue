<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { reactive, ref, watchEffect } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import PhoneIcon from "@/Components/Icons/PhoneIcon.vue";
import MapPinIcon from "@/Components/Icons/MapPinIcon.vue";
import EditIcon from "@/Components/Icons/EditIcon.vue";
import Notification from "@/Components/Global/Notification.vue";
import CreateItemForm from "@/Components/ItemComponents/CreateItemForm.vue";
import PrimaryButton from "@/Components/Ui/PrimaryButton.vue";
import CardItem from "@/Components/ItemComponents/CardItem.vue";

defineOptions({ layout: AppLayout });

const props = defineProps({
  restaurant: Object,
  items: Array,
  categories: Array,
});

const restData = reactive(props.restaurant);
const logoSrc = restData.restLogo
  ? ref(`/storage/${restData.restLogo}`)
  : ref("/storage/default.png");

const status = reactive({
  name: null,
  message: {
    "restaurant-updated": "Restaurant updated successfully!",
    "item-created": "Item created successfully!",
    "item-updated": "Item updated successfully!",
    "item-deleted": "Item deleted successfully!",
  },
});

watchEffect(() => {
  status.name = usePage().props.flash?.status;
});
</script>

<template>
  <section
    class="mb-8 lg:px-0 mx-auto w-full md:max-w-2xl lg:max-w-4xl xl:max-w-7xl"
  >
    <Head :title="`${restData.restName} Menu`" />
    <!-- Notification Message -->
    <Notification
      :status="status.name"
      :message="status.message[status.name]"
      @closeNotification="status.name = null"
    />

    <div
      class="flex flex-col md:flex-row my-8 p-4 dark:bg-gray-900 rounded-md shadow-lg"
    >
      <div class="w-48 mb-4 md:mb-0 md:mr-4 md:basis-1/3 xl:basis-1/5">
        <img
          :src="logoSrc"
          alt="Restaurant Logo"
          class="rounded-md aspect-square object-cover"
        />
      </div>

      <header class="w-full md:basis-2/3 xl:basis-4/5 dark:text-white">
        <div class="flex-1">
          <h1 class="font-extrabold text-3xl mb-2">
            {{ restData.restName }}
          </h1>
          <div class="mb-2">{{ restData.restDesc }}</div>
          <div class="flex items-center gap-2 mb-2">
            <MapPinIcon class="w-4 h-4" /> {{ restData.location }}
          </div>
          <div class="flex items-center mb-2">
            <PhoneIcon class="w-4 h-4 mr-2" />
            <div>
              <div v-for="phone in restData.phones" :key="phone.id">
                {{ phone.phoneNumber }}
              </div>
            </div>
          </div>
          <div class="mb-2">
            <div class="text-green-600">Open: {{ restData.openAt }}</div>
            <div class="text-red-600">Close: {{ restData.closeAt }}</div>
          </div>
        </div>

        <div class="flex justify-end flex-col sm:flex-row gap-2">
          <!-- Add Item Form -->
          <CreateItemForm :restID="restData.id" :categories="categories" />
          <!-- Edit Restaurant Form -->
          <PrimaryButton>
            <EditIcon class="w-5 h-5 mr-2" />
            <Link :href="route('restaurant.edit', restData)">
              Edit Restaurant
            </Link>
          </PrimaryButton>
        </div>
      </header>
    </div>

    <div class="grid lg:grid-cols-6 xl:grid-cols-8 gap-4 dark:text-white">
      <article class="p-4 md:p-0 lg:col-span-4 xl:col-span-6 h-fit">
        <h2 class="font-bold text-3xl mb-6">⭐ Popular Items</h2>
        <!-- Items -->
        <div class="grid xl:grid-cols-2 gap-4">
          <CardItem v-for="item in items" :key="item.id" :item="item" />
        </div>
      </article>

      <aside class="hidden lg:col-span-2 xl:col-span-2 lg:block">
        <!-- Cart -->
        <div
          class="p-4 border border-slate-200 rounded-md w-full h-[38rem] sticky top-16 right-0"
        >
          <h3 class="mb-5 text-xl font-bold">Takeout order</h3>

          <div class="grid grid-cols-2 justify-between space-x-4">
            <div class="text-center p-2 border border-gray-300 rounded-md">
              Delivery
            </div>
            <div class="text-center p-2 border border-gray-300 rounded-md">
              Takeout
            </div>
          </div>

          <div class="h-96">
            <p>Add menu items to your order.</p>
          </div>
        </div>
      </aside>
    </div>
  </section>
</template>
