<script setup>
import { computed } from "vue";

const props = defineProps({
  price: String,
  discount: String,
});

const formattedDiscount = computed(() => {
  const price = parseFloat(props.price);
  const discount = parseFloat(props.discount);

  if (Number.isInteger(price) && Number.isInteger(discount)) {
    return (((price - discount) / price) * 100).toFixed(0);
  } else {
    return (((price - discount) / price) * 100).toFixed(1);
  }
});
</script>

<template>
  <span
    v-if="discount"
    class="bg-green-200 text-green-600 py-1 px-3 rounded-full"
  >
    {{ formattedDiscount }}%
  </span>
</template>
