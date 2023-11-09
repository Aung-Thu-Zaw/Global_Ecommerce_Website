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
import BlueBadge from "@/Components/Badges/BlueBadge.vue";
import GreenBadge from "@/Components/Badges/GreenBadge.vue";
import OrangeBadge from "@/Components/Badges/OrangeBadge.vue";
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
  products: Object,
});

const productList = "admin.products.index";

const { queryStringParams } = useQueryStringParams();

const { softDeleteAction, selectedSoftDeleteAction } = useResourceActions();
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('Products')" />

    <!-- Breadcrumb And Trash Button  -->
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col items-start md:flex-row md:items-center md:justify-between mb-4 md:mb-8"
      >
        <Breadcrumb
          :to="productList"
          icon="fa-basket-shopping"
          label="Products"
        >
          <BreadcrumbItem label="List" />
        </Breadcrumb>
      </div>

      <div class="flex items-center justify-between mb-3">
        <!-- Create New Button -->
        <InertiaLinkButton
          v-show="can('products.create')"
          to="admin.products.create"
          :data="queryStringParams"
        >
          <i class="fa-solid fa-file-circle-plus mr-1"></i>
          {{ __("Create A New :label", { label: __("Product") }) }}
        </InertiaLinkButton>

        <!-- Trash Button -->
        <InertiaLinkButton
          v-show="can('products.view.trash')"
          to="admin.products.trashed"
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
            :to="productList"
          />

          <div class="flex items-center justify-end w-full md:space-x-5">
            <DashboardTableDataPerPageSelectBox :to="productList" />

            <DashboardTableFilterByDate :to="productList" />
          </div>
        </div>

        <TableContainer>
          <ActionTable :items="products.data">
            <!-- Table Actions -->
            <template #bulk-actions="{ selectedItems }">
              <BulkActionButton
                v-show="can('products.delete')"
                @click="
                  selectedSoftDeleteAction(
                    'Products',
                    'admin.products.destroy.selected',
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
                :to="productList"
                sort="id"
              />

              <TableHeaderCell label="Image" />

              <SortableTableHeaderCell
                label="Name"
                :to="productList"
                sort="name"
              />

              <SortableTableHeaderCell
                label="Price"
                :to="productList"
                sort="price"
              />

              <SortableTableHeaderCell
                label="Discount"
                :to="productList"
                sort="discount"
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
                <div class="min-w-[250px]">
                  {{ item?.name }}
                </div>
              </TableDataCell>

              <TableDataCell>
                <div class="min-w-[100px]">
                  {{ item?.price }}
                </div>
              </TableDataCell>

              <TableDataCell>
                <div class="min-w-[100px]">
                  {{ item?.discount }}
                </div>
              </TableDataCell>

              <TableDataCell>
                <div class="min-w-[100px]">
                  <BlueBadge v-if="item?.status === 'pending'">
                    <i class="fa-solid fa-spinner animate-spin"></i>
                    Pending
                  </BlueBadge>
                  <GreenBadge v-if="item?.status === 'approved'">
                    <i class="fa-solid fa-circle-check animate-pulse"></i>
                    Approved
                  </GreenBadge>
                  <OrangeBadge v-if="item?.status === 'disapproved'">
                    <i class="fa-solid fa-circle-xmark animate-pulse"></i>
                    Disapproved
                  </OrangeBadge>
                </div>
              </TableDataCell>

              <TableActionCell>
                <InertiaLinkButton
                  v-show="can('products.edit')"
                  to="admin.products.edit"
                  :targetIdentifier="item"
                  :data="queryStringParams"
                >
                  <i class="fa-solid fa-edit"></i>
                  {{ __("Edit") }}
                </InertiaLinkButton>

                <NormalButton
                  v-show="can('products.delete')"
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

        <Pagination :data="products" />

        <NoTableData v-show="!products.data.length" />
      </div>
      <!-- Table End -->
    </div>
  </AdminDashboardLayout>
</template>

