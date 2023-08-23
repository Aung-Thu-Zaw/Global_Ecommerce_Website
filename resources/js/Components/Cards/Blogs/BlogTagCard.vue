<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  blogTags: Object,
});
</script>

<template>
  <div class="border shadow-lg rounded-sm border-slate-400">
    <h1
      class="text-lg font-semibold text-slate-700 text-center border-b border-slate-400 px-4 py-2"
    >
      {{ __("BLOG_TAGS") }}
    </h1>

    <div class="flex flex-wrap items-center space-x-2 space-y-2 p-3">
      <Link
        v-for="blogTag in blogTags"
        :key="blogTag.id"
        :href="route('blogs.tag', blogTag.slug)"
        :data="{
          view: 'grid',
          sort: 'id',
          direction: 'desc',
        }"
        class="px-3 py-1 bg-blue-600 rounded-full text-white text-xs capitalize font-bold hover:bg-blue-700 transition-all"
      >
        {{ blogTag.name }}
      </Link>
    </div>
  </div>
</template>


