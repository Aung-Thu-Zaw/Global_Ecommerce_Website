<template>
  <AdminDashboardLayout>
    <DashboardNavbar>
      <template v-slot:dashboardName>
        <span>Admin Dashboard</span>
      </template>
    </DashboardNavbar>
    <AdminHeaderStats />

  </AdminDashboardLayout>
</template>

    <script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import DashboardNavbar from "@/Components/Navbars/DashboardNavbar.vue";
import AdminHeaderStats from "@/Components/Headers/AdminHeaderStats.vue";
</script>

    <style>
</style>
