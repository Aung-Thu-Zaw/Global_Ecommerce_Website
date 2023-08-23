<script setup>
import EcommerceFooter from "@/Components/Footers/EcommerceFooter.vue";
import EcommerceNavbar from "@/Components/Navbars/EcommerceNavbar.vue";
import CategoryNavbar from "@/Components/Navbars/CategoryNavbar.vue";
import EcommerceRightSideNavbar from "@/Components/Navbars/EcommerceRightSideNavbar.vue";
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

  <EcommerceRightSideNavbar />
  <slot />
  <EcommerceFooter />
</template>


<style>
.scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #999 #f0f0f0;
}

.scrollbar::-webkit-scrollbar {
  width: 6px;
}

.scrollbar::-webkit-scrollbar-track {
  background-color: #f0f0f0;
}

.scrollbar::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}
</style>
