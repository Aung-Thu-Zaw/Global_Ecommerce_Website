<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/Cards/ProductCard.vue";
import ProductCardList from "@/Components/Cards/ProductCardList.vue";
import EcommerceFilterSidebarForCategoryResult from "@/Components/Sidebars/EcommerceFilterSidebarForCategoryResult.vue";
import Breadcrumb from "@/Components/Breadcrumbs/SearchByCategoryBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import { reactive, ref, watch } from "vue";
import { usePage, router, Link, Head } from "@inertiajs/vue3";

const props = defineProps({
  category: Object,
  brands: Object,
  products: Object,
});

// Query String Parameters
const params = reactive({
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  page: usePage().props.ziggy.query?.page,
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
    router.get(route("category.products", props.category.slug), {
      sort: params.sort,
      direction: params.direction,
      page: params.page,
      brand: params.brand,
      rating: params.rating,
      price: params.price,
      view: params.view,
    });
  }
);

// Remove Price Query String Parameter
const handleRemovePrice = () => {
  router.get(route("category.products", props.category.slug), {
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    brand: params.brand,
    rating: params.rating,
    view: params.view,
  });
};

// Remove Rating Query String Parameter
const handleRemoveRating = () => {
  router.get(route("category.products", props.category.slug), {
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    brand: params.brand,
    price: params.price,
    view: params.view,
  });
};

// Remove Brand Query String Parameter
const handleRemoveBrand = () => {
  router.get(route("category.products", props.category.slug), {
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    rating: params.rating,
    price: params.price,
    view: params.view,
  });
};
</script>

<template>
  <AppLayout>
    <Head :title="'Search By Category : ' + category.name" />

    <section class="container mt-40 mx-auto py-10">
      <div class="mb-5 px-4">
        <div class="border-b py-3">
          <!-- Breadcrumb -->
          <Breadcrumb :category="category" />
        </div>
      </div>
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col md:flex-row -mx-4">
          <!-- Ecommerce Filter Sidebar -->
          <EcommerceFilterSidebarForCategoryResult
            :category="category"
            :brands="brands"
          />
          <main class="md:w-2/3 lg:w-3/4 px-4">
            <div
              class="text-sm font-bold text-slate-600 px-5 py-3 border-t border-b flex items-center justify-between"
            >
              <p v-if="category">
                {{ products.total }} {{ __("ITEMS_FOUND_FOR_THE_RESULT") }}
                <span class="text-blue-600">"{{ category.name }}"</span>
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

                <!-- Dynamic View -->
                <div class="flex items-center ml-3">
                  <span class="mr-2">{{ __("VIEW") }} : </span>
                  <div class="flex items-center justify-between">
                    <!-- Grid View -->
                    <Link
                      :href="route('category.products', category.slug)"
                      :data="{
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
                      :href="route('category.products', category.slug)"
                      :data="{
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
                v-if="params.price || params.rating || params.brand"
                class="font-bold text-slate-600 text-lg mr-3"
                >{{ __("FILTERED_BY") }} :</span
              >

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
                      "WE'RE_SORRY_WE_CANNOT_FIND_ANY_MATCHES_FOR_YOUR_FILTER_TERM"
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
                      "WE'RE_SORRY_WE_CANNOT_FIND_ANY_MATCHES_FOR_YOUR_FILTER_TERM"
                    )
                  }}
                </p>
              </div>

              <Pagination class="mt-6" :links="products.links" />
            </div>
          </main>
        </div>
      </div>
    </section>
  </AppLayout>
</template>


