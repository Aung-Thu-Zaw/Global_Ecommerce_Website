<script setup>
import ProductCard from "@/Components/Cards/ProductCard.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
  vendorProductBanners: Object,
  products: Object,
});
</script>


<template>
  <section>
    <div class="w-full my-5">
      <div
        v-if="vendorProductBanners.length"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3"
      >
        <div
          v-for="vendorProductBanner in vendorProductBanners"
          :key="vendorProductBanner.id"
          class="w-full max-w-sm bg-white border border-gray-200 rounded-sm shadow mx-auto"
        >
          <Link :href="vendorProductBanner.url">
            <img
              class="rounded-sm h-full object-center object-contain"
              :src="vendorProductBanner.image"
              alt="product image"
            />
          </Link>
        </div>
      </div>
    </div>

    <div class="my-5">
      <h1 class="text-2xl text-slate-700 font-bold my-10">Just For You</h1>

      <div
        v-if="products.length"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4"
      >
        <div v-for="product in products" :key="product.id">
          <ProductCard :product="product"></ProductCard>
        </div>
      </div>

      <div v-else class="my-10">
        <p class="text-center font-bold text-slate-600">Product Not Found!</p>
      </div>
    </div>
  </section>
</template>
