<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  href: String,
});
</script>

<template>
  <Link
    as="button"
    :href="route(href)"
    :data="{
      page: 1,
      per_page: 10,
      sort: 'id',
      direction: 'desc',
    }"
    class="text-sm px-5 py-2.5 shadow-md font-semibold rounded-[4px] bg-red-600 text-white hover:bg-red-700 group"
  >
    <span class="group-hover:animate-pulse">
      <i class="fa-solid fa-trash-can-arrow-up"></i>
      {{ __("TRASH") }}
    </span>
  </Link>
</template>

