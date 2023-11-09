<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import DashboardTableDataSearchBox from "@/Components/Forms/SearchBoxs/DashboardTableDataSearchBox.vue";
import DashboardTableDataPerPageSelectBox from "@/Components/Forms/SelectBoxs/DashboardTableDataPerPageSelectBox.vue";
import DashboardTableFilterByDate from "@/Components/Forms/SelectBoxs/DashboardTableFilterByDate.vue";
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
import BulkActionButton from "@/Components/Buttons/BulkActionButton.vue";
import NormalButton from "@/Components/Buttons/NormalButton.vue";
import InertiaLinkButton from "@/Components/Buttons/InertiaLinkButton.vue";
import EmptyTrashButton from "@/Components/Buttons/EmptyTrashButton.vue";
import NoTableData from "@/Components/Table/NoTableData.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { useResourceActions } from "@/Composables/useResourceActions";
import { Head } from "@inertiajs/vue3";
import { useQueryStringParams } from "@/Composables/useQueryStringParams";

// Define the Props
defineProps({ trashedCollections: Object });

const collectionList = "admin.collections.index";

const trashedCollectionList = "admin.collections.trashed";

const { queryStringParams } = useQueryStringParams();

const {
  restoreAction,
  restoreSelectedAction,
  permanentDeleteAction,
  permanentDeleteSelectedAction,
  permanentDeleteAllAction,
} = useResourceActions();
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('Deleted :label', { label: __('Collection') })" />
    <!-- Breadcrumb And Go back Button  -->
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col items-start md:flex-row md:items-center md:justify-between mb-4 md:mb-8"
      >
        <Breadcrumb :to="collectionList" icon="fa-box" label="Collections">
          <BreadcrumbLinkItem label="Trash" :to="trashedCollectionList" />
          <BreadcrumbItem label="List" />
        </Breadcrumb>

        <div class="w-full flex items-center justify-end">
          <InertiaLinkButton
            :to="collectionList"
            :data="{
              page: 1,
              per_page: 5,
              sort: 'id',
              direction: 'desc',
            }"
          >
            <i class="fa-solid fa-left-long"></i>
            {{ __("Go Back") }}
          </InertiaLinkButton>
        </div>
      </div>

      <!-- Message -->
      <div
        v-if="
          can('collections.force.delete') &&
          trashedCollections.data.length !== 0
        "
        class="text-left text-sm font-bold mb-2 text-warning-600"
      >
        {{
          __(
            ":label in the trash will be automatically deleted after 60 days",
            { label: __("Collections") }
          )
        }}

        <EmptyTrashButton
          @click="
            permanentDeleteAllAction(
              'Collection',
              'admin.collections.force-delete.all'
            )
          "
        />
      </div>

      <!-- Table Start -->
      <div class="border bg-white rounded-md shadow px-5 py-3">
        <div
          class="my-5 flex flex-col sm:flex-row space-y-5 sm:space-y-0 items-center justify-between"
        >
          <DashboardTableDataSearchBox
            :placeholder="
              __('Search by :label', { label: __('Title') }) + '...'
            "
            :to="trashedCollectionList"
          />

          <div class="flex items-center justify-end w-full md:space-x-5">
            <DashboardTableDataPerPageSelectBox :to="trashedCollectionList" />

            <DashboardTableFilterByDate :to="trashedCollectionList" />
          </div>
        </div>

        <TableContainer>
          <ActionTable :items="trashedCollections.data">
            <!-- Table Actions -->
            <template #bulk-actions="{ selectedItems }">
              <BulkActionButton
                v-show="can('collections.restore')"
                @click="
                  restoreSelectedAction(
                    'Collections',
                    'admin.collections.restore.selected',
                    selectedItems
                  )
                "
              >
                <i class="fa-solid fa-recycle"></i>
                {{ __("Restore Selected") }} ({{ selectedItems.length }})
              </BulkActionButton>

              <BulkActionButton
                v-show="can('collections.force.delete')"
                @click="
                  permanentDeleteSelectedAction(
                    'Collections',
                    'admin.collections.force-delete.selected',
                    selectedItems
                  )
                "
                class="text-red-600"
              >
                <i class="fa-solid fa-trash-can"></i>
                {{ __("Delete Selected") }} ({{ selectedItems.length }})
              </BulkActionButton>
            </template>

            <!-- Table Header -->
            <template #table-header>
              <SortableTableHeaderCell
                label="# No"
                :to="trashedCollectionList"
                sort="id"
              />

              <SortableTableHeaderCell
                label="Title"
                :to="trashedCollectionList"
                sort="title"
              />

              <SortableTableHeaderCell
                label="Description"
                :to="trashedCollectionList"
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
                <NormalButton
                  v-show="can('collections.restore')"
                  @click="
                    restoreAction(
                      'Collection',
                      'admin.collections.restore',
                      item
                    )
                  "
                >
                  <i class="fa-solid fa-recycle"></i>
                  {{ __("Restore") }}
                </NormalButton>

                <NormalButton
                  v-show="can('collections.force.delete')"
                  @click="
                    permanentDeleteAction(
                      'Collection',
                      'admin.collections.force-delete',
                      item
                    )
                  "
                  class="bg-red-600 text-white ring-2 ring-red-300"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete Forever") }}
                </NormalButton>
              </TableActionCell>
            </template>
          </ActionTable>
        </TableContainer>

        <Pagination :data="trashedCollections" />

        <NoTableData v-show="!trashedCollections.data.length" />
      </div>
      <!-- Table End -->
    </div>
  </AdminDashboardLayout>
</template>


