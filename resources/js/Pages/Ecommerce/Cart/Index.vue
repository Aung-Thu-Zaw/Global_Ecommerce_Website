<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ShoppingCartItem from "@/Components/ShoppingCartItem.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  shops: Object,
  cartItems: Object,
});
</script>


<template>
  <AppLayout>
    <section class="py-5 sm:py-7 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <h2 class="text-4xl text-slate-800 font-semibold mb-2">
          Shopping cart
        </h2>
      </div>
    </section>

    <section class="py-5">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-4">
          <main class="md:w-3/4">
            <article
              v-for="(shop, index) in shops"
              :key="index"
              class="border border-gray-200 bg-white shadow-sm rounded mb-5"
            >
              <div
                class="border-b flex items-center justify-between px-3 py-2 lg:px-5 font-bold text-slate-600 text-md"
              >
                <span>
                  <i class="fas fa-box"></i>
                  Package {{ index + 1 }}
                </span>
                <span class="text-sm text-slate-500">
                  Shipped By
                  <span class="text-slate-700">{{ shop.shop_name }}</span>
                </span>
              </div>

              <!-- item-cart -->
              <div v-for="item in cartItems" :key="item.id">
                <div v-if="item.shop_id == shop.id">
                  <ShoppingCartItem :item="item" />
                </div>
              </div>

              <hr />
            </article>
          </main>

          <aside class="md:w-1/4">
            <article
              class="border border-gray-200 bg-white shadow-sm rounded mb-5 p-3 lg:p-5"
            >
              <ul class="mb-5">
                <li class="flex justify-between text-gray-600 mb-1">
                  <span>Total Items:</span>
                  <span>4 Items</span>
                </li>
                <li class="flex justify-between text-gray-600 mb-1">
                  <span>Total price:</span>
                  <span>$245.97</span>
                </li>
                <li class="flex justify-between text-gray-600 mb-1">
                  <span>Discount:</span>
                  <span class="text-green-500">- $60.00</span>
                </li>
                <li class="flex justify-between text-gray-600 mb-1">
                  <span>Shipping Fee:</span>
                  <span>$14.00</span>
                </li>
                <li
                  class="text-lg font-bold border-t flex justify-between mt-3 pt-3"
                >
                  <span>Total price:</span>
                  <span>$420.00</span>
                </li>
              </ul>

              <a
                class="px-4 py-2 mb-2 inline-block text-lg w-full text-center font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700"
                href="#"
              >
                Checkout
              </a>

              <a
                class="px-4 py-2 inline-block text-lg w-full text-center font-medium text-blue-600 bg-white shadow-sm border border-gray-200 rounded-md hover:bg-gray-100"
                href="#"
              >
                Back to shop
              </a>
            </article>

            <div
              class="border border-gray-200 bg-white shadow-sm rounded my-5 p-3"
            >
              <input
                type="text"
                class="w-full mb-3 rounded-md py-3 border-slate-400"
                placeholder="Enter Cupon Code"
              />
              <a
                class="px-4 py-2 mb-2 inline-block text-lg w-full text-center font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700"
                href="#"
              >
                Apply
              </a>
            </div>
          </aside>
        </div>
      </div>
    </section>
  </AppLayout>
</template>


<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  display: none;
}
</style>
