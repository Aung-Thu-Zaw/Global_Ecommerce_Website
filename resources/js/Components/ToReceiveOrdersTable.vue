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
import AllOrdersTable from "@/Components/AllOrdersTable.vue";
import ToPayOrdersTable from "@/Components/ToPayOrdersTable.vue";
import ToReceiveOrdersTable from "@/Components/ToReceiveOrdersTable.vue";
import ReceivedOrdersTable from "@/Components/ReceivedOrdersTable.vue";

const props = defineProps({
  toReceiveOrders: Object,
});

const swal = inject("$swal");

const handleDownload = async (orderId) => {
  try {
    const response = await axios.get(`/my-orders/invoice/${orderId}/download`, {
      responseType: "blob",
    });
    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", "invoice.pdf");
    document.body.appendChild(link);
    link.click();
  } catch (error) {
    this.showSnackbar({
      message: "Error downloading invoice.",
      type: "error",
    });
  }
};
</script>

<template>
  <TableContainer class="w-full my-5">
    <TableHeader>
      <HeaderTh> No </HeaderTh>
      <HeaderTh> Invoice </HeaderTh>
      <HeaderTh> Payment </HeaderTh>
      <HeaderTh> Amount </HeaderTh>
      <HeaderTh> Status </HeaderTh>
      <HeaderTh> Order Date </HeaderTh>
      <HeaderTh> Actions </HeaderTh>
    </TableHeader>

    <tbody v-if="toReceiveOrders.length">
      <Tr v-for="order in toReceiveOrders" :key="order.id">
        <BodyTh>{{ order.id }}</BodyTh>
        <Td>{{ order.invoice_no }}</Td>
        <Td class="capitalize">{{ order.payment_type }}</Td>
        <Td>$ {{ order.total_amount }}</Td>
        <Td>
          <PendingStatus v-if="order.order_status === 'pending'">
            {{ order.order_status }}
          </PendingStatus>
          <ConfirmedStatus v-else-if="order.order_status === 'confirm'">
            {{ order.order_status }}
          </ConfirmedStatus>
          <ProcessingStatus v-else-if="order.order_status === 'processing'">
            {{ order.order_status }}
          </ProcessingStatus>
          <ShippedStatus v-else-if="order.order_status === 'shipped'">
            {{ order.order_status }}
          </ShippedStatus>
          <DeliveredStatus v-else-if="order.order_status === 'delivered'">
            {{ order.order_status }}
          </DeliveredStatus>
          <span
            v-if="
              order.return_reason &&
              order.return_date &&
              order.return_status === 'pending'
            "
            class="text-red-600 text-sm bg-red-200 px-3 py-1 rounded-full ml-2"
          >
            <i class="fa-solid fa-rotate-right animate-spin"></i>
            return
          </span>
          <span
            v-if="
              order.return_reason &&
              order.return_approved_date &&
              order.return_status === 'approved'
            "
            class="text-green-600 text-sm bg-green-200 px-3 py-1 rounded-full ml-2"
          >
            <i class="fa-solid fa-circle-check animate-pulse"></i>
            approved
          </span>
        </Td>
        <Td>{{ order.order_date }}</Td>

        <Td>
          <button
            @click="handleDownload(order.id)"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-orange-600 text-white hover:bg-orange-700 mr-3 my-1"
          >
            <i class="fa-solid fa-download"></i>
            Invoice
          </button>
          <Link
            :href="route('my-orders.show', order.id)"
            as="button"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-sky-600 text-white hover:bg-sky-700 my-1"
          >
            <i class="fa-solid fa-eye"></i>
            Details
          </Link>
        </Td>
      </Tr>
    </tbody>
  </TableContainer>
</template>
