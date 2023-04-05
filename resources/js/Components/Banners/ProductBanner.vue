
<script setup>
defineProps({
  productBanners: Object,
});
</script>
<template>
  <section class="container mx-auto">
    <div class="flex items-center justify-between">
      <div
        v-for="productBanner in productBanners"
        :key="productBanner.id"
        class="w-[350px] h-[350px] rounded-md overflow-hidden my-3"
      >
        <a :href="productBanner.url" :key="productBanner.id" class="h-full">
          <img :src="productBanner.image" alt="" class="h-full object-cover" />
        </a>
      </div>
    </div>
  </section>
</template>
