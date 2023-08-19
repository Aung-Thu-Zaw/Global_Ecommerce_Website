<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CategoryBreadcrumb.vue";
import ActiveStatus from "@/Components/Status/ActiveStatus.vue";
import InactiveStatus from "@/Components/Status/InactiveStatus.vue";
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
  categories: Object,
});

// Define Variables
const swal = inject("$swal");
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
    route("admin.categories.index"),
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

// Handle Category Delete
const handleDelete = (category) => {
  router.delete(
    route("admin.categories.destroy", {
      category: category,
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
};

// Handle Delete Category
const handleDeleteCategory = async (category) => {
  if (category.children.length > 0) {
    const result = await swal({
      icon: "error",
      title: __(
        "YOU_CANT_DELETE_THIS_CATEGORY_BECAUSE_THIS_CATEGORY_HAVE_CHILDREN_CATEGORIES"
      ),
      text: __(
        "IF_YOU_CLICK_THE_DELETE_WHATEVER_BUTTON_CHILDREN_CATEGORY_ASSOCIATED_WITH_THAT_PARENT_CATEGORY_WILL_BE_AUTOMATICALLY_DELETED"
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
      handleDelete(category.slug);
    }
  } else {
    const result = await swal({
      icon: "question",
      title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_CATEGORY"),
      text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_CATEGORY_IN_THE_TRASH"),
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
      handleDelete(category.slug);
    }
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
    <Head :title="__('CATEGORIES')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="categoryTrashList">
          <TrashButton href="admin.categories.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Category Button -->

        <div v-if="categoryAdd">
          <CreateButton href="admin.categories.create" name="ADD_CATEGORY" />
        </div>

        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.categories.index"
            placeholder="SEARCH_BY_NAME"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.categories.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.categories.index" />
        </div>
      </div>

      <!-- Category Table Start -->
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

          <HeaderTh v-if="categoryEdit || categoryDelete">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="categories.data.length">
          <Tr v-for="category in categories.data" :key="category.id">
            <BodyTh>
              {{ category.id }}
            </BodyTh>

            <Td>
              <img v-if="category.image" :src="category.image" class="image" />

              <img
                v-else
                src="https://media.istockphoto.com/id/1357365823/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg?s=612x612&w=0&k=20&c=PM_optEhHBTZkuJQLlCjLz-v3zzxp-1mpNQZsdjrbns="
                class="image"
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

            <Td v-if="categoryEdit || categoryDelete" class="flex items-center">
              <!-- Edit Button -->
              <div v-if="categoryEdit">
                <EditButton
                  href="admin.categories.edit"
                  :slug="category.slug"
                />
              </div>

              <!-- Delete Button -->
              <div v-if="categoryDelete">
                <DeleteButton @click="handleDeleteCategory(category)" />
              </div>
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

