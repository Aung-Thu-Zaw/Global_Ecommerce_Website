<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { reactive } from "vue";

defineProps({
  category: Object,
});

// Query String Parameters
const params = reactive({
  sort: usePage().props.ziggy.query?.sort,
  direction: usePage().props.ziggy.query?.direction,
  view: usePage().props.ziggy.query?.view,
});
</script>

<template>
  <nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
      <li class="inline-flex items-center">
        <Link
          :href="route('home')"
          class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
        >
          <svg
            aria-hidden="true"
            class="w-4 h-4 mr-2"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
            ></path>
          </svg>
          {{ __("HOME") }}
        </Link>
      </li>
      <li v-if="category.parent?.parent?.parent?.parent" aria-current="page">
        <Link
          :href="
            route(
              'category.products',
              category.parent.parent.parent.parent.slug
            )
          "
          :data="{
            sort: params.sort,
            direction: params.direction,
            view: params.view,
          }"
          class="flex items-center"
        >
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
            >{{ category.parent.parent.parent.parent.name }}</span
          >
        </Link>
      </li>
      <li v-if="category.parent?.parent?.parent" aria-current="page">
        <Link
          :href="route('category.products', category.parent.parent.parent.slug)"
          :data="{
            sort: params.sort,
            direction: params.direction,
            view: params.view,
          }"
          class="flex items-center"
        >
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
            >{{ category.parent.parent.parent.name }}</span
          >
        </Link>
      </li>
      <li v-if="category.parent?.parent" aria-current="page">
        <Link
          :href="route('category.products', category.parent.parent.slug)"
          :data="{
            sort: params.sort,
            direction: params.direction,
            view: params.view,
          }"
          class="flex items-center"
        >
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
            >{{ category.parent.parent.name }}</span
          >
        </Link>
      </li>
      <li v-if="category.parent" aria-current="page">
        <Link
          :href="route('category.products', category.parent.slug)"
          :data="{
            sort: params.sort,
            direction: params.direction,
            view: params.view,
          }"
          class="flex items-center"
        >
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
            >{{ category.parent.name }}</span
          >
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
          <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{
            category.name
          }}</span>
        </div>
      </li>
    </ol>
  </nav>
</template>
