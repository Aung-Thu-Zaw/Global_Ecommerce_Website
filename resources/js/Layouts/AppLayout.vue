<script setup>
import EcommerceFooter from "@/Components/Footers/EcommerceFooter.vue";
import EcommerceNavbar from "@/Components/Navbars/EcommerceNavbar.vue";
import CategoryNavbar from "@/Components/Navbars/CategoryNavbar.vue";
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";
import "aos/dist/aos.css";
import { AOS } from "aos";

// initialize components based on data attribute selectors
onMounted(() => {
  initFlowbite();
  AOS.init({
    duration: 500,
    easing: "ease-in-out",
    delay: 100,
  });
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


