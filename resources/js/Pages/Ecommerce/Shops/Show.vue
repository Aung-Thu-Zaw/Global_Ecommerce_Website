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

const props = defineProps({
  shop: Object,
  followings: Object,
  followers: Object,
  vendorProductBanners: Object,
  vendorRandomProducts: Object,
  vendorProducts: Object,
  categories: Object,
  brands: Object,
  paginateProductReviews: Object,
  productReviews: Object,
  productReviewsAvg: Object,
  paginateShopReviews: Object,
  shopReviews: Object,
  shopReviewsAvg: Object,
});

const currentTime = new Date();
const threshold = 1000 * 60 * 3; //3minutes in millseconds

const status = (last_activity) => {
  const lastActivity = new Date(last_activity);
  const timeDifference = currentTime.getTime() - lastActivity.getTime();

  return timeDifference < threshold ? "active" : "offline";
};

const filterFollowing = computed(() => {
  return props.followings.filter(
    (following) => following.followable_id === props.shop.id
  );
});

const handleFollow = () => {
  router.post(
    route("shop.follow", {
      shop_id: props.shop.id,
    }),
    {},
    {
      onSuccess: () => {
        if (usePage().props.flash.successMessage) {
          toast.success(usePage().props.flash.successMessage, {
            autoClose: 2000,
          });
        }
      },
    }
  );
};

const swal = inject("$swal");

const handleUnFollow = async () => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want unfollow this shop?",
    text: "If you unfollow selected stores, you won't be able to view the latest arrival and sales from them anymore.",
    showCancelButton: true,
    confirmButtonText: "Yes, unfollow!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("shop.unfollow", {
        shop_id: props.shop.id,
      })
    );
  }
};

const params = reactive({
  search: usePage().props.ziggy.query.search
    ? usePage().props.ziggy.query.search
    : "",
  sort: "id",
  direction: "desc",
  page: usePage().props.ziggy.query.page,
  tab: "all-products",
  category: usePage().props.ziggy.query.category,
  brand: usePage().props.ziggy.query.brand,
  rating: usePage().props.ziggy.query.rating,
  price: usePage().props.ziggy.query.price,
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});

const handleSearch = () => {
  router.get(route("shop.show", props.shop.id), {
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

const handelRemoveSearch = () => {
  params.search = "";
  router.get(route("shop.show", props.shop.id), {
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
        <div
          class="shadow border rounded-sm p-5 mb-5 flex items-center justify-between"
        >
          <div class="flex items-center">
            <img
              :src="shop.avatar"
              alt=""
              class="w-16 h-16 rounded-full object-cover mr-5 ring-2 ring-blue-500"
            />
            <div>
              <h3 class="text-2xl font-bold text-slate-700">
                {{ shop.shop_name }}
                <span
                  class="px-3 py-1 bg-green-200 text-green-600 rounded-xl text-[.8rem]"
                >
                  <i class="fa-solid fa-circle-check"></i>
                  Verified
                </span>
              </h3>
              <span class="text-sm text-slate-500 block"
                >{{ followers.length }} Followers
              </span>

              <span
                class="capitalize text-sm text-green-500 animate-pulse font-bold"
                :class="{
                  ' text-green-500': status(shop.last_activity) == 'active',
                  ' text-red-500': status(shop.last_activity) == 'offline',
                }"
              >
                <i class="fa-solid fa-circle animate-pulse text-[.6rem]"></i>
                {{ status(shop.last_activity) }}
              </span>
            </div>
          </div>
          <div
            v-if="$page.props.auth.user && $page.props.auth.user.id !== shop.id"
          >
            <button
              class="px-5 py-2 rounded-sm mx-2 font-bold shadow bg-yellow-500 hover:bg-yellow-600 text-white"
            >
              <i class="fa-solid fa-message"></i>
              Chat Now
            </button>
            <button
              v-if="filterFollowing.length"
              @click="handleUnFollow"
              class="px-5 py-2 rounded-sm mx-2 font-bold shadow bg-blue-500 hover:bg-blue-600 text-white"
            >
              <i class="fa-solid fa-check"></i>
              Following
            </button>
            <button
              v-else
              @click="handleFollow"
              class="px-5 py-2 rounded-sm mx-2 font-bold shadow bg-blue-600 hover:bg-blue-700 text-white"
            >
              <i class="fa-solid fa-store"></i>
              Follow Store
            </button>
          </div>
        </div>

        <div
          class="border-b border-gray-200 dark:border-gray-700 self-start w-full flex items-center justify-between"
        >
          <ul
            class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400"
            id="myTab"
            data-tabs-toggle="#myTabContent"
            role="tablist"
          >
            <li class="mr-2" role="presentation">
              <Link
                :href="route('shop.show', shop.id)"
                :data="{ tab: 'home' }"
                class="inline-flex p-4 rounded-t-lg active group"
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
            <li class="mr-2" role="presentation">
              <Link
                :href="route('shop.show', shop.id)"
                :data="{ tab: 'all-products', view: 'grid' }"
                class="inline-flex p-4 rounded-t-lg active group"
                :class="{
                  'text-blue-600 border-b-2 border-blue-600':
                    $page.props.ziggy.query.tab === 'all-products',
                }"
              >
                <i class="fa-solid fa-basket-shopping mr-2 text-sm"></i>
                All Products
              </Link>
            </li>
            <li class="mr-2" role="presentation">
              <Link
                :href="route('shop.show', shop.id)"
                :data="{ tab: 'ratings-and-reviews-for-shop' }"
                class="inline-flex p-4 rounded-t-lg active group"
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
            <li class="mr-2" role="presentation">
              <Link
                :href="route('shop.show', shop.id)"
                :data="{ tab: 'ratings-and-reviews-for-products' }"
                class="inline-flex p-4 rounded-t-lg active group"
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

          <div>
            <form @submit.prevent="handleSearch" class="flex items-center">
              <div
                class="border-2 border-slate-400 rounded-sm focus:ring-0 focus:border-slate-400 mr-2 w-[300px] flex items-center justify-between"
              >
                <input
                  type="text"
                  class="border-none focus:ring-0 w-full"
                  placeholder="Search product in shop"
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

        <div id="myTabContet" class="w-full">
          <div class="w-full">
            <div
              v-if="
                $page.props.ziggy.query.tab === 'home' ||
                !$page.props.ziggy.query.tab
              "
            >
              <Home
                :vendorProductBanners="vendorProductBanners"
                :vendorRandomProducts="vendorRandomProducts"
              />
            </div>
            <div v-else-if="$page.props.ziggy.query.tab === 'all-products'">
              <AllProducts
                :vendorProducts="vendorProducts"
                :categories="categories"
                :brands="brands"
                :shop="shop"
              />
            </div>
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


