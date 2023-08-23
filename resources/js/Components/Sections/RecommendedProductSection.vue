<script setup>
import ProductCard from "@/Components/Cards/Products/ProductCard.vue";

defineProps({
    recommendedProducts: Object,
});
</script>

<template>
  <section class="pt-10 pb-20 bg-gray-100">
    <div class="container max-w-screen-xl mx-auto px-4">
      <h2 class="text-2xl font-semibold mb-8">Recommended products</h2>

      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4"
      >
        <!-- Recommended Products -->
        <div v-for="product in recommendedProducts" :key="product.id">
          <ProductCard :product="product"></ProductCard>
        </div>
      </div>
    </div>
  </section>
</template>
