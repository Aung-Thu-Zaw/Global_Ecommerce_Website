<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CouponBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  coupons: Object,
});

// Define Alert Variables
const swal = inject("$swal");

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
const formatDiscountType = (suggestionType) => {
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
});

// Handle Search
const handleSearch = () => {
  router.get(
    route("admin.coupons.index"),
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
    route("admin.coupons.index"),
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
    route("admin.coupons.index"),
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

// Handle Coupon Delete
const handleCouponDelete = async (coupon) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete this coupon?",
    text: "You will be able to restore this coupon in the trash!",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.coupons.destroy", {
        coupon: coupon,
        page: params.page,
        per_page: params.per_page,
      }),
      {
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

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: usePage().props.flash.successMessage,
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Coupons" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="couponTrashList">
          <Link
            as="button"
            :href="route('admin.coupons.trash')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700"
          >
            <i class="fa-solid fa-trash"></i>

            Trash
          </Link>
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Coupon Button -->
        <Link
          v-if="couponAdd"
          as="button"
          :href="route('admin.coupons.create')"
          :data="{
            per_page: params.per_page,
          }"
          class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700"
        >
          <i class="fa-sharp fa-solid fa-plus cursor-pointer"></i>
          Add Coupon</Link
        >
        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <form class="w-[350px] relative">
            <input
              type="text"
              class="rounded-md border-2 border-slate-300 text-sm p-3 w-full"
              placeholder="Search"
              v-model="params.search"
            />

            <i
              v-if="params.search"
              class="fa-solid fa-xmark absolute top-4 right-5 text-slate-600 cursor-pointer hover:text-red-600"
              @click="removeSearch"
            ></i>
          </form>

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <select
              class="py-3 w-[80px] border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="params.per_page"
            >
              <option value="" disabled>Select</option>
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
              <option value="75">75</option>
              <option value="100">100</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Coupon Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'id',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'id',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'id',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'id',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('code')">
            Code
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'code',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'code',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'code',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'code',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('discount_type')">
            Discount Type
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'discount_type',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'discount_type',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' &&
                  params.sort === 'discount_type',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'discount_type',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('discount_amount')">
            Discount Amount
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' &&
                  params.sort === 'discount_amount',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'discount_amount',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' &&
                  params.sort === 'discount_amount',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'discount_amount',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('min_spend')">
            Minmimum Spend
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'min_spend',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'min_spend',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'min_spend',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'min_spend',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('max_uses')">
            Max Uses
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'max_uses',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'max_uses',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'max_uses',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'max_uses',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh> Total Used </HeaderTh>
          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'created_at',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'created_at',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'created_at',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'created_at',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh v-if="couponEdit || couponDelete"> Action </HeaderTh>
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
              {{ formatDiscountType(coupon.discount_type) }}
            </Td>

            <Td>
              <span v-if="coupon.discount_type === 'fixed_amount'">
                $ {{ formattedAmount(coupon.discount_amount) }}
              </span>
              <span v-if="coupon.discount_type === 'percentage'">
                % {{ coupon.discount_amount }}
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

            <Td v-if="couponEdit || couponDelete">
              <Link
                v-if="couponEdit"
                as="button"
                :href="route('admin.coupons.edit', coupon.id)"
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                }"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 mr-3 my-1"
              >
                <i class="fa-solid fa-edit"></i>
                Edit
              </Link>
              <button
                v-if="couponDelete"
                @click="handleCouponDelete(coupon.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
              >
                <i class="fa-solid fa-xmark"></i>
                Delete
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Coupon Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!coupons.data.length" />

      <!-- Pagination -->
      <Pagination class="mt-6" :links="coupons.links" />
    </div>
  </AdminDashboardLayout>
</template>

