<script setup>
import ConfirmedStatus from "@/Components/Status/ConfirmedStatus.vue";
import ShippedStatus from "@/Components/Status/ShippedStatus.vue";
import DeliveredStatus from "@/Components/Status/DeliveredStatus.vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import ProcessingStatus from "@/Components/Status/ProcessingStatus.vue";

defineProps({
  deliveryInformation: Object,
  order: Object,
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
  <div>
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
            <span class="w-full block">
              $ {{ formattedAmount(order.total_amount) }}
            </span>
          </div>

          <div class="border-b py-3 bg-gray-50 flex items-center">
            <span
              class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
            >
              Transaction Id
            </span>
            <span v-if="order.transaction_id" class="w-full block">
              {{ order.transaction_id }}
            </span>
            <span v-else class="w-full block">
              Transition does not exist.
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

          <slot />

          <div class="py-3 bg-gray-50 flex items-center">
            <span
              class="px-10 w-[350px] font-medium text-gray-900 whitespace-nowrap"
            >
              Order Status
            </span>
            <span class="w-full block">
              <PendingStatus v-if="order.order_status === 'pending'">
                {{ order.order_status }}
              </PendingStatus>
              <ConfirmedStatus v-if="order.order_status === 'confirmed'">
                {{ order.order_status }}
              </ConfirmedStatus>
              <ProcessingStatus v-if="order.order_status === 'processing'">
                {{ order.order_status }}
              </ProcessingStatus>
              <ShippedStatus v-if="order.order_status === 'shipped'">
                {{ order.order_status }}
              </ShippedStatus>
              <DeliveredStatus v-if="order.order_status === 'delivered'">
                {{ order.order_status }}
              </DeliveredStatus>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
