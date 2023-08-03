<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  faqCategories: Object,
});
</script>

<template>
  <div
    class="border w-[260px] overflow-hidden shadow-lg border-slate-400 rounded-md h-auto"
  >
    <h3 class="py-3 bg-blue-700 text-white text-md font-bold text-center">
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
                :data-collapse-toggle="'dropdown-example' + faqCategory.id"
              >
                <span class="flex-1 ml-3 text-left text-sm whitespace-nowrap">
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
              <ul :id="'dropdown-example' + faqCategory.id" class="hidden py-2">
                <li
                  v-for="faqSubCategory in faqCategory.faq_sub_categories"
                  :key="faqSubCategory.id"
                >
                  <Link
                    :href="route('faqs.index')"
                    :data="{
                      search_question: $page.props.ziggy.query.search_question,
                      category: faqSubCategory.slug,
                    }"
                    class="flex items-center w-full py-2 text-sm pl-10 transition duration-75 group hover:bg-gray-200 hover:text-gray-900"
                    :class="{
                      'text-blue-700':
                        $page.props.ziggy.query.category ===
                        faqSubCategory.slug,

                      'text-gray-800':
                        $page.props.ziggy.query.category !==
                        faqSubCategory.slug,
                    }"
                    >{{ faqSubCategory.name }}
                  </Link>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </aside>
    </div>
  </div>
</template>

