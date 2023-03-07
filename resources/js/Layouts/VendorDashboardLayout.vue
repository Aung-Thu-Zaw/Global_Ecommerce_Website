<template>
  <div class="font-roboto">
    <VendorSidebar />
    <div class="relative md:ml-64 bg-white">
      <slot />
    </div>
  </div>
</template>
<script setup>

import VendorSidebar from "@/Components/Sidebar/VendorSidebar.vue";
</script>



