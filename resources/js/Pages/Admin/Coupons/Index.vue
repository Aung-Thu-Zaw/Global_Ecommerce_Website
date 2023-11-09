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
import BlueBadge from "@/Components/Badges/BlueBadge.vue";
import OrangeBadge from "@/Components/Badges/OrangeBadge.vue";
import BulkActionButton from "@/Components/Buttons/BulkActionButton.vue";
import InertiaLinkButton from "@/Components/Buttons/InertiaLinkButton.vue";
import NormalButton from "@/Components/Buttons/NormalButton.vue";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { useResourceActions } from "@/Composables/useResourceActions";
import { Head } from "@inertiajs/vue3";
import { __ } from "@/Services/translations-inside-setup.js";
import { useQueryStringParams } from "@/Composables/useQueryStringParams";
import { useFormatFunctions } from "@/Composables/useFormatFunctions";

defineProps({ coupons: Object });

const couponList = "admin.coupons.index";

const { queryStringParams } = useQueryStringParams();

const { formatAmount } = useFormatFunctions();

const { softDeleteAction, selectedSoftDeleteAction, softDeleteAllAction } =
  useResourceActions();
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('Coupons')" />

    <!-- Breadcrumb And Trash Button  -->
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col items-start md:flex-row md:items-center md:justify-between mb-4 md:mb-8"
      >
        <Breadcrumb :to="couponList" icon="fa-ticket" label="Coupons">
          <BreadcrumbItem label="List" />
        </Breadcrumb>
      </div>

      <div class="flex items-center justify-between mb-3">
        <!-- Create New Button -->
        <InertiaLinkButton
          v-show="can('coupons.create')"
          to="admin.coupons.create"
          :data="queryStringParams"
        >
          <i class="fa-solid fa-file-circle-plus mr-1"></i>
          {{ __("Create A New :label", { label: __("Coupon") }) }}
        </InertiaLinkButton>

        <!-- Trash Button -->
        <InertiaLinkButton
          v-show="can('coupons.view.trash')"
          to="admin.coupons.trashed"
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
      <div class="bg-white rounded-md shadow px-5 py-3">
        <div
          class="my-5 flex flex-col sm:flex-row space-y-5 sm:space-y-0 items-center justify-between overflow-auto p-2"
        >
          <DashboardTableDataSearchBox
            :placeholder="__('Search by :label', { label: __('Code') }) + '...'"
            :to="couponList"
          />

          <div class="flex items-center justify-end w-full md:space-x-5">
            <DashboardTableDataPerPageSelectBox :to="couponList" />

            <DashboardTableFilterByDate :to="couponList" />
          </div>
        </div>

        <TableContainer>
          <ActionTable :items="coupons.data">
            <!-- Table Actions -->
            <template #bulk-actions="{ selectedItems }">
              <div v-show="can('coupons.delete')">
                <BulkActionButton
                  @click="
                    selectedSoftDeleteAction(
                      'Coupons',
                      'admin.coupons.destroy.selected',
                      selectedItems
                    )
                  "
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete Selected") }} ({{ selectedItems.length }})
                </BulkActionButton>
                <BulkActionButton
                  @click="
                    softDeleteAllAction('Coupon', 'admin.coupons.destroy.all')
                  "
                  class="text-red-600"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete All") }} ({{ coupons.total }})
                </BulkActionButton>
              </div>
            </template>

            <!-- Table Header -->
            <template #table-header>
              <SortableTableHeaderCell
                label="# No"
                :to="couponList"
                sort="id"
              />

              <SortableTableHeaderCell
                label="Code"
                :to="couponList"
                sort="code"
              />

              <TableHeaderCell label="Discount Type" />

              <TableHeaderCell label="Discount Amount" />

              <TableHeaderCell label="Minimum Spend" />

              <TableHeaderCell label="Maximum Uses" />

              <TableHeaderCell label="Total Used" />

              <TableHeaderCell label="Actions" />
            </template>

            <!-- Table Body -->
            <template #table-data="{ item }">
              <TableDataCell>
                {{ item?.id }}
              </TableDataCell>

              <TableDataCell>
                <div class="min-w-[200px]">
                  {{ item?.code }}
                </div>
              </TableDataCell>

              <TableDataCell>
                <div class="min-w-[150px]">
                  <BlueBadge v-if="item?.discount_type === 'fixed_amount'">
                    <i class="fa-solid fa-dollar-sign animate-pulse"></i>
                    Fixed Amount
                  </BlueBadge>
                  <OrangeBadge v-else>
                    <i class="fa-solid fa-percentage animate-pulse"></i>
                    Percentage
                  </OrangeBadge>
                </div>
              </TableDataCell>

              <TableDataCell>
                <div class="min-w-[130px]">
                  {{ formatAmount(item?.discount_amount) }}
                </div>
              </TableDataCell>

              <TableDataCell>
                <div class="min-w-[130px]">
                  {{ formatAmount(item?.min_spend) }}
                </div>
              </TableDataCell>

              <TableDataCell>
                <div class="min-w-[130px]">
                  {{ item?.max_uses }}
                </div>
              </TableDataCell>

              <TableDataCell>
                <div class="min-w-[130px]">
                  {{ item.uses_count ? item.uses_count : 0 }}
                </div>
              </TableDataCell>

              <TableActionCell>
                <InertiaLinkButton
                  v-show="can('coupons.edit')"
                  to="admin.coupons.edit"
                  :targetIdentifier="item"
                  :data="queryStringParams"
                >
                  <i class="fa-solid fa-edit"></i>
                  {{ __("Edit") }}
                </InertiaLinkButton>

                <NormalButton
                  v-show="can('coupons.delete')"
                  @click="
                    softDeleteAction('Coupon', 'admin.coupons.destroy', item)
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

        <Pagination :data="coupons" />

        <NoTableData v-show="!coupons.data.length" />
      </div>
      <!-- Table End -->
    </div>
  </AdminDashboardLayout>
</template>

