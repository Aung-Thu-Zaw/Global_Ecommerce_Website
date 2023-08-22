<script setup>
defineProps({
  campaignBanner: Object,
});
</script>

<template>
  <section v-if="campaignBanner" class="container mx-auto my-3 p-5">
    <div
      class="min-h-[120px] max-h-[300px] w-full flex items-center justify-center"
    >
      <a :href="campaignBanner.url" target="_blank">
        <img :src="campaignBanner.image" class="object-cover" />
      </a>
    </div>
  </section>
</template>
