<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/RegisteredAccountBreadcrumb.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByCreatedDate from "@/Components/Forms/DashboardFilterByCreatedDate.vue";
import RoleStatus from "@/Components/Status/RoleStatus.vue";
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import InactiveStatus from "@/Components/Status/InactiveStatus.vue";
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
  users: Object,
});

// User Activity Status
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
    route("admin.registered-accounts.index"),
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

// Handle User Delete
const handleDeleteRegisteredUser = async (user) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_USER"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_USER_IN_THE_TRASH"),
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
      route("admin.registered-accounts.destroy", {
        user: user,
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
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('REGISTERED_ACCOUNTS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="registeredAccountTrashList">
          <TrashButton href="admin.registered-accounts.trash" />
        </div>
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Box -->
        <DashboardSearchInputForm
          href="admin.registered-accounts.index"
          placeholder="SEARCH_BY_NAME"
        />

        <!-- Perpage Select Box -->
        <div class="ml-5">
          <DashboardPerPageSelectBox href="admin.registered-accounts.index" />
        </div>

        <!-- Filter By Date -->
        <DashboardFilterByCreatedDate href="admin.registered-accounts.index" />
      </div>

      <!-- User Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh>{{ __("AVATAR") }}</HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            {{ __("NAME") }}
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('email')">
            {{ __("EMAIL_ADDRESS") }}
            <SortingArrows :params="params" sort="email" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('role')">
            {{ __("ROLE") }}
            <SortingArrows :params="params" sort="role" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('status')">
            {{ __("STATUS") }}
            <SortingArrows :params="params" sort="status" />
          </HeaderTh>

          <HeaderTh> {{ __("ONLINE_STATUS") }} </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="registeredAccountDelete || registeredAccountDetail">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="users.data.length">
          <Tr v-for="user in users.data" :key="user.id">
            <BodyTh>
              {{ user.id }}
            </BodyTh>

            <Td>
              <img
                :src="user.avatar"
                alt=""
                class="h-[50px] w-[50px] ring-2 ring-slate-300 object-cover rounded-full"
              />
            </Td>

            <Td>
              {{ user.name }}
            </Td>

            <Td>
              {{ user.email }}
            </Td>

            <Td>
              <RoleStatus>
                {{ user.role }}
              </RoleStatus>
            </Td>

            <Td>
              <ActiveStatus v-if="user.status == 'active'">
                {{ user.status }}
              </ActiveStatus>

              <InactiveStatus v-if="user.status == 'inactive'">
                {{ user.status }}
              </InactiveStatus>
            </Td>

            <Td>
              <ActiveStatus v-if="status(user.last_activity) == 'active'">
                {{ status(user.last_activity) }}
              </ActiveStatus>

              <InactiveStatus v-if="status(user.last_activity) == 'offline'">
                {{ status(user.last_activity) }}
              </InactiveStatus>
            </Td>

            <Td>
              {{ user.created_at }}
            </Td>

            <Td
              v-if="registeredAccountDelete || registeredAccountDetail"
              class="flex items-center"
            >
              <!-- Delete Button -->
              <div v-if="registeredAccountDelete">
                <DeleteButton @click="handleDeleteRegisteredUser(user.id)" />
              </div>

              <!-- Detail Button -->
              <div v-if="registeredAccountDetail">
                <DetailButton
                  href="admin.registered-accounts.show"
                  :id="user.id"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- User Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!users.data.length" />

      <!-- Pagination -->
      <div v-if="users.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ users.from }} - {{ users.to }} of
          {{ users.total }}
        </p>
        <Pagination :links="users.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

