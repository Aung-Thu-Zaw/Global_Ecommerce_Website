<script setup>
import RequestedStatus from "@/Components/Status/RequestedStatus.vue";
import ConfirmedStatus from "@/Components/Status/ConfirmedStatus.vue";

// Define the props
const props = defineProps({
  order: Object,
});
</script>


<template>
  <h1 class="font-bold text-slate-700 text-2xl border-b-4 px-10 py-3">
    Cancel Order Request Details
  </h1>
  <div v-if="order.cancel_reason" class="my-5">
    <div
      class="w-full text-sm text-left text-gray-500 border overflow-hidden shadow rounded-md"
    >
      <div>
        <div class="border-b py-3 bg-gray-50 flex items-center">
          <span
            class="px-10 w-full font-medium text-gray-900 whitespace-nowrap"
          >
            Cancel Reason
          </span>
          <span class="w-full block">
            {{ order.cancel_reason }}
          </span>
        </div>
      </div>
      <div>
        <div class="border-b py-3 bg-white flex items-center">
          <span
            class="px-10 w-full font-medium text-gray-900 whitespace-nowrap"
          >
            Cancel Status
          </span>
          <span v-if="order.cancel_status === 'requested'" class="w-full block">
            <RequestedStatus>
              {{ order.cancel_status }}
            </RequestedStatus>
          </span>
          <span
            v-else-if="order.cancel_status === 'approved'"
            class="w-full block"
          >
            <ConfirmedStatus>
              {{ order.cancel_status }}
            </ConfirmedStatus>
          </span>
        </div>
      </div>
      <div>
        <div class="border-b py-3 bg-gray-50 flex items-center">
          <span
            class="px-10 w-full font-medium text-gray-900 whitespace-nowrap"
          >
            Cancel Requested Date
          </span>
          <span class="w-full block">
            {{ order.cancel_date }}
          </span>
        </div>
      </div>

      <slot />
    </div>
  </div>
</template>

