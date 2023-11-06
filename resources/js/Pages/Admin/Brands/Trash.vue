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
import InertiaLinkButton from "@/Components/Buttons/InertiaLinkButton.vue";
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

const { restoreAction, permanentDeleteAction, permanentDeleteAllAction } =
  useResourceActions();
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('Trashed Brands')" />
    <!-- Breadcrumb And Go back Button  -->
    <div class="min-h-screen py-10 font-poppins">
      <div
        class="flex flex-col md:flex-row items-center md:justify-between mb-5"
      >
        <Breadcrumb :to="brandList" icon="fa-award" label="Brands">
          <BreadcrumbLinkItem label="Trash" :to="trashedBrandList" />
          <BreadcrumbItem label="List" />
        </Breadcrumb>

        <GoBackButton :to="brandList" />
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

          <div class="flex items-center space-x-5">
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
              permanentDeleteAllAction('Brand', 'admin.brands.force-delete-all')
            "
          />
        </div>

        <TableContainer>
          <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
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
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(trashBrand, index) in trashedBrands.data"
                :key="trashBrand.id"
                :class="{
                  'border-b': index !== trashedBrands.data.length - 1,
                }"
              >
                <TableDataCell>
                  {{ trashBrand.id }}
                </TableDataCell>

                <TableDataCell>
                  <Image :src="trashBrand.image" />
                </TableDataCell>

                <TableDataCell>
                  {{ trashBrand.name }}
                </TableDataCell>

                <TableDataCell>
                  {{ trashBrand.description }}
                </TableDataCell>

                <TableActionCell>
                  <NormalButton
                    v-show="can('brands.restore')"
                    @click="
                      restoreAction('Brand', 'admin.brands.restore', trashBrand)
                    "
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
                        trashBrand
                      )
                    "
                    class="bg-red-600 text-white ring-2 ring-red-300"
                  >
                    <i class="fa-solid fa-trash-can"></i>
                    Delete Forever
                  </NormalButton>
                </TableActionCell>
              </tr>
            </tbody>
          </table>
        </TableContainer>

        <Pagination :data="trashedBrands" />

        <NoTableData v-show="!trashedBrands.data.length" />
      </div>
      <!-- Table End -->
    </div>
  </AdminDashboardLayout>
</template>


