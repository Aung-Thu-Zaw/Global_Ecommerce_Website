<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import InactiveStatus from "@/Components/Status/InactiveStatus.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CategoryBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  categories: Object,
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
    route("admin.categories.index"),
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
    route("admin.categories.index"),
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
    route("admin.categories.index"),
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

// Handle Category Delete
const handleDelete = (category) => {
  router.delete(
    route("admin.categories.destroy", {
      category: category,
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
};

// Handle Delete Category
const handleDeleteCategory = async (category) => {
  if (category.children.length > 0) {
    const result = await swal({
      icon: "error",
      title:
        "You can't delete this category because this category have children category?",
      text: "If you click 'Delete, whatever!' button children category will be automatically deleted.You will be able to restore this category in the trash!",
      showCancelButton: true,
      confirmButtonText: "Delete, whatever!",
      confirmButtonColor: "#d52222",
      cancelButtonColor: "#626262",
      timer: 20000,
      timerProgressBar: true,
      reverseButtons: true,
    });
    if (result.isConfirmed) {
      handleDelete(category.slug);
    }
  } else {
    const result = await swal({
      icon: "question",
      title: "Are you sure you want to delete this category?",
      text: "You will be able to restore this category in the trash!",
      showCancelButton: true,
      confirmButtonText: "Yes, Delete it!",
      confirmButtonColor: "#d52222",
      cancelButtonColor: "#626262",
      timer: 20000,
      timerProgressBar: true,
      reverseButtons: true,
    });

    if (result.isConfirmed) {
      handleDelete(category.slug);
    }
  }
};

// Define Permissions Variables
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Category Permission
const categoryAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some((permission) => permission.name === "category.add")
    : false;
});

// Category Edit Permission
const categoryEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "category.edit"
      )
    : false;
});

// Category Delete Permission
const categoryDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "category.delete"
      )
    : false;
});

// Category Trash List Permission
const categoryTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "category.trash.list"
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
    <Head title="Categories" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="categoryTrashList">
          <Link
            as="button"
            :href="route('admin.categories.trash')"
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
        <!-- Create Category Button -->
        <Link
          v-if="categoryAdd"
          as="button"
          :href="route('admin.categories.create')"
          :data="{
            per_page: params.per_page,
          }"
          class="add-btn"
        >
          <span>
            <i class="fa-solid fa-file-circle-plus"></i>
            Add Category
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
            <select
              class="py-3 w-[80px] border-gray-300 rounded-md focus:border-gray-300 focus:ring-0 text-sm"
              v-model="params.per_page"
            >
              <option value="" disabled>Select</option>
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
              <option value="75">75</option>
              <option value="100">100</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Category Table Start -->
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

          <HeaderTh @click="updateSorting('status')">
            Status
            <SortingArrows :params="params" sort="status" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="categoryEdit || categoryDelete"> Action </HeaderTh>
        </TableHeader>

        <tbody v-if="categories.data.length">
          <Tr v-for="category in categories.data" :key="category.id">
            <BodyTh>
              {{ category.id }}
            </BodyTh>

            <Td>
              <img
                :src="category.image"
                class="w-[50px] h-[50px] rounded-full object-cover shadow-lg ring-2 ring-slate-300"
                alt=""
              />
            </Td>

            <Td>
              {{ category.name }}
            </Td>

            <Td>
              <ActiveStatus v-if="category.status == 'show'">
                {{ category.status }}
              </ActiveStatus>
              <InactiveStatus v-if="category.status == 'hide'">
                {{ category.status }}
              </InactiveStatus>
            </Td>

            <Td>
              {{ category.created_at }}
            </Td>

            <Td v-if="categoryEdit || categoryDelete">
              <!-- Edit Button -->
              <Link
                v-if="categoryEdit"
                as="button"
                :href="route('admin.categories.edit', category.slug)"
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
                v-if="categoryDelete"
                @click="handleDeleteCategory(category)"
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
      <!-- Category Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!categories.data.length" />

      <!-- Pagination -->
      <div v-if="categories.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ categories.from }} - {{ categories.to }} of
          {{ categories.total }}
        </p>
        <Pagination :links="categories.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

