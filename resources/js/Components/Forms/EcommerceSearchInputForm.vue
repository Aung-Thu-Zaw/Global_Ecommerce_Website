<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed, reactive, ref, watch } from "vue";

// Define Veriables
const searchedKeyword = ref("");
const visibleHistory = ref(false);
const searchHistories = ref(usePage().props.searchHistories);

// Query String Parameter
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  sort: usePage().props.ziggy.query.sort
    ? usePage().props.ziggy.query.sort
    : "id",
  direction: usePage().props.ziggy.query.direction
    ? usePage().props.ziggy.query.direction
    : "desc",
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});

// Watch Search Input
watch(
  () => params.search,
  () => {
    searchedKeyword.value = params.search;
  }
);

// Handle Search Box
const handleSearch = () => {
  if (params.search || searchedKeyword.value) {
    params.search = params.search ? params.search : searchedKeyword.value;
    router.get(route("product.search"), {
      search: params.search,
      sort: params.sort,
      direction: params.direction,
      view: params.view,
    });
  } else {
    router.get(route("home"));
  }
};

const handleUpdateSearchHistory = (historyId) => {
  router.post(
    route("user.search.history.update", { search_history: historyId })
  );
};

// Global Ecommerce Suggestion Search
const searchSuggestions = computed(() => {
  if (params.search.length >= 1) {
    return searchHistories.value
      .filter(
        (history) =>
          history.keyword.includes(params.search) &&
          history.user_id !== usePage().props.auth.user?.id
      )
      .slice(0, 20);
  } else {
    return [];
  }
});

// Filtered User Search Histories
const filteredUserSearchHistories = computed(() => {
  const searchQuery = params.search.toLowerCase();

  if (usePage().props.auth.user) {
    return params.search === ""
      ? searchHistories.value
          .filter((history) => {
            return history.user_id === usePage().props.auth.user.id;
          })
          .slice(0, 10)
      : searchHistories.value
          .filter((history) => {
            const historyKeyword = history.keyword.toLowerCase();
            return (
              history.user_id === usePage().props.auth.user.id &&
              historyKeyword.includes(searchQuery)
            );
          })
          .slice(0, 10);
  } else {
    return [];
  }
});

// Handle Search Input
const handleSearchInputKeyword = (keyword) => {
  params.search = keyword;

  handleSearch();
};

// Highlisht Search Input Word
const highlightKeyword = (text) => {
  const keyword = searchedKeyword.value;
  if (keyword && text.includes(keyword)) {
    const regex = new RegExp(keyword, "gi");
    return text.replace(
      regex,
      `<span class="font-bold text-gray-800">${keyword}</span>`
    );
  }
  return text;
};

// Remove User Search History
const handleRemoveSearchHistory = (index, historyId) => {
  const updatedSearchHistories = [...filteredUserSearchHistories.value];
  updatedSearchHistories.splice(index, 1);
  searchHistories.value = updatedSearchHistories;
  handleUpdateSearchHistory(historyId);
};

const handleSearchHistoryBoxVisible = () => {
  visibleHistory.value =
    searchedKeyword.value || !visibleHistory.value ? true : false;
};
</script>

<template>
  <!-- backdrop -->
  <div
    v-if="visibleHistory"
    class="fixed top-0 bottom-0 left-0 right-0"
    @click="visibleHistory = false"
  ></div>

  <div class="w-[600px] relative">
    <form
      @submit.prevent="handleSearch()"
      class="w-[580px] flex flex-nowrap items-center"
    >
      <input
        @click="handleSearchHistoryBoxVisible"
        class="flex-grow appearance-none border border-gray-200 bg-gray-100 rounded-md mr-2 py-2 px-3 hover:border-gray-400 focus:ring-0 focus:outline-none focus:border-gray-400 placeholder:text-sm placeholder:text-gray-400"
        type="text"
        v-model="params.search"
        :placeholder="__('WHAT_ARE_YOU_LOOKING_FOR') + '?'"
      />
      <button
        type="submit"
        class="px-4 py-2 inline-block text-white border border-transparent bg-blue-600 rounded-md hover:bg-blue-700"
      >
        <i class="fa fa-search"></i>
      </button>
    </form>

    <!-- Search History And Suggestions -->
    <div
      v-if="
        visibleHistory &&
        (searchSuggestions.length || filteredUserSearchHistories.length) &&
        searchedKeyword.length > 0
      "
      class="border fixed z-50 rounded-md text-sm border-gray-200 mt-1 text-slate-700 font-semibold bg-white w-[520px] max-h-[400px] h-auto shadow overflow-auto scrollbar"
    >
      <!-- Your Search History -->
      <div v-if="filteredUserSearchHistories.length !== 0">
        <div class="px-3 py-2 flex items-center justify-between">
          <span class="text-[.8rem] text-slate-600">
            <i class="fa-solid fa-clock mr-1"></i>
            Your Search History
          </span>
        </div>
        <ul class="text-gray-600">
          <li
            v-for="(history, index) in filteredUserSearchHistories"
            :key="history.id"
            class="hover:bg-gray-100 font-normal text-[.8rem] px-3 py-2 cursor-pointer"
          >
            <span
              v-if="history.user_id === $page.props.auth.user?.id"
              class="flex items-center justify-between"
            >
              <span
                @click="handleSearchInputKeyword(history.keyword)"
                v-html="highlightKeyword(history.keyword)"
                class="w-full"
              >
              </span>
              <span class="cursor-pointer text-sm">
                <i
                  @click="handleRemoveSearchHistory(index, history.id)"
                  class="fa-solid fa-xmark hover:text-red-600"
                ></i>
              </span>
            </span>
          </li>
        </ul>
      </div>

      <!-- Global E-commerce Suggest -->
      <div v-if="params.search.length >= 1 && searchSuggestions.length !== 0">
        <div class="px-3 py-2 flex items-center justify-between">
          <span class="text-[.8rem] text-slate-600">
            <i class="fa-solid fa-lightbulb"></i>
            Global E-commerce Suggest
          </span>
        </div>
        <ul class="text-gray-600">
          <li
            v-for="history in searchSuggestions"
            :key="history.id"
            class="hover:bg-gray-100 font-normal text-[.8rem] px-3 py-2 cursor-pointer flex items-center justify-between"
          >
            <span
              @click="handleSearchInputKeyword(history.keyword)"
              v-html="highlightKeyword(history.keyword)"
              class="w-full"
            >
            </span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>


