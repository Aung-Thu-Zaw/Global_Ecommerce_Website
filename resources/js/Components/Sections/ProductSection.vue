<template>
  <section class="py-10">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div
        class="bg-orange-500 p-3 text-white lg:text-slate-600 lg:bg-transparent lg:p-0 mb-5 rounded-md flex items-center justify-between"
      >
        <slot name="sectionHeader"></slot>
      </div>

      <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4"
      >
        <ProductCard></ProductCard>
        <ProductCard></ProductCard>
        <ProductCard></ProductCard>
        <ProductCard></ProductCard>
        <ProductCard></ProductCard>
      </div>

      <!-- grid .// -->
    </div>
  </section>
</template>

<script>
import ProductCard from "@/Components/Cards/ProductCard.vue";
export default {
  components: { ProductCard },
};
</script>

<style>
</style>
