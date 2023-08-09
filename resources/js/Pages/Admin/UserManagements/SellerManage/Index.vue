<script setup>
import Breadcrumb from "@/Components/Breadcrumbs/SellerManageBreadcrumb.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import InactiveStatus from "@/Components/Status/InactiveStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { Link, usePage, Head, router } from "@inertiajs/vue3";
import { inject, reactive, watch, computed, ref } from "vue";

// Define the props
const props = defineProps({
  sellers: Object,
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
    route("admin.seller-manage.index"),
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
    route("admin.seller-manage.index"),
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
    route("admin.seller-manage.index"),
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

// Handle Seller shop is active or inactive
const handleStatus = async (seller) => {
  const result = await swal({
    icon: "question",
    title: `Are you sure you want to set ${
      seller.status === "active" ? "inactive" : "active"
    } this seller?`,
    showCancelButton: true,
    confirmButtonText: `Yes, ${
      seller.status === "active" ? "Inactive" : "Active"
    }!`,
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

// Handle Delete Seller
const handleDeleteSeller = async (sellerId) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to move it to the trash?",
    text: "You will be able to revert this action!",
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
      route("admin.seller-manage.destroy", {
        user: sellerId,
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

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: usePage().props.flash.successMessage,
  });
}
</script>


<template>
  <AdminDashboardLayout>
    <Head title="Sellers" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="sellerManageTrashList">
          <Link
            as="button"
            :href="route('admin.seller-manage.trash')"
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

          <HeaderTh @click="updateSorting('status')">
            Status
            <SortingArrows :params="params" sort="status" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh
            v-if="
              sellerManageControl || sellerManageDelete || sellerManageDetail
            "
          >
            Action
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
            >
              <!-- Control Button -->
              <button
                v-if="sellerManageControl"
                @click="handleStatus(seller)"
                class="offical-btn group"
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
                  Active
                </span>
                <span v-else class="group-hover:animate-pulse">
                  <i class="fa-solid fa-xmark"></i>
                  Inactive
                </span>
              </button>

              <!-- Delete Button -->
              <button
                v-if="sellerManageDelete"
                @click="handleDeleteSeller(seller.id)"
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
                v-if="sellerManageDetail"
                as="button"
                :href="route('admin.seller-manage.show', seller.id)"
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

