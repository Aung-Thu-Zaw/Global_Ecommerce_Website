<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/ReturnOrderManageBreadcrumb.vue";
import OrderDetailCard from "@/Components/Cards/OrderDetailCard.vue";
import ReturnOrderDetailCard from "@/Components/Cards/ReturnOrderDetailCard.vue";
import DeliveryInformationCard from "@/Components/Cards/DeliveryInformationCard.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, usePage, Head } from "@inertiajs/vue3";
import { computed, inject, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

// Define the props
const props = defineProps({
  queryStringParams: Array,
  deliveryInformation: Object,
  order: Object,
  orderItems: Object,
});

// Define Variables
const processing = ref(false);
const swal = inject("$swal");

const handleRefundOrder = async (id) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to refund this return order?",
    showCancelButton: true,
    confirmButtonText: "Yes, Refund!",
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });
  if (result.isConfirmed) {
    router.post(
      route("admin.return-orders.approved.update", {
        order: props.order.id,
        page: props.queryStringParams.page,
        per_page: props.queryStringParams.per_page,
        sort: props.queryStringParams.sort,
        direction: props.queryStringParams.direction,
      }),
      {},
      {
        preserveScroll: true,
        onFinish: () => {
          processing.value = false;
        },
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            toast.success(usePage().props.flash.successMessage, {
              autoClose: 2000,
            });
          }
        },
      }
    );
  }
};

// Return Order Control Permission
const returnOrderManageControl = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "return-order-manage.control"
      )
    : false;
});
</script>


<template>
  <AdminDashboardLayout>
    <Head title="Details Approved Return Order" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcurmb -->
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

        <!-- Go Back button -->
        <div>
          <Link
            as="button"
            :href="route('admin.return-orders.approved.index')"
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

      <div class="grid grid-cols-2 gap-3 my-5">
        <!-- Delivery Information Detail  -->
        <DeliveryInformationCard :deliveryInformation="deliveryInformation" />

        <div class="p-5 border shadow-md rounded-sm">
          <!-- Order Detail  -->
          <OrderDetailCard
            :deliveryInformation="deliveryInformation"
            :order="order"
          />
        </div>
      </div>

      <div class="p-5 my-5 border shadow-md rounded-sm">
        <!-- Return Order Detail -->
        <ReturnOrderDetailCard :order="order">
          <div v-if="order.return_approved_date">
            <div class="border-b py-3 bg-white flex items-center">
              <span
                class="px-10 w-full font-medium text-gray-900 whitespace-nowrap"
              >
                Return Approved Date
              </span>
              <span class="w-full block">
                {{ order.return_approved_date }}
              </span>
            </div>
          </div>
        </ReturnOrderDetailCard>

        <!-- Approve Button -->
        <button
          @click="handleRefundOrder(order.id)"
          v-if="order.return_status === 'approved' && returnOrderManageControl"
          class="bg-slate-600 py-3 w-full rounded-sm font-bold text-white hover:bg-slate-700 transition-all shadow"
        >
          <svg
            v-if="processing"
            aria-hidden="true"
            role="status"
            class="inline w-4 h-4 mr-3 text-white animate-spin"
            viewBox="0 0 100 101"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
              fill="#E5E7EB"
            />
            <path
              d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
              fill="currentColor"
            />
          </svg>
          {{ processing ? "Processing..." : "Refund Return" }}
        </button>
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
