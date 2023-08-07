<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import AdminHeaderStats from "@/Components/Headers/AdminHeaderStats.vue";
import MonthlyOrderCardBarChart from "@/Components/Charts/MonthlyOrderCardBarChart.vue";
import MonthlySalesCardLineChart from "@/Components/Charts/MonthlySalesCardLineChart.vue";
import MonthlyRegisterUserCardLineChart from "@/Components/Charts/MonthlyRegisterUserCardLineChart.vue";
import MonthlyRegisterVendorCardLineChart from "@/Components/Charts/MonthlyRegisterSellerCardLineChart.vue";
import CardPageVisits from "@/Components/Cards/CardPageVisits.vue";
import CardSocialTraffic from "@/Components/Cards/CardSocialTraffic.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { usePage, Head } from "@inertiajs/vue3";
import { watch } from "vue";

// Define the props
defineProps({
  totalUsers: Number,
  totalVendors: Number,
  totalOrders: Number,
  todaySales: Number,
  percentageChangeForUser: Number,
  percentageChangeForVendor: Number,
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
  thisYearMonthlyVendorRegisterLables: Object,
  thisYearMonthlyVendorRegisterData: Object,
  lastYearMonthlyVendorRegisterLables: Object,
  lastYearMonthlyVendorRegisterData: Object,
  socialTraffics: Object,
});

// Success Toast
// if (usePage().props.flash.successMessage) {
//   toast.success(usePage().props.flash.successMessage, {
//     autoClose: 2000,
//   });
// }

watch(
  () => usePage().props.flash.successMessage,
  () => {
    if (usePage().props.flash.successMessage) {
      toast.success(usePage().props.flash.successMessage, {
        autoClose: 2000,
      });
    }
  }
);
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('ADMIN_DASHBOARD')" />

    <!-- Status Cards -->
    <AdminHeaderStats
      :totalUsers="totalUsers"
      :totalVendors="totalVendors"
      :totalOrders="totalOrders"
      :todaySales="todaySales"
      :percentageChangeForUser="percentageChangeForUser"
      :percentageChangeForVendor="percentageChangeForVendor"
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
          <!-- Monthly Registered Vendor Chart -->
          <div class="w-full xl:w-1/2 mb-12 xl:mb-0 px-4">
            <MonthlyRegisterVendorCardLineChart
              :thisYearMonthlyVendorRegisterLables="
                thisYearMonthlyVendorRegisterLables
              "
              :thisYearMonthlyVendorRegisterData="
                thisYearMonthlyVendorRegisterData
              "
              :lastYearMonthlyVendorRegisterLables="
                lastYearMonthlyVendorRegisterLables
              "
              :lastYearMonthlyVendorRegisterData="
                lastYearMonthlyVendorRegisterData
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

