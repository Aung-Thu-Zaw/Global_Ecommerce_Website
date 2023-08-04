<script setup>
import SliderBanner from "@/Components/Banners/SliderBanner.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { reactive } from "vue";

defineProps({
  categories: Object,
  sliderBanners: Object,
});

// Query String Parameters
const params = reactive({
  sort: "id",
  direction: "desc",
  view: usePage().props.ziggy.query.view
    ? usePage().props.ziggy.query.view
    : "grid",
});
</script>

<template>
  <section class="pt-5">
    <div class="container max-w-screen-xl mx-auto px-4">
      <article class="p-4 bg-white border border-gray-200 shadow-sm rounded-md">
        <div class="flex flex-col md:flex-row">
          <aside class="md:w-1/4 flex-auto mb-4 pr-4 md:mb-0">
            <div
              v-for="category in categories"
              :key="category.id"
              class="flex items-center hover:bg-blue-50 rounded-sm mb-3"
            >
              <!-- First Category -->
              <div
                class="flex items-center justify-center w-[40px] h-[40px] rounded-full bg-slate-100 mr-2 ring-2 ring-gray-400 shadow overflow-hidden"
              >
                <img :src="category.image" class="h-full object-cover" />
              </div>
              <Link
                :href="route('category.products', category.slug)"
                :data="{
                  sort: params.sort,
                  direction: params.direction,
                  view: params.view,
                }"
                id="dropdownHoverButton"
                :data-dropdown-toggle="'dropdownHover' + category.id"
                data-dropdown-trigger="hover"
                data-dropdown-placement="right-end"
                class="w-[80%] md:mb-0 font-medium text-sm text-center inline-flex items-center py-2 hover:text-blue-600"
                type="button"
              >
                {{ category.name }}
                <svg
                  class="w-4 h-4 ml-auto"
                  aria-hidden="true"
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
              </Link>

              <!-- Second Category -->
              <div
                :id="'dropdownHover' + category.id"
                class="z-50 hidden border-2 border-gray-300 bg-white divide-y divide-gray-100 rounded-lg shadow-md p-5 md:w-[500px] lg:w-[920px] h-[400px] scrollbar overflow-auto"
              >
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                  <div
                    v-for="secondChildCategory in category.children"
                    :key="secondChildCategory.id"
                    class="p-3 mb-3"
                  >
                    <div class="flex items-center">
                      <div
                        class="flex items-center justify-center w-[40px] h-[40px] rounded-full bg-slate-100 mr-2 ring-2 ring-gray-400 shadow overflow-hidden"
                      >
                        <img
                          :src="secondChildCategory.image"
                          class="h-full object-cover"
                        />
                      </div>
                      <Link
                        :href="
                          route('category.products', secondChildCategory.slug)
                        "
                        :data="{
                          sort: params.sort,
                          direction: params.direction,
                          view: params.view,
                        }"
                        class="font-bold text-slate-700 hover:text-blue-500 hover:underline cursor-pointer"
                      >
                        {{ secondChildCategory.name }}
                      </Link>
                    </div>

                    <ul>
                      <li
                        v-for="thirdChildCategory in secondChildCategory.children"
                        :key="thirdChildCategory"
                        class=""
                      >
                        <i
                          class="fa-solid fa-circle text-[.4rem] text-slate-600 mx-2"
                        ></i>
                        <Link
                          :href="
                            route('category.products', thirdChildCategory.slug)
                          "
                          :data="{
                            sort: params.sort,
                            direction: params.direction,
                            view: params.view,
                          }"
                          class="text-[.8rem] font-bold text-slate-500 hover:text-blue-500 hover:underline cursor-pointer"
                        >
                          {{ thirdChildCategory.name }}
                        </Link>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </aside>

          <!-- Slider Banner -->
          <main v-if="sliderBanners.length" class="md:w-3/4 flex-auto">
            <SliderBanner :sliderBanners="sliderBanners" />
          </main>
        </div>
      </article>
    </div>
  </section>
</template>



