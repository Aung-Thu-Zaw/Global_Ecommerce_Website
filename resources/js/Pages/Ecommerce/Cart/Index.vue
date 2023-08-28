<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ShoppingCartItem from "@/Components/Items/ShoppingCartItem.vue";
import OrderSummaryCard from "@/Components/Cards/OrderSummaryCard.vue";
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

// Calculate Total Product Price
const totalPrice = computed(() =>
  props.cartItems.reduce((total, item) => {
    return item.product.discount
      ? total + item.qty * parseFloat(item.product.discount)
      : total + item.qty * parseFloat(item.product.price);
  }, 0)
);

// Handle Apply Coupon
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
</script>

<template>
  <AppLayout>
    <Head title="Global E-commerce : Global Online Shopping" />

    <!-- Title -->
    <section class="py-5 sm:py-7 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <h2 class="text-4xl text-slate-700 font-semibold mb-2">
          {{ __("SHOPPING_CART") }}
        </h2>
      </div>
    </section>

    <section v-if="cartItems.length && shops.length" class="py-5">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col md:flex-row gap-4">
          <main class="md:w-3/4">
            <!-- Packages -->
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
                  {{ __("PACKAGE") }} {{ index + 1 }}
                </span>
                <span class="text-sm text-slate-500">
                  {{ __("SHIPPED_BY") }}
                  <span class="text-slate-700">{{ shop.shop_name }}</span>
                </span>
              </div>

              <!-- Cart Items -->
              <div v-for="item in cartItems" :key="item.id">
                <div v-if="item.shop_id == shop.id">
                  <ShoppingCartItem :item="item" />
                </div>
              </div>

              <hr />
            </article>
          </main>

          <aside class="md:w-1/4">
            <!-- Order Summary Card -->
            <OrderSummaryCard :cartItems="cartItems" :coupon="coupon" />

            <!-- Apply Coupon Input -->
            <div
              class="border border-gray-200 bg-white shadow-sm rounded my-5 p-3"
            >
              <h2 class="font-bold text-lg mb-1 text-slate-700">
                {{ __("APPLY_COUPON") }}
              </h2>

              <span v-if="coupon" class="font-bold text-green-700 text-sm my-4">
                {{ __("COUPON_CODE_APPLIED") }}
              </span>

              <input
                type="text"
                class="w-full my-2 rounded-md py-2 text-sm font-bold text-slate-700 border-slate-400"
                :placeholder="__('ENTER_COUPON_CODE')"
                v-model="coupon_code"
                :disabled="coupon ? true : false"
              />

              <button
                class="px-4 py-2 mb-2 inline-block text-sm uppercase w-full text-center font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700"
                @click="applyCoupon"
                :disabled="coupon ? true : false"
              >
                {{ __("APPLY") }}
              </button>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <!-- No Items Card Section -->
    <section v-else class="min-h-[400px] flex flex-col items-center py-10">
      <h2 class="font-semibold text-lg text-center text-slate-600 mb-20">
        <i class="fa-solid fa-bag-shopping"></i>
        <br />

        {{ __("THERE_ARE_NO_ITEMS_IN_THIS_CART") }}
      </h2>
      <Link
        as="button"
        :href="route('home')"
        class="border border-blue-600 px-5 py-3 shadow animate-bounce font-semibold text-blue-600 rounded text-sm hover:bg-blue-600 hover:text-white transition-all"
      >
        <i class="fa-solid fa-cart-shopping"></i>
        {{ __("CONTINUE_SHOPPING") }}
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
