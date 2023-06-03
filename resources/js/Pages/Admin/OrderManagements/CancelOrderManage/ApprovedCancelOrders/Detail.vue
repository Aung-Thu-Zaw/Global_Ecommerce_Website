<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/CancelOrderManageBreadcrumb.vue";
import ConfirmedStatus from "@/Components/Table/ConfirmedStatus.vue";
import ApprovedStatus from "@/Components/Table/ApprovedStatus.vue";
import ProcessingStatus from "@/Components/Table/ProcessingStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
  paginate: Object,
  deliveryInformation: Object,
  approvedCancelOrderDetail: Object,
  orderItems: Object,
});
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Details Approved Return Order" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
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
                >Approved Return
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
        <div>
          <Link
            as="button"
            :href="route('admin.cancel-orders.approved.index')"
            :data="{
              page: props.paginate.page,
              per_page: props.paginate.per_page,
            }"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-3 my-5">
        <div class="p-5 border shadow-md rounded-sm">
          <h1 class="font-bold text-slate-700 text-2xl border-b-4 px-10 py-3">
            Delivery Information
          </h1>
          <div v-if="deliveryInformation" class="my-5">
            <div
              class="w-full text-sm text-left text-gray-500 border overflow-hidden shadow rounded-md"
            >
              <div>
                <div
                  class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
                >
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Name
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.name }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Email
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.email }}
                  </span>
                </div>
                <div
                  class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
                >
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Phone
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.phone }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Address
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.address }}
                  </span>
                </div>
                <div
                  class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
                >
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Country
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.country }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Region
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.region }}
                  </span>
                </div>
                <div
                  class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
                >
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    City
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.city }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Township
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.township }}
                  </span>
                </div>
                <div
                  class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
                >
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Postal Code
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.postal_code }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Additional Information
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.additional_information }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="p-5 border shadow-md rounded-sm">
          <h1 class="font-bold text-slate-700 text-2xl border-b-4 px-10 py-3">
            Order Details
          </h1>
          <div
            v-if="deliveryInformation && approvedCancelOrderDetail"
            class="my-5"
          >
            <div
              class="w-full text-sm text-left text-gray-500 border overflow-hidden shadow rounded-md"
            >
              <div>
                <div
                  class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
                >
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Name
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.name }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Phone
                  </span>
                  <span class="w-full block">
                    {{ deliveryInformation.phone }}
                  </span>
                </div>
                <div
                  class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
                >
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Invoice No
                  </span>
                  <span class="w-full text-orange-600 block">
                    {{ approvedCancelOrderDetail.invoice_no }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Order No
                  </span>
                  <span class="w-full text-orange-600 block">
                    {{ approvedCancelOrderDetail.order_no }}
                  </span>
                </div>
                <div
                  class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
                >
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Currency
                  </span>
                  <span class="w-full block uppercase">
                    {{ approvedCancelOrderDetail.currency }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Payment Type
                  </span>
                  <span class="w-full block capitalize">
                    {{ approvedCancelOrderDetail.payment_type }}
                  </span>
                </div>
                <div
                  class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
                >
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Total Amount
                  </span>
                  <span class="w-full block">
                    $ {{ approvedCancelOrderDetail.total_amount }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Transaction Id
                  </span>
                  <span class="w-full block">
                    {{ approvedCancelOrderDetail.transaction_id }}
                  </span>
                </div>
                <div
                  class="bg-white border-b py-3 dark:bg-gray-900 flex items-center"
                >
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Order Date
                  </span>
                  <span class="w-full block">
                    {{ approvedCancelOrderDetail.order_date }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Order Status
                  </span>
                  <span class="w-full block">
                    <PendingStatus
                      v-if="
                        approvedCancelOrderDetail.order_status === 'pending'
                      "
                    >
                      {{ approvedCancelOrderDetail.order_status }}
                    </PendingStatus>
                    <ConfirmedStatus
                      v-if="
                        approvedCancelOrderDetail.order_status === 'confirmed'
                      "
                    >
                      {{ approvedCancelOrderDetail.order_status }}
                    </ConfirmedStatus>
                    <ProcessingStatus
                      v-if="
                        approvedCancelOrderDetail.order_status === 'processing'
                      "
                    >
                      {{ approvedCancelOrderDetail.order_status }}
                    </ProcessingStatus>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="p-5 my-5 border shadow-md rounded-sm">
        <h1 class="font-bold text-slate-700 text-2xl border-b-4 px-10 py-3">
          Cancel Order Request Details
        </h1>
        <div v-if="approvedCancelOrderDetail.cancel_reason" class="my-5">
          <div
            class="w-full text-sm text-left text-gray-500 border overflow-hidden shadow rounded-md"
          >
            <div>
              <div class="border-b py-3 bg-gray-50 flex items-center">
                <span
                  class="px-10 w-full font-medium text-gray-900 whitespace-nowrap"
                >
                  Return Reason
                </span>
                <span class="w-full block">
                  {{ approvedCancelOrderDetail.cancel_reason }}
                </span>
              </div>
            </div>
            <div>
              <div class="border-b py-3 bg-gray-50 flex items-center">
                <span
                  class="px-10 w-full font-medium text-gray-900 whitespace-nowrap"
                >
                  Cancel Request Date
                </span>
                <span class="w-full block">
                  {{ approvedCancelOrderDetail.cancel_date }}
                </span>
              </div>
            </div>
            <div>
              <div class="border-b py-3 bg-gray-50 flex items-center">
                <span
                  class="px-10 w-full font-medium text-gray-900 whitespace-nowrap"
                >
                  Cancel Approved Date
                </span>
                <span class="w-full block">
                  {{ approvedCancelOrderDetail.cancel_approved_date }}
                </span>
              </div>
            </div>
            <div>
              <div class="border-b py-3 bg-gray-50 flex items-center">
                <span
                  class="px-10 w-full font-medium text-gray-900 whitespace-nowrap"
                >
                  Cancel Status
                </span>
                <span
                  v-if="approvedCancelOrderDetail.cancel_status === 'approved'"
                  class="w-full block"
                >
                  <ApprovedStatus>
                    {{ approvedCancelOrderDetail.cancel_status }}
                  </ApprovedStatus>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
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
                <td class="px-6 py-4">{{ orderItem.product.name }}</td>
                <td class="px-6 py-4">{{ orderItem.product.code }}</td>
                <td class="px-6 py-4">{{ orderItem.color }}</td>
                <td class="px-6 py-4">{{ orderItem.size }}</td>
                <td class="px-6 py-4">
                  <span v-if="orderItem.product.discount">
                    $ {{ orderItem.product.discount }}
                  </span>
                  <span v-else> $ {{ orderItem.product.price }} </span>
                </td>
                <td class="px-6 py-4">{{ orderItem.qty }}</td>
                <td class="px-6 py-4">$ {{ orderItem.price }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
