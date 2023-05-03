<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/OrderManage/Breadcrumb.vue";
import SearchForm from "@/Components/Form/SearchForm.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import PendingStatus from "@/Components/Table/PendingStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Pagination from "@/Components/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, usePage, Head } from "@inertiajs/vue3";
import { computed, inject, reactive, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({
  pendingOrders: Object,
});

const swal = inject("$swal");
const params = reactive({
  search: null,
  page: props.pendingOrders.current_page ? props.pendingOrders.current_page : 1,
  per_page: props.pendingOrders.per_page ? props.pendingOrders.per_page : 10,
  sort: "id",
  direction: "desc",
});
const handleSearchBox = () => {
  params.search = "";
};

watch(
  () => params.search,
  (current, previous) => {
    router.get(
      "/admin/order-manage/pending-orders",
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
  }
);

watch(
  () => params.per_page,
  (current, previous) => {
    router.get(
      "/admin/order-manage/pending-orders",
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
  }
);

const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  router.get(
    "/admin/order-manage/pending-orders",
    {
      search: params.search,
      page: params.page,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    { replace: true, preserveState: true }
  );
};

// const handleActive = async (inactiveVendorId) => {
//   const result = await swal({
//     icon: "info",
//     title: "Are you sure you want to active this vendor?",
//     showCancelButton: true,
//     confirmButtonText: "Yes, active!",
//     confirmButtonColor: "#027e00",
//     timer: 20000,
//     timerProgressBar: true,
//     reverseButtons: true,
//   });

//   if (result.isConfirmed) {
//     router.post(
//       route("admin.vendors.inactive.update", {
//         id: inactiveVendorId,
//         page: props.inactiveVendors.current_page,
//         per_page: params.per_page,
//       })
//     );
//     setTimeout(() => {
//       swal({
//         icon: "success",
//         title: usePage().props.flash.successMessage,
//       });
//     }, 500);
//   }
// };

// const handleDelete = async (inactiveVendorId) => {
//   const result = await swal({
//     icon: "warning",
//     title: "Are you sure you want to move it to the trash?",
//     text: "You will be able to revert this action!",
//     showCancelButton: true,
//     confirmButtonText: "Yes, remove it!",
//     confirmButtonColor: "#ef4444",
//     timer: 20000,
//     timerProgressBar: true,
//     reverseButtons: true,
//   });

//   if (result.isConfirmed) {
//     router.delete(
//       route("admin.vendors.inactive.destroy", {
//         id: inactiveVendorId,
//         page: props.inactiveVendors.current_page,
//         per_page: params.per_page,
//       })
//     );
//     setTimeout(() => {
//       swal({
//         icon: "success",
//         title: usePage().props.flash.successMessage,
//       });
//     }, 500);
//   }
// };
</script>


<template>
  <AdminDashboardLayout>
    <Head title="Pending Orders" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Vendor Breadcrumb -->
      <div class="flex items-center justify-between mb-10">
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

        <!-- <div>
          <Link
            as="button"
            :href="route('admin.vendors.inactive.trash')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700"
          >
            <i class="fa-solid fa-trash"></i>

            Trash
          </Link>
        </div> -->
      </div>

      <!-- Search Input Form -->
      <div class="flex items-center justify-end mb-5">
        <form class="w-[350px] relative">
          <input
            type="text"
            class="rounded-md border-2 border-slate-300 text-sm p-3 w-full"
            placeholder="Search"
            v-model="params.search"
          />

          <i
            v-if="params.search"
            class="fa-solid fa-xmark absolute top-4 right-5 text-slate-600 cursor-pointer"
            @click="handleSearchBox"
          ></i>
        </form>

        <div class="ml-5">
          <select
            class="py-3 w-[80px] border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
            v-model="params.per_page"
          >
            <option value="" selected disabled>Select</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>

      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'id',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'id',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'id',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'id',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('invoice_no')">
            Invoice
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'invoice_no',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'invoice_no',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'invoice_no',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'invoice_no',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('payment_type')">
            Payment
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'payment_type',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'payment_type',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'payment_type',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'payment_type',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('total_amount')">
            Amount
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'total_amount',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'total_amount',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'total_amount',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'total_amount',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh> Status </HeaderTh>
          <HeaderTh @click="updateSorting('order_date')">
            Date
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'order_date',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'order_date',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'order_date',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'order_date',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh> Action </HeaderTh>
        </TableHeader>

        <tbody v-if="pendingOrders.data.length">
          <Tr v-for="pendingOrder in pendingOrders.data" :key="pendingOrder.id">
            <BodyTh>{{ pendingOrder.id }}</BodyTh>
            <Td>{{ pendingOrder.invoice_no }}</Td>
            <Td class="capitalize">{{ pendingOrder.payment_type }}</Td>
            <Td>$ {{ pendingOrder.total_amount }}</Td>
            <Td>
              <PendingStatus>
                {{ pendingOrder.status }}
              </PendingStatus>
            </Td>
            <Td>{{ pendingOrder.order_date }}</Td>

            <Td>
              <!-- <button
                @click="handleActive(pendingOrder.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-green-600 text-white hover:bg-green-700 mr-3 my-1"
              >
                <i class="fa-solid fa-check"></i>
                Active
              </button>

              <button
                @click="handleDelete(pendingOrder.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
              >
                <i class="fa-solid fa-minus"></i>
                Remove
              </button>
              <Link
                as="button"
                :href="route('admin.vendors.inactive.show', pendingOrder.id)"
                :data="{
                  page: props.pendingOrders.current_page,
                  per_page: params.per_page,
                }"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-emerald-600 text-white hover:bg-emerald-700 my-1"
              >
                <i class="fa-solid fa-eye"></i>
                Details
              </Link> -->
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <!-- Not Avaliable Data -->
      <NotAvaliableData v-if="!pendingOrders.data.length" />

      <!-- Pagination -->
      <pagination class="mt-6" :links="pendingOrders.links" />
    </div>
  </AdminDashboardLayout>
</template>

