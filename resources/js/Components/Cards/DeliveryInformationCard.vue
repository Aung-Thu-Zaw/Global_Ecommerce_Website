<script setup>
defineProps({
  deliveryInformation: Object,
});
</script>

<template>
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
          <div class="py-3 bg-gray-50 flex items-center">
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
</template>
