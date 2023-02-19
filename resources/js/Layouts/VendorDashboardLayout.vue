<template>
  <div class="font-roboto">
    <VendorSidebar />
    <div class="relative md:ml-64 bg-blueGray-100">
      <DashboardNavbar>
        <template v-slot:dashboardName>
          <span>Vendor Dashboard</span>
        </template>
      </DashboardNavbar>
      <VendorHeaderStats />
      <div class="px-4 md:px-10 mx-auto w-full -m-24">
        <slot />
        <Footer />
      </div>
    </div>
  </div>
</template>
<script>
import DashboardNavbar from "@/Components/Navbars/DashboardNavbar.vue";
import VendorHeaderStats from "@/Components/Headers/VendorHeaderStats.vue";
import VendorSidebar from "@/Components/Sidebar/VendorSidebar.vue";
import Footer from "@/Components/Footers/DashboardFooter.vue";
export default {
  name: "vendor-layout",
  components: {
    DashboardNavbar,
    VendorSidebar,
    Footer,
    VendorHeaderStats,
  },
};
</script>
