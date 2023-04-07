<script setup>
import EcommerceFooter from "@/Components/Footers/EcommerceFooter.vue";
import EcommerceNavbar from "@/Components/Navbars/EcommerceNavbar.vue";
import CategoryNavbar from "@/Components/Navbars/CategoryNavbar.vue";
</script>


<template>
  <EcommerceNavbar />
  <CategoryNavbar />
  <slot />
  <EcommerceFooter />
</template>


