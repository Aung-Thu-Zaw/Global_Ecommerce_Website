<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import { computed, onMounted, reactive, ref, watch } from "vue";

const props = defineProps({
  shop: Object,
  categories: Object,
  brands: Object,
});

const isCategoryShowLess = ref(true);
const isBrandShowLess = ref(true);

const limitedCategories = ref([]);
const limitedBrands = ref([]);

const price = ref(
  usePage().props.ziggy.query.price ? usePage().props.ziggy.query.price : ""
);

const [minValue, maxValue] = price.value
  .split("-")
  .map((value) => parseInt(value));

const minPrice = ref(minValue);
const maxPrice = ref(maxValue);

onMounted(() => {
  limitedCategories.value = props.categories.slice(0, 10);
  limitedBrands.value = props.brands.slice(0, 10);
});

const params = reactive({
  search: usePage().props.ziggy.query.search,
  sort: "id",
  direction: usePage().props.ziggy.query.direction
    ? usePage().props.ziggy.query.direction
    : "desc",

  page: usePage().props.ziggy.query.page,
  tab: usePage().props.ziggy.query.tab,
  category: usePage().props.ziggy.query.category,
  brand: usePage().props.ziggy.query.brand,
  rating: usePage().props.ziggy.query.rating,
  price: usePage().props.ziggy.query.price,
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});

watch(
  () => params.rating,
  (current, previous) => {
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
  }
);

watch(
  () => params.brand,
  (current, previous) => {
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
  }
);

