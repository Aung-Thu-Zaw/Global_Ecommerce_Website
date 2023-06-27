<script setup>
import ProductCard from "@/Components/Cards/ProductCard.vue";

defineProps({
  justForYouProducts: Object,
});
</script>

<template>
  <section class="pt-10 pb-20 bg-gray-100">
    <div class="container max-w-screen-xl mx-auto px-4">
      <h2 class="text-2xl font-semibold mb-8">Just For You</h2>

      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4"
      >
        <div v-for="product in justForYouProducts" :key="product.id">
          <ProductCard :product="product"></ProductCard>
        </div>
      </div>
    </div>
  </section>
</template>
