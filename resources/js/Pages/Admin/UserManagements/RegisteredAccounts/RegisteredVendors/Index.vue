<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/RegisteredAccountBreadcrumb.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import InactiveStatus from "@/Components/Status/InactiveStatus.vue";
import RoleStatus from "@/Components/Status/RoleStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Head, Link, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  vendors: Object,
});

// Define Alert Variables
const swal = inject("$swal");

// Vendor Activity Status
const currentTime = new Date();
const threshold = 1000 * 60 * 5; //5minutes in millseconds

const status = (last_activity) => {
  const lastActivity = new Date(last_activity);
  const timeDifference = currentTime.getTime() - lastActivity.getTime();

  return timeDifference < threshold ? "active" : "offline";
};

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
    route("admin.vendors.registered.index"),
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
    route("admin.vendors.registered.index"),
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
    route("admin.vendors.registered.index"),
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

// Handle Vendor Delete
const handleDeleteRegisteredVendor = async (vendor) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to delete this vendor?",
    text: "You will be able to restore this vendor in the trash!",
    showCancelButton: true,
    confirmButtonText: "Yes, Delete it!",
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.vendors.registered.destroy", {
        user: vendor,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
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

// Registered Account Detail Permission
const registeredAccountDetail = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "registered-account.detail"
      )
    : false;
});

// Registered Account Delete Permission
const registeredAccountDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "registered-account.delete"
      )
    : false;
});

// Registered Account Trash List Permission
const registeredAccountTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "registered-account.trash.list"
      )
    : false;
});
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Registered Vendors" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
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
              <span class="ml-1 font-medium text-gray-500 md:ml-2"
                >Registered Vendors</span
              >
            </div>
          </li>
        </Breadcrumb>

        <div v-if="registeredAccountTrashList">
          <Link
            as="button"
            :href="route('admin.vendors.registered.trash')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
            class="trash-btn group"
          >
            <span class="group-hover:animate-pulse">
              <i class="fa-solid fa-trash-can-arrow-up"></i>
              Trash
            </span>
          </Link>
        </div>
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Box -->
        <form class="w-[350px] relative">
          <input
            type="text"
            class="search-input"
            placeholder="Search by name"
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

      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh>Avatar</HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            Name
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('email')">
            Email Address
            <SortingArrows :params="params" sort="email" />
          </HeaderTh>

          <HeaderTh> Role </HeaderTh>

          <HeaderTh> Status </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="registeredAccountDelete || registeredAccountDetail">
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="vendors.data.length">
          <Tr v-for="vendor in vendors.data" :key="vendor.id">
            <BodyTh>
              {{ vendor.id }}
            </BodyTh>

            <Td>
              <img
                :src="vendor.avatar"
                alt=""
                class="h-[50px] w-[50px] ring-2 ring-slate-300 object-cover rounded-full"
              />
            </Td>

            <Td>
              {{ vendor.name }}
            </Td>

            <Td>
              {{ vendor.email }}
            </Td>

            <Td>
              <RoleStatus>
                {{ vendor.role }}
              </RoleStatus>
            </Td>

            <Td>
              <ActiveStatus v-if="status(vendor.last_activity) == 'active'">
                {{ status(vendor.last_activity) }}
              </ActiveStatus>

              <InactiveStatus v-if="status(vendor.last_activity) == 'offline'">
                {{ status(vendor.last_activity) }}
              </InactiveStatus>
            </Td>

            <Td>
              {{ vendor.created_at }}
            </Td>

            <Td v-if="registeredAccountDelete || registeredAccountDetail">
              <!-- Delete Button -->
              <button
                v-if="registeredAccountDelete"
                @click="handleDeleteRegisteredVendor(vendor.id)"
                class="delete-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-trash-can"></i>
                  Delete
                </span>
              </button>

              <!-- Detail Button -->
              <Link
                v-if="registeredAccountDetail"
                as="button"
                :href="route('admin.vendors.registered.show', vendor.id)"
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
      <!-- User Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!vendors.data.length" />

      <div v-if="vendors.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ vendors.from }} - {{ vendors.to }} of
          {{ vendors.total }}
        </p>
        <Pagination :links="vendors.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

