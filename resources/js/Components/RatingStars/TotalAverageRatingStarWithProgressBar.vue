<script setup>
defineProps({
  oneStarRating: Number,
  twoStarsRating: Number,
  threeStarsRating: Number,
  fourStarsRating: Number,
  fiveStarsRating: Number,
});
</script>

<template>
  <div class="flex items-center mt-4 justify-center">
    <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
      >5 star</span
    >
    <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
      <div
        class="h-5 bg-yellow-400 rounded"
        :style="{ width: `${fiveStarsRating}%` }"
      ></div>
    </div>
    <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
      >{{ fiveStarsRating }}%</span
    >
  </div>
  <div class="flex items-center mt-4 justify-center">
    <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
      >4 star</span
    >
    <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
      <div
        class="h-5 bg-yellow-400 rounded"
        :style="{ width: `${fourStarsRating}%` }"
      ></div>
    </div>
    <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
      >{{ fourStarsRating }}%</span
    >
  </div>
  <div class="flex items-center mt-4 justify-center">
    <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
      >3 star</span
    >
    <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
      <div
        class="h-5 bg-yellow-400 rounded"
        :style="{ width: `${threeStarsRating}%` }"
      ></div>
    </div>
    <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
      >{{ threeStarsRating }}%</span
    >
  </div>
  <div class="flex items-center mt-4 justify-center">
    <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
      >2 star</span
    >
    <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
      <div
        class="h-5 bg-yellow-400 rounded"
        :style="{ width: `${twoStarsRating}%` }"
      ></div>
    </div>
    <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
      >{{ twoStarsRating }}%</span
    >
  </div>
  <div class="flex items-center mt-4 justify-center">
    <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
      >1 star</span
    >
    <div class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700">
      <div
        class="h-5 bg-yellow-400 rounded"
        :style="{ width: `${oneStarRating}%` }"
      ></div>
    </div>
    <span class="text-sm font-medium text-blue-600 dark:text-blue-500"
      >{{ oneStarRating }}%</span
    >
  </div>
</template>



