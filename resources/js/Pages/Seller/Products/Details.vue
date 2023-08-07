<script setup>
import VendorDashboardLayout from "@/Layouts/SellerDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductBreadcrumb.vue";
import NoDiscountStatus from "@/Components/Status/NoDiscountStatus.vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import ApprovedStatus from "@/Components/Status/ApprovedStatus.vue";
import DiscountStatus from "@/Components/Status/DiscountStatus.vue";
import { Link, Head } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  product: Object,
});

// Formatted Amount
const formattedAmount = (amount) => {
  const totalAmount = parseFloat(amount);
  if (Number.isInteger(totalAmount)) {
    return totalAmount.toFixed(0);
  } else {
    return totalAmount.toFixed(2);
  }
};
</script>

<template>
  <VendorDashboardLayout>
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
            :href="route('vendor.products.index')"
            :data="{
              page: props.queryStringParams.page,
              per_page: props.queryStringParams.per_page,
              sort: props.queryStringParams.sort,
              direction: props.queryStringParams.direction,
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
              <div class="bg-white border-b py-3 flex items-center">
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Product Name
                </span>
                <span class="w-1/2 block">
                  {{ product.name }}
                </span>
              </div>
              <div
                v-if="product.sizes.length"
                class="border-b py-3 bg-gray-50 flex items-center"
              >
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Avaliable Product Sizes
                </span>
                <span class="w-1/2 block space-x-3">
                  <span
                    v-for="size in product.sizes"
                    :key="size.id"
                    class="px-3 py-1 text-xs font-bold text-white bg-blue-600 rounded-sm"
                  >
                    {{ size.name }}
                  </span>
                </span>
              </div>
              <div
                v-if="product.types.length"
                class="border-b py-3 bg-gray-50 flex items-center"
              >
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Avaliable Product Types
                </span>
                <span class="w-1/2 block space-x-3">
                  <span
                    v-for="productType in product.types"
                    :key="productType.id"
                    class="px-3 py-1 text-xs font-bold text-white bg-blue-600 rounded-sm"
                  >
                    {{ productType.name }}
                  </span>
                </span>
              </div>
              <div
                v-if="product.colors.length"
                class="bg-white border-b py-3 flex items-center"
              >
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Avaliable Product Colors
                </span>
                <span class="w-1/2 block space-x-3">
                  <span
                    v-for="color in product.colors"
                    :key="color.id"
                    class="px-3 py-1 text-xs font-bold text-white bg-blue-600 rounded-sm"
                  >
                    {{ color.name }}
                  </span>
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
              <div class="bg-white border-b py-3 flex items-center">
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
                <span class="w-1/2 block">
                  $ {{ formattedAmount(product.price) }}
                </span>
              </div>
              <div class="bg-white border-b py-3 flex items-center">
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Product Discount
                </span>
                <span class="w-1/2 block">
                  <span v-if="product.discount">
                    $ {{ formattedAmount(product.discount) }}

                    <DiscountStatus
                      :price="product.price"
                      :discount="product.discount"
                      class="ml-5"
                    />
                  </span>

                  <NoDiscountStatus v-else />
                </span>
              </div>
              <div class="bg-gray-50 border-b py-3 flex items-center">
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
              <div class="bg-gray-50 border-b py-3 flex items-center">
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
                  <PendingStatus v-if="product.status === 'pending'">
                    {{ product.status }}
                  </PendingStatus>

                  <ApprovedStatus v-else>
                    {{ product.status }}
                  </ApprovedStatus>
                </span>
              </div>
              <div class="bg-gray-50 border-b py-3 flex items-center">
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
              <div class="border-b py-3 bg-gray-50 flex items-start">
                <span
                  class="px-10 w-1/2 font-medium text-gray-900 whitespace-nowrap"
                >
                  Product Description
                </span>
                <span v-html="product.description" class="w-1/2 block pr-5">
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </VendorDashboardLayout>
</template>
