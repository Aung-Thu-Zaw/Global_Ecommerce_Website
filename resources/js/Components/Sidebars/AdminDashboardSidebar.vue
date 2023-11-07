<script setup>
// import DashboardNotificationDropdown from "@/components/Dropdowns/DashboardNotificationDropdown.vue";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import logo from "@/assets/images/website-logo-color.png";

const collapseShow = ref("hidden");

const toggleCollapseShow = (classes) => {
  collapseShow.value = classes;
};
</script>

<template>
  <nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6"
  >
    <div
      class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center md:justify-between w-full mx-auto"
    >
      <!-- Toggler -->
      <button
        class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
        type="button"
        v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')"
      >
        <i class="fas fa-bars"></i>
      </button>
      <!-- Brand -->
      <Link
        :href="route('home')"
        class="md:block text-left text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm font-bold px-0"
      >
        <img :src="logo" alt="logo" class="w-auto h-4 md:h-12 object-contain" />
      </Link>
      <!-- User -->
      <ul class="md:hidden items-center flex flex-wrap list-none ml-auto">
        <li class="inline-block relative">
          <!-- <DashboardNotificationDropdown /> -->
        </li>
        <li class="inline-block relative">
          <UserDropdown />
        </li>
      </ul>
      <!-- Collapse -->
      <div
        class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded border border-accent-light md:border-none"
        v-bind:class="collapseShow"
      >
        <!-- Collapse header -->
        <div
          class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-blueGray-200"
        >
          <div class="flex flex-wrap">
            <div class="w-6/12">
              <Link
                :href="route('home')"
                class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm font-bold p-4 px-0"
              >
                <img
                  :src="logo"
                  alt="logo"
                  class="w-auto h-12 object-contain"
                />
              </Link>
            </div>
            <div class="w-6/12 flex justify-end">
              <button
                type="button"
                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                v-on:click="toggleCollapseShow('hidden')"
              >
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        <form class="mt-6 mb-4 md:hidden">
          <div class="mb-3 pt-0">
            <input
              type="text"
              placeholder="Search"
              class="px-3 py-2 h-12 border border-solid border-blueGray-500 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-base leading-snug shadow-none outline-none focus:outline-none w-full font-normal"
            />
          </div>
        </form>

        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-blueGray-500 text-xs font-bold block pt-1 pb-4 no-underline"
        >
          {{ __("E-commerce Administration") }}
        </h6>
        <!-- Navigation -->

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Dashboard -->
          <li class="items-center">
            <Link :href="route('admin.dashboard')">
              <div
                class="text-xs py-3 font-bold block"
                :class="{
                  'text-blue-600 hover:text-blue-500':
                    $page.url === '/admin/dashboard',
                  'text-slate-600 hover:text-slate-500':
                    $page.url !== '/admin/dashboard',
                }"
              >
                <i class="fas fa-tv mr-2 text-sm"></i>
                {{ __("Dashboard") }}
              </div>
            </Link>
          </li>

          <!-- Brands -->
          <li v-show="can('brands.view')" class="items-center">
            <Link
              :href="route('admin.brands.index')"
              :data="{
                page: 1,
                per_page: 5,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs py-3 font-bold block"
              :class="{
                'text-blue-600 hover:text-blue-500':
                  $page.url.startsWith('/admin/brands'),
                'text-slate-600 hover:text-slate-500':
                  !$page.url.startsWith('/admin/brands'),
              }"
            >
              <i class="fa-solid fa-award mr-2 text-sm"></i>
              {{ __("Brands") }}
            </Link>
          </li>

          <!-- Collections -->
          <li class="items-center">
            <Link
              :href="route('admin.collections.index')"
              :data="{
                page: 1,
                per_page: 5,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs py-3 font-bold block"
              :class="{
                'text-blue-600 hover:text-blue-500':
                  $page.url.startsWith('/admin/collections'),
                'text-slate-600 hover:text-slate-500':
                  !$page.url.startsWith('/admin/collections'),
              }"
            >
              <i class="fa-solid fa-box mr-2 text-sm"></i>
              {{ __("COLLECTIONS") }}
            </Link>
          </li>

          <!-- Categories -->
          <li class="items-center">
            <Link
              :href="route('admin.categories.index')"
              :data="{
                page: 1,
                per_page: 5,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs py-3 font-bold block"
              :class="{
                'text-blue-600 hover:text-blue-500':
                  $page.url.startsWith('/admin/categories'),
                'text-slate-600 hover:text-slate-500':
                  !$page.url.startsWith('/admin/categories'),
              }"
            >
              <i class="fa-solid fa-list mr-2 text-sm"></i>
              {{ __("CATEGORIES") }}
            </Link>
          </li>

          <!-- Products -->
          <li class="items-center">
            <Link
              :href="route('admin.products.index')"
              :data="{
                page: 1,
                per_page: 5,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs py-3 font-bold block"
              :class="{
                'text-blue-600 hover:text-blue-500':
                  $page.url.startsWith('/admin/products'),
                'text-slate-600 hover:text-slate-500':
                  !$page.url.startsWith('/admin/products'),
              }"
            >
              <i class="fa-solid fa-basket-shopping mr-2 text-sm"></i>
              {{ __("PRODUCTS") }}
            </Link>
          </li>

          <!-- Coupons -->
          <li class="items-center">
            <Link
              :href="route('admin.coupons.index')"
              :data="{
                page: 1,
                per_page: 5,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs py-3 font-bold block"
              :class="{
                'text-blue-600 hover:text-blue-500':
                  $page.url.startsWith('/admin/coupons'),
                'text-slate-600 hover:text-slate-500':
                  !$page.url.startsWith('/admin/coupons'),
              }"
            >
              <i class="fa-solid fa-ticket mr-2 text-sm"></i>
              {{ __("COUPONS") }}
            </Link>
          </li>

          <!-- Flash Sales -->
          <li class="items-center">
            <Link
              :href="route('admin.flash-sales.edit')"
              :data="{
                page: 1,
                per_page: 5,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs py-3 font-bold block"
              :class="{
                'text-blue-600 hover:text-blue-500':
                  $page.url.startsWith('/admin/flash-sales'),
                'text-slate-600 hover:text-slate-500':
                  !$page.url.startsWith('/admin/flash-sales'),
              }"
            >
              <i class="fa-solid fa-bolt-lightning mr-2 text-sm"></i>
              {{ __("FLASH_SALES") }}
            </Link>
          </li>

          <!-- Banners -->
          <li class="items-center">
            <nav
              class="hs-accordion-group w-full cursor-pointer"
              data-hs-accordion-always-open
            >
              <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="hs-accordion w-full" id="banner-accordion">
                  <div
                    class="hs-accordion-toggle flex items-center justify-between py-3 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent"
                  >
                    <div
                      class="flex items-center text-xs font-bold text-slate-600 hover:text-slate-500"
                    >
                      <i class="fa-solid fa-ad mr-2 text-sm"></i>
                      {{ __("BANNERS") }}
                    </div>
                    <div>
                      <svg
                        class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>

                      <svg
                        class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>
                    </div>
                  </div>

                  <div
                    id="banner-accordion"
                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                  >
                    <ul
                      class="text-xs ml-10 font-bold text-blueGray-500 h-auto flex flex-col items-center space-y-1"
                    >
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/banners/slider-banners'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.slider-banners.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("SLIDER_BANNERS") }}
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/banners/campaign-banners'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.campaign-banners.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("CAMPAIGN_BANNERS") }}
                        </Link>
                      </li>
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/banners/product-banners'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.product-banners.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("PRODUCT_BANNERS") }}
                        </Link>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </li>

          <!-- Shipping Areas -->
          <li class="items-center">
            <nav
              class="hs-accordion-group w-full cursor-pointer"
              data-hs-accordion-always-open
            >
              <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="hs-accordion w-full" id="shipping-accordion">
                  <div
                    class="hs-accordion-toggle flex items-center justify-between py-3 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent"
                  >
                    <div
                      class="flex items-center text-xs font-bold text-slate-600 hover:text-slate-500"
                    >
                      <i class="fa-solid fa-map-location-dot mr-2 text-sm"></i>
                      {{ __("SHIPPING_AREAS") }}
                    </div>
                    <div>
                      <svg
                        class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>

                      <svg
                        class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>
                    </div>
                  </div>

                  <div
                    id="shipping-accordion"
                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                  >
                    <ul
                      class="text-xs ml-10 font-bold text-blueGray-500 h-auto flex flex-col items-center space-y-1"
                    >
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/shipping-areas/countries'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.countries.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("COUNTRIES") }}
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/shipping-areas/regions'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.regions.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("REGIONS") }}
                        </Link>
                      </li>
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/shipping-areas/cities'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.cities.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("CITIES") }}
                        </Link>
                      </li>
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/shipping-areas/townships'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.townships.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("TOWNSHIPS") }}
                        </Link>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </li>

          <!-- Blogs -->
          <li class="items-center">
            <nav
              class="hs-accordion-group w-full cursor-pointer"
              data-hs-accordion-always-open
            >
              <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="hs-accordion w-full" id="blog-accordion">
                  <div
                    class="hs-accordion-toggle flex items-center justify-between py-3 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent"
                  >
                    <div
                      class="flex items-center text-xs font-bold text-slate-600 hover:text-slate-500"
                    >
                      <i class="fa-solid fa-file-pen mr-2 text-sm"></i>
                      {{ __("BLOGS") }}
                    </div>
                    <div>
                      <svg
                        class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>

                      <svg
                        class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>
                    </div>
                  </div>

                  <div
                    id="blog-accordion"
                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                  >
                    <ul
                      class="text-xs ml-10 font-bold text-blueGray-500 h-auto flex flex-col items-center space-y-1"
                    >
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/categories'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.categories.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("CATEGORIES") }}
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/contents'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.posts.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("CONTENTS") }}
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/comments'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.comments.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("COMMENTS") }}
                        </Link>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </li>
        </ul>

        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-blueGray-500 text-xs font-bold block pt-1 pb-4 no-underline"
        >
          Management and Oversight
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Vouchers -->
          <li class="items-center">
            <Link
              :href="route('admin.coupons.index')"
              :data="{
                page: 1,
                per_page: 5,
                sort: 'id',
                direction: 'desc',
              }"
              class="text-xs py-3 font-bold block"
              :class="{
                'text-blue-600 hover:text-blue-500':
                  $page.url.startsWith('/admin/coupons'),
                'text-slate-600 hover:text-slate-500':
                  !$page.url.startsWith('/admin/coupons'),
              }"
            >
              <i class="fa-solid fa-ticket-simple mr-2 text-sm"></i>
              Vouchers
            </Link>
          </li>

          <!-- Order Managements -->
          <li class="items-center">
            <nav
              class="hs-accordion-group w-full cursor-pointer"
              data-hs-accordion-always-open
            >
              <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="hs-accordion w-full" id="review-accordion">
                  <div
                    class="hs-accordion-toggle flex items-center justify-between py-3 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent"
                  >
                    <div
                      class="flex items-center text-xs font-bold text-slate-600 hover:text-slate-500"
                    >
                      <i class="fa-solid fa-boxes-packing mr-2 text-sm"></i>
                      {{ __("ORDER_MANAGEMENTS") }}
                    </div>
                    <div>
                      <svg
                        class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>

                      <svg
                        class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>
                    </div>
                  </div>

                  <div
                    id="review-accordion"
                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                  >
                    <ul
                      class="text-xs ml-10 font-bold text-blueGray-500 h-auto flex flex-col items-center space-y-1"
                    >
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/review-managements/product-reviews'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.product-reviews.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("PRODUCT_REVIEWS") }}
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/review-managements/shop-reviews'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.shop-reviews.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("SHOP_REVIEWS") }}
                        </Link>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </li>

          <!-- Review Managements -->
          <li class="items-center">
            <nav
              class="hs-accordion-group w-full cursor-pointer"
              data-hs-accordion-always-open
            >
              <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="hs-accordion w-full" id="review-accordion">
                  <div
                    class="hs-accordion-toggle flex items-center justify-between py-3 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent"
                  >
                    <div
                      class="flex items-center text-xs font-bold text-slate-600 hover:text-slate-500"
                    >
                      <i class="fa-solid fa-star mr-2 text-sm"></i>
                      {{ __("REVIEW_MANAGEMENTS") }}
                    </div>
                    <div>
                      <svg
                        class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>

                      <svg
                        class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>
                    </div>
                  </div>

                  <div
                    id="review-accordion"
                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                  >
                    <ul
                      class="text-xs ml-10 font-bold text-blueGray-500 h-auto flex flex-col items-center space-y-1"
                    >
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/review-managements/product-reviews'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.product-reviews.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("PRODUCT_REVIEWS") }}
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/review-managements/shop-reviews'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.shop-reviews.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("SHOP_REVIEWS") }}
                        </Link>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </li>

          <!-- Account Managements -->
          <li class="items-center">
            <nav
              class="hs-accordion-group w-full cursor-pointer"
              data-hs-accordion-always-open
            >
              <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="hs-accordion w-full" id="account-accordion">
                  <div
                    class="hs-accordion-toggle flex items-center justify-between py-3 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent"
                  >
                    <div
                      class="flex items-center text-xs font-bold text-slate-600 hover:text-slate-500"
                    >
                      <i class="fa-solid fa-user-shield mr-2 text-sm"></i>
                      {{ __("ACCOUNT_MANAGEMENTS") }}
                    </div>
                    <div>
                      <svg
                        class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>

                      <svg
                        class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>
                    </div>
                  </div>

                  <div
                    id="account-accordion"
                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                  >
                    <ul
                      class="text-xs ml-10 font-bold text-blueGray-500 h-auto flex flex-col items-center space-y-1"
                    >
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/account-managements/registered-accounts'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.registered-accounts.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("REGISTERED_ACCOUNTS") }}
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/account-managements/seller-manage'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.seller-manage.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("SELLER_MANAGE") }}
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/account-managements/admin-manage'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.admin-manage.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("ADMIN_MANAGE") }}
                        </Link>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </li>

          <!-- Authority Managements -->
          <li class="items-center">
            <nav
              class="hs-accordion-group w-full cursor-pointer"
              data-hs-accordion-always-open
            >
              <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="hs-accordion w-full" id="authority-accordion">
                  <div
                    class="hs-accordion-toggle flex items-center justify-between py-3 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent"
                  >
                    <div
                      class="flex items-center text-xs font-bold text-slate-600 hover:text-slate-500"
                    >
                      <i class="fa-solid fa-user-lock mr-2 text-sm"></i>
                      {{ __("AUTHORITY_MANAGEMENTS") }}
                    </div>
                    <div>
                      <svg
                        class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>

                      <svg
                        class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>
                    </div>
                  </div>

                  <div
                    id="authority-accordion"
                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                  >
                    <ul
                      class="text-xs ml-10 font-bold text-blueGray-500 h-auto flex flex-col items-center space-y-1"
                    >
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/authority-managements/roles'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.roles.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("ROLES") }}
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/authority-managements/permissions'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.permissions.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("PERMISSIONS") }}
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/authority-managements/role-in-permissions'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.role-in-permissions.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          {{ __("ROLE_IN_PERMISSIONS") }}
                        </Link>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </li>
        </ul>

        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-blueGray-500 text-xs font-bold block pt-1 pb-4 no-underline"
        >
          Subscribers & Newsletters
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Subscribers -->
          <li class="items-center">
            <Link
              :href="route('admin.live-chats.index')"
              class="text-xs py-3 font-bold block"
              :data="{
                tab: 'all-chats',
              }"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/live-chats'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/live-chats'),
              }"
            >
              <i class="fa-solid fa-comment mr-2 text-sm"></i>
              {{ __("SUBSCRIBERS") }}
            </Link>
          </li>

          <!-- NewsLetters -->
          <li class="items-center">
            <Link
              :href="route('admin.live-chats.index')"
              class="text-xs py-3 font-bold block"
              :data="{
                tab: 'all-chats',
              }"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/live-chats'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/live-chats'),
              }"
            >
              <i class="fa-solid fa-envelope-open-text mr-2 text-sm"></i>
              {{ __("NEWSLETTERS") }}
            </Link>
          </li>
        </ul>

        <!-- Order Managements -->
        <!-- Return Order Managements -->
        <!-- Cancel Order Managements -->

        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-blueGray-500 text-xs font-bold block pt-1 pb-4 no-underline"
        >
          Support & Content
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Chats -->
          <li class="items-center">
            <Link
              :href="route('admin.live-chats.index')"
              class="text-xs py-3 font-bold block"
              :data="{
                tab: 'all-chats',
              }"
              :class="{
                'text-blue-500 hover:text-blue-600':
                  $page.url.startsWith('/admin/live-chats'),
                'text-slate-700 hover:text-slate-500':
                  !$page.url.startsWith('/admin/live-chats'),
              }"
            >
              <i class="fa-solid fa-comment mr-2 text-sm"></i>
              {{ __("CHATS") }}
            </Link>
          </li>

          <!-- FAQs -->
          <li class="items-center">
            <nav
              class="hs-accordion-group w-full cursor-pointer"
              data-hs-accordion-always-open
            >
              <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="hs-accordion w-full" id="faq-accordion">
                  <div
                    class="hs-accordion-toggle flex items-center justify-between py-3 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent"
                  >
                    <div
                      class="flex items-center text-xs font-bold text-slate-600 hover:text-slate-500"
                    >
                      <i
                        class="fa-solid fa-file-circle-question mr-2 text-sm"
                      ></i>
                      FAQs
                    </div>
                    <div>
                      <svg
                        class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>

                      <svg
                        class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>
                    </div>
                  </div>

                  <div
                    id="faq-accordion"
                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                  >
                    <ul
                      class="text-xs ml-10 font-bold text-blueGray-500 h-auto flex flex-col items-center space-y-1"
                    >
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/categories'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.categories.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          Categories
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/contents'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.posts.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          Subcategories
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/comments'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.comments.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          Faqs
                        </Link>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </li>

          <!-- Pages -->
          <li class="items-center">
            <nav
              class="hs-accordion-group w-full cursor-pointer"
              data-hs-accordion-always-open
            >
              <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="hs-accordion w-full" id="blog-accordion">
                  <div
                    class="hs-accordion-toggle flex items-center justify-between py-3 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent"
                  >
                    <div
                      class="flex items-center text-xs font-bold text-slate-600 hover:text-slate-500"
                    >
                      <i class="fa-solid fa-file-lines mr-2 text-sm"></i>
                      Pages
                    </div>
                    <div>
                      <svg
                        class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>

                      <svg
                        class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>
                    </div>
                  </div>

                  <div
                    id="blog-accordion"
                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                  >
                    <ul
                      class="text-xs ml-10 font-bold text-blueGray-500 h-auto flex flex-col items-center space-y-1"
                    >
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/categories'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.categories.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          About Us
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/contents'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.posts.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          Our History
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/comments'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.comments.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          Terms & Conditions
                        </Link>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </li>
        </ul>

        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-blueGray-500 text-xs font-bold block pt-1 pb-4 no-underline"
        >
          Website Configuration
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Settings -->
          <li class="items-center">
            <nav
              class="hs-accordion-group w-full cursor-pointer"
              data-hs-accordion-always-open
            >
              <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                <li class="hs-accordion w-full" id="blog-accordion">
                  <div
                    class="hs-accordion-toggle flex items-center justify-between py-3 hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent"
                  >
                    <div
                      class="flex items-center text-xs font-bold text-slate-600 hover:text-slate-500"
                    >
                      <i class="fa-solid fa-gears mr-2 text-sm"></i>
                      {{ __("SETTINGS") }}
                    </div>
                    <div>
                      <svg
                        class="hs-accordion-active:block ml-auto hidden w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 11L8.16086 5.31305C8.35239 5.13625 8.64761 5.13625 8.83914 5.31305L15 11"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>

                      <svg
                        class="hs-accordion-active:hidden ml-auto block w-3 h-3 text-gray-600 group-hover:text-gray-500"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                        ></path>
                      </svg>
                    </div>
                  </div>

                  <div
                    id="blog-accordion"
                    class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden"
                  >
                    <ul
                      class="text-xs ml-10 font-bold text-blueGray-500 h-auto flex flex-col items-center space-y-1"
                    >
                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/categories'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.categories.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          General Settings
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/contents'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.posts.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          SEO Settings
                        </Link>
                      </li>

                      <li
                        class="p-2 hover:text-blueGray-600 text-left w-full"
                        :class="{
                          'text-blue-600 hover:text-blue-500':
                            $page.url.startsWith(
                              '/admin/blog-managements/comments'
                            ),
                        }"
                      >
                        <Link
                          :href="route('admin.blogs.comments.index')"
                          :data="{
                            page: 1,
                            per_page: 10,
                            sort: 'id',
                            direction: 'desc',
                          }"
                        >
                          Payment Settings
                        </Link>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
            </nav>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />
        <!-- Heading -->
        <h6
          class="md:min-w-full text-blueGray-500 text-xs font-bold block pt-1 pb-4 no-underline"
        >
          Important Operations
        </h6>

        <ul class="md:flex-col md:min-w-full flex flex-col list-none">
          <!-- Clear Database Section -->
          <li class="items-center">
            <Link href="#">
              <div
                class="text-xs py-3 font-bold block"
                :class="{
                  'text-blue-600 hover:text-blue-500': $page.url.startsWith(
                    '/admin/clear-database'
                  ),
                  'text-red-600 hover:text-red-500': !$page.url.startsWith(
                    '/admin/clear-database'
                  ),
                }"
              >
                <i class="fa-solid fa-database mr-2 text-sm"></i>
                Clear Database
              </div>
            </Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>










