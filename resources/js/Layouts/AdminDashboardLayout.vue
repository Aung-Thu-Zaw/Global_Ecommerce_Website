<template>
  <div class="font-roboto">
    <AdminSidebar />
    <div class="relative md:ml-64 bg-blueGray-100">
      <DashboardNavbar>
        <template v-slot:dashboardName>
          <span>Admin Dashboard</span>
        </template>
      </DashboardNavbar>
      <AdminHeaderStats />
      <div class="px-4 md:px-10 mx-auto w-full -m-24">
        <slot />
        <Footer />
      </div>
    </div>
  </div>
</template>
<script>
import DashboardNavbar from "@/Components/Navbars/DashboardNavbar.vue";
import AdminHeaderStats from "@/Components/Headers/AdminHeaderStats.vue";
import AdminSidebar from "@/Components/Sidebar/AdminSidebar.vue";
import Footer from "@/Components/Footers/DashboardFooter.vue";
export default {
  name: "vendor-layout",
  components: {
    DashboardNavbar,
    AdminSidebar,
    Footer,
    AdminHeaderStats,
  },
};
</script>
