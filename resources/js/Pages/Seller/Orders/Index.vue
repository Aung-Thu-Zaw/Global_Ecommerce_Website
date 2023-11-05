<script setup>
import SellerDashboardLayout from "@/Layouts/SellerDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/OrderManageBreadcrumb.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByCreatedDate from "@/Components/Forms/DashboardFilterByCreatedDate.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import { reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

const props = defineProps({
  orderItems: Object,
});

// Query String Parameteres
const params = reactive({
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
});

// Update Sorting Table Column
const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  router.get(
    route("seller.orders.index"),
    {
      search: usePage().props.ziggy.query?.search,
      page: usePage().props.ziggy.query?.page,
      per_page: usePage().props.ziggy.query?.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: usePage().props.ziggy.query?.created_from,
      created_until: usePage().props.ziggy.query?.created_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};
</script>


<template>
  <SellerDashboardLayout>
    <Head :title="__('ORDERS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Box -->
        <DashboardSearchInputForm
          href="seller.orders.index"
          placeholder="SEARCH_BY_INVOICE"
        />

        <!-- Perpage Select Box -->
        <div class="ml-5">
          <DashboardPerPageSelectBox href="seller.orders.index" />
        </div>

        <!-- Filter By Date -->
        <DashboardFilterByCreatedDate href="seller.orders.index" />
      </div>

      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('invoice_no')">
            {{ __("INVOICE") }}
            <SortingArrows :params="params" sort="invoice_no" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('payment_type')">
            {{ __("PAYMENT") }}
            <SortingArrows :params="params" sort="payment_type" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('total_amount')">
            {{ __("AMOUNT") }}
            <SortingArrows :params="params" sort="total_amount" />
          </HeaderTh>

          <HeaderTh> {{ __("ORDER_STATUS") }} </HeaderTh>

          <HeaderTh @click="updateSorting('order_date')">
            {{ __("ORDER_DATE") }}
            <SortingArrows :params="params" sort="order_date" />
          </HeaderTh>

          <HeaderTh> {{ __("ACTION") }} </HeaderTh>
        </TableHeader>

        <tbody v-if="orderItems.data.length">
          <Tr v-for="orderItem in orderItems.data" :key="orderItem.id">
            <BodyTh>
              {{ orderItem.order.id }}
            </BodyTh>

            <Td>
              {{ orderItem.order?.invoice_no }}
            </Td>

            <Td class="capitalize">
              {{ orderItem.order.payment_type }}
            </Td>

            <Td>$ {{ orderItem.order?.total_amount }}</Td>

            <Td>
              <PendingStatus v-if="orderItem.order.status === 'pending'">
                {{ orderItem.order.status }}
              </PendingStatus>
              <ConfirmedStatus v-if="orderItem.order.status === 'confirmed'">
                {{ orderItem.order.status }}
              </ConfirmedStatus>
              <ProcessingStatus v-if="orderItem.order.status === 'processing'">
                {{ orderItem.order.status }}
              </ProcessingStatus>
              <ShippedStatus v-if="orderItem.order.status === 'shipped'">
                {{ orderItem.order.status }}
              </ShippedStatus>
              <DeliveredStatus v-if="orderItem.order.status === 'delivered'">
                {{ orderItem.order.status }}
              </DeliveredStatus>
            </Td>

            <Td>{{ orderItem.order.order_date }}</Td>

            <Td>
              <div>
                <DetailButton href="seller.orders.show" :id="product.id" />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <NotAvaliableData v-if="!orderItems.data.length" />

      <Pagination class="mt-6" :links="orderItems.links" />
    </div>
  </SellerDashboardLayout>
</template>

