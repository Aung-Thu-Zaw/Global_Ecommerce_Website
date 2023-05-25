<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import AdminHeaderStats from "@/Components/Headers/AdminHeaderStats.vue";
import CardBarChart from "@/Components/Cards/CardBarChart.vue";
import CardLineChart from "@/Components/Cards/CardLineChart.vue";
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
});

if (usePage().props.flash.successMessage) {
  toast.success(usePage().props.flash.successMessage, {
    autoClose: 2000,
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Admin Dashboard" />
    <AdminHeaderStats
      :totalUsers="totalUsers"
      :totalVendors="totalVendors"
      :totalOrders="totalOrders"
      :todaySales="todaySales"
    />
    <div class="px-4 md:px-10 mx-auto w-full -m-24 border">
      <div class="relative z-10">
        <div class="flex flex-wrap">
          <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
            <CardLineChart></CardLineChart>
          </div>
          <div class="w-full xl:w-4/12 px-4">
            <CardBarChart></CardBarChart>
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

