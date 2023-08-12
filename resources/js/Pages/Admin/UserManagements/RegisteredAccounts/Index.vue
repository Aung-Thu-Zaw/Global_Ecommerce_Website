<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/RegisteredAccountBreadcrumb.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import ResetFilterButton from "@/Components/Buttons/ResetFilterButton.vue";
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import InactiveStatus from "@/Components/Status/InactiveStatus.vue";
import RoleStatus from "@/Components/Status/RoleStatus.vue";
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
import datepicker from "vue3-datepicker";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

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

// Define  Variables
const swal = inject("$swal");
const isFilterBoxOpened = ref(false);
const createdFrom = ref(
  usePage().props.ziggy.query.created_from
    ? new Date(usePage().props.ziggy.query.created_from)
    : ""
);
const createdUntil = ref(
  usePage().props.ziggy.query.created_until
    ? new Date(usePage().props.ziggy.query.created_until)
    : ""
);

// Formatted Date
const formattedCreatedFrom = computed(() => {
  const year = createdFrom.value ? createdFrom.value.getFullYear() : "";
  const month = createdFrom.value ? createdFrom.value.getMonth() + 1 : "";
  const day = createdFrom.value ? createdFrom.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

const formattedCreatedUntil = computed(() => {
  const year = createdUntil.value ? createdUntil.value.getFullYear() : "";
  const month = createdUntil.value ? createdUntil.value.getMonth() + 1 : "";
  const day = createdUntil.value ? createdUntil.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

// Query String Parameteres
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  page: usePage().props.ziggy.query?.page,
  per_page: usePage().props.ziggy.query?.per_page,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  created_from: usePage().props.ziggy.query.created_from
    ? usePage().props.ziggy.query.created_from
    : formattedCreatedFrom,
  created_until: usePage().props.ziggy.query.created_until
    ? usePage().props.ziggy.query.created_until
    : formattedCreatedUntil,
});

// Handle Search
const handleSearch = () => {
  router.get(
    route("admin.registered-accounts.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: params.created_until,
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
    route("admin.registered-accounts.index"),
    {
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: params.created_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Filtered By Only Created From
const filteredByCreatedFrom = () => {
  router.get(
    route("admin.registered-accounts.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: formattedCreatedFrom.value,
      created_until: params.created_until,
    },
    {
      replace: true,
      preserveState: true,
      onSuccess: () => {
        isFilterBoxOpened.value = true;
      },
    }
  );
};

// Filtered By Only Created Until
const filteredByCreatedUntil = () => {
  router.get(
    route("admin.registered-accounts.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: formattedCreatedUntil.value,
    },
    {
      replace: true,
      preserveState: true,
      onSuccess: () => {
        isFilterBoxOpened.value = true;
      },
    }
  );
};

// Handle Reset Filtered Date
const resetFilteredDate = () => {
  createdFrom.value = "";
  createdUntil.value = "";
  router.get(
    route("admin.registered-accounts.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    {
      replace: true,
      preserveState: true,
      onSuccess: () => (isFilterBoxOpened.value = false),
    }
  );
};

// Handle Query String Parameter
const handleQueryStringParameter = () => {
  router.get(
    route("admin.registered-accounts.index"),
    {
      search: params.search,
      page: params.page,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: params.created_until,
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

// Watching Created From Datepicker
watch(
  () => params.created_from,
  () => {
    if (params.created_from === "") {
      resetFilteredDate();
    } else {
      filteredByCreatedFrom();
    }
  }
);

// Watching Created Unitl Datepicker
watch(
  () => params.created_until,
  () => {
    if (params.created_until === "") {
      resetFilteredDate();
    } else {
      filteredByCreatedUntil();
    }
  }
);

// Update Sorting Table Column
const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  handleQueryStringParameter();
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
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: params.created_from,
        created_until: params.created_until,
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
    <Head :title="__('REGISTERED_ACCOUNTS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="registeredAccountTrashList">
          <Link
            as="button"
            :href="route('admin.registered-accounts.trash')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
          >
            <TrashButton />
          </Link>
        </div>
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Box -->
        <form class="w-[350px] relative">
          <input
            type="text"
            class="search-input"
            :placeholder="__('SEARCH_BY_NAME')"
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

        <!-- Filter By Date -->
        <button
          @click="isFilterBoxOpened = !isFilterBoxOpened"
          class="filter-btn"
        >
          <span class="">
            <i class="fa-solid fa-filter"></i>
          </span>
        </button>

        <div
          v-if="isFilterBoxOpened"
          class="w-[400px] border border-gray-300 shadow-lg absolute bg-white top-64 right-10 z-30 px-5 py-4 rounded-md"
        >
          <div class="flex items-center justify-end">
            <span
              @click="isFilterBoxOpened = false"
              class="text-lg text-gray-500 hover:text-gray-800 cursor-pointer"
            >
              <i class="fa-solid fa-xmark"></i>
            </span>
          </div>
          <div class="w-full mb-6">
            <span class="font-bold text-sm text-gray-700 mb-5"
              >Created from</span
            >
            <div>
              <datepicker
                class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
                :placeholder="__('SELECT_DATE')"
                v-model="createdFrom"
              />
            </div>
          </div>
          <div class="w-full mb-3">
            <span class="font-bold text-sm text-gray-700 mb-5"
              >Created until</span
            >
            <div>
              <datepicker
                class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
                :placeholder="__('SELECT_DATE')"
                v-model="createdUntil"
              />
            </div>
          </div>

          <div
            v-if="params.created_from || params.created_until"
            class="w-full flex items-center"
          >
            <ResetFilterButton @click="resetFilteredDate" />
          </div>
        </div>
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

            <Td v-if="registeredAccountDelete || registeredAccountDetail">
              <!-- Delete Button -->
              <DeleteButton
                v-if="registeredAccountDelete"
                @click="handleDeleteRegisteredUser(user.id)"
              />

              <!-- Detail Button -->
              <Link
                v-if="registeredAccountDetail"
                as="button"
                :href="route('admin.registered-accounts.show', user.id)"
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                  sort: params.sort,
                  direction: params.direction,
                }"
              >
                <DetailButton />
              </Link>
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

