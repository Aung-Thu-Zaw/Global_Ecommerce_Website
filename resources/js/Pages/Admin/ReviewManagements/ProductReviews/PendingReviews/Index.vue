<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductReviewBreadcrumb.vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import TotalRatingStars from "@/Components/RatingStars/TotalRatingStars.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  pendingProductReviews: Object,
});

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
    route("admin.product-reviews.pending.index"),
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
    route("admin.product-reviews.pending.index"),
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
    route("admin.product-reviews.pending.index"),
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

// Handle Product Review Publish
const handlePublishProductReview = async (productReview) => {
  const result = await swal({
    icon: "info",
    title: "Are you sure you want to publish this product review?",
    showCancelButton: true,
    confirmButtonText: "Yes, publish!",
    confirmButtonColor: "#027e00",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.product-reviews.pending.update", {
        product_review: productReview,
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

// Handle Product Review Delete
const handleProductReviewDelete = async (productReview) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete this product review?",
    text: "You will be able to restore this product review in the trash!",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.product-reviews.pending.destroy", {
        product_review: productReview,
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

// Product Review Detail Permission
const productReviewDetail = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product-review.detail"
      )
    : false;
});

// Product Review Control Permission
const productReviewControl = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product-review.control"
      )
    : false;
});

// Product Review Delete Permission
const productReviewDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product-review.delete"
      )
    : false;
});

// Product Review Trash List Permission
const productReviewTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "product-review.trash.list"
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
    <Head title="Pending Product Reviews" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb>
          <li>
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
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:hover:text-white"
                >Pending Reviews</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Trash Button -->
        <div v-if="productReviewTrashList">
          <Link
            as="button"
            :href="route('admin.product-reviews.pending.trash')"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700"
          >
            <i class="fa-solid fa-trash"></i>

            Trash
          </Link>
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
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

      <!-- Brand Table Start -->
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
          <HeaderTh> Product Name </HeaderTh>
          <HeaderTh> Reviewer Name </HeaderTh>
          <HeaderTh @click="updateSorting('review_text')">
            Review Text
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'review_text',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'review_text',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'review_text',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'review_text',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('rating')">
            Rating
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'rating',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'rating',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'rating',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'rating',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh>Status</HeaderTh>
          <HeaderTh
            v-if="
              productReviewControl || productReviewDetail || productReviewDelete
            "
          >
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="pendingProductReviews.data.length">
          <Tr
            v-for="pendingProductReview in pendingProductReviews.data"
            :key="pendingProductReview.id"
          >
            <BodyTh>
              {{ pendingProductReview.id }}
            </BodyTh>

            <Td>
              <span class="line-clamp-1">
                {{ pendingProductReview.product.name }}
              </span>
            </Td>

            <Td>
              {{ pendingProductReview.user.name }}
            </Td>

            <Td>
              <span class="line-clamp-1 w-[300px]">
                {{ pendingProductReview.review_text }}
              </span>
            </Td>

            <Td>
              <TotalRatingStars :rating="pendingProductReview.rating" />
            </Td>

            <Td>
              <PendingStatus v-if="pendingProductReview.status === 0">
                pending
              </PendingStatus>
            </Td>

            <Td
              v-if="
                productReviewControl ||
                productReviewDetail ||
                productReviewDelete
              "
            >
              <button
                @click="handlePublishProductReview(pendingProductReview.id)"
                v-if="productReviewControl"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-green-600 text-white hover:bg-green-700 mr-3"
              >
                <i class="fa-solid fa-arrow-up"></i>
                Publish
              </button>

              <Link
                v-if="productReviewDetail"
                :href="
                  route(
                    'admin.product-reviews.pending.show',
                    pendingProductReview.id
                  )
                "
                as="button"
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                }"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-sky-600 text-white hover:bg-sky-700 mr-3"
              >
                <i class="fa-solid fa-eye"></i>
                Details
              </Link>

              <button
                @click="handleProductReviewDelete(pendingProductReview.id)"
                v-if="productReviewDelete"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3"
              >
                <i class="fa-solid fa-xmark"></i>
                Delete
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Product Review Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!pendingProductReviews.data.length" />

      <!-- Pagination -->
      <Pagination class="mt-6" :links="pendingProductReviews.links" />
    </div>
  </AdminDashboardLayout>
</template>

