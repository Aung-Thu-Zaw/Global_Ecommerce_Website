<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CountryBreadcrumb.vue";
import CreateButton from "@/Components/Buttons/CreateButton.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
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
  countries: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Shipping Area Permission
const shippingAreaAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "shipping-area.add"
      )
    : false;
});

// Shipping Area Edit Permission
const shippingAreaEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "shipping-area.edit"
      )
    : false;
});

// Shipping Area Delete Permission
const shippingAreaDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "shipping-area.delete"
      )
    : false;
});

// Shipping Area Trash List Permission
const shippingAreaTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "shipping-area.trash.list"
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
    route("admin.countries.index"),
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

// Handle Country Delete
const handleDelete = (country) => {
  router.delete(
    route("admin.countries.destroy", {
      country: country,
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
};

// Handle Delete Country
const handleDeleteCountry = async (country) => {
  if (country.regions.length > 0) {
    const result = await swal({
      icon: "error",
      title: __(
        "YOU_CANT_DELETE_THIS_COUNTRY_BECAUSE_THIS_COUNTRY_HAVE_REGIONS"
      ),
      text: __(
        "IF_YOU_CLICK_THE_DELETE_WHATEVER_BUTTON_REGIONS_ASSOCIATED_WITH_THAT_COUNTRY_WILL_BE_AUTOMATICALLY_DELETED"
      ),
      showCancelButton: true,
      confirmButtonText: __("DELETE_WHATEVER"),
      cancelButtonText: __("CANCEL"),
      confirmButtonColor: "#d52222",
      cancelButtonColor: "#626262",
      timer: 20000,
      timerProgressBar: true,
      reverseButtons: true,
    });
    if (result.isConfirmed) {
      handleDelete(country.slug);
    }
  } else {
    const result = await swal({
      icon: "question",
      title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_COUNTRY"),
      text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_COUNTRY_IN_THE_TRASH"),
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
      handleDelete(country.slug);
    }
  }
};

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: __(usePage().props.flash.successMessage),
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('COUNTRIES')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="shippingAreaTrashList">
          <TrashButton href="admin.countries.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create country Button -->
        <div v-if="shippingAreaAdd">
          <CreateButton href="admin.countries.create" name="ADD_COUNTRY" />
        </div>

        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.countries.index"
            placeholder="SEARCH_BY_NAME"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.countries.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.countries.index" />
        </div>
      </div>

      <!-- Country Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            {{ __("NAME") }}
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="shippingAreaEdit || shippingAreaDelete">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="countries.data.length">
          <Tr v-for="country in countries.data" :key="country.id">
            <BodyTh>
              {{ country.id }}
            </BodyTh>

            <Td>
              {{ country.name }}
            </Td>

            <Td>
              {{ country.created_at }}
            </Td>

            <Td
              v-if="shippingAreaEdit || shippingAreaDelete"
              class="flex items-center"
            >
              <!-- Edit Button -->
              <div v-if="shippingAreaEdit">
                <EditButton href="admin.countries.edit" :slug="country.slug" />
              </div>

              <!-- Delete Button -->
              <div v-if="shippingAreaDelete">
                <DeleteButton @click="handleDeleteCountry(country)" />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Country Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!countries.data.length" />

      <!-- Pagination -->
      <div v-if="countries.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-500 mb-3 font-bold">
          Showing {{ countries.from }} - {{ countries.to }} of
          {{ countries.total }}
        </p>
        <Pagination :links="countries.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

