<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Home/Breadcrumb.vue";
import Information from "@/Components/Information.vue";
import { computed, reactive, ref } from "vue";
import { Link, router, usePage, Head } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  specificShopProducts: Object,
  product: Object,
  productQuestions: Object,
});

const images = reactive([props.product.image]);

props.product.images.forEach((image) => images.push(image.img_path));

const activeImageIndex = ref(0);

const activeImage = computed(() => images[activeImageIndex.value]);

const quantity = ref(1);
const selectedColor = ref("");
const selectedSize = ref("");

const increment = () =>
  quantity.value >= props.product.qty
    ? (quantity.value = props.product.qty)
    : quantity.value++;
const decrement = () => (quantity.value <= 1 ? 1 : quantity.value--);

const saved = computed(() => {
  return props.product.watchlists.some(
    (watchlist) => watchlist.product_id === props.product.id
  )
    ? true
    : false;
});

const addToCart = () => {
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
        // Success flash message
        toast.success(usePage().props.flash.successMessage, {
          autoClose: 2000,
        });
      },
    }
  );
};

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
        // Success flash message
        if (usePage().props.flash.successMessage) {
          toast.success(usePage().props.flash.successMessage, {
            autoClose: 2000,
          });
        }
        // Info flash message
        if (usePage().props.flash.infoMessage) {
          toast.info(usePage().props.flash.infoMessage, {
            autoClose: 2000,
          });
        }
      },
    }
  );
};
</script>


<template>
  <AppLayout>
    <Head :title="product.name" />
    <section class="py-4 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <Breadcrumb />
      </div>
    </section>

    <section class="bg-white py-3">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
          <aside>
            <div
              class="border border-gray-200 shadow-sm p-3 text-center rounded mb-5"
            >
              <img
                class="object-cover inline-block w-[500px] h-full"
                :src="activeImage"
                :alt="product.name"
              />
            </div>
            <div class="space-x-2 overflow-auto text-center whitespace-nowrap">
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
            <h2 class="font-semibold text-2xl mb-4">
              {{ product.name }}
            </h2>

            <!-- <div class="flex items-center">
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
                4.95
              </p>
              <span
                class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full dark:bg-gray-400"
              ></span>
              <a
                href="#"
                class="text-sm font-medium text-gray-900 underline hover:no-underline dark:text-white"
                >73 reviews</a
              >
            </div> -->

            <div v-if="product.qty != 0" class="my-3">
              <span class="text-secondary-700 font-semibold text-sm mr-3"
                >Total {{ product.qty }} Available</span
              >
              <span
                class="text-green-500 font-bold text-sm bg-green-200 px-2 py-1 rounded-full"
                >Active</span
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

            <p class="text-gray-400 text-sm font-semibold">
              <i class="fa fa-award"></i>
              <span v-if="product.brand">
                Brand : {{ product.brand.name }}
              </span>
              <span v-else> Brand : No Brand </span>
            </p>

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

            <!-- action buttons -->
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

            <div class="border w-[450px] shadow rounded-md mt-5">
              <div
                class="font-bold text-md text-slate-600 w-full border-b px-5 py-3 mb-3"
              >
                Sold By
              </div>

              <!-- <span
                class="px-3 rounded-sm py-1 ml-5 font-bold uppercase text-[0.6rem] text-white bg-fuchsia-700"
              >
                <i class="fas fa-crown"></i>
                Official Store
              </span> -->

              <div class="flex items-center px-5 py-3">
                <img
                  :src="product.shop.avatar"
                  alt=""
                  class="w-14 h-14 rounded-full object-cover ring-2 shadow ring-blue-300 mr-3"
                />
                <div class="flex items-start">
                  <Link
                    :href="route()"
                    class="font-bold w-full text-md text-slate-700 hover:text-blue-600 cursor-pointer mr-1"
                  >
                    {{ product.shop.shop_name }}
                  </Link>

                  <span
                    class="rounded-full flex items-center justify-center bg-green-200 text-sm text-green-600 font-bold px-3 py-1"
                    >Verified
                    <i
                      class="fas fa-check arrow-icon ml-3 bg-green-500 p-1 rounded-full text-white"
                    ></i>
                  </span>
                </div>
              </div>

              <div
                class="border-t border-b h-[100px] flex items-center justify-center my-3"
              >
                <div class="p-2 w-full h-full">
                  <p
                    class="text-sm font-bold text-slate-600 text-center w-full"
                  >
                    On Time Delievery
                  </p>
                  <p class="text-2xl text-slate-800 w-full text-center mt-4">
                    100%
                  </p>
                </div>
                <div class="border-l border-r p-2 w-full h-full">
                  <p
                    class="text-sm font-bold text-slate-600 text-center w-full"
                  >
                    Chat Response Rate
                  </p>
                  <p class="text-2xl text-slate-800 w-full text-center mt-4">
                    10%
                  </p>
                </div>
                <div class="p-2 w-full h-full">
                  <p
                    class="text-sm font-bold text-slate-600 text-center w-full"
                  >
                    Shop Rating
                  </p>
                  <p class="text-2xl text-slate-800 w-full text-center mt-4">
                    50%
                  </p>
                </div>
              </div>
              <div class="flex items-center justify-between my-3 px-5 py-3">
                <Link
                  :href="route()"
                  class="px-5 py-2 bg-blue-600 w-1/3 rounded-sm font-bold text-white text-sm hover:bg-blue-700 shadow"
                >
                  <i class="fas fa-store mr-1"></i>
                  Visit Store
                </Link>
                <button
                  class="px-5 py-2 bg-yellow-500 w-1/3 rounded-sm font-bold text-white text-sm hover:bg-yellow-700 shadow"
                >
                  <i class="fas fa-message mr-1"></i>
                  Chat Now
                </button>
              </div>
            </div>
          </main>
        </div>
      </div>
    </section>

    <Information
      :product="product"
      :productQuestions="productQuestions"
      :specificShopProducts="specificShopProducts"
    />
  </AppLayout>
</template>


<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  display: none;
}
</style>
