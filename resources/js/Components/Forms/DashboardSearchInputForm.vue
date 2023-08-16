<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { watch, reactive } from "vue";

const props = defineProps({
  href: String,
  placeholder: String,
});

const params = reactive({
  search: usePage().props.ziggy.query?.search,
  per_page: usePage().props.ziggy.query?.per_page,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  created_from: usePage().props.ziggy.query?.created_from,
  created_until: usePage().props.ziggy.query?.created_until,
  deleted_from: usePage().props.ziggy.query?.deleted_from,
  deleted_until: usePage().props.ziggy.query?.deleted_until,
});

// Handle Search
const handleSearch = () => {
  router.get(
    route(props.href),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: params.created_until,
      deleted_from: params.deleted_from,
      deleted_until: params.deleted_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Remove Search Param
const removeSearch = () => {
  params.search = "";
  router.get(
    route(props.href),
    {
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: params.created_until,
      deleted_from: params.deleted_from,
      deleted_until: params.deleted_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Watching Search Box
watch(
  () => params.search,
  () => {
    if (params.search === "") {
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
      v-model="params.search"
    />
    <i
      v-if="params.search"
      class="fa-solid fa-xmark remove-search"
      @click="removeSearch"
    ></i>
  </form>
</template>

