<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  href: String,
  queryStringParams: Object,
});
</script>

<template>
  <Link
    as="button"
    :href="route(href)"
    :data="{
      page: queryStringParams.page,
      per_page: queryStringParams.per_page,
      sort: queryStringParams.sort,
      direction: queryStringParams.direction,
    }"
    class="text-sm px-5 py-2.5 font-semibold rounded-[4px] bg-blue-600 text-white hover:bg-blue-700"
  >
    <span>
      <i class="fa-solid fa-circle-left"></i>
      {{ __("GO_BACK") }}
    </span>
  </Link>
</template>
