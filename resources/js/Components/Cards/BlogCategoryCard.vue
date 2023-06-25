<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  blogCategories: Object,
});
</script>

<template>
  <li
    v-for="blogCategory in blogCategories"
    :key="blogCategory.id"
    class="py-2 rounded-sm transition-all ring-2 ring-slate-300 shadow px-4"
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
        class="w-10 h-10 object-cover rounded-full ring-2 ring-slate-300"
      />
      {{ blogCategory.name }}
      <span
        class="text-[.8rem] ml-3 w-6 h-6 rounded-full border-2 border-slate-300 flex items-center justify-center"
      >
        <span>
          {{
            blogCategory.blog_posts_count ? blogCategory.blog_posts_count : 0
          }}
        </span>
      </span>
    </Link>
  </li>
</template>

