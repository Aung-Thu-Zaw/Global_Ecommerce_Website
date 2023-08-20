<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BlogPostBreadcrumb.vue";
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
  blogPosts: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Create New Blog Post Permission
const blogPostAdd = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-post.add"
      )
    : false;
});

// Blog Post Edit Permission
const blogPostEdit = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-post.edit"
      )
    : false;
});

// Blog Post Delete Permission
const blogPostDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-post.delete"
      )
    : false;
});

// Blog Post Trash List Permission
const blogPostTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-post.trash.list"
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
    route("admin.blogs.posts.index"),
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

// Handle Delete Blog Post
const handleDeleteBlogPost = async (blogPost) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_BLOG_POST"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_BLOG_POST_IN_THE_TRASH"),
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
      route("admin.blogs.posts.destroy", {
        blog_post: blogPost,
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
    <Head :title="__('BLOG_POSTS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="blogPostTrashList">
          <TrashButton href="admin.blogs.posts.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <!-- Create Blog Post Button -->
        <div v-if="blogPostAdd">
          <CreateButton href="admin.blogs.posts.create" name="ADD_BLOG_POST" />
        </div>

        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.blogs.posts.index"
            placeholder="SEARCH_BY_NAME"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.blogs.posts.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.blogs.posts.index" />
        </div>
      </div>

      <!-- Blog Post Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> {{ __("IMAGE") }} </HeaderTh>

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

          <HeaderTh v-if="blogPostEdit || blogPostDelete"> Action </HeaderTh>
        </TableHeader>

        <tbody v-if="blogPosts.data.length">
          <Tr v-for="blogPost in blogPosts.data" :key="blogPost.id">
            <BodyTh>
              {{ blogPost.id }}
            </BodyTh>

            <Td>
              <img :src="blogPost.image" class="image" />
            </Td>

            <Td class="line-clamp-1 w-[400px]">
              {{ blogPost.title }}
            </Td>

            <Td>
              <span
                v-html="blogPost.description"
                class="line-clamp-1 w-[400px]"
              >
              </span>
            </Td>

            <Td class="w-[150px]">
              {{ blogPost.created_at }}
            </Td>

            <Td
              v-if="blogPostEdit || blogPostDelete"
              class="w-[300px] flex items-center"
            >
              <!-- Edit Button -->
              <div v-if="blogPostEdit">
                <EditButton
                  href="admin.blogs.posts.edit"
                  :slug="blogPost.slug"
                />
              </div>

              <!-- Delete Button -->
              <div v-if="blogPostDelete">
                <DeleteButton @click="handleDeleteBlogPost(blogPost.slug)" />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Blog Post Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!blogPosts.data.length" />

      <!-- Pagination -->
      <div v-if="blogPosts.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ blogPosts.from }} - {{ blogPosts.to }} of
          {{ blogPosts.total }}
        </p>
        <Pagination :links="blogPosts.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

