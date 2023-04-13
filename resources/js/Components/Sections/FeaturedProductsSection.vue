
<script setup>
import ProductCard from "@/Components/Cards/ProductCard.vue";

defineProps({
  featuredProducts: Object,
});
</script>


<template>
  <section class="py-10">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div
        class="bg-orange-500 p-3 text-white lg:text-slate-600 lg:bg-transparent lg:p-0 mb-5 rounded-md flex items-center justify-between"
      >
        <h2 class="text-md md:text-2xl font-bold">FEATURED PRODUCTS</h2>
        <span class="hidden border-4 border-slate-300 w-[65%] lg:block"></span>
        <a href="" class="text-sm font-bold md:text-md animate-bounce">
          SEE ALL
          <i class="fa-solid fa-angles-right ml-3"></i>
        </a>
      </div>

      <div
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4"

      >
        <div v-for="product in featuredProducts" :key="product.id">
          <ProductCard :product="product"></ProductCard>
        </div>
      </div>
    </div>
  </section>
</template>


