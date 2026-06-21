<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  meta: Object,
  links: Object,
});

const pages = ref(props.meta.links);
</script>

<template>
  <div class="py-8 flex gap-4 items-center justify-end dark:text-white">
    <ul class="lg:flex gap-4">
      <li v-for="(page, index) in pages" :key="index" class="hidden lg:block">
        <Link
          as="button"
          :href="page.url ?? ''"
          v-html="page.label"
          class="px-4 py-2 rounded-md bg-amber-50 text-amber-600 disabled:opacity-40 disabled:cursor-not-allowed"
          :class="{ 'font-bold': page.active }"
          :disabled="!page.url"
        >
        </Link>
      </li>

      <li class="lg:hidden">
        <Link
          as="button"
          :href="links.next ?? ''"
          class="px-4 py-2 rounded-md bg-amber-50 text-amber-600 disabled:opacity-40 disabled:cursor-not-allowed"
          :disabled="!links.next"
        >
          Next
        </Link>
      </li>
    </ul>
  </div>
</template>
