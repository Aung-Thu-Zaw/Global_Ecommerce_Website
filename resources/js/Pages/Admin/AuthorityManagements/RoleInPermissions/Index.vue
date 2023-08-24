<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/RoleInPermissionBreadcrumb.vue";
import CreateButton from "@/Components/Buttons/CreateButton.vue";
import EditButton from "@/Components/Buttons/EditButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
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
import { inject, computed, ref, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  rolesWithPermissions: Object,
});

// Define Variables
const swal = inject("$swal");
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
    route("admin.role-in-permissions.index"),
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

// Handle Delete Role In Permissions
const handleDeleteRoleInPermissions = async (role) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_ROLE_IN_PERMISSIONS"),
    showCancelButton: true,
    confirmButtonText: __("YES_DELETE_IT"),
    cancelButtonText: __("CANCEL"),
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
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: usePage().props.ziggy.query?.created_from,
        created_until: usePage().props.ziggy.query?.created_until,
      }),
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: __(usePage().props.flash.successMessage),
            });
          }
        },
      }
    );
  }
};

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: __(usePage().props.flash.successMessage),
  });
}

if (usePage().props.flash.errorMessage) {
  swal({
    icon: "error",
    title: __(usePage().props.flash.errorMessage),
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('ROLE_IN_PERMISSIONS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Role In Permissions Button -->
        <div v-if="roleInPermissionsAdd">
          <CreateButton
            href="admin.role-in-permissions.create"
            name="ADD_ROLE_IN_PERMISSIONS"
          />
        </div>

        <div class="flex items-center">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.role-in-permissions.index"
            placeholder="SEARCH_BY_ROLE_NAME"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.role-in-permissions.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate
            href="admin.role-in-permissions.index"
          />
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
            {{ __("ROLE_NAME") }}
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh> {{ __("PERMISSIONS") }}</HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="roleInPermissionsEdit || roleInPermissionsDelete">
            {{ __("ACTION") }}
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

            <Td v-if="roleWithPermissions.permissions.length" class="w-[150px]">
              {{ roleWithPermissions.name }}
            </Td>

            <Td
              v-if="roleWithPermissions.permissions.length"
              class="max-w-[800px] max-h-[200px] overflow-y-scroll scrollbar flex items-start"
            >
              <span
                v-for="permission in roleWithPermissions.permissions"
                :key="permission.id"
                class="bg-blue-700 text-white rounded-full px-3 py-1 mr-3 my-2"
              >
                {{ permission.name }}
              </span>
            </Td>

            <Td v-if="roleWithPermissions.permissions.length" class="w-[150px]">
              {{ roleWithPermissions.created_at }}
            </Td>

            <Td
              v-if="
                roleWithPermissions.permissions.length &&
                (roleInPermissionsEdit || roleInPermissionsDelete)
              "
              class="flex items-center"
            >
              <!-- Edit Button -->
              <div
                v-if="
                  roleInPermissionsEdit &&
                  roleWithPermissions.name !== 'Super Admin'
                "
              >
                <EditButton
                  href="admin.role-in-permissions.edit"
                  :id="roleWithPermissions.id"
                />
              </div>

              <!-- Delete Button -->
              <div
                v-if="
                  roleInPermissionsDelete &&
                  roleWithPermissions.name !== 'Super Admin'
                "
              >
                <DeleteButton
                  @click="handleDeleteRoleInPermissions(roleWithPermissions.id)"
                />
              </div>
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

