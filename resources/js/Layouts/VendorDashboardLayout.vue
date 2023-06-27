<script setup>
import VendorDashboardNavbar from "@/Components/Navbars/VendorDashboardNavbar.vue";
import VendorSidebar from "@/Components/Sidebars/VendorSidebar.vue";
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";

onMounted(() => {
  initFlowbite();
});
</script>

<template>
  <div class="font-roboto">
    <VendorSidebar />
    <VendorDashboardNavbar />
    <div class="relative md:ml-64 bg-white">
      <slot />
    </div>
  </div>
</template>




