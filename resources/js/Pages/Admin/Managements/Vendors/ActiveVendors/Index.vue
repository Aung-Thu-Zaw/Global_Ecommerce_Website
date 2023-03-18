<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/VendorManage/Breadcrumb.vue";
import SearchForm from "@/Components/Form/SearchForm.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import ActiveStatus from "@/Components/Table/ActiveStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Pagination from "@/Components/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import { reactive, watch, inject } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

defineProps({
  activeVendors: Object,
});

const params = reactive({
  search: null,
  per_page: 10,
});

const handleSearchBox = () => {
  params.search = "";
};

watch(
  () => params.search,
  (current, previous) => {
    router.get(
      "/admin/managements/active-vendors",
      { search: params.search },
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
      "/admin/managements/active-vendors",
      { per_page: params.per_page },
      {
        replace: true,
        preserveState: true,
      }
    );
  }
);

const swal = inject("$swal");

const handleInactive = async (id) => {
  const result = await swal({
    icon: "info",
    title: "Are you sure you want to inactive this vendor?",
    showCancelButton: true,
    confirmButtonText: "Yes, inactive!",
    confirmButtonColor: "#027e00",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(route("admin.vendors.active.update", id));
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
  }
};
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Active Vendors" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Vendor Breadcrumb -->
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
            <span class="ml-1 font-medium text-gray-500 md:ml-2"
              >Active Vendor</span
            >
          </div>
        </li>
      </Breadcrumb>

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

      <!-- Table  -->
      <TableContainer>
        <TableHeader>
          <HeaderTh>
            No
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
            ></i>
          </HeaderTh>
          <HeaderTh>
            Username
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
            ></i>
          </HeaderTh>
          <HeaderTh>
            Email Address
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
            ></i>
          </HeaderTh>
          <HeaderTh>
            Status
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
            ></i>
          </HeaderTh>
          <HeaderTh>
            Created At
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
            ></i>
          </HeaderTh>
          <HeaderTh> Action </HeaderTh>
        </TableHeader>

        <tbody v-if="activeVendors.data.length">
          <Tr v-for="activeVendor in activeVendors.data" :key="activeVendor.id">
            <BodyTh>{{ activeVendor.id }}</BodyTh>
            <Td>{{ activeVendor.name }}</Td>
            <Td>{{ activeVendor.email }}</Td>
            <Td>
              <ActiveStatus> {{ activeVendor.status }} </ActiveStatus>
            </Td>
            <Td>{{ activeVendor.created_at }}</Td>
            <Td>
              <button
                @click="handleInactive(activeVendor.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3"
              >
                <i class="fa-solid fa-xmark"></i>
                Inactive
              </button>
              <Link
                as="button"
                :href="route('admin.vendors.active.show', activeVendor.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700"
              >
                <i class="fa-solid fa-circle-info"></i>
                See Details
              </Link>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <!-- Not Avaliable Data -->
      <NotAvaliableData v-if="!activeVendors.data.length" />

      <!-- Pagination -->
      <pagination class="mt-6" :links="activeVendors.links" />
    </div>
  </AdminDashboardLayout>
</template>

