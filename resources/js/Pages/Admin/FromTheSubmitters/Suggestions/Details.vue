<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import Breadcrumb from "@/Components/Breadcrumbs/SuggestionBreadcrumb.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
  paginate: Object,
  suggestion: Object,
});
</script>

<template>
  <AdminDashboardLayout>
    <Head title="Suggestion Details" />

    <div class="px-4 md:px-10 mx-auto w-full py-32">
      <div class="flex items-center justify-between mb-10">
        <!-- Breadcrumb -->
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
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                >{{ suggestion.id }}</span
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
                class="ml-1 font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                >Details</span
              >
            </div>
          </li>
        </Breadcrumb>

        <!-- Go Back Button -->
        <div>
          <Link
            as="button"
            :href="route('admin.suggestions.index')"
            :data="{
              page: props.paginate.page,
              per_page: props.paginate.per_page,
            }"
            class="text-sm px-3 py-2 uppercase font-semibold rounded-md bg-blue-600 text-white hover:bg-blue-500"
          >
            <i class="fa-solid fa-arrow-left"></i>
            Go Back
          </Link>
        </div>
      </div>

      <div class="p-5 border shadow-md rounded-sm my-5">
        <h1 class="font-bold text-slate-700 text-2xl border-b-4 px-10 py-3">
          {{
            suggestion.type === "report_bug"
              ? "Bug Report : "
              : "Request Feature :"
          }}
        </h1>

        <p class="px-10 py-5 text-slate-700">{{ suggestion.description }}</p>

        <div v-if="suggestion.images.length" class="flex items-cener">
          <div v-for="image in suggestion.images" :key="image.id">
            <img :src="image.img_path" alt="" class="h-[200px] mx-3" />
          </div>
        </div>
      </div>
    </div>
  </AdminDashboardLayout>
</template>
