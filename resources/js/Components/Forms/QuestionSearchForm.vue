<script setup>
import { usePage, router } from "@inertiajs/vue3";
import { reactive } from "vue";

const params = reactive({
  search_question: usePage().props.ziggy.query?.search_question,
  page: usePage().props.ziggy.query?.page,
});

// Handle Search
const handleSearch = () => {
  router.get(
    route("help-center.questions.search"),
    {
      search_question: params.search_question,
      page: params.page,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Remove Search Param
const removeSearch = () => {
  params.search_question = "";
  router.get(
    route("help-center.questions.search"),
    {},
    {
      replace: true,
      preserveState: true,
    }
  );
};
</script>

<template>
  <form @submit.prevent="handleSearch" class="w-[700px] h-[50px] mx-auto">
    <div class="flex items-center justify-between">
      <div class="relative">
        <input
          type="text"
          class="w-[650px] h-full py-3 rounded-md borde-2 border-slate-400 focus:ring-0 focus:border-slate-400"
          autofocus
          :placeholder="__('SEARCH_FOR_A_QUESTION')"
          v-model="params.search_question"
        />
        <i
          v-if="params.search_question"
          class="fa-solid fa-xmark remove-search"
          @click="removeSearch"
        ></i>
      </div>

      <button
        class="bg-blue-600 text-white px-6 py-3 h-full rounded-md hover:bg-blue-700 ml-2"
      >
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
    </div>
  </form>
</template>

