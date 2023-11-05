<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ShopReviewBreadcrumb.vue";
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
  shopReviews: Object,
});

// Define Variables
const swal = inject("$swal");
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
    route("admin.shop-reviews.index"),
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

// Handle Shop Review Published Or Unpublished
const handleStatus = async (shopReview) => {
  const result = await swal({
    icon: "question",
    title:
      shopReview.status === "pending" || shopReview.status === "unpublished"
        ? __("ARE_YOU_SURE_YOU_WANT_TO_SET_PUBLISH_THIS_SHOP_REVIEW")
        : __("ARE_YOU_SURE_YOU_WANT_TO_SET_UNPUBLISH_THIS_SHOP_REVIEW"),
    showCancelButton: true,
    confirmButtonText:
      shopReview.status === "pending" || shopReview.status === "unpublished"
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
      route("admin.shop-reviews.update", {
        shop_review: shopReview.id,
        status:
          shopReview.status === "pending" || shopReview.status === "unpublished"
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

// Handle Shop Review Delete
const handleDeleteShopReview = async (shopReview) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_SHOP_REVIEW"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_SHOP_REVIEW_IN_THE_TRASH"),
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
      route("admin.shop-reviews.destroy", {
        shop_review: shopReview,
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
    <Head :title="__('SHOP_REVIEWS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="shopReviewTrashList">
          <TrashButton href="admin.shop-reviews.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.shop-reviews.index"
            placeholder="SEARCH_BY_REVIEW"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.shop-reviews.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.shop-reviews.index" />
        </div>
      </div>

      <!-- Shop Review Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> {{ __("SHOP_NAME") }} </HeaderTh>

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
            v-if="shopReviewControl || shopReviewDetail || shopReviewDelete"
          >
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="shopReviews.data.length">
          <Tr v-for="shopReview in shopReviews.data" :key="shopReview.id">
            <BodyTh>
              {{ shopReview.id }}
            </BodyTh>

            <Td>
              <span v-if="shopReview.shop" class="line-clamp-1 w-[150px]">
                {{ shopReview.shop.shop_name }}
              </span>
            </Td>

            <Td>
              <span class="line-clamp-1 w-[200px]">
                {{ shopReview.review_text }}
              </span>
            </Td>

            <Td>
              <TotalRatingStars :rating="shopReview.rating" />
            </Td>

            <Td>
              <PendingStatus v-if="shopReview.status === 'pending'">
                {{ shopReview.status }}
              </PendingStatus>
              <PublishedStatus v-if="shopReview.status === 'published'">
                {{ shopReview.status }}
              </PublishedStatus>
              <UnpublishedStatus v-if="shopReview.status === 'unpublished'">
                {{ shopReview.status }}
              </UnpublishedStatus>
            </Td>

            <Td>
              {{ shopReview.created_at }}
            </Td>

            <Td
              v-if="shopReviewControl || shopReviewDetail || shopReviewDelete"
              class="flex items-center"
            >
              <!-- Control Button -->
              <button
                v-if="shopReviewControl"
                @click="handleStatus(shopReview)"
                class="text-sm px-5 py-2 border-[3px] font-semibold rounded-[4px] shadow-md text-white transition-all mr-3 my-1 group"
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
                  {{ __("PUBLISH") }}
                </span>
                <span v-else class="group-hover:animate-pulse">
                  <i class="fa-solid fa-xmark"></i>
                  {{ __("UNPUBLISH") }}
                </span>
              </button>

              <!-- Delete Button -->
              <div v-if="shopReviewDelete">
                <DeleteButton @click="handleDeleteShopReview(shopReview.id)" />
              </div>

              <!-- Detail Button -->
              <div v-if="shopReviewDetail">
                <DetailButton
                  href="admin.shop-reviews.show"
                  :id="shopReview.id"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Shop Review Review Table End -->

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

