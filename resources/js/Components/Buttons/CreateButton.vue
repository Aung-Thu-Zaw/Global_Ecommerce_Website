<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  href: String,
  name: String,
});
</script>

<template>
  <Link
    as="button"
    :href="route(href)"
    :data="{
      per_page: $page.props.ziggy.query?.per_page,
    }"
    class="text-sm px-4 shadow-md py-3 font-semibold rounded-[4px] bg-blue-600 text-white hover:bg-blue-700"
  >
    <span>
      <i class="fa-solid fa-file-circle-plus mr-2"></i>
      {{ __(name) }}
    </span>
  </Link>
</template>





