<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/Cards/Products/ProductCard.vue";
import { computed, onMounted, ref } from "vue";
import { usePage, router, Head } from "@inertiajs/vue3";

const props = defineProps({
  flashSale: Object,
  flashSaleProducts: Object,
});

const isLoading = ref(false);

const products = ref(props.flashSaleProducts.data);

const url = usePage().url;

// Handle Load More Button
const loadMoreProduct = () => {
  if (props.flashSaleProducts.next_page_url === null) {
    return;
  }

  isLoading.value = true;

  router.get(
    props.flashSaleProducts.next_page_url,
    {},
    {
      preserveState: true,
      preserveScroll: true,
      only: ["flashSaleProducts"],
      onSuccess: () => {
        isLoading.value = false;
        products.value = [...products.value, ...props.flashSaleProducts.data];
        window.history.replaceState({}, "", url);
      },
    }
  );
};

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
  <AppLayout>
    <Head title="All Flash Sale Products" />

    <!-- Title -->
    <section class="container mx-auto mt-40 py-10">
      <div
        class="relative w-full h-[180px] mb-10 shadow-md rounded-md overflow-hidden border"
      >
        <img
          src="https://wallpaperaccess.com/full/1092758.jpg"
          class="w-full h-full object-cover"
        />
        <div
          class="absolute top-[50%] right-[50%] translate-x-[50%] -translate-y-[50%] text-2xl font-semibold text-white"
        >
          <p class="text-center uppercase mb-5">
            {{ __("FLASH_SALE_PRODUCTS") }}
          </p>

          <div class="flex items-center space-x-5">
            <div
              class="flex flex-col items-center justify-between font-semibold border text-white w-16 h-16 p-3 rounded-sm shadow-md"
            >
              <span class="text-sm">{{ days }}</span>
              <span class="text-[.7rem]">Days</span>
            </div>
            <div
              class="flex flex-col items-center justify-between font-semibold border text-white w-16 h-16 p-3 rounded-sm shadow-md"
            >
              <span class="text-sm">{{ hours }}</span>
              <span class="text-[.7rem]">Hours</span>
            </div>
            <div
              class="flex flex-col items-center justify-between font-semibold border text-white w-16 h-16 p-3 rounded-sm shadow-md"
            >
              <span class="text-sm">{{ minutes }}</span>
              <span class="text-[.7rem]">Minutes</span>
            </div>
            <div
              class="flex flex-col items-center justify-between font-semibold border text-white w-16 h-16 p-3 rounded-sm shadow-md"
            >
              <span class="text-sm animate-pulse">{{ seconds }}</span>
              <span class="text-[.7rem]">Seconds</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Products -->
      <div
        v-if="products"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4"
      >
        <div v-for="product in products" :key="product.id">
          <ProductCard :product="product.product"></ProductCard>
        </div>
      </div>
      <div v-else>
        <p class="text-center text-xl font-bold text-red-600 animate-bounce">
          {{ __("NO_PRODUCT_FOUND") }}!
        </p>
      </div>

      <div
        v-if="props.flashSaleProducts.next_page_url != null"
        class="my-5 flex items-center justify-center"
      >
        <!-- Loading Animation  -->
        <img
          v-if="isLoading"
          src="../../../assets/images/loading.gif"
          class="w-14 h-14"
          alt=""
        />

        <!-- Load More Button  -->
        <button
          v-else
          @click="loadMoreProduct"
          class="border-2 border-slate-500 text-slate-600 rounded-sm px-5 py-2 shadow-md font-bold hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all"
        >
          {{ __("LOAD_MORE_PRODUCTS") }}
        </button>
      </div>
      <p v-else class="my-5 text-slate-600 text-center">
        {{ __("YOU_HAVE_REACH_THE_END_OF_THE_PAGE") }}
      </p>
    </section>
  </AppLayout>
</template>


