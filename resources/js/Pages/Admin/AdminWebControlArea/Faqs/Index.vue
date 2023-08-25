<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/FaqBreadcrumb.vue";
import CreateButton from "@/Components/Buttons/CreateButton.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import EditButton from "@/Components/Buttons/EditButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
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
  faqs: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Faq Permission
const faqAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "faq.add")
    : false;
});

// Faq Edit Permission
const faqEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "faq.edit")
    : false;
});

// Faq Delete Permission
const faqDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "faq.delete")
    : false;
});

// Faq Trash List Permission
const faqTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "faq.trash.list"
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
    route("admin.faqs.index"),
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

// Handle Delete Faq
const handleDeleteFaq = async (faq) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_FAQ"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_FAQ_IN_THE_TRASH"),
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
      route("admin.faqs.destroy", {
        faq: faq,
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
    <Head :title="__('FAQS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="faqTrashList">
          <TrashButton href="admin.faqs.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Faq Button -->
        <div v-if="faqAdd">
          <CreateButton href="admin.faqs.create" name="ADD_FAQ" />
        </div>

        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.faqs.index"
            placeholder="SEARCH_BY_QUESTION"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.faqs.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.faqs.index" />
        </div>
      </div>

      <!-- Faq Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> {{ __("SUBCATEGORY") }} </HeaderTh>

          <HeaderTh @click="updateSorting('question')">
            {{ __("QUESTION") }}
            <SortingArrows :params="params" sort="question" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('answer')">
            {{ __("ANSWER") }}
            <SortingArrows :params="params" sort="answer" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="faqEdit || faqDelete"> {{ __("ACTION") }} </HeaderTh>
        </TableHeader>

        <tbody v-if="faqs.data.length">
          <Tr v-for="faq in faqs.data" :key="faq.id">
            <BodyTh>
              {{ faq.id }}
            </BodyTh>

            <Td>
              {{ faq.faq_sub_category?.name }}
            </Td>

            <Td>
              <span class="[w-200px]">
                {{ faq.question }}
              </span>
            </Td>

            <Td>
              <span v-html="faq.answer" class="line-clamp-1 w-[200px]"> </span>
            </Td>

            <Td>
              {{ faq.created_at }}
            </Td>

            <Td v-if="faqEdit || faqDelete" class="flex items-center">
              <!-- Edit Button -->
              <div v-if="faqEdit">
                <EditButton href="admin.faqs.edit" :slug="faq.slug" />
              </div>

              <!-- Delete Button -->
              <div v-if="faqDelete">
                <DeleteButton @click="handleDeleteFaq(faq.slug)" />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Faq Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!faqs.data.length" />

      <!-- Pagination -->
      <div v-if="faqs.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ faqs.from }} - {{ faqs.to }} of
          {{ faqs.total }}
        </p>
        <Pagination :links="faqs.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

