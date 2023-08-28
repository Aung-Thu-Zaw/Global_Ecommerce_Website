<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/HomeBreadcrumb.vue";
import BlogTagCard from "@/Components/Cards/Blogs/BlogTagCard.vue";
import BlogCard from "@/Components/Cards/Blogs/BlogCardGrid.vue";
import BlogCategoryCard from "@/Components/Cards/Blogs/BlogCategoryCard.vue";
import BlogCardList from "@/Components/Cards/Blogs/BlogCardList.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import { usePage, Head, Link, router } from "@inertiajs/vue3";
import { reactive, watch } from "vue";

const props = defineProps({
  blogCategories: Object,
  blogTags: Object,
  blogTag: Object,
  blogPosts: Object,
});

// Query String Parameters
const params = reactive({
  search_blog: usePage().props.ziggy.query?.search_blog,
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  page: usePage().props.ziggy.query?.page,
  view: usePage().props.ziggy.query?.view,
});

const handleQueryStringParameter = () => {
  router.get(
    route("blogs.tag", props.blogTag.slug),
    {
      search_blog: params.search_blog,
      sort: params.sort,
      direction: params.direction,
      page: params.page,
      view: params.view,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Remove Search Param
const removeSearch = () => {
  params.search_blog = "";
  router.get(
    route("blogs.tag", props.blogTag.slug),
    {
      sort: params.sort,
      direction: params.direction,
      page: params.page,
      view: params.view,
    },
    {
      replace: true,
      preserveState: true,
    }
  );
};

// Watching Blog Search Input
watch(
  () => params.search_blog,
  () => {
    if (params.search_blog === "") {
      removeSearch();
    } else {
      handleQueryStringParameter();
    }
  }
);

// Watching Sorting Dropdown
watch(
  () => params.direction,
  () => {
    handleQueryStringParameter();
  }
);

// Remove Filter Tag
const handleRemoveBlogTag = () => {
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
    <Head :title="__('BLOGS')" />

    <div class="min-h-screen bg-gray-50 mt-40 w-full py-6">
      <div class="w-[1500px] mx-auto">
        <!-- Home Blog Breadcrumb Start -->
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
                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                  {{ __("BLOGS") }}
                </span>
              </div>
            </li>
          </Breadcrumb>
          <!-- Home Blog Breadcrumb End -->
        </div>

        <div class="flex items-start space-x-3">
          <div class="w-[400px]">
            <!-- Sidebar Blog Categories -->
            <ul
              v-if="blogCategories.length"
              class="h-auto space-y-3 text-center text-md font-bold text-slate-700 mb-10"
            >
              <BlogCategoryCard :blogCategories="blogCategories" />
            </ul>

            <!-- Sidebar Blog Tags -->
            <div v-if="blogTags.length">
              <BlogTagCard :blogTags="blogTags" />
            </div>
          </div>

          <div class="w-full">
            <div
              class="text-sm font-bold text-slate-600 px-5 py-3 border-t border-b flex items-center justify-between mb-5"
            >
              <!-- Search Blogs From Input -->
              <form
                class="w-[350px] rounded-md flex items-center justify-between border border-gray-400 focus:border-gray-400 p-1"
              >
                <input
                  type="text"
                  class="border-0 focus:ring-0 text-sm bg-gray-50 w-full"
                  :placeholder="__('SEARCH_BLOG')"
                  v-model="params.search_blog"
                />
                <i
                  v-if="params.search_blog"
                  class="fa-solid fa-xmark mr-2 text-slate-600 cursor-pointer hover:text-red-600"
                  @click="removeSearch"
                ></i>
              </form>

              <!-- Search Result Text -->
              <p v-if="params.search_blog" class="ml-5">
                {{ blogPosts.total }} {{ __("POSTS_FOUND_FOR_RESULT") }}
                <span class="text-blue-600">"{{ params.search_blog }}"</span>
              </p>

              <div class="flex items-center ml-auto">
                <!-- Blog Sorting Dropdown -->
                <div class="w-[210px] flex items-center justify-between">
                  <span class="flex items-center">{{ __("SORT_BY") }} : </span>
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
                      {{ __("LATEST_POST") }}
                    </option>
                    <option value="asc" :selected="params.direction === 'asc'">
                      {{ __("NEWEST_POST") }}
                    </option>
                  </select>
                </div>

                <!-- Blog Grid And List Views -->
                <div class="flex items-center ml-3">
                  <span class="mr-2"> {{ __("VIEW") }} : </span>
                  <div class="flex items-center justify-between">
                    <!-- Grid View -->
                    <Link
                      as="button"
                      :href="route('blogs.tag', blogTag.slug)"
                      :data="{
                        search_blog: params.search_blog,
                        blog_category: params.blog_category,
                        sort: params.sort,
                        direction: params.direction,
                        page: params.page,
                        view: 'grid',
                      }"
                      class="px-2 py-1 rounded-md cursor-pointer hover:bg-gray-300 transition-none"
                      :class="{
                        'bg-gray-400 text-white': params.view === 'grid',
                        'bg-gray-200': params.view !== 'grid',
                      }"
                    >
                      <i class="fa-solid fa-grip"></i>
                    </Link>

                    <!-- List View -->
                    <Link
                      as="button"
                      :href="route('blogs.tag', blogTag.slug)"
                      :data="{
                        search_blog: params.search_blog,
                        blog_category: params.blog_category,
                        sort: params.sort,
                        direction: params.direction,
                        page: params.page,
                        view: 'list',
                      }"
                      class="ml-3 px-2 py-1 rounded-md cursor-pointer hover:bg-gray-300 transition-none"
                      :class="{
                        'bg-gray-400 text-white': params.view === 'list',
                        'bg-gray-200': params.view !== 'list',
                      }"
                    >
                      <i class="fa-solid fa-list"></i>
                    </Link>
                  </div>
                </div>
              </div>
            </div>

            <!-- Filter tags -->
            <div v-if="blogTag" class="my-3 w-full">
              <span class="font-bold text-slate-600 text-lg mr-3"
                >{{ __("FILTERED_BY") }} :</span
              >

              <span
                class="text-sm mr-2 border-2 border-slate-300 px-3 py-1 rounded-xl text-slate-700 shadow capitalize"
              >
                {{ __("TAG") }} : {{ blogTag.name }}

                <i
                  @click="handleRemoveBlogTag"
                  class="fa-solid fa-xmark text-sm font-bold cursor-pointer hover:text-red-700 transition-all"
                >
                </i>
              </span>
            </div>

            <!-- Blog Cards List View -->
            <div v-if="params.view === 'list'" class="w-full">
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

            <!-- Blog Cards Grid View -->
            <div v-else>
              <div v-if="blogPosts.data.length" class="grid grid-cols-4 gap-5">
                <div v-for="blogPost in blogPosts.data" :key="blogPost.id">
                  <BlogCard :post="blogPost" />
                </div>
              </div>
            </div>

            <!-- Blog Pagination -->
            <Pagination class="mt-6" :links="blogPosts.links" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

