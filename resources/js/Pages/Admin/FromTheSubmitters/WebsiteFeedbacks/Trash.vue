<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/WebsiteFeedbackBreadcrumb.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import RestoreButton from "@/Components/Buttons/RestoreButton.vue";
import DeleteForeverButton from "@/Components/Buttons/DeleteForeverButton.vue";
import EmptyTrashButton from "@/Components/Buttons/EmptyTrashButton.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByDeletedDate from "@/Components/Forms/DashboardFilterByDeletedDate.vue";
import TotalRatingStars from "@/Components/RatingStars/TotalRatingStars.vue";
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
import { reactive, inject, computed, ref } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the Props
const props = defineProps({
  trashWebsiteFeedbacks: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Website Feedback Trash Restore Permission
const websiteFeedbackTrashRestore = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "website-feedback.trash.restore"
      )
    : false;
});

// Website Feedback Trash Delete Permission
const websiteFeedbackTrashDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "website-feedback.trash.delete"
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
    route("admin.website-feedbacks.trash"),
    {
      search: usePage().props.ziggy.query?.search,
      page: usePage().props.ziggy.query?.page,
      per_page: usePage().props.ziggy.query?.per_page,
      sort: params.sort,
      direction: params.direction,
      deleted_from: usePage().props.ziggy.query?.deleted_from,
      deleted_until: usePage().props.ziggy.query?.deleted_until,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Handle Restore Website Feedback
const handleRestoreTrashFeedback = async (trashWebsiteFeedbackId) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_RESTORE_THIS_WEBSITE_FEEDBACK"),
    showCancelButton: true,
    confirmButtonText: __("YES_RESTORE_IT"),
    cancelButtonText: __("CANCEL"),
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.website-feedbacks.trash.restore", {
        trash_website_feedback_id: trashWebsiteFeedbackId,
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        deleted_from: usePage().props.ziggy.query?.deleted_from,
        deleted_until: usePage().props.ziggy.query?.deleted_until,
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

// Handle Delete Website Feedback
const handleDeleteTrashFeedback = async (trashWebsiteFeedbackId) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_IT_FROM_THE_TRASH"),
    text: __(
      "WEBSITE_FEEDBACK_IN_THE_TRASH_WILL_BE_PERMANETLY_DELETED_YOU_CANT_GET_IT_BACK"
    ),
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
      route("admin.website-feedbacks.trash.force.delete", {
        trash_website_feedback_id: trashWebsiteFeedbackId,
        search: usePage().props.ziggy.query?.search,
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        deleted_from: usePage().props.ziggy.query?.deleted_from,
        deleted_until: usePage().props.ziggy.query?.deleted_until,
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

// Handle Permanently Delete Website Feedback
const handlePermanentlyDeleteTrashFeedbacks = async () => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_IT_FROM_THE_TRASH"),
    text: __(
      "ALL_WEBSITE_FEEDBACKS_IN_THE_TRASH_WILL_BE_PERMANETLY_DELETED_YOU_CANT_GET_IT_BACK"
    ),
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
      route("admin.website-feedbacks.trash.permanently.delete", {
        page: usePage().props.ziggy.query?.page,
        per_page: usePage().props.ziggy.query?.per_page,
        sort: params.sort,
        direction: params.direction,
        deleted_from: usePage().props.ziggy.query?.deleted_from,
        deleted_until: usePage().props.ziggy.query?.deleted_until,
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
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('TRASH_WEBSITE_FEEDBACKS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
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
              >
                {{ __("TRASH") }}
              </span>
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back Button -->
        <div>
          <GoBackButton
            href="admin.website-feedbacks.index"
            :queryStringParams="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
          />
        </div>
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Box -->
        <DashboardSearchInputForm
          href="admin.website-feedbacks.trash"
          placeholder="SEARCH_BY_EMAIL"
        />
        <!-- Perpage Select Box -->
        <div class="ml-5">
          <DashboardPerPageSelectBox href="admin.website-feedbacks.trash" />
        </div>

        <!-- Filter By Date -->
        <DashboardFilterByDeletedDate href="admin.website-feedbacks.trash" />
      </div>

      <!-- Empty Trash Button -->
      <p
        v-if="
          websiteFeedbackTrashDelete && trashWebsiteFeedbacks.data.length !== 0
        "
        class="text-left text-sm font-bold mb-2 text-warning-600"
      >
        {{
          __(
            "WEBSITE_FEEDBACKS_IN_THE_TRASH_WILL_BE_AUTOMATICALLY_DELETED_AFTER_60_DAYS"
          )
        }}

        <EmptyTrashButton @click="handlePermanentlyDeleteTrashFeedbacks" />
      </p>

      <!-- Trash Website Feedback Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('email')">
            {{ __("EMAIL") }}
            <SortingArrows :params="params" sort="email" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('rating')">
            {{ __("RATING") }}
            <SortingArrows :params="params" sort="rating" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('deleted_at')">
            {{ __("DELETED_DATE") }}
            <SortingArrows :params="params" sort="deleted_at" />
          </HeaderTh>

          <HeaderTh
            v-if="websiteFeedbackTrashRestore || websiteFeedbackTrashDelete"
          >
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="trashWebsiteFeedbacks.data.length">
          <Tr
            v-for="trashWebsiteFeedback in trashWebsiteFeedbacks.data"
            :key="trashWebsiteFeedback.id"
          >
            <BodyTh>
              {{ trashWebsiteFeedback.id }}
            </BodyTh>

            <Td>
              {{ trashWebsiteFeedback.email }}
            </Td>

            <Td>
              <TotalRatingStars :rating="trashWebsiteFeedback.rating" />
            </Td>

            <Td>
              {{ trashWebsiteFeedback.deleted_at }}
            </Td>

            <Td
              v-if="websiteFeedbackTrashRestore || websiteFeedbackTrashDelete"
              class="flex items-center"
            >
              <!-- Restore Button -->
              <div v-if="websiteFeedbackTrashRestore">
                <RestoreButton
                  @click="handleRestoreTrashFeedback(trashWebsiteFeedback.id)"
                />
              </div>

              <!-- Delete Button -->
              <div v-if="websiteFeedbackTrashDelete">
                <DeleteForeverButton
                  @click="handleDeleteTrashFeedback(trashWebsiteFeedback.id)"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Trash Website Feedback Table End -->

      <!-- No Avaliable Data Row -->
      <NotAvaliableData v-if="!trashWebsiteFeedbacks.data.length" />

      <!-- Pagination -->
      <div v-if="trashWebsiteFeedbacks.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ trashWebsiteFeedbacks.from }} -
          {{ trashWebsiteFeedbacks.to }} of
          {{ trashWebsiteFeedbacks.total }}
        </p>
        <Pagination :links="trashWebsiteFeedbacks.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>


