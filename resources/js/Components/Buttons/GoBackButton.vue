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
      page: $page.props.ziggy.query?.page,
      per_page: $page.props.ziggy.query?.per_page,
      sort: $page.props.ziggy.query?.sort,
      direction: $page.props.ziggy.query?.direction,
      created_from: $page.props.ziggy.query?.created_from,
      created_until: $page.props.ziggy.query?.created_until,
    }"
    class="text-sm px-5 py-2.5 font-semibold rounded-[4px] bg-blue-600 text-white hover:bg-blue-700"
  >
    <span>
      <i class="fa-solid fa-circle-left"></i>
      {{ __("GO_BACK") }}
    </span>
  </Link>
</template>
