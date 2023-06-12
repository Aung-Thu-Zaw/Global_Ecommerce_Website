<script setup>
import AdminDashboardNavbar from "@/Components/Navbars/AdminDashboardNavbar.vue";
import AdminSidebar from "@/Components/Sidebars/AdminSidebar.vue";
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";

onMounted(() => {
  initFlowbite();
});
</script>

<template>
  <div class="font-roboto">
    <AdminSidebar />
    <AdminDashboardNavbar />
    <div class="relative md:ml-64 bg-white">
      <slot />
    </div>
  </div>
</template>

