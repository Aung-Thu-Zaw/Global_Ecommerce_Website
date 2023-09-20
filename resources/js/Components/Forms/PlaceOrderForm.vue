<script setup>
import { computed, ref } from "vue";
import { useForm, Head, Link } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  cartItems: Object,
  deliveryInformation: Object,
  coupon: Object,
  product: Object,
  quantity: Object,
});

const totalPrice = computed(() =>
  props.product
    ? props.product.discount
      ? props.quantity * parseFloat(props.product.discount)
      : props.quantity * parseFloat(props.product.price)
    : props.cartItems.reduce((total, item) => {
        return item.product.discount
          ? total + item.qty * parseFloat(item.product.discount)
          : total + item.qty * parseFloat(item.product.price);
      }, 0)
);

const totalPriceWithCoupon = computed(
  () => totalPrice.value - props.coupon.discount_amount
);

const form = useForm({
  total_price: ref(
    props.coupon ? totalPriceWithCoupon.value : totalPrice.value
  ),
  cart_items: ref(
    props.product && props.quantity ? props.quantity : props.cartItems
  ),
  payment_method: ref("creditOrDebitCard"),
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handlePlaceOrder = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("place_order");
  form.post(route("payment"));
};
</script>

<template>
  <!-- Order Summary -->
  <article
    class="border border-gray-200 bg-white shadow-sm rounded mb-5 p-3 lg:p-5"
  >
    <h2 class="text-center mb-5 font-bold text-2xl text-slate-800">
      {{ __("ORDER_SUMMARY") }}
    </h2>
    <ul class="mb-5">
      <li class="flex justify-between text-gray-600 mb-1">
        <span> {{ __("TOTAL_ITEMS") }} :</span>
        <span>{{ quantity ? quantity : totalItems }} {{ __("ITEMS") }} </span>
      </li>

      <li class="flex justify-between text-gray-600 mb-1">
        <span> {{ __("TOTAL_PRICE") }} :</span>
        <span>${{ totalPrice }}</span>
      </li>

      <div v-if="coupon">
        <li class="flex justify-between text-gray-600 mb-1">
          <span> {{ __("COUPON_CODE") }} :</span>
          <span class="text-yellow-600 text-sm font-bold">
            {{ coupon.code }}
          </span>
        </li>
        <li class="flex justify-between text-gray-600 mb-1">
          <span> {{ __("COUPON_DISCOUNT") }} :</span>
          <span class="text-gray-600 text-sm font-bold">
            - ${{ coupon.discount_amount }}
          </span>
        </li>
      </div>

      <li class="text-lg font-bold border-t flex justify-between mt-3 pt-3">
        <span> {{ __("TOTAL_PRICE") }} :</span>
        <span v-if="totalPriceWithCoupon"> ${{ totalPriceWithCoupon }} </span>
        <span v-else>${{ totalPrice }}</span>
      </li>
    </ul>
    <form @submit.prevent="handlePlaceOrder">
      <div class="my-10">
        <h1 class="font-bold text-lg text-slate-700">
          {{ __("SELECT_PAYMENT_METHODS") }}
        </h1>

        <input type="hidden" v-model="form.total_price" />
        <input type="hidden" v-model="form.cart_items" />
        <div class="my-5">
          <div class="flex items-center mr-4 mb-3">
            <input
              id="blue-radio-1"
              type="radio"
              name="colored-radio"
              class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              value="creditOrDebitCard"
              v-model="form.payment_method"
            />
            <label
              for="blue-radio-1"
              class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300"
            >
              <i class="fa-solid fa-credit-card"></i>
              Credit/Debit Card
            </label>
          </div>

          <div class="flex items-center mr-4 mb-3">
            <input
              id="blue-radio-2"
              type="radio"
              name="colored-radio"
              class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              value="paypal"
              v-model="form.payment_method"
            />
            <label
              for="blue-radio-2"
              class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300"
            >
              <i class="fa-brands fa-paypal"></i>
              Paypal
            </label>
          </div>

          <div class="flex items-center mr-4 mb-3">
            <input
              id="blue-radio-3"
              type="radio"
              name="colored-radio"
              class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              value="cashOnDelivery"
              v-model="form.payment_method"
            />
            <label
              for="blue-radio-3"
              class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300"
            >
              <i class="fa-solid fa-money-bill"></i>

              Cash on Delivery
            </label>
          </div>
        </div>
      </div>
      <button
        type="submit"
        class="px-4 py-3 mb-2 inline-block text-md w-full text-center font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 uppercase"
        :disabled="!deliveryInformation"
      >
        <i class="fa-solid fa-bag-shopping"></i>
        {{ __("PLACE_ORDER") }}
      </button>
    </form>
  </article>
</template>
