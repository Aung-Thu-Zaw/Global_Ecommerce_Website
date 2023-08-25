<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/WebsiteFeedbackBreadcrumb.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import DetailButton from "@/Components/Buttons/DetailButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByCreatedDate from "@/Components/Forms/DashboardFilterByCreatedDate.vue";
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
import { inject, computed, ref, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  websiteFeedbacks: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Website Feedback Trash List Permission
const websiteFeedbackTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "website-feedback.trash.list"
      )
    : false;
});

// Website Feedback Detail Permission
const websiteFeedbackDetail = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "website-feedback.detail"
      )
    : false;
});

// Website Feedback Delete Permission
const websiteFeedbackDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "website-feedback.delete"
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
    route("admin.website-feedbacks.index"),
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

// Handle Delete Website Feedback
const handleDeleteWebsiteFeedback = async (websiteFeedbackId) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_WEBSITE_FEEDBACK"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_WEBSITE_FEEDBACK_IN_THE_TRASH"),
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
      route("admin.website-feedbacks.destroy", {
        website_feedback: websiteFeedbackId,
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
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('WEBSITE_FEEDBACKS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="websiteFeedbackTrashList">
          <TrashButton href="admin.website-feedbacks.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.website-feedbacks.index"
            placeholder="SEARCH_BY_EMAIL"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.website-feedbacks.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.website-feedbacks.index" />
        </div>
      </div>

      <!-- Website Feedback Table Start -->
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

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="websiteFeedbackDelete || websiteFeedbackDetail">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="websiteFeedbacks.data.length">
          <Tr
            v-for="websiteFeedback in websiteFeedbacks.data"
            :key="websiteFeedback.id"
          >
            <BodyTh>
              {{ websiteFeedback.id }}
            </BodyTh>

            <Td>
              {{ websiteFeedback.email }}
            </Td>

            <Td>
              <TotalRatingStars :rating="websiteFeedback.rating" />
            </Td>

            <Td>
              {{ websiteFeedback.created_at }}
            </Td>

            <Td
              v-if="websiteFeedbackDelete || websiteFeedbackDetail"
              class="flex items-center"
            >
              <!-- Delete Button -->
              <div v-if="websiteFeedbackDelete">
                <DeleteButton
                  @click="handleDeleteWebsiteFeedback(websiteFeedback.id)"
                />
              </div>

              <!-- Detail Button -->
              <div v-if="websiteFeedbackDetail">
                <DetailButton
                  href="admin.website-feedbacks.show"
                  :id="websiteFeedback.id"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Website Feedback Table Start -->

      <!-- No Avaliable Data Row -->
      <NotAvaliableData v-if="!websiteFeedbacks.data.length" />

      <!-- Pagination -->
      <div v-if="websiteFeedbacks.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ websiteFeedbacks.from }} - {{ websiteFeedbacks.to }} of
          {{ websiteFeedbacks.total }}
        </p>
        <Pagination :links="websiteFeedbacks.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

