<script setup>
import BarsIcon from "../Icons/BarsIcon.vue";
</script>

<template>
  <nav>
    <div class="flex items-center mx-auto p-4">
      <!-- Sidbar button -->
      <div class="xl:hidden">
        <BarsIcon
          @click="$emit('toggle')"
          class="h-7 w-7 text-gray-900 dark:text-gray-50 cursor-pointer"
        />
      </div>
    </div>
  </nav>
</template>
