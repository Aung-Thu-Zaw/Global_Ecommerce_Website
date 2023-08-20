<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BlogCategoryBreadcrumb.vue";
import CreateButton from "@/Components/Buttons/CreateButton.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
import EditButton from "@/Components/Buttons/EditButton.vue";
import DeleteButton from "@/Components/Buttons/DeleteButton.vue";
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import InactiveStatus from "@/Components/Status/InactiveStatus.vue";
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
  blogCategories: Object,
});

// Define Variables
const swal = inject("$swal");
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
    route("admin.blogs.categories.index"),
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

// Handle Delete Blog Category
const handleDeleteBlogCategory = async (blogCategory) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_BLOG_CATEGORY"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_BLOG_CATEGORY_IN_THE_TRASH"),
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
      route("admin.blogs.categories.destroy", {
        blog_category: blogCategory,
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
    <Head :title="__('BLOG_CATEGORIES')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="blogCategoryTrashList">
          <TrashButton href="admin.blogs.categories.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Blog Category Button -->
        <div v-if="blogCategoryAdd">
          <CreateButton
            href="admin.blogs.categories.create"
            name="ADD_BLOG_CATEGORY"
          />
        </div>

        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.blogs.categories.index"
            placeholder="SEARCH_BY_NAME"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.blogs.categories.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.blogs.categories.index" />
        </div>
      </div>

      <!-- Blog Categories Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> {{ __("IMAGE") }} </HeaderTh>

          <HeaderTh @click="updateSorting('name')">
            {{ __("NAME") }}
            <SortingArrows :params="params" sort="name" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('status')">
            {{ __("STATUS") }}
            <SortingArrows :params="params" sort="status" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="blogCategoryEdit || blogCategoryDelete">
            {{ __("ACTION") }}
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
              <img :src="blogCategory.image" class="image" />
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

            <Td
              v-if="blogCategoryEdit || blogCategoryDelete"
              class="flex items-center"
            >
              <!-- Edit Button -->
              <div v-if="blogCategoryEdit">
                <EditButton
                  href="admin.blogs.categories.edit"
                  :slug="blogCategory.slug"
                />
              </div>

              <!-- Delete Button -->
              <div v-if="blogCategoryDelete">
                <DeleteButton
                  @click="handleDeleteBlogCategory(blogCategory.slug)"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Blog Categories Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!blogCategories.data.length" />

      <!-- Pagination -->
      <div v-if="blogCategories.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ blogCategories.from }} - {{ blogCategories.to }} of
          {{ blogCategories.total }}
        </p>
        <Pagination :links="blogCategories.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

