<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/Cards/ProductCard.vue";
import ProductCardList from "@/Components/Cards/ProductCardList.vue";
import { reactive, ref, watch } from "vue";
import { usePage, router, Link } from "@inertiajs/vue3";
import EcommerceFilterSidebarForSearchResult from "@/Components/Sidebars/EcommerceFilterSidebarForSearchResult.vue";
import Breadcrumb from "@/Components/Breadcrumbs/HomeBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";

const props = defineProps({
  categories: Object,
  brands: Object,
  products: Object,
});

const params = reactive({
  search: usePage().props.ziggy.query.search,
  sort: "id",
  direction: usePage().props.ziggy.query.direction
    ? usePage().props.ziggy.query.direction
    : "desc",

  page: usePage().props.ziggy.query.page,
  category: usePage().props.ziggy.query.category,
  brand: usePage().props.ziggy.query.brand,
  rating: usePage().props.ziggy.query.rating,
  price: usePage().props.ziggy.query.price,
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});

watch(
  () => params.direction,
  (current, previous) => {
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

const price = ref(
  usePage().props.ziggy.query.price ? usePage().props.ziggy.query.price : ""
);

const [minValue, maxValue] = price.value
  .split("-")
  .map((value) => parseInt(value));

const minPrice = ref(minValue);
const maxPrice = ref(maxValue);

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
    <section class="container mt-40 mx-auto py-10">
      <div class="mb-5 px-4">
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
                  >Search Result</span
                >
              </div>
            </li>
          </Breadcrumb>
        </div>
      </div>
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col md:flex-row -mx-4">
          <EcommerceFilterSidebarForSearchResult
            :categories="categories"
            :brands="brands"
          />
          <main class="md:w-2/3 lg:w-3/4 px-4">
            <div
              class="text-sm font-bold text-slate-600 px-5 py-3 border-t border-b flex items-center justify-between"
            >
              <p v-if="params.search">
                {{ products.data.length }} items found for result
                <span class="text-blue-600">"{{ params.search }}"</span>
              </p>

              <div class="flex items-center ml-auto">
                <div class="w-[220px] flex items-center justify-between">
                  <span class="">Sort By : </span>
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
                      Latest Arrivals
                    </option>
                    <option value="asc" :selected="params.direction === 'asc'">
                      Earliest Arrivals
                    </option>
                  </select>
                </div>

                <div class="flex items-center ml-3">
                  <span class="mr-2">View : </span>
                  <div class="flex items-center justify-between">
                    <Link
                      :href="route('product.search')"
                      :data="{
                        search: $page.props.ziggy.query.search,
                        category: $page.props.ziggy.query.category,
                        brand: $page.props.ziggy.query.brand,
                        sort: $page.props.ziggy.query.sort,
                        direction: $page.props.ziggy.query.direction,
                        page: $page.props.ziggy.query.page,
                        rating: $page.props.ziggy.query.rating,
                        price: $page.props.ziggy.query.price,
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
                    <Link
                      :href="route('product.search')"
                      :data="{
                        search: $page.props.ziggy.query.search,
                        category: $page.props.ziggy.query.category,
                        brand: $page.props.ziggy.query.brand,
                        sort: $page.props.ziggy.query.sort,
                        direction: $page.props.ziggy.query.direction,
                        page: $page.props.ziggy.query.page,
                        rating: $page.props.ziggy.query.rating,
                        price: $page.props.ziggy.query.price,
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

            <div class="my-3 w-full">
              <span
                v-if="
                  $page.props.ziggy.query.category ||
                  $page.props.ziggy.query.price ||
                  $page.props.ziggy.query.rating ||
                  $page.props.ziggy.query.brand
                "
                class="font-bold text-slate-600 text-lg mr-3"
                >Filtered By :</span
              >

              <span
                v-if="$page.props.ziggy.query.category"
                class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow capitalize"
              >
                Category : {{ $page.props.ziggy.query.category }}

                <i
                  @click="handleRemoveCategory"
                  class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
                >
                </i>
              </span>

              <span v-if="$page.props.ziggy.query.brand">
                <span
                  class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow"
                >
                  Brand : {{ $page.props.ziggy.query.brand }}

                  <i
                    @click="handleRemoveBrand"
                    class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
                  >
                  </i>
                </span>
              </span>

              <span
                v-if="$page.props.ziggy.query.rating"
                class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow"
              >
                Rating : {{ $page.props.ziggy.query.rating }} Stars And Up

                <i
                  @click="handleRemoveRating"
                  class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
                >
                </i>
              </span>

              <span
                v-if="$page.props.ziggy.query.price"
                class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow"
              >
                Price : {{ minPrice }} - {{ maxPrice }}

                <i
                  @click="handleRemovePrice"
                  class="fa-solid fa-xmark font-bold hover:text-red-600 cursor-pointer"
                >
                </i>
              </span>
            </div>

            <div v-if="$page.props.ziggy.query.view === 'list'">
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
                  ☹️ Items Not Found!
                </h4>
                <p class="my-3 font-bold text-slate-500 text-center">
                  We're sorry. We cannot find any matches for your search term.
                </p>
              </div>
              <Pagination class="mt-6" :links="products.links" />
            </div>

            <div v-if="$page.props.ziggy.query.view === 'grid'">
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
                  ☹️ Items Not Found!
                </h4>
                <p class="my-3 font-bold text-slate-500 text-center">
                  We're sorry. We cannot find any matches for your search term.
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


