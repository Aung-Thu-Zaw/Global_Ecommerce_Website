<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Breadcrumb.vue";
import BreadcrumbItem from "@/Components/Breadcrumbs/BreadcrumbItem.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import ActionTable from "@/Components/Table/ActionTable.vue";
import DashboardTableDataSearchBox from "@/Components/Forms/SearchBoxs/DashboardTableDataSearchBox.vue";
import DashboardTableDataPerPageSelectBox from "@/Components/Forms/SelectBoxs/DashboardTableDataPerPageSelectBox.vue";
import DashboardTableFilterByDate from "@/Components/Forms/SelectBoxs/DashboardTableFilterByDate.vue";
import SortableTableHeaderCell from "@/Components/Table/SortableTableHeaderCell.vue";
import TableHeaderCell from "@/Components/Table/TableHeaderCell.vue";
import TableDataCell from "@/Components/Table/TableDataCell.vue";
import TableActionCell from "@/Components/Table/TableActionCell.vue";
import Image from "@/Components/Table/Image.vue";
import NoTableData from "@/Components/Table/NoTableData.vue";
import BulkActionButton from "@/Components/Buttons/BulkActionButton.vue";
import InertiaLinkButton from "@/Components/Buttons/InertiaLinkButton.vue";
import NormalButton from "@/Components/Buttons/NormalButton.vue";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { useResourceActions } from "@/Composables/useResourceActions";
import { Head } from "@inertiajs/vue3";
import { inject } from "vue";
import { __ } from "@/Services/translations-inside-setup.js";
import { useQueryStringParams } from "@/Composables/useQueryStringParams";

const props = defineProps({
  brands: Object,
});

const swal = inject("$swal");

const brandList = "admin.brands.index";

const { queryStringParams } = useQueryStringParams();

const { softDeleteAction, selectedSoftDeleteAction, softDeleteAllAction } =
  useResourceActions();

const handleDeleteBrand = async (brand) => {
  if (brand.products_count > 0) {
    const result = await swal({
      icon: "error",
      title: __("You can't delete this :label", {
        label: __("brand"),
        label2: __("products"),
      }),
      text: __(
        "If you click the 'Delete Whatever' button :label2 associated with that :label will be automatically deleted.",
        { label2: __("products"), label: __("brand") }
      ),
      showCancelButton: true,
      confirmButtonText: __("Delete Whatever"),
      cancelButtonText: __("Cancel"),
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
    <Head :title="__('Brands')" />

    <!-- Breadcrumb And Trash Button  -->
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col items-start md:flex-row md:items-center md:justify-between mb-4 md:mb-8"
      >
        <Breadcrumb :to="brandList" icon="fa-award" label="Brands">
          <BreadcrumbItem label="List" />
        </Breadcrumb>
      </div>

      <div class="flex items-center justify-between mb-3">
        <!-- Create New Button -->
        <InertiaLinkButton
          v-show="can('brands.create')"
          to="admin.brands.create"
          :data="queryStringParams"
        >
          <i class="fa-solid fa-file-circle-plus mr-1"></i>
          {{ __("Create A New :label", { label: __("Brand") }) }}
        </InertiaLinkButton>

        <!-- Trash Button -->
        <InertiaLinkButton
          v-show="can('brands.view.trash')"
          to="admin.brands.trashed"
          :data="{
            page: 1,
            per_page: 5,
            sort: 'id',
            direction: 'desc',
          }"
          class="bg-red-600 text-white ring-2 ring-red-300"
        >
          <i class="fa-solid fa-trash-can mr-1"></i>
          {{ __("Trash") }}
        </InertiaLinkButton>
      </div>

      <!-- Table Start -->
      <div class="border bg-white rounded-md shadow px-5 py-3">
        <div
          class="my-5 flex flex-col sm:flex-row space-y-5 sm:space-y-0 items-center justify-between overflow-auto p-2"
        >
          <DashboardTableDataSearchBox
            :placeholder="__('Search by :label', { label: __('Name') }) + '...'"
            :to="brandList"
          />

          <div class="flex items-center justify-end w-full md:space-x-5">
            <DashboardTableDataPerPageSelectBox :to="brandList" />

            <DashboardTableFilterByDate :to="brandList" />
          </div>
        </div>

        <TableContainer>
          <ActionTable :items="brands.data">
            <!-- Table Actions -->
            <template #bulk-actions="{ selectedItems }">
              <div v-show="can('brands.delete')">
                <BulkActionButton
                  @click="
                    selectedSoftDeleteAction(
                      'Brands',
                      'admin.brands.destroy.selected',
                      selectedItems
                    )
                  "
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete Selected") }} ({{ selectedItems.length }})
                </BulkActionButton>
                <BulkActionButton
                  @click="
                    softDeleteAllAction('Brand', 'admin.brands.destroy.all')
                  "
                  class="text-red-600"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete All") }} ({{ brands.total }})
                </BulkActionButton>
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
                  {{ __("Edit") }}
                </InertiaLinkButton>

                <NormalButton
                  v-show="can('brands.delete')"
                  @click="handleDeleteBrand(item)"
                  class="bg-red-600 text-white ring-2 ring-red-300"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete") }}
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

