<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/Cards/ProductCard.vue";
import { ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import EcommerceFilterSidebar from "@/Components/Sidebar/EcommerceFilterSidebar.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Home/Breadcrumb.vue";
</script>


<template>
  <AppLayout>
    <section class="container mt-40 mx-auto py-10">
      <div class="mb-5 px-4">
        <div class="border-b py-3">
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
                  >Search Result</span
                >
              </div>
            </li>
          </Breadcrumb>
        </div>
      </div>
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-col md:flex-row -mx-4">
          <EcommerceFilterSidebar />
          <main class="md:w-2/3 lg:w-3/4 px-4">
            <div
              class="text-sm font-bold text-slate-600 px-5 py-3 border-t border-b flex items-center justify-between"
            >
              <p>30 items found for "toy for kids"</p>

              <div class="w-[250px] flex items-center">
                <span class="mr-2">Sort By</span>
                <select
                  id="countries"
                  class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[180px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-slate-700"
                >
                  <option value="newest" selected>Newest</option>
                  <option value="oldest">Oldest</option>
                  <option value="low_to_high">Price low to high</option>
                  <option value="high_to_low">Price high to low</option>
                </select>
              </div>
            </div>
            <div
              class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
            >
              <div
                v-for="product in products"
                :key="product.id"
                data-aos="zoom-in"
              >
                <ProductCard :product="product"></ProductCard>
              </div>
            </div>
          </main>
        </div>
      </div>
    </section>
  </AppLayout>
</template>


