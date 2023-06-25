<script setup>
defineProps({
  productBanners: Object,
});
</script>


<template>
  <section class="container mx-auto">
    <div class="flex items-center justify-between flex-wrap">
      <div
        v-for="productBanner in productBanners"
        :key="productBanner.id"
        class="w-[300px] h-[300px] lg:w-[350px] lg:h-[350px] rounded-md overflow-hidden mx-3 mb-5 shadow-lg border-2 border-gray-200"
      >
        <a :href="productBanner.url" :key="productBanner.id" class="h-full">
          <img :src="productBanner.image" alt="" class="h-full object-cover" />
        </a>
      </div>
    </div>
  </section>
</template>
