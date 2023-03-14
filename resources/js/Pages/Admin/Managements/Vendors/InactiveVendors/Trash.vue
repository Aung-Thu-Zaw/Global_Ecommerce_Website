
<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/VendorManage/Breadcrumb.vue";
import SearchForm from "@/Components/Form/SearchForm.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import InactiveStatus from "@/Components/Table/InactiveStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Pagination from "@/Components/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, Head } from "@inertiajs/vue3";
import { inject } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

defineProps({
  inactiveTrashVendors: Array,
});

const swal = inject("$swal");

const handleRestore = async (id) => {
  const result = await swal({
    icon: "info",
    title: "Are you sure you want to restore this vendor?",
    showCancelButton: true,
    confirmButtonText: "Yes, restore!",
    confirmButtonColor: "#027e00",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(route("admin.vendors.inactive.restore", id));
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
  }
};

const handleDelete = async (id) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete it from the trash?",
    text: "You will not be able to revert this action!",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(route("admin.vendors.inactive.forceDelete", id));
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
    <Head title="Inactive Vendors Trash" />

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
                >Inactive Vendor</span
              >
            </div>
          </li>
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
                >Trash</span
              >
            </div>
          </li>
        </Breadcrumb>

        <div>
          <Link
            :href="route('admin.vendors.inactive.index')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <!-- Search Input Form -->
      <SearchForm />

      <TableContainer>
        <TableHeader>
          <HeaderTh> No# </HeaderTh>
          <HeaderTh> Shop Name </HeaderTh>
          <HeaderTh> Username </HeaderTh>
          <HeaderTh> Email Address </HeaderTh>
          <HeaderTh> Status </HeaderTh>
          <HeaderTh> Date </HeaderTh>
          <HeaderTh> Action </HeaderTh>
        </TableHeader>

        <tbody v-if="inactiveTrashVendors.data.length">
          <Tr
            v-for="inactiveTrashVendor in inactiveTrashVendors.data"
            :key="inactiveTrashVendor.id"
          >
            <BodyTh>{{ inactiveTrashVendor.id }}</BodyTh>
            <Td>{{ inactiveTrashVendor.shop_name }}</Td>
            <Td>{{ inactiveTrashVendor.name }}</Td>
            <Td>{{ inactiveTrashVendor.email }}</Td>
            <Td>
              <InactiveStatus>
                {{ inactiveTrashVendor.status }}
              </InactiveStatus>
            </Td>
            <Td>{{ inactiveTrashVendor.created_at }}</Td>
            <Td>
              <button
                @click="handleRestore(inactiveTrashVendor.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 mr-3 my-1"
              >
                <i class="fa-solid fa-recycle"></i>
                Restore
              </button>
              <button
                @click="handleDelete(inactiveTrashVendor.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
              >
                <i class="fa-solid fa-trash"></i>
                Delete Forever
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <!-- Not Avaliable Data -->
      <NotAvaliableData v-if="!inactiveTrashVendors.data.length" />

      <!-- Pagination -->
      <pagination class="mt-6" :links="inactiveTrashVendors.links" />
    </div>
  </AdminDashboardLayout>
</template>

