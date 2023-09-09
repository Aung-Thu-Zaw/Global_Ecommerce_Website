<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const search = ref(usePage().props.ziggy.query.search);

// Handle Search
const handleSearch = () => {
  router.get(
    route("admin.live-chats.index"),
    {
      search: search.value,
      tab: usePage().props.ziggy.query?.tab,
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
    route("admin.live-chats.index"),
    {
      tab: usePage().props.ziggy.query?.tab,
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
  <div class="bg-white border-b px-2 py-[11px]">
    <form
      class="w-full border-b flex items-center justify-between border-2 border-gray-300 py-0.5 px-2 rounded-sm"
    >
      <input
        type="text"
        class="w-full border-none focus:ring-0 text-sm"
        :placeholder="__('SEARCH_CHAT')"
        v-model="search"
      />
      <i
        v-if="search"
        class="fa-solid fa-xmark ml-1 text-sm cursor-pointer text-gray-600 hover:text-red-600"
        @click="removeSearch"
      ></i>
    </form>
  </div>
</template>

