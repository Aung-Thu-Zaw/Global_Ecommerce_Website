<script setup>
import ProductCard from "@/Components/Cards/ProductCard.vue";
import { router } from "@inertiajs/core";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import "aos/dist/aos.css";
import { onMounted } from "vue";

const props = defineProps({
  randomProducts: Object,
});

onMounted(() =>
  AOS.init({
    duration: 500,
    easing: "ease-in-out",
    delay: 100,
  })
);

const isLoading = ref(false);
const products = ref(props.randomProducts.data);
const url = usePage().url;

const loadMoreProduct = () => {
  if (props.randomProducts.next_page_url === null) {
    return;
  }
  isLoading.value = true;

  router.get(
    props.randomProducts.next_page_url,
    {},
    {
      preserveState: true,
      preserveScroll: true,
      only: ["randomProducts"],
      onSuccess: () => {
        isLoading.value = false;
        products.value = [...products.value, ...props.randomProducts.data];
        window.history.replaceState({}, "", url);
      },
    }
  );
};
</script>
<template>
  <section class="py-10">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div
        class="bg-orange-500 p-3 text-white lg:text-slate-600 lg:bg-transparent lg:p-0 mb-5 rounded-md flex items-center justify-between"
      >
        <h2 class="text-md md:text-2xl font-bold">PRODUCTS FOR YOU</h2>
      </div>

      <div
        v-if="products"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4"
      >
        <div v-for="product in products" :key="product.id" data-aos="zoom-in">
          <ProductCard :product="product"></ProductCard>
        </div>
      </div>
      <div v-else>
        <p class="text-center text-xl font-bold text-red-600 animate-bounce">
          No Product Found!
        </p>
      </div>

      <div
        v-if="props.randomProducts.next_page_url != null || products"
        class="my-5 flex items-center justify-center"
      >
        <img
          v-if="isLoading"
          src="../../assets/images/loading.gif"
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
    </div>
  </section>
</template>

