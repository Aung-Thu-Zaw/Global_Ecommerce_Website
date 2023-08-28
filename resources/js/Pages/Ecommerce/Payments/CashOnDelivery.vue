<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { router, Head } from "@inertiajs/vue3";

const props = defineProps({
  totalPrice: String,
  cartItems: Object,
});

const handleConfirmOrder = () => {
  router.post(
    route("payment.cash", {
      total_price: props.totalPrice,
      cart_items: props.cartItems,
    })
  );
};
</script>

<template>
  <AppLayout>
    <Head title="Global E-commerce : Global Online Shopping" />
    <section class="py-10 mt-44 min-h-[530px]">
      <div
        class="p-5 w-[600px] border mx-auto shadow flex flex-col items-center justify-center"
      >
        <h2 class="text-md font-bold text-slate-600">
          You can pay in cash to our courier when you receive the goods at your
          doorstep.
        </h2>
        <button
          type="button"
          @click="handleConfirmOrder"
          class="px-5 py-3 text-sm font-bold rounded-md border border-blue-600 text-blue-600 mt-10 mb-5 hover:bg-blue-600 hover:text-white transition-all animate-bounce"
        >
          <i class="fa-solid fa-handshake"></i>
          Confirm Order
        </button>
      </div>
    </section>
  </AppLayout>
</template>

