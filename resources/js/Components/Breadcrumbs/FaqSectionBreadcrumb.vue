<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  faqSubCategory: Object,
});
</script>

<template>
  <div class="mb-5 border-b pb-5">
    <nav class="flex" aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
          <Link
            :href="route('faqs.index')"
            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
          >
            <i class="fa-solid fa-list mr-3 text-dark"></i>

            {{ __("CATEGORIES") }}
          </Link>
        </li>
        <li v-if="faqSubCategory?.faq_category">
          <div class="flex items-center">
            <svg
              class="w-3 h-3 text-gray-400 mx-1"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 6 10"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 9 4-4-4-4"
              />
            </svg>
            <span
              class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"
            >
              {{ faqSubCategory?.faq_category?.name }}
            </span>
          </div>
        </li>
        <li v-if="faqSubCategory" aria-current="page">
          <div class="flex items-center">
            <svg
              class="w-3 h-3 text-gray-400 mx-1"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 6 10"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m1 9 4-4-4-4"
              />
            </svg>
            <span
              class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"
              >{{ faqSubCategory?.name }}</span
            >
          </div>
        </li>
        <slot />
      </ol>
    </nav>
  </div>
</template>


