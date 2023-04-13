<script setup>
import EcommerceFooter from "@/Components/Footers/EcommerceFooter.vue";
import EcommerceNavbar from "@/Components/Navbars/EcommerceNavbar.vue";
import CategoryNavbar from "@/Components/Navbars/CategoryNavbar.vue";
</script>


<template>
  <div class="z-50 fixed top-0 w-full">
    <EcommerceNavbar />
    <CategoryNavbar />
  </div>
  <slot />
  <EcommerceFooter />
</template>


