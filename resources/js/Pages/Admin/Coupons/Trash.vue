<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CouponBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { inject, reactive, watch, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the Props
const props = defineProps({
  trashCoupons: Object,
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

// Define Alert Variables
const swal = inject("$swal");

// Query String Parameteres
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  page: usePage().props.ziggy.query?.page,
  per_page: usePage().props.ziggy.query?.per_page,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
});

// Handle Search
const handleSearch = () => {
  router.get(
    route("admin.coupons.trash"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Remove Search Param
const removeSearch = () => {
  params.search = "";
  router.get(
    route("admin.coupons.trash"),
    {
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Handle Query String Parameter
const handleQueryStringParameter = () => {
  router.get(
    route("admin.coupons.trash"),
    {
      search: params.search,
      page: params.page,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Watching Search Box
watch(
  () => params.search,
  () => {
    if (params.search === "") {
      removeSearch();
    } else {
      handleSearch();
    }
  }
);

// Watching Perpage Select Box
watch(
  () => params.per_page,
  () => {
    handleQueryStringParameter();
  }
);

// Update Sorting Table Column
const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  handleQueryStringParameter();
};

// Handle Trash Coupon Restore
const handleRestoreTrashCoupon = async (trashCouponId) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to restore this coupon?",
    showCancelButton: true,
    confirmButtonText: "Yes, Restore It",
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
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {},
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: usePage().props.flash.successMessage,
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
    title: "Are you sure you want to delete it from the trash?",
    text: "Coupon in the trash will be permanetly deleted! You can't get it back.",
    showCancelButton: true,
    confirmButtonText: "Yes, Delete it !",
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
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: usePage().props.flash.successMessage,
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
    title: "Are you sure you want to delete it from the trash?",
    text: "All coupons in the trash will be permanetly deleted! You can't get it back.",
    showCancelButton: true,
    confirmButtonText: "Yes, Delete it !",
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.coupons.trash.permanently.delete", {
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {
        preserveScroll: true,
        onSuccess: () => {
          if (usePage().props.flash.successMessage) {
            swal({
              icon: "success",
              title: usePage().props.flash.successMessage,
            });
          }
        },
      }
    );
  }
};

// Define Permissions Variables
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
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Trash Coupons" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
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
                >Trash</span
              >
            </div>
          </li>
        </Breadcrumb>

        <div>
          <Link
            as="button"
            :href="route('admin.coupons.index')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
            class="goback-btn"
          >
            <span>
              <i class="fa-solid fa-circle-left"></i>
              Go Back
            </span>
          </Link>
        </div>
      </div>

      <div class="flex items-center justify-end mb-5">
        <form class="w-[350px] relative">
          <input
            type="text"
            class="search-input"
            placeholder="Search by code"
            v-model="params.search"
          />

          <i
            v-if="params.search"
            class="fa-solid fa-xmark remove-search"
            @click="removeSearch"
          ></i>
        </form>
        <div class="ml-5">
          <select class="perpage-selectbox" v-model="params.per_page">
            <option value="" selected disabled>Select</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>

      <p
        v-if="couponTrashDelete && trashCoupons.data.length !== 0"
        class="text-left text-sm font-bold mb-2 text-warning-600"
      >
        Coupons in the Trash will be automatically deleted after 60 days.
        <button
          @click="handlePermanentlyDeleteTrashCoupons"
          class="empty-trash-btn"
        >
          Empty the trash now
        </button>
      </p>

      <!-- Trash Coupon Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('code')">
            Code
            <SortingArrows :params="params" sort="code" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('discount_type')">
            Discount Type
            <SortingArrows :params="params" sort="discount_type" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('discount_amount')">
            Discount Amount
            <SortingArrows :params="params" sort="discount_amount" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('min_spend')">
            Minmimum Spend
            <SortingArrows :params="params" sort="min_spend" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('max_uses')">
            Max Uses
            <SortingArrows :params="params" sort="max_uses" />
          </HeaderTh>

          <HeaderTh> Total Used </HeaderTh>

          <HeaderTh @click="updateSorting('deleted_at')">
            Deleted At
            <SortingArrows :params="params" sort="deleted_at" />
          </HeaderTh>

          <HeaderTh v-if="couponTrashRestore || couponTrashDelete">
            Action
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
              <button
                v-if="couponTrashRestore"
                @click="handleRestoreTrashCoupon(trashCoupon.id)"
                class="edit-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-recycle"></i>
                  Restore
                </span>
              </button>

              <!-- Delete Button -->
              <button
                v-if="couponTrashDelete"
                @click="handleDeleteTrashCoupon(trashCoupon.id)"
                class="delete-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-trash-can"></i>
                  Delete Forever
                </span>
              </button>
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


