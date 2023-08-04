<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/HomeBreadcrumb.vue";
import BlogCategoryCard from "@/Components/Cards/BlogCategoryCard.vue";
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
          <!-- Breadcrumb -->
          <Breadcrumb>
            <li aria-current="page">
              <Link
                :href="route('blogs.index')"
                :data="{
                  sort: $page.props.ziggy.query.sort,
                  direction: $page.props.ziggy.query.direction,
                  view: $page.props.ziggy.query.view,
                }"
              >
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
                    class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-700 md:ml-2"
                  >
                    {{ __("BLOGS") }}
                  </span>
                </div>
              </Link>
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
                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                  {{ blogPost.title }}
                </span>
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

          <!-- Blogs Detail -->
          <div class="w-full pl-10">
            <img
              :src="blogPost.image"
              alt=""
              class="h-[400px] rounded-t-md object-cover"
            />

            <h1 class="font-bold text-2xl text-slate-700 mt-8 mb-2">
              {{ blogPost.title }}
            </h1>

            <div class="flex items-center mb-3">
              <span
                class="text-xs font-bold bg-gray-300 py-1 px-3 rounded-sm shadow mr-3"
              >
                {{ blogPost.blog_category.name }}
              </span>

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

            <!-- Tags -->
            <div
              v-if="blogPost.blog_tags.length"
              class="flex items-center my-5"
            >
              <span class="font-bold text-gray-600 mr-3">Blog Tags :</span>
              <div class="flex items-center space-x-3">
                <Link
                  href="#"
                  v-for="blogTag in blogPost.blog_tags"
                  :key="blogTag.id"
                  class="px-3 py-1 bg-blue-600 rounded-full text-white text-xs capitalize font-medium"
                >
                  {{ blogTag.name }}
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

