<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <div>
    <Link
      :href="route('my-account.edit')"
      :data="{ tab: 'edit-profile' }"
      class="border border-gray-300 cursor-pointer w-[280px] h-[120px] rounded-md hover:shadow-md p-5 flex flex-col items-center justify-center"
    >
      <span
        class="w-10 h-10 text-sm rounded-full flex items-center justify-center shadow-lg bg-blue-600 text-white"
      >
        <i class="fa-solid fa-user-gear"></i>
      </span>
      <span class="text-gray-700 font-bold text-sm mt-3">My Account</span>
    </Link>
  </div>

  <div>
    <Link
      :href="route('my-orders.index')"
      :data="{ tab: 'all-orders' }"
      class="border border-gray-300 cursor-pointer w-[280px] h-[120px] rounded-md hover:shadow-md p-5 flex flex-col items-center justify-center"
    >
      <span
        class="w-10 h-10 text-sm rounded-full flex items-center justify-center shadow-lg bg-blue-600 text-white"
      >
        <i class="fa-solid fa-boxes-packing"></i>
      </span>
      <span class="text-gray-700 font-bold text-sm mt-3">My Orders</span>
    </Link>
  </div>

  <div>
    <Link
      :href="route('return-orders.index')"
      :data="{ tab: 'requested-return-orders' }"
      class="border border-gray-300 cursor-pointer w-[280px] h-[120px] rounded-md hover:shadow-md p-5 flex flex-col items-center justify-center"
    >
      <span
        class="w-10 h-10 text-sm rounded-full flex items-center justify-center shadow-lg bg-blue-600 text-white"
      >
        <i class="fa-solid fa-money-check-dollar"></i>
      </span>
      <span class="text-gray-700 font-bold text-sm mt-3"
        >Return Orders And Items</span
      >
    </Link>
  </div>

  <div>
    <Link
      :href="route('cancel-orders.index')"
      :data="{ tab: 'requested-cancel-orders' }"
      class="border border-gray-300 cursor-pointer w-[280px] h-[120px] rounded-md hover:shadow-md p-5 flex flex-col items-center justify-center"
    >
      <span
        class="w-10 h-10 text-sm rounded-full flex items-center justify-center shadow-lg bg-blue-600 text-white"
      >
        <i class="fa-solid fa-truck-fast"></i>
      </span>
      <span class="text-gray-700 font-bold text-sm mt-3"
        >Cancel Orders And Items</span
      >
    </Link>
  </div>
</template>

