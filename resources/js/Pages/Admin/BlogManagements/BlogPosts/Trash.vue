<script setup>
import NotAvaliableData from "@/Components/Table/NotAvaliableData.vue";
import SortingArrows from "@/Components/Table/SortingArrows.vue";
import Tr from "@/Components/Table/Tr.vue";
import Td from "@/Components/Table/Td.vue";
import HeaderTh from "@/Components/Table/HeaderTh.vue";
import BodyTh from "@/Components/Table/BodyTh.vue";
import TableHeader from "@/Components/Table/TableHeader.vue";
import TableContainer from "@/Components/Table/TableContainer.vue";
import Breadcrumb from "@/Components/Breadcrumbs/BlogPostBreadcrumb.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import { inject, reactive, watch, computed, ref } from "vue";
import { router, usePage, Link, Head } from "@inertiajs/vue3";

// Define the Props
const props = defineProps({
  trashBlogPosts: Object,
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
    route("admin.blogs.posts.trash"),
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
    route("admin.blogs.posts.trash"),
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
    route("admin.blogs.posts.trash"),
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

// Handle Trash Blog Post Restore
const handleRestoreTrashBlogPost = async (trashBlogPostId) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to restore this blog post?",
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
      route("admin.blogs.posts.restore", {
        trash_blog_post_id: trashBlogPostId,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {},
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
  }
};

// Handle Trash Blog Post Delete
const handleDeleteTrashBlogPost = async (trashBlogPostId) => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to delete it from the trash?",
    text: "Blog post in the trash will be permanetly deleted! You can't get it back.",
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
      route("admin.blogs.posts.force.delete", {
        trash_blog_post_id: trashBlogPostId,
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
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
  }
};

// Handle Trash Blog Post Delete Permanently
const handlePermanentlyDeleteBlogPosts = async () => {
  const result = await swal({
    icon: "question",
    title: "Are you sure you want to delete it from the trash?",
    text: "All blog posts in the trash will be permanetly deleted! You can't get it back.",
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
      route("admin.blogs.posts.permanently.delete", {
        page: params.page,
        per_page: params.per_page,
        sort: params.sort,
        direction: params.direction,
      }),
      {},
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
  }
};

// Define Permissions Variables
const permissions = ref(usePage().props.auth.user.permissions); // Permissions From HandleInertiaRequest.php

// Blog Post Trash Restore Permission
const blogPostTrashRestore = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-post.trash.restore"
      )
    : false;
});

// Blog Post Trash Delete Permission
const blogPostTrashDelete = computed(() => {
  return permissions.value.length
    ? permissions.value.some(
        (permission) => permission.name === "blog-post.trash.delete"
      )
    : false;
});
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Trash Blog Posts" />

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
            :href="route('admin.blogs.posts.index')"
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

      <!-- Blog Post Permanently Delete Button -->
      <p
        v-if="blogPostTrashDelete && trashBlogPosts.data.length !== 0"
        class="text-left text-sm font-bold mb-2 text-warning-600"
      >
        Blog posts in the Trash will be automatically deleted after 60 days.
        <button
          @click="handlePermanentlyDeleteBlogPosts"
          class="empty-trash-btn"
        >
          Empty the trash now
        </button>
      </p>

      <!-- Trash Blog Post Table Start -->
      <TableContainer>
        <TableHeader>
          <HeaderTh @click="updateSorting('id')">
            No
            <SortingArrows :params="params" sort="id" />
          </HeaderTh>

          <HeaderTh> Image </HeaderTh>

          <HeaderTh @click="updateSorting('title')">
            Title
            <SortingArrows :params="params" sort="title" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('description')">
            Description
            <SortingArrows :params="params" sort="description" />
          </HeaderTh>

          <HeaderTh @click="updateSorting('deleted_at')">
            Deleted At
            <SortingArrows :params="params" sort="deleted_at" />
          </HeaderTh>

          <HeaderTh v-if="blogPostTrashRestore || blogPostTrashDelete">
            Action
          </HeaderTh>
        </TableHeader>

        <tbody v-if="trashBlogPosts.data.length">
          <Tr
            v-for="trashBlogPost in trashBlogPosts.data"
            :key="trashBlogPost.id"
          >
            <BodyTh>
              {{ trashBlogPost.id }}
            </BodyTh>

            <Td>
              <img :src="trashBlogPost.image" class="image" />
            </Td>

            <Td>
              <span class="line-clamp-1">
                {{ trashBlogPost.title }}
              </span>
            </Td>

            <Td>
              <span
                v-html="trashBlogPost.description"
                class="line-clamp-1 w-[500px]"
              >
              </span>
            </Td>

            <Td class="w-[150px]">
              {{ trashBlogPost.deleted_at }}
            </Td>

            <Td
              v-if="blogPostTrashRestore || blogPostTrashDelete"
              class="w-[350px]"
            >
              <!-- Restore Button -->
              <button
                v-if="blogPostTrashRestore"
                @click="handleRestoreTrashBlogPost(trashBlogPost.id)"
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
                v-if="blogPostTrashDelete"
                @click="handleDeleteTrashBlogPost(trashBlogPost.id)"
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
      <!-- Trash Blog Post Table End -->

      <!-- No Data Row -->
      <NotAvaliableData v-if="!trashBlogPosts.data.length" />

      <!-- Pagination -->
      <div v-if="trashBlogPosts.data.length" class="mt-6">
        <p class="text-center text-sm text-gray-600 mb-3 font-bold">
          Showing {{ trashBlogPosts.from }} - {{ trashBlogPosts.to }} of
          {{ trashBlogPosts.total }}
        </p>
        <Pagination :links="trashBlogPosts.links" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>


