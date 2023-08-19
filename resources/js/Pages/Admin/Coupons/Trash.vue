<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CouponBreadcrumb.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import RestoreButton from "@/Components/Buttons/RestoreButton.vue";
import DeleteForeverButton from "@/Components/Buttons/DeleteForeverButton.vue";
import EmptyTrashButton from "@/Components/Buttons/EmptyTrashButton.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByDeletedDate from "@/Components/Forms/DashboardFilterByDeletedDate.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import { __ } from "@/Translations/translations-inside-setup.js";
import { reactive, inject, computed, ref } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the Props
const props = defineProps({
  trashCoupons: Object,
});

// Define  Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Coupon Trash Restore Permission
const couponTrashRestore = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "coupon.trash.restore"
      )
    : false;
});

// Coupon Trash Delete Permission
const couponTrashDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "coupon.trash.delete"
      )
    : false;
});

// Formatted Amount
const formattedAmount = (amount) => {
  const totalAmount = parseFloat(amount);
  if (Number.isInteger(totalAmount)) {
    return totalAmount.toFixed(0);
  } else {
    return totalAmount.toFixed(2);
  }
};

// Formatted Discount Type
const formattedDiscountType = (suggestionType) => {
  const words = suggestionType.split("_");
  const capitalizedWords = words.map(
    (word) => word.charAt(0).toUpperCase() + word.slice(1)
  );
  const formattedString = capitalizedWords.join(" ");

  return formattedString;
};

// Query String Parameteres
const params = reactive({
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
});

// Update Sorting Table Column
const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  router.get(
    route("admin.coupons.trash"),
    {
      search: usePage().props.ziggy.query?.search,
      page: usePage().props.ziggy.query?.page,
      per_page: usePage().props.ziggy.query?.per_page,
      sort: params.sort,
      direction: params.direction,
      deleted_from: usePage().props.ziggy.query?.deleted_from,
      deleted_until: usePage().props.ziggy.query?.deleted_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Handle Trash Coupon Restore
const handleRestoreTrashCoupon = async (trashCouponId) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_RESTORE_THIS_COUPON"),
    showCancelButton: true,
    confirmButtonText: __("YES_RESTORE_IT"),
    cancelButtonText: __("CANCEL"),
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.coupons.trash.restore", {
        trash_coupon_id: trashCouponId,
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        deleted_from: usePage().props.ziggy.query?.deleted_from,
        deleted_until: usePage().props.ziggy.query?.deleted_until,
      }),
      {},
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: __(usePage().props.flash.successMessage),
            });
          }
        },
      }
    );
  }
};

// Handle Trash Coupon Delete
const handleDeleteTrashCoupon = async (trashCouponId) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_IT_FROM_THE_TRASH"),
    text: __(
      "COUPON_IN_THE_TRASH_WILL_BE_PERMANETLY_DELETED_YOU_CANT_GET_IT_BACK"
    ),
    showCancelButton: true,
    confirmButtonText: __("YES_DELETE_IT"),
    cancelButtonText: __("CANCEL"),
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.coupons.trash.force.delete", {
        trash_coupon_id: trashCouponId,
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        deleted_from: usePage().props.ziggy.query?.deleted_from,
        deleted_until: usePage().props.ziggy.query?.deleted_until,
      }),
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: __(usePage().props.flash.successMessage),
            });
          }
        },
      }
    );
  }
};

