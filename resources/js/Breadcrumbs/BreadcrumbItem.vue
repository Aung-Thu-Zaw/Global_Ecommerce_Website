<script setup>
defineProps({
  name: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <li>
    <div class="flex items-center">
      <i class="fa-solid fa-angle-right text-gray-400"></i>
      <div
        class="ml-1 text-sm font-semibold text-blueGray-600 hover:text-blueGray-700 md:ml-2"
      >
        {{ name }}
      </div>
    </div>
  </li>
</template>
