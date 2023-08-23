<script setup>
defineProps({
  type: {
    type: String,
    default: "submit",
  },
});
</script>

<template>
  <button
    :type="type"
    class="font-semibold text-sm px-5 py-3 rounded-md bg-red-600 text-white hover:bg-red-700 shadow transition-all"
  >
    <slot />
  </button>
</template>
