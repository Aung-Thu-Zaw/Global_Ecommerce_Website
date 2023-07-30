<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/VendorManageBreadcrumb.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  activeVendors: Object,
});

// Define Alert Variables
const swal = inject("$swal");

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
    route("admin.vendors.active.index"),
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
    route("admin.vendors.active.index"),
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
    route("admin.vendors.active.index"),
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

// Handle Vendor Inactive
const handleInactive = async (activeVendorId) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to inactive this vendor?",
    showCancelButton: true,
    confirmButtonText: "Yes, Inactive!",
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.vendors.active.update", {
        user: activeVendorId,
        status: "inactive",
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {},
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: usePage().props.flash.successMessage,
            });
          }
        },
      }
    );
  }
};

// Handle Offical Or UnOffical
const handleOffical = async (activeVendor) => {
  const result = await swal({
    icon: "question",
    title: `Are you sure you want to set ${
      activeVendor.offical ? "unoffical" : "offical"
    } this vendor?`,
    showCancelButton: true,
    confirmButtonText: `Yes, ${
      activeVendor.offical ? "unoffical" : "offical"
    }!`,
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.vendors.active.update", {
        user: activeVendor.id,
        offical: activeVendor.offical ? false : true,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {},
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: usePage().props.flash.successMessage,
            });
          }
        },
      }
    );
  }
};

// Define Permissions Variables
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Vendor Manage Control Permission
const vendorManageControl = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "vendor-manage.control"
      )
    : false;
});

// Vendor Manage Detail Permission
const vendorManageDetail = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "vendor-manage.detail"
      )
    : false;
});

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: usePage().props.flash.successMessage,
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Active Vendors" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
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
            <span class="ml-1 font-medium text-gray-500 md:ml-2"
              >Active Vendors</span
            >
          </div>
        </li>
      </Breadcrumb>

      <div class="flex items-center justify-end mb-5 ml-auto">
        <!-- Search Box -->
        <form class="w-[350px] relative">
          <input
            type="text"
            class="search-input"
            placeholder="Search by shop name"
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

      <!-- Active Vendor Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('shop_name')">
            Shop Name
            <SortingArrows :params="params" sort="shop_name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('email')">
            Email Address
            <SortingArrows :params="params" sort="email" />
          </HeaderTh>

          <HeaderTh> Status </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="vendorManageControl || vendorManageDetail">
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="activeVendors.data.length">
          <Tr v-for="activeVendor in activeVendors.data" :key="activeVendor.id">
            <BodyTh>
              {{ activeVendor.id }}
            </BodyTh>

            <Td>
              {{ activeVendor.shop_name }}

              <i
                v-if="activeVendor.offical"
                class="fas fa-check arrow-icon ml-1 bg-green-500 p-1 rounded-full text-white"
              ></i>
            </Td>
            <Td>
              {{ activeVendor.email }}
            </Td>

            <Td>
              <ActiveStatus>
                {{ activeVendor.status }}
              </ActiveStatus>
            </Td>

            <Td>
              {{ activeVendor.created_at }}
            </Td>

            <Td v-if="vendorManageControl || vendorManageDetail">
              <!-- Offical Button -->
              <button
                v-if="vendorManageControl"
                @click="handleOffical(activeVendor)"
                class="offical-btn group"
                type="button"
                :class="{
                  'bg-slate-600  hover:bg-slate-700 border-slate-700':
                    !activeVendor.offical,
                  'bg-emerald-600  hover:bg-emerald-700 border-emerald-700':
                    activeVendor.offical,
                }"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-award"></i>
                  {{ activeVendor.offical ? "Unoffical" : "Offical" }}
                </span>
              </button>

              <!-- Inactive Button -->
              <button
                v-if="vendorManageControl"
                @click="handleInactive(activeVendor.id)"
                class="delete-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-trash"></i>
                  Inactive
                </span>
              </button>

              <!-- Detail Button -->
              <Link
                v-if="vendorManageDetail"
                as="button"
                :href="route('admin.vendors.active.show', activeVendor.id)"
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
      <!-- Active Vendor Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!activeVendors.data.length" />

      <!-- Pagination -->
      <div v-if="activeVendors.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ activeVendors.from }} - {{ activeVendors.to }} of
          {{ activeVendors.total }}
        </p>
        <Pagination :links="activeVendors.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

