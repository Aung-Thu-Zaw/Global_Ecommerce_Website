<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BlogCommentBreadcrumb.vue";
import TrashButton from "@/Components/Buttons/TrashButton.vue";
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
import Pagination from "@/Components/Paginations/DashboardPagination.vue";
import { __ } from "@/Services/translations-inside-setup.js";
import { inject, computed, ref, reactive } from "vue";
import { router, Head, usePage } from "@inertiajs/vue3";

// Define the props
const props = defineProps({
  blogComments: Object,
});

// Define Variables
const swal = inject("$swal");
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Blog Comment Delete Permission
const blogCommentDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-comment.delete"
      )
    : false;
});

// Blog Comment Trash List Permission
const blogCommentTrashList = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-comment.trash.list"
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
    route("admin.blogs.comments.index"),
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

// Handle Delete Blog Comment
const handleDeleteBlogComment = async (blogComment) => {
  const result = await swal({
    icon: "question",
    title: __("ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_BLOG_COMMENT"),
    text: __("YOU_WILL_BE_ABLE_TO_RESTORE_THIS_BLOG_COMMENT_IN_THE_TRASH"),
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
      route("admin.blogs.comments.destroy", {
        blog_comment: blogComment,
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
    <Head :title="__('BLOG_COMMENTS')" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
        <Breadcrumb />

        <!-- Trash Button -->
        <div v-if="blogCommentTrashList">
          <TrashButton href="admin.blogs.comments.trash" />
        </div>
      </div>

      <div class="mb-5 flex items-center justify-between">
        <div class="flex items-center ml-auto">
          <!-- Search Box -->
          <DashboardSearchInputForm
            href="admin.blogs.comments.index"
            placeholder="SEARCH_BY_COMMENT"
          />

          <!-- Perpage Select Box -->
          <div class="ml-5">
            <DashboardPerPageSelectBox href="admin.blogs.comments.index" />
          </div>

          <!-- Filter By Date -->
          <DashboardFilterByCreatedDate href="admin.blogs.comments.index" />
        </div>
      </div>

      <!-- Blog Post Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> {{ __("BLOG_NAME") }} </HeaderTh>

          <HeaderTh> {{ __("COMMENTER_NAME") }} </HeaderTh>

          <HeaderTh @click="updateSorting('comment')">
            {{ __("COMMENT") }}
            <SortingArrows :params="params" sort="comment" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('created_at')">
            {{ __("CREATED_DATE") }}
            <SortingArrows :params="params" sort="created_at" />
          </HeaderTh>

          <HeaderTh v-if="blogCommentDelete"> {{ __("ACTION") }} </HeaderTh>
        </TableHeader>

        <tbody v-if="blogComments.data.length">
          <Tr v-for="blogComment in blogComments.data" :key="blogComment.id">
            <BodyTh>
              {{ blogComment.id }}
            </BodyTh>

            <Td>
              <span class="line-clamp-1 w-[300px]">
                {{ blogComment.blog_post?.title }}
              </span>
            </Td>

            <Td>
              {{ blogComment.user?.name }}
            </Td>

            <Td>
              <span class="line-clamp-1 w-[300px]">
                {{ blogComment.comment }}
              </span>
            </Td>

            <Td>
              {{ blogComment.created_at }}
            </Td>

            <Td v-if="blogCommentDelete" class="flex items-center">
              <!-- Delete Button -->
              <div v-if="blogCommentDelete">
                <DeleteButton
                  @click="handleDeleteBlogComment(blogComment.id)"
                />
              </div>
            </Td>
          </Tr>
        </tbody>
      </TableContainer>
      <!-- Blog Post Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!blogComments.data.length" />

      <!-- Pagination -->
      <div v-if="blogComments.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ blogComments.from }} - {{ blogComments.to }} of
          {{ blogComments.total }}
        </p>
        <Pagination :links="blogComments.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

