<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import InactiveStatus from "@/Components/Status/InactiveStatus.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BlogCategoryBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { reactive, watch, inject, computed, ref } from "vue";
import { router, Link, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  blogCategories: Object,
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
    route("admin.blogs.categories.index"),
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
    route("admin.blogs.categories.index"),
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
    route("admin.blogs.categories.index"),
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

// Handle Delete Blog Category
const handleBlogCategoryDelete = async (blogCategory) => {
  const result = await swal({
    icon: "warning",
    title: "Are you sure you want to delete this blog category?",
    text: "You will be able to restore this blog category in the trash!",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    confirmButtonColor: "#ef4444",
    timer: 20000,
    timerProgressBar: true,
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    router.delete(
      route("admin.blogs.categories.destroy", {
        blog_category: blogCategory,
        page: params.page,
        per_page: params.per_page,
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

// Define Permissions Variables
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Blog Category Permission
const blogCategoryAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-category.add"
      )
    : false;
});

// Blog Category Edit Permission
const blogCategoryEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-category.edit"
      )
    : false;
});

// Blog Category Delete Permission
const blogCategoryDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-category.delete"
      )
    : false;
});

// Blog Category Trash List Permission
const blogCategoryTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-category.trash.list"
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
    <Head title="Blog Categories" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="blogCategoryTrashList">
          <Link
            as="button"
            :href="route('admin.blogs.categories.trash')"
            :data="{
              page: 1,
              per_page: 10,
              sort: 'id',
              direction: 'desc',
            }"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700"
          >
            <i class="fa-solid fa-trash"></i>

            Trash
          </Link>
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Blog Category Button -->
        <Link
          v-if="blogCategoryAdd"
          as="button"
          :href="route('admin.blogs.categories.create')"
          :data="{
            per_page: params.per_page,
          }"
          class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700"
        >
          <i class="fa-sharp fa-solid fa-plus cursor-pointer"></i>
          Add Blog Category</Link
        >
        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <form class="w-[350px] relative">
            <input
              type="text"
              class="rounded-md border-2 border-slate-300 text-sm p-3 w-full"
              placeholder="Search"
              v-model="params.search"
            />

            <i
              v-if="params.search"
              class="fa-solid fa-xmark absolute top-4 right-5 text-slate-600 cursor-pointer hover:text-red-600"
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

      <!-- Blog Categories Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'id',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'id',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'id',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'id',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh> Image </HeaderTh>
          <HeaderTh @click="updateSorting('name')">
            Name
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'name',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'name',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'name',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'name',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('status')">
            Status
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'status',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'status',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'status',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'status',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh @click="updateSorting('created_at')">
            Created At
            <i
              class="fa-sharp fa-solid fa-arrow-up arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'asc' && params.sort === 'created_at',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'asc' &&
                  params.sort === 'created_at',
              }"
            ></i>
            <i
              class="fa-sharp fa-solid fa-arrow-down arrow-icon cursor-pointer"
              :class="{
                'text-blue-600':
                  params.direction === 'desc' && params.sort === 'created_at',
                'visually-hidden':
                  params.direction !== '' &&
                  params.direction !== 'desc' &&
                  params.sort === 'created_at',
              }"
            ></i>
          </HeaderTh>
          <HeaderTh v-if="blogCategoryEdit || blogCategoryDelete">
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="blogCategories.data.length">
          <Tr
            v-for="blogCategory in blogCategories.data"
            :key="blogCategory.id"
          >
            <BodyTh>
              {{ blogCategory.id }}
            </BodyTh>

            <Td>
              <img
                :src="blogCategory.image"
                class="w-[50px] h-[50px] rounded-full object-cover shadow-lg ring-2 ring-slate-300"
                alt=""
              />
            </Td>

            <Td>
              {{ blogCategory.name }}
            </Td>

            <Td>
              <ActiveStatus v-if="blogCategory.status == 'show'">
                {{ blogCategory.status }}
              </ActiveStatus>
              <InactiveStatus v-if="blogCategory.status == 'hide'">
                {{ blogCategory.status }}
              </InactiveStatus>
            </Td>

            <Td>
              {{ blogCategory.created_at }}
            </Td>

            <Td v-if="blogCategoryEdit || blogCategoryDelete">
              <Link
                v-if="blogCategoryEdit"
                as="button"
                :href="route('admin.blogs.categories.edit', blogCategory.slug)"
                :data="{
                  page: props.blogCategories.current_page,
                  per_page: params.per_page,
                }"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-700 mr-3 my-1"
              >
                <i class="fa-solid fa-edit"></i>
                Edit
              </Link>
              <button
                v-if="blogCategoryDelete"
                @click="handleBlogCategoryDelete(blogCategory.slug)"
                class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-red-600 text-white hover:bg-red-700 mr-3 my-1"
              >
                <i class="fa-solid fa-xmark"></i>
                Delete
              </button>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Blog Categories Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!blogCategories.data.length" />

      <!-- Pagination -->
      <Pagination class="mt-6" :links="blogCategories.links" />
    </div>
  </AdminDashboardLayout>
</template>

