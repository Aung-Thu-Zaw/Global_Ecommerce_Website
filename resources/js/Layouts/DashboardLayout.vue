<template>
  <div class="font-roboto">
    <Sidebar />
    <div class="relative md:ml-64 bg-blueGray-100">
      <DashboardNavbar />
      <Header />
      <div class="px-4 md:px-10 mx-auto w-full -m-24">
        <slot />
        <Footer />
      </div>
    </div>
  </div>
</template>
  <script>
import DashboardNavbar from "@/Components/Navbars/DashboardNavbar.vue";
import Sidebar from "@/Components/Sidebar/Sidebar.vue";
import Header from "@/Components/Headers/HeaderStats.vue";
import Footer from "@/Components/Footers/DashboardFooter.vue";
export default {
  name: "admin-layout",
  components: {
    DashboardNavbar,
    Sidebar,
    Header,
    Footer,
  },
};
</script>

