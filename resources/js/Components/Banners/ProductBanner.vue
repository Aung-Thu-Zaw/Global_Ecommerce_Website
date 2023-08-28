<script setup>
defineProps({
  productBanners: Object,
});
</script>

<template>
  <section v-if="productBanners.length" class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
      <div
        v-for="productBanner in productBanners"
        :key="productBanner.id"
        class="rounded-md overflow-hidden mx-3 mb-5 shadow-lg border-2 border-gray-200"
      >
        <a :href="productBanner.url" :key="productBanner.id" class="h-full">
          <img :src="productBanner.image" alt="" class="h-full object-cover" />
        </a>
      </div>
    </div>
  </section>
</template>
