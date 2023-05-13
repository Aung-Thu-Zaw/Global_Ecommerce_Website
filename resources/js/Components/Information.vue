<script setup>
import FromTheSameStore from "@/Components/FromTheSameStore.vue";
import { computed } from "vue";

const props = defineProps({
  specificShopProducts: Object,
  description: String,
});

// decodeHtml: function (html) {
//     console.log(html);
//       var txt = document.createElement("textarea");
//       txt.innerHTML = html;
//       return txt.value;
//     },

// const decodeHtml = (html) => {
//   let text = document.createElement("textarea");
//   text.innerHTML = html;

//   console.log(text);
// };
</script>

<template>
  <section class="bg-gray-100 py-10">
    <div class="container max-w-screen-xl mx-auto px-4">
      <div class="flex flex-wrap -mx-2">
        <div class="lg:w-3/4 px-2">
          <div class="border mb-10">
            <div class="border border-gray-200 shadow-sm rounded bg-white">
              <ul
                class="flex flex-wrap -mb-px text-sm font-medium text-center"
                id="myTab"
                data-tabs-toggle="#myTabContent"
                role="tablist"
              >
                <li class="mr-2" role="presentation">
                  <button
                    class="inline-block p-4 border-b-2 rounded-t-lg"
                    id="profile-tab"
                    data-tabs-target="#profile"
                    type="button"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                  >
                    Description
                  </button>
                </li>
                <li class="mr-2" role="presentation">
                  <button
                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="dashboard-tab"
                    data-tabs-target="#dashboard"
                    type="button"
                    role="tab"
                    aria-controls="dashboard"
                    aria-selected="false"
                  >
                    Delievery & Services
                  </button>
                </li>
                <li class="mr-2" role="presentation">
                  <button
                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="settings-tab"
                    data-tabs-target="#settings"
                    type="button"
                    role="tab"
                    aria-controls="settings"
                    aria-selected="false"
                  >
                    Available Payments
                  </button>
                </li>

                <li role="presentation">
                  <button
                    class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                    id="reviews-tab"
                    data-tabs-target="#reviews"
                    type="button"
                    role="tab"
                    aria-controls="reviews"
                    aria-selected="false"
                  >
                    Product Reviews
                  </button>
                </li>
              </ul>
            </div>
            <div id="myTabContent" class="">
              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 p-5 bg-white"
                id="profile"
                role="tabpanel"
                aria-labelledby="profile-tab"
              >
                <p
                  v-html="description"
                  class="text-sm text-gray-600 font-medium dark:text-gray-400"
                ></p>
              </div>
              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 p-5 bg-white"
                id="dashboard"
                role="tabpanel"
                aria-labelledby="dashboard-tab"
              >
                <p class="text-sm text-gray-500 dark:text-gray-400"></p>
              </div>
              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 p-5 bg-white"
                id="settings"
                role="tabpanel"
                aria-labelledby="settings-tab"
              >
                <p class="text-sm text-gray-500 dark:text-gray-400">Wavepay</p>
              </div>

              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 bg-white"
                id="reviews"
                role="tabpanel"
                aria-labelledby="reviews-tab"
              >
                <div class="text-center mb-5 p-5">
                  <h1 class="font-bold text-slate-600 text-xl my-3">
                    Product Reviews
                  </h1>

                  <div class="flex items-center justify-center">
                    <div class="flex items-center mb-3">
                      <svg
                        aria-hidden="true"
                        class="w-5 h-5 text-yellow-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <title>First star</title>
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        ></path>
                      </svg>
                      <svg
                        aria-hidden="true"
                        class="w-5 h-5 text-yellow-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <title>Second star</title>
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        ></path>
                      </svg>
                      <svg
                        aria-hidden="true"
                        class="w-5 h-5 text-yellow-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <title>Third star</title>
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        ></path>
                      </svg>
                      <svg
                        aria-hidden="true"
                        class="w-5 h-5 text-yellow-400"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <title>Fourth star</title>
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        ></path>
                      </svg>
                      <svg
                        aria-hidden="true"
                        class="w-5 h-5 text-gray-300 dark:text-gray-500"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <title>Fifth star</title>
                        <path
                          d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                        ></path>
                      </svg>
                      <p
                        class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400"
                      >
                        4.95 out of 5
                      </p>
                    </div>
                  </div>

                  <p class="text-sm text-slate-400">
                    Based on 123 users ratings
                  </p>

                  <div class="flex items-center mt-4 justify-center">
                    <span
                      class="text-sm font-medium text-blue-600 dark:text-blue-500"
                      >5 star</span
                    >
                    <div
                      class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700"
                    >
                      <div
                        class="h-5 bg-yellow-400 rounded"
                        style="width: 70%"
                      ></div>
                    </div>
                    <span
                      class="text-sm font-medium text-blue-600 dark:text-blue-500"
                      >70%</span
                    >
                  </div>
                  <div class="flex items-center mt-4 justify-center">
                    <span
                      class="text-sm font-medium text-blue-600 dark:text-blue-500"
                      >4 star</span
                    >
                    <div
                      class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700"
                    >
                      <div
                        class="h-5 bg-yellow-400 rounded"
                        style="width: 17%"
                      ></div>
                    </div>
                    <span
                      class="text-sm font-medium text-blue-600 dark:text-blue-500"
                      >17%</span
                    >
                  </div>
                  <div class="flex items-center mt-4 justify-center">
                    <span
                      class="text-sm font-medium text-blue-600 dark:text-blue-500"
                      >3 star</span
                    >
                    <div
                      class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700"
                    >
                      <div
                        class="h-5 bg-yellow-400 rounded"
                        style="width: 8%"
                      ></div>
                    </div>
                    <span
                      class="text-sm font-medium text-blue-600 dark:text-blue-500"
                      >8%</span
                    >
                  </div>
                  <div class="flex items-center mt-4 justify-center">
                    <span
                      class="text-sm font-medium text-blue-600 dark:text-blue-500"
                      >2 star</span
                    >
                    <div
                      class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700"
                    >
                      <div
                        class="h-5 bg-yellow-400 rounded"
                        style="width: 4%"
                      ></div>
                    </div>
                    <span
                      class="text-sm font-medium text-blue-600 dark:text-blue-500"
                      >4%</span
                    >
                  </div>
                  <div class="flex items-center mt-4 justify-center">
                    <span
                      class="text-sm font-medium text-blue-600 dark:text-blue-500"
                      >1 star</span
                    >
                    <div
                      class="w-2/4 h-5 mx-4 bg-gray-200 rounded dark:bg-gray-700"
                    >
                      <div
                        class="h-5 bg-yellow-400 rounded"
                        style="width: 1%"
                      ></div>
                    </div>
                    <span
                      class="text-sm font-medium text-blue-600 dark:text-blue-500"
                      >1%</span
                    >
                  </div>
                </div>

                <hr />

                <div class="p-5">
                  <h1 class="font-bold text-slate-600 text-xl my-3">
                    Customer Reviews
                  </h1>

                  <!-- Card  -->
                  <div
                    class="shadow border rounded-md p-5 flex items-start my-3"
                  >
                    <div class="flex flex-col items-center justify-center mr-5">
                      <img
                        src="https://imglarger.com/Images/before-after/ai-image-enlarger-1-before-2.jpg"
                        alt=""
                        class="w-12 h-12 object-cover rounded-full mr-5 mb-3"
                      />

                      <div class="flex items-center">
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>First star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Second star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Third star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Fourth star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-gray-300 dark:text-gray-500"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Fifth star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                      </div>
                    </div>

                    <div class="flex flex-col items-end">
                      <div
                        class="flex items-center justify-between w-full mb-1"
                      >
                        <span class="text-green-500 text-sm font-bold">
                          <i class="fa-solid fa-circle-check"></i>
                          Verified Puraches
                        </span>

                        <span class="text-slate-600 text-sm font-bold">
                          04/August/2023
                        </span>
                      </div>
                      <p class="w-full text-sm font-normal text-slate-900">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Incidunt quidem quis harum consequuntur ullam debitis
                        esse nisi eveniet. Repellendus quas modi eum pariatur
                        sunt deleniti doloremque minima excepturi totam, non,
                        minus aperiam ipsa corrupti nostrum, eaque facilis.
                        Optio minima rerum sint maiores sunt, eos repellendus
                        dicta adipisci incidunt nam et eaque provident beatae
                        quos id excepturi aut ex asperiores illum. Fuga non est
                        totam laboriosam? Harum vel dolor cupiditate
                        voluptatibus explicabo praesentium aliquid quo,
                        repudiandae velit, beatae eum laudantium porro possimus
                        corrupti accusantium aut reiciendis fugit! Nobis culpa
                        totam itaque quis necessitatibus placeat, ex nisi in
                        excepturi odio ipsam officiis!
                      </p>
                    </div>
                  </div>
                  <div
                    class="shadow border rounded-md p-5 flex items-start my-3"
                  >
                    <div class="flex flex-col items-center justify-center mr-5">
                      <img
                        src="https://imglarger.com/Images/before-after/ai-image-enlarger-1-before-2.jpg"
                        alt=""
                        class="w-12 h-12 object-cover rounded-full mr-5 mb-3"
                      />

                      <div class="flex items-center">
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>First star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Second star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Third star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Fourth star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-gray-300 dark:text-gray-500"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Fifth star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                      </div>
                    </div>

                    <div class="flex flex-col items-end">
                      <div
                        class="flex items-center justify-between w-full mb-1"
                      >
                        <span class="text-green-500 text-sm font-bold">
                          <i class="fa-solid fa-circle-check"></i>
                          Verified Puraches
                        </span>

                        <span class="text-slate-600 text-sm font-bold">
                          04/August/2023
                        </span>
                      </div>
                      <p class="w-full text-sm font-normal text-slate-900">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Incidunt quidem quis harum consequuntur ullam debitis
                        esse nisi eveniet. Repellendus quas modi eum pariatur
                        sunt deleniti doloremque minima excepturi totam, non,
                        minus aperiam ipsa corrupti nostrum, eaque facilis.
                        Optio minima rerum sint maiores sunt, eos repellendus
                        dicta adipisci incidunt nam et eaque provident beatae
                        quos id excepturi aut ex asperiores illum. Fuga non est
                        totam laboriosam? Harum vel dolor cupiditate
                        voluptatibus explicabo praesentium aliquid quo,
                        repudiandae velit, beatae eum laudantium porro possimus
                        corrupti accusantium aut reiciendis fugit! Nobis culpa
                        totam itaque quis necessitatibus placeat, ex nisi in
                        excepturi odio ipsam officiis!
                      </p>
                    </div>
                  </div>
                  <div
                    class="shadow border rounded-md p-5 flex items-start my-3"
                  >
                    <div class="flex flex-col items-center justify-center mr-5">
                      <img
                        src="https://imglarger.com/Images/before-after/ai-image-enlarger-1-before-2.jpg"
                        alt=""
                        class="w-12 h-12 object-cover rounded-full mr-5 mb-3"
                      />

                      <div class="flex items-center">
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>First star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Second star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Third star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Fourth star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-gray-300 dark:text-gray-500"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Fifth star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                      </div>
                    </div>

                    <div class="flex flex-col items-end">
                      <div
                        class="flex items-center justify-between w-full mb-1"
                      >
                        <span class="text-green-500 text-sm font-bold">
                          <i class="fa-solid fa-circle-check"></i>
                          Verified Puraches
                        </span>

                        <span class="text-slate-600 text-sm font-bold">
                          04/August/2023
                        </span>
                      </div>
                      <p class="w-full text-sm font-normal text-slate-900">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Incidunt quidem quis harum consequuntur ullam debitis
                        esse nisi eveniet. Repellendus quas modi eum pariatur
                        sunt deleniti doloremque minima excepturi totam, non,
                        minus aperiam ipsa corrupti nostrum, eaque facilis.
                        Optio minima rerum sint maiores sunt, eos repellendus
                        dicta adipisci incidunt nam et eaque provident beatae
                        quos id excepturi aut ex asperiores illum. Fuga non est
                        totam laboriosam? Harum vel dolor cupiditate
                        voluptatibus explicabo praesentium aliquid quo,
                        repudiandae velit, beatae eum laudantium porro possimus
                        corrupti accusantium aut reiciendis fugit! Nobis culpa
                        totam itaque quis necessitatibus placeat, ex nisi in
                        excepturi odio ipsam officiis!
                      </p>
                    </div>
                  </div>
                  <div
                    class="shadow border rounded-md p-5 flex items-start my-3"
                  >
                    <div class="flex flex-col items-center justify-center mr-5">
                      <img
                        src="https://imglarger.com/Images/before-after/ai-image-enlarger-1-before-2.jpg"
                        alt=""
                        class="w-12 h-12 object-cover rounded-full mr-5 mb-3"
                      />

                      <div class="flex items-center">
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>First star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Second star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Third star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Fourth star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-gray-300 dark:text-gray-500"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Fifth star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                      </div>
                    </div>

                    <div class="flex flex-col items-end">
                      <div
                        class="flex items-center justify-between w-full mb-1"
                      >
                        <span class="text-green-500 text-sm font-bold">
                          <i class="fa-solid fa-circle-check"></i>
                          Verified Puraches
                        </span>

                        <span class="text-slate-600 text-sm font-bold">
                          04/August/2023
                        </span>
                      </div>
                      <p class="w-full text-sm font-normal text-slate-900">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Incidunt quidem quis harum consequuntur ullam debitis
                        esse nisi eveniet. Repellendus quas modi eum pariatur
                        sunt deleniti doloremque minima excepturi totam, non,
                        minus aperiam ipsa corrupti nostrum, eaque facilis.
                        Optio minima rerum sint maiores sunt, eos repellendus
                        dicta adipisci incidunt nam et eaque provident beatae
                        quos id excepturi aut ex asperiores illum. Fuga non est
                        totam laboriosam? Harum vel dolor cupiditate
                        voluptatibus explicabo praesentium aliquid quo,
                        repudiandae velit, beatae eum laudantium porro possimus
                        corrupti accusantium aut reiciendis fugit! Nobis culpa
                        totam itaque quis necessitatibus placeat, ex nisi in
                        excepturi odio ipsam officiis!
                      </p>
                    </div>
                  </div>
                  <div
                    class="shadow border rounded-md p-5 flex items-start my-3"
                  >
                    <div class="flex flex-col items-center justify-center mr-5">
                      <img
                        src="https://imglarger.com/Images/before-after/ai-image-enlarger-1-before-2.jpg"
                        alt=""
                        class="w-12 h-12 object-cover rounded-full mr-5 mb-3"
                      />

                      <div class="flex items-center">
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>First star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Second star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Third star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Fourth star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-gray-300 dark:text-gray-500"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>Fifth star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                      </div>
                    </div>

                    <div class="flex flex-col items-end">
                      <div
                        class="flex items-center justify-between w-full mb-1"
                      >
                        <span class="text-green-500 text-sm font-bold">
                          <i class="fa-solid fa-circle-check"></i>
                          Verified Puraches
                        </span>

                        <span class="text-slate-600 text-sm font-bold">
                          04/August/2023
                        </span>
                      </div>
                      <p class="w-full text-sm font-normal text-slate-900">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Incidunt quidem quis harum consequuntur ullam debitis
                        esse nisi eveniet. Repellendus quas modi eum pariatur
                        sunt deleniti doloremque minima excepturi totam, non,
                        minus aperiam ipsa corrupti nostrum, eaque facilis.
                        Optio minima rerum sint maiores sunt, eos repellendus
                        dicta adipisci incidunt nam et eaque provident beatae
                        quos id excepturi aut ex asperiores illum. Fuga non est
                        totam laboriosam? Harum vel dolor cupiditate
                        voluptatibus explicabo praesentium aliquid quo,
                        repudiandae velit, beatae eum laudantium porro possimus
                        corrupti accusantium aut reiciendis fugit! Nobis culpa
                        totam itaque quis necessitatibus placeat, ex nisi in
                        excepturi odio ipsam officiis!
                      </p>
                    </div>
                  </div>
                </div>
                <hr />

                <div class="p-5">
                  <h1 class="font-bold text-slate-600 text-xl my-3">
                    Add a Review
                  </h1>

                  <div
                    class="border shadow-md rounded-sm my-5 flex items-center justify-between"
                  >
                    <div
                      class="flex flex-col items-center justify-center space-y-5 border-l border-r w-full py-3"
                    >
                      <span>
                        <svg
                          aria-hidden="true"
                          class="w-5 h-5 text-yellow-400"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <title>First star</title>
                          <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                          ></path>
                        </svg>
                      </span>
                      <span>
                        <input
                          id="red-radio"
                          type="radio"
                          value=""
                          name="colored-radio"
                          class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-400 focus:ring-2"
                        />
                      </span>
                    </div>

                    <div
                      class="flex flex-col items-center justify-center space-y-5 border-l border-r w-full py-3"
                    >
                      <span>
                        <div class="flex items-center">
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>First star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>Second star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                        </div>
                      </span>
                      <span>
                        <input
                          id="red-radio"
                          type="radio"
                          value=""
                          name="colored-radio"
                          class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-400 focus:ring-2"
                        />
                      </span>
                    </div>

                    <div
                      class="flex flex-col items-center justify-center space-y-5 border-l border-r w-full py-3"
                    >
                      <span>
                        <div class="flex items-center">
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>First star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>Second star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>Third star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                        </div>
                      </span>
                      <span>
                        <input
                          id="red-radio"
                          type="radio"
                          value=""
                          name="colored-radio"
                          class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-400 focus:ring-2"
                        />
                      </span>
                    </div>

                    <div
                      class="flex flex-col items-center justify-center space-y-5 border-l border-r w-full py-3"
                    >
                      <span>
                        <div class="flex items-center">
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>First star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>Second star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>Third star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>Fourth star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                        </div>
                      </span>
                      <span>
                        <input
                          id="red-radio"
                          type="radio"
                          value=""
                          name="colored-radio"
                          class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-400 focus:ring-2"
                        />
                      </span>
                    </div>

                    <div
                      class="flex flex-col items-center justify-center space-y-5 border-l border-r w-full py-3"
                    >
                      <span>
                        <div class="flex items-center">
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>First star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>Second star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>Third star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>Fourth star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                          <svg
                            aria-hidden="true"
                            class="w-5 h-5 text-yellow-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <title>Fifth star</title>
                            <path
                              d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            ></path>
                          </svg>
                        </div>
                      </span>
                      <span>
                        <input
                          id="red-radio"
                          type="radio"
                          value=""
                          name="colored-radio"
                          class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-400 focus:ring-2"
                        />
                      </span>
                    </div>
                  </div>

                  <form>
                    <textarea
                      cols="30"
                      rows="10"
                      class="w-full h-[200px] rounded-md border-2 border-slate-400 focus:ring-0 focus:border-slate-400"
                      placeholder="Write Comment"
                    ></textarea>
                    <button
                      class="bg-blue-600 font-bold text-white w-full py-2 rounded-sm hover:bg-blue-700 my-5"
                    >
                      Add Review
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="border border-gray-200 shadow-sm rounded bg-white">
            <h3 class="text-lg font-bold text-slate-700 border-b pb-3 mb-3 p-5">
              Ask Questions About This Product
            </h3>

            <p class="font-bold text-md text-slate-600 px-5 mb-5">
              Total Questions (6)
            </p>

            <!-- Card  -->
            <div class="px-5">
              <div
                class="shadow border rounded-md p-5 flex flex-col items-start my-5"
              >
                <div class="flex items-start">
                  <div class="flex flex-col items-end">
                    <div class="flex items-center justify-between w-full mb-1">
                      <div class="flex items-center">
                        <img
                          src="https://imglarger.com/Images/before-after/ai-image-enlarger-1-before-2.jpg"
                          alt=""
                          class="w-10 h-10 object-cover rounded-full mr-5"
                        />
                        <div>
                          <h4 class="text-lg font-bold text-slate-700">
                            Aung Thu Zaw
                          </h4>
                          <p class="text-[.8rem] text-slate-400">
                            Question From Aung Thu Zaw
                          </p>
                        </div>
                      </div>

                      <span class="text-slate-600 text-sm font-bold">
                        04/August/2023 12:25 PM
                      </span>
                    </div>
                    <p class="w-full text-sm font-normal text-slate-900">
                      Lorem ipsum dolor sit amet consectetur adipisicing elit.
                      Incidunt quidem quis harum consequuntur ullam debitis esse
                      nisi eveniet. Repellendus quas modi eum pariatur sunt
                      deleniti doloremque minima excepturi totam, non, minus
                      aperiam ipsa corrupti nostrum, eaque facilis. Optio minima
                      rerum sint maiores sunt, eos repellendus dicta adipisci
                      incidunt nam et eaque provident beatae quos id excepturi
                      aut ex asperiores illum. Fuga non est totam laboriosam?
                      Harum vel dolor cupiditate voluptatibus explicabo
                      praesentium aliquid quo, repudiandae velit, beatae eum
                      laudantium porro possimus corrupti accusantium aut
                      reiciendis fugit! Nobis culpa totam itaque quis
                      necessitatibus placeat, ex nisi in excepturi odio ipsam
                      officiis!
                    </p>
                  </div>
                </div>

                <!-- Reply  -->

                <div class="w-[95%] ml-auto">
                  <div class="flex items-start justify-between my-3">
                    <div class="flex items-center">
                      <img
                        src="https://imglarger.com/Images/before-after/ai-image-enlarger-1-before-2.jpg"
                        alt=""
                        class="w-10 h-10 object-cover rounded-full mr-5"
                      />
                      <div>
                        <h4 class="text-lg font-bold text-slate-700">
                          Samsung
                          <span
                            class="px-3 py-1 bg-green-200 text-green-600 rounded-xl text-[.7rem] ml-2"
                          >
                            <i class="fa-solid fa-circle-check"></i>
                            Verified
                          </span>
                        </h4>
                        <p class="text-[.8rem] text-slate-400">
                          Answer From Strore
                        </p>
                      </div>
                    </div>
                    <div class="">
                      <span class="text-slate-600 text-sm font-bold">
                        04/August/2023 12:25 PM
                      </span>
                    </div>
                  </div>
                  <p class="w-[92%] text-sm font-normal text-slate-900 ml-auto">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Incidunt quidem quis harum consequuntur ullam debitis esse
                    nisi eveniet. Repellendus quas modi eum pariatur sunt
                    deleniti doloremque minima excepturi totam, non, minus
                    aperiam ipsa corrupti nostrum, eaque facilis. Optio minima
                    rerum sint maiores sunt, eos repellendus dicta adipisci
                    incidunt nam et eaque provident beatae quos id excepturi aut
                    ex asperiores illum. Fuga non est totam laboriosam? Harum
                    vel dolor cupiditate voluptatibus explicabo praesentium
                    aliquid quo, repudiandae velit, beatae eum laudantium porro
                    possimus corrupti accusantium aut reiciendis fugit! Nobis
                    culpa totam itaque quis necessitatibus placeat, ex nisi in
                    excepturi odio ipsam officiis!
                  </p>
                </div>
              </div>
            </div>

            <hr />

            <div class="p-5">
              <form>
                <textarea
                  cols="30"
                  rows="10"
                  class="w-full h-[200px] rounded-md border-2 border-slate-400 focus:ring-0 focus:border-slate-400"
                  placeholder="Write Comment"
                ></textarea>
                <button
                  class="bg-blue-600 font-bold text-white w-full py-2 rounded-sm hover:bg-blue-700 my-5"
                >
                  Ask Question
                </button>
              </form>
            </div>
          </div>
        </div>

        <FromTheSameStore :specificShopProducts="specificShopProducts" />
      </div>
    </div>
  </section>
</template>
