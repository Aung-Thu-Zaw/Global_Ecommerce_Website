<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DeliveryInformationForm from "@/Components/DeliveryInformationForm.vue";
import CheckoutShoppingCartItem from "@/Components/CheckoutShoppingCartItem.vue";
import { computed, ref } from "vue";
import { Link, router, useForm, Head } from "@inertiajs/vue3";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  shops: Object,
  cartItems: Object,
  countries: Object,
  regions: Object,
  cities: Object,
  townships: Object,
  deliveryInformation: Object,
  coupon: Object,
});

const totalItems = computed(() => {
  return props.cartItems.reduce((total, item) => total + item.qty, 0);
});

const totalPrice = computed(() =>
  props.cartItems.reduce((total, item) => {
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
  cart_items: ref(props.cartItems),
  payment_method: ref("creditOrDebitCard"),
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handlePlaceOrder = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("place_order");
  submit();
};

const submit = () => {
  form.post(route("payment"));
};
</script>

<template>
  <AppLayout>
    <Head title="Global E-commerce : Global Online Shopping" />
    <section class="py-10 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <h1 class="font-semibold text-xl text-slate-700 mb-5">
          <i class="fa-solid fa-file-lines"></i>
          Delivery Information
        </h1>

        <div class="flex flex-col md:flex-row gap-4">
          <main class="md:w-3/5">
            <DeliveryInformationForm
              :countries="countries"
              :regions="regions"
              :cities="cities"
              :townships="townships"
              :deliveryInformation="deliveryInformation"
            />

            <article
              v-for="(shop, index) in shops"
              :key="index"
              class="border border-gray-200 bg-white shadow-sm rounded mb-5"
            >
              <div
                class="border-b flex items-center justify-between px-3 py-2 lg:px-5 font-bold text-slate-600 text-md"
              >
                <span>
                  <i class="fas fa-box"></i>
                  Package {{ index + 1 }}
                </span>
                <span class="text-sm text-slate-500">
                  Shipped By
                  <span class="text-slate-700">{{ shop.shop_name }}</span>
                </span>
              </div>

              <!-- item-cart -->
              <div v-for="item in cartItems" :key="item.id">
                <div v-if="item.shop_id == shop.id">
                  <CheckoutShoppingCartItem :item="item" />
                </div>
              </div>

              <hr />
            </article>
          </main>

          <aside class="md:w-1/3">
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
                    </span>
                  </li>
                  <li class="flex justify-between text-gray-600 mb-1">
                    <span>Coupon Discount:</span>
                    <span class="text-gray-600 text-sm font-bold">
                      - ${{ coupon.discount_amount }}
                    </span>
                  </li>
                </div>

                <li
                  class="text-lg font-bold border-t flex justify-between mt-3 pt-3"
                >
                  <span>Total price:</span>
                  <span v-if="totalPriceWithCoupon">
                    ${{ totalPriceWithCoupon }}
                  </span>
                  <span v-else>${{ totalPrice }}</span>
                </li>
              </ul>

              <form @submit.prevent="handlePlaceOrder">
                <div class="my-10">
                  <h1 class="font-bold text-lg text-slate-700">
                    Select Payment Methods
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
                  Place Order
                </button>
              </form>
            </article>
          </aside>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
