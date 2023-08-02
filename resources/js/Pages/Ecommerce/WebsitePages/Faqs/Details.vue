<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Paginations/Pagination.vue";
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
          <div
            class="border w-[260px] overflow-hidden shadow-lg border-slate-400 rounded-md h-auto"
          >
            <h3
              class="py-3 bg-blue-700 text-white text-md font-bold text-center"
            >
              <i class="fa-solid fa-list mr-3"></i>
              Categories
            </h3>

            <div class="">
              <button
                data-drawer-target="sidebar-multi-level-sidebar"
                data-drawer-toggle="sidebar-multi-level-sidebar"
                aria-controls="sidebar-multi-level-sidebar"
                type="button"
                class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600"
              >
                <span class="sr-only">Open sidebar</span>
                <svg
                  class="w-6 h-6"
                  aria-hidden="true"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    clip-rule="evenodd"
                    fill-rule="evenodd"
                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
                  ></path>
                </svg>
              </button>

              <aside
                id="sidebar-multi-level-sidebar"
                class="z-40 w-64 transition-transform -translate-x-full sm:translate-x-0"
                aria-label="Sidebar"
              >
                <div class="w-full overflow-y-auto bg-gray-50">
                  <ul class="text-sm font-medium">
                    <li
                      v-for="faqCategory in faqCategories"
                      :key="faqCategory.id"
                      class="w-full border-b border-b-slate-300"
                    >
                      <button
                        type="button"
                        class="flex items-center w-full p-3 text-base text-gray-900 transition duration-75 group hover:bg-gray-200"
                        :aria-controls="'dropdown-example' + faqCategory.id"
                        :data-collapse-toggle="
                          'dropdown-example' + faqCategory.id
                        "
                      >
                        <span
                          class="flex-1 ml-3 text-left text-sm whitespace-nowrap"
                        >
                          {{ faqCategory.name }}
                        </span>
                        <svg
                          class="w-3 h-3"
                          aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 10 6"
                        >
                          <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 1 4 4 4-4"
                          />
                        </svg>
                      </button>
                      <ul
                        :id="'dropdown-example' + faqCategory.id"
                        class="hidden py-2"
                      >
                        <li
                          v-for="faqSubCategory in faqCategory.faq_sub_categories"
                          :key="faqSubCategory.id"
                        >
                          <a
                            href="#"
                            class="flex items-center w-full py-2 text-sm pl-10 text-gray-900 transition duration-75 group hover:bg-gray-200"
                            >{{ faqSubCategory.name }}</a
                          >
                        </li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </aside>
            </div>
          </div>

          <div class="w-[1000px] ml-5">
            <!-- Question Search Input -->
            <div class="flex flex-col items-start mb-6">
              <div>
                <form class="w-[700px] h-[50px]">
                  <div class="flex items-center justify-between">
                    <input
                      type="text"
                      class="w-[650px] h-full py-3 rounded-md borde-2 border-slate-400 focus:ring-0 focus:border-slate-400"
                      autofocus
                      placeholder="Search for a question..."
                    />
                    <button
                      class="bg-blue-600 text-white px-6 py-3 h-full rounded-md hover:bg-blue-700 ml-2"
                    >
                      <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                  </div>
                </form>
              </div>
            </div>

            <!-- Result -->
            <div
              class="border border-slate-400 p-6 bg-white w-full rounded-md shadow-md"
            >
              <!-- Breadcrumb -->
              <div class="mb-5 border-b pb-5">
                <nav class="flex" aria-label="Breadcrumb">
                  <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                      <a
                        href="#"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
                      >
                        <i class="fa-solid fa-list mr-3 text-dark"></i>

                        Categories
                      </a>
                    </li>
                    <li v-if="faq.faq_sub_category.faq_category">
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
                        <a
                          href="#"
                          class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"
                          >{{ faq.faq_sub_category.faq_category.name }}</a
                        >
                      </div>
                    </li>
                    <li v-if="faq.faq_sub_category">
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
                        <a
                          href="#"
                          class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"
                          >{{ faq.faq_sub_category.name }}</a
                        >
                      </div>
                    </li>
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
                          >{{ faq.question }}</span
                        >
                      </div>
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="w-full mb-14">
                <h1 class="font-bold text-md text-gray-700 mb-5">
                  {{ faq.question }}
                </h1>

                <p v-html="faq.answer" class="text-[.9rem] text-gray-600"></p>

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
                      {{ faq.question }}
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

