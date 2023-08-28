<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
import FaqCategorySidebar from "@/Components/Sidebars/FaqCategorySidebar.vue";
import Breadcrumb from "@/Components/Breadcrumbs/FaqSectionBreadcrumb.vue";
import FaqSearchFormInput from "@/Components/Forms/FaqSearchFormInput.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  faqCategories: Object,
  faqs: Object,
  faqSubCategory: Object,
});
</script>

<template>
  <AppLayout>
    <Head :title="__('FAQS')" />

    <div class="min-h-[1400px] h-auto bg-gray-50 mt-40 w-full">
      <div class="container mx-auto py-8">
        <h1 class="font-bold text-2xl">{{ __("FREQUENTLY_ASK_QUESTIONS") }}</h1>

        <div class="flex items-start justify-between mt-10">
          <!-- Faq Categories Sidebar -->
          <FaqCategorySidebar :faqCategories="faqCategories" />

          <div class="w-[1000px] ml-5">
            <!-- Question Search Input -->
            <FaqSearchFormInput />

            <p
              v-if="$page.props.ziggy.query?.search_question"
              class="text-sm font-bold my-5 text-gray-700"
            >
              {{ faqs.total }} {{ __("QUESTION_FOUND_FOR_SEARCH_RESULT") }}
              <span class="text-blue-600">
                "{{ $page.props.ziggy.query?.search_question }}"
              </span>
            </p>

            <!-- Result -->
            <div
              class="border border-slate-400 p-6 bg-white w-full rounded-md shadow-md"
            >
              <!-- Faq Breadcrumb Start -->
              <Breadcrumb :faqSubCategory="faqSubCategory">
                <li aria-current="page">
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
                      {{
                        $page.props.ziggy.query.search
                          ? "Search Result(s)"
                          : "All"
                      }}
                    </span>
                  </div>
                </li>
              </Breadcrumb>
              <!-- Faq Breadcrumb End -->

              <div class="w-full">
                <!-- Faq Questions -->
                <ul
                  class="list-disc list-inside space-y-4 text-sm text-gray-700"
                >
                  <li
                    v-for="faq in faqs.data"
                    :key="faq.id"
                    class="hover:text-blue-700 text-sm font-medium text-gray-600"
                  >
                    <Link :href="route('faqs.show', faq.slug)">
                      {{ faq.question }}
                    </Link>
                  </li>
                </ul>

                <!-- Question Not Found -->
                <p
                  v-if="!faqs.data.length"
                  class="my-3 font-bold text-slate-500 text-center"
                >
                  {{
                    __(
                      "WE'RE_SORRY_WE_CANNOT_FIND_ANY_MATCHES_FOR_YOUR_SEARCH_TERM"
                    )
                  }}
                </p>
              </div>

              <!-- Question Pagination -->
              <div class="mt-10 mb-5">
                <Pagination :links="faqs.links" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

