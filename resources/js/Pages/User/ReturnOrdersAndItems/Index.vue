<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import PendingStatus from "@/Components/Table/PendingStatus.vue";
import ConfirmedStatus from "@/Components/Table/ConfirmedStatus.vue";
import ProcessingStatus from "@/Components/Table/ProcessingStatus.vue";
import DeliveredStatus from "@/Components/Table/DeliveredStatus.vue";
import ShippedStatus from "@/Components/Table/ShippedStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import { inject } from "vue";
import axios from "axios";
import RequestedReturnOrdersTable from "@/Components/RequestedReturnOrdersTable.vue";
import ApprovedReturnOrdersTable from "@/Components/ApprovedReturnOrdersTable.vue";
import AllReturnOrdersTable from "@/Components/AllReturnOrdersTable.vue";
import RefundedReturnOrdersTable from "@/Components/RefundedReturnOrdersTable.vue";
import ToReceiveOrdersTable from "@/Components/ToReceiveOrdersTable.vue";
import ReceivedOrdersTable from "@/Components/ReceivedOrdersTable.vue";

const props = defineProps({
  allReturnOrders: Object,
  requestedReturnOrders: Object,
  approvedReturnOrders: Object,
  refundedReturnOrders: Object,
});
</script>

<template>
  <Head title="Return Orders And Items" />

  <AppLayout>
    <div
      class="max-w-[1400px] mx-auto mt-48 mb-10 flex flex-col items-center min-h-[500px] w-full p-5"
    >
      <h1 class="font-bold text-2xl text-slate-600 uppercase mb-5 self-start">
        Return Orders And Items
      </h1>

      <div
        class="border-b border-gray-200 dark:border-gray-700 self-start w-full"
      >
        <ul
          class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400"
          id="myTab"
          data-tabs-toggle="#myTabContent"
          role="tablist"
        >
          <li class="mr-2" role="presentation">
            <Link
              :href="route('return-orders.index')"
              :data="{ tab: 'all-return-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'all-return-orders',
              }"
            >
              <i class="fa-solid fa-boxes-packing mr-2 text-sm"></i>
              All Return Orders ({{ allReturnOrders.length }})
            </Link>
          </li>

          <li class="mr-2" role="presentation">
            <Link
              :href="route('return-orders.index')"
              :data="{ tab: 'requested-return-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'requested-return-orders',
              }"
            >
              <i class="fa-solid fa-rotate-right mr-2 text-sm"></i>
              Requested Return Orders ({{ requestedReturnOrders.length }})
            </Link>
          </li>

          <li class="mr-2" role="presentation">
            <Link
              :href="route('return-orders.index')"
              :data="{ tab: 'approved-return-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'approved-return-orders',
              }"
            >
              <i class="fa-solid fa-check-circle mr-2 text-sm"></i>
              Approved Return Orders ({{ approvedReturnOrders.length }})
            </Link>
          </li>

          <li class="mr-2" role="presentation">
            <Link
              :href="route('return-orders.index')"
              :data="{ tab: 'refunded-return-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'refunded-return-orders',
              }"
            >
              <i class="fa-solid fa-money-bill-transfer mr-2 text-sm"></i>
              Refunded Return Orders ({{ refundedReturnOrders.length }})
            </Link>
          </li>

          <!-- <li class="mr-2" role="presentation">
            <Link
              :href="route('my-orders.index')"
              :data="{ tab: 'to-receive-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'to-receive-orders',
              }"
            >
              <i class="fa-solid fa-boxes-stacked mr-2 text-sm"></i>
              To Receive ({{ toReceiveOrders.length }})
            </Link>
          </li>

          <li class="mr-2" role="presentation">
            <Link
              :href="route('my-orders.index')"
              :data="{ tab: 'received-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'received-orders',
              }"
            >
              <i class="fa-solid fa-handshake text-sm mr-2"></i>

              Received ({{ receivedOrders.length }})
            </Link>
          </li> -->
        </ul>
      </div>

      <div id="myTabContet" class="w-full">
        <div class="w-full">
          <div v-if="$page.props.ziggy.query.tab === 'all-return-orders'">
            <AllReturnOrdersTable :allReturnOrders="allReturnOrders" />
          </div>
          <div v-if="$page.props.ziggy.query.tab === 'requested-return-orders'">
            <RequestedReturnOrdersTable
              :requestedReturnOrders="requestedReturnOrders"
            />
          </div>
          <div
            v-else-if="$page.props.ziggy.query.tab === 'approved-return-orders'"
          >
            <ApprovedReturnOrdersTable
              :approvedReturnOrders="approvedReturnOrders"
            />
          </div>
          <div
            v-else-if="$page.props.ziggy.query.tab === 'refunded-return-orders'"
          >
            <RefundedReturnOrdersTable
              :refundedReturnOrders="refundedReturnOrders"
            />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
