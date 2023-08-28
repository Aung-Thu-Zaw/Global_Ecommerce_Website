<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/HomeBreadcrumb.vue";
import Information from "@/Components/Information.vue";
import ShopInformationCard from "@/Components/Cards/Shops/ShopInformationCard.vue";
import RelatedProductSection from "@/Components/Sections/RelatedProductSection.vue";
import { computed, reactive, ref } from "vue";
import { router, usePage, Head, Link } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  productsFromShop: Object,
  product: Object,
  relatedProducts: Object,
  productQuestions: Object,
  paginateProductReviews: Object,
  productReviews: Object,
  productReviewsAvg: String,
  conversation: Object,
});

const selectedColor = ref("");

const selectedSize = ref("");

// Handle Multiple Images And Select Active Image
const images = reactive([props.product.image]);

props.product.images.forEach((image) => images.push(image.img_path));

const activeImageIndex = ref(0);

const activeImage = computed(() => images[activeImageIndex.value]);

// Handle Product Quantity Increase And Decrease
const quantity = ref(1);

const increment = () =>
  quantity.value >= props.product.qty
    ? (quantity.value = props.product.qty)
    : quantity.value++;
const decrement = () => (quantity.value <= 1 ? 1 : quantity.value--);

// Calculate Total Product Reveiw Avg
const reviewAvg = computed(() =>
  parseFloat(props.productReviewsAvg).toFixed(2)
);

// Handle Product Add To Cart
const addToCart = () => {
  if (props.product.qty !== 0) {
    router.post(
      route("cart-items.store", {
        cart_id: usePage().props.auth.user.cart
          ? usePage().props.auth.user.cart.id
          : null,
        product_id: props.product.id,
        shop_id: props.product.shop.id,
        qty: quantity.value,
        color: selectedColor.value,
        size: selectedSize.value,
        total_price: props.product.discount
          ? quantity.value * props.product.discount
          : quantity.value * props.product.price,
      }),
      {},
      {
        preserveScroll: true,
        onSuccess: () => {
          toast.success(usePage().props.flash.successMessage, {
            autoClose: 2000,
          });
        },
      }
    );
  } else {
    toast.error("Product is sold out.", {
      autoClose: 2000,
    });
  }
};

// Handle Product Save To Watchlist
const saveToWatchlist = () => {
  router.post(
    route("watchlist.store", {
      user_id: usePage().props.auth.user.id,
      product_id: props.product.id,
      shop_id: props.product.shop.id,
    }),
    {},
    {
      preserveScroll: true,
      onSuccess: () => {
        if (usePage().props.flash.successMessage) {
          toast.success(usePage().props.flash.successMessage, {
            autoClose: 2000,
          });
        }
        if (usePage().props.flash.infoMessage) {
          toast.info(usePage().props.flash.infoMessage, {
            autoClose: 2000,
          });
        }
      },
    }
  );
};

// Check Product is Saved Or Not
const saved = computed(() => {
  return props.product.watchlists.some(
    (watchlist) => watchlist.product_id === props.product.id
  )
    ? true
    : false;
});
</script>


