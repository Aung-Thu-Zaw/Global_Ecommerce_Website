<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { usePage, Head, Link } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumbs/HomeBreadcrumb.vue";
import BlogCard from "@/Components/Cards/BlogCard.vue";

defineProps({});

if (usePage().props.flash.successMessage) {
  toast.success(usePage().props.flash.successMessage, {
    autoClose: 2000,
  });
}
</script>

<template>
  <AppLayout>
    <Head title="Blogs" />

    <div class="min-h-screen bg-gray-50 mt-40 w-full py-6">
      <div class="w-[1500px] mx-auto">
        <div class="border-b py-3 mb-5">
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
                  class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400"
                  >Blogs</span
                >
              </div>
            </li>
          </Breadcrumb>
        </div>

        <div class="flex items-start space-x-3">
          <div class="w-[300px]">
            <ul
              class="h-auto space-y-3 text-center text-md font-bold text-slate-700"
            >
              <li
                class="py-3 rounded-sm bg-gray-100 hover:bg-gray-200 transition-all border border-slate-300 shadow hover:animate-bounce"
              >
                <Link href="#">
                  Beauty And Fashion
                  <span
                    class="text-[.8rem] px-2 ml-3 py-1 rounded-full border-2 border-slate-400"
                  >
                    3
                  </span>
                </Link>
              </li>
              <li
                class="py-3 rounded-sm bg-gray-100 hover:bg-gray-200 transition-all border border-slate-300 shadow hover:animate-bounce"
              >
                <Link href="#">
                  Beauty And Fashion
                  <span
                    class="text-[.8rem] px-2 ml-3 py-1 rounded-full border-2 border-slate-400"
                  >
                    3
                  </span>
                </Link>
              </li>
              <li
                class="py-3 rounded-sm bg-gray-100 hover:bg-gray-200 transition-all border border-slate-300 shadow hover:animate-bounce"
              >
                <Link href="#">
                  Beauty And Fashion
                  <span
                    class="text-[.8rem] px-2 ml-3 py-1 rounded-full border-2 border-slate-400"
                  >
                    3
                  </span>
                </Link>
              </li>
              <li
                class="py-3 rounded-sm bg-gray-100 hover:bg-gray-200 transition-all border border-slate-300 shadow hover:animate-bounce"
              >
                <Link href="#">
                  Beauty And Fashion
                  <span
                    class="text-[.8rem] px-2 ml-3 py-1 rounded-full border-2 border-slate-400"
                  >
                    3
                  </span>
                </Link>
              </li>
              <li
                class="py-3 rounded-sm bg-gray-100 hover:bg-gray-200 transition-all border border-slate-300 shadow hover:animate-bounce"
              >
                <Link href="#">
                  Beauty And Fashion
                  <span
                    class="text-[.8rem] px-2 ml-3 py-1 rounded-full border-2 border-slate-400"
                  >
                    3
                  </span>
                </Link>
              </li>
              <li
                class="py-3 rounded-sm bg-gray-100 hover:bg-gray-200 transition-all border border-slate-300 shadow hover:animate-bounce"
              >
                <Link href="#">
                  Beauty And Fashion
                  <span
                    class="text-[.8rem] px-2 ml-3 py-1 rounded-full border-2 border-slate-400"
                  >
                    3
                  </span>
                </Link>
              </li>
              <li
                class="py-3 rounded-sm bg-gray-100 hover:bg-gray-200 transition-all border border-slate-300 shadow hover:animate-bounce"
              >
                <Link href="#">
                  Beauty And Fashion
                  <span
                    class="text-[.8rem] px-2 ml-3 py-1 rounded-full border-2 border-slate-400"
                  >
                    3
                  </span>
                </Link>
              </li>
            </ul>
          </div>
          <div class="w-full">
            <div class="grid grid-cols-4 gap-5">
              <BlogCard />
              <BlogCard />
              <BlogCard />
              <BlogCard />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

