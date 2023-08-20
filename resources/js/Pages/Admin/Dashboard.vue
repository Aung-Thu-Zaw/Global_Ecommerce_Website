<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import AdminHeaderStats from "@/Components/Headers/AdminHeaderStats.vue";
import MonthlyOrderCardBarChart from "@/Components/Charts/MonthlyOrderCardBarChart.vue";
import MonthlySalesCardLineChart from "@/Components/Charts/MonthlySalesCardLineChart.vue";
import MonthlyRegisterUserCardLineChart from "@/Components/Charts/MonthlyRegisterUserCardLineChart.vue";
import MonthlyRegisterSellerCardLineChart from "@/Components/Charts/MonthlyRegisterSellerCardLineChart.vue";
import CardPageVisits from "@/Components/Cards/CardPageVisits.vue";
import CardSocialTraffic from "@/Components/Cards/CardSocialTraffic.vue";
import { usePage, Head } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

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
if (usePage().props.flash.successMessage) {
  toast.success(usePage().props.flash.successMessage, {
    autoClose: 2000,
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('ADMIN_DASHBOARD')" />

    <!-- Status Cards -->
    <AdminHeaderStats
      :totalUsers="totalUsers"
      :totalSellers="totalSellers"
      :totalOrders="totalOrders"
      :todaySales="todaySales"
      :percentageChangeForUser="percentageChangeForUser"
      :percentageChangeForSeller="percentageChangeForSeller"
      :percentageChangeForOrder="percentageChangeForOrder"
      :percentageChangeForSales="percentageChangeForSales"
    />

    <!-- Charts Container -->
    <div class="px-4 md:px-10 mx-auto w-full -m-24">
      <div class="relative z-1">
        <div class="flex flex-wrap">
          <!-- Monthly Registered User Chart -->
          <div class="w-full xl:w-1/2 mb-12 xl:mb-0 px-4">
            <MonthlyRegisterUserCardLineChart
              :thisYearMonthlyUserRegisterLables="
                thisYearMonthlyUserRegisterLables
              "
              :thisYearMonthlyUserRegisterData="thisYearMonthlyUserRegisterData"
              :lastYearMonthlyUserRegisterLables="
                lastYearMonthlyUserRegisterLables
              "
              :lastYearMonthlyUserRegisterData="lastYearMonthlyUserRegisterData"
            />
          </div>
          <!-- Monthly Registered Seller Chart -->
          <div class="w-full xl:w-1/2 mb-12 xl:mb-0 px-4">
            <MonthlyRegisterSellerCardLineChart
              :thisYearMonthlySellerRegisterLables="
                thisYearMonthlySellerRegisterLables
              "
              :thisYearMonthlySellerRegisterData="
                thisYearMonthlySellerRegisterData
              "
              :lastYearMonthlySellerRegisterLables="
                lastYearMonthlySellerRegisterLables
              "
              :lastYearMonthlySellerRegisterData="
                lastYearMonthlySellerRegisterData
              "
            />
          </div>
        </div>
        <div class="flex flex-wrap">
          <!-- Monthly Sales Chart -->
          <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
            <MonthlySalesCardLineChart
              :thisYearMonthlySaleLables="thisYearMonthlySaleLables"
              :thisYearMonthlySaleData="thisYearMonthlySaleData"
              :lastYearMonthlySaleLables="lastYearMonthlySaleLables"
              :lastYearMonthlySaleData="lastYearMonthlySaleData"
            />
          </div>
          <!-- Monthly Order Chart -->
          <div class="w-full xl:w-4/12 px-4">
            <MonthlyOrderCardBarChart
              :thisYearMonthlyOrderLables="thisYearMonthlyOrderLables"
              :thisYearMonthlyOrderData="thisYearMonthlyOrderData"
              :lastYearMonthlyOrderLables="lastYearMonthlyOrderLables"
              :lastYearMonthlyOrderData="lastYearMonthlyOrderData"
            />
          </div>
        </div>
        <div class="flex flex-wrap mt-4">
          <!-- Page Visits -->
          <div class="w-full xl:w-1/2 mb-12 xl:mb-0 px-4">
            <CardPageVisits />
          </div>

          <!-- Social Traffic -->
          <div class="w-full xl:w-1/2 px-4">
            <CardSocialTraffic :socialTraffics="socialTraffics" />
          </div>
        </div>
      </div>
    </div>
  </AdminDashboardLayout>
</template>