<template>
  <AppLayout>
    <Head :title="product.name" />

    <section class="py-4 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <!-- Breadcrumb Start -->
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
              <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                {{ __("PRODUCTS") }}
              </span>
            </div>
          </li>
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
              <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                {{ product.name }}
              </span>
            </div>
          </li>
        </Breadcrumb>
        <!-- Breadcrumb End -->
      </div>
    </section>

    <section class="bg-white py-3">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
          <aside>
            <!-- Dynamic Display Active Image -->
            <div
              class="border border-gray-200 shadow-sm p-3 text-center rounded mb-5"
            >
              <img
                class="object-cover inline-block w-[500px] h-full"
                :src="activeImage"
                :alt="product.name"
              />
            </div>

            <!-- Multi Product Images -->
            <div
              class="space-x-2 overflow-auto text-center whitespace-nowrap scrollbar"
            >
              <div
                v-for="(image, index) in images"
                :key="image.id"
                class="inline-block border border-gray-400 p-1 rounded-md hover:border-blue-500"
                :class="{
                  'border-4 border-blue-500': activeImageIndex === index,
                }"
                @click="activeImageIndex = index"
              >
                <img class="w-14 h-14" :src="image" :alt="product.name" />
              </div>
            </div>
          </aside>
          <main>
            <!-- Product  -->
            <h2 class="font-semibold text-2xl mb-4">
              {{ product.name }}
            </h2>

            <!-- Average Product Review -->
            <div v-if="productReviewsAvg" class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Rating star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <p class="ml-2 text-sm font-bold text-gray-900 dark:text-white">
                {{ reviewAvg }}
              </p>
              <span
                class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full dark:bg-gray-400"
              ></span>
              <a
                href="#"
                class="text-sm font-medium text-gray-900 underline hover:no-underline dark:text-white"
                >{{ productReviews.length }} reviews</a
              >
            </div>
            <div v-else class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Rating star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>

              <p class="text-sm font-medium text-gray-600 ml-3">No Reviews</p>
            </div>

            <!-- Current Total Product -->
            <div v-if="product.qty != 0" class="my-3">
              <span class="text-secondary-700 font-semibold text-sm mr-3"
                >Total {{ product.qty }} Available</span
              >
              <span
                class="text-green-500 font-bold text-sm bg-green-200 px-2 py-1 rounded-full"
                >In Stock</span
              >
            </div>
            <div v-else-if="product.qty == 0" class="my-3">
              <span class="text-secondary-700 font-semibold text-sm mr-3"
                >{{ product.qty }} Available</span
              >

              <span
                class="text-red-500 font-bold text-sm bg-red-200 px-2 py-1 rounded-full"
                >Sold Out</span
              >
            </div>

            <!-- Product Brand -->
            <p class="text-gray-400 text-sm font-semibold">
              <i class="fa fa-award"></i>
              <span v-if="product.brand">
                Brand : {{ product.brand.name }}
              </span>
              <span v-else> Brand : No Brand </span>
            </p>

            <!-- Product Price -->
            <div v-if="product.discount" class="my-3">
              <p class="font-semibold text-xl mb-1">${{ product.discount }}</p>
              <p class="font-normal text-sm mb-3">
                <span class="text-secondary-600 line-through mr-3"
                  >${{ product.price }}
                </span>
                <span
                  class="bg-green-200 text-green-500 py-[.2rem] px-2 rounded-full"
                >
                  {{
                    (
                      ((product.price - product.discount) / product.price) *
                      100
                    ).toFixed(1)
                  }}%
                </span>
              </p>
            </div>

            <div v-else class="my-3">
              <p class="font-semibold text-xl mb-1">${{ product.price }}</p>
            </div>

            <!-- Choose Sizes  -->
            <div v-if="product.sizes.length" class="my-5 flex items-center">
              <span class="text-secondary-800 mr-5"> Sizes </span>
              <div
                v-for="size in product.sizes"
                :key="size.id"
                class="flex items-center"
              >
                <div class="flex items-center mr-3">
                  <input
                    type="radio"
                    :id="size.name"
                    name="size"
                    :value="size.name"
                    class="hidden peer"
                    v-model="selectedSize"
                    required
                  />
                  <label
                    :for="size.name"
                    class="px-3 py-1 text-secondary-800 shadow-md bg-white border-2 border-gray-200 rounded-sm cursor-pointer peer-checked:border-gray-400 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div class="rounded-sm uppercase font-bold text-sm">
                      {{ size.name }}
                    </div>
                  </label>
                </div>
              </div>
            </div>

            <!-- Choose Color  -->
            <div v-if="product.colors.length" class="my-5 flex items-center">
              <span class="text-secondary-800 mr-5"> Colors </span>
              <div
                v-for="color in product.colors"
                :key="color.id"
                class="flex items-center"
              >
                <div class="flex items-center mr-3">
                  <input
                    type="radio"
                    :id="color.name"
                    name="color"
                    :value="color.name"
                    class="hidden peer"
                    v-model="selectedColor"
                    required
                  />
                  <label
                    :for="color.name"
                    class="w-7 h-7 text-gray-500 bg-white border-[3px] border-gray-100 shadow-md rounded-sm cursor-pointer peer-checked:border-gray-400 peer-checked:w-8 peer-checked:h-8 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div
                      class="w-full h-full rounded-sm"
                      :class="'bg-' + color.name + '-600'"
                    ></div>
                  </label>
                </div>
              </div>
            </div>

            <!-- Handle Quantity -->
            <div class="my-5">
              <span class="text-secondary-800 mr-5"> Quantity </span>
              <span
                class="px-3 py-2 bg-slate-500 hover:bg-slate-600 rounded-sm cursor-pointer"
                @click="increment"
              >
                <i class="fa-solid fa-plus text-white"></i>
              </span>

              <input
                type="number"
                class="border-2 text-center border-slate-500 outline-none focus:outline-none focus:ring-0 w-[100px] h-full mx-1 rounded-sm"
                v-model="quantity"
              />
              <span
                class="px-3 py-2 bg-slate-500 hover:bg-slate-600 mr-2 rounded-sm cursor-pointer"
                @click="decrement"
              >
                <i class="fa-solid fa-minus text-white"></i>
              </span>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-2 mb-5">
              <a
                class="px-4 py-2 inline-block text-white bg-yellow-500 border border-transparent rounded-md hover:bg-yellow-600"
                href="#"
              >
                Buy now
              </a>
              <button
                class="px-4 py-2 inline-block text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700"
                @click="addToCart"
              >
                <i class="fa fa-shopping-cart mr-2"></i>
                Add to cart
              </button>
              <button
                class="px-4 py-2 inline-block text-blue-600 border border-gray-300 rounded-md hover:bg-gray-100"
                :class="{ 'text-pink-500': saved }"
                @click="saveToWatchlist"
              >
                <i class="fa fa-heart mr-2"></i>
                {{ saved ? "Saved" : "Save to watchlist" }}
              </button>
            </div>

            <div class="w-[450px] border-2 border-slate-300"></div>

            <!-- Product Shop Information -->
            <ShopInformationCard
              :product="product"
              :conversation="conversation"
            />
          </main>
        </div>
      </div>
    </section>

    <!-- Product Information -->
    <Information
      :product="product"
      :productQuestions="productQuestions"
      :productReviews="productReviews"
      :paginateProductReviews="paginateProductReviews"
      :productsFromShop="productsFromShop"
      :productReviewsAvg="productReviewsAvg"
    />

    <!-- Related Product Section -->
    <div v-if="relatedProducts.length">
      <RelatedProductSection :relatedProducts="relatedProducts" />
    </div>
  </AppLayout>
</template>


<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  display: none;
}

.scrollbar::-webkit-scrollbar {
  height: 10px;
}
</style>
