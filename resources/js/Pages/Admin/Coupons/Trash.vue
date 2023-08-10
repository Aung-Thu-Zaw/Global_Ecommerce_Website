<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CouponBreadcrumb.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import RestoreButton from "@/Components/Buttons/RestoreButton.vue";
import DeleteForeverButton from "@/Components/Buttons/DeleteForeverButton.vue";
import EmptyTrashButton from "@/Components/Buttons/EmptyTrashButton.vue";
import ResetFilterButton from "@/Components/Buttons/ResetFilterButton.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import datepicker from "vue3-datepicker";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the Props
const props = defineProps({
  trashCoupons: Object,
});

// Define  Variables
const swal = inject("$swal");
const isFilterBoxOpened = ref(false);
const deletedFrom = ref(
  usePage().props.ziggy.query.deleted_from
    ? new Date(usePage().props.ziggy.query.deleted_from)
    : ""
);
const deletedUntil = ref(
  usePage().props.ziggy.query.deleted_until
    ? new Date(usePage().props.ziggy.query.deleted_until)
    : ""
);

// Formatted Date
const formattedDeletedFrom = computed(() => {
  const year = deletedFrom.value ? deletedFrom.value.getFullYear() : "";
  const month = deletedFrom.value ? deletedFrom.value.getMonth() + 1 : "";
  const day = deletedFrom.value ? deletedFrom.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

const formattedDeletedUntil = computed(() => {
  const year = deletedUntil.value ? deletedUntil.value.getFullYear() : "";
  const month = deletedUntil.value ? deletedUntil.value.getMonth() + 1 : "";
  const day = deletedUntil.value ? deletedUntil.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
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
  search: usePage().props.ziggy.query?.search,
  page: usePage().props.ziggy.query?.page,
  per_page: usePage().props.ziggy.query?.per_page,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  deleted_from: usePage().props.ziggy.query.deleted_from
    ? usePage().props.ziggy.query.deleted_from
    : formattedDeletedFrom,
  deleted_until: usePage().props.ziggy.query.deleted_until
    ? usePage().props.ziggy.query.deleted_until
    : formattedDeletedUntil,
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
      deleted_from: params.deleted_from,
      deleted_until: params.deleted_until,
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
      deleted_from: params.deleted_from,
      deleted_until: params.deleted_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Filtered By Only Deleted From
const filteredByDeletedFrom = () => {
  router.get(
    route("admin.coupons.trash"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      deleted_from: formattedDeletedFrom.value,
      deleted_until: params.deleted_until,
    },
    {
      replace: true,
      preserveState: true,
      onSuccess: () => {
        isFilterBoxOpened.value = true;
      },
    }
  );
};

// Filtered By Only Deleted Until
const filteredByDeletedUntil = () => {
  router.get(
    route("admin.coupons.trash"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      deleted_from: params.deleted_from,
      deleted_until: formattedDeletedUntil.value,
    },
    {
      replace: true,
      preserveState: true,
      onSuccess: () => {
        isFilterBoxOpened.value = true;
      },
    }
  );
};

// Handle Reset Filtered Date
const resetFilteredDate = () => {
  deletedFrom.value = "";
  deletedUntil.value = "";
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
      onSuccess: () => (isFilterBoxOpened.value = false),
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
      deleted_from: params.deleted_from,
      deleted_until: params.deleted_until,
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

// Watching Deleted From Datepicker
watch(
  () => params.deleted_from,
  () => {
    if (params.deleted_from === "") {
      resetFilteredDate();
    } else {
      filteredByDeletedFrom();
    }
  }
);

// Watching Deleted Unitl Datepicker
watch(
  () => params.deleted_until,
  () => {
    if (params.deleted_until === "") {
      resetFilteredDate();
    } else {
      filteredByDeletedUntil();
    }
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
        deleted_from: params.deleted_from,
        deleted_until: params.deleted_until,
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
        deleted_from: params.deleted_from,
        deleted_until: params.deleted_until,
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
        deleted_from: params.deleted_from,
        deleted_until: params.deleted_until,
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
          <Link
            as="button"
            :href="route('admin.coupons.index')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
          >
            <GoBackButton />
          </Link>
        </div>
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Box -->
        <form class="w-[350px] relative">
          <input
            type="text"
            class="search-input"
            :placeholder="__('SEARCH_BY_CODE')"
            v-model="params.search"
          />

          <i
            v-if="params.search"
            class="fa-solid fa-xmark remove-search"
            @click="removeSearch"
          ></i>
        </form>

        <!-- Perpage Select Box -->
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

        <!-- Filter By Date -->
        <button
          @click="isFilterBoxOpened = !isFilterBoxOpened"
          class="filter-btn"
        >
          <span class="">
            <i class="fa-solid fa-filter"></i>
          </span>
        </button>

        <div
          v-if="isFilterBoxOpened"
          class="w-[400px] border border-gray-300 shadow-lg absolute bg-white top-64 right-10 z-30 px-5 py-4 rounded-md"
        >
          <div class="flex items-center justify-end">
            <span
              @click="isFilterBoxOpened = false"
              class="text-lg text-gray-500 hover:text-gray-800 cursor-pointer"
            >
              <i class="fa-solid fa-xmark"></i>
            </span>
          </div>
          <div class="w-full mb-6">
            <span class="font-bold text-sm text-gray-700 mb-5"
              >Deleted from</span
            >
            <div>
              <datepicker
                class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
                :placeholder="__('SELECT_DATE')"
                v-model="deletedFrom"
              />
            </div>
          </div>
          <div class="w-full mb-3">
            <span class="font-bold text-sm text-gray-700 mb-5"
              >Deleted until</span
            >
            <div>
              <datepicker
                class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
                :placeholder="__('SELECT_DATE')"
                v-model="deletedUntil"
              />
            </div>
          </div>

          <div
            v-if="params.deleted_from || params.deleted_until"
            class="w-full flex items-center"
          >
            <ResetFilterButton @click="resetFilteredDate" />
          </div>
        </div>
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
              <RestoreButton
                v-if="couponTrashRestore"
                @click="handleRestoreTrashCoupon(trashCoupon.id)"
              />

              <!-- Delete Button -->
              <DeleteForeverButton
                v-if="couponTrashDelete"
                @click="handleDeleteTrashCoupon(trashCoupon.id)"
              />
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


