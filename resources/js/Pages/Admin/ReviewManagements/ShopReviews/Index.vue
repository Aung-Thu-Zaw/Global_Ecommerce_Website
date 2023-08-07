<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ShopReviewBreadcrumb.vue";
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
  shopReviews: Object,
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
    route("admin.shop-reviews.index"),
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
    route("admin.shop-reviews.index"),
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
    route("admin.shop-reviews.index"),
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
const handleStatus = async (shopReview) => {
  const result = await swal({
    icon: "question",
    title: `Are you sure you want to set ${
      shopReview.status === "pending" || shopReview.status === "unpublished"
        ? "publish"
        : "unpublish"
    } this shop review?`,
    showCancelButton: true,
    confirmButtonText: `Yes, ${
      shopReview.status === "pending" || shopReview.status === "unpublished"
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
      route("admin.shop-reviews.update", {
        shop_review: shopReview.id,
        status:
          shopReview.status === "pending" || shopReview.status === "unpublished"
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

// Handle Shop Review Delete
const handleDeleteShopReview = async (shopReview) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to delete this shop review?",
    text: "You will be able to restore this shop review in the trash!",
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
      route("admin.shop-reviews.destroy", {
        shop_review: shopReview,
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

// Shop Review Detail Permission
const shopReviewDetail = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "shop-review.detail"
      )
    : false;
});

// Shop Review Control Permission
const shopReviewControl = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "shop-review.control"
      )
    : false;
});

// Shop Review Delete Permission
const shopReviewDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "shop-review.delete"
      )
    : false;
});

// Shop Review Trash List Permission
const shopReviewTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "shop-review.trash.list"
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
    <Head title="Pending Shop Reviews" />

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
        <div v-if="shopReviewTrashList">
          <Link
            as="button"
            :href="route('admin.shop-reviews.trash')"
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

      <!-- Pending Product Review Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> Shop Name </HeaderTh>

          <HeaderTh @click="updateSorting('review_text')">
            Review Text
            <SortingArrows :params="params" sort="review_text" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('rating')">
            Rating
            <SortingArrows :params="params" sort="rating" />
          </HeaderTh>

          <HeaderTh>Status</HeaderTh>

          <HeaderTh
            v-if="shopReviewControl || shopReviewDetail || shopReviewDelete"
          >
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="shopReviews.data.length">
          <Tr v-for="shopReview in shopReviews.data" :key="shopReview.id">
            <BodyTh>
              {{ shopReview.id }}
            </BodyTh>

            <Td>
              <span class="line-clamp-1">
                {{ shopReview.shop.shop_name }}
              </span>
            </Td>

            <Td>
              <span class="line-clamp-1 w-[300px]">
                {{ shopReview.review_text }}
              </span>
            </Td>

            <Td>
              <TotalRatingStars :rating="shopReview.rating" />
            </Td>

            <Td>
              <PendingStatus v-if="shopReview.status === 'pending'">
                pending
              </PendingStatus>
              <PublishedStatus v-if="shopReview.status === 'published'">
                published
              </PublishedStatus>
              <UnpublishedStatus v-if="shopReview.status === 'unpublished'">
                unpublished
              </UnpublishedStatus>
            </Td>

            <Td
              v-if="shopReviewControl || shopReviewDetail || shopReviewDelete"
            >
              <!-- Control Button -->
              <button
                v-if="shopReviewControl"
                @click="handleStatus(shopReview)"
                class="offical-btn group"
                type="button"
                :class="{
                  'bg-green-600  hover:bg-green-700 border-green-700':
                    shopReview.status === 'pending' ||
                    shopReview.status === 'unpublished',
                  'bg-orange-600  hover:bg-orange-700 border-orange-700':
                    shopReview.status === 'published',
                }"
              >
                <span
                  v-if="
                    shopReview.status === 'pending' ||
                    shopReview.status === 'unpublished'
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
                @click="handleDeleteShopReview(shopReview.id)"
                v-if="shopReviewDelete"
                class="delete-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-trash-can"></i>
                  Delete
                </span>
              </button>

              <Link
                v-if="shopReviewDetail"
                :href="route('admin.shop-reviews.show', shopReview.id)"
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
      <!-- Pending Product Review Review Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!shopReviews.data.length" />

      <!-- Pagination -->
      <div v-if="shopReviews.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ shopReviews.from }} - {{ shopReviews.to }} of
          {{ shopReviews.total }}
        </p>
        <Pagination :links="shopReviews.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

