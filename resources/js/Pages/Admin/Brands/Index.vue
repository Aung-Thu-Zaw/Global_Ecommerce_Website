<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import DashboardTableDataSearchBox from "@/Components/Forms/SearchBoxs/DashboardTableDataSearchBox.vue";
import DashboardTableDataPerPageSelectBox from "@/Components/Forms/SelectBoxs/DashboardTableDataPerPageSelectBox.vue";
import DashboardTableFilterByCreatedDate from "@/Components/Forms/SelectBoxs/DashboardTableFilterByCreatedDate.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Breadcrumb.vue";
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import SortableTableHeaderCell from "@/Components/Table/SortableTableHeaderCell.vue";
import TableHeaderCell from "@/Components/Table/TableHeaderCell.vue";
import TableDataCell from "@/Components/Table/TableDataCell.vue";
import TableActionCell from "@/Components/Table/TableActionCell.vue";
import Image from "@/Components/Table/Image.vue";
import ActionTable from "@/Components/Table/ActionTable.vue";
import InertiaLinkButton from "@/Components/Buttons/InertiaLinkButton.vue";
import ActionButton from "@/Components/Buttons/TableActionButton.vue";
import NormalButton from "@/Components/Buttons/NormalButton.vue";
import NoTableData from "@/Components/Table/NoTableData.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { useResourceActions } from "@/Composables/useResourceActions";
import { Head, usePage } from "@inertiajs/vue3";
import { computed, inject } from "vue";

const props = defineProps({
  brands: Object,
});

const swal = inject("$swal");

const brandList = "admin.brands.index";

const queryStringParams = computed(() => {
  return {
    page: usePage().props.ziggy.query?.page,
    per_page: usePage().props.ziggy.query?.per_page,
    sort: usePage().props.ziggy.query?.sort,
    direction: usePage().props.ziggy.query?.direction,
  };
});

const { softDeleteAction, softDeleteSelectedAction, softDeleteAllAction } =
  useResourceActions();

const handleDeleteBrand = async (brand) => {
  if (brand.products_count > 0) {
    const result = await swal({
      icon: "error",
      title: __("YOU_CANT_DELETE_THIS_BRAND_BECAUSE_THIS_BRAND_HAVE_PRODUCTS"),
      text: __(
        "IF_YOU_CLICK_THE_DELETE_WHATEVER_BUTTON_PRODUCTS_ASSOCIATED_WITH_THAT_BRAND_WILL_BE_AUTOMATICALLY_DELETED"
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
      softDeleteAction("Brand", "admin.brands.destroy", brand);
    }
  } else {
    softDeleteAction("Brand", "admin.brands.destroy", brand);
  }
};
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('BRANDS')" />
    <!-- Breadcrumb And Trash Button  -->
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col md:flex-row items-center md:justify-between mb-5"
      >
        <Breadcrumb :to="brandList" icon="fa-award" label="Brands">
          <BreadcrumbItem label="List" />
        </Breadcrumb>

        <InertiaLinkButton
          v-show="can('brands.view.trash')"
          to="admin.brands.trashed"
          :data="queryStringParams"
          class="bg-red-600 text-white ring-2 ring-red-300"
        >
          <i class="fa-solid fa-trash-can mr-1"></i>
          Trash
        </InertiaLinkButton>
      </div>

      <!-- Create New Button  -->
      <div v-show="can('brands.create')" class="mb-3">
        <InertiaLinkButton to="admin.brands.create" :data="queryStringParams">
          <i class="fa-solid fa-file-circle-plus mr-1"></i>
          Add A New Brand
        </InertiaLinkButton>
      </div>

      <!-- Table Start -->
      <div class="border bg-white rounded-md shadow px-5 py-3">
        <div
          class="my-5 flex flex-col sm:flex-row space-y-5 sm:space-y-0 items-center justify-between overflow-auto"
        >
          <DashboardTableDataSearchBox
            placeholder="Search by brand name ..."
            :to="brandList"
          />

          <div class="flex items-center space-x-5">
            <DashboardTableDataPerPageSelectBox :to="brandList" />

            <DashboardTableFilterByCreatedDate :to="brandList" />
          </div>
        </div>
        <TableContainer>
          <ActionTable :items="brands.data">
            <!-- Delete Actions -->
            <template #actions="{ selectedItems }">
              <div v-show="can('brands.delete')">
                <ActionButton
                  @click="
                    softDeleteSelectedAction(
                      'Brand',
                      'admin.brands.destroy.selected',
                      selectedItems
                    )
                  "
                >
                  <i class="fa-solid fa-trash-can"></i>
                  Delete Selected
                </ActionButton>
                <ActionButton
                  @click="
                    softDeleteAllAction('Brand', 'admin.brands.destroy.all')
                  "
                  class="text-red-600"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  Delete The Whole Table
                </ActionButton>
              </div>
            </template>

            <!-- Table Header -->
            <template #table-header>
              <SortableTableHeaderCell label="# No" :to="brandList" sort="id" />

              <TableHeaderCell label="Image" />

              <SortableTableHeaderCell
                label="Name"
                :to="brandList"
                sort="name"
              />

              <SortableTableHeaderCell
                label="Description"
                :to="brandList"
                sort="description"
              />

              <TableHeaderCell label="Actions" />
            </template>

            <!-- Table Body -->
            <template #table-data="{ item }">
              <TableDataCell>
                {{ item?.id }}
              </TableDataCell>

              <TableDataCell>
                <Image :src="item?.image" />
              </TableDataCell>

              <TableDataCell>
                {{ item?.name }}
              </TableDataCell>

              <TableDataCell>
                {{ item?.description }}
              </TableDataCell>

              <TableActionCell>
                <InertiaLinkButton
                  v-show="can('brands.edit')"
                  to="admin.brands.edit"
                  :targetIdentifier="item"
                  :data="queryStringParams"
                >
                  <i class="fa-solid fa-edit"></i>
                  Edit
                </InertiaLinkButton>

                <NormalButton
                  v-show="can('brands.delete')"
                  @click="handleDeleteBrand(item)"
                  class="bg-red-600 text-white ring-2 ring-red-300"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  Delete
                </NormalButton>
              </TableActionCell>
            </template>
          </ActionTable>
        </TableContainer>

        <Pagination :data="brands" />

        <NoTableData v-show="!brands.data.length" />
      </div>
      <!-- Table End -->
    </div>
  </AdminDashboardLayout>
</template>

