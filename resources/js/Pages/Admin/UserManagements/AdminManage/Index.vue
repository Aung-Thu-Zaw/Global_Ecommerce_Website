<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/AdminManageBreadcrumb.vue";
import CreateButton from "@/Components/Buttons/CreateButton.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import EditButton from "@/Components/Buttons/EditButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByCreatedDate from "@/Components/Forms/DashboardFilterByCreatedDate.vue";
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import InactiveStatus from "@/Components/Status/InactiveStatus.vue";
import RoleStatus from "@/Components/Status/RoleStatus.vue";
import NoRoleStatus from "@/Components/Status/NoRoleStatus.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import { inject, computed, ref, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  admins: Object,
});

// Admin Activity Status
const currentTime = new Date();
const threshold = 1000 * 60 * 5; //5minutes in millseconds

const status = (last_activity) => {
  const lastActivity = new Date(last_activity);
  const timeDifference = currentTime.getTime() - lastActivity.getTime();

  return timeDifference < threshold ? "active" : "offline";
};

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Admin Manage Permission
const adminManageAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "admin-manage.add"
      )
    : false;
});

// Admin Manage Edit Permission
const adminManageEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "admin-manage.edit"
      )
    : false;
});

// Admin Manage Delete Permission
const adminManageDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "admin-manage.delete"
      )
    : false;
});

// Admin Manage Detail Permission
const adminManageDetail = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "admin-manage.detail"
      )
    : false;
});

// Admin Manage Trash List Permission
const adminManageTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "admin-manage.trash.list"
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
    route("admin.admin-manage.index"),
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

// Handle Admin Delete
const handleAdminDelete = async (admin) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_ADMIN_USER"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_BRAND_IN_THE_TRASH"),
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
      route("admin.admin-manage.destroy", {
        user: admin,
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
    <Head :title="__('ADMIN_MANAGE')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="adminManageTrashList">
          <TrashButton href="admin.admin-manage.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Admin Button -->
        <div v-if="adminManageAdd">
          <CreateButton href="admin.admin-manage.create" name="ADD_ADMIN" />
        </div>

        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.admin-manage.index"
            placeholder="SEARCH_BY_NAME"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.admin-manage.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.admin-manage.index" />
        </div>
      </div>

      <!-- Admin Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> {{ __("AVATAR") }} </HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            {{ __("NAME") }}
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('email')">
            {{ __("EMAIL_ADDRESS") }}
            <SortingArrows :params="params" sort="email" />
          </HeaderTh>

          <HeaderTh> {{ __("ADMIN_ROLE") }} </HeaderTh>

          <HeaderTh> {{ __("ONLINE_STATUS") }} </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh
            v-if="adminManageEdit || adminManageDelete || adminManageDetail"
          >
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="admins.data.length">
          <Tr v-for="admin in admins.data" :key="admin.id">
            <BodyTh>
              {{ admin.id }}
            </BodyTh>

            <Td>
              <img
                :src="admin.avatar"
                class="h-[50px] w-[50px] ring-2 ring-slate-300 object-cover rounded-full"
              />
            </Td>

            <Td>{{ admin.name }}</Td>

            <Td>{{ admin.email }}</Td>

            <Td>
              <RoleStatus v-if="admin.roles.length">
                {{ admin.roles[0].name }}
              </RoleStatus>

              <NoRoleStatus v-else />
            </Td>

            <Td>
              <ActiveStatus v-if="status(admin.last_activity) == 'active'">
                {{ status(admin.last_activity) }}
              </ActiveStatus>

              <InactiveStatus v-if="status(admin.last_activity) == 'offline'">
                {{ status(admin.last_activity) }}
              </InactiveStatus>
            </Td>

            <Td class="">{{ admin.created_at }}</Td>

            <Td
              v-if="adminManageEdit || adminManageDelete || adminManageDetail"
              class="flex items-center"
            >
              <!-- Edit Button -->
              <div v-if="adminManageEdit">
                <EditButton href="admin.admin-manage.edit" :id="admin.id" />
              </div>

              <!-- Delete Button -->
              <div v-if="adminManageDelete">
                <DeleteButton @click="handleAdminDelete(admin.id)" />
              </div>

              <!-- Detail Button -->
              <div v-if="adminManageDetail">
                <DetailButton href="admin.admin-manage.show" :id="admin.id" />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Admin Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!admins.data.length" />

      <!-- Pagination -->
      <div v-if="admins.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ admins.from }} - {{ admins.to }} of
          {{ admins.total }}
        </p>
        <Pagination :links="admins.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

