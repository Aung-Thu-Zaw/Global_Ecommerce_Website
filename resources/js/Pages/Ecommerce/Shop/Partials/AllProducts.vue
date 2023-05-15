<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductCard from "@/Components/Cards/ProductCard.vue";
import { onMounted, reactive, ref, watch } from "vue";
import { usePage, router, useForm } from "@inertiajs/vue3";
import EcommerceFilterSidebar from "@/Components/Sidebar/EcommerceFilterSidebar.vue";
import Breadcrumb from "@/Components/Breadcrumbs/Home/Breadcrumb.vue";
import { useReCaptcha } from "vue-recaptcha-v3";
import Pagination from "@/Components/Pagination.vue";
</script>


<template>
  <section class="container mx-auto py-10">
    <div class="container max-w-screen-xl mx-auto">
      <div class="flex flex-col md:flex-row -mx-4">
        <EcommerceFilterSidebar />
        <!-- <main class="md:w-2/3 lg:w-3/4 px-4">
            <div
              class="text-sm font-bold text-slate-600 px-5 py-3 border-t border-b flex items-center justify-between"
            >
              <p>
                {{ products.data.length }} items found for result
                <span class="text-blue-600">"{{ params.search }}"</span>
              </p>

              <div class="w-[250px] flex items-center">
                <span class="mr-2">Sort By</span>
                <select
                  id="countries"
                  class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-[180px] p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-slate-700"
                  v-model="params.direction"
                >
                  <option value="desc" :selected="params.direction == 'desc'">
                    Newest
                  </option>
                  <option value="asc" :selected="params.direction == 'asc'">
                    Oldest
                  </option>

                </select>
              </div>
            </div>
            <div
              v-if="products.data.length"
              class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
            >
              <div
                v-for="product in products.data"
                :key="product.id"
                class="my-3"
              >
                <ProductCard :product="product"></ProductCard>
              </div>
            </div>
            <div v-else>
              <h4 class="font-bold text-slate-600 text-center mt-20 text-xl">
                ☹️ Items Not Found!
              </h4>
              <p class="my-3 font-bold text-slate-500 text-center">
                We're sorry. We cannot find any matches for your search term.
              </p>
            </div>

       Pagination -->
        <!-- <Pagination class="mt-6" :links="products.links" /> -->
        <!-- </main> -->
      </div>
    </div>
  </section>
</template>


