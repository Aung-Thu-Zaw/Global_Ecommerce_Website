<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const order_no = ref(null);

const handleTrackOrder = () => {
  router.post(
    route("order.track"),
    {
      order_no: order_no.value,
    },
    {
      onFinish: () => {
        order_no.value = "";
      },
      onSuccess: () => {
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
  <div
    class="text-sm font-bold px-3 py-2 hover:text-gray-300 cursor-pointer uppercase"
    data-dropdown-toggle="dropdownSearch"
    data-dropdown-placement="bottom"
    data-te-toggle="tooltip"
    data-te-placement="bottom"
    title="Check what happened to my products order?"
  >
    <i class="fa-solid fa-location-crosshairs"></i>
    {{ __("TRACK_MY_ORDER") }}
  </div>
  <div
    id="dropdownSearch"
    class="z-10 hidden bg-white rounded-lg shadow-md w-[300px] p-5 border border-gray-300"
  >
    <h4 class="font-bold text-lg mb-4 text-slate-600 text-center">
      <i class="fa-solid fa-location-crosshairs"></i>
      {{ __("TRACK_MY_ORDER") }}
    </h4>

    <!-- Order Tracking Search Box -->
    <form @submit.prevent="handleTrackOrder">
      <label for="" class="text-sm text-slate-500 mb-3">
        {{ __("ENTER_YOUR_ORDER_NUMBER") }}
      </label>
      <input
        type="text"
        class="w-full border-slate-300 rounded-sm text-slate-800 focus:ring-0 focus:border-slate-300"
        placeholder="Eg. #e5353453er"
        v-model="order_no"
      />
      <button
        class="font-bold text-sm bg-blue-600 w-full py-2 px 4 my-3 hover:bg-blue-700 rounded-sm"
      >
        {{ __("SEARCH") }}
      </button>
    </form>
  </div>
</template>

