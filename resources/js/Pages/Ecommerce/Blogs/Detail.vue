<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/HomeBreadcrumb.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  blogPost: Object,
  blogCategories: Object,
});
</script>

<template>
  <AppLayout>
    <Head :title="blogPost.title" />

    <div class="min-h-screen bg-gray-50 mt-40 w-full py-6">
      <div class="container mx-auto">
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
                <span
                  class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                  >Blogs</span
                >
              </div>
            </li>
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
                  class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                >
                  {{ blogPost.slug }}
                </span>
              </div>
            </li>
          </Breadcrumb>
        </div>

        <div class="flex items-start space-x-3">
          <div v-if="blogCategories.length" class="w-[400px]">
            <ul
              class="h-auto space-y-3 text-center text-md font-bold text-slate-700"
            >
              <li
                v-for="blogCategory in blogCategories"
                :key="blogCategory.id"
                class="py-2 rounded-sm transition-all border border-slate-300 shadow px-4"
                :class="{
                  'bg-blue-600 text-white hover:bg-blue-700':
                    $page.props.ziggy.query.blog_category === blogCategory.slug,

                  'bg-gray-100 hover:bg-gray-200':
                    $page.props.ziggy.query.blog_category !== blogCategory.slug,
                }"
              >
                <Link
                  :href="route('blogs.index')"
                  :data="{
                    search_blog: $page.props.ziggy.query.search_blog,
                    blog_category: blogCategory.slug,
                    sort: $page.props.ziggy.query.sort,
                    direction: $page.props.ziggy.query.direction,
                    page: $page.props.ziggy.query.page,
                    view: $page.props.ziggy.query.view,
                  }"
                  class="flex items-center justify-between"
                >
                  <img
                    :src="blogCategory.image"
                    class="w-10 h-10 object-cover rounded-full ring-2 ring-slate-500"
                  />
                  {{ blogCategory.name }}
                  <span
                    class="text-[.8rem] ml-3 w-6 h-6 rounded-full border-2 border-slate-300 flex items-center justify-center"
                  >
                    <span>
                      {{
                        blogCategory.blog_posts
                          ? blogCategory.blog_posts.length
                          : 0
                      }}
                    </span>
                  </span>
                </Link>
              </li>
            </ul>
          </div>
          <div class="w-full pl-10">
            <img :src="blogPost.image" alt="" class="h-[400px] rounded-t-md" />

            <h1 class="font-bold text-2xl text-slate-700 mt-8 mb-2">
              {{ blogPost.title }}
            </h1>

            <div class="flex items-center mb-3">
              <span class="font-bold text-slate-600 text-sm mr-3">
                <i class="fa-solid fa-user mr-2"></i>
                {{ blogPost.author.name }}
              </span>
              <span class="font-bold text-slate-600 text-sm">
                <i class="fa-solid fa-clock mr-2"></i>
                {{ blogPost.created_at }}
              </span>
            </div>

            <hr class="my-3" />

            <p v-html="blogPost.description" class="text-ms text-slate-600"></p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

