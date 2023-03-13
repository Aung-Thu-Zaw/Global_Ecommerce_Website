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
          </ol>
        </nav>

        <!-- Breadcrumb end -->

        <div>
          <Link
            as="button"
            :href="route('admin.vendors.inactive.trash')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700"
          >
            <i class="fa-solid fa-trash"></i>

            Trash
          </Link>
        </div>
      </div>

      <!-- Breadcrumb end -->

      <div class="mb-5 flex items-center justify-end">
        <form class="w-[350px]">
          <input
            type="text"
            class="rounded-md border-2 border-slate-300 text-sm p-3 w-full"
            placeholder="Search"
            v-model="params.search"
          />
        </form>
      </div>

      <div class="relative overflow-x-auto shadow-md">
        <table
          class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border"
        >
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-3">
                <span class="mr-1">NO</span>
                <i
                  class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
                ></i>
                <i
                  class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
                ></i>
              </th>
              <th scope="col" class="px-6 py-3">
                <span class="mr-1">Username</span>
                <i
                  class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
                ></i>
                <i
                  class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
                ></i>
              </th>
              <th scope="col" class="px-6 py-3">
                <span class="mr-1">Email Address</span>
                <i
                  class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
                ></i>
                <i
                  class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
                ></i>
              </th>
              <th scope="col" class="px-6 py-3">
                <span class="mr-1">Status</span>
                <i
                  class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
                ></i>
                <i
                  class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
                ></i>
              </th>
              <th scope="col" class="px-6 py-3">
                <span class="mr-1">Date</span>
                <i
                  class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
                ></i>
                <i
                  class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
                ></i>
              </th>
              <th scope="col" class="px-6 py-3">
                <span class="mr-1">Action</span>
                <i
                  class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
                ></i>
                <i
                  class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
                ></i>
              </th>
            </tr>
          </thead>
          <tbody v-if="inactiveVendors.data.length">
            <tr
              v-for="(inactiveVendor, index) in inactiveVendors.data"
              :key="inactiveVendor.id"
              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
            >
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                {{ index + 1 }}
              </th>
              <td class="px-6 py-4">{{ inactiveVendor.name }}</td>
              <td class="px-6 py-4">{{ inactiveVendor.email }}</td>
              <td class="px-6 py-4">
                <div class="flex items-center px-1">
                  <div class="h-2.5 w-2.5 rounded-full bg-red-600 mr-1"></div>
                  {{ inactiveVendor.status }}
                </div>
              </td>
              <td class="px-6 py-4">{{ inactiveVendor.created_at }}</td>
              <td class="px-6 py-4 flex flex-wrap">
                <button
                  @click="handleActive(inactiveVendor.id)"
                  class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-green-600 text-white hover:bg-green-700 mr-3 my-1"
                >
                  <i class="fa-solid fa-check"></i>
                  Active
                </button>

                <button
                  @click="handleRemove(inactiveVendor.id)"
                  class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
                >
                  <i class="fa-solid fa-minus"></i>
                  Remove
                </button>
                <Link
                  as="button"
                  :href="
                    route('admin.vendors.inactive.show', inactiveVendor.id)
                  "
                  class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 my-1"
                >
                  <i class="fa-solid fa-circle-info"></i>
                  See Details
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="!inactiveVendors.data.length" class="p-5 w-full">
          <p class="text-center text-sm uppercase text-slate-500 font-bold">
            Data is not avliable for this table
          </p>
        </div>
      </div>

      <div class="flex items-center justify-center">
        <pagination class="mt-6" :links="inactiveVendors.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

<script setup>
import Pagination from "@/Components/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { computed, inject, reactive, ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
defineProps({
  inactiveVendors: Object,
});

const swal = inject("$swal");
const params = reactive({
  search: null,
});
const handleActive = async (id) => {
  const result = await swal({
    icon: "info",
    title: "Are you sure you want to active this vendor?",
    showCancelButton: true,
    confirmButtonText: "Yes, active!",
    confirmButtonColor: "#027e00",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(route("admin.vendors.inactive.update", id));
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
  }
};

const handleRemove = async (id) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to move it to the trash?",
    text: "You will be able to revert this action!",
    showCancelButton: true,
    confirmButtonText: "Yes, remove it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(route("admin.vendors.inactive.softDelete", id));
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
  }
};

watch(
  () => params.search,
  (current, previous) => {
    router.get(
      "/admin/managements/inactive-vendors",
      { search: params.search },
      {
        replace: true,
        preserveState: true,
      }
    );
  }
);
</script>

<style>
</style>
