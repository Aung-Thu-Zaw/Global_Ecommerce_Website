<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import Home from "./Partials/Home.vue";
import AllProducts from "./Partials/AllProducts.vue";
import ShopRating from "./Partials/ShopRating.vue";
import ProductRating from "./Partials/ProductRating.vue";
import { usePage, router, Link, Head } from "@inertiajs/vue3";
</script>


<template>
  <AppLayout>
    <Head title="All Collections" />
    <section class="pt-10 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div
          class="shadow border rounded-sm p-5 mb-5 flex items-center justify-between"
        >
          <div class="flex items-center">
            <img
              src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSUdHX7OODp6tyUKh-AS88pK5n5MdPKnPxYarCR1R1m9zX2bCUVZSCSrRerMWdcyJGnXlw&usqp=CAU"
              alt=""
              class="w-16 h-16 rounded-full object-cover mr-5 ring-2 ring-blue-500"
            />
            <div>
              <h3 class="text-2xl font-bold text-slate-700">
                Samsung
                <span
                  class="px-3 py-1 bg-green-200 text-green-600 rounded-xl text-[.8rem]"
                >
                  <i class="fa-solid fa-circle-check"></i>
                  Verified
                </span>
              </h3>
              <span class="text-sm text-slate-500 block">22 Followers</span>
              <span class="text-sm text-green-500 animate-pulse font-bold">
                <i class="fa-solid fa-circle text-[.6rem]"></i>
                Active
              </span>
              <span class="text-sm text-red-500 animate-pulse font-bold">
                <i class="fa-solid fa-circle text-[.6rem]"></i>
                Offline
              </span>
            </div>
          </div>
          <div>
            <button
              class="px-5 py-2 rounded-sm mx-2 font-bold shadow bg-yellow-600 hover:bg-yellow-700 text-white"
            >
              <i class="fa-solid fa-message"></i>
              Chat Now
            </button>
            <button
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
            <li class="relative mr-2 flex items-center">
              <button
                id="dropdownNavbarLink"
                data-dropdown-toggle="dropdownNavbar"
                data-dropdown-trigger="hover"
                class="flex items-center justify-center w-full pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto"
              >
                <i class="fa-solid fa-list mr-2"></i>
                Categories
                <svg
                  class="w-5 h-5 ml-1"
                  aria-hidden="true"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
              </button>
              <!-- Dropdown menu -->
              <div
                id="dropdownNavbar"
                class="hidden z-40 font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-md w-[900px] h-[700px] ml-10 overflow-auto"
              >
                <div
                  class="grid grid-cols-1 md:grid-cols-3 p-5 text-slate-700 overflow-auto"
                >
                  <ul
                    class="m-3"
                    v-for="category in $page.props.parentCategory"
                    :key="category.id"
                  >
                    <li class="flex items-center">
                      <img
                        :src="category.image"
                        alt=""
                        class="w-7 h-7 rounded-full object-cover mr-2 border-2 border-secondary-500"
                      />
                      <a
                        href="#"
                        class="hover:text-blue-600 hover:underline cursor-pointer text-[1.1rem] font-bold"
                      >
                        {{ category.name }}
                      </a>
                    </li>
                    <li
                      v-for="childCategory in category.children"
                      :key="childCategory.id"
                      class="flex items-start"
                    >
                      <span>
                        <i
                          class="fa-solid fa-circle text-[.4rem] text-slate-600 mx-4"
                        ></i>
                      </span>

                      <span>
                        <a
                          class="font-medium text-sm hover:text-blue-600 hover:underline cursor-pointer"
                        >
                          {{ childCategory.name }}
                        </a>
                      </span>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
            <li class="mr-2" role="presentation">
              <a
                href="#"
                class="inline-flex p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group"
                id="home-tab"
                data-tabs-target="#home"
                type="button"
                role="tab"
                aria-controls="home"
                aria-selected="false"
              >
                <i class="fa-solid fa-home mr-2 text-sm"></i>
                Home
              </a>
            </li>
            <li class="mr-2" role="presentation">
              <a
                href="#"
                class="inline-flex p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group"
                aria-current="page"
                id="products-tab"
                data-tabs-target="#products"
                type="button"
                role="tab"
                aria-controls="products"
                aria-selected="false"
              >
                <i class="fa-solid fa-basket-shopping mr-2 text-sm"></i>
                All Products
              </a>
            </li>
            <li class="mr-2" role="presentation">
              <a
                href="#"
                class="inline-flex p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group"
                id="ratingsForShop-tab"
                data-tabs-target="#ratingsForShop"
                type="button"
                role="tab"
                aria-controls="ratingsForShop"
                aria-selected="false"
              >
                <i class="fa-solid fa-star mr-2 text-sm"></i>
                Ratings & Reviews For Shop
              </a>
            </li>
            <li class="mr-2" role="presentation">
              <a
                href="#"
                class="inline-flex p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group"
                id="ratingsForProducts-tab"
                data-tabs-target="#ratingsForProducts"
                type="button"
                role="tab"
                aria-controls="ratingsForProducts"
                aria-selected="false"
              >
                <i class="fa-solid fa-star mr-2 text-sm"></i>
                Ratings & Reviews For Products
              </a>
            </li>
          </ul>

          <div>
            <input
              type="text"
              class="border-2 border-slate-400 rounded-sm focus:ring-0 focus:border-slate-400 mr-2"
              placeholder="Search in store"
            />
            <button
              class="px-3 py-2 bg-blue-600 hover:bg-blue-70 text-white rounded-sm"
            >
              <i class="fa-solid fa-magnifying-glass"></i>
            </button>
          </div>
        </div>

        <div id="myTabContet" class="w-full">
          <div
            class="hidden w-full"
            id="home"
            role="tabpanel"
            aria-labelledby="home-tab"
          >
            <Home />
          </div>
          <div
            class="hidden w-full"
            id="products"
            role="tabpanel"
            aria-labelledby="products-tab"
          >
            <AllProducts />
          </div>

          <div
            class="hidden w-full"
            id="ratingsForShop"
            role="tabpanel"
            aria-labelledby="ratingsForShop-tab"
          >
            <ShopRating />
          </div>

          <div
            class="hidden w-full"
            id="ratingsForProducts"
            role="tabpanel"
            aria-labelledby="ratingsForProducts-tab"
          >
            <ProductRating />
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>


