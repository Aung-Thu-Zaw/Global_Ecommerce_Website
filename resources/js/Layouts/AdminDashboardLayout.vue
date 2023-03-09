<template>
  <div class="font-roboto">
    <AdminSidebar />
    <DashboardNavbar>
      <template v-slot:dashboardName>
        <span>Admin Dashboard</span>
      </template>
    </DashboardNavbar>
    <div class="relative md:ml-64 bg-white">
      <slot />
    </div>
  </div>
</template>
<script setup>
import DashboardNavbar from "@/Components/Navbars/DashboardNavbar.vue";

import AdminSidebar from "@/Components/Sidebar/AdminSidebar.vue";
</script>
