<template>
  <div class="font-roboto">
    <AdminSidebar />
    <div class="relative md:ml-64 bg-white">
      <slot />
    </div>
  </div>
</template>
<script setup>
import AdminSidebar from "@/Components/Sidebar/AdminSidebar.vue";
</script>
