<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductBreadcrumb.vue";
import CreateButton from "@/Components/Buttons/CreateButton.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import EditButton from "@/Components/Buttons/EditButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import DisapprovedStatus from "@/Components/Status/DisapprovedStatus.vue";
import ApprovedStatus from "@/Components/Status/ApprovedStatus.vue";
import NoDiscountStatus from "@/Components/Status/NoDiscountStatus.vue";
import DiscountStatus from "@/Components/Status/DiscountStatus.vue";
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
  products: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Product Permission
const productAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "product.add")
    : false;
});

// Product Detail Permission
const productDetail = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product.detail"
      )
    : false;
});

// Product Edit Permission
const productEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "product.edit")
    : false;
});

// Product Delete Permission
const productDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product.delete"
      )
    : false;
});

// Product Trash List Permission
const productTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product.trash.list"
      )
    : false;
});

// Product Control Permission
const productControl = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product.control"
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
    route("admin.products.index"),
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

// Formatted Amount
const formattedAmount = (amount) => {
  const totalAmount = parseFloat(amount);
  if (Number.isInteger(totalAmount)) {
    return totalAmount.toFixed(0);
  } else {
    return totalAmount.toFixed(2);
  }
};

// Handle Product Approved Or Disapproved
const handleStatus = async (product) => {
  const result = await swal({
    icon: "question",
    title:
      product.status === "pending" || product.status === "disapproved"
        ? __("ARE_YOU_SURE_YOU_WANT_TO_SET_APPROVE_THIS_PRODUCT")
        : __("ARE_YOU_SURE_YOU_WANT_TO_SET_DISAPPROVE_THIS_PRODUCT"),
    showCancelButton: true,
    confirmButtonText:
      product.status === "pending" || product.status === "disapproved"
        ? __("YES_APPROVE_IT")
        : __("YES_DISAPPROVE_IT"),
    cancelButtonText: __("CANCEL"),
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.patch(
      route("admin.products.handle.status", {
        product: product.slug,
        status:
          product.status === "pending" || product.status === "disapproved"
            ? "approved"
            : "disapproved",
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

// Handle Product Delete
const handleProductDelete = async (productSlug) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_PRODUCT"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_PRODUCT_IN_THE_TRASH"),
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
      route("admin.products.destroy", {
        product: productSlug,
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
    <Head :title="__('PRODUCTS')" />
    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="productTrashList">
          <TrashButton href="admin.products.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Product Button -->
        <div v-if="productAdd">
          <CreateButton href="admin.products.create" name="ADD_PRODUCT" />
        </div>

        <div class="flex items-center">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.products.index"
            placeholder="SEARCH_BY_NAME"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.products.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.products.index" />
        </div>
      </div>

      <!-- Product Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> {{ __("IMAGE") }} </HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            {{ __("NAME") }}
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('price')">
            {{ __("PRICE") }}
            <SortingArrows :params="params" sort="price" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('discount')">
            {{ __("DISCOUNT") }} (%)
            <SortingArrows :params="params" sort="discount" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('status')">
            {{ __("STATUS") }}
            <SortingArrows :params="params" sort="status" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="productEdit || productDelete || productDetail">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="products.data.length">
          <Tr v-for="product in products.data" :key="product.id">
            <BodyTh>
              {{ product.id }}
            </BodyTh>

            <Td>
              <img :src="product.image" class="image" />
            </Td>

            <Td class="line-clamp-1">
              {{ product.name }}
            </Td>

            <Td class="w-[110px]"> $ {{ formattedAmount(product.price) }} </Td>

            <Td class="w-[150px]">
              <DiscountStatus
                :price="product.price"
                :discount="product.discount"
              />

              <NoDiscountStatus v-if="!product.discount" />
            </Td>

            <Td class="w-[180px]">
              <PendingStatus v-if="product.status === 'pending'">
                {{ product.status }}
              </PendingStatus>

              <DisapprovedStatus v-if="product.status === 'disapproved'">
                {{ product.status }}
              </DisapprovedStatus>

              <ApprovedStatus v-if="product.status === 'approved'">
                {{ product.status }}
              </ApprovedStatus>
            </Td>

            <Td class="w-[140px]">
              {{ product.created_at }}
            </Td>

            <Td
              class="w-[550px] flex"
              v-if="
                productEdit || productDelete || productDetail || productControl
              "
            >
              <!-- Control Button -->
              <button
                v-if="productControl"
                @click="handleStatus(product)"
                class="text-sm px-5 py-2 border-[3px] font-semibold rounded-[4px] shadow-md text-white transition-all mr-3 my-1 group"
                type="button"
                :class="{
                  'bg-green-600  hover:bg-green-700 border-green-700':
                    product.status === 'pending' ||
                    product.status === 'disapproved',
                  'bg-orange-600  hover:bg-orange-700 border-orange-700':
                    product.status === 'approved',
                }"
              >
                <span
                  v-if="
                    product.status === 'pending' ||
                    product.status === 'disapproved'
                  "
                  class="group-hover:animate-pulse"
                >
                  <i class="fa-solid fa-check"></i>
                  {{ __("APPROVE") }}
                </span>
                <span v-else class="group-hover:animate-pulse">
                  <i class="fa-solid fa-xmark"></i>
                  {{ __("DISAPPROVE") }}
                </span>
              </button>

              <!-- Edit Button -->
              <div v-if="productEdit">
                <EditButton href="admin.products.edit" :slug="product.slug" />
              </div>

              <!-- Delete Button -->
              <div v-if="productDelete">
                <DeleteButton @click="handleProductDelete(product.slug)" />
              </div>

              <!-- Detail Button -->
              <div v-if="productDetail">
                <DetailButton href="admin.products.show" :slug="product.slug" />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Product Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!products.data.length" />

      <!-- Pagination -->
      <div v-if="products.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ products.from }} - {{ products.to }} of
          {{ products.total }}
        </p>
        <Pagination :links="products.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

