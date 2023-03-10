<template>
  <AdminDashboardLayout>
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <!-- Breadcrumb start -->

      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb start -->

        <nav class="flex text-md" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
              <a
                href="#"
                class="inline-flex items-center font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
              >
                <svg
                  aria-hidden="true"
                  class="w-4 h-4 mr-2"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                  ></path>
                </svg>
                Dashboard
              </a>
            </li>
            <li>
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
                  class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400 dark:hover:text-white"
                  >Vendor Manage</span
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
          </ol>
        </nav>

        <!-- Breadcrumb end -->

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

      <!-- Breadcrumb end -->

      <div class="relative overflow-x-auto shadow-md">
        <table
          class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border"
        >
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-3">ID #</th>
              <th scope="col" class="px-6 py-3">Shop Name</th>
              <th scope="col" class="px-6 py-3">Username</th>
              <th scope="col" class="px-6 py-3">Email Address</th>
              <th scope="col" class="px-6 py-3">Status</th>
              <th scope="col" class="px-6 py-3">Date</th>
              <th scope="col" class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="inactiveTrashVendor in inactiveTrashVendors"
              :key="inactiveTrashVendor.id"
              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
            >
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                {{ inactiveTrashVendor.id }}
              </th>
              <td class="px-6 py-4">{{ inactiveTrashVendor.shop_name }}</td>
              <td class="px-6 py-4">{{ inactiveTrashVendor.name }}</td>
              <td class="px-6 py-4">{{ inactiveTrashVendor.email }}</td>
              <td class="px-6 py-4">
                <div
                  class="w-[80px] p-1 bg-red-300 rounded-xl flex items-center"
                >
                  <div class="flex items-center justify-center px-1">
                    <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-1"></div>
                    <span class="text-white">
                      {{ inactiveTrashVendor.status }}</span
                    >
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">{{ inactiveTrashVendor.created_at }}</td>
              <td class="px-6 py-4 flex flex-wrap">
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
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminDashboardLayout>
</template>

<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link } from "@inertiajs/vue3";
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

  <style>
</style>
