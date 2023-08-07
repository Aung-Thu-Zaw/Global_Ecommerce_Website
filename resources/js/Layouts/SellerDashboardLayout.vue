<script setup>
import SellerDashboardNavbar from "@/Components/Navbars/SellerDashboardNavbar.vue";
import SellerSidebar from "@/Components/Sidebars/SellerSidebar.vue";
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";

onMounted(() => {
  initFlowbite();
});
</script>

<template>
  <div class="font-roboto">
    <SellerSidebar />
    <SellerDashboardNavbar />
    <div class="relative md:ml-64 bg-white">
      <slot />
    </div>
  </div>
</template>




