<script setup>
import ProductCardGrid from "@/Components/Cards/Products/ProductCardGrid.vue";
import ProductCardList from "@/Components/Cards/Products/ProductCardList.vue";
import FilterSidebar from "@/Components/Sidebars/EcommerceFilterSidebarForShop.vue";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { reactive, ref, watch } from "vue";
import { usePage, router, Link } from "@inertiajs/vue3";

const props = defineProps({
  sellerProducts: Object,
  categories: Object,
  brands: Object,
  shop: Object,
});

// Query String Parameters
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  page: usePage().props.ziggy.query?.page,
  tab: usePage().props.ziggy.query?.tab,
  category: usePage().props.ziggy.query?.category,
  brand: usePage().props.ziggy.query?.brand,
  rating: usePage().props.ziggy.query?.rating,
  price: usePage().props.ziggy.query?.price,
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});

// Handle Filter Prices
const price = ref(
  usePage().props.ziggy.query.price ? usePage().props.ziggy.query.price : ""
);

const [minValue, maxValue] = price.value
  .split("-")
  .map((value) => parseInt(value));

const minPrice = ref(minValue);
const maxPrice = ref(maxValue);

// Remove Category Query String Parameter
const handleRemoveCategory = () => {
  router.get(route("shop.show", props.shop.uuid), {
    search: params.search,
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    brand: params.brand,
    tab: params.tab,
    rating: params.rating,
    price: params.price,
    view: params.view,
  });
};

// Remove Price Query String Parameter
const handleRemovePrice = () => {
  router.get(route("shop.show", props.shop.uuid), {
    search: params.search,
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    tab: params.tab,
    category: params.category,
    brand: params.brand,
    rating: params.rating,
    view: params.view,
  });
};

// Remove Rating Query String Parameter
const handleRemoveRating = () => {
  router.get(route("shop.show", props.shop.uuid), {
    search: params.search,
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    tab: params.tab,
    category: params.category,
    brand: params.brand,
    price: params.price,
    view: params.view,
  });
};

// Remove Brand Query String Parameter
const handleRemoveBrand = () => {
  router.get(route("shop.show", props.shop.uuid), {
    search: params.search,
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    tab: params.tab,
    category: params.category,
    rating: params.rating,
    price: params.price,
    view: params.view,
  });
};

// Watching Sorting Select Box
watch(
  () => params.direction,
  () => {
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
  }
);
</script>


