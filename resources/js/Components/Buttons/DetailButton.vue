<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  href: String,
  slug: String | null,
  id: Number | null,
});
</script>

<template>
  <Link
    as="button"
    :href="route(href, slug ? slug : id)"
    :data="{
      page: $page.props.ziggy.query?.page,
      per_page: $page.props.ziggy.query?.per_page,
      sort: $page.props.ziggy.query?.sort,
      direction: $page.props.ziggy.query?.direction,
      created_from: $page.props.ziggy.query?.created_from,
      created_until: $page.props.ziggy.query?.created_until,
    }"
    class="text-sm px-5 py-2 border-[3px] border-sky-700 font-semibold rounded-[4px] shadow-md bg-sky-600 text-white transition-all hover:bg-sky-700 mr-3 my-1 group"
  >
    <span class="group-hover:animate-pulse">
      <i class="fa-solid fa-eye"></i>
      {{ __("DETAILS") }}
    </span>
  </Link>
</template>




