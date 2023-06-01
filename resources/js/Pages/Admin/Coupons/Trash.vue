<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Coupons/Breadcrumb.vue";
import Pagination from "@/Components/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { inject, reactive, watch } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

const props = defineProps({
  trashCoupons: Object,
});

const swal = inject("$swal");

const params = reactive({
  search: null,
  page: props.trashCoupons.current_page ? props.trashCoupons.current_page : 1,
  per_page: props.trashCoupons.per_page ? props.trashCoupons.per_page : 10,
  sort: "id",
  direction: "desc",
});

const handleSearchBox = () => {
  params.search = "";
};

watch(
  () => params.search,
  () => {
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
  }
);

watch(
  () => params.per_page,
  () => {
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
  }
);

const updateSorting = (sort = "id") => {
  params.sort = sort;
  params.direction = params.direction === "asc" ? "desc" : "asc";

  router.get(
    route("admin.coupons.trash"),
    {
      search: params.search,
      page: params.page,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
    },
    { replace: true, preserveState: true }
  );
};

const handleRestore = async (trashCouponId) => {
  const result = await swal({
    icon: "info",
    title: "Are you sure you want to restore this coupon?",
    showCancelButton: true,
    confirmButtonText: "Yes, restore",
    confirmButtonColor: "#4d9be9",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.coupons.restore", {
        id: trashCouponId,
        page: params.page,
        per_page: params.per_page,
      })
    );
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
  }
};

const handleDelete = async (trashCouponId) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete it from the trash?",
    text: "Coupon in the trash will be permanetly deleted! You can't get it back.",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it !",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.coupons.forceDelete", {
        id: trashCouponId,
        page: params.page,
        per_page: params.per_page,
      })
    );
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
  }
};

const handlePermanentlyDelete = async () => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete it from the trash?",
    text: "All coupons in the trash will be permanetly deleted! You can't get it back.",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it !",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.get(
      route("admin.coupons.permanentlyDelete", {
        page: params.page,
        per_page: params.per_page,
      })
    );
    setTimeout(() => {
      swal({
        icon: "success",
        title: usePage().props.flash.successMessage,
      });
    }, 500);
  }
};
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
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <div class="flex items-center justify-end mb-5">
        <form class="w-[350px] relative">
          <input
            type="text"
            class="rounded-md border-2 border-slate-300 text-sm p-3 w-full"
            placeholder="Search"
            v-model="params.search"
          />

          <i
            v-if="params.search"
            class="fa-solid fa-xmark absolute top-4 right-5 text-slate-600 cursor-pointer"
            @click="handleSearchBox"
          ></i>
        </form>
        <div class="ml-5">
          <select
            class="py-3 w-[80px] border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
            v-model="params.per_page"
          >
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

      <p class="text-left text-sm font-bold mb-2 text-warning-600">
        Coupons in the Trash will be automatically deleted after 60 days.
        <button
          @click="handlePermanentlyDelete"
          class="text-primary-500 rounded-md px-2 py-1 hover:bg-primary-200 hover:text-primary-600 transition-all hover:animate-bounce"
        >
          Empty the trash now
        </button>
      </p>

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
          <HeaderTh @click="updateSorting('deleted_at')">
            Deleted At
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'deleted_at',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'deleted_at',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'deleted_at',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'deleted_at',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh> Action </HeaderTh>
        </TableHeader>

        <tbody v-if="trashCoupons.data.length">
          <Tr v-for="trashCoupon in trashCoupons.data" :key="trashCoupon.id">
            <BodyTh>{{ trashCoupon.id }}</BodyTh>

            <Td>{{ trashCoupon.code }}</Td>
            <Td>{{ trashCoupon.discount_type }}</Td>
            <Td>{{ trashCoupon.discount_amount }}</Td>
            <Td>{{ trashCoupon.min_spend }}</Td>
            <Td>{{ trashCoupon.max_uses }}</Td>
            <Td>{{ trashCoupon.uses_count ? trashCoupon.uses_count : 0 }}</Td>
            <Td>{{ trashCoupon.deleted_at }}</Td>
            <Td>
              <button
                @click="handleRestore(trashCoupon.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 mr-3 my-1"
              >
                <i class="fa-solid fa-recycle"></i>
                Restore
              </button>
              <button
                @click="handleDelete(trashCoupon.id)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
              >
                <i class="fa-solid fa-trash"></i>
                Delete Forever
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>

      <NotAvaliableData v-if="!trashCoupons.data.length" />

      <Pagination class="mt-6" :links="trashCoupons.links" />
    </div>
  </AdminDashboardLayout>
</template>


