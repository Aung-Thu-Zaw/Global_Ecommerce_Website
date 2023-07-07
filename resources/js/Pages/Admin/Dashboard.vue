<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import AdminHeaderStats from "@/Components/Headers/AdminHeaderStats.vue";
import MonthlyOrderCardBarChart from "@/Components/Charts/MonthlyOrderCardBarChart.vue";
import MonthlySalesCardLineChart from "@/Components/Charts/MonthlySalesCardLineChart.vue";
import MonthlyRegisterUserCardLineChart from "@/Components/Charts/MonthlyRegisterUserCardLineChart.vue";
import MonthlyRegisterVendorCardLineChart from "@/Components/Charts/MonthlyRegisterVendorCardLineChart.vue";
import CardPageVisits from "@/Components/Cards/CardPageVisits.vue";
import CardSocialTraffic from "@/Components/Cards/CardSocialTraffic.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { usePage, Head } from "@inertiajs/vue3";

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
});

if (usePage().props.flash.successMessage) {
  toast.success(usePage().props.flash.successMessage, {
    autoClose: 2000,
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('ADMIN_DASHBOARD')" />

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
    <div class="px-4 md:px-10 mx-auto w-full -m-24">
      <div class="relative z-1">
        <div class="flex flex-wrap">
          <div class="w-full xl:w-6/12 mb-12 xl:mb-0 px-4">
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
          <div class="w-full xl:w-6/12 mb-12 xl:mb-0 px-4">
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
          <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
            <MonthlySalesCardLineChart
              :thisYearMonthlySaleLables="thisYearMonthlySaleLables"
              :thisYearMonthlySaleData="thisYearMonthlySaleData"
              :lastYearMonthlySaleLables="lastYearMonthlySaleLables"
              :lastYearMonthlySaleData="lastYearMonthlySaleData"
            />
          </div>
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
          <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
            <CardPageVisits />
          </div>
          <div class="w-full xl:w-4/12 px-4">
            <CardSocialTraffic />
          </div>
        </div>
      </div>
    </div>
  </AdminDashboardLayout>
</template>

