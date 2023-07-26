<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/RoleInPermissionBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  rolesWithPermissions: Object,
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
    route("admin.role-in-permissions.index"),
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
    route("admin.role-in-permissions.index"),
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
    route("admin.role-in-permissions.index"),
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

// Handle Delete Role In Permissions
const handleDeleteRoleInPermissions = async (role) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to delete this role in permissions?",
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
      route("admin.role-in-permissions.destroy", {
        role: role,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {
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

// Create New RoleInPermissions Permission
const roleInPermissionsAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "role-in-permissions.add"
      )
    : false;
});

// RoleInPermissions Edit Permission
const roleInPermissionsEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "role-in-permissions.edit"
      )
    : false;
});

// RoleInPermissions Delete Permission
const roleInPermissionsDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "role-in-permissions.delete"
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
    <Head title="Role In Permissions" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Role In Permissions Button -->
        <Link
          v-if="roleInPermissionsAdd"
          as="button"
          :href="route('admin.role-in-permissions.create')"
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

        <div class="flex items-center">
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
      </div>

      <!-- RoleInPermissions Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            Role Name
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh>Permissions</HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="roleInPermissionsEdit || roleInPermissionsDelete">
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="rolesWithPermissions.data.length">
          <Tr
            v-for="roleWithPermissions in rolesWithPermissions.data"
            :key="roleWithPermissions.id"
          >
            <BodyTh v-if="roleWithPermissions.permissions.length">
              {{ roleWithPermissions.id }}
            </BodyTh>

            <Td v-if="roleWithPermissions.permissions.length">
              {{ roleWithPermissions.name }}
            </Td>

            <Td
              v-if="roleWithPermissions.permissions.length"
              class="w-[1000px] flex items-start"
            >
              <span
                v-for="permission in roleWithPermissions.permissions"
                :key="permission.id"
                class="bg-blue-700 text-white rounded-full px-3 py-1 mr-3 my-2"
              >
                {{ permission.name }}
              </span>
            </Td>

            <Td v-if="roleWithPermissions.permissions.length">
              {{ roleWithPermissions.created_at }}
            </Td>

            <Td
              v-if="
                roleWithPermissions.permissions.length &&
                (roleInPermissionsEdit || roleInPermissionsDelete)
              "
            >
              <!-- Edit Button -->
              <Link
                v-if="roleInPermissionsEdit"
                as="button"
                :href="
                  route(
                    'admin.role-in-permissions.edit',
                    roleWithPermissions.id
                  )
                "
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                  sort: params.sort,
                  direction: params.direction,
                }"
                class="edit-btn group"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-edit"></i>
                  Edit
                </span>
              </Link>

              <!-- Delete Button -->
              <button
                v-if="roleInPermissionsDelete"
                @click="handleDeleteRoleInPermissions(roleWithPermissions.id)"
                class="delete-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-trash-can"></i>
                  Delete
                </span>
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- RoleInPermissions Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!rolesWithPermissions.data.length" />

      <!-- Pagination -->
      <div v-if="rolesWithPermissions.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ rolesWithPermissions.from }} -
          {{ rolesWithPermissions.to }} of {{ rolesWithPermissions.total }}
        </p>
        <Pagination :links="rolesWithPermissions.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

