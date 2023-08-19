<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BannerBreadcrumb.vue";
import GoBackButton from "@/Components/Buttons/GoBackButton.vue";
import RestoreButton from "@/Components/Buttons/RestoreButton.vue";
import DeleteForeverButton from "@/Components/Buttons/DeleteForeverButton.vue";
import EmptyTrashButton from "@/Components/Buttons/EmptyTrashButton.vue";
import DashboardSearchInputForm from "@/Components/Forms/DashboardSearchInputForm.vue";
import DashboardPerPageSelectBox from "@/Components/Forms/DashboardPerPageSelectBox.vue";
import DashboardFilterByDeletedDate from "@/Components/Forms/DashboardFilterByDeletedDate.vue";
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
  trashSliderBanners: Object,
});

// Define  Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Banner Trash Restore Permission
const bannerTrashRestore = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "banner.trash.restore"
      )
    : false;
});

// Banner Trash Delete Permission
const bannerTrashDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "banner.trash.delete"
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
    route("admin.slider-banners.trash"),
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

// Handle Trash Slider Banner Restore
const handleRestoreTrashSliderBanner = async (trashSliderBannerId) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_RESTORE_THIS_SLIDER_BANNER"),
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
      route("admin.slider-banners.trash.restore", {
        trash_slider_banner_id: trashSliderBannerId,
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

// Handle Trash Slider Banner Delete
const handleDeleteTrashSliderBanner = async (trashSliderBannerId) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_IT_FROM_THE_TRASH"),
    text: __(
      "SLIDER_BANNER_IN_THE_TRASH_WILL_BE_PERMANETLY_DELETED_YOU_CANT_GET_IT_BACK"
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
      route("admin.slider-banners.trash.force.delete", {
        trash_slider_banner_id: trashSliderBannerId,
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

// Handle Trash Slider Banner Delete Permanently
const handlePermanentlyDeleteTrashSliderBanners = async () => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_IT_FROM_THE_TRASH"),
    text: __(
      "ALL_SLIDER_BANNERS_IN_THE_TRASH_WILL_BE_PERMANETLY_DELETED_YOU_CANT_GET_IT_BACK"
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
      route("admin.slider-banners.trash.permanently.delete", {
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
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('TRASH_SLIDER_BANNERS')" />

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
                {{ __("SLIDER_BANNERS") }}
              </span>
            </div>
          </li>
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
            href="admin.slider-banners.index"
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
          href="admin.slider-banners.trash"
          placeholder="SEARCH_BY_URL"
        />
        <!-- Perpage Select Box -->
        <div class="ml-5">
          <DashboardPerPageSelectBox href="admin.slider-banners.trash" />
        </div>

        <!-- Filter By Date -->
        <DashboardFilterByDeletedDate href="admin.slider-banners.trash" />
      </div>

      <!-- Slider Banner Permanently Delete Button -->
      <p
        v-if="bannerTrashDelete"
        class="text-left text-sm font-bold mb-2 text-warning-600"
      >
        {{
          __(
            "SLIDER_BANNERS_IN_THE_TRASH_WILL_BE_AUTOMATICALLY_DELETED_AFTER_60_DAYS"
          )
        }}

        <EmptyTrashButton @click="handlePermanentlyDeleteTrashSliderBanners" />
      </p>

      <!-- Trash Slider Banner Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> {{ __("IMAGE") }} </HeaderTh>

          <HeaderTh @click="updateSorting('url')">
            {{ __("URL") }}
            <SortingArrows :params="params" sort="url" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('deleted_at')">
            {{ __("DELETED_DATE") }}
            <SortingArrows :params="params" sort="deleted_at" />
          </HeaderTh>

          <HeaderTh v-if="bannerTrashRestore || bannerTrashDelete">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="trashSliderBanners.data.length">
          <Tr
            v-for="trashSliderBanner in trashSliderBanners.data"
            :key="trashSliderBanner.id"
          >
            <BodyTh>
              {{ trashSliderBanner.id }}
            </BodyTh>

            <Td>
              <img :src="trashSliderBanner.image" class="image" />
            </Td>

            <Td>
              {{ trashSliderBanner.url }}
            </Td>

            <Td>
              {{ trashSliderBanner.deleted_at }}
            </Td>

            <Td
              v-if="bannerTrashRestore || bannerTrashDelete"
              class="flex items-center"
            >
              <!-- Restore Button -->
              <div v-if="bannerTrashRestore">
                <RestoreButton
                  @click="handleRestoreTrashSliderBanner(trashSliderBanner.id)"
                />
              </div>

              <!-- Delete Button -->
              <div v-if="bannerTrashDelete">
                <DeleteForeverButton
                  @click="handleDeleteTrashSliderBanner(trashSliderBanner.id)"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Trash Slider Banner Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!trashSliderBanners.data.length" />

      <!-- Pagination -->
      <div v-if="trashSliderBanners.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ trashSliderBanners.from }} - {{ trashSliderBanners.to }} of
          {{ trashSliderBanners.total }}
        </p>
        <Pagination :links="trashSliderBanners.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>


