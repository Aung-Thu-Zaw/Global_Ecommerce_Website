<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ReturnOrderManageBreadcrumb.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import RequestedStatus from "@/Components/Status/RequestedStatus.vue";
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
import Pagination from "@/Components/Paginations/Pagination.vue";
import { __ } from "@/Translations/translations-inside-setup.js";
import { computed, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  requestedReturnOrders: Object,
});

// Return Order Detail Permission
const returnOrderManageDetail = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "return-order-manage.detail"
      )
    : false;
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
    route("admin.return-orders.requested.index"),
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

// Formatted Amount
const formattedAmount = (amount) => {
  const totalAmount = parseFloat(amount);
  if (Number.isInteger(totalAmount)) {
    return totalAmount.toFixed(0);
  } else {
    return totalAmount.toFixed(2);
  }
};
</script>


<template>
  <AdminDashboardLayout>
    <Head :title="__('REQUESTED_RETURN_ORDERS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb>
          <li aria-current="page">
            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-6 h-6 text-gray-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              <span
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                >{{ __("REQUESTED_RETURNS") }}</span
              >
            </div>
          </li>
        </Breadcrumb>
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Box -->
        <DashboardSearchInputForm
          href="admin.return-orders.requested.index"
          placeholder="SEARCH_BY_INVOICE"
        />

        <!-- Perpage Select Box -->
        <div class="ml-5">
          <DashboardPerPageSelectBox
            href="admin.return-orders.requested.index"
          />
        </div>

        <!-- Filter By Date -->
        <DashboardFilterByCreatedDate
          href="admin.return-orders.requested.index"
        />
      </div>

      <!-- Requested Order Table Start -->
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

          <HeaderTh> {{ __("RETURN_STATUS") }} </HeaderTh>

          <HeaderTh @click="updateSorting('return_date')">
            {{ __("RETURN_DATE") }}
            <SortingArrows :params="params" sort="return_date" />
          </HeaderTh>

          <HeaderTh v-if="returnOrderManageDetail">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="requestedReturnOrders.data.length">
          <Tr
            v-for="requestedReturnOrder in requestedReturnOrders.data"
            :key="requestedReturnOrder.id"
          >
            <BodyTh>
              {{ requestedReturnOrder.id }}
            </BodyTh>

            <Td>
              {{ requestedReturnOrder.invoice_no }}
            </Td>

            <Td class="capitalize">
              {{ requestedReturnOrder.payment_type }}
            </Td>

            <Td
              >$
              {{ formattedAmount(requestedReturnOrder.total_amount) }}
            </Td>

            <Td>
              <RequestedStatus>
                {{ requestedReturnOrder.return_status }}
              </RequestedStatus>
            </Td>

            <Td>
              {{ requestedReturnOrder.return_date }}
            </Td>

            <Td v-if="returnOrderManageDetail">
              <!-- Detail Button -->
              <div>
                <DetailButton
                  href="admin.return-orders.requested.show"
                  :id="requestedReturnOrder.id"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Requested Order Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!requestedReturnOrders.data.length" />

      <!-- Pagination -->
      <div v-if="requestedReturnOrders.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ requestedReturnOrders.from }} -
          {{ requestedReturnOrders.to }} of
          {{ requestedReturnOrders.total }}
        </p>
        <Pagination :links="requestedReturnOrders.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

