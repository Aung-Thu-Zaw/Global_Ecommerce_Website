<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <button
    id="dropdownSellersButton"
    data-dropdown-toggle="dropdownSellers"
    data-dropdown-placement="bottom"
    data-dropdown-trigger="hover"
    class="flex items-center justify-between w-full pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto"
  >
    <i class="fa-solid fa-shop mr-2"></i>
    {{ __("OUR_SELLER_SHOPS") }}
    <svg
      class="w-5 h-5 ml-1"
      aria-hidden="true"
      fill="currentColor"
      viewBox="0 0 20 20"
      xmlns="http://www.w3.org/2000/svg"
    >
      <path
        fill-rule="evenodd"
        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
        clip-rule="evenodd"
      ></path>
    </svg>
  </button>
  <!-- Dropdown menu -->
  <div
    id="dropdownSellers"
    class="z-40 hidden bg-white shadow-md w-[320px] h-[350px] border border-slate-300"
  >
    <ul
      class="h-full py-2 overflow-y-auto text-gray-700 scrollbar"
      aria-labelledby="dropdownSellersButton"
    >
      <li v-for="seller in $page.props.sellers" :key="seller.id">
        <Link
          :href="route('shop.show', seller.uuid)"
          :data="{ tab: 'home' }"
          class="flex items-center px-4 py-2 hover:bg-gray-100"
        >
          <img
            class="w-6 h-6 mr-2 rounded-full"
            :src="seller.avatar"
            alt="Jese image"
          />
          {{ seller.shop_name }}
          <span v-if="seller.offical" class="text-green-400 rounded-xl">
            <i class="fa-solid fa-circle-check ml-2"></i>
          </span>
        </Link>
      </li>
    </ul>
    <Link
      as="button"
      :href="route('shop.index')"
      class="flex items-center justify-center p-3 w-full text-sm font-bold text-slate-600 border bg-white hover:bg-gray-100 hover:text-blue-600 border-slate-300"
    >
      <i class="fas fa-eye mr-2"></i>
      {{ __("VIEW_MORE") }}
    </Link>
  </div>
</template>
