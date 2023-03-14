<template>
  <div class="font-roboto">
    <AdminSidebar />
    <AdminDashboardNavbar />
    <div class="relative md:ml-64 bg-white">
      <slot />
    </div>
  </div>
</template>
<script setup>
import AdminDashboardNavbar from "@/Components/Navbars/AdminDashboardNavbar.vue";
import AdminSidebar from "@/Components/Sidebar/AdminSidebar.vue";

</script>
