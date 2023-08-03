<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FaqCategorySidebar from "@/Components/Sidebars/FaqCategorySidebar.vue";
import Breadcrumb from "@/Components/Breadcrumbs/FaqSectionBreadcrumb.vue";
import FaqSearchFormInput from "@/Components/Forms/FaqSearchFormInput.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  faqCategories: Object,
  faq: Object,
  relatedFaqs: Object,
});
</script>

<template>
  <AppLayout>
    <Head :title="faq.question" />

    <div class="min-h-[1400px] h-auto bg-gray-50 mt-40 w-full">
      <div class="container mx-auto py-8">
        <h1 class="font-bold text-2xl">Frequently Ask Questions?</h1>

        <div class="flex items-start justify-between mt-10">
          <!-- Categories Sidebar -->
          <FaqCategorySidebar :faqCategories="faqCategories" />

          <div class="w-[1000px] ml-5">
            <!-- Question Search Input -->
            <FaqSearchFormInput />

            <!-- Result -->
            <div
              class="border border-slate-400 p-6 bg-white w-full rounded-md shadow-md"
            >
              <!-- Breadcrumb -->
              <Breadcrumb :faqSubCategory="faq.faq_sub_category">
                <li aria-current="page">
                  <div class="flex items-center max-w-[500px]">
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
                      class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400 line-clamp-1"
                      >{{ faq.question }}</span
                    >
                  </div>
                </li>
              </Breadcrumb>

              <!-- Questions And Answers -->
              <div class="w-full mb-14">
                <h1 class="font-bold text-md text-gray-700 mb-5">
                  {{ faq.question }}
                </h1>

                <p v-html="faq.answer" class="text-[.9rem] text-gray-600"></p>

                <!-- Helpful Or Unhelpful Buttons -->
                <div
                  class="my-5 text-sm text-gray-700 font-semibold text-center"
                >
                  <p class="mb-5">Is this helpful for you?</p>

                  <div class="space-x-5">
                    <button
                      class="px-5 py-2 group rounded-sm shadow-sm text-gray-600 text-sm border border-blue-600 hover:bg-blue-600 hover:text-white transition-all"
                    >
                      <i
                        class="fa-solid fa-thumbs-up text-blue-600 group-hover:text-white"
                      ></i>
                      Yes
                    </button>
                    <button
                      class="px-5 py-2 group rounded-sm shadow-sm text-gray-600 text-sm border border-orange-600 hover:bg-orange-600 hover:text-white transition-all"
                    >
                      <i
                        class="fa-solid fa-thumbs-down text-orange-600 group-hover:text-white"
                      ></i>
                      No
                    </button>
                  </div>
                </div>
              </div>

              <!-- Related Questions -->
              <div class="p-6">
                <h3 class="font-bold text-gray-700 text-md mb-3">
                  Related Questions :
                </h3>

                <ul class="list-disc space-y-3">
                  <li
                    v-for="relatedFaq in relatedFaqs"
                    :key="relatedFaq.id"
                    class="hover:text-blue-700 hover:underline text-[.8rem] font-medium text-blue-600"
                  >
                    <Link :href="route('faqs.show', relatedFaq.slug)">
                      {{ relatedFaq.question }}
                    </Link>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

