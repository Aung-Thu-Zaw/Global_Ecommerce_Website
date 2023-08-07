<template>
  <nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6"
  >
    <div
      class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto"
    >
      <button
        class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
        type="button"
        v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')"
      >
        <i class="fas fa-bars"></i>
      </button>
      <Link
        :href="route('home')"
        class="md:block text-left md:pb-2 text-slate-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
      >
        Global E-commerce
      </Link>
      <ul class="md:hidden items-center flex flex-wrap list-none">
        <li class="inline-block relative">
          <UserDropdown />
        </li>
      </ul>
      <div
        class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded"
        v-bind:class="collapseShow"
      >
        <div
          class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-slate-200"
        >
          <div class="flex flex-wrap">
            <div class="w-6/12">
              <Link
                :href="route('home')"
                class="md:block text-left md:pb-2 text-slate-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0"
              >
                Global E-commerce
              </Link>
            </div>
            <div class="w-6/12 flex justify-end">
              <button
                type="button"
                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                v-on:click="toggleCollapseShow('hidden')"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
        <form class="mt-6 mb-4 md:hidden">
          <div class="mb-3 pt-0">
            <input
              type="text"
              placeholder="Search"
              class="px-3 py-2 h-12 border border-solid border-slate-500 placeholder-slate-300 text-slate-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal"
            />
          </div>
        </form>

        <hr class="my-4 md:min-w-full" />

        <!-- Shop Control Area Section -->
        <h6
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("SELLER_SHOP_CONTROL_AREA") }}
        </h6>
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <li class="items-center">
            <Link
              :href="route('seller.dashboard')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url === '/seller/dashboard',
                'text-slate-700 hover:text-slate-500':
                  $page.url !== '/seller/dashboard',
              }"
            >
              <i class="fas fa-tv mr-2 text-sm"></i>
              {{ __("DASHBOARD") }}
            </Link>
          </li>
          <!-- Product Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'seller' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              :href="route('seller.products.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/seller/products'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/seller/products'),
              }"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
            >
              <i class="fa-solid fa-basket-shopping mr-2 text-sm"></i>
              {{ __("PRODUCTS") }}
            </Link>
          </li>
          <!-- Product Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'seller' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              :href="route('seller.product-banners.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/seller/product-banners'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/seller/product-banners'
                ),
              }"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
            >
              <i class="fa-solid fa-basket-shopping mr-2 text-sm"></i>
              {{ __("PRODUCT_BANNERS") }}
            </Link>
          </li>
          <!-- Order Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'seller' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              :href="route('seller.orders.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/seller/orders'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/seller/orders'),
              }"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
            >
              <i class="fa-solid fa-boxes-packing mr-2 text-sm"></i>
              {{ __("ORDERS") }}
            </Link>
          </li>
          <!-- Return Order Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'seller' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              href="#"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/seller/return-orders'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/seller/return-orders'
                ),
              }"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
            >
              <i class="fa-solid fa-rotate-left mr-2 text-sm"></i>
              {{ __("RETURN_ORDERS") }}
            </Link>
          </li>
          <!-- Cancel Order Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'seller' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              href="#"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/seller/cancel-orders'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/seller/cancel-orders'
                ),
              }"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
            >
              <i class="fa-solid fa-xmark mr-2 text-sm"></i>
              {{ __("CANCEL_ORDERS") }}
            </Link>
          </li>
          <!-- Product Review Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'seller' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              :href="route('seller.product-reviews.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/seller/product-reviews'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/seller/product-reviews'
                ),
              }"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
            >
              <i class="fa-solid fa-star mr-2 text-sm"></i>
              {{ __("PRODUCT_REVIEWS") }}
            </Link>
          </li>
          <!-- Shop Review Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'seller' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              :href="route('seller.shop-reviews.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/seller/shop-reviews'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/seller/shop-reviews'
                ),
              }"
              :data="{
                page: 1,
                per_page: 10,
                sort: 'id',
                direction: 'desc',
              }"
            >
              <i class="fa-solid fa-shop mr-2 text-sm"></i>
              {{ __("SHOP_REVIEWS") }}
            </Link>
          </li>
        </ul>

        <hr class="my-4 md:min-w-full" />

        <!-- Seller Support Section Title -->
        <h6
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("SELLER_SUPPORT") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Seller Guide Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'seller' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              :href="route('seller.dashboard.guide')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/seller/guide'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/seller/guide'),
              }"
            >
              <i class="fa-solid fa-book mr-2 text-sm"></i>
              {{ __("GUIDE") }}
            </Link>
          </li>

          <!-- Seller Support Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'seller' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              :href="route('seller.orders.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/seller/support'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/seller/support'),
              }"
            >
              <i class="fa-solid fa-headset mr-2 text-sm"></i>
              {{ __("SUPPORT") }}
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>


<script>
import { Link } from "@inertiajs/vue3";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";

export default {
  data() {
    return {
      collapseShow: "hidden",
    };
  },
  methods: {
    toggleCollapseShow: function (classes) {
      this.collapseShow = classes;
    },
  },
  components: {
    UserDropdown,
    Link,
  },
};
</script>
