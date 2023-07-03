<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, usePage, router } from "@inertiajs/vue3";
import Pagination from "@/Components/Paginations/Pagination.vue";
import { reactive, ref, watch } from "vue";

const props = defineProps({
  vendorShops: Object,
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
const handelRemoveSearch = () => {
  params.search_shop = "";
  router.get(route("shop.index"));
};
</script>


<template>
  <AppLayout>
    <Head title="Seller Shops" />

    <section class="pt-10 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
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

        <!-- Search Box -->
        <div>
          <form
            @submit.prevent="handleSearch"
            class="flex items-center justify-end"
          >
            <div
              class="border-2 border-slate-300 rounded-md focus:ring-0 focus:border-slate-300 w-[300px] flex items-center justify-between"
            >
              <input
                type="text"
                class="border-none focus:ring-0 w-full"
                placeholder="Search by shop name"
                v-model="params.search_shop"
              />
              <i
                v-if="params.search_shop"
                @click="handelRemoveSearch"
                class="fa-solid fa-xmark mx-2 cursor-pointer hover:text-slate-600"
              ></i>
            </div>
          </form>
        </div>

        <div class="grid grid-cols-5 gap-3 my-3">
          <Link
            v-for="vendorShop in vendorShops.data"
            :key="vendorShop.id"
            as="button"
            :href="route('shop.show', vendorShop.uuid)"
            :data="{ tab: 'home' }"
            class="hover:shadow-lg border rounded-md p-3 flex flex-col items-center justify-center"
          >
            <img
              :src="vendorShop.avatar"
              alt=""
              class="rounded-full w-24 h-24 object-cover ring-2 ring-gray-400 shadow-md"
            />
            <div class="my-3">
              <h1 class="font-bold text-slate-600 text-center">
                {{ vendorShop.shop_name }}
                <span
                  v-if="vendorShop.offical"
                  class="text-green-400 rounded-xl"
                >
                  <i class="fa-solid fa-circle-check ml-2"></i>
                </span>
              </h1>
            </div>
          </Link>
        </div>

        <Pagination class="my-6" :links="vendorShops.links" />
      </div>
    </section>
  </AppLayout>
</template>


