<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import DashboardTableDataSearchBox from "@/Components/Forms/SearchBoxs/DashboardTableDataSearchBox.vue";
import DashboardTableDataPerPageSelectBox from "@/Components/Forms/SelectBoxs/DashboardTableDataPerPageSelectBox.vue";
import DashboardTableFilterByCreatedDate from "@/Components/Forms/SelectBoxs/DashboardTableFilterByCreatedDate.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Breadcrumb.vue";
import BreadcrumbLinkItem from "@/Components/Breadcrumbs/BreadcrumbLinkItem.vue";
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
import EmptyTrashButton from "@/Components/Buttons/EmptyTrashButton.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import NoTableData from "@/Components/Table/NoTableData.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { useResourceActions } from "@/Composables/useResourceActions";
import { Head, usePage } from "@inertiajs/vue3";
import { computed, inject } from "vue";

// Define the Props
const props = defineProps({
  trashedBrands: Object,
});

const brandList = "admin.brands.index";
const trashedBrandList = "admin.brands.trashed";

const {
  restoreAction,
  restoreSelectedAction,
  restoreAllAction,
  permanentDeleteAction,
  permanentDeleteSelectedAction,
  permanentDeleteAllAction,
} = useResourceActions();
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('Trashed Brands')" />
    <!-- Breadcrumb And Go back Button  -->
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col items-start md:flex-row md:items-center md:justify-between mb-4 md:mb-8"
      >
        <Breadcrumb :to="brandList" icon="fa-award" label="Brands">
          <BreadcrumbLinkItem label="Trash" :to="trashedBrandList" />
          <BreadcrumbItem label="List" />
        </Breadcrumb>

        <div class="w-full flex items-center justify-end">
          <GoBackButton :to="brandList" />
        </div>
      </div>

      <!-- Table Start -->
      <div class="border bg-white rounded-md shadow px-5 py-3">
        <div
          class="my-5 flex flex-col sm:flex-row space-y-5 sm:space-y-0 items-center justify-between"
        >
          <DashboardTableDataSearchBox
            placeholder="Search by brand name ..."
            :to="trashedBrandList"
          />

          <div class="flex items-center justify-end w-full md:space-x-5">
            <DashboardTableDataPerPageSelectBox :to="trashedBrandList" />

            <DashboardTableFilterByCreatedDate :to="trashedBrandList" />
          </div>
        </div>

        <div
          v-if="can('brands.force.delete') && trashedBrands.data.length !== 0"
          class="text-left text-sm font-bold mb-2 text-warning-600"
        >
          {{
            __(
              "BRANDS_IN_THE_TRASH_WILL_BE_AUTOMATICALLY_DELETED_AFTER_60_DAYS"
            )
          }}

          <EmptyTrashButton
            @click="
              permanentDeleteAllAction('Brand', 'admin.brands.force-delete.all')
            "
          />
        </div>

        <TableContainer>
          <ActionTable :items="trashedBrands.data">
            <!-- Table Actions -->
            <template #actions="{ selectedItems }">
              <div v-show="can('brands.restore')">
                <ActionButton
                  @click="
                    restoreSelectedAction(
                      'Brand',
                      'admin.brands.restore.selected',
                      selectedItems
                    )
                  "
                >
                  <i class="fa-solid fa-recycle"></i>
                  Restore Selected ({{ selectedItems.length }})
                </ActionButton>
                <ActionButton
                  @click="restoreAllAction('Brand', 'admin.brands.restore.all')"
                >
                  <i class="fa-solid fa-recycle"></i>
                  Restore All ({{ trashedBrands.total }})
                </ActionButton>
              </div>
              <div v-show="can('brands.force.delete')">
                <ActionButton
                  @click="
                    permanentDeleteSelectedAction(
                      'Brand',
                      'admin.brands.force-delete.selected',
                      selectedItems
                    )
                  "
                >
                  <i class="fa-solid fa-trash-can"></i>
                  Delete Selected ({{ selectedItems.length }})
                </ActionButton>
                <ActionButton
                  @click="
                    permanentDeleteAllAction(
                      'Brand',
                      'admin.brands.force-delete.all'
                    )
                  "
                  class="text-red-600"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  Delete All ({{ trashedBrands.total }})
                </ActionButton>
              </div>
            </template>

            <!-- Table Header -->
            <template #table-header>
              <SortableTableHeaderCell
                label="# No"
                :to="trashedBrandList"
                sort="id"
              />

              <TableHeaderCell label="Image" />

              <SortableTableHeaderCell
                label="Name"
                :to="trashedBrandList"
                sort="name"
              />

              <SortableTableHeaderCell
                label="Description"
                :to="trashedBrandList"
                sort="description"
              />

              <TableHeaderCell label="Actions" />
            </template>

            <!-- Table Body -->
            <template #table-data="{ item }">
              <TableDataCell>
                {{ item.id }}
              </TableDataCell>

              <TableDataCell>
                <Image :src="item.image" />
              </TableDataCell>

              <TableDataCell>
                {{ item.name }}
              </TableDataCell>

              <TableDataCell>
                {{ item.description }}
              </TableDataCell>

              <TableActionCell>
                <NormalButton
                  v-show="can('brands.restore')"
                  @click="restoreAction('Brand', 'admin.brands.restore', item)"
                >
                  <i class="fa-solid fa-recycle"></i>
                  Restore
                </NormalButton>

                <NormalButton
                  v-show="can('brands.force.delete')"
                  @click="
                    permanentDeleteAction(
                      'Brand',
                      'admin.brands.force-delete',
                      item
                    )
                  "
                  class="bg-red-600 text-white ring-2 ring-red-300"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  Delete Forever
                </NormalButton>
              </TableActionCell>
            </template>
          </ActionTable>
        </TableContainer>

        <Pagination :data="trashedBrands" />

        <NoTableData v-show="!trashedBrands.data.length" />
      </div>
      <!-- Table End -->
    </div>
  </AdminDashboardLayout>
</template>


