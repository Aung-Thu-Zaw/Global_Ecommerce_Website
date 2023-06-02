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
import RequestedCancelOrdersTable from "@/Components/RequestedCancelOrdersTable.vue";
import ApprovedCancelOrdersTable from "@/Components/ApprovedCancelOrdersTable.vue";
import AllCancelOrdersTable from "@/Components/AllCancelOrdersTable.vue";
import RefundedReturnOrdersTable from "@/Components/RefundedReturnOrdersTable.vue";
import ToReceiveOrdersTable from "@/Components/ToReceiveOrdersTable.vue";
import ReceivedOrdersTable from "@/Components/ReceivedOrdersTable.vue";

const props = defineProps({
  allCancelOrders: Object,
  requestedCancelOrders: Object,
  approvedCancelOrders: Object,
});

</script>

<template>
  <Head title="Cancel Orders And Items" />

  <AppLayout>
    <div
      class="max-w-[1400px] mx-auto mt-48 mb-10 flex flex-col items-center min-h-[500px] w-full p-5"
    >
      <h1 class="font-bold text-2xl text-slate-600 uppercase mb-5 self-start">
        Cancel Orders And Items
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
              :href="route('cancel-orders.index')"
              :data="{ tab: 'all-cancel-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'all-cancel-orders',
              }"
            >
              <i class="fa-solid fa-boxes-packing mr-2 text-sm"></i>
              All Cancel Orders ({{ allCancelOrders.length }})
            </Link>
          </li>

          <li class="mr-2" role="presentation">
            <Link
              :href="route('cancel-orders.index')"
              :data="{ tab: 'requested-cancel-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'requested-cancel-orders',
              }"
            >
              <i class="fa-solid fa-rotate-right mr-2 text-sm"></i>
              Requested Cancel Orders ({{ requestedCancelOrders.length }})
            </Link>
          </li>

          <li class="mr-2" role="presentation">
            <Link
              :href="route('cancel-orders.index')"
              :data="{ tab: 'approved-cancel-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'approved-cancel-orders',
              }"
            >
              <i class="fa-solid fa-check-circle mr-2 text-sm"></i>
              Approved Cancel Orders ({{ approvedCancelOrders.length }})
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
          <div v-if="$page.props.ziggy.query.tab === 'all-cancel-orders'">
            <AllCancelOrdersTable :allCancelOrders="allCancelOrders" />
          </div>
          <div v-if="$page.props.ziggy.query.tab === 'requested-cancel-orders'">
            <RequestedCancelOrdersTable
              :requestedCancelOrders="requestedCancelOrders"
            />
          </div>
          <div
            v-else-if="$page.props.ziggy.query.tab === 'approved-cancel-orders'"
          >
            <ApprovedCancelOrdersTable
              :approvedCancelOrders="approvedCancelOrders"
            />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
