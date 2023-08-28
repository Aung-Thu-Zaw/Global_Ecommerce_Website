<script setup>
import ProductCard from "@/Components/Cards/Products/ProductCardGrid.vue";
import ProductBanner from "@/Components/Banners/ProductBanner.vue";

defineProps({
  sellerProductBanners: Object,
  sellerRandomProducts: Object,
});
</script>


<template>
  <section>
    <!-- Seller Product Banners -->
    <div class="w-full my-5">
      <ProductBanner :productBanners="sellerProductBanners" />
    </div>

    <!-- Random Display Products section -->
    <section>
      <div v-if="sellerRandomProducts.length" class="my-5">
        <h1 class="text-2xl text-slate-700 font-bold my-10">Just For You</h1>

        <div
          class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4"
        >
          <div v-for="product in sellerRandomProducts" :key="product.id">
            <ProductCard :product="product"></ProductCard>
          </div>
        </div>
      </div>
    </section>
  </section>
</template>
