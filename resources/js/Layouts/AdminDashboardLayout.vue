<script setup>
import AdminDashboardNavbar from "@/Components/Navbars/AdminDashboardNavbar.vue";
import AdminDashboardSidebar from "@/Components/Sidebars/AdminDashboardSidebar.vue";
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";

onMounted(() => {
  initFlowbite();
});
</script>

<template>
  <div class="">
    <AdminDashboardSidebar />
    <div class="relative md:ml-64 bg-blueGray-100">
      <AdminDashboardNavbar />
      <slot name="header"></slot>

      <div class="px-4 md:px-10 mx-auto w-full -m-24 md:m-0">
        <slot />
      </div>
    </div>
  </div>
</template>
