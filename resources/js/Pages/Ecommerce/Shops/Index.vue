<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import ShopProfileCard from "@/Components/Cards/Shops/ShopProfileCard.vue";
import { Head, usePage, router } from "@inertiajs/vue3";
import { reactive, watch } from "vue";

const props = defineProps({
  sellerShops: Object,
});

// Query String Parameters
const params = reactive({
  search_shop: usePage().props.ziggy.query?.search_shop,
});

// Handle Search Box
const handleSearch = () => {
  router.get(route("shop.index"), {
    search_shop: params.search_shop,
  });
};

// Watching Search Form
watch(
  () => params.search_shop,
  () => {
    if (params.search_shop === "") {
      router.get(route("shop.index"));
    } else {
      handleSearch();
    }
  }
);

// Remove Query String Search
const removeSearch = () => {
  params.search_shop = "";
  router.get(route("shop.index"));
};
</script>

<template>
  <AppLayout>
    <Head :title="__('OUR_SELLER_SHOPS')" />

    <section class="pt-10 min-h-[2300px] bg-gray-50 mt-40">
      <div class="container max-w-screen-xl mx-auto px-4">
        <!-- Cover Photo -->
        <div
          class="relative w-full h-[150px] mb-10 shadow-md rounded-md overflow-hidden border"
        >
          <img
            src="https://png.pngtree.com/thumb_back/fh260/back_our/20190614/ourmid/pngtree-happy-shopping-light-spot-poster-background-image_122448.jpg"
            class="w-full h-full object-cover"
          />
          <div
            class="absolute top-[50%] right-[50%] translate-x-[50%] -translate-y-[50%] text-2xl font-semibold text-white"
          >
            <p class="text-center uppercase">Our Seller Shops</p>
          </div>
        </div>

        <div class="flex items-center justify-end">
          <!-- Shop Search Form Input -->
          <form @submit.prevent="handleSearch" class="w-[350px] relative">
            <input
              type="text"
              class="search-input border border-gray-400 focus:border-gray-400"
              placeholder="Search by name"
              v-model="params.search_shop"
            />
            <i
              v-if="params.search_shop"
              class="fa-solid fa-xmark remove-search"
              @click="removeSearch"
            ></i>
          </form>
        </div>

        <div v-if="sellerShops.data.length" class="grid grid-cols-3 gap-3 my-3">
          <!-- Shop Profile Card -->
          <ShopProfileCard :sellerShops="sellerShops.data" />
        </div>
        <div v-else class="my-10">
          <p class="my-3 font-bold text-slate-500 text-center">
            {{
              __("WE'RE_SORRY_WE_CANNOT_FIND_ANY_MATCHES_FOR_YOUR_SEARCH_TERM")
            }}
          </p>
        </div>

        <!-- Shop Pagination -->
        <Pagination class="my-6" :links="sellerShops.links" />
      </div>
    </section>
  </AppLayout>
</template>


