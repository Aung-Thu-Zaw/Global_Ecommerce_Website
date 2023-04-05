
<script setup>
defineProps({
  productBanners: Object,
});
</script>
<template>
  <section class="container mx-auto">
    <div class="flex items-center justify-center flex-wrap">
      <div
        v-for="productBanner in productBanners"
        :key="productBanner.id"
        class="w-[300px] h-[300px] lg:w-[350px] lg:h-[350px] rounded-md overflow-hidden m-5"
      >
        <a :href="productBanner.url" :key="productBanner.id" class="h-full">
          <img :src="productBanner.image" alt="" class="h-full object-cover" />
        </a>
      </div>
    </div>
  </section>
</template>
