<script setup>
import SliderBanner from "@/Components/Banners/SliderBanner.vue";

defineProps({
  categories: Object,
  sliderBanners: Object,
});
</script>

<template>
  <!--  MAIN SECTION  -->
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
              <div
                class="flex items-center justify-center w-[40px] h-[40px] rounded-full bg-slate-100 mr-2 border-2 overflow-hidden"
              >
                <img :src="category.image" class="h-full object-cover" />
              </div>
              <button
                id="dropdownHoverButton"
                data-dropdown-toggle="dropdownHover"
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
              </button>

              <!-- Dropdown menu -->
              <div
                id="dropdownHover"
                class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-md p-5 md:w-[500px] lg:w-[800px] h-[400px] dark:bg-gray-700"
              >
                vel eaque. Possimus minima cupiditate nemo doloremque incidunt,
                autem assumenda eius. Quod, ipsum culpa. Dicta accusantium vel
                magnam excepturi sit sed vero quisquam, neque corrupti nihil
                impedit omnis repudiandae unde necessitatibus cum reiciendis.
                Molestias mollitia eius obcaecati odio rerum odit dolor, dolorem
                culpa nesciunt perspiciatis esse cupiditate excepturi temporibus
              </div>
            </div>
          </aside>
          <main class="md:w-3/4 flex-auto mr-4">
            <SliderBanner :sliderBanners="sliderBanners" />
          </main>
        </div>
        <!-- grid.// -->
      </article>
    </div>
    <!-- container //end -->
  </section>
  <!--  MAIN SECTION END -->
</template>



