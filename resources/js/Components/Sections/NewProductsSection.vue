<script setup>
import ProductCard from "@/Components/Cards/Products/ProductCardGrid.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
  newProducts: Object,
});
</script>

<template>
  <section class="">
    <div class="container max-w-screen-xl mx-auto px-4">
      <!-- Title -->
      <div
        class="bg-orange-500 p-3 text-white lg:text-slate-600 lg:bg-transparent lg:p-0 mb-5 rounded-md flex items-center justify-between"
      >
        <h2 class="text-md md:text-2xl font-bold">{{ __("NEW_PRODUCTS") }}</h2>
        <span class="hidden border-4 border-slate-300 w-[70%] lg:block"></span>
        <Link
          :href="route('products.new')"
          class="text-sm font-bold md:text-md animate-bounce"
        >
          {{ __("SEE_ALL") }}
          <i class="fa-solid fa-angles-right ml-3"></i>
        </Link>
      </div>

      <div
        v-if="newProducts.length"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4"
      >
        <!-- Product Card -->
        <div v-for="product in newProducts" :key="product.id" class="h-auto">
          <ProductCard :product="product"></ProductCard>
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
