<script setup>
defineProps({
  disabled: {
    type: Boolean,
    default: false,
  },
  processing: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <button
    type="submit"
    class="w-full bg-orange-600 text-white ring-2 ring-orange-300 hover:bg-orange-700 capitalize font-semibold focus:ring-2 focus:ring-orange-200"
    :disabled="disabled"
  >
    <div v-if="processing" class="flex items-center">
      <span class="loading loading-infinity loading-sm"></span>
      <span>Processing...</span>
    </div>
    <div v-else>
      <slot />
    </div>
  </button>
</template>
