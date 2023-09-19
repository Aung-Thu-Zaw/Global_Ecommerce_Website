<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/OrderManageBreadcrumb.vue";
import OrderDetailCard from "@/Components/Cards/OrderDetailCard.vue";
import DeliveryInformationCard from "@/Components/Cards/DeliveryInformationCard.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import { Head } from "@inertiajs/vue3";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  deliveryInformation: Object,
  order: Object,
  orderItems: Object,
});
</script>


<template>
  <AdminDashboardLayout>
    <Head title="Details Delivered Order" />

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
                {{ __("DELIVERED_ORDERS") }}
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
              >
                {{ order.invoice_no }}
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
                >{{ __("DETAILS") }}</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back button -->

        <div>
          <GoBackButton
            href="admin.orders.delivered.index"
            :queryStringParams="queryStringParams"
          />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3 my-5">
        <!-- Delivery Information Detail  -->
        <DeliveryInformationCard :deliveryInformation="deliveryInformation" />

        <div class="p-5 border shadow-md rounded-sm">
          <!-- Order Detail  -->
          <OrderDetailCard
            :deliveryInformation="deliveryInformation"
            :order="order"
          >
            <div
              v-if="order.confirmed_date"
              class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
            >
              <span
                class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
              >
                Order Confirmed Date
              </span>
              <span class="w-full block">
                {{ order.confirmed_date }}
              </span>
            </div>
            <div
              v-if="order.processing_date"
              class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
            >
              <span
                class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
              >
                Order Processing Date
              </span>
              <span class="w-full block">
                {{ order.processing_date }}
              </span>
            </div>
            <div
              v-if="order.shipped_date"
              class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
            >
              <span
                class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
              >
                Order Shipped Date
              </span>
              <span class="w-full block">
                {{ order.shipped_date }}
              </span>
            </div>
            <div
              class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
              v-if="order.delivered_date"
            >
              <span
                class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
              >
                Order Delivered Date
              </span>
              <span class="w-full block">
                {{ order.delivered_date }}
              </span>
            </div>
          </OrderDetailCard>
        </div>
      </div>

      <!-- Order Item Products  -->
      <div class="border shadow rounded-sm">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <table
            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
          >
            <thead
              class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th scope="col" class="px-6 py-3">Shop Name</th>
                <th scope="col" class="px-6 py-3">Product Image</th>
                <th scope="col" class="px-6 py-3">Product Name</th>
                <th scope="col" class="px-6 py-3">Product Code</th>
                <th scope="col" class="px-6 py-3">Color</th>
                <th scope="col" class="px-6 py-3">Size</th>
                <th scope="col" class="px-6 py-3">Price</th>
                <th scope="col" class="px-6 py-3">Quantity</th>
                <th scope="col" class="px-6 py-3">Total Prize</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="orderItem in orderItems"
                :key="orderItem.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
              >
                <th
                  scope="row"
                  class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                >
                  {{ orderItem.product.shop.shop_name }}
                </th>

                <td class="px-6 py-4">
                  <img
                    :src="orderItem.product.image"
                    alt=""
                    class="h-14 object-cover"
                  />
                </td>

                <td class="px-6 py-4">
                  {{ orderItem.product.name }}
                </td>

                <td class="px-6 py-4">
                  {{ orderItem.product.code }}
                </td>

                <td class="px-6 py-4">
                  {{ orderItem.color }}
                </td>

                <td class="px-6 py-4">
                  {{ orderItem.size }}
                </td>

                <td class="px-6 py-4">
                  <span v-if="orderItem.product.discount">
                    $ {{ orderItem.product.discount }}
                  </span>
                  <span v-else> $ {{ orderItem.product.price }} </span>
                </td>

                <td class="px-6 py-4">
                  {{ orderItem.qty }}
                </td>

                <td class="px-6 py-4">$ {{ orderItem.price }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminDashboardLayout>
</template>

