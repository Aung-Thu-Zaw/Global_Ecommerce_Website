<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/HomeBreadcrumb.vue";
import BlogCard from "@/Components/Cards/BlogCard.vue";
import BlogCategoryCard from "@/Components/Cards/BlogCategoryCard.vue";
import BlogCardList from "@/Components/Cards/BlogCardList.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import { usePage, Head, Link, router } from "@inertiajs/vue3";
import { reactive, watch } from "vue";

defineProps({
  blogCategories: Object, // data come from blog controller
  blogPosts: Object, // data come from blog controller
});

const handleSearchBox = () => {
  params.search_blog = "";
};

// Query String Parameters
const params = reactive({
  search_blog: usePage().props.ziggy.query.search_blog,
  sort: "id",
  direction: usePage().props.ziggy.query.direction
    ? usePage().props.ziggy.query.direction
    : "desc",

  page: usePage().props.ziggy.query.page,
  blog_category: usePage().props.ziggy.query.blog_category,
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});

// Watching Blog Search Input
watch(
  () => params.search_blog,
  () => {
    router.get(
      route("blogs.index"),
      {
        search_blog: params.search_blog,
        sort: params.sort,
        direction: params.direction,
        page: params.page,
        blog_category: params.blog_category,
        view: params.view,
      },
      {
        replace: true,
        preserveState: true,
      }
    );
  }
);

// Watching Sorting Dropdown
watch(
  () => params.direction,
  () => {
    router.get(
      route("blogs.index"),
      {
        search_blog: params.search_blog,
        sort: params.sort,
        direction: params.direction,
        page: params.page,
        blog_category: params.blog_category,
        view: params.view,
      },
      {
        replace: true,
        preserveState: true,
      }
    );
  }
);

// Remove Filter Tag
const handleRemoveBlogCategory = () => {
  router.get(route("blogs.index"), {
    search_blog: params.search_blog,
    sort: params.sort,
    direction: params.direction,
    page: params.page,
    view: params.view,
  });
};
</script>

<template>
  <AppLayout>
    <Head title="Blogs" />

    <div class="min-h-screen bg-gray-50 mt-40 w-full py-6">
      <div class="w-[1500px] mx-auto">
        <!-- Breadcrumb  -->
        <div class="border-b py-3 mb-5">
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
                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2"
                  >Blogs</span
                >
              </div>
            </li>
          </Breadcrumb>
        </div>

        <div class="flex items-start space-x-3">
          <!-- Blog Category Cards  -->
          <div v-if="blogCategories.length" class="w-[400px]">
            <ul
              class="h-auto space-y-3 text-center text-md font-bold text-slate-700"
            >
              <BlogCategoryCard :blogCategories="blogCategories" />
            </ul>
          </div>

          <div class="w-full">
            <div
              class="text-sm font-bold text-slate-600 px-5 py-3 border-t border-b flex items-center justify-between mb-5"
            >
              <!-- Search Blogs Input -->
              <div
                class="border-2 border-slate-400 rounded-sm shadow w-[300px] flex items-center justify-between py-1"
              >
                <input
                  type="text"
                  placeholder="Search Blogs"
                  class="text-sm w-full focus:ring-0 border-none bg-gray-50"
                  v-model="params.search_blog"
                />
                <span v-if="params.search_blog" class="mx-3 cursor-pointer">
                  <i
                    @click="handleSearchBox"
                    class="fa-solid fa-xmark hover:text-xl hover:text-slate-700 transition-all"
                  ></i>
                </span>
              </div>

              <!-- Search Result Text -->
              <p v-if="params.search_blog" class="ml-5">
                {{ blogPosts.data.length }} post found for result
                <span class="text-blue-600">"{{ params.search_blog }}"</span>
              </p>

              <div class="flex items-center ml-auto">
                <!-- Blog Sorting -->
                <div class="w-[220px] flex items-center justify-between">
                  <span class="">Sort By : </span>
                  <select
                    id="countries"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[150px] p-2.5 text-slate-700"
                    v-model="params.direction"
                  >
                    <option
                      value="desc"
                      :selected="
                        params.direction === 'desc' || params.direction === null
                      "
                    >
                      Latest Post
                    </option>
                    <option value="asc" :selected="params.direction === 'asc'">
                      Newest Post
                    </option>
                  </select>
                </div>

                <!-- Blog Card Views -->
                <div class="flex items-center ml-3">
                  <span class="mr-2">View : </span>
                  <div class="flex items-center justify-between">
                    <Link
                      :href="route('blogs.index')"
                      :data="{
                        search_blog: $page.props.ziggy.query.search_blog,
                        blog_category: $page.props.ziggy.query.blog_category,
                        sort: $page.props.ziggy.query.sort,
                        direction: $page.props.ziggy.query.direction,
                        page: $page.props.ziggy.query.page,
                        view: 'grid',
                      }"
                      class="px-2 py-1 rounded-md cursor-pointer hover:bg-gray-300 transition-none"
                      :class="{
                        'bg-gray-400 text-white':
                          $page.props.ziggy.query.view === 'grid',
                        'bg-gray-200': $page.props.ziggy.query.view !== 'grid',
                      }"
                    >
                      <i class="fa-solid fa-grip"></i>
                    </Link>
                    <Link
                      :href="route('blogs.index')"
                      :data="{
                        search_blog: $page.props.ziggy.query.search_blog,
                        blog_category: $page.props.ziggy.query.blog_category,
                        sort: $page.props.ziggy.query.sort,
                        direction: $page.props.ziggy.query.direction,
                        page: $page.props.ziggy.query.page,
                        view: 'list',
                      }"
                      class="ml-3 px-2 py-1 rounded-md cursor-pointer hover:bg-gray-300 transition-none"
                      :class="{
                        'bg-gray-400 text-white':
                          $page.props.ziggy.query.view === 'list',
                        'bg-gray-200': $page.props.ziggy.query.view !== 'list',
                      }"
                    >
                      <i class="fa-solid fa-list"></i>
                    </Link>
                  </div>
                </div>
              </div>
            </div>

            <!-- Filter tags -->
            <div class="my-3 w-full">
              <span
                v-if="$page.props.ziggy.query.blog_category"
                class="font-bold text-slate-600 text-lg mr-3"
                >Filtered By :</span
              >

              <span
                v-if="$page.props.ziggy.query.blog_category"
                class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow capitalize"
              >
                Category : {{ $page.props.ziggy.query.blog_category }}

                <i
                  @click="handleRemoveBlogCategory"
                  class="fa-solid fa-xmark text-sm font-bold cursor-pointer hover:text-red-700 transition-all"
                >
                </i>
              </span>
            </div>

            <!-- Blog Cards -->
            <div v-if="$page.props.ziggy.query.view === 'list'" class="w-full">
              <div v-if="blogPosts.data.length" class="w-full">
                <div
                  v-for="blogPost in blogPosts.data"
                  :key="blogPost.id"
                  class="w-full"
                >
                  <BlogCardList :post="blogPost" />
                </div>
              </div>
            </div>
            <div v-else>
              <div v-if="blogPosts.data.length" class="grid grid-cols-4 gap-5">
                <div v-for="blogPost in blogPosts.data" :key="blogPost.id">
                  <BlogCard :post="blogPost" />
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <Pagination class="mt-6" :links="blogPosts.links" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