const handlePrice = () => {
  params.price = `${minPrice.value}-${maxPrice.value}`;
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
</script>

<template>
  <aside class="md:w-1/3 lg:w-1/4 px-4">
    <!-- filter wrap -->

    <!-- <a
      class="md:hidden mb-5 w-full text-center px-4 py-2 inline-block text-lg text-gray-700 bg-white shadow-sm border border-gray-200 rounded-md hover:bg-gray-100 hover:text-blue-600"
      href="#"
    >
      Filter by
    </a> -->

    <div
      class="hidden md:block px-6 py-4 border border-gray-200 bg-white rounded shadow-sm"
    >
      <div v-if="categories.length">
        <h3 class="font-semibold mb-2">Category</h3>

        <ul v-if="isCategoryShowLess" class="text-gray-500 space-y-1">
          <li v-for="category in limitedCategories" :key="category.id">
            <Link
              class="hover:text-blue-600"
              :class="{
                'text-blue-600':
                  $page.props.ziggy.query.category === category.slug,
              }"
              :href="route('shop.show', shop.id)"
              :data="{
                search: $page.props.ziggy.query.search,
                tab: $page.props.ziggy.query.tab,
                category: category.slug,
                brand: $page.props.ziggy.query.brand,
                sort: $page.props.ziggy.query.sort,
                direction: $page.props.ziggy.query.direction,
                page: $page.props.ziggy.query.page,
                rating: $page.props.ziggy.query.rating,
                price: $page.props.ziggy.query.price,
                view: params.view,
              }"
            >
              {{ category.name }}
            </Link>
          </li>
        </ul>

        <ul v-else class="text-gray-500 space-y-1">
          <li v-for="category in categories" :key="category.id">
            <Link
              class="hover:text-blue-600"
              :class="{
                'text-blue-600':
                  $page.props.ziggy.query.category === category.slug,
              }"
              :href="route('shop.show', shop.id)"
              :data="{
                search: $page.props.ziggy.query.search,
                tab: $page.props.ziggy.query.tab,
                category: category.slug,
                brand: $page.props.ziggy.query.brand,
                sort: $page.props.ziggy.query.sort,
                direction: $page.props.ziggy.query.direction,
                page: $page.props.ziggy.query.page,
                rating: $page.props.ziggy.query.rating,
                price: $page.props.ziggy.query.price,
                view: params.view,
              }"
            >
              {{ category.name }}
            </Link>
          </li>
        </ul>

        <button
          v-if="categories.length > 10"
          @click="isCategoryShowLess = !isCategoryShowLess"
          class="font-bold text-sm w-full hover:text-blue-700 mt-5"
        >
          <span v-if="!isCategoryShowLess">
            Show Less
            <i class="fa-solid fa-chevron-up ml-3 animate-bounce"></i>
          </span>
          <span v-else>
            Show More
            <i class="fa-solid fa-chevron-down ml-3 animate-bounce"></i>
          </span>
        </button>
      </div>

      <hr class="my-4" />

      <div v-if="brands.length">
        <h3 class="font-semibold mb-2">Brand</h3>

        <ul v-if="isBrandShowLess" class="space-y-1">
          <li v-for="brand in limitedBrands" :key="brand.id">
            <label class="flex items-center">
              <input
                name="myselection"
                type="radio"
                :value="brand.slug"
                class="h-4 w-4"
                v-model="params.brand"
              />
              <span class="ml-2 text-gray-500"> {{ brand.name }} </span>
            </label>
          </li>
        </ul>

        <ul v-else class="space-y-1">
          <li v-for="brand in brands" :key="brand.id">
            <label class="flex items-center">
              <input
                name="myselection"
                type="radio"
                :value="brand.slug"
                class="h-4 w-4"
                v-model="params.brand"
              />
              <span class="ml-2 text-gray-500"> {{ brand.name }} </span>
            </label>
          </li>
        </ul>

        <button
          v-if="brands.length > 10"
          @click="isBrandShowLess = !isBrandShowLess"
          class="font-bold text-sm w-full hover:text-blue-700 mt-5"
        >
          <span v-if="!isBrandShowLess">
            Show Less
            <i class="fa-solid fa-chevron-up ml-3 animate-bounce"></i>
          </span>
          <span v-else>
            Show More
            <i class="fa-solid fa-chevron-down ml-3 animate-bounce"></i>
          </span>
        </button>
      </div>

      <hr class="my-4" />
      <h3 class="font-semibold mb-2">Ratings</h3>
      <ul class="space-y-1">
        <li>
          <label class="flex items-center">
            <input
              name="myselection"
              type="radio"
              value="5"
              class="h-4 w-4 mr-2"
              v-model="params.rating"
            />

            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>First star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Second star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Third star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Fourth star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Fifth star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <p
                class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"
              >
                5 Stars
              </p>
            </div>
          </label>
        </li>
        <li>
          <label class="flex items-center">
            <input
              name="myselection"
              type="radio"
              value="4"
              v-model="params.rating"
              class="h-4 w-4 mr-2"
            />

            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>First star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Second star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Third star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Fourth star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-300"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Fifth star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <p
                class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"
              >
                4 Stars And Up
              </p>
            </div>
          </label>
        </li>
        <li>
          <label class="flex items-center">
            <input
              name="myselection"
              type="radio"
              value="3"
              v-model="params.rating"
              class="h-4 w-4 mr-2"
            />

            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>First star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Second star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Third star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-300"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Fourth star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-300"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Fifth star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <p
                class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"
              >
                3 Stars And Up
              </p>
            </div>
          </label>
        </li>
        <li>
          <label class="flex items-center">
            <input
              name="myselection"
              type="radio"
              value="2"
              v-model="params.rating"
              class="h-4 w-4 mr-2"
            />

            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>First star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Second star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-300"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Third star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-300"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Fourth star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-300"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Fifth star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <p
                class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"
              >
                2 Stars And Up
              </p>
            </div>
          </label>
        </li>
        <li>
          <label class="flex items-center">
            <input
              name="myselection"
              type="radio"
              value="1"
              v-model="params.rating"
              class="h-4 w-4 mr-2"
            />

            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>First star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-300"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Second star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-300"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Third star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-300"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Fourth star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-gray-300"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Fifth star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <p
                class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"
              >
                1 Star And Up
              </p>
            </div>
          </label>
        </li>
      </ul>
      <hr class="my-4" />
      <h3 class="font-semibold mb-2">Price</h3>
      <ul class="space-y-1">
        <li>
          <form @submit.prevent="handlePrice" class="flex items-center">
            <input
              type="number"
              placeholder="Min"
              class="w-20 h-8 border-slate-400 rounded-sm"
              v-model="minPrice"
            />
            <span class="mx-2 text-slate-500">-</span>
            <input
              type="number"
              placeholder="Max"
              class="w-20 h-8 border-slate-400 rounded-sm"
              v-model="maxPrice"
            />
            <button
              class="bg-blue-600 px-3 py-1 ml-4 text-white rounded-sm hover:bg-blue-700"
            >
              <i class="fa-solid fa-play"></i>
            </button>
          </form>
        </li>
      </ul>
    </div>
    <!-- filter wrap -->
  </aside>
</template>
