<script setup>
import RequestedStatus from "@/Components/Status/RequestedStatus.vue";
import ConfirmedStatus from "@/Components/Status/ConfirmedStatus.vue";
import RefundedStatus from "@/Components/Status/RefundedStatus.vue";

// Define the props
const props = defineProps({
  order: Object,
});
</script>


<template>
  <h1 class="font-bold text-slate-700 text-2xl border-b-4 px-10 py-3">
    Return Order Request Details
  </h1>
  <div v-if="order.return_reason" class="my-5">
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
            {{ order.return_reason }}
          </span>
        </div>
      </div>
      <div>
        <div class="border-b py-3 bg-white flex items-center">
          <span
            class="px-10 w-full font-medium text-gray-900 whitespace-nowrap"
          >
            Return Status
          </span>
          <span v-if="order.return_status === 'requested'" class="w-full block">
            <RequestedStatus>
              {{ order.return_status }}
            </RequestedStatus>
          </span>
          <span
            v-else-if="order.return_status === 'approved'"
            class="w-full block"
          >
            <ConfirmedStatus>
              {{ order.return_status }}
            </ConfirmedStatus>
          </span>
          <span
            v-else-if="order.return_status === 'refunded'"
            class="w-full block"
          >
            <RefundedStatus>
              {{ order.return_status }}
            </RefundedStatus>
          </span>
        </div>
      </div>
      <div>
        <div class="border-b py-3 bg-gray-50 flex items-center">
          <span
            class="px-10 w-full font-medium text-gray-900 whitespace-nowrap"
          >
            Return Requested Date
          </span>
          <span class="w-full block">
            {{ order.return_date }}
          </span>
        </div>
      </div>

      <slot />
    </div>
  </div>
</template>

