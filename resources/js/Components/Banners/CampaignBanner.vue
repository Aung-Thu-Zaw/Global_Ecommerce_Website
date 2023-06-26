<script setup>
defineProps({
  campaignBanner: Object,
});
</script>

<template>
  <section class="container mx-auto my-3 p-5">
    <div class="h-[200px] w-full flex items-center justify-center">
      <a :href="campaignBanner.url" target="_blank" class="h-full">
        <img :src="campaignBanner.image" alt="" class="h-full object-cover" />
      </a>
    </div>
  </section>
</template>
