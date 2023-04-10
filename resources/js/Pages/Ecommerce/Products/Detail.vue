<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
defineProps({
  product: Object,
  images: Object,
});
</script>


<template>
  <AppLayout>
    <section class="py-4 mt-3">
      <div class="container max-w-screen-xl mx-auto px-4">
        <!-- breadcrumbs start -->

        <nav class="flex" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
              <a
                href="#"
                class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
              >
                <svg
                  aria-hidden="true"
                  class="w-4 h-4 mr-2"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                  ></path>
                </svg>
                Home
              </a>
            </li>
            <li>
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
                <a
                  href="#"
                  class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white"
                  >Projects</a
                >
              </div>
            </li>
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
                  >Flowbite</span
                >
              </div>
            </li>
          </ol>
        </nav>

        <!-- breadcrumbs end -->
      </div>
      <!-- container .// -->
    </section>

    <section class="bg-white py-3">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
          <aside>
            <!-- gallery -->
            <div
              class="border border-gray-200 shadow-sm p-3 text-center rounded mb-5"
            >
              <img
                class="object-cover inline-block"
                width="400"
                :src="product.image"
                :alt="product.name"
              />
            </div>
            <div class="space-x-2 overflow-auto text-center whitespace-nowrap">
              <a
                v-for="image in images"
                :key="image.id"
                href="#"
                class="inline-block border border-gray-200 p-1 rounded-md hover:border-blue-500"
              >
                <img
                  class="w-14 h-14"
                  :src="image.img_path"
                  :alt="product.name"
                />
              </a>
            </div>
            <!-- gallery end.// -->
          </aside>
          <main>
            <h2 class="font-semibold text-2xl mb-4">
              {{ product.name }}
            </h2>

            <div class="flex items-center">
              <svg
                aria-hidden="true"
                class="w-5 h-5 text-yellow-400"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <title>Rating star</title>
                <path
                  d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                ></path>
              </svg>
              <p class="ml-2 text-sm font-bold text-gray-900 dark:text-white">
                4.95
              </p>
              <span
                class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full dark:bg-gray-400"
              ></span>
              <a
                href="#"
                class="text-sm font-medium text-gray-900 underline hover:no-underline dark:text-white"
                >73 reviews</a
              >
            </div>

            <div v-if="product.qty != 0" class="my-3">
              <span class="text-secondary-700 font-semibold text-sm mr-3"
                >Total {{ product.qty }} Available</span
              >
              <span
                class="text-green-500 font-bold text-sm bg-green-200 px-2 py-1 rounded-full"
                >Active</span
              >
            </div>
            <div v-else class="my-3">
              <span class="text-secondary-700 font-semibold text-sm mr-3"
                >0 Available</span
              >

              <span
                class="text-red-500 font-bold text-sm bg-red-200 px-2 py-1 rounded-full"
                >Sold Out</span
              >
            </div>

            <span class="text-gray-400 text-sm font-semibold">
              <i class="fa fa-award"></i>
              Brand : No Brand
            </span>

            <div class="my-3">
              <p class="font-semibold text-xl mb-1">$98.00</p>
              <p class="font-normal text-sm mb-3">
                <span class="text-secondary-600 line-through mr-3"
                  >$98.00
                </span>
                <span
                  class="bg-green-200 text-green-500 py-[.2rem] px-2 rounded-full"
                >
                  - 24 %</span
                >
              </p>
            </div>

            <!-- Choose Sizes  -->

            <div class="my-5 flex items-center">
              <span class="text-secondary-800 mr-5"> Sizes </span>
              <div class="flex items-center">
                <div class="flex items-center mr-3">
                  <input
                    type="checkbox"
                    id="size-option1"
                    value=""
                    class="hidden peer"
                  />
                  <label
                    for="size-option1"
                    class="px-3 py-1 text-secondary-800 shadow-md bg-white border-2 border-gray-200 rounded-sm cursor-pointer peer-checked:border-gray-400 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div class="rounded-sm uppercase font-bold text-sm">sm</div>
                  </label>
                </div>
              </div>
              <div class="flex items-center">
                <div class="flex items-center mr-3">
                  <input
                    type="checkbox"
                    id="size-option2"
                    value=""
                    class="hidden peer"
                  />
                  <label
                    for="size-option2"
                    class="px-3 py-1 text-secondary-800 shadow-md bg-white border-2 border-gray-200 rounded-sm cursor-pointer peer-checked:border-gray-400 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div class="rounded-sm uppercase font-bold text-sm">md</div>
                  </label>
                </div>
              </div>
              <div class="flex items-center">
                <div class="flex items-center mr-3">
                  <input
                    type="checkbox"
                    id="size-option3"
                    value=""
                    class="hidden peer"
                  />
                  <label
                    for="size-option3"
                    class="px-3 py-1 text-secondary-800 shadow-md bg-white border-2 border-gray-200 rounded-sm cursor-pointer peer-checked:border-gray-400 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div class="rounded-sm uppercase font-bold text-sm">lg</div>
                  </label>
                </div>
              </div>
              <div class="flex items-center">
                <div class="flex items-center mr-3">
                  <input
                    type="checkbox"
                    id="size-option4"
                    value=""
                    class="hidden peer"
                  />
                  <label
                    for="size-option4"
                    class="px-3 py-1 text-secondary-800 shadow-md bg-white border-2 border-gray-200 rounded-sm cursor-pointer peer-checked:border-gray-400 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div class="rounded-sm uppercase font-bold text-sm">xl</div>
                  </label>
                </div>
              </div>
              <div class="flex items-center">
                <div class="flex items-center mr-3">
                  <input
                    type="checkbox"
                    id="size-option5"
                    value=""
                    class="hidden peer"
                  />
                  <label
                    for="size-option5"
                    class="px-3 py-1 text-secondary-800 shadow-md bg-white border-2 border-gray-200 rounded-sm cursor-pointer peer-checked:border-gray-400 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div class="rounded-sm uppercase font-bold text-sm">
                      2xl
                    </div>
                  </label>
                </div>
              </div>
            </div>

            <!-- Choose Color  -->

            <div class="my-5 flex items-center">
              <span class="text-secondary-800 mr-5"> Colors </span>
              <div class="flex items-center">
                <div class="flex items-center mr-3">
                  <input
                    type="checkbox"
                    id="color-option1"
                    value=""
                    class="hidden peer"
                  />
                  <label
                    for="color-option1"
                    class="w-7 h-7 text-gray-500 bg-white border-4 border-gray-100 shadow-md rounded-sm cursor-pointer peer-checked:border-slate-300 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div class="w-full h-full bg-blue-600 rounded-sm"></div>
                  </label>
                </div>
                <div class="flex items-center mr-3">
                  <input
                    type="checkbox"
                    id="color-option2"
                    value=""
                    class="hidden peer"
                  />
                  <label
                    for="color-option2"
                    class="w-7 h-7 text-gray-500 bg-white border-4 border-gray-100 shadow-md rounded-sm cursor-pointer peer-checked:border-slate-300 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div class="w-full h-full bg-orange-600 rounded-sm"></div>
                  </label>
                </div>
                <div class="flex items-center mr-3">
                  <input
                    type="checkbox"
                    id="color-option3"
                    value=""
                    class="hidden peer"
                  />
                  <label
                    for="color-option3"
                    class="w-7 h-7 text-gray-500 bg-white border-4 border-gray-100 shadow-md rounded-sm cursor-pointer peer-checked:border-slate-300 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div class="w-full h-full bg-pink-600 rounded-sm"></div>
                  </label>
                </div>
                <div class="flex items-center mr-3">
                  <input
                    type="checkbox"
                    id="color-option4"
                    value=""
                    class="hidden peer"
                  />
                  <label
                    for="color-option4"
                    class="w-7 h-7 text-gray-500 bg-white border-4 border-gray-100 shadow-md rounded-sm cursor-pointer peer-checked:border-slate-300 hover:text-gray-600 peer-checked:text-gray-600 hover:bg-gray-50"
                  >
                    <div class="w-full h-full bg-green-600 rounded-sm"></div>
                  </label>
                </div>
              </div>
            </div>

            <div class="my-5">
              <span class="text-secondary-800 mr-5"> Quantity </span>
              <span
                class="px-3 py-2 bg-slate-500 hover:bg-slate-600 rounded-sm"
              >
                <i class="fa-solid fa-plus text-white"></i>
              </span>

              <input
                type="number"
                class="border-2 text-center border-slate-500 outline-none focus:outline-none focus:ring-0 w-[100px] h-full mx-1 rounded-sm"
              />
              <span
                class="px-3 py-2 bg-slate-500 hover:bg-slate-600 mr-2 rounded-sm"
              >
                <i class="fa-solid fa-minus text-white"></i>
              </span>
            </div>

            <!-- action buttons -->
            <div class="flex flex-wrap gap-2 mb-10">
              <a
                class="px-4 py-2 inline-block text-white bg-yellow-500 border border-transparent rounded-md hover:bg-yellow-600"
                href="#"
              >
                Buy now
              </a>
              <a
                class="px-4 py-2 inline-block text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700"
                href="#"
              >
                <i class="fa fa-shopping-cart mr-2"></i>
                Add to cart
              </a>
              <a
                class="px-4 py-2 inline-block text-blue-600 border border-gray-300 rounded-md hover:bg-gray-100"
                href="#"
              >
                <i class="fa fa-heart mr-2"></i>
                Save to whilist
              </a>
            </div>
            <!-- action buttons .//end -->
          </main>
        </div>
        <!-- grid .// -->
      </div>
      <!-- container .// -->
    </section>

    <section class="bg-gray-100 py-10">
      <div class="container max-w-screen-xl mx-auto px-4">
        <div class="flex flex-wrap -mx-2">
          <div class="lg:w-3/4 px-2">
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
                    id="contacts-tab"
                    data-tabs-target="#contacts"
                    type="button"
                    role="tab"
                    aria-controls="contacts"
                    aria-selected="false"
                  >
                    Shop Profile
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
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  This is some placeholder content the
                  <strong class="font-medium text-gray-800 dark:text-white"
                    >Profile tab's associated content</strong
                  >. Clicking another tab will toggle the visibility of this one
                  for the next. The tab JavaScript swaps classes to control the
                  content visibility and styling.
                </p>
              </div>
              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 p-5 bg-white"
                id="dashboard"
                role="tabpanel"
                aria-labelledby="dashboard-tab"
              >
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  This is some placeholder content the
                  <strong class="font-medium text-gray-800 dark:text-white"
                    >Dashboard tab's associated content</strong
                  >. Clicking another tab will toggle the visibility of this one
                  for the next. The tab JavaScript swaps classes to control the
                  content visibility and styling.
                </p>
              </div>
              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 p-5 bg-white"
                id="settings"
                role="tabpanel"
                aria-labelledby="settings-tab"
              >
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  This is some placeholder content the
                  <strong class="font-medium text-gray-800 dark:text-white"
                    >Settings tab's associated content</strong
                  >. Clicking another tab will toggle the visibility of this one
                  for the next. The tab JavaScript swaps classes to control the
                  content visibility and styling.
                </p>
              </div>
              <div
                class="hidden border border-gray-200 shadow-sm border-t-0 p-5 bg-white"
                id="contacts"
                role="tabpanel"
                aria-labelledby="contacts-tab"
              >
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  This is some placeholder content the
                  <strong class="font-medium text-gray-800 dark:text-white"
                    >Contacts tab's associated content</strong
                  >. Clicking another tab will toggle the visibility of this one
                  for the next. The tab JavaScript swaps classes to control the
                  content visibility and styling.
                </p>
              </div>
            </div>
          </div>
          <!-- col.// -->
          <aside class="lg:w-1/4 px-2">
            <article
              class="border border-gray-200 shadow-sm rounded bg-white p-4"
            >
              <h3 class="mb-5 text-lg font-semibold capitalize">
                from the same store
              </h3>

              <figure class="flex flex-row mb-4">
                <div>
                  <a
                    href="#"
                    class="block w-20 h-20 rounded border border-gray-200 overflow-hidden"
                  >
                    <img
                      src="https://cdn.shopify.com/s/files/1/2303/2711/files/2_e822dae0-14df-4cb8-b145-ea4dc0966b34.jpg?v=1617059123"
                      class="h-full object-cover"
                      alt="Title"
                    />
                  </a>
                </div>
                <figcaption class="ml-3">
                  <p>
                    <a href="#" class="text-gray-600 hover:text-blue-600"
                      >Travel Bag Jeans Blue Color Modern</a
                    >
                  </p>
                  <p class="mt-1 font-semibold">$712.00</p>
                </figcaption>
              </figure>

              <figure class="flex flex-row mb-4">
                <div>
                  <a
                    href="#"
                    class="block w-20 h-20 rounded border border-gray-200 overflow-hidden"
                  >
                    <img
                      src="https://cdn.shopify.com/s/files/1/2303/2711/files/2_e822dae0-14df-4cb8-b145-ea4dc0966b34.jpg?v=1617059123"
                      class="h-full object-cover"
                      alt="Title"
                    />
                  </a>
                </div>
                <figcaption class="ml-3">
                  <p>
                    <a href="#" class="text-gray-600 hover:text-blue-600"
                      >Travel Bag Jeans Blue Color Modern</a
                    >
                  </p>
                  <p class="mt-1 font-semibold">$712.00</p>
                </figcaption>
              </figure>

              <figure class="flex flex-row mb-4">
                <div>
                  <a
                    href="#"
                    class="block w-20 h-20 rounded border border-gray-200 overflow-hidden"
                  >
                    <img
                      src="https://cdn.shopify.com/s/files/1/2303/2711/files/2_e822dae0-14df-4cb8-b145-ea4dc0966b34.jpg?v=1617059123"
                      class="h-full object-cover"
                      alt="Title"
                    />
                  </a>
                </div>
                <figcaption class="ml-3">
                  <p>
                    <a href="#" class="text-gray-600 hover:text-blue-600"
                      >Apple Watch Series 4 - Space Gray</a
                    >
                  </p>
                  <p class="mt-1 font-semibold">$12.99</p>
                </figcaption>
              </figure>

              <figure class="flex flex-row mb-4">
                <div>
                  <a
                    href="#"
                    class="block w-20 h-20 rounded border border-gray-200 overflow-hidden"
                  >
                    <img
                      src="https://cdn.shopify.com/s/files/1/2303/2711/files/2_e822dae0-14df-4cb8-b145-ea4dc0966b34.jpg?v=1617059123"
                      class="h-full object-cover"
                      alt="Title"
                    />
                  </a>
                </div>
                <figcaption class="ml-3">
                  <p>
                    <a href="#" class="text-gray-600 hover:text-blue-600"
                      >Apple Watch Series 4 - Space Gray</a
                    >
                  </p>
                  <p class="mt-1 font-semibold">$12.99</p>
                </figcaption>
              </figure>

              <figure class="flex flex-row mb-4">
                <div>
                  <a
                    href="#"
                    class="block w-20 h-20 rounded border border-gray-200 overflow-hidden"
                  >
                    <img
                      src="https://cdn.shopify.com/s/files/1/2303/2711/files/2_e822dae0-14df-4cb8-b145-ea4dc0966b34.jpg?v=1617059123"
                      class="h-full object-cover"
                      alt="Title"
                    />
                  </a>
                </div>
                <figcaption class="ml-3">
                  <p>
                    <a href="#" class="text-gray-600 hover:text-blue-600"
                      >Apple Watch Series 4 - Space Gray</a
                    >
                  </p>
                  <p class="mt-1 font-semibold">$12.99</p>
                </figcaption>
              </figure>

              <button
                class="bg-blue-600 text-white w-full font-bold py-2 rounded-sm shadow-md hover:bg-blue-700"
              >
                View More
              </button>
            </article>
          </aside>
          <!-- col.// -->
        </div>
        <!-- grid.// -->
      </div>
      <!-- container.// -->
    </section>
  </AppLayout>
</template>


<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  display: none;
}
</style>
