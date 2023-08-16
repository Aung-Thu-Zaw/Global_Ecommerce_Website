<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { watch, ref } from "vue";

const props = defineProps({
  href: String,
  placeholder: String,
});

const search = ref(usePage().props.ziggy.query?.search);

// Handle Search
const handleSearch = () => {
  router.get(
    route(props.href),
    {
      search: search.value,
      per_page: usePage().props.ziggy.query?.per_page,
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
};

// Remove Search Param
const removeSearch = () => {
  search.value = "";
  router.get(
    route(props.href),
    {
      per_page: usePage().props.ziggy.query?.per_page,
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
};

// Watching Search Box
watch(
  () => search.value,
  () => {
    if (search.value === "") {
      removeSearch();
    } else {
      handleSearch();
    }
  }
);
</script>

<template>
  <form class="w-[350px] relative">
    <input
      type="text"
      class="rounded-md border border-gray-300 focus:ring-0 focus:border-gray-300 text-sm p-3 w-full"
      :placeholder="__(placeholder)"
      v-model="search"
    />
    <i
      v-if="search"
      class="fa-solid fa-xmark remove-search"
      @click="removeSearch"
    ></i>
  </form>
</template>

