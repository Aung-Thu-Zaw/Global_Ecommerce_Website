<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { computed, inject, reactive, ref } from "vue";
import Home from "./Partials/Home.vue";
import AllProducts from "./Partials/AllProducts.vue";
import ShopRating from "./Partials/ShopRating.vue";
import ProductRating from "./Partials/ProductRating.vue";
import { usePage, router, Link, Head } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
  vendorShops: Object,
});
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

        <div class="grid grid-cols-5 gap-3 my-3">
          <Link
            v-for="vendorShop in vendorShops.data"
            :key="vendorShop.id"
            as="button"
            :href="route('shop.show', vendorShop.id)"
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
                <span class="text-green-400 rounded-xl">
                  <i class="fa-solid fa-circle-check ml-2"></i>
                </span>
              </h1>
            </div>
          </Link>
        </div>

        <!-- Pagination -->
        <Pagination class="my-6" :links="vendorShops.links" />
      </div>
    </section>
  </AppLayout>
</template>


