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
          <NotificationDropdown />
        </li>
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
        <h6
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("VENDOR_WEB_CONTROL_AREA") }}
        </h6>
        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <li class="items-center">
            <Link
              :href="route('vendor.dashboard')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url === '/vendor/dashboard',
                'text-slate-700 hover:text-slate-500':
                  $page.url !== '/vendor/dashboard',
              }"
            >
              <i class="fas fa-tv mr-2 text-sm"></i>
              {{ __("DASHBOARD") }}
            </Link>
          </li>
          <!-- Product Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'vendor' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              :href="route('vendor.products.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/vendor/products'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/vendor/products'),
              }"
            >
              <i class="fa-solid fa-basket-shopping mr-2 text-sm"></i>
              {{ __("PRODUCTS") }}
            </Link>
          </li>
          <!-- Product Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'vendor' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              :href="route('vendor.product-banners.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600': $page.url.startsWith(
                  '/vendor/product-banners'
                ),
                'text-slate-700 hover:text-slate-500': !$page.url.startsWith(
                  '/vendor/product-banners'
                ),
              }"
            >
              <i class="fa-solid fa-basket-shopping mr-2 text-sm"></i>
              {{ __("PRODUCT_BANNERS") }}
            </Link>
          </li>
          <!-- Order Section -->
          <li
            v-if="
              $page.props.auth.user.role === 'vendor' &&
              $page.props.auth.user.status === 'active'
            "
            class="items-center"
          >
            <Link
              :href="route('vendor.orders.index')"
              class="text-xs uppercase py-3 font-bold block"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/vendor/orders'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/vendor/orders'),
              }"
            >
              <i class="fa-solid fa-boxes-packing mr-2 text-sm"></i>
              {{ __("ORDERS") }}
            </Link>
          </li>
          <!-- Order Section -->
        </ul>

        <hr class="my-4 md:min-w-full" />
        <h6
          class="md:min-w-full text-slate-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("VENDOR_SUPPORT") }}
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <li class="items-center">
            <Link
              :href="route('vendor.orders.index')"
              class="text-xs uppercase py-3 font-bold block"
            >
              <i class="fa-solid fa-book mr-2 text-sm"></i>

              {{ __("GUIDE") }}
            </Link>
          </li>
          <li class="items-center">
            <Link
              :href="route('vendor.orders.index')"
              class="text-xs uppercase py-3 font-bold block"
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
import NotificationDropdown from "@/Components/Dropdowns/NotificationDropdown.vue";
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
    NotificationDropdown,
    UserDropdown,
    Link,
  },
};
</script>
