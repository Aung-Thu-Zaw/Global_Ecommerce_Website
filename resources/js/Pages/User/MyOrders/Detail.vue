<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import OrderCartItem from "@/Components/Items/OrderCartItem.vue";
import OrderDetailCard from "@/Components/Cards/OrderDetailCard.vue";
import DeliveryInformationCard from "@/Components/Cards/DeliveryInformationCard.vue";
import Stepper from "@/Components/Steppers/OrderStepper.vue";
import { ref } from "vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import ConfirmedStatus from "@/Components/Status/ConfirmedStatus.vue";
import ProcessingStatus from "@/Components/Status/ProcessingStatus.vue";
import ShippedStatus from "@/Components/Status/ShippedStatus.vue";
import DeliveredStatus from "@/Components/Status/DeliveredStatus.vue";
import { useReCaptcha } from "vue-recaptcha-v3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  order: Object,
  orderItems: Object,
  deliveryInformation: Object,
  shops: Object,
});

const isReturnFormOpened = ref(false);
const isCancelFormOpened = ref(false);

const form = useForm({
  return_reason: "",
  cancel_reason: "",
  captcha_token: null,
});

const { executeRecaptcha, recaptchaLoaded } = useReCaptcha();
const handleOrder = async () => {
  await recaptchaLoaded();
  form.captcha_token = await executeRecaptcha("handle_order");
  form.return_reason ? handleReturn() : handleCancel();
};

const handleReturn = () => {
  form.post(route("my-orders.return", props.order.id), {
    onFinish: () => {
      isReturnFormOpened.value = false;
      if (usePage().props.flash.successMessage) {
        toast.success(usePage().props.flash.successMessage, {
          autoClose: 2000,
        });
      }
    },
  });
};

const handleCancel = () => {
  form.post(route("my-orders.cancel", props.order.id), {
    onFinish: () => {
      isCancelFormOpened.value = false;
      if (usePage().props.flash.successMessage) {
        toast.success(usePage().props.flash.successMessage, {
          autoClose: 2000,
        });
      }
    },
  });
};
</script>

<template>
  <Head title="Detail Order" />

  <AppLayout>
    <div
      class="container mx-auto mt-48 mb-10 flex flex-col items-center min-h-[500px] w-full p-5"
    >
      <h1 class="font-bold text-2xl text-slate-600 uppercase mb-5 self-start">
        Order Details
      </h1>

      <div
        class="bg-gray-50 px-5 py-3 rounded-sm w-full border shadow flex items-center justify-between"
      >
        <div>
          <h3 class="font-bold text-sm text-slate-700">
            Order No : {{ order.order_no }}
          </h3>
          <span class="text-[.8rem] font-bold text-slate-500">
            Placed On {{ order.created_at }}
          </span>
        </div>
        <div class="font-bold text-md text-slate-700">
          Total: $ {{ order.total_amount }}
        </div>
      </div>

      <Stepper :order="order" />

      <div class="grid grid-cols-2 gap-3 my-5">
        <!-- Delivery Information Detail  -->
        <DeliveryInformationCard :deliveryInformation="deliveryInformation" />

        <div class="p-5 border shadow-md rounded-sm">
          <!-- Order Detail  -->
          <OrderDetailCard
            :deliveryInformation="deliveryInformation"
            :order="order"
          />
        </div>
      </div>

      <article
        v-for="(shop, index) in shops"
        :key="index"
        class="border border-gray-200 bg-white shadow-sm rounded mb-5 w-full my-3"
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

        <div v-for="item in orderItems" :key="item.id" class="w-full">
          <div v-if="item.shop_id === shop.id">
            <OrderCartItem :item="item" :order="order" />
          </div>
        </div>
      </article>

      <div
        v-if="order.payment_type === 'card'"
        class="w-full flex flex-col items-center"
      >
        <button
          v-if="
            order.order_status !== 'shipped' &&
            order.order_status !== 'delivered' &&
            !order.return_reason
          "
          @click="isReturnFormOpened = !isReturnFormOpened"
          class="bg-yellow-500 font-bold text-sm py-3 px-5 text-white rounded-sm hover:bg-yellow-700 transition-all ml-auto"
        >
          <span v-if="!isReturnFormOpened">
            <i class="fa-solid fa-rotate-left mr-3"></i>
            Return Order
          </span>
          <span v-else>
            <i class="fa-solid fa-xmark mr-3"></i>
            Close
          </span>
        </button>

        <div v-if="isReturnFormOpened" class="w-full my-5">
          <form
            @submit.prevent="handleOrder"
            class="flex flex-col items-center"
          >
            <textarea
              cols="30"
              rows="10"
              placeholder="Please, write reason why do you want to return this order."
              class="w-full h-[200px] border-2 border-slate-400 focus:border-slate-400 focus:ring-0 rounded-md"
              v-model="form.return_reason"
            ></textarea>
            <button
              class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-md ml-auto my-3"
            >
              <i class="fa-solid fa-paper-plane mr-2"></i>
              Submit
            </button>
          </form>
        </div>
      </div>
      <div
        v-if="order.payment_type === 'cash on delivery'"
        class="w-full flex flex-col items-center"
      >
        <button
          v-if="
            order.order_status !== 'shipped' &&
            order.order_status !== 'delivered' &&
            !order.cancel_reason
          "
          @click="isCancelFormOpened = !isCancelFormOpened"
          class="bg-yellow-500 font-bold text-sm py-3 px-5 text-white rounded-sm hover:bg-yellow-700 transition-all ml-auto"
        >
          <span v-if="!isCancelFormOpened">
            <i class="fa-solid fa-rotate-left mr-3"></i>
            Cancel Order
          </span>
          <span v-else>
            <i class="fa-solid fa-xmark mr-3"></i>
            Close
          </span>
        </button>

        <div v-if="isCancelFormOpened" class="w-full my-5">
          <form
            @submit.prevent="handleOrder"
            class="flex flex-col items-center"
          >
            <textarea
              cols="30"
              rows="10"
              placeholder="Please, write reason why do you want to cancel this order."
              class="w-full h-[200px] border-2 border-slate-400 focus:border-slate-400 focus:ring-0 rounded-md"
              v-model="form.cancel_reason"
            ></textarea>
            <button
              class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-md ml-auto my-3"
            >
              <i class="fa-solid fa-paper-plane mr-2"></i>
              Submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