// Handle Trash Coupon Delete Permanently
const handlePermanentlyDeleteTrashCoupons = async () => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_IT_FROM_THE_TRASH"),
    text: __(
      "ALL_COUPONS_IN_THE_TRASH_WILL_BE_PERMANETLY_DELETED_YOU_CANT_GET_IT_BACK"
    ),
    showCancelButton: true,
    confirmButtonText: __("YES_DELETE_IT"),
    cancelButtonText: __("CANCEL"),
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.coupons.trash.permanently.delete", {
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        deleted_from: usePage().props.ziggy.query?.deleted_from,
        deleted_until: usePage().props.ziggy.query?.deleted_until,
      }),
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: __(usePage().props.flash.successMessage),
            });
          }
        },
      }
    );
  }
};
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('TRASH_COUPONS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb>
          <li aria-current="page">
            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-6 h-6 text-gray-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              <span
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
              >
                {{ __("TRASH") }}
              </span>
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back Button -->
        <div>
          <GoBackButton
            href="admin.coupons.index"
            :queryStringParams="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
          />
        </div>
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Box -->
        <DashboardSearchInputForm
          href="admin.coupons.trash"
          placeholder="SEARCH_BY_CODE"
        />
        <!-- Perpage Select Box -->
        <div class="ml-5">
          <DashboardPerPageSelectBox href="admin.coupons.trash" />
        </div>

        <!-- Filter By Date -->
        <DashboardFilterByDeletedDate href="admin.coupons.trash" />
      </div>

      <p
        v-if="couponTrashDelete && trashCoupons.data.length !== 0"
        class="text-left text-sm font-bold mb-2 text-warning-600"
      >
        {{
          __("COUPONS_IN_THE_TRASH_WILL_BE_AUTOMATICALLY_DELETED_AFTER_60_DAYS")
        }}

        <EmptyTrashButton @click="handlePermanentlyDeleteTrashCoupons" />
      </p>

      <!-- Trash Coupon Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('code')">
            {{ __("CODE") }}
            <SortingArrows :params="params" sort="code" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('discount_type')">
            {{ __("DISCOUNT_TYPE") }}
            <SortingArrows :params="params" sort="discount_type" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('discount_amount')">
            {{ __("DISCOUNT_AMOUNT") }}
            <SortingArrows :params="params" sort="discount_amount" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('min_spend')">
            {{ __("MINIMUN_SPEND") }}
            <SortingArrows :params="params" sort="min_spend" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('max_uses')">
            {{ __("MAX_USES") }}
            <SortingArrows :params="params" sort="max_uses" />
          </HeaderTh>

          <HeaderTh> {{ __("TOTAL_USED") }} </HeaderTh>

          <HeaderTh @click="updateSorting('deleted_at')">
            {{ __("DELETED_DATE") }}
            <SortingArrows :params="params" sort="deleted_at" />
          </HeaderTh>

          <HeaderTh v-if="couponTrashRestore || couponTrashDelete">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="trashCoupons.data.length">
          <Tr v-for="trashCoupon in trashCoupons.data" :key="trashCoupon.id">
            <BodyTh>
              {{ trashCoupon.id }}
            </BodyTh>

            <Td>
              {{ trashCoupon.code }}
            </Td>

            <Td>
              {{ formattedDiscountType(trashCoupon.discount_type) }}
            </Td>

            <Td>
              <span v-if="trashCoupon.discount_type === 'fixed_amount'">
                $ {{ formattedAmount(trashCoupon.discount_amount) }}
              </span>
              <span v-if="trashCoupon.discount_type === 'percentage'">
                % {{ formattedAmount(trashCoupon.discount_amount) }}
              </span>
            </Td>

            <Td> $ {{ formattedAmount(trashCoupon.min_spend) }} </Td>

            <Td>
              {{ trashCoupon.max_uses }}
            </Td>

            <Td>
              {{ trashCoupon.uses_count ? trashCoupon.uses_count : 0 }}
            </Td>

            <Td>
              {{ trashCoupon.deleted_at }}
            </Td>

            <Td v-if="couponTrashRestore || couponTrashDelete">
              <!-- Restore Button -->
              <div v-if="couponTrashRestore">
                <RestoreButton
                  @click="handleRestoreTrashCoupon(trashCoupon.id)"
                />
              </div>

              <!-- Delete Button -->
              <div v-if="couponTrashDelete">
                <DeleteForeverButton
                  @click="handleDeleteTrashCoupon(trashCoupon.id)"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Trash Coupon Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!trashCoupons.data.length" />

      <!-- Pagination -->
      <div v-if="trashCoupons.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ trashCoupons.from }} - {{ trashCoupons.to }} of
          {{ trashCoupons.total }}
        </p>
        <Pagination :links="trashCoupons.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>


