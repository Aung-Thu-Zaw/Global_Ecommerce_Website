<script setup>
import { computed } from "vue";

const props = defineProps({
  cartItems: Object,
  coupon: Object,
});

// Calculate Total Items
const totalItems = computed(() => {
  return props.cartItems.reduce((total, item) => total + item.qty, 0);
});

// Calculate Total Product Price
const totalPrice = computed(() =>
  props.cartItems.reduce((total, item) => {
    return item.product.discount
      ? total + item.qty * parseFloat(item.product.discount)
      : total + item.qty * parseFloat(item.product.price);
  }, 0)
);

// Calculate Total Product Price With Coupon
const totalPriceWithCoupon = computed(() => {
  if (props.coupon.discount_type === "fixed_amount") {
    return totalPrice.value - props.coupon.discount_amount;
  } else if (props.coupon.discount_type === "percentage") {
    const discountAmount =
      (totalPrice.value * props.coupon.discount_amount) / 100;

    return totalPrice.value - discountAmount;
  }
});

// Handle Remove Coupon
const removeCoupon = () => {
  router.get(
    route("coupon.remove"),
    {},
    {
      preserveScroll: true,
      onSuccess: () => {
        if (usePage().props.flash.successMessage) {
          toast.success(usePage().props.flash.successMessage, {
            autoClose: 2000,
          });
        }
      },
    }
  );
};
</script>

<template>
  <article
    class="border border-gray-200 bg-white shadow-sm rounded mb-5 p-3 lg:p-5"
  >
    <h2 class="text-center mb-5 font-bold text-2xl text-slate-800">
      Order Summary
    </h2>
    <ul class="mb-5">
      <li class="flex justify-between text-gray-600 mb-1">
        <span>Total Items:</span>
        <span>{{ totalItems }} Items</span>
      </li>

      <li class="flex justify-between text-gray-600 mb-1">
        <span>Total price:</span>
        <span>${{ totalPrice }}</span>
      </li>

      <div v-if="coupon">
        <li class="flex justify-between text-gray-600 mb-1">
          <span>Coupon Code:</span>
          <span class="text-yellow-600 text-sm font-bold">
            {{ coupon.code }}
            <i
              class="fas fa-xmark text-slate-600 cursor-pointer hover:text-red-600"
              @click="removeCoupon"
            ></i>
          </span>
        </li>
        <li class="flex justify-between text-gray-600 mb-1">
          <span>Coupon Discount:</span>
          <span
            v-if="coupon.discount_type === 'fixed_amount'"
            class="text-gray-600 text-sm font-bold"
          >
            - $ {{ coupon.discount_amount }}
          </span>
          <span
            v-else-if="coupon.discount_type === 'percentage'"
            class="text-gray-600 text-sm font-bold"
          >
            - % {{ coupon.discount_amount }}
          </span>
        </li>
      </div>

      <li class="text-lg font-bold border-t flex justify-between mt-3 pt-3">
        <span>Total price:</span>
        <span v-if="totalPriceWithCoupon"> ${{ totalPriceWithCoupon }} </span>
        <span v-else>${{ totalPrice }}</span>
      </li>
    </ul>

    <Link
      as="button"
      class="px-4 py-3 mb-2 inline-block text-sm w-full text-center font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 uppercase cursor-pointer"
      :href="route('checkout.index')"
    >
      <i class="fa-solid fa-right-from-bracket"></i>
      Proceed To Checkout
    </Link>

    <Link
      as="button"
      class="px-4 py-3 inline-block text-sm w-full text-center font-medium text-blue-600 bg-white shadow-sm border border-gray-200 rounded-md hover:bg-gray-100 uppercase cursor-pointer"
      :href="route('home')"
    >
      <i class="fa-solid fa-shop"></i>
      Back to shop
    </Link>
  </article>
</template>

