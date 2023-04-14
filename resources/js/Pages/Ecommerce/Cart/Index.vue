<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";

const quantity = ref(1);

const increment = () => quantity.value++;
const decrement = () => (quantity.value <= 1 ? 1 : quantity.value--);
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
              class="border border-gray-200 bg-white shadow-sm rounded mb-5"
            >
              <div
                class="border-b flex items-center justify-between px-3 py-2 lg:px-5 font-bold text-slate-600 text-md"
              >
                <span>
                  <i class="fas fa-box"></i>
                  Package 1
                </span>
                <span class="text-sm text-slate-500">
                  Shipped By
                  <span class="text-slate-700">Aung Thu Zaw</span>
                </span>
              </div>

              <!-- item-cart -->
              <div
                class="flex flex-wrap lg:flex-row gap-5 mb-4 px-3 py-2 lg:py-4 lg:px-5"
              >
                <div class="w-full lg:w-2/5 xl:w-2/4">
                  <figure class="flex leading-5">
                    <div>
                      <div
                        class="block w-16 h-16 rounded border border-gray-200 overflow-hidden"
                      >
                        <img src="images/items/1.jpg" alt="Title" />
                      </div>
                    </div>
                    <figcaption class="ml-3">
                      <p>
                        <a
                          href="#"
                          class="hover:text-blue-600 font-semibold text-slate-600"
                          >Modern Product Name Goes Here as demo
                        </a>
                      </p>
                      <span class="text-[.8rem] text-gray-500">
                        Brand: Galaxy
                      </span>
                      <span class="text-gray-600">|</span>
                      <span class="text-[.8rem] text-gray-500">
                        Size: 6 Months
                      </span>
                      <span class="text-gray-600">|</span>
                      <span class="text-[.8rem] text-gray-500">
                        Color: Yellow
                      </span>
                      <p class="text-[.8rem] text-red-500 font-bold">
                        Only 5 item(s) left
                      </p>
                    </figcaption>
                  </figure>
                </div>

                <div class="">
                  <div class="leading-5">
                    <p class="font-semibold not-italic">$1156.00</p>
                    <small class="text-gray-600 block">
                      $460.00 / per item
                    </small>
                    <small class="text-gray-400 block line-through">
                      $2000$ / per item
                    </small>
                    <small
                      class="bg-green-300 text-green-600 px-2 py-1 rounded-full text-[.6rem]"
                    >
                      -20% OFF
                    </small>
                  </div>
                </div>

                <div class="">
                  <!-- selection -->
                  <div class="w-auto relative">
                    <div>
                      <span
                        class="px-3 py-2 bg-slate-500 hover:bg-slate-600 rounded-sm cursor-pointer"
                        @click="increment"
                      >
                        <i class="fa-solid fa-plus text-white"></i>
                      </span>

                      <input
                        type="number"
                        class="border-2 text-center border-slate-500 outline-none focus:outline-none focus:ring-0 w-[50px] h-full mx-1 rounded-sm"
                        v-model="quantity"
                      />
                      <span
                        class="px-3 py-2 bg-slate-500 hover:bg-slate-600 mr-2 rounded-sm cursor-pointer"
                        @click="decrement"
                      >
                        <i class="fa-solid fa-minus text-white"></i>
                      </span>
                    </div>
                  </div>
                </div>

                <div class="flex-auto">
                  <div class="float-right">
                    <a
                      class="px-4 py-2 inline-block text-blue-600 bg-white shadow-sm border border-gray-200 rounded-md ml-3 hover:bg-blue-600 hover:text-white transition-all"
                      href="#"
                    >
                      <i class="fa fa-heart"></i>
                    </a>
                    <a
                      class="px-4 py-2 inline-block text-red-600 bg-white shadow-sm border border-gray-200 rounded-md hover:bg-red-600 hover:text-white transition-all ml-3"
                      href="#"
                    >
                      <i class="fa fa-trash"></i>
                    </a>
                  </div>
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
