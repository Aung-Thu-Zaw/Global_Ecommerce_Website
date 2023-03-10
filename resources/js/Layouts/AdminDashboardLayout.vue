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

// import { toast } from "vue3-toastify";
// import "vue3-toastify/dist/index.css";

// toast.success("Wow so easy !", {
//   autoClose: 2000,
// });
</script>
