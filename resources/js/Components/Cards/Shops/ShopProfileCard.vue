<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  sellerShops: Object,
});
</script>

<template>
  <div
    v-for="sellerShop in sellerShops"
    :key="sellerShop.id"
    class="shadow-md bg-white rounded-md flex items-center h-[180px]"
  >
    <div
      class="flex flex-col items-center justify-center w-[300px] h-full border-r border-r-slate-300 p-2"
    >
      <img
        :src="sellerShop.avatar"
        alt=""
        class="rounded-full w-12 h-12 object-cover ring-1 ring-gray-400 shadow-md"
      />
      <div class="mt-3 flex flex-col items-center justify-between">
        <h1 class="font-bold text-sm text-slate-600 text-center line-clamp-2">
          {{ sellerShop.shop_name }}
          <span v-if="sellerShop.offical" class="text-green-400 rounded-xl">
            <i class="fa-solid fa-circle-check ml-2"></i>
          </span>
        </h1>
      </div>
    </div>
    <div
      class="w-full h-full px-3 py-5 flex flex-col items-center justify-between"
    >
      <div class="flex items-start justify-between w-full">
        <div>
          <p
            class="text-md text-gray-600 font-semibold border-b border-b-slate-400 mb-2"
          >
            Products
          </p>
          <p class="text-sm text-gray-500 text-center">
            {{ sellerShop.products.length }}
          </p>
        </div>
        <div>
          <p
            class="text-md text-gray-600 font-semibold border-b border-b-slate-400 mb-2"
          >
            Followers
          </p>
          <p class="text-sm text-gray-500 text-center">
            {{ sellerShop.followers.length }}
          </p>
        </div>
      </div>

      <Link
        as="button"
        :href="route('shop.show', sellerShop.uuid)"
        :data="{ tab: 'home' }"
        class="border border-blue-600 px-2 py-2 text-blue-600 text-xs font-bold rounded-sm shadow hover:bg-blue-600 hover:text-white transition-all"
      >
        Go To Shop Profile
      </Link>
    </div>
  </div>
</template>

