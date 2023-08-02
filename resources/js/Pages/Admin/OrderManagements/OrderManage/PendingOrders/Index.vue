<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/OrderManageBreadcrumb.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, Head, router, usePage } from "@inertiajs/vue3";
import { reactive, watch, computed } from "vue";

// Define the props
const props = defineProps({
  pendingOrders: Object,
});

// Query String Parameteres
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  page: usePage().props.ziggy.query?.page,
  per_page: usePage().props.ziggy.query?.per_page,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
});

// Handle Search
const handleSearch = () => {
  router.get(
    route("admin.orders.pending.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Remove Search Param
const removeSearch = () => {
  params.search = "";
  router.get(
    route("admin.orders.pending.index"),
    {
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Handle Query String Parameter
const handleQueryStringParameter = () => {
  router.get(
    route("admin.orders.pending.index"),
    {
      search: params.search,
      page: params.page,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Watching Search Box
watch(
  () => params.search,
  () => {
    if (params.search === "") {
      removeSearch();
    } else {
      handleSearch();
    }
  }
);

// Watching Perpage Select Box
watch(
  () => params.per_page,
  () => {
    handleQueryStringParameter();
  }
);

// Update Sorting Table Column
const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  handleQueryStringParameter();
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

const orderManageDetail = computed(() => {
  return usePage().props.auth.user.permissions.length
    ? usePage().props.auth.user.permissions.some(
        (permission) => permission.name === "order-manage.detail"
      )
    : false;
});
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Pending Orders" />

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
                >Pending Orders</span
              >
            </div>
          </li>
        </Breadcrumb>
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Box -->
        <form class="w-[350px] relative">
          <input
            type="text"
            class="search-input"
            placeholder="Search by invoice"
            v-model="params.search"
          />
          <i
            v-if="params.search"
            class="fa-solid fa-xmark remove-search"
            @click="removeSearch"
          ></i>
        </form>

        <!-- Perpage Select Box -->
        <div class="ml-5">
          <select class="perpage-selectbox" v-model="params.per_page">
            <option value="" disabled>Select</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>

      <!-- Pending Order Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('invoice_no')">
            Invoice
            <SortingArrows :params="params" sort="invoice_no" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('payment_type')">
            Payment
            <SortingArrows :params="params" sort="payment_type" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('total_amount')">
            Amount
            <SortingArrows :params="params" sort="total_amount" />
          </HeaderTh>

          <HeaderTh> Order Status </HeaderTh>

          <HeaderTh @click="updateSorting('order_date')">
            Order Date
            <SortingArrows :params="params" sort="order_date" />
          </HeaderTh>

          <HeaderTh v-if="orderManageDetail"> Action </HeaderTh>
        </TableHeader>

        <tbody v-if="pendingOrders.data.length">
          <Tr v-for="pendingOrder in pendingOrders.data" :key="pendingOrder.id">
            <BodyTh>
              {{ pendingOrder.id }}
            </BodyTh>

            <Td>
              {{ pendingOrder.invoice_no }}
            </Td>

            <Td class="capitalize">
              {{ pendingOrder.payment_type }}
            </Td>

            <Td> $ {{ formattedAmount(pendingOrder.total_amount) }} </Td>

            <Td>
              <PendingStatus>
                {{ pendingOrder.order_status }}
              </PendingStatus>
            </Td>

            <Td>
              {{ pendingOrder.order_date }}
            </Td>

            <Td v-if="orderManageDetail">
              <!-- Detail Button -->
              <Link
                v-if="orderManageDetail"
                as="button"
                :href="route('admin.orders.pending.show', pendingOrder.id)"
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                  sort: params.sort,
                  direction: params.direction,
                }"
                class="detail-btn group"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-eye"></i>
                  Details
                </span>
              </Link>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Pending Order Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!pendingOrders.data.length" />

      <!-- Pagination -->
      <div v-if="pendingOrders.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ pendingOrders.from }} - {{ pendingOrders.to }} of
          {{ pendingOrders.total }}
        </p>
        <Pagination :links="pendingOrders.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

