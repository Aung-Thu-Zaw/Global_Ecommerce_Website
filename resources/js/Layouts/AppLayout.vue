<script setup>
import EcommerceFooter from "@/Components/Footers/EcommerceFooter.vue";
import EcommerceNavbar from "@/Components/Navbars/EcommerceNavbar.vue";
import CategoryNavbar from "@/Components/Navbars/CategoryNavbar.vue";
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";

// initialize components based on data attribute selectors
onMounted(() => {
  initFlowbite();
});
</script>


<template>
  <div class="z-50 fixed top-0 w-full">
    <EcommerceNavbar />
    <CategoryNavbar />
  </div>
  <slot />
  <EcommerceFooter />
</template>


