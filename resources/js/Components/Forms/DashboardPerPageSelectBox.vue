<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { watch, ref } from "vue";

const props = defineProps({
  href: String,
});

const per_page = ref(usePage().props.ziggy.query?.per_page);

// Watching Perpage Select Box
watch(
  () => per_page.value,
  () => {
    router.get(
      route(props.href),
      {
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: per_page.value,
        sort: usePage().props.ziggy.query?.sort,
        direction: usePage().props.ziggy.query?.direction,
        created_from: usePage().props.ziggy.query?.created_from,
        created_until: usePage().props.ziggy.query?.created_until,
        deleted_from: usePage().props.ziggy.query?.deleted_from,
        deleted_until: usePage().props.ziggy.query?.deleted_until,
      },
      {
        replace: true,
        preserveState: true,
      }
    );
  }
);
</script>

<template>
  <select
    class="py-3 w-[80px] border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
    v-model="per_page"
  >
    <option value="" disabled>Select</option>
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="25">25</option>
    <option value="50">50</option>
    <option value="75">75</option>
    <option value="100">100</option>
  </select>
</template>

