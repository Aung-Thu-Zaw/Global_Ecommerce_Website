<script setup>
import { usePage, router } from "@inertiajs/vue3";
import Pagination from "@/Components/Paginations/Pagination.vue";
import { reactive } from "vue";

const params = reactive({
  search_question: usePage().props.ziggy.query?.search_question,
  category: usePage().props.ziggy.query?.category,
  page: usePage().props.ziggy.query?.page,
});

// Handle Search
const handleSearch = () => {
  router.get(
    route("faqs.index"),
    {
      search_question: params.search_question,
      category: params.category,
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
    route("faqs.index"),
    {
      category: params.category,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};
</script>

<template>
  <div class="flex flex-col items-start mb-6">
    <div>
      <form @submit.prevent="handleSearch" class="w-[700px] h-[50px]">
        <div class="flex items-center justify-between">
          <div class="relative">
            <input
              type="text"
              class="w-[650px] h-full py-3 rounded-md borde-2 border-slate-400 focus:ring-0 focus:border-slate-400"
              autofocus
              placeholder="Search for a question..."
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
    </div>
  </div>
</template>

