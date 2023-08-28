<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import HeaderShopProfile from "@/Components/Headers/HeaderShopProfile.vue";
import Home from "./Partials/Home.vue";
import AllProducts from "./Partials/AllProducts.vue";
import ShopRating from "./Partials/ShopRating.vue";
import ProductRating from "./Partials/ProductRating.vue";
import { usePage, router, Link, Head } from "@inertiajs/vue3";
import { reactive } from "vue";

// Define the props
const props = defineProps({
  shop: Object,
  followings: Object,
  followers: Object,
  sellerProductBanners: Object,
  sellerRandomProducts: Object,
  sellerProducts: Object,
  categories: Object,
  brands: Object,
  paginateProductReviews: Object,
  productReviews: Object,
  productReviewsAvg: Object,
  paginateShopReviews: Object,
  shopReviews: Object,
  shopReviewsAvg: Object,
});

// Query String Parameters
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  sort: usePage().props.ziggy.query.sort
    ? usePage().props.ziggy.query.sort
    : "id",
  direction: usePage().props.ziggy.query.direction
    ? usePage().props.ziggy.query.direction
    : "desc",
  page: usePage().props.ziggy.query?.page,
  category: usePage().props.ziggy.query?.category,
  brand: usePage().props.ziggy.query?.brand,
  rating: usePage().props.ziggy.query?.rating,
  price: usePage().props.ziggy.query?.price,
  tab: "all-products",
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});

// Handle Search Box
const handleSearch = () => {
  router.get(route("shop.show", props.shop.uuid), {
    search: params.search,
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    tab: params.tab,
    category: params.category,
    brand: params.brand,
    rating: params.rating,
    price: params.price,
    view: params.view,
  });
};

// Remove Query String Search
const handelRemoveSearch = () => {
  params.search = "";
  router.get(route("shop.show", props.shop.uuid), {
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    tab: params.tab,
    category: params.category,
    brand: params.brand,
    rating: params.rating,
    price: params.price,
    view: params.view,
  });
};
</script>

<template>
  <AppLayout>
    <Head :title="shop.shop_name" />

    <section class="pt-10 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <!-- Shop Profile -->
        <HeaderShopProfile
          :shop="shop"
          :followings="followings"
          :followers="followers"
        />

        <div
          class="border-b border-gray-200 dark:border-gray-700 self-start w-full flex items-center justify-between"
        >
          <!-- Tabs Start -->
          <ul
            class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400"
            id="myTab"
            data-tabs-toggle="#myTabContent"
            role="tablist"
          >
            <!-- Home Tab -->
            <li class="mr-2" role="presentation">
              <Link
                :href="route('shop.show', shop.uuid)"
                :data="{ tab: 'home' }"
                class="inline-flex p-4 rounded-t-lg active group text-slate-600"
                :class="{
                  'text-blue-600 border-b-2 border-blue-600':
                    $page.props.ziggy.query.tab === 'home' ||
                    !$page.props.ziggy.query.tab,
                }"
              >
                <i class="fa-solid fa-home mr-2 text-sm"></i>
                Home
              </Link>
            </li>

            <!-- All Products Tab -->
            <li class="mr-2" role="presentation">
              <Link
                :href="route('shop.show', shop.uuid)"
                :data="{
                  tab: 'all-products',
                  view: 'grid',
                  sort: 'id',
                  direction: 'desc',
                }"
                class="inline-flex p-4 rounded-t-lg active group text-slate-600"
                :class="{
                  'text-blue-600 border-b-2 border-blue-600':
                    $page.props.ziggy.query.tab === 'all-products',
                }"
              >
                <i class="fa-solid fa-basket-shopping mr-2 text-sm"></i>
                All Products
              </Link>
            </li>

            <!-- Shop Rating And Review Tab -->
            <li class="mr-2" role="presentation">
              <Link
                :href="route('shop.show', shop.uuid)"
                :data="{ tab: 'ratings-and-reviews-for-shop' }"
                class="inline-flex p-4 rounded-t-lg active group text-slate-600"
                :class="{
                  'text-blue-600 border-b-2 border-blue-600':
                    $page.props.ziggy.query.tab ===
                    'ratings-and-reviews-for-shop',
                }"
              >
                <i class="fa-solid fa-star mr-2 text-sm"></i>
                Ratings & Reviews For Shop
              </Link>
            </li>

            <!-- Product Rating And Review Tab -->
            <li class="mr-2" role="presentation">
              <Link
                :href="route('shop.show', shop.uuid)"
                :data="{ tab: 'ratings-and-reviews-for-products' }"
                class="inline-flex p-4 rounded-t-lg active group text-slate-600"
                :class="{
                  'text-blue-600 border-b-2 border-blue-600':
                    $page.props.ziggy.query.tab ===
                    'ratings-and-reviews-for-products',
                }"
              >
                <i class="fa-solid fa-star mr-2 text-sm"></i>
                Ratings & Reviews For Products
              </Link>
            </li>
          </ul>
          <!-- Tabs End -->

          <!-- Product Search Form Input -->
          <div>
            <form @submit.prevent="handleSearch" class="flex items-center">
              <div
                class="border border-slate-300 rounded-sm focus:ring-0 mr-2 w-[300px] flex items-center justify-between"
              >
                <input
                  type="text"
                  class="border-none focus:ring-0 w-full"
                  :placeholder="__('SEARCH_PRODUCT_IN_SHOP')"
                  v-model="params.search"
                />
                <i
                  v-if="params.search"
                  @click="handelRemoveSearch"
                  class="fa-solid fa-xmark mx-2 cursor-pointer hover:text-slate-600"
                ></i>
              </div>
              <button
                class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-sm"
              >
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </form>
          </div>
        </div>

        <!-- Nav Tabs Result -->
        <div id="myTabContet" class="w-full">
          <div class="w-full">
            <!-- Home Tab -->
            <div
              v-if="
                $page.props.ziggy.query.tab === 'home' ||
                !$page.props.ziggy.query.tab
              "
            >
              <Home
                :sellerProductBanners="sellerProductBanners"
                :sellerRandomProducts="sellerRandomProducts"
              />
            </div>

            <!-- All Products Tab -->
            <div v-else-if="$page.props.ziggy.query.tab === 'all-products'">
              <AllProducts
                :sellerProducts="sellerProducts"
                :categories="categories"
                :brands="brands"
                :shop="shop"
              />
            </div>

            <!-- Shop Rating And Review Tab -->
            <div
              v-else-if="
                $page.props.ziggy.query.tab === 'ratings-and-reviews-for-shop'
              "
            >
              <ShopRating
                :shop="shop"
                :paginateShopReviews="paginateShopReviews"
                :shopReviews="shopReviews"
                :shopReviewsAvg="shopReviewsAvg"
              />
            </div>

            <!-- Product Rating And Review Tab -->
            <div
              v-else-if="
                $page.props.ziggy.query.tab ===
                'ratings-and-reviews-for-products'
              "
            >
              <ProductRating
                :paginateProductReviews="paginateProductReviews"
                :productReviews="productReviews"
                :productReviewsAvg="productReviewsAvg"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>


