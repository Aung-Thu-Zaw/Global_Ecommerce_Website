<script setup>
import SellerDashboardLayout from "@/Layouts/SellerDashboardLayout.vue";
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
import Pagination from "@/Components/Paginations/Pagination.vue";
import { __ } from "@/Translations/translations-inside-setup.js";
import { inject, computed, ref, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  shopReviews: Object,
});

// Define Variables
const swal = inject("$swal");

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
    route("seller.shop-reviews.index"),
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
</script>

<template>
  <SellerDashboardLayout>
    <Head :title="__('SHOP_REVIEWS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />
      </div>

      <div class="mb-5 flex items-center justify-between">
        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="seller.shop-reviews.index"
            placeholder="SEARCH_BY_REVIEW"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="seller.shop-reviews.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="seller.shop-reviews.index" />
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

          <HeaderTh>
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="shopReviews.data.length">
          <Tr v-for="shopReview in shopReviews.data" :key="shopReview.id">
            <BodyTh>
              {{ shopReview.id }}
            </BodyTh>

            <Td>
              <span class="line-clamp-1 w-[150px]">
                {{ shopReview.shop?.shop_name }}
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

            <Td class="flex items-center">
              <!-- Detail Button -->
              <div>
                <DetailButton
                  href="seller.shop-reviews.show"
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
  </SellerDashboardLayout>
</template>

