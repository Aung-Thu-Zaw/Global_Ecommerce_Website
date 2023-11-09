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
import BlueBadge from "@/Components/Badges/BlueBadge.vue";
import OrangeBadge from "@/Components/Badges/OrangeBadge.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { useResourceActions } from "@/Composables/useResourceActions";
import { Head } from "@inertiajs/vue3";
import { useQueryStringParams } from "@/Composables/useQueryStringParams";
import { useFormatFunctions } from "@/Composables/useFormatFunctions";

// Define the Props
defineProps({ trashedCoupons: Object });

const couponList = "admin.coupons.index";

const trashedCouponList = "admin.coupons.trashed";

const { queryStringParams } = useQueryStringParams();

const { formatAmount } = useFormatFunctions();

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
    <Head :title="__('Deleted :label', { label: __('Coupons') })" />
    <!-- Breadcrumb And Go back Button  -->
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col items-start md:flex-row md:items-center md:justify-between mb-4 md:mb-8"
      >
        <Breadcrumb :to="couponList" icon="fa-ticket" label="Coupons">
          <BreadcrumbLinkItem label="Trash" :to="trashedCouponList" />
          <BreadcrumbItem label="List" />
        </Breadcrumb>

        <div class="w-full flex items-center justify-end">
          <InertiaLinkButton
            :to="couponList"
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
        v-if="can('coupons.force.delete') && trashedCoupons.data.length !== 0"
        class="text-left text-sm font-bold mb-2 text-warning-600"
      >
        {{
          __(
            ":label in the trash will be automatically deleted after 60 days",
            { label: __("Coupons") }
          )
        }}

        <EmptyTrashButton
          @click="
            permanentDeleteAllAction('Coupon', 'admin.coupons.force-delete.all')
          "
        />
      </div>

      <!-- Table Start -->
      <div class="border bg-white rounded-md shadow px-5 py-3">
        <div
          class="my-5 flex flex-col sm:flex-row space-y-5 sm:space-y-0 items-center justify-between"
        >
          <DashboardTableDataSearchBox
            :placeholder="__('Search by :label', { label: __('Code') }) + '...'"
            :to="trashedCouponList"
          />

          <div class="flex items-center justify-end w-full md:space-x-5">
            <DashboardTableDataPerPageSelectBox :to="trashedCouponList" />

            <DashboardTableFilterByDate :to="trashedCouponList" />
          </div>
        </div>

        <TableContainer>
          <ActionTable :items="trashedCoupons.data">
            <!-- Table Actions -->
            <template #bulk-actions="{ selectedItems }">
              <div v-show="can('coupons.restore')">
                <BulkActionButton
                  @click="
                    restoreSelectedAction(
                      'Coupons',
                      'admin.coupons.restore.selected',
                      selectedItems
                    )
                  "
                >
                  <i class="fa-solid fa-recycle"></i>
                  {{ __("Restore Selected") }} ({{ selectedItems.length }})
                </BulkActionButton>
                <BulkActionButton
                  @click="
                    restoreAllAction('Coupon', 'admin.coupons.restore.all')
                  "
                >
                  <i class="fa-solid fa-recycle"></i>
                  {{ __("Restore All") }} ({{ trashedCoupons.total }})
                </BulkActionButton>
              </div>
              <div v-show="can('coupons.force.delete')">
                <BulkActionButton
                  @click="
                    permanentDeleteSelectedAction(
                      'Coupons',
                      'admin.coupons.force-delete.selected',
                      selectedItems
                    )
                  "
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete Selected") }} ({{ selectedItems.length }})
                </BulkActionButton>
                <BulkActionButton
                  @click="
                    permanentDeleteAllAction(
                      'Coupon',
                      'admin.coupons.force-delete.all'
                    )
                  "
                  class="text-red-600"
                >
                  <i class="fa-solid fa-trash-can"></i>
                  {{ __("Delete All") }} ({{ trashedCoupons.total }})
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
                <NormalButton
                  v-show="can('coupons.restore')"
                  @click="
                    restoreAction('Coupon', 'admin.coupons.restore', item)
                  "
                >
                  <i class="fa-solid fa-recycle"></i>
                  {{ __("Restore") }}
                </NormalButton>

                <NormalButton
                  v-show="can('coupons.force.delete')"
                  @click="
                    permanentDeleteAction(
                      'Coupon',
                      'admin.coupons.force-delete',
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

        <Pagination :data="trashedCoupons" />

        <NoTableData v-show="!trashedCoupons.data.length" />
      </div>
      <!-- Table End -->
    </div>
  </AdminDashboardLayout>
</template>


