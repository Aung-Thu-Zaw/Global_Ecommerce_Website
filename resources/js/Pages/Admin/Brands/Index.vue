<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BrandBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import datepicker from "vue3-datepicker";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  brands: Object,
});

// Define Alert Variables
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
// const createdUntil = ref("");

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
    route("admin.brands.index"),
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
    route("admin.brands.index"),
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

const filteredByCreatedFrom = () => {
  router.get(
    route("admin.brands.index"),
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

const filteredByCreatedUntil = () => {
  router.get(
    route("admin.brands.index"),
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
    route("admin.brands.index"),
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
    route("admin.brands.index"),
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

// Handle Brand Delete
const handleDelete = (brand) => {
  router.delete(
    route("admin.brands.destroy", {
      brand: brand,
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
            title: usePage().props.flash.successMessage,
          });
        }
      },
    }
  );
};

// Handle Delete Brand
const handleDeleteBrand = async (brand) => {
  if (brand.products.length > 0) {
    const result = await swal({
      icon: "error",
      title: "You can't delete this brand because this brand have products?",
      text: "If you click 'Delete, whatever!' button products will be automatically deleted.You will be able to restore this brand in the trash!",
      showCancelButton: true,
      confirmButtonText: "Delete, whatever!",
      confirmButtonColor: "#d52222",
      cancelButtonColor: "#626262",
      timer: 20000,
      timerProgressBar: true,
      reverseButtons: true,
    });
    if (result.isConfirmed) {
      handleDelete(brand.slug);
    }
  } else {
    const result = await swal({
      icon: "question",
      title: "Are you sure you want to delete this brand?",
      text: "You will be able to restore this brand in the trash!",
      showCancelButton: true,
      confirmButtonText: "Yes, Delete it!",
      confirmButtonColor: "#d52222",
      cancelButtonColor: "#626262",
      timer: 20000,
      timerProgressBar: true,
      reverseButtons: true,
    });

    if (result.isConfirmed) {
      handleDelete(brand.slug);
    }
  }
};

// Define Permissions Variables
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Brand Permission
const brandAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "brand.add")
    : false;
});

// Brand Edit Permission
const brandEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "brand.edit")
    : false;
});

// Brand Delete Permission
const brandDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "brand.delete")
    : false;
});

// Brand Trash List Permission
const brandTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "brand.trash.list"
      )
    : false;
});

if (usePage().props.flash.successMessage) {
  swal({
    icon: "success",
    title: usePage().props.flash.successMessage,
  });
}
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Brands" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="brandTrashList">
          <Link
            as="button"
            :href="route('admin.brands.trash')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
            class="trash-btn group"
          >
            <span class="group-hover:animate-pulse">
              <i class="fa-solid fa-trash-can-arrow-up"></i>
              Trash
            </span>
          </Link>
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Brand Button -->
        <Link
          v-if="brandAdd"
          as="button"
          :href="route('admin.brands.create')"
          :data="{
            per_page: params.per_page,
          }"
          class="add-btn"
        >
          <span>
            <i class="fa-solid fa-file-circle-plus"></i>
            Add Brand
          </span>
        </Link>

        <div class="flex items-center ml-auto">
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
                  placeholder="Select Date"
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
                  placeholder="Select Date"
                  v-model="createdUntil"
                />
              </div>
            </div>

            <div
              v-if="params.created_from || params.created_until"
              class="w-full flex items-center"
            >
              <button
                @click="resetFilteredDate"
                class="text-xs font-semibold px-3 ml-auto py-2 text-white bg-red-600 rounded-[4px] hover:bg-red-700 transition-all"
              >
                Reset Filter
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Brand Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> Image </HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            Name
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('description')">
            Description
            <SortingArrows :params="params" sort="description" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="brandEdit || brandDelete"> Action </HeaderTh>
        </TableHeader>

        <tbody v-if="brands.data.length">
          <Tr v-for="brand in brands.data" :key="brand.id">
            <BodyTh>
              {{ brand.id }}
            </BodyTh>

            <Td>
              <img :src="brand.image" class="image" />
            </Td>

            <Td>
              {{ brand.name }}
            </Td>

            <Td>
              <span v-html="brand.description" class="line-clamp-1 w-[500px]">
              </span>
            </Td>

            <Td>
              {{ brand.created_at }}
            </Td>

            <Td v-if="brandEdit || brandDelete">
              <!-- Edit Button -->
              <Link
                v-if="brandEdit"
                as="button"
                :href="route('admin.brands.edit', brand.slug)"
                :data="{
                  page: params.page,
                  per_page: params.per_page,
                  sort: params.sort,
                  direction: params.direction,
                }"
                class="edit-btn group"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-edit"></i>
                  Edit
                </span>
              </Link>

              <!-- Delete Button -->
              <button
                v-if="brandDelete"
                @click="handleDeleteBrand(brand)"
                class="delete-btn group"
                type="button"
              >
                <span class="group-hover:animate-pulse">
                  <i class="fa-solid fa-trash-can"></i>
                  Delete
                </span>
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Brand Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!brands.data.length" />

      <!-- Pagination -->
      <div v-if="brands.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ brands.from }} - {{ brands.to }} of {{ brands.total }}
        </p>
        <Pagination :links="brands.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

