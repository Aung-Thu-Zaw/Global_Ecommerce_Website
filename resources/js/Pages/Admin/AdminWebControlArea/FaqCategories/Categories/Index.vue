<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/FaqCategoryBreadcrumb.vue";
import CreateButton from "@/Components/Buttons/CreateButton.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import EditButton from "@/Components/Buttons/EditButton.vue";
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
  faqCategories: Object,
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
    route("admin.faq-categories.categories.index"),
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
    route("admin.faq-categories.categories.index"),
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
    route("admin.faq-categories.categories.index"),
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
    route("admin.faq-categories.categories.index"),
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
    route("admin.faq-categories.categories.index"),
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
    route("admin.faq-categories.categories.index"),
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

// Handle Delete Faq Category
const handleDelete = async (faqCategory) => {
  router.delete(
    route("admin.faq-categories.categories.destroy", {
      faq_category: faqCategory,
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
};

// Handle Delete Faq Category
const handleDeleteFaqCategory = async (faqCategory) => {
  if (faqCategory.faq_sub_categories.length > 0) {
    const result = await swal({
      icon: "error",
      title: __(
        "YOU_CANT_DELETE_THIS_FAQ_CATEGORY_BECAUSE_THIS_FAQ_CATEGORY_HAVE_FAQ_SUB_CATEGORIES"
      ),
      text: __(
        "IF_YOU_CLICK_THE_DELETE_WHATEVER_BUTTON_FAQ_SUB_CATEGORIES_ASSOCIATED_WITH_THAT_FAQ_CATEGORY_WILL_BE_AUTOMATICALLY_DELETED"
      ),
      showCancelButton: true,
      confirmButtonText: __("DELETE_WHATEVER"),
      cancelButtonText: __("CANCEL"),
      confirmButtonColor: "#d52222",
      cancelButtonColor: "#626262",
      timer: 20000,
      timerProgressBar: true,
      reverseButtons: true,
    });
    if (result.isConfirmed) {
      handleDelete(faqCategory.slug);
    }
  } else {
    const result = await swal({
      icon: "question",
      title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_FAQ_CATEGORY"),
      text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_FAQ_CATEGORY_IN_THE_TRASH"),
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
      handleDelete(faqCategory.slug);
    }
  }
};

// Define Permissions Variables
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Faq Category Permission
const faqCategoryAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "faq-category.add"
      )
    : false;
});

// F Category Edit Permission
const faqCategoryEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "faq-category.edit"
      )
    : false;
});

// F Category Delete Permission
const faqCategoryDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "faq-category.delete"
      )
    : false;
});

// F Category Trash List Permission
const faqCategoryTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "faq-category.trash.list"
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
    <Head :title="__('FAQ_CATEGORIES')" />

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
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400 dark:hover:text-white"
                >{{ __("CATEGORIES") }}</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Trash Button -->
        <div v-if="faqCategoryTrashList">
          <Link
            as="button"
            :href="route('admin.faq-categories.categories.trash')"
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
        <!-- Create Faq Category Button -->
        <Link
          v-if="faqCategoryAdd"
          as="button"
          :href="route('admin.faq-categories.categories.create')"
          :data="{
            per_page: params.per_page,
          }"
        >
          <CreateButton>
            {{ __("ADD_FAQ_CATEGORY") }}
          </CreateButton>
        </Link>

        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <form class="w-[350px] relative">
            <input
              type="text"
              class="search-input"
              :placeholder="__('SEARCH_BY_NAME')"
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

      <!-- Blog Categories Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            {{ __("NAME") }}
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="faqCategoryEdit || faqCategoryDelete">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="faqCategories.data.length">
          <Tr v-for="faqCategory in faqCategories.data" :key="faqCategory.id">
            <BodyTh>
              {{ faqCategory.id }}
            </BodyTh>

            <Td>
              {{ faqCategory.name }}
            </Td>

            <Td>
              {{ faqCategory.created_at }}
            </Td>

            <Td v-if="faqCategoryEdit || faqCategoryDelete">
              <!-- Edit Button -->
              <Link
                v-if="faqCategoryEdit"
                as="button"
                :href="
                  route(
                    'admin.faq-categories.categories.edit',
                    faqCategory.slug
                  )
                "
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                  sort: params.sort,
                  direction: params.direction,
                }"
              >
                <EditButton />
              </Link>

              <!-- Delete Button -->
              <DeleteButton
                v-if="faqCategoryDelete"
                @click="handleDeleteFaqCategory(faqCategory)"
              />
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Blog Categories Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!faqCategories.data.length" />

      <!-- Pagination -->
      <div v-if="faqCategories.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ faqCategories.from }} - {{ faqCategories.to }} of
          {{ faqCategories.total }}
        </p>
        <Pagination :links="faqCategories.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

