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
import GreenBadge from "@/Components/Badges/GreenBadge.vue";
import RedBadge from "@/Components/Badges/RedBadge.vue";
import BulkActionButton from "@/Components/Buttons/BulkActionButton.vue";
import InertiaLinkButton from "@/Components/Buttons/InertiaLinkButton.vue";
import NormalButton from "@/Components/Buttons/NormalButton.vue";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { useResourceActions } from "@/Composables/useResourceActions";
import { Head } from "@inertiajs/vue3";
import { __ } from "@/Services/translations-inside-setup.js";
import { useQueryStringParams } from "@/Composables/useQueryStringParams";

defineProps({ categories: Object });

const categoryList = "admin.categories.index";

const { queryStringParams } = useQueryStringParams();

const { softDeleteAction, selectedSoftDeleteAction, softDeleteAllAction } =
  useResourceActions();
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('Categories')" />

    <!-- Breadcrumb And Trash Button  -->
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col items-start md:flex-row md:items-center md:justify-between mb-4 md:mb-8"
      >
        <Breadcrumb :to="categoryList" icon="fa-list" label="Categories">
          <BreadcrumbItem label="List" />
        </Breadcrumb>
      </div>

      <div class="flex items-center justify-between mb-3">
        <!-- Create New Button -->
        <InertiaLinkButton
          v-show="can('categories.create')"
          to="admin.categories.create"
          :data="queryStringParams"
        >
          <i class="fa-solid fa-file-circle-plus mr-1"></i>
          {{ __("Create A New :label", { label: __("Category") }) }}
        </InertiaLinkButton>

        <!-- Trash Button -->
        <InertiaLinkButton
          v-show="can('categories.view.trash')"
          to="admin.categories.trashed"
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
            :to="categoryList"
          />

          <div class="flex items-center justify-end w-full md:space-x-5">
            <DashboardTableDataPerPageSelectBox :to="categoryList" />

            <DashboardTableFilterByDate :to="categoryList" />
          </div>
        </div>

        <TableContainer>
          <ActionTable :items="categories.data">
            <!-- Table Actions -->
            <template #bulk-actions="{ selectedItems }">
              <div v-show="can('categories.delete')">
                <BulkActionButton
                  @click="
                    selectedSoftDeleteAction(
                      'Categories',
                      'admin.categories.destroy.selected',
                      selectedItems
                    )
                  "
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete Selected") }} ({{ selectedItems.length }})
                </BulkActionButton>
                <BulkActionButton
                  @click="
                    softDeleteAllAction(
                      'Category',
                      'admin.categories.destroy.all'
                    )
                  "
                  class="text-red-600"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete All") }} ({{ categories.total }})
                </BulkActionButton>
              </div>
            </template>

            <!-- Table Header -->
            <template #table-header>
              <SortableTableHeaderCell
                label="# No"
                :to="categoryList"
                sort="id"
              />

              <TableHeaderCell label="Image" />

              <SortableTableHeaderCell
                label="Name"
                :to="categoryList"
                sort="name"
              />

              <TableHeaderCell label="Status" />

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
                <GreenBadge v-if="item?.status === 'show'">
                  <i class="fa-solid fa-eye animate-pulse"></i>
                  Show
                </GreenBadge>
                <RedBadge v-else>
                  <i class="fa-solid fa-eye-slash animate-pulse"></i>
                  Hide
                </RedBadge>
              </TableDataCell>

              <TableActionCell>
                <InertiaLinkButton
                  v-show="can('categories.edit')"
                  to="admin.categories.edit"
                  :targetIdentifier="item"
                  :data="queryStringParams"
                >
                  <i class="fa-solid fa-edit"></i>
                  {{ __("Edit") }}
                </InertiaLinkButton>

                <NormalButton
                  v-show="can('categories.delete')"
                  @click="
                    softDeleteAction(
                      'Category',
                      'admin.categories.destroy',
                      item
                    )
                  "
                  class="bg-red-600 text-white ring-2 ring-red-300"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete") }}
                </NormalButton>
              </TableActionCell>
            </template>
          </ActionTable>
        </TableContainer>

        <Pagination :data="categories" />

        <NoTableData v-show="!categories.data.length" />
      </div>
      <!-- Table End -->
    </div>
  </AdminDashboardLayout>
</template>

