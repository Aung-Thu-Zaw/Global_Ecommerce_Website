<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/SellerManageBreadcrumb.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByCreatedDate from "@/Components/Forms/DashboardFilterByCreatedDate.vue";
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
import Pagination from "@/Components/Paginations/Pagination.vue";
import { __ } from "@/Translations/translations-inside-setup.js";
import { inject, computed, ref, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  sellers: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Seller Manage Control Permission
const sellerManageControl = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "seller-manage.control"
      )
    : false;
});

// Seller Manage Detail Permission
const sellerManageDetail = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "seller-manage.detail"
      )
    : false;
});

// Seller Manage Delete Permission
const sellerManageDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "seller-manage.delete"
      )
    : false;
});

// Seller Manage Trash List Permission
const sellerManageTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "seller-manage.trash.list"
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
    route("admin.seller-manage.index"),
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

// Handle Seller shop is active or inactive
const handleStatus = async (seller) => {
  const result = await swal({
    icon: "question",
    title:
      seller.status === "active"
        ? __("ARE_YOU_SURE_YOU_WANT_TO_SET_INACTIVE_THIS_SELLER")
        : __("ARE_YOU_SURE_YOU_WANT_TO_SET_ACTIVE_THIS_SELLER"),
    showCancelButton: true,
    confirmButtonText:
      seller.status === "active" ? __("YES_INACTIVE") : __("YES_ACTIVE"),
    cancelButtonText: __("CANCEL"),
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.patch(
      route("admin.seller-manage.update", {
        user: seller.id,
        status: seller.status === "inactive" ? "active" : "inactive",
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: usePage().props.ziggy.query?.created_from,
        created_until: usePage().props.ziggy.query?.created_until,
      }),
      {},
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

// Handle Delete Seller
const handleDeleteSeller = async (sellerId) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_SELLER"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_SELLER_IN_THE_TRASH"),
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
      route("admin.seller-manage.destroy", {
        user: sellerId,
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
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('SELLERS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="sellerManageTrashList">
          <TrashButton href="admin.seller-manage.trash" />
        </div>
      </div>

      <div class="flex items-center justify-end mb-5 ml-auto">
        <!-- Search Box -->
        <DashboardSearchInputForm
          href="admin.seller-manage.index"
          placeholder="SEARCH_BY_SHOP_NAME"
        />

        <!-- Perpage Select Box -->
        <div class="ml-5">
          <DashboardPerPageSelectBox href="admin.seller-manage.index" />
        </div>

        <!-- Filter By Date -->
        <DashboardFilterByCreatedDate href="admin.seller-manage.index" />
      </div>

      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('shop_name')">
            {{ __("SHOP_NAME") }}
            <SortingArrows :params="params" sort="shop_name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('email')">
            {{ __("EMAIL_ADDRESS") }}
            <SortingArrows :params="params" sort="email" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('status')">
            {{ __("STATUS") }}
            <SortingArrows :params="params" sort="status" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh
            v-if="
              sellerManageControl || sellerManageDelete || sellerManageDetail
            "
          >
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="sellers.data.length">
          <Tr v-for="seller in sellers.data" :key="seller.id">
            <BodyTh>
              {{ seller.id }}
            </BodyTh>

            <Td>
              {{ seller.shop_name }}
            </Td>

            <Td>
              {{ seller.email }}
            </Td>

            <Td>
              <ActiveStatus v-if="seller.status === 'active'">
                {{ seller.status }}
              </ActiveStatus>
              <InactiveStatus v-if="seller.status === 'inactive'">
                {{ seller.status }}
              </InactiveStatus>
            </Td>

            <Td>
              {{ seller.created_at }}
            </Td>

            <Td
              v-if="
                sellerManageControl || sellerManageDelete || sellerManageDetail
              "
              class="flex items-center"
            >
              <!-- Control Button -->
              <button
                v-if="sellerManageControl"
                @click="handleStatus(seller)"
                class="text-sm px-5 py-2 border-[3px] font-semibold rounded-[4px] shadow-md text-white transition-all mr-3 my-1 group"
                type="button"
                :class="{
                  'bg-green-600  hover:bg-green-700 border-green-700':
                    seller.status === 'inactive',
                  'bg-orange-600  hover:bg-orange-700 border-orange-700':
                    seller.status === 'active',
                }"
              >
                <span
                  v-if="seller.status === 'inactive'"
                  class="group-hover:animate-pulse"
                >
                  <i class="fa-solid fa-check"></i>
                  {{ __("ACTIVE") }}
                </span>
                <span v-else class="group-hover:animate-pulse">
                  <i class="fa-solid fa-xmark"></i>
                  {{ __("INACTIVE") }}
                </span>
              </button>

              <!-- Delete Button -->
              <div v-if="sellerManageDelete">
                <DeleteButton @click="handleDeleteSeller(seller.id)" />
              </div>

              <!-- Detail Button -->
              <div v-if="sellerManageDetail">
                <DetailButton href="admin.seller-manage.show" :id="seller.id" />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <!-- No Data Row -->
      <NotAvaliableData v-if="!sellers.data.length" />

      <!-- Pagination -->
      <div v-if="sellers.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ sellers.from }} - {{ sellers.to }} of
          {{ sellers.total }}
        </p>
        <Pagination :links="sellers.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

