<script setup>
import ProductCard from "@/Components/Cards/Products/ProductCard.vue";
import { computed, onMounted, ref } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  flashSale: Object,
  flashSaleProducts: Object,
});

const currentTime = ref(new Date().getTime());
const endDate = ref(new Date(props.flashSale.end_date).getTime());

const timeLeft = computed(() => endDate.value - currentTime.value);

const days = computed(() => {
  const remainingDays = Math.floor(timeLeft.value / (1000 * 60 * 60 * 24));
  return remainingDays >= 0 ? remainingDays : 0;
});

const hours = computed(() => {
  const remainingHours = Math.floor(
    (timeLeft.value % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  return remainingHours >= 0 ? remainingHours : 0;
});

const minutes = computed(() => {
  const remainingMinutes = Math.floor(
    (timeLeft.value % (1000 * 60 * 60)) / (1000 * 60)
  );
  return remainingMinutes >= 0 ? remainingMinutes : 0;
});

const seconds = computed(() => {
  const remainingSeconds = Math.floor((timeLeft.value % (1000 * 60)) / 1000);
  return remainingSeconds >= 0 ? remainingSeconds : 0;
});

const updateTime = () => {
  setInterval(() => {
    currentTime.value = new Date().getTime();
  }, 1000);
};

onMounted(() => {
  updateTime();
});
</script>

<template>
  <section v-if="flashSaleProducts.length" class="py-10">
    <div
      class="container max-w-screen-xl mx-auto p-4 border border-slate-300 bg-white rounded-md shadow-md"
    >
      <!-- Title -->
      <div
        class="bg-orange-500 p-3 text-white lg:text-slate-600 lg:bg-transparent lg:p-0 mb-5 rounded-md flex items-center justify-between"
      >
        <h2 class="text-md md:text-2xl font-bold">
          {{ __("FLASH_SALES") }}
        </h2>
        <div class="flex items-center space-x-5">
          <div
            class="flex flex-col items-center justify-between font-semibold bg-blue-600 text-white w-14 h-14 p-3 rounded-sm shadow-md"
          >
            <span class="text-sm">{{ days }}</span>
            <span class="text-[.7rem]">Days</span>
          </div>
          <div
            class="flex flex-col items-center justify-between font-semibold bg-blue-600 text-white w-14 h-14 p-3 rounded-sm shadow-md"
          >
            <span class="text-sm">{{ hours }}</span>
            <span class="text-[.7rem]">Hours</span>
          </div>
          <div
            class="flex flex-col items-center justify-between font-semibold bg-blue-600 text-white w-14 h-14 p-3 rounded-sm shadow-md"
          >
            <span class="text-sm">{{ minutes }}</span>
            <span class="text-[.7rem]">Minutes</span>
          </div>
          <div
            class="flex flex-col items-center justify-between font-semibold bg-blue-600 text-white w-14 h-14 p-3 rounded-sm shadow-md"
          >
            <span class="text-sm animate-pulse">{{ seconds }}</span>
            <span class="text-[.7rem]">Seconds</span>
          </div>
        </div>
        <Link
          :href="route('products.flash-sales')"
          class="text-sm font-bold md:text-md animate-bounce"
        >
          {{ __("SEE_ALL") }}
          <i class="fa-solid fa-angles-right ml-3"></i>
        </Link>
      </div>

      <div
        v-if="flashSaleProducts.length"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4"
      >
        <!-- Product Card -->
        <div
          v-for="flashSaleProduct in flashSaleProducts"
          :key="flashSaleProduct.id"
        >
          <ProductCard :product="flashSaleProduct.product" />
        </div>
      </div>
      <div v-else>
        <p class="text-center text-xl font-bold text-red-600 animate-bounce">
          {{ __("NO_PRODUCT_FOUND") }}!
        </p>
      </div>
    </div>
  </section>
</template>


