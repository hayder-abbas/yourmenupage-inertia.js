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
    <Link
      v-show="links.prev"
      :href="links.prev ?? ''"
      class="hidden lg:block bg-amber-100 text-amber-600 px-4 py-2 rounded-md"
    >
      Previous
    </Link>

    <ul class="hidden lg:flex gap-4">
      <li v-for="(page, index) in pages" :key="index">
        <Link
          :href="page.url ?? ''"
          class="px-4 py-2 text-xl rounded-md cursor-pointer"
          :class="{
            'bg-amber-100 text-amber-600 font-bold': page.active,
            hidden: index === 0 || index === pages.length - 1,
          }"
        >
          {{ page.label }}
        </Link>
      </li>
    </ul>

    <Link
      :href="links.next ?? ''"
      class="bg-amber-100 text-amber-600 px-4 py-2 rounded-md"
    >
      Next
    </Link>
  </div>
</template>