<template>
  <section class="container mx-auto py-10">
    <div class="container max-w-screen-xl mx-auto">
      <div class="flex flex-col md:flex-row -mx-4">
        <!-- Product Filter Sidebar Card -->
        <FilterSidebar :categories="categories" :brands="brands" :shop="shop" />

        <main class="md:w-2/3 lg:w-3/4 px-4">
          <div
            class="text-sm font-bold text-slate-600 px-5 py-3 border-t border-b flex items-center justify-between"
          >
            <p v-if="params.search">
              {{ sellerProducts.total }} {{ __("ITEMS_FOUND_FOR_THE_RESULT") }}
              <span class="text-blue-600">"{{ params.search }}"</span>
            </p>

            <!-- Sorting Select Box -->
            <div class="flex items-center ml-auto">
              <div class="w-[210px] flex items-center justify-between">
                <span class="">{{ __("SORT_BY") }} : </span>
                <select
                  id="countries"
                  class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[150px] p-2.5 text-slate-700"
                  v-model="params.direction"
                >
                  <option
                    value="desc"
                    :selected="
                      params.direction === 'desc' || params.direction === null
                    "
                  >
                    {{ __("LATEST_ARRIVALS") }}
                  </option>
                  <option value="asc" :selected="params.direction === 'asc'">
                    {{ __("EARLIEST_ARRIVALS") }}
                  </option>
                </select>
              </div>

              <!-- Product Grid And List View -->
              <div class="flex items-center ml-3">
                <span class="mr-2">{{ __("VIEW") }} : </span>
                <div class="flex items-center justify-between">
                  <!-- Grid View -->
                  <Link
                    as="button"
                    :href="route('shop.show', shop.uuid)"
                    :data="{
                      search: $page.props.ziggy.query?.search,
                      tab: $page.props.ziggy.query?.tab,
                      category: $page.props.ziggy.query?.category,
                      brand: $page.props.ziggy.query?.brand,
                      sort: $page.props.ziggy.query?.sort,
                      direction: $page.props.ziggy.query?.direction,
                      page: $page.props.ziggy.query?.page,
                      rating: $page.props.ziggy.query?.rating,
                      price: $page.props.ziggy.query?.price,
                      view: 'grid',
                    }"
                    class="px-2 py-1 rounded-md cursor-pointer hover:bg-gray-300 transition-none"
                    :class="{
                      'bg-gray-400 text-white':
                        $page.props.ziggy.query.view === 'grid',
                      'bg-gray-200': $page.props.ziggy.query.view !== 'grid',
                    }"
                  >
                    <i class="fa-solid fa-grip"></i>
                  </Link>

                  <!-- List View -->
                  <Link
                    as="button"
                    :href="route('shop.show', shop.uuid)"
                    :data="{
                      search: $page.props.ziggy.query?.search,
                      tab: $page.props.ziggy.query?.tab,
                      category: $page.props.ziggy.query?.category,
                      brand: $page.props.ziggy.query?.brand,
                      sort: $page.props.ziggy.query?.sort,
                      direction: $page.props.ziggy.query?.direction,
                      page: $page.props.ziggy.query?.page,
                      rating: $page.props.ziggy.query?.rating,
                      price: $page.props.ziggy.query?.price,
                      view: 'list',
                    }"
                    class="ml-3 px-2 py-1 rounded-md cursor-pointer hover:bg-gray-300 transition-none"
                    :class="{
                      'bg-gray-400 text-white':
                        $page.props.ziggy.query.view === 'list',
                      'bg-gray-200': $page.props.ziggy.query.view !== 'list',
                    }"
                  >
                    <i class="fa-solid fa-list"></i>
                  </Link>
                </div>
              </div>
            </div>
          </div>

          <!-- Filter Tags -->
          <div class="my-3 w-full">
            <span
              v-if="
                $page.props.ziggy.query.category ||
                $page.props.ziggy.query.price ||
                $page.props.ziggy.query.rating ||
                $page.props.ziggy.query.brand
              "
              class="font-bold text-slate-600 text-lg mr-3"
              >{{ __("FILTERED_BY") }} :</span
            >

            <!-- Category Filter Tag -->
            <span
              v-if="$page.props.ziggy.query.category"
              class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow capitalize"
            >
              {{ __("CATEGORY") }} : {{ $page.props.ziggy.query.category }}

              <i
                @click="handleRemoveCategory"
                class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
              >
              </i>
            </span>

            <!-- Brand Filter Tag -->
            <span v-if="$page.props.ziggy.query.brand">
              <span
                class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow"
              >
                {{ __("BRAND") }} : {{ $page.props.ziggy.query.brand }}

                <i
                  @click="handleRemoveBrand"
                  class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
                >
                </i>
              </span>
            </span>

            <!-- Rating Filter Tag -->
            <span
              v-if="$page.props.ziggy.query.rating"
              class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow"
            >
              {{ __("RATING") }} : {{ $page.props.ziggy.query.rating }} Stars
              And Up

              <i
                @click="handleRemoveRating"
                class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
              >
              </i>
            </span>

            <!-- Price Filter Tag -->
            <span
              v-if="$page.props.ziggy.query.price"
              class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow"
            >
              {{ __("PRICE") }} : {{ minPrice }} - {{ maxPrice }}

              <i
                @click="handleRemovePrice"
                class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
              >
              </i>
            </span>
          </div>

          <!-- Product Card List View Start -->
          <div v-if="$page.props.ziggy.query.view === 'list'">
            <div
              v-if="sellerProducts.data.length"
              class="flex flex-col items-center space-y-2"
            >
              <div
                v-for="product in sellerProducts.data"
                :key="product.id"
                class="w-full"
              >
                <ProductCardList :product="product" />
              </div>
            </div>

            <!-- Product Not Found -->
            <div v-else>
              <h4 class="font-bold text-slate-600 text-center mt-20 text-xl">
                ☹️ {{ __("ITEMS_NOT_FOUND") }}!
              </h4>
              <p class="my-3 font-bold text-slate-500 text-center">
                {{
                  __(
                    "WE'RE_SORRY_WE_CANNOT_FIND_ANY_MATCHES_FOR_YOUR_SEARCH_TERM"
                  )
                }}
              </p>
            </div>
            <!-- Pagination -->
            <Pagination class="mt-6" :links="sellerProducts.links" />
          </div>
          <!-- Product Card List View End -->

          <!-- Product Card Grid View Start -->
          <div v-if="$page.props.ziggy.query.view === 'grid'">
            <div
              v-if="sellerProducts.data.length"
              class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
            >
              <div
                v-for="product in sellerProducts.data"
                :key="product.id"
                class="my-3"
              >
                <ProductCardGrid :product="product" />
              </div>
            </div>

            <!-- Product Not Found -->
            <div v-else>
              <h4 class="font-bold text-slate-600 text-center mt-20 text-xl">
                ☹️ {{ __("ITEMS_NOT_FOUND") }}!
              </h4>
              <p class="my-3 font-bold text-slate-500 text-center">
                {{
                  __(
                    "WE'RE_SORRY_WE_CANNOT_FIND_ANY_MATCHES_FOR_YOUR_SEARCH_TERM"
                  )
                }}
              </p>
            </div>

            <!-- Pagination -->
            <Pagination class="mt-6" :links="sellerProducts.links" />
          </div>
          <!-- Product Card Grid View End -->
        </main>
      </div>
    </div>
  </section>
</template>


