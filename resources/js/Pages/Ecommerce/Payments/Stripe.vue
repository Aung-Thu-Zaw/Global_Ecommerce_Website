<template>
  <AppLayout>
    <Head title="Global E-commerce : Global Online Shopping" />
    <section class="py-10 mt-44 min-h-[530px]">
      <div class="p-5 w-[600px] border mx-auto shadow">
        <form @submit.prevent="handleSubmit">
          <input
            type="hidden"
            name="payment_method_id"
            v-model="paymentMethodId"
          />

          <div class="mb-5">
            <label for="card-element">Credit or debit card</label>
            <div id="card-element" class="form-control"></div>
            <div id="card-errors" role="alert" class="text-red-600"></div>
          </div>

          <div class="mb-5">
            <button
              class="w-full py-2 font-bold text-white rounded-sm bg-blue-600"
              :disabled="processing"
            >
              {{ processing ? "Processing..." : "Pay Now" }}
            </button>
          </div>
        </form>
      </div>
    </section>
  </AppLayout>
</template>

<script>
import { loadStripe } from "@stripe/stripe-js";
import AppLayout from "@/Layouts/AppLayout.vue";
import { router, Head } from "@inertiajs/vue3";

export default {
  components: {
    AppLayout,
    Head
  },
  data() {
    return {
      stripe: null,
      card: null,
      paymentMethodId: null,
      processing: false,
      paymentError: null,
      paymentSuccess: null,
    };
  },
  async mounted() {
    this.stripe = await loadStripe(this.stripeKey);
    this.card = this.stripe.elements().create("card");

    this.card.mount("#card-element");

    // Handle real-time validation errors from the card Element.
    this.card.addEventListener("change", (event) => {
      const displayError = document.getElementById("card-errors");
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = "";
      }
    });
  },
  props: {
    stripeKey: String,
    totalPrice: String,
    cartItems: Object,
  },
  methods: {
    async handleSubmit() {
      this.processing = true;
      this.paymentError = null;
      this.paymentSuccess = null;

      const { error, paymentMethod } = await this.stripe.createPaymentMethod({
        type: "card",
        card: this.card,
      });

      if (error) {
        this.paymentError = error.message;
        this.processing = false;
      } else {
        // Send the paymentMethod.id to your server to complete the payment.
        // You can access it with paymentMethod.id

        this.paymentMethodId = paymentMethod.id;

        router.post(
          route("payment.stripePaymentProcess", {
            payment_method_id: this.paymentMethodId,
            total_price: this.totalPrice,
            cart_items: this.cartItems,
          }),
          {},
          {
            preserveScroll: true,
            onSuccess: () => {
              this.paymentSuccess = "Payment successful";
              this.processing = false;
              //   window.history.replaceState({}, "", );
            },
          }
        );
      }
    },
  },
};
</script>

<style>
label {
  display: block;
  margin-bottom: 5px;
}

.form-control {
  height: 40px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: none;
}
</style>
