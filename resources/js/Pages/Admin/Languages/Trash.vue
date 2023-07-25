<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/LanguageBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { inject, reactive, watch, computed, ref } from "vue";
import { router, usePage, Link, Head } from "@inertiajs/vue3";

// Define the Props
const props = defineProps({
  trashLanguages: Object,
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
    route("admin.languages.trash"),
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
    route("admin.languages.trash"),
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
    route("admin.languages.trash"),
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

// Handle Trash Language Restore
const handleRestoreTrashLanguage = async (trashLanguageId) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to restore this language?",
    showCancelButton: true,
    confirmButtonText: "Yes, Restore It",
    confirmButtonColor: "#2562c4",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.post(
      route("admin.languages.restore", {
        trash_language_id: trashLanguageId,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {},
      {
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

// Handle Trash Language Delete
const handleDeleteTrashLanguage = async (trashLanguageId) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to delete it from the trash?",
    text: "Language in the trash will be permanetly deleted! You can't get it back.",
    showCancelButton: true,
    confirmButtonText: "Yes, Delete it !",
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.languages.force.delete", {
        trash_language_id: trashLanguageId,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {
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

// Handle Trash Language Delete Permanently
const handlePermanentlyDeleteTrashLanguages = async () => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to delete it from the trash?",
    text: "All languages in the trash will be permanetly deleted! You can't get it back.",
    showCancelButton: true,
    confirmButtonText: "Yes, Delete it !",
    confirmButtonColor: "#d52222",
    cancelButtonColor: "#626262",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.get(
      route("admin.languages.permanently.delete", {
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {},
      {
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

// Language Trash Restore Permission
const languageTrashRestore = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "language.trash.restore"
      )
    : false;
});

// Language Trash Delete Permission
const languageTrashDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "language.trash.delete"
      )
    : false;
});
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Trash Languages" />

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
                >Trash</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back Button -->
        <div>
          <Link
            as="button"
            :href="route('admin.languages.index')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
            class="goback-btn"
          >
            <span>
              <i class="fa-solid fa-circle-left"></i>
              Go Back
            </span>
          </Link>
        </div>
      </div>

      <div class="flex items-center justify-end mb-5">
        <!-- Search Box -->
        <form class="w-[350px] relative">
          <input
            type="text"
            class="search-input"
            placeholder="Search by name"
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
            <option value="" selected disabled>Select</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="75">75</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>

      <!-- Language Permanently Delete Button -->
      <p
        v-if="languageTrashDelete && trashLanguages.data.length !== 0"
        class="text-left text-sm font-bold mb-2 text-warning-600"
      >
        Languages in the Trash will be automatically deleted after 60 days.
        <button
          @click="handlePermanentlyDeleteTrashLanguages"
          class="empty-trash-btn"
        >
          Empty the trash now
        </button>
      </p>

      <!-- Trash Language Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            Name
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('short_name')">
            Short Name
            <SortingArrows :params="params" sort="short_name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('deleted_at')">
            Deleted At
            <SortingArrows :params="params" sort="deleted_at" />
          </HeaderTh>

          <HeaderTh v-if="languageTrashRestore || languageTrashDelete">
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="trashLanguages.data.length">
          <Tr
            v-for="trashLanguage in trashLanguages.data"
            :key="trashLanguage.id"
          >
            <BodyTh>
              {{ trashLanguage.id }}
            </BodyTh>

            <Td>
              {{ trashLanguage.name }}
            </Td>

            <Td>
              {{ trashLanguage.short_name }}
            </Td>

            <Td>
              {{ trashLanguage.deleted_at }}
            </Td>

            <Td v-if="languageTrashRestore || languageTrashDelete">
              <!-- Restore Button -->
              <button
                v-if="languageTrashRestore"
                @click="handleRestoreTrashLanguage(trashLanguage.id)"
                class="edit-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-recycle"></i>
                  Restore
                </span>
              </button>

              <!-- Delete Button -->
              <button
                v-if="languageTrashDelete"
                @click="handleDeleteTrashLanguage(trashLanguage.id)"
                class="delete-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-trash-can"></i>
                  Delete Forever
                </span>
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Trash Language Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!trashLanguages.data.length" />

      <!-- Pagination -->
      <div v-if="trashLanguages.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ trashLanguages.from }} - {{ trashLanguages.to }} of
          {{ trashLanguages.total }}
        </p>
        <Pagination :links="trashLanguages.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>


