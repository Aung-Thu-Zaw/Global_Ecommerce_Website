<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CouponBreadcrumb.vue";
import CreateButton from "@/Components/Buttons/CreateButton.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import EditButton from "@/Components/Buttons/EditButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByCreatedDate from "@/Components/Forms/DashboardFilterByCreatedDate.vue";
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
import { inject, computed, ref, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  coupons: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Coupon Permission
const couponAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "coupon.add")
    : false;
});

// Coupon Edit Permission
const couponEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "coupon.edit")
    : false;
});

// Coupon Delete Permission
const couponDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "coupon.delete"
      )
    : false;
});

// Coupon Trash List Permission
const couponTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "coupon.trash.list"
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
    route("admin.coupons.index"),
    {
      search: usePage().props.ziggy.query?.search,
      page: usePage().props.ziggy.query?.page,
      per_page: usePage().props.ziggy.query?.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: usePage().props.ziggy.query?.created_from,
      created_until: usePage().props.ziggy.query?.created_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Handle Coupon Delete
const handleDeleteCoupon = async (coupon) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_COUPON"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_COUPON_IN_THE_TRASH"),
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
      route("admin.coupons.destroy", {
        coupon: coupon,
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: usePage().props.ziggy.query?.created_from,
        created_until: usePage().props.ziggy.query?.created_until,
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

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: __(usePage().props.flash.successMessage),
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('COUPONS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="couponTrashList">
          <TrashButton href="admin.coupons.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Coupon Button -->
        <div v-if="couponAdd">
          <CreateButton href="admin.coupons.create" name="ADD_COUPON" />
        </div>

        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.coupons.index"
            placeholder="SEARCH_BY_CODE"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.coupons.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.coupons.index" />
        </div>
      </div>

      <!-- Coupon Table Start -->
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

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="couponEdit || couponDelete">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="coupons.data.length">
          <Tr v-for="coupon in coupons.data" :key="coupon.id">
            <BodyTh>
              {{ coupon.id }}
            </BodyTh>

            <Td>
              {{ coupon.code }}
            </Td>

            <Td>
              {{ formattedDiscountType(coupon.discount_type) }}
            </Td>

            <Td>
              <span v-if="coupon.discount_type === 'fixed_amount'">
                $ {{ formattedAmount(coupon.discount_amount) }}
              </span>
              <span v-if="coupon.discount_type === 'percentage'">
                % {{ formattedAmount(coupon.discount_amount) }}
              </span>
            </Td>

            <Td> $ {{ formattedAmount(coupon.min_spend) }} </Td>

            <Td>
              {{ coupon.max_uses }}
            </Td>

            <Td>
              {{ coupon.uses_count ? coupon.uses_count : 0 }}
            </Td>

            <Td>
              {{ coupon.created_at }}
            </Td>

            <Td v-if="couponEdit || couponDelete" class="flex items-center">
              <!-- Edit Button -->
              <div v-if="couponEdit">
                <EditButton href="admin.coupons.edit" :id="coupon.id" />
              </div>

              <!-- Delete Button -->
              <div v-if="couponDelete">
                <DeleteButton @click="handleDeleteCoupon(coupon.id)" />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Coupon Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!coupons.data.length" />

      <!-- Pagination -->
      <div v-if="coupons.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ coupons.from }} - {{ coupons.to }} of {{ coupons.total }}
        </p>
        <Pagination :links="coupons.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

