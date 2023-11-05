<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductReviewBreadcrumb.vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import PublishedStatus from "@/Components/Status/PublishedStatus.vue";
import UnpublishedStatus from "@/Components/Status/UnpublishedStatus.vue";
import TotalRatingStars from "@/Components/RatingStars/TotalRatingStars.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
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
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import { inject, computed, ref, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  productReviews: Object,
});

// Define Variables
const swal = inject("$swal");
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
    route("admin.product-reviews.index"),
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

// Handle Product Review Published Or Unpublished
const handleStatus = async (productReview) => {
  const result = await swal({
    icon: "question",
    title:
      productReview.status === "pending" ||
      productReview.status === "unpublished"
        ? __("ARE_YOU_SURE_YOU_WANT_TO_SET_PUBLISH_THIS_PRODUCT_REVIEW")
        : __("ARE_YOU_SURE_YOU_WANT_TO_SET_UNPUBLISH_THIS_PRODUCT_REVIEW"),
    showCancelButton: true,
    confirmButtonText:
      productReview.status === "pending" ||
      productReview.status === "unpublished"
        ? __("YES_PUBLISH")
        : __("YES_UNPUBLISH"),
    cancelButtonText: __("CANCEL"),
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
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: usePage().props.ziggy.query?.created_from,
        created_until: usePage().props.ziggy.query?.created_until,
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

// Handle Product Review Delete
const handleDeleteProductReview = async (productReview) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_PRODUCT_REVIEW"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_PRODUCT_REVIEW_IN_THE_TRASH"),
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
      route("admin.product-reviews.destroy", {
        product_review: productReview,
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
    <Head :title="__('PRODUCT_REVIEWS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="productReviewTrashList">
          <TrashButton href="admin.product-reviews.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.product-reviews.index"
            placeholder="SEARCH_BY_REVIEW"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.product-reviews.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.product-reviews.index" />
        </div>
      </div>

      <!-- Product Review Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> {{ __("PRODUCT_NAME") }} </HeaderTh>

          <HeaderTh @click="updateSorting('review_text')">
            {{ __("REVIEW") }}
            <SortingArrows :params="params" sort="review_text" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('rating')">
            {{ __("RATING") }}
            <SortingArrows :params="params" sort="rating" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('status')">
            {{ __("STATUS") }}
            <SortingArrows :params="params" sort="status" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh
            v-if="
              productReviewControl || productReviewDetail || productReviewDelete
            "
          >
            {{ __("ACTION") }}
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
              <span v-if="productReview.product" class="line-clamp-1 w-[150px]">
                {{ productReview.product.name }}
              </span>
            </Td>

            <Td>
              <span class="line-clamp-1 w-[200px]">
                {{ productReview.review_text }}
              </span>
            </Td>

            <Td>
              <TotalRatingStars :rating="productReview.rating" />
            </Td>

            <Td>
              <PendingStatus v-if="productReview.status === 'pending'">
                {{ productReview.status }}
              </PendingStatus>
              <PublishedStatus v-if="productReview.status === 'published'">
                {{ productReview.status }}
              </PublishedStatus>
              <UnpublishedStatus v-if="productReview.status === 'unpublished'">
                {{ productReview.status }}
              </UnpublishedStatus>
            </Td>

            <Td>
              {{ productReview.created_at }}
            </Td>

            <Td
              v-if="
                productReviewControl ||
                productReviewDetail ||
                productReviewDelete
              "
              class="flex items-center"
            >
              <!-- Control Button -->
              <button
                v-if="productReviewControl"
                @click="handleStatus(productReview)"
                class="text-sm px-5 py-2 border-[3px] font-semibold rounded-[4px] shadow-md text-white transition-all mr-3 my-1 group"
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
                  {{ __("PUBLISH") }}
                </span>
                <span v-else class="group-hover:animate-pulse">
                  <i class="fa-solid fa-xmark"></i>
                  {{ __("UNPUBLISH") }}
                </span>
              </button>

              <!-- Delete Button -->
              <div v-if="productReviewDelete">
                <DeleteButton
                  @click="handleDeleteProductReview(productReview.id)"
                />
              </div>

              <!-- Detail Button -->
              <div v-if="productReviewDetail">
                <DetailButton
                  href="admin.product-reviews.show"
                  :id="productReview.id"
                />
              </div>
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

