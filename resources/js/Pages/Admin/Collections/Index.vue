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
import NoTableData from "@/Components/Table/NoTableData.vue";
import BulkActionButton from "@/Components/Buttons/BulkActionButton.vue";
import InertiaLinkButton from "@/Components/Buttons/InertiaLinkButton.vue";
import NormalButton from "@/Components/Buttons/NormalButton.vue";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { useResourceActions } from "@/Composables/useResourceActions";
import { Head } from "@inertiajs/vue3";
import { __ } from "@/Services/translations-inside-setup.js";
import { useQueryStringParams } from "@/Composables/useQueryStringParams";

defineProps({ collections: Object });

const collectionList = "admin.collections.index";

const { queryStringParams } = useQueryStringParams();

const { softDeleteAction, selectedSoftDeleteAction, softDeleteAllAction } =
  useResourceActions();
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('Collections')" />

    <!-- Breadcrumb And Trash Button  -->
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col items-start md:flex-row md:items-center md:justify-between mb-4 md:mb-8"
      >
        <Breadcrumb :to="collectionList" icon="fa-box" label="Collections">
          <BreadcrumbItem label="List" />
        </Breadcrumb>
      </div>

      <div class="flex items-center justify-between mb-3">
        <!-- Create New Button -->
        <InertiaLinkButton
          v-show="can('collections.create')"
          to="admin.collections.create"
          :data="queryStringParams"
        >
          <i class="fa-solid fa-file-circle-plus mr-1"></i>
          {{ __("Create A New :label", { label: __("Collection") }) }}
        </InertiaLinkButton>

        <!-- Trash Button -->
        <InertiaLinkButton
          v-show="can('collections.view.trash')"
          to="admin.collections.trashed"
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
            :placeholder="
              __('Search by :label', { label: __('Title') }) + '...'
            "
            :to="collectionList"
          />

          <div class="flex items-center justify-end w-full md:space-x-5">
            <DashboardTableDataPerPageSelectBox :to="collectionList" />

            <DashboardTableFilterByDate :to="collectionList" />
          </div>
        </div>

        <TableContainer>
          <ActionTable :items="collections.data">
            <!-- Table Actions -->
            <template #bulk-actions="{ selectedItems }">
              <div v-show="can('collections.delete')">
                <BulkActionButton
                  @click="
                    selectedSoftDeleteAction(
                      'Collections',
                      'admin.collections.destroy.selected',
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
                      'Collection',
                      'admin.collections.destroy.all'
                    )
                  "
                  class="text-red-600"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete All") }} ({{ collections.total }})
                </BulkActionButton>
              </div>
            </template>

            <!-- Table Header -->
            <template #table-header>
              <SortableTableHeaderCell
                label="# No"
                :to="collectionList"
                sort="id"
              />

              <SortableTableHeaderCell
                label="Title"
                :to="collectionList"
                sort="title"
              />

              <SortableTableHeaderCell
                label="Description"
                :to="collectionList"
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
                {{ item?.title }}
              </TableDataCell>

              <TableDataCell>
                {{ item?.description }}
              </TableDataCell>

              <TableActionCell>
                <InertiaLinkButton
                  v-show="can('collections.edit')"
                  to="admin.collections.edit"
                  :targetIdentifier="item"
                  :data="queryStringParams"
                >
                  <i class="fa-solid fa-edit"></i>
                  {{ __("Edit") }}
                </InertiaLinkButton>

                <NormalButton
                  v-show="can('collections.delete')"
                  @click="
                    softDeleteAction(
                      'Collection',
                      'admin.collections.destroy',
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

        <Pagination :data="collections" />

        <NoTableData v-show="!collections.data.length" />
      </div>
      <!-- Table End -->
    </div>
  </AdminDashboardLayout>
</template>

