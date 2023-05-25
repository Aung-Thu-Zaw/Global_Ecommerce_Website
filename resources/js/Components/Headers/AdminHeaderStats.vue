<script setup>
import CardStats from "@/Components/Cards/CardStats.vue";

defineProps({
  totalUsers: Number,
  totalVendors: Number,
  totalOrders: Number,
  todaySales: Number,
});
</script>

<template>
  <div class="relative bg-blue-500 md:pt-32 pb-32 pt-12">
    <div class="px-4 md:px-10 mx-auto w-full">
      <div>
        <div class="flex flex-wrap">
          <div class="w-full lg:w-6/12 xl:w-3/12 px-5 py-3">
            <CardStats
              statSubtitle="TOTAL USERS"
              :statTitle="totalUsers"
              statArrow="up"
              statPercent="12"
              statPercentColor="text-green-500"
              statDescripiron="Since last month"
              statIconName="fas fa-users"
              statIconColor="bg-teal-500"
            />
          </div>

          <div class="w-full lg:w-6/12 xl:w-3/12 px-5 py-3">
            <CardStats
              statSubtitle="TOTAL VENDORS"
              :statTitle="totalVendors"
              statArrow="up"
              statPercent="12"
              statPercentColor="text-green-500"
              statDescripiron="Since last month"
              statIconName="fas fa-store"
              statIconColor="bg-blue-500"
            />
          </div>

          <div class="w-full lg:w-6/12 xl:w-3/12 px-5 py-3">
            <CardStats
              statSubtitle="TOTAL DELIVERED ORDERS"
              :statTitle="totalOrders"
              statArrow="up"
              statPercent="12"
              statPercentColor="text-green-500"
              statDescripiron="Since last month"
              statIconName="fas fa-boxes-packing"
              statIconColor="bg-orange-500"
            />
          </div>

          <div class="w-full lg:w-6/12 xl:w-3/12 px-5 py-3">
            <CardStats
              statSubtitle="TODAY SALES"
              :statTitle="todaySales"
              statArrow="down"
              statPercent="1.10"
              statPercentColor="text-red-500"
              statDescripiron="Since yesterday"
              statIconName="fas fa-dollar-sign"
              statIconColor="bg-rose-500"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

