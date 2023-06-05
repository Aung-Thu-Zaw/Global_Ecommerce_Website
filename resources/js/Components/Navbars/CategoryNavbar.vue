<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <nav class="relative shadow-sm bg-secondary-200">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div class="hidden lg:flex flex-1 items-center py-1">
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
          <ul
            class="flex flex-col p-2 mt-4 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-sm md:border-0 md:dark:bg-gray-900 font-bold"
          >
            <li class="relative">
              <button
                id="dropdownNavbarLink"
                data-dropdown-toggle="dropdownNavbar"
                data-dropdown-trigger="hover"
                class="flex items-center justify-between w-full pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-gray-400 dark:hover:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent"
              >
                <i class="fa-solid fa-list mr-2"></i>
                Shop By Categories
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
          </ul>
        </div>

        <!-- Vendor List  -->
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
          <ul
            class="flex flex-col p-2 mt-4 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-sm md:border-0 md:dark:bg-gray-900 font-bold"
          >
            <li class="relative">
              <button
                id="dropdownSellersButton"
                data-dropdown-toggle="dropdownSellers"
                data-dropdown-placement="bottom"
                data-dropdown-trigger="hover"
                class="flex items-center justify-between w-full pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-gray-400 dark:hover:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent"
              >
                <i class="fa-solid fa-shop mr-2"></i>
                Our Seller Shops
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
                id="dropdownSellers"
                class="z-40 hidden bg-white shadow-md w-[300px] h-[350px] dark:bg-gray-700"
              >
                <ul
                  class="h-full py-2 overflow-y-auto text-gray-700 dark:text-gray-200 scrollbar"
                  aria-labelledby="dropdownSellersButton"
                >
                  <li v-for="vendor in $page.props.vendors" :key="vendor.id">
                    <Link
                      :href="route('shop.show', vendor.id)"
                      :data="{ tab: 'home' }"
                      class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    >
                      <img
                        class="w-6 h-6 mr-2 rounded-full"
                        :src="vendor.avatar"
                        alt="Jese image"
                      />
                      {{ vendor.shop_name }}
                      <span class="text-green-400 rounded-xl">
                        <i class="fa-solid fa-circle-check ml-2"></i>
                      </span>
                    </Link>
                  </li>
                </ul>
                <Link
                  :href="route('shop.index')"
                  class="flex items-center justify-center p-3 text-sm font-medium text-blue-600 border-2 border-gray-200 bg-white rounded-b-lg dark:border-gray-600 hover:bg-gray-100"
                >
                  <i class="fas fa-eye mr-2"></i>
                  View More
                </Link>
              </div>
            </li>
          </ul>
        </div>

        <!-- Our Brands -->
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
          <ul
            class="flex flex-col p-2 mt-4 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:text-sm md:border-0 md:dark:bg-gray-900 font-bold"
          >
            <li class="relative">
              <button
                id="dropdownBrandsButton"
                data-dropdown-toggle="dropdownBrands"
                data-dropdown-placement="bottom"
                data-dropdown-trigger="hover"
                class="flex items-center justify-between w-full pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-gray-400 dark:hover:text-white dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent"
              >
                <i class="fa-solid fa-tags mr-2"></i>
                Our Brands
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
                id="dropdownBrands"
                class="z-40 hidden bg-white shadow-md w-[300px] h-[350px] dark:bg-gray-700"
              >
                <ul
                  class="h-full py-2 overflow-y-auto text-gray-700 dark:text-gray-200 scrollbar"
                  aria-labelledby="dropdownBrandsButton"
                >
                  <li v-for="vendor in $page.props.vendors" :key="vendor.id">
                    <Link
                      :href="route('shop.show', vendor.id)"
                      :data="{ tab: 'home' }"
                      class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                    >
                      <img
                        class="w-6 h-6 mr-2 rounded-full"
                        :src="vendor.avatar"
                        alt="Jese image"
                      />
                      {{ vendor.shop_name }}
                      <span class="text-green-400 rounded-xl">
                        <i class="fa-solid fa-circle-check ml-2"></i>
                      </span>
                    </Link>
                  </li>
                </ul>
                <Link
                  :href="route('shop.index')"
                  class="flex items-center justify-center p-3 text-sm font-medium text-blue-600 border-2 border-gray-200 bg-white rounded-b-lg dark:border-gray-600 hover:bg-gray-100"
                >
                  <i class="fas fa-eye mr-2"></i>
                  View More
                </Link>
              </div>
            </li>
          </ul>
        </div>

        <!-- Our Blogs  -->

        <Link
          :href="route('blogs.index')"
          class="font-bold text-sm text-gray-700 hover:text-blue-700 transition-all ml-3"
        >
          <i class="fa-solid fa-newspaper mr-2"></i>
          <span>Our Blogs</span>
        </Link>
      </div>
    </div>
  </nav>
</template>



<style>
.chat-box {
  box-shadow: -5px 0px 8px 0px #3737377f;
}

.scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #999 #f0f0f0;
}

.scrollbar::-webkit-scrollbar {
  width: 6px;
}

.scrollbar::-webkit-scrollbar-track {
  background-color: #f0f0f0;
}

.scrollbar::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}
</style>
