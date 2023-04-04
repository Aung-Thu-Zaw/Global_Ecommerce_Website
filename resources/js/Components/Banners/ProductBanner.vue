
<script setup>
defineProps({
  productBanners: Object,
});
</script>
<template>
  <section class="container mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
      <div
        v-for="productBanner in productBanners"
        :key="productBanner.id"
        class="border h-[300px] rounded-md overflow-hidden my-3"
      >
        <a :href="productBanner.url" :key="productBanner.id">
          <img
            :src="productBanner.image"
            alt=""
            class="w-full h-full object-cover"
          />
        </a>
      </div>
    </div>
  </section>
</template>
