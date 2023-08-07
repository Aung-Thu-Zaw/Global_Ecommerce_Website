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
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import PublishedStatus from "@/Components/Status/PublishedStatus.vue";
import UnpublishedStatus from "@/Components/Status/UnpublishedStatus.vue";
import TotalRatingStars from "@/Components/RatingStars/TotalRatingStars.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  productReviews: Object,
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
    route("admin.product-reviews.index"),
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
    route("admin.product-reviews.index"),
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
    route("admin.product-reviews.index"),
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

// Handle Product Review Published Or Unpublished
const handleStatus = async (productReview) => {
  const result = await swal({
    icon: "question",
    title: `Are you sure you want to set ${
      productReview.status === "pending" ||
      productReview.status === "unpublished"
        ? "publish"
        : "unpublish"
    } this product review?`,
    showCancelButton: true,
    confirmButtonText: `Yes, ${
      productReview.status === "pending" ||
      productReview.status === "unpublished"
        ? "Publish"
        : "Unpublish"
    }!`,
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.patch(
      route("admin.product-reviews.update", {
        product_review: productReview.id,
        status:
          productReview.status === "pending" ||
          productReview.status === "unpublished"
            ? "published"
            : "unpublished",
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

// Handle Product Review Delete
const handleDeleteProductReview = async (productReview) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to delete this product review?",
    text: "You will be able to restore this product review in the trash!",
    showCancelButton: true,
    confirmButtonText: "Yes, Delete it!",
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.product-reviews.destroy", {
        product_review: productReview,
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
    <Head title="Product Reviews" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="productReviewTrashList">
          <Link
            as="button"
            :href="route('admin.product-reviews.trash')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
            class="trash-btn group"
          >
            <span class="group-hover:animate-pulse">
              <i class="fa-solid fa-trash-can-arrow-up"></i>
              Trash
            </span>
          </Link>
        </div>
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

      <!-- Product Review Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> Product Name </HeaderTh>

          <HeaderTh @click="updateSorting('review_text')">
            Review Text
            <SortingArrows :params="params" sort="review_text" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('rating')">
            Rating
            <SortingArrows :params="params" sort="rating" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('status')">
            Status
            <SortingArrows :params="params" sort="status" />
          </HeaderTh>

          <HeaderTh
            v-if="
              productReviewControl || productReviewDetail || productReviewDelete
            "
          >
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="productReviews.data.length">
          <Tr
            v-for="productReview in productReviews.data"
            :key="productReview.id"
          >
            <BodyTh>
              {{ productReview.id }}
            </BodyTh>

            <Td>
              <span class="line-clamp-1">
                {{ productReview.product.name }}
              </span>
            </Td>

            <Td>
              <span class="line-clamp-1 w-[300px]">
                {{ productReview.review_text }}
              </span>
            </Td>

            <Td>
              <TotalRatingStars :rating="productReview.rating" />
            </Td>

            <Td>
              <PendingStatus v-if="productReview.status === 'pending'">
                pending
              </PendingStatus>
              <PublishedStatus v-if="productReview.status === 'published'">
                published
              </PublishedStatus>
              <UnpublishedStatus v-if="productReview.status === 'unpublished'">
                unpublished
              </UnpublishedStatus>
            </Td>

            <Td
              v-if="
                productReviewControl ||
                productReviewDetail ||
                productReviewDelete
              "
            >
              <!-- Control Button -->
              <button
                v-if="productReviewControl"
                @click="handleStatus(productReview)"
                class="offical-btn group"
                type="button"
                :class="{
                  'bg-green-600  hover:bg-green-700 border-green-700':
                    productReview.status === 'pending' ||
                    productReview.status === 'unpublished',
                  'bg-orange-600  hover:bg-orange-700 border-orange-700':
                    productReview.status === 'published',
                }"
              >
                <span
                  v-if="
                    productReview.status === 'pending' ||
                    productReview.status === 'unpublished'
                  "
                  class="group-hover:animate-pulse"
                >
                  <i class="fa-solid fa-check"></i>
                  Publish
                </span>
                <span v-else class="group-hover:animate-pulse">
                  <i class="fa-solid fa-xmark"></i>
                  Unpublish
                </span>
              </button>

              <!-- Delete Button -->
              <button
                @click="handleDeleteProductReview(productReview.id)"
                v-if="productReviewDelete"
                class="delete-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-trash-can"></i>
                  Delete
                </span>
              </button>

              <Link
                v-if="productReviewDetail"
                :href="route('admin.product-reviews.show', productReview.id)"
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
      <!-- Product Review Review Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!productReviews.data.length" />

      <!-- Pagination -->
      <div v-if="productReviews.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ productReviews.from }} - {{ productReviews.to }} of
          {{ productReviews.total }}
        </p>
        <Pagination :links="productReviews.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

