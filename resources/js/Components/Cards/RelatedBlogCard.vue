<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  blogPost: Object,
});
</script>

<template>
  <div class="flex items-center">
    <div class="w-[100px]">
      <img
        :src="blogPost.image"
        class="rounded-lg shadow-sm w-16 h-16 object-cover border border-slate-300"
      />
    </div>
    <div class="w-full">
      <Link
        :href="route('blogs.show', blogPost.slug)"
        :data="{
          sort: $page.props.ziggy.query?.sort,
          direction: $page.props.ziggy.query?.direction,
          view: $page.props.ziggy.query?.view,
        }"
        class="hover:text-blue-700 text-md font-semibold text-gray-700 line-clamp-2"
      >
        {{ blogPost.title }}
      </Link>
      <div class="flex items-center justify-between mb-3">
        <span class="font-bold text-slate-400 text-[.7rem]">
          <i class="fa-solid fa-user mr-2"></i>
          {{ blogPost.author?.name }}
        </span>
        <span class="font-bold text-slate-400 text-[.7rem]">
          <i class="fa-solid fa-clock mr-2"></i>
          {{ blogPost.created_at }}
        </span>
      </div>
    </div>
  </div>
</template>

