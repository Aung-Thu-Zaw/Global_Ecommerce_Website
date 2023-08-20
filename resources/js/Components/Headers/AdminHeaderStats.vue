<script setup>
import CardStats from "@/Components/Cards/CardStats.vue";
import { computed } from "vue";

const props = defineProps({
  totalUsers: Number,
  totalSellers: Number,
  totalOrders: Number,
  todaySales: Number,
  percentageChangeForUser: Number,
  percentageChangeForSeller: Number,
  percentageChangeForOrder: Number,
  percentageChangeForSales: Number,
});

const formatpercentageChangeForUser = computed(() =>
  props.percentageChangeForUser.toFixed(1)
);

const formatpercentageChangeForSeller = computed(() =>
  props.percentageChangeForSeller.toFixed(1)
);

const formatpercentageChangeForOrder = computed(() =>
  props.percentageChangeForOrder.toFixed(1)
);

const formatpercentageChangeForSales = computed(() =>
  props.percentageChangeForSales.toFixed(1)
);
</script>

<template>
  <div class="relative bg-blue-500 md:pt-32 pb-32 pt-12">
    <div class="px-4 md:px-10 mx-auto w-full">
      <div>
        <div class="flex flex-wrap">
          <div class="w-full lg:w-6/12 xl:w-3/12 px-5 py-3">
            <CardStats
              :statSubtitle="__('TOTAL_USERS')"
              :statTitle="totalUsers"
              :statArrow="formatpercentageChangeForUser > 0 ? 'up' : 'down'"
              :statPercent="formatpercentageChangeForUser"
              :statPercentColor="
                formatpercentageChangeForUser > 0
                  ? 'text-green-500'
                  : 'text-red-500'
              "
              :statDescripiron="__('THAN_LAST_MONTH')"
              statIconName="fas fa-users"
              statIconColor="bg-teal-500"
            />
          </div>

          <div class="w-full lg:w-6/12 xl:w-3/12 px-5 py-3">
            <CardStats
              :statSubtitle="__('TOTAL_SELLERS')"
              :statTitle="totalSellers"
              :statArrow="formatpercentageChangeForSeller > 0 ? 'up' : 'down'"
              :statPercent="formatpercentageChangeForSeller"
              :statPercentColor="
                formatpercentageChangeForSeller > 0
                  ? 'text-green-500'
                  : 'text-red-500'
              "
              :statDescripiron="__('THAN_LAST_MONTH')"
              statIconName="fas fa-store"
              statIconColor="bg-blue-500"
            />
          </div>

          <div class="w-full lg:w-6/12 xl:w-3/12 px-5 py-3">
            <CardStats
              :statSubtitle="__('TOTAL_ORDERS')"
              :statTitle="totalOrders"
              :statArrow="formatpercentageChangeForOrder > 0 ? 'up' : 'down'"
              :statPercent="formatpercentageChangeForOrder"
              :statPercentColor="
                formatpercentageChangeForOrder > 0
                  ? 'text-green-500'
                  : 'text-red-500'
              "
              :statDescripiron="__('THAN_LAST_MONTH')"
              statIconName="fas fa-boxes-packing"
              statIconColor="bg-orange-500"
            />
          </div>

          <div class="w-full lg:w-6/12 xl:w-3/12 px-5 py-3">
            <CardStats
              :statSubtitle="__('TODAY_SALES')"
              :statTitle="todaySales"
              :statArrow="formatpercentageChangeForSales > 0 ? 'up' : 'down'"
              :statPercent="formatpercentageChangeForSales"
              :statPercentColor="
                formatpercentageChangeForSales > 0
                  ? 'text-green-500'
                  : 'text-red-500'
              "
              :statDescripiron="__('THAN_YESTERDAY')"
              statIconName="fas fa-dollar-sign"
              statIconColor="bg-rose-500"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

