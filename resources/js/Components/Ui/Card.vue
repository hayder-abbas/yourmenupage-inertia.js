<script setup>
defineProps({
  title: String,
  desc: String,
  img: String,
});
</script>

<template>
  <div class="flex items-center lg:flex-col mb-6 lg:mb-0">
    <div>
      <img :src="img" alt="Icon" loading="lazy" class="w-20 object-cover" />
    </div>
    <div class="p-2 ml-4 lg:ml-0 lg:text-center">
      <h3 class="font-extrabold text-lg">{{ title }}</h3>
      <p class="font-thin text-slate-700 text-sm">
        {{ desc }}
      </p>
    </div>
  </div>
</template>
