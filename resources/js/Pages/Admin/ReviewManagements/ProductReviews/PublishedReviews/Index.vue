<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductReviewBreadcrumb.vue";
import PublishedStatus from "@/Components/Status/PublishedStatus.vue";
import TotalRatingStars from "@/Components/RatingStars/TotalRatingStars.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  publishedProductReviews: Object,
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
    route("admin.product-reviews.published.index"),
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
    route("admin.product-reviews.published.index"),
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
    route("admin.product-reviews.published.index"),
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
const handleUnPublishProductReview = async (productReview) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to unpublish this product review?",
    showCancelButton: true,
    confirmButtonText: "Yes, Unpublish!",
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.product-reviews.published.update", {
        product_review: productReview,
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

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: usePage().props.flash.successMessage,
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Published Product Reviews" />

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
                >Published Reviews</span
              >
            </div>
          </li>
        </Breadcrumb>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <form class="w-[350px] relative">
            <input
              type="text"
              class="search-input"
              placeholder="Search by review text"
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
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> Product Name </HeaderTh>

          <HeaderTh> Reviewer Name </HeaderTh>

          <HeaderTh @click="updateSorting('review_text')">
            Review Text
            <SortingArrows :params="params" sort="review_text" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('rating')">
            Rating
            <SortingArrows :params="params" sort="rating" />
          </HeaderTh>

          <HeaderTh>Status</HeaderTh>

          <HeaderTh v-if="productReviewControl || productReviewDetail">
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="publishedProductReviews.data.length">
          <Tr
            v-for="publishedProductReview in publishedProductReviews.data"
            :key="publishedProductReview.id"
          >
            <BodyTh>
              {{ publishedProductReview.id }}
            </BodyTh>

            <Td>
              <span class="line-clamp-1">
                {{ publishedProductReview.product.name }}
              </span>
            </Td>

            <Td>
              {{ publishedProductReview.user.name }}
            </Td>

            <Td>
              <span class="line-clamp-1 w-[300px]">
                {{ publishedProductReview.review_text }}
              </span>
            </Td>

            <Td>
              <TotalRatingStars :rating="publishedProductReview.rating" />
            </Td>

            <Td>
              <PublishedStatus v-if="publishedProductReview.status === 1">
                published
              </PublishedStatus>
            </Td>

            <Td v-if="productReviewControl || productReviewDetail">
              <!-- Unpublish Button -->
              <button
                @click="handleUnPublishProductReview(publishedProductReview.id)"
                v-if="productReviewControl"
                class="hide-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-arrow-down"></i>
                  UnPublish
                </span>
              </button>

              <Link
                v-if="productReviewDetail"
                :href="
                  route(
                    'admin.product-reviews.published.show',
                    publishedProductReview.id
                  )
                "
                as="button"
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                  sort: params.sort,
                  direction: params.direction,
                }"
                class="detail-btn group"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-eye"></i>
                  Details
                </span>
              </Link>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Product Review Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!publishedProductReviews.data.length" />

      <!-- Pagination -->
      <div v-if="publishedProductReviews.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ publishedProductReviews.from }} -
          {{ publishedProductReviews.to }} of
          {{ publishedProductReviews.total }}
        </p>
        <Pagination :links="publishedProductReviews.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

