<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/ProductReviewBreadcrumb.vue";
import PendingStatus from "@/Components/Status/PendingStatus.vue";
import PublishedStatus from "@/Components/Status/PublishedStatus.vue";
import UnpublishedStatus from "@/Components/Status/UnpublishedStatus.vue";
import TotalRatingStars from "@/Components/RatingStars/TotalRatingStars.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
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
import { __ } from "@/Translations/translations-inside-setup.js";
import datepicker from "vue3-datepicker";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  productReviews: Object,
});

// Define  Variables
const swal = inject("$swal");
const isFilterBoxOpened = ref(false);
const createdFrom = ref(
  usePage().props.ziggy.query.created_from
    ? new Date(usePage().props.ziggy.query.created_from)
    : ""
);
const createdUntil = ref(
  usePage().props.ziggy.query.created_until
    ? new Date(usePage().props.ziggy.query.created_until)
    : ""
);

// Formatted Date
const formattedCreatedFrom = computed(() => {
  const year = createdFrom.value ? createdFrom.value.getFullYear() : "";
  const month = createdFrom.value ? createdFrom.value.getMonth() + 1 : "";
  const day = createdFrom.value ? createdFrom.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

const formattedCreatedUntil = computed(() => {
  const year = createdUntil.value ? createdUntil.value.getFullYear() : "";
  const month = createdUntil.value ? createdUntil.value.getMonth() + 1 : "";
  const day = createdUntil.value ? createdUntil.value.getDate() : "";

  return year && month && day ? `${year}-${month}-${day}` : undefined;
});

// Query String Parameteres
const params = reactive({
  search: usePage().props.ziggy.query?.search,
  page: usePage().props.ziggy.query?.page,
  per_page: usePage().props.ziggy.query?.per_page,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  created_from: usePage().props.ziggy.query.created_from
    ? usePage().props.ziggy.query.created_from
    : formattedCreatedFrom,
  created_until: usePage().props.ziggy.query.created_until
    ? usePage().props.ziggy.query.created_until
    : formattedCreatedUntil,
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
      created_from: params.created_from,
      created_until: params.created_until,
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
      created_from: params.created_from,
      created_until: params.created_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Filtered By Only Created From
const filteredByCreatedFrom = () => {
  router.get(
    route("admin.product-reviews.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: formattedCreatedFrom.value,
      created_until: params.created_until,
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

// Filtered By Only Created Until
const filteredByCreatedUntil = () => {
  router.get(
    route("admin.product-reviews.index"),
    {
      search: params.search,
      per_page: params.per_page,
      sort: params.sort,
      direction: params.direction,
      created_from: params.created_from,
      created_until: formattedCreatedUntil.value,
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
  createdFrom.value = "";
  createdUntil.value = "";
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
      onSuccess: () => (isFilterBoxOpened.value = false),
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
      created_from: params.created_from,
      created_until: params.created_until,
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

// Watching Created From Datepicker
watch(
  () => params.created_from,
  () => {
    if (params.created_from === "") {
      resetFilteredDate();
    } else {
      filteredByCreatedFrom();
    }
  }
);

// Watching Created Unitl Datepicker
watch(
  () => params.created_until,
  () => {
    if (params.created_until === "") {
      resetFilteredDate();
    } else {
      filteredByCreatedUntil();
    }
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
    title:
      productReview.status === "pending" ||
      productReview.status === "unpublished"
        ? __("ARE_YOU_SURE_YOU_WANT_TO_SET_PUBLISH_THIS_PRODUCT")
        : __("ARE_YOU_SURE_YOU_WANT_TO_SET_UNPUBLISH_THIS_PRODUCT"),
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
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: params.created_from,
        created_until: params.created_until,
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
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
        created_from: params.created_from,
        created_until: params.created_until,
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
          <Link
            as="button"
            :href="route('admin.product-reviews.trash')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
          >
            <TrashButton />
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
              :placeholder="__('SEARCH_BY_REVIEW')"
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
                >Created from</span
              >
              <div>
                <datepicker
                  class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
                  :placeholder="__('SELECT_DATE')"
                  v-model="createdFrom"
                />
              </div>
            </div>
            <div class="w-full mb-3">
              <span class="font-bold text-sm text-gray-700 mb-5"
                >Created until</span
              >
              <div>
                <datepicker
                  class="w-full rounded-md p-3 border-gray-300 bg-white focus:ring-0 focus:border-gray-400 text-sm"
                  :placeholder="__('SELECT_DATE')"
                  v-model="createdUntil"
                />
              </div>
            </div>

            <div
              v-if="params.created_from || params.created_until"
              class="w-full flex items-center"
            >
              <ResetFilterButton @click="resetFilteredDate" />
            </div>
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
              <span v-if="productReview.product" class="line-clamp-1">
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
              <DeleteButton
                v-if="productReviewDelete"
                @click="handleDeleteProductReview(productReview.id)"
              />

              <!-- Detail Button -->
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
              >
                <DetailButton />
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

