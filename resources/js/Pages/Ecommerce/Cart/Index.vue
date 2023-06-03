<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ShoppingCartItem from "@/Components/Items/ShoppingCartItem.vue";
import { Link, router, usePage, Head } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  shops: Object,
  cartItems: Object,
  coupon: Object,
});

const coupon_code = ref(props.coupon ? props.coupon.code : "");

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

const totalPriceWithCoupon = computed(() => {
  if (props.coupon.discount_type === "fixed_amount") {
    return totalPrice.value - props.coupon.discount_amount;
  } else if (props.coupon.discount_type === "percentage") {
    const discountAmount =
      (totalPrice.value * props.coupon.discount_amount) / 100;

    return totalPrice.value - discountAmount;
  }
});

const applyCoupon = () => {
  router.post(
    route("coupon.apply", {
      code: coupon_code.value,
      total_price: totalPrice.value,
    }),
    {},
    {
      preserveScroll: true,
      onSuccess: () => {
        if (usePage().props.flash.successMessage) {
          toast.success(usePage().props.flash.successMessage, {
            autoClose: 2000,
          });
        }
        if (usePage().props.flash.errorMessage) {
          toast.error(usePage().props.flash.errorMessage, {
            autoClose: 2000,
          });
        }
      },
    }
  );
};

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
  <AppLayout>
    <Head title="Global E-commerce : Global Online Shopping" />
    <section class="py-5 sm:py-7 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <h2 class="text-4xl text-slate-700 font-semibold mb-2">
          Shopping cart
        </h2>
      </div>
    </section>

    <section v-if="cartItems.length && shops.length" class="py-5">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-4">
          <main class="md:w-3/4">
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

              <div v-for="item in cartItems" :key="item.id">
                <div v-if="item.shop_id == shop.id">
                  <ShoppingCartItem :item="item" />
                </div>
              </div>

              <hr />
            </article>
          </main>

          <aside class="md:w-1/4">
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

              <Link
                class="px-4 py-3 mb-2 inline-block text-sm w-full text-center font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 uppercase"
                :href="route('checkout.index')"
              >
                <i class="fa-solid fa-right-from-bracket"></i>
                Proceed To Checkout
              </Link>

              <Link
                class="px-4 py-3 inline-block text-sm w-full text-center font-medium text-blue-600 bg-white shadow-sm border border-gray-200 rounded-md hover:bg-gray-100 uppercase"
                :href="route('home')"
              >
                <i class="fa-solid fa-shop"></i>
                Back to shop
              </Link>
            </article>

            <div
              class="border border-gray-200 bg-white shadow-sm rounded my-5 p-3"
            >
              <h2 class="font-bold text-lg mb-1 text-slate-700">
                Apply Coupon
              </h2>

              <span v-if="coupon" class="font-bold text-green-700 text-sm my-4">
                Coupon code applied.
              </span>

              <input
                type="text"
                class="w-full my-2 rounded-md py-2 text-sm font-bold text-slate-700 border-slate-400"
                placeholder="Enter Cupon Code"
                v-model="coupon_code"
                :disabled="coupon ? true : false"
              />

              <button
                class="px-4 py-3 mb-2 inline-block text-sm uppercase w-full text-center font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700"
                @click="applyCoupon"
                :disabled="coupon ? true : false"
              >
                Apply
              </button>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <section v-else class="min-h-[400px] flex flex-col items-center py-10">
      <h2 class="font-semibold text-lg text-center text-slate-600 mb-20">
        <i class="fa-solid fa-bag-shopping"></i>
        <br />
        There are no items in this cart.
      </h2>
      <Link
        :href="route('home')"
        class="border border-blue-600 px-5 py-3 shadow animate-bounce font-semibold text-blue-600 rounded text-sm hover:bg-blue-600 hover:text-white transition-all"
      >
        <i class="fa-solid fa-cart-shopping"></i>
        Continue Shopping
      </Link>
    </section>
  </AppLayout>
</template>


<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  display: none;
}
</style>
