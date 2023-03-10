<template>
  <div class="font-roboto">
    <VendorSidebar />
    <VendorDashboardNavbar />
    <div class="relative md:ml-64 bg-white">
      <slot />
    </div>
  </div>
</template>
<script setup>
import VendorDashboardNavbar from "@/Components/Navbars/VendorDashboardNavbar.vue";
import VendorSidebar from "@/Components/Sidebar/VendorSidebar.vue";
</script>



