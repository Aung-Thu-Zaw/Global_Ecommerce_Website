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

const props = defineProps({
  orders: Object,
  toPayOrders: Object,
  toReceiveOrders: Object,
  receivedOrders: Object,
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
  <Head title="My Orders" />

  <AppLayout>
    <div
      class="container mx-auto mt-48 mb-10 flex flex-col items-center min-h-[500px] w-full p-5"
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
            <a
              href="#"
              class="inline-flex p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group"
              id="orders-tab"
              data-tabs-target="#orders"
              type="button"
              role="tab"
              aria-controls="orders"
              aria-selected="false"
            >
              <i class="fa-solid fa-boxes-packing mr-2 text-sm"></i>
              All Orders ({{ orders.length }})
            </a>
          </li>
          <li class="mr-2" role="presentation">
            <a
              href="#"
              class="inline-flex p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group"
              aria-current="page"
              id="toPay-tab"
              data-tabs-target="#toPay"
              type="button"
              role="tab"
              aria-controls="toPay"
              aria-selected="false"
            >
              <i class="fa-solid fa-money-bill-wave mr-2 text-sm"></i>
              To Pay ({{ toPayOrders.length }})
            </a>
          </li>
          <li class="mr-2" role="presentation">
            <a
              href="#"
              class="inline-flex p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group"
              id="toReceive-tab"
              data-tabs-target="#toReceive"
              type="button"
              role="tab"
              aria-controls="toReceive"
              aria-selected="false"
            >
              <i class="fa-solid fa-boxes-stacked mr-2 text-sm"></i>
              To Receive ({{ toReceiveOrders.length }})
            </a>
          </li>
          <li class="mr-2" role="presentation">
            <a
              href="#"
              class="inline-flex p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group"
              id="received-tab"
              data-tabs-target="#received"
              type="button"
              role="tab"
              aria-controls="received"
              aria-selected="false"
            >
              <i class="fa-solid fa-handshake text-sm mr-2"></i>

              Received ({{ receivedOrders.length }})
            </a>
          </li>
        </ul>
      </div>

      <div id="myTabContet" class="w-full">
        <div
          class="hidden w-full"
          id="orders"
          role="tabpanel"
          aria-labelledby="orders-tab"
        >
          <TableContainer class="w-full my-5">
            <TableHeader>
              <HeaderTh> No </HeaderTh>
              <HeaderTh> Invoice </HeaderTh>
              <HeaderTh> Payment </HeaderTh>
              <HeaderTh> Amount </HeaderTh>
              <HeaderTh> Status </HeaderTh>
              <HeaderTh> Date </HeaderTh>
              <HeaderTh> Actions </HeaderTh>
            </TableHeader>

            <tbody v-if="orders.length">
              <Tr v-for="order in orders" :key="order.id">
                <BodyTh>{{ order.id }}</BodyTh>
                <Td>{{ order.invoice_no }}</Td>
                <Td class="capitalize">{{ order.payment_type }}</Td>
                <Td>$ {{ order.total_amount }}</Td>
                <Td>
                  <PendingStatus v-if="order.status === 'pending'">
                    {{ order.status }}
                  </PendingStatus>
                  <ConfirmedStatus v-else-if="order.status === 'confirmed'">
                    {{ order.status }}
                  </ConfirmedStatus>
                  <ProcessingStatus v-else-if="order.status === 'processing'">
                    {{ order.status }}
                  </ProcessingStatus>
                  <ShippedStatus v-else-if="order.status === 'shipped'">
                    {{ order.status }}
                  </ShippedStatus>
                  <DeliveredStatus v-else-if="order.status === 'delivered'">
                    {{ order.status }}
                  </DeliveredStatus>

                  <span
                    class="text-red-600 font-bold text-sm bg-red-300 px-3 py-1 rounded-full ml-2 animate-pulse"
                  >
                    Return
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
        </div>
        <div
          class="hidden w-full"
          id="toPay"
          role="tabpanel"
          aria-labelledby="toPay-tab"
        >
          <TableContainer class="w-full my-5">
            <TableHeader>
              <HeaderTh> No </HeaderTh>
              <HeaderTh> Invoice </HeaderTh>
              <HeaderTh> Payment </HeaderTh>
              <HeaderTh> Amount </HeaderTh>
              <HeaderTh> Status </HeaderTh>
              <HeaderTh> Date </HeaderTh>
              <HeaderTh> Actions </HeaderTh>
            </TableHeader>

            <tbody v-if="toPayOrders.length">
              <Tr v-for="order in toPayOrders" :key="order.id">
                <BodyTh>{{ order.id }}</BodyTh>
                <Td>{{ order.invoice_no }}</Td>
                <Td class="capitalize">{{ order.payment_type }}</Td>
                <Td>$ {{ order.total_amount }}</Td>
                <Td>
                  <PendingStatus v-if="order.status === 'pending'">
                    {{ order.status }}
                  </PendingStatus>
                  <ConfirmedStatus v-else-if="order.status === 'confirm'">
                    {{ order.status }}
                  </ConfirmedStatus>
                  <ProcessingStatus v-else-if="order.status === 'processing'">
                    {{ order.status }}
                  </ProcessingStatus>
                  <ShippedStatus v-else-if="order.status === 'shipped'">
                    {{ order.status }}
                  </ShippedStatus>
                  <DeliveredStatus v-else-if="order.status === 'delivered'">
                    {{ order.status }}
                  </DeliveredStatus>
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
        </div>

        <div
          class="hidden w-full"
          id="toReceive"
          role="tabpanel"
          aria-labelledby="toReceive-tab"
        >
          <TableContainer class="w-full my-5">
            <TableHeader>
              <HeaderTh> No </HeaderTh>
              <HeaderTh> Invoice </HeaderTh>
              <HeaderTh> Payment </HeaderTh>
              <HeaderTh> Amount </HeaderTh>
              <HeaderTh> Status </HeaderTh>
              <HeaderTh> Date </HeaderTh>
              <HeaderTh> Actions </HeaderTh>
            </TableHeader>

            <tbody v-if="toReceiveOrders.length">
              <Tr v-for="order in toReceiveOrders" :key="order.id">
                <BodyTh>{{ order.id }}</BodyTh>
                <Td>{{ order.invoice_no }}</Td>
                <Td class="capitalize">{{ order.payment_type }}</Td>
                <Td>$ {{ order.total_amount }}</Td>
                <Td>
                  <PendingStatus v-if="order.status === 'pending'">
                    {{ order.status }}
                  </PendingStatus>
                  <ConfirmedStatus v-else-if="order.status === 'confirm'">
                    {{ order.status }}
                  </ConfirmedStatus>
                  <ProcessingStatus v-else-if="order.status === 'processing'">
                    {{ order.status }}
                  </ProcessingStatus>
                  <ShippedStatus v-else-if="order.status === 'shipped'">
                    {{ order.status }}
                  </ShippedStatus>
                  <DeliveredStatus v-else-if="order.status === 'delivered'">
                    {{ order.status }}
                  </DeliveredStatus>
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
        </div>

        <div
          class="hidden w-full"
          id="received"
          role="tabpanel"
          aria-labelledby="received-tab"
        >
          <TableContainer class="w-full my-5">
            <TableHeader>
              <HeaderTh> No </HeaderTh>
              <HeaderTh> Invoice </HeaderTh>
              <HeaderTh> Payment </HeaderTh>
              <HeaderTh> Amount </HeaderTh>
              <HeaderTh> Status </HeaderTh>
              <HeaderTh> Date </HeaderTh>
              <HeaderTh> Actions </HeaderTh>
            </TableHeader>

            <tbody v-if="receivedOrders.length">
              <Tr v-for="order in receivedOrders" :key="order.id">
                <BodyTh>{{ order.id }}</BodyTh>
                <Td>{{ order.invoice_no }}</Td>
                <Td class="capitalize">{{ order.payment_type }}</Td>
                <Td>$ {{ order.total_amount }}</Td>
                <Td>
                  <PendingStatus v-if="order.status === 'pending'">
                    {{ order.status }}
                  </PendingStatus>
                  <ConfirmedStatus v-else-if="order.status === 'confirm'">
                    {{ order.status }}
                  </ConfirmedStatus>
                  <ProcessingStatus v-else-if="order.status === 'processing'">
                    {{ order.status }}
                  </ProcessingStatus>
                  <ShippedStatus v-else-if="order.status === 'shipped'">
                    {{ order.status }}
                  </ShippedStatus>
                  <DeliveredStatus v-else-if="order.status === 'delivered'">
                    {{ order.status }}
                  </DeliveredStatus>
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
        </div>
      </div>
    </div>
  </AppLayout>
</template>
