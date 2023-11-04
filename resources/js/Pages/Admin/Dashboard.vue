<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import AdminDashboardHeaderStats from "@/Components/Headers/AdminDashboardHeaderStats.vue";
// import TotalSaleLineChart from "@/Components/Cards/Dashboard/TotalSaleLineChart.vue";
// import TotalOrderBarChart from "@/Components/Cards/Dashboard/TotalOrderBarChart.vue";
// import TotalUserBarChart from "@/Components/Cards/Dashboard/TotalUserBarChart.vue";
import { Head } from "@inertiajs/vue3";

// Define the props
defineProps({
  totalUsers: Number,
  totalSellers: Number,
  totalOrders: Number,
  todaySales: Number,
  percentageChangeForUser: Number,
  percentageChangeForSeller: Number,
  percentageChangeForOrder: Number,
  percentageChangeForSales: Number,
  thisYearMonthlySaleLables: Object,
  thisYearMonthlySaleData: Object,
  lastYearMonthlySaleLables: Object,
  lastYearMonthlySaleData: Object,
  thisYearMonthlyOrderLables: Object,
  thisYearMonthlyOrderData: Object,
  lastYearMonthlyOrderLables: Object,
  lastYearMonthlyOrderData: Object,
  thisYearMonthlyUserRegisterLables: Object,
  thisYearMonthlyUserRegisterData: Object,
  lastYearMonthlyUserRegisterLables: Object,
  lastYearMonthlyUserRegisterData: Object,
  thisYearMonthlySellerRegisterLables: Object,
  thisYearMonthlySellerRegisterData: Object,
  lastYearMonthlySellerRegisterLables: Object,
  lastYearMonthlySellerRegisterData: Object,
  socialTraffics: Object,
});

// Success Toast
// if (usePage().props.flash.successMessage) {
//   toast.success(usePage().props.flash.successMessage, {
//     autoClose: 2000,
//   });
// }
</script>

<template>
  <Head title="Admin Dashboard" />
  <AdminDashboardLayout>
    <template #header>
      <AdminDashboardHeaderStats
        :totalUsers="totalUsers"
        :totalSellers="totalSellers"
        :totalOrders="totalOrders"
        :todaySales="todaySales"
        :percentageChangeForUser="percentageChangeForUser"
        :percentageChangeForSeller="percentageChangeForSeller"
        :percentageChangeForOrder="percentageChangeForOrder"
        :percentageChangeForSales="percentageChangeForSales"
      />
    </template>

    <div class="min-h-screen">
      <div class="flex flex-wrap">
        <div class="w-full xl:w-1/2 px-4">
          <TotalUserBarChart />
        </div>
        <div class="w-full xl:w-1/2 px-4">
          <TotalOrderBarChart />
        </div>
        <div class="w-full mb-12 xl:mb-0 px-4">
          <TotalSaleLineChart />
        </div>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
