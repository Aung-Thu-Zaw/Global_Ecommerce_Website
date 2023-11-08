<script setup>
import { useFormatFunctions } from "@/Composables/useFormatFunctions";

defineProps({
  options: {
    type: [Array, Object],
    required: true,
  },
});

const { formatToTitleCase } = useFormatFunctions();
</script>

<template>
  <div v-show="options.length !== 0" class="my-5 flex items-center space-x-3">
    <div class="font-semibold text-sm text-gray-600">
      <span>{{ __("Filtered By") }} :</span>
    </div>
    <div class="space-x-3">
      <div
        v-for="(option, index) in options"
        :key="index"
        class="inline-flex flex-nowrap items-center bg-white border border-gray-300 rounded-md py-1.5 px-3 space-x-2"
      >
        <div class="whitespace-nowrap text-xs font-medium text-gray-600">
          {{ formatToTitleCase(option) }}
        </div>
        <div
          class="ms-2.5 inline-flex justify-center items-center text-xs font-bold text-gray-500 hover:text-red-600 transition-all cursor-pointer"
        >
          <i class="fa-solid fa-circle-xmark"></i>
        </div>
      </div>
    </div>
  </div>
</template>
