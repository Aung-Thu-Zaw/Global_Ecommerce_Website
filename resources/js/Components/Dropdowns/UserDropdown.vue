<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <button
    id="dropdownUserAvatarButton"
    data-dropdown-toggle="dropdownAvatar"
    type="button"
  >
    <div class="items-center flex">
      <span
        class="w-12 h-12 text-sm text-white bg-slate-200 inline-flex items-center justify-center rounded-full ring-2"
      >
        <img
          alt=""
          class="w-full h-full object-cover rounded-full align-middle border-none shadow-lg ring-1 ring-slate-300"
          :src="$page.props.auth.user?.avatar"
        />
      </span>

      <span
        v-if="$page.url.startsWith('/admin') || $page.url.startsWith('/seller')"
        class="font-bold ml-2"
        :class="{
          'text-slate-600 md:text-white':
            $page.url === '/admin/dashboard' ||
            $page.url === '/seller/dashboard',

          'text-white':
            $page.url !== '/admin/dashboard' ||
            $page.url !== '/seller/dashboard',
        }"
        >{{ $page.props.auth.user.name }}
      </span>
      <span v-else class="font-bold ml-2 text-slate-600"
        >{{ $page.props.auth.user.name }}
      </span>
    </div>
  </button>

  <!-- Dropdown menu -->
  <div
    id="dropdownAvatar"
    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow border w-auto"
  >
    <ul
      class="py-2 text-sm text-gray-700 dark:text-gray-200"
      aria-labelledby="dropdownUserAvatarButton"
    >
      <!-- Go To User Account Information Page -->
      <li>
        <Link
          :href="route('my-account.edit')"
          :data="{ tab: 'edit-profile' }"
          class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
        >
          <i class="fa-solid fa-address-card mr-3"></i>
          {{ __("MY_ACCOUNT") }}
        </Link>
      </li>
      <!-- Go To Seller Own Shop -->
      <li>
        <Link
          v-if="
            $page.props.auth.user?.role === 'seller' &&
            $page.props.auth.user?.status === 'active'
          "
          :href="route('shop.show', $page.props.auth.user.uuid)"
          :data="{ tab: 'home' }"
          class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
        >
          <i class="fa-solid fa-store mr-3"></i>
          {{ __("MY_SHOP") }}
        </Link>
      </li>
      <!-- Go To User Order List Page -->
      <li>
        <Link
          :href="route('my-orders.index')"
          :data="{ tab: 'all-orders' }"
          class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
        >
          <i class="fa-solid fa-bag-shopping mr-3"></i>
          {{ __("MY_ORDERS") }}
        </Link>
      </li>
      <!-- Go To User Return Orders Page -->
      <li>
        <Link
          :href="route('return-orders.index')"
          :data="{ tab: 'requested-return-orders' }"
          class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
        >
          <i class="fa-solid fa-rotate-left mr-3"></i>
          {{ __("RETURN_ORDERS_AND_ITEMS") }}
        </Link>
      </li>
      <!-- Go To User Cancel Orders Page -->
      <li>
        <Link
          :href="route('cancel-orders.index')"
          :data="{ tab: 'requested-cancel-orders' }"
          class="text-left text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
        >
          <i class="fa-solid fa-xmark mr-3"></i>
          {{ __("CANCEL_ORDERS_AND_ITEMS") }}
        </Link>
      </li>
      <!-- Go To User Saved Watchlist List -->
      <li>
        <Link
          :href="route('watchlists.index')"
          class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
        >
          <i class="fa-solid fa-heart mr-3"></i>
          {{ __("MY_WATCHLIST") }}
        </Link>
      </li>
      <!-- Go To User Followed Shop List -->
      <li>
        <Link
          :href="route('user.shop.followed')"
          class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-slate-700 hover:bg-slate-200"
        >
          <i class="fa-solid fa-store mr-3"></i>
          {{ __("FOLLOWED_SHOPS") }}
        </Link>
      </li>
    </ul>
    <div class="py-2">
      <!-- Authenticated User Logout -->
      <Link
        method="post"
        :href="route('logout')"
        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
      >
        <i class="fa-solid fa-right-from-bracket mr-3"></i>

        {{ __("LOGOUT") }}
      </Link>
    </div>
  </div>
</template>
