<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/CollectionBreadcrumb.vue";
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
  collections: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Collection Permission
const collectionAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "collection.add"
      )
    : false;
});

// Collection Edit Permission
const collectionEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "collection.edit"
      )
    : false;
});

// Collection Delete Permission
const collectionDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "collection.delete"
      )
    : false;
});
// Collection Trash List Permission
const collectionTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "collection.trash.list"
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
    route("admin.collections.index"),
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

// Handle Delete Collection
const handleDeleteCollection = async (collection) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_COLLECTION"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_COLLECTION_IN_THE_TRASH"),
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
      route("admin.collections.destroy", {
        collection: collection,
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
    <Head :title="__('COLLECTIONS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="collectionTrashList">
          <TrashButton href="admin.collections.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Collection Button -->

        <div v-if="collectionAdd">
          <CreateButton href="admin.collections.create" name="ADD_COLLECTION" />
        </div>

        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.collections.index"
            placeholder="SEARCH_BY_TITLE"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.collections.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.collections.index" />
        </div>
      </div>

      <!-- Collection Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('title')">
            {{ __("TITLE") }}
            <SortingArrows :params="params" sort="title" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('description')">
            {{ __("DESCRIPTION") }}
            <SortingArrows :params="params" sort="description" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="collectionEdit || collectionDelete">
            {{ __("ACTION") }}
          </HeaderTh>
        </TableHeader>

        <tbody v-if="collections.data.length">
          <Tr v-for="collection in collections.data" :key="collection.id">
            <BodyTh>
              {{ collection.id }}
            </BodyTh>

            <Td>
              {{ collection.title }}
            </Td>

            <Td>
              {{ collection.description }}
            </Td>

            <Td>
              {{ collection.created_at }}
            </Td>

            <Td v-if="collectionEdit || collectionDelete">
              <!-- Edit Button -->
              <div v-if="collectionEdit">
                <EditButton
                  href="admin.collections.edit"
                  :slug="collection.slug"
                />
              </div>

              <!-- Delete Button -->
              <div v-if="collectionDelete">
                <DeleteButton
                  @click="handleDeleteCollection(collection.slug)"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Collection Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!collections.data.length" />

      <!-- Pagination -->
      <div v-if="collections.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ collections.from }} - {{ collections.to }} of
          {{ collections.total }}
        </p>
        <Pagination :links="collections.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

