<template>
  <EcommerceNavbar />
  <slot />
  <EcommerceFooter />
</template>

<script setup>
import EcommerceFooter from "@/Components/Footers/EcommerceFooter.vue";
import EcommerceNavbar from "@/Components/Navbars/EcommerceNavbar.vue";
</script>

<style>
</style>
