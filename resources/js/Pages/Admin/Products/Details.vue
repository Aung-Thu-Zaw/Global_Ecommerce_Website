<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductBreadcrumb.vue";
import { Link, Head } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  paginate: Object,
  product: Object,
});
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="product.name" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
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
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
              >
                {{ product.name }}
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
              <span
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                >Details</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back button -->
        <div>
          <Link
            as="button"
            :href="route('admin.products.index')"
            :data="{
              page: props.paginate.page,
              per_page: props.paginate.per_page,
            }"
            class="goback-btn"
          >
            <span>
              <i class="fa-solid fa-circle-left"></i>
              Go Back
            </span>
          </Link>
        </div>
      </div>

      <!-- Product Detail -->
      <div class="p-5 border shadow-md rounded-sm my-5">
        <h1 class="font-bold text-slate-700 text-2xl border-b-4 px-10 py-3">
          Product Details
        </h1>

        <div v-if="product" class="my-3">
          <div class="flex items-center my-3 space-x-2">
            <div>
              <img
                :src="product.image"
                alt=""
                class="h-36 rounded-md shadow ring-2 ring-slate-300"
              />
            </div>
            <div v-for="image in product.images" :key="image.id">
              <img
                :src="image.img_path"
                alt=""
                class="h-36 rounded-md shadow ring-2 ring-slate-300"
              />
            </div>
          </div>
          <div
            class="w-full text-sm text-left text-gray-500 border overflow-hidden shadow rounded-md my-5"
          >
            <div>
              <div
                class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
              >
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Product Name
                </span>
                <span class="w-1/2 block">
                  {{ product.name }}
                </span>
              </div>
              <div class="border-b py-3 bg-gray-50 flex items-center">
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Product Code
                </span>
                <span class="w-1/2 block">
                  {{ product.code }}
                </span>
              </div>
              <div
                class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
              >
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Product Quantity
                </span>
                <span class="w-1/2 block">
                  {{ product.qty }}
                </span>
              </div>
              <div class="border-b py-3 bg-gray-50 flex items-center">
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Product Price
                </span>
                <span class="w-1/2 block"> $ {{ product.price }} </span>
              </div>
              <div
                class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
              >
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Product Discount
                </span>
                <span class="w-1/2 block">
                  <span v-if="product.discount">
                    $ {{ product.discount }}

                    <span
                      class="rounded-full px-3 py-1 bg-green-200 text-green-600 font-bold ml-5"
                    >
                      {{
                        (
                          ((product.price - product.discount) / product.price) *
                          100
                        ).toFixed(1)
                      }}%
                    </span>
                  </span>
                  <span
                    v-else
                    class="rounded-full px-3 py-1 bg-sky-200 text-sky-600 font-bold"
                  >
                    No Discount
                  </span>
                </span>
              </div>
              <div
                class="bg-gray-50 border-b py-3 dark:bg-gray-900 flex items-center"
              >
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Special Offer
                </span>
                <span class="w-1/2 block">
                  {{ product.special_offer ? "Yes" : "No" }}
                </span>
              </div>
              <div class="border-b py-3 bg-white flex items-center">
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Featured
                </span>
                <span class="w-1/2 block">
                  {{ product.featured ? "Yes" : "No" }}
                </span>
              </div>
              <div
                class="bg-gray-50 border-b py-3 dark:bg-gray-900 flex items-center"
              >
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Hot Deal
                </span>
                <span class="w-1/2 block">
                  {{ product.hot_deal ? "Yes" : "No" }}</span
                >
              </div>
              <div class="border-b py-3 bg-white flex items-center">
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Status
                </span>
                <span class="w-1/2 block capitalize">
                  <span
                    v-if="product.status == active"
                    class="rounded-full bg-green-200 text-green-600 px-3 py-1 font-bold"
                  >
                    {{ product.status }}
                  </span>
                  <span
                    v-else
                    class="rounded-full bg-red-200 text-red-600 px-3 py-1 font-bold"
                  >
                    {{ product.status }}
                  </span>
                </span>
              </div>
              <div
                class="bg-gray-50 border-b py-3 dark:bg-gray-900 flex items-center"
              >
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Brand
                </span>
                <span class="w-1/2 block">
                  {{ product.brand ? product.brand.name : "No Brand" }}
                </span>
              </div>

              <div class="border-b py-3 bg-white flex items-center">
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Vendor
                </span>
                <span class="w-1/2 block">
                  {{ product.shop.shop_name }}
                </span>
              </div>
              <div class="border-b py-3 bg-gray-50 flex items-center">
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Product Description
                </span>
                <span v-html="product.description" class="w-1/2 block"> </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
