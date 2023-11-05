<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/Cards/Products/ProductCardGrid.vue";
import ProductCardList from "@/Components/Cards/Products/ProductCardList.vue";
import FilterSidebar from "@/Components/Sidebars/EcommerceFilterSidebarForSearchResult.vue";
import Breadcrumb from "@/Components/Breadcrumbs/HomeBreadcrumb.vue";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { reactive, ref, watch } from "vue";
import { usePage, router, Link, Head } from "@inertiajs/vue3";

const props = defineProps({
  categories: Object,
  brands: Object,
  products: Object,
});

// Query String Parameters
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  page: usePage().props.ziggy.query?.page,
  category: usePage().props.ziggy.query?.category,
  brand: usePage().props.ziggy.query?.brand,
  rating: usePage().props.ziggy.query?.rating,
  price: usePage().props.ziggy.query?.price,
  view: usePage().props.ziggy.query?.view,
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

// Watching Sorting Select Box
watch(
  () => params.direction,
  () => {
    router.get(route("product.search"), {
      search: params.search,
      sort: params.sort,
      direction: params.direction,
      page: params.page,
      category: params.category,
      brand: params.brand,
      rating: params.rating,
      price: params.price,
      view: params.view,
    });
  }
);

// Remove Category Query String Parameter
const handleRemoveCategory = () => {
  router.get(route("product.search"), {
    search: params.search,
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    brand: params.brand,
    rating: params.rating,
    price: params.price,
    view: params.view,
  });
};

// Remove Price Query String Parameter
const handleRemovePrice = () => {
  router.get(route("product.search"), {
    search: params.search,
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    category: params.category,
    brand: params.brand,
    rating: params.rating,
    view: params.view,
  });
};

// Remove Rating Query String Parameter
const handleRemoveRating = () => {
  router.get(route("product.search"), {
    search: params.search,
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    category: params.category,
    brand: params.brand,
    price: params.price,
    view: params.view,
  });
};

// Remove Brand Query String Parameter
const handleRemoveBrand = () => {
  router.get(route("product.search"), {
    search: params.search,
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    category: params.category,
    rating: params.rating,
    price: params.price,
    view: params.view,
  });
};
</script>

<template>
  <AppLayout>
    <Head :title="__('SEARCH_RESULT')" />

    <section class="container mt-40 mx-auto py-10">
      <div class="mb-5 px-4">
        <!-- Breadcrumb Start -->
        <div class="border-b py-3">
          <Breadcrumb>
            <li aria-current="page">
              <div class="flex items-center">
                <svg
                  aria-hidden="true"
                  class="w-6 h-6 text-gray-400"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
                <span
                  class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                >
                  {{ __("SEARCH_RESULT") }}
                </span>
              </div>
            </li>
          </Breadcrumb>
          <!-- Breadcrumb End -->
        </div>
      </div>
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col md:flex-row -mx-4">
          <!-- Ecommerce Filter Sidebar -->
          <FilterSidebar :categories="categories" :brands="brands" />

          <main class="md:w-2/3 lg:w-3/4 px-4">
            <div
              class="text-sm font-bold text-slate-600 px-5 py-3 border-t border-b flex items-center justify-between"
            >
              <p v-if="$page.props.ziggy.query?.search">
                {{ products.total }} {{ __("ITEMS_FOUND_FOR_THE_RESULT") }}
                <span class="text-blue-600">
                  "{{ $page.props.ziggy.query?.search }}"
                </span>
              </p>

              <div class="flex items-center ml-auto">
                <!-- Sorting Select Box -->
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

                <!-- Product Grid View And List View -->
                <div class="flex items-center ml-3">
                  <span class="w-[50px]">{{ __("VIEW") }} : </span>
                  <div class="flex items-center justify-between">
                    <!-- Grid View -->
                    <Link
                      as="button"
                      :href="route('product.search')"
                      :data="{
                        search: params.search,
                        category: params.category,
                        brand: params.brand,
                        sort: params.sort,
                        direction: params.direction,
                        page: params.page,
                        rating: params.rating,
                        price: params.price,
                        view: 'grid',
                      }"
                      class="px-2 py-1 rounded-md cursor-pointer hover:bg-gray-300 transition-none"
                      :class="{
                        'bg-gray-400 text-white': params.view === 'grid',
                        'bg-gray-200': params.view !== 'grid',
                      }"
                    >
                      <i class="fa-solid fa-grip"></i>
                    </Link>

                    <!-- List View -->
                    <Link
                      as="button"
                      :href="route('product.search')"
                      :data="{
                        search: params.search,
                        category: params.category,
                        brand: params.brand,
                        sort: params.sort,
                        direction: params.direction,
                        page: params.page,
                        rating: params.rating,
                        price: params.price,
                        view: 'list',
                      }"
                      class="ml-3 px-2 py-1 rounded-md cursor-pointer hover:bg-gray-300 transition-none"
                      :class="{
                        'bg-gray-400 text-white': params.view === 'list',
                        'bg-gray-200': params.view !== 'list',
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
                  params.category ||
                  params.price ||
                  params.rating ||
                  params.brand
                "
                class="font-bold text-slate-600 text-lg mr-3"
                >{{ __("FILTERED_BY") }} :</span
              >

              <!-- Category Filter Tag -->
              <span
                v-if="params.category"
                class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow capitalize"
              >
                {{ __("CATEGORY") }} : {{ params.category }}

                <i
                  @click="handleRemoveCategory"
                  class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
                >
                </i>
              </span>

              <!-- Brand Filter Tag -->
              <span v-if="params.brand">
                <span
                  class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow"
                >
                  {{ __("BRAND") }} : {{ params.brand }}

                  <i
                    @click="handleRemoveBrand"
                    class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
                  >
                  </i>
                </span>
              </span>

              <!-- Rating Filter Tag -->
              <span
                v-if="params.rating"
                class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow"
              >
                {{ __("RATING") }} : {{ params.rating }} Stars And Up

                <i
                  @click="handleRemoveRating"
                  class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
                >
                </i>
              </span>

              <!-- Price Filter Tag -->
              <span
                v-if="params.price"
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

            <!-- Products List View -->
            <div v-if="params.view === 'list'">
              <div
                v-if="products.data.length"
                class="flex flex-col items-center space-y-2"
              >
                <div
                  v-for="product in products.data"
                  :key="product.id"
                  class="w-full"
                >
                  <ProductCardList :product="product" />
                </div>
              </div>
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
              <Pagination class="mt-6" :links="products.links" />
            </div>

            <!-- Products Grid View -->
            <div v-if="params.view === 'grid'">
              <div
                v-if="products.data.length"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
              >
                <div
                  v-for="product in products.data"
                  :key="product.id"
                  class="my-3"
                >
                  <ProductCard :product="product"></ProductCard>
                </div>
              </div>
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

              <!-- Product Pagination -->
              <Pagination class="mt-6" :links="products.links" />
            </div>
          </main>
        </div>
      </div>
    </section>
  </AppLayout>
</template>


