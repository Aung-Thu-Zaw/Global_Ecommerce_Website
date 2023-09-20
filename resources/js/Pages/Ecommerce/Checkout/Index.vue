<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DeliveryInformationForm from "@/Components/Forms/DeliveryInformationForm.vue";
import PlaceOrderForm from "@/Components/Forms/PlaceOrderForm.vue";
import CheckoutShoppingCartItem from "@/Components/Items/CheckoutShoppingCartItem.vue";
import BuyNowItem from "@/Components/Items/BuyNowItem.vue";
import { computed, ref } from "vue";
import { useForm, Head, Link } from "@inertiajs/vue3";
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
  product: Object,
  quantity: Number,
});

const totalItems = computed(() => {
  return props.cartItems?.reduce((total, item) => total + item.qty, 0);
});

const totalPrice = computed(() =>
  props.cartItems?.reduce((total, item) => {
    return item.product.discount
      ? total + item.qty * parseFloat(item.product.discount)
      : total + item.qty * parseFloat(item.product.price);
  }, 0)
);

const totalPriceWithCoupon = computed(
  () => totalPrice.value - props.coupon.discount_amount
);
</script>

<template>
  <AppLayout>
    <Head title="Global E-commerce : Global Online Shopping" />

    <section class="py-10 mt-44">
      <div class="container max-w-screen-xl mx-auto px-4">
        <h1 class="font-semibold text-xl text-slate-700 mb-5">
          <i class="fa-solid fa-file-lines"></i>
          {{ __("DELIVERY_INFORMATION") }}
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

            <!-- Packages -->
            <div v-if="!product">
              <div
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

                <!-- item-cart -->
                <div v-for="item in cartItems" :key="item.id">
                  <div v-if="item.shop_id == shop.id">
                    <CheckoutShoppingCartItem :item="item" />
                  </div>
                </div>

                <hr />
              </div>
            </div>
            <div v-else>
              <div
                class="border border-gray-200 bg-white shadow-sm rounded mb-5"
              >
                <div
                  class="border-b flex items-center justify-between px-3 py-2 lg:px-5 font-bold text-slate-600 text-md"
                >
                  <span>
                    <i class="fas fa-box"></i>
                    {{ __("PACKAGE") }} 1
                  </span>
                  <span class="text-sm text-slate-500">
                    {{ __("SHIPPED_BY") }}
                    <span class="text-slate-700">
                      {{ product.shop.shop_name }}
                    </span>
                  </span>
                </div>

                <BuyNowItem :product="product" :quantity="quantity" />
              </div>
            </div>
          </main>

          <aside class="md:w-1/3">
            <PlaceOrderForm
              :cartItems="cartItems"
              :deliveryInformation="deliveryInformation"
              :coupon="coupon"
              :product="product"
              :quantity="quantity"
            />
          </aside>
        </div>
      </div>
    </section>
  </AppLayout>
</template>
