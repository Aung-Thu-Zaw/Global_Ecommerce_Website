<script setup>
defineProps({
  sliderBanners: Object,
});
</script>

<template>
  <!--  MAIN SECTION  -->

  <section class="pt-5">
    <div class="container max-w-screen-xl mx-auto px-4">
      <article class="p-4 bg-white border border-gray-200 shadow-sm rounded-md">
        <div class="flex flex-col md:flex-row">
          <aside class="md:w-1/4 mb-4 md:mb-0">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quia
            blanditiis ipsa nulla optio recusandae assumenda, voluptate quo
            culpa laudantium sunt odio minima expedita ratione quaerat est
            doloremque temporibus obcaecati eveniet.
          </aside>
          <main class="md:w-3/4 flex-auto mr-4">
            <div id="default-carousel" class="relative" data-carousel="slide">
              <!-- Carousel wrapper -->
              <div
                class="relative overflow-hidden rounded-lg h-[300px] md:h-[400px] border border-slate-200 shadow-sm"
              >
                <!-- Item -->
                <div
                  v-for="sliderBanner in sliderBanners"
                  :key="sliderBanner.id"
                  class="hidden duration-700 ease-in-out"
                  data-carousel-item
                >
                  <a :href="sliderBanner.url" target="_blank" class="h-full">
                    <img
                      :src="sliderBanner.image"
                      class="absolute block w-[100%] h-[100%] object-cover object-center -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                      alt="..."
                    />
                  </a>
                </div>
              </div>
              <!-- Slider indicators -->
              <div
                class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2"
              >
                <button
                  v-for="sliderBanner in sliderBanners"
                  :key="sliderBanner.id"
                  type="button"
                  class="w-3 h-3 rounded-full"
                  aria-current="false"
                  :aria-label="'Slide ' + sliderBanner.id"
                  data-carousel-slide-to="0"
                ></button>
              </div>
              <!-- Slider controls -->
              <button
                type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev
              >
                <span
                  class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-slate-200 group-hover:bg-slate-300 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none"
                >
                  <svg
                    aria-hidden="true"
                    class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 19l-7-7 7-7"
                    ></path>
                  </svg>
                  <span class="sr-only">Previous</span>
                </span>
              </button>
              <button
                type="button"
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next
              >
                <span
                  class="inline-flex items-center justify-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-slate-200 group-hover:bg-slate-300 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none"
                >
                  <svg
                    aria-hidden="true"
                    class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 5l7 7-7 7"
                    ></path>
                  </svg>
                  <span class="sr-only">Next</span>
                </span>
              </button>
            </div>
          </main>
        </div>
        <!-- grid.// -->
      </article>
    </div>
    <!-- container //end -->
  </section>
  <!--  MAIN SECTION END -->
</template>



