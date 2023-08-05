<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  faqSubCategory: Object,
});
</script>

<template>
  <Link
    :href="route('faqs.index')"
    :data="{
      search_question: $page.props.ziggy.query?.search_question,
      category: faqSubCategory.slug,
    }"
    class="border border-gray-300 cursor-pointer w-[280px] h-[120px] rounded-md hover:shadow-md p-5 flex flex-col items-center justify-center"
  >
    <span
      class="w-10 h-10 text-sm rounded-full flex items-center justify-center shadow-lg bg-blue-600 text-white"
    >
      <i v-html="faqSubCategory.icon"></i>
    </span>
    <span class="text-gray-700 font-bold text-sm mt-3">{{
      faqSubCategory.name
    }}</span>
  </Link>
</template>
