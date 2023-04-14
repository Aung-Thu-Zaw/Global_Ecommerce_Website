<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/Cards/ProductCard.vue";
import { ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";

const props = defineProps({ hotDealProducts: Object });

const isLoading = ref(false);
const products = ref(props.hotDealProducts.data);
const url = usePage().url;

const loadMoreProduct = () => {
  if (props.hotDealProducts.next_page_url === null) {
    return;
  }

  isLoading.value = true;

  router.get(
    props.hotDealProducts.next_page_url,
    {},
    {
      preserveState: true,
      preserveScroll: true,
      only: ["hotDealProducts"],
      onSuccess: () => {
        isLoading.value = false;
        products.value = [...products.value, ...props.hotDealProducts.data];
        window.history.replaceState({}, "", url);
      },
    }
  );
};
</script>


<template>
  <AppLayout>
    <section class="container mx-auto mt-40 py-10">
      <div
        class="relative w-full h-[150px] mb-10 shadow-md rounded-md overflow-hidden border"
      >
        <img
          src="https://e0.pxfuel.com/wallpapers/661/60/desktop-wallpaper-abstract-background-light-blur-smooth-light-coloured-stains-spots.jpg"
          class="w-full h-full object-cover"
        />
        <div
          class="absolute top-[50%] right-[50%] translate-x-[50%] -translate-y-[50%] text-2xl font-semibold text-white"
        >
          <p class="text-center uppercase">Hot Deal Products</p>
        </div>
      </div>
      <div
        v-if="products"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4"
      >
        <div v-for="product in products" :key="product.id">
          <ProductCard :product="product"></ProductCard>
        </div>
      </div>
      <div v-else>
        <p class="text-center text-xl font-bold text-red-600 animate-bounce">
          No Product Found!
        </p>
      </div>

      <div
        v-if="props.hotDealProducts.next_page_url != null"
        class="my-5 flex items-center justify-center"
      >
        <img
          v-if="isLoading"
          src="../../../assets/images/loading.gif"
          class="w-14 h-14"
          alt=""
        />

        <button
          v-else
          @click="loadMoreProduct"
          class="border-2 border-slate-500 text-slate-600 rounded-sm px-5 py-2 shadow-md font-bold hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all"
        >
          LOAD MORE PRODUCTS
        </button>
      </div>
      <p v-else class="my-5 text-slate-600 text-center">
        You have reached the end of the page.
      </p>
    </section>
  </AppLayout>
</template>


