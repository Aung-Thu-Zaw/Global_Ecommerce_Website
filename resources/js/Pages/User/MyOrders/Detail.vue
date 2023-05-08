<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";
import OrderCartItem from "@/Components/OrderCartItem.vue";
import Stepper from "@/Components/Stepper.vue";
import { inject } from "vue";
import PendingStatus from "@/Components/Table/PendingStatus.vue";
import ConfirmedStatus from "@/Components/Table/ConfirmedStatus.vue";
import ProcessingStatus from "@/Components/Table/ProcessingStatus.vue";
import ShippedStatus from "@/Components/Table/ShippedStatus.vue";
import DeliveredStatus from "@/Components/Table/DeliveredStatus.vue";

const props = defineProps({
  order: Object,
  orderItems: Object,
  deliveryInformation: Object,
  shops: Object,
});

const swal = inject("$swal");
</script>

<template>
  <Head title="Detail Order" />

  <AppLayout>
    <div
      class="container mx-auto mt-48 mb-10 flex flex-col items-center min-h-[500px] w-full p-5"
    >
      <h1 class="font-bold text-2xl text-slate-600 uppercase mb-5 self-start">
        Order Details
      </h1>

      <div
        class="bg-gray-50 px-5 py-3 rounded-sm w-full border shadow flex items-center justify-between"
      >
        <div>
          <h3 class="font-bold text-sm text-slate-700">
            Order No : {{ order.order_no }}
          </h3>
          <span class="text-[.8rem] font-bold text-slate-500">
            Placed On {{ order.created_at }}
          </span>
        </div>
        <div class="font-bold text-md text-slate-700">
          Total: $ {{ order.total_amount }}
        </div>
      </div>

      <!-- Stepper  -->
      <Stepper :order="order" />

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
          <div v-if="deliveryInformation && order" class="my-5">
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
                    {{ order.invoice_no }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Order No
                  </span>
                  <span class="w-full text-orange-600 block">
                    {{ order.order_no }}
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
                    {{ order.currency }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Payment Type
                  </span>
                  <span class="w-full block capitalize">
                    {{ order.payment_type }}
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
                  <span class="w-full block"> $ {{ order.total_amount }} </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Transaction Id
                  </span>
                  <span class="w-full block">
                    {{ order.transaction_id }}
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
                    {{ order.order_date }}
                  </span>
                </div>
                <div class="border-b py-3 bg-gray-50 flex items-center">
                  <span
                    class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
                  >
                    Order Status
                  </span>
                  <span class="w-full block">
                    <PendingStatus v-if="order.status === 'pending'">
                      {{ order.status }}
                    </PendingStatus>
                    <ConfirmedStatus v-else-if="order.status === 'confirm'">
                      {{ order.status }}
                    </ConfirmedStatus>
                    <ProcessingStatus v-else-if="order.status === 'processing'">
                      {{ order.status }}
                    </ProcessingStatus>
                    <ShippedStatus v-else-if="order.status === 'shipped'">
                      {{ order.status }}
                    </ShippedStatus>
                    <DeliveredStatus v-else-if="order.status === 'delivered'">
                      {{ order.status }}
                    </DeliveredStatus>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <article
        v-for="(shop, index) in shops"
        :key="index"
        class="border border-gray-200 bg-white shadow-sm rounded mb-5 w-full my-3"
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

        <div v-for="item in orderItems" :key="item.id" class="w-full my-3">
          <div v-if="item.vendor_id === shop.id">
            <OrderCartItem :item="item" />
          </div>
        </div>
      </article>
    </div>
  </AppLayout>
</template>
