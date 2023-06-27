<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import AllOrdersTable from "@/Components/OrderTables/AllOrdersTable.vue";
import ToPayOrdersTable from "@/Components/OrderTables/ToPayOrdersTable.vue";
import ToReceiveOrdersTable from "@/Components/OrderTables/ToReceiveOrdersTable.vue";
import ReceivedOrdersTable from "@/Components/OrderTables/ReceivedOrdersTable.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
  orders: Object,
  toPayOrders: Object,
  toReceiveOrders: Object,
  receivedOrders: Object,
});
</script>

<template>
  <Head title="My Orders" />

  <AppLayout>
    <div
      class="max-w-[1400px] mx-auto mt-48 mb-10 flex flex-col items-center min-h-[500px] w-full p-5"
    >
      <h1 class="font-bold text-2xl text-slate-600 uppercase mb-5 self-start">
        My Orders
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
              :href="route('my-orders.index')"
              :data="{ tab: 'all-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'all-orders',
              }"
            >
              <i class="fa-solid fa-boxes-packing mr-2 text-sm"></i>
              All Orders ({{ orders.length }})
            </Link>
          </li>

          <li class="mr-2" role="presentation">
            <Link
              :href="route('my-orders.index')"
              :data="{ tab: 'to-pay-orders' }"
              class="inline-flex p-4 rounded-t-lg active group"
              :class="{
                'text-blue-600 border-b-2 border-blue-600':
                  $page.props.ziggy.query.tab === 'to-pay-orders',
              }"
            >
              <i class="fa-solid fa-money-bill-wave mr-2 text-sm"></i>
              To Pay ({{ toPayOrders.length }})
            </Link>
          </li>

          <li class="mr-2" role="presentation">
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
          </li>
        </ul>
      </div>

      <div id="myTabContet" class="w-full">
        <div class="w-full">
          <div
            v-if="
              $page.props.ziggy.query.tab === 'all-orders' ||
              !$page.props.ziggy.query.tab
            "
          >
            <AllOrdersTable :orders="orders" />
          </div>
          <div v-else-if="$page.props.ziggy.query.tab === 'to-pay-orders'">
            <ToPayOrdersTable :toPayOrders="toPayOrders" />
          </div>
          <div v-else-if="$page.props.ziggy.query.tab === 'to-receive-orders'">
            <ToReceiveOrdersTable :toReceiveOrders="toReceiveOrders" />
          </div>
          <div v-else-if="$page.props.ziggy.query.tab === 'received-orders'">
            <ReceivedOrdersTable :receivedOrders="receivedOrders" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
