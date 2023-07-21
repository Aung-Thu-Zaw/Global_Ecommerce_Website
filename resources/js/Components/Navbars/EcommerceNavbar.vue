<script setup>
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import LanguageDropdown from "@/Components/Dropdowns/LanguageDropdown.vue";
import { Link, router, useForm, usePage } from "@inertiajs/vue3";
import { computed, reactive, ref, watch } from "vue";
import { useReCaptcha } from "vue-recaptcha-v3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

// Define Veriables
const visibleHistory = ref(false);
const searchedKeyword = ref("");
const searchHistories = ref(usePage().props.searchHistories);

// Query String Parameter
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  sort: "id",
  direction: "desc",
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});

// Calculate Total Items
const totalItems = computed(() => {
  if (usePage().props.totalCartItems) {
    return usePage().props.totalCartItems.cart_items.reduce(
      (acc, item) => acc + item.qty,
      0
    );
  }
  return;
});

// Handle Order No Tracking
const form = useForm({
  order_no: "",
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleTrackOrder = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("track_order");

  form.post(route("order.track"), {
    onFinish: () => form.reset(),
    onSuccess: () => {
      if (usePage().props.flash.errorMessage) {
        toast.error(usePage().props.flash.errorMessage, {
          autoClose: 2000,
        });
      }
    },
  });
};

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
</script>


<template>
  <nav class="bg-blue-600 text-white">
    <div class="flex items-center justify-between px-10">
      <span class="text-sm font-bold">GLOBAL E-COMMERCE WEBSITE</span>
      <!-- Menus -->
      <nav class="hidden lg:flex flex-1 items-center justify-end py-1">
        <Link
          class="text-sm font-bold px-3 py-2 hover:text-gray-300 uppercase"
          :href="route('help-center')"
        >
          <i class="fa-solid fa-circle-info"></i>
          {{ __("HELP_CENTER") }}
        </Link>
        <span>|</span>

        <Link
          class="text-sm font-bold px-3 py-2 hover:text-gray-300 uppercase"
          :href="route('vendor.register')"
        >
          <i class="fa-solid fa-store"></i>
          {{ __("BECOME_A_SELLER") }}
        </Link>

        <span>|</span>

        <!-- Order Tracking -->
        <div
          class="text-sm font-bold px-3 py-2 hover:text-gray-300 cursor-pointer uppercase"
          data-dropdown-toggle="dropdownSearch"
          data-dropdown-placement="bottom"
          data-te-toggle="tooltip"
          data-te-placement="bottom"
          title="Check what happened to my products order?"
        >
          <i class="fa-solid fa-location-crosshairs"></i>
          {{ __("TRACK_MY_ORDER") }}
        </div>
        <div
          id="dropdownSearch"
          class="z-10 hidden bg-gray-50 rounded-lg shadow-md w-[300px] p-5"
        >
          <h4 class="font-bold text-lg mb-4 text-slate-700 text-center">
            <i class="fa-solid fa-location-crosshairs"></i>
            {{ __("TRACK_MY_ORDER") }}
          </h4>

          <!-- Order Tracking Search Box -->
          <form @submit.prevent="handleTrackOrder">
            <label for="" class="text-sm font-bold text-slate-800 mb-3">
              {{ __("ENTER_YOUR_ORDER_NUMBER") }}
            </label>
            <input
              type="text"
              class="w-full rounded-sm text-slate-800"
              placeholder="Eg. #e5353453er"
              v-model="form.order_no"
            />
            <button
              class="font-bold text-sm bg-blue-600 w-full py-2 px 4 my-3 hover:bg-blue-700"
            >
              {{ __("SEARCH") }}
            </button>
          </form>
        </div>

        <span>|</span>

        <!-- Change Languages Dropdown -->
        <LanguageDropdown />
      </nav>
    </div>
  </nav>

  <!-- Middle Navbar -->
  <header class="bg-white shadow-sm border border-b">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div class="py-3 md:flex items-center">
        <div class="flex items-center flex-shrink-0 mb-4 md:mb-0">
          <Link
            v-if="$page.props.websiteSetting.logo"
            :href="route('home')"
            class="mr-20 md:mr-3 lg:mr-24 pr-4 w-[200px]"
          >
            <img
              :src="$page.props.websiteSetting.logo"
              alt=""
              class="h-12 w-full object-cover"
            />
          </Link>
          <Link
            v-else
            :href="route('home')"
            class="mr-20 md:mr-3 lg:mr-24 pr-4 text-xl text-slate-600 font-bold"
          >
            Global E-commerce
          </Link>

          <div class="md:hidden ml-auto">
            <button
              type="button"
              class="bg-white p-3 inline-flex items-center justify-center rounded-md text-gray-400 font-semibold hover:bg-gray-200 hover:text-gray-800 border border-transparent"
            >
              <span class="sr-only">Open menu</span>
              <i class="fa fa-bars fa-lg"></i>
            </button>
          </div>
        </div>

        <div class="w-[600px] relative">
          <form
            @submit.prevent="handleSearch()"
            class="w-[580px] flex flex-nowrap items-center"
          >
            <input
              @click="visibleHistory = !visibleHistory"
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
              (searchSuggestions.length || filteredUserSearchHistories.length)
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
            <div
              v-if="params.search.length >= 1 && searchSuggestions.length !== 0"
            >
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

        <nav
          v-if="$page.props.auth.user"
          class="hidden md:flex justify-end flex-1 items-center"
        >
          <!-- User Profile Dropdown  -->
          <UserDropdown />

          <!-- My Cart Button -->
          <Link
            as="button"
            class="relative px-3 py-2 ml-5 inline-block text-center text-white bg-blue-600 shadow-sm border border-gray-300 rounded-md hover:bg-blue-700"
            :href="route('cart.index')"
          >
            <i class="w-5 fa fa-shopping-cart"></i>
            <span class="hidden lg:inline ml-1"> {{ __("MY_CART") }}</span>
            <span
              v-if="totalItems"
              class="bg-red-500 text-[.7rem] absolute -top-2 -right-2 w-5 h-5 p-2 rounded-full flex items-center justify-center"
            >
              {{ totalItems }}
            </span>
          </Link>
        </nav>

        <!-- Unauthorized User Actions -->
        <nav v-else class="hidden md:flex justify-end flex-1 items-center">
          <div class="flex items-center space-x-2 ml-auto">
            <Link
              as="button"
              class="px-3 py-2 inline-block text-center text-gray-700 bg-white shadow-sm border border-gray-200 rounded-md hover:bg-gray-100 hover:border-gray-300 uppercase"
              :href="route('register')"
            >
              <i class="text-gray-400 w-5 fa fa-user"></i>
              <span class="hidden lg:inline ml-1 text-sm font-bold">
                {{ __("SIGN_UP") }}
              </span>
            </Link>
            <Link
              as="button"
              class="px-3 py-2 inline-block text-center text-white bg-blue-500 shadow-sm border border-gray-200 rounded-md hover:bg-blue-700 uppercase"
              :href="route('login')"
            >
              <i class="w-5 fa fa-user"></i>
              <span class="hidden lg:inline ml-1 text-sm font-bold">
                {{ __("SIGN_IN") }}
              </span>
            </Link>
          </div>
        </nav>
      </div>
    </div>
  </header>
</template>



