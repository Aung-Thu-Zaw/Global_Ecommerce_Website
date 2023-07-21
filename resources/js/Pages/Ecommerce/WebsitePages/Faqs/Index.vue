<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
  <AppLayout>
    <Head title="FAQs" />

    <div class="min-h-[1400px] h-auto bg-gray-50 mt-40 w-full">
      <div class="container mx-auto py-8">
        <h1 class="font-bold text-2xl">Frequently Ask Questions?</h1>

        <div class="flex items-start justify-between mt-10">
          <!-- Categories Sidebar -->
          <div class="border w-[258px] border-slate-500 h-auto">
            <h3
              class="py-3 bg-blue-700 text-white text-lg font-bold text-center"
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
                  <ul class="font-medium">
                    <li class="w-full border-b border-b-slate-300">
                      <a
                        href="#"
                        class="flex items-center p-3 text-gray-900 w-full hover:bg-gray-200 group"
                      >
                        <svg
                          class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                          aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="currentColor"
                          viewBox="0 0 22 21"
                        >
                          <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"
                          />
                          <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"
                          />
                        </svg>
                        <span class="ml-3">Dashboard</span>
                      </a>
                    </li>
                    <li class="w-full border-b border-b-slate-300">
                      <button
                        type="button"
                        class="flex items-center w-full p-3 text-base text-gray-900 transition duration-75 group hover:bg-gray-200"
                        aria-controls="dropdown-example"
                        data-collapse-toggle="dropdown-example"
                      >
                        <svg
                          class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                          aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="currentColor"
                          viewBox="0 0 18 21"
                        >
                          <path
                            d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z"
                          />
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap"
                          >E-commerce</span
                        >
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
                      <ul id="dropdown-example" class="hidden py-2 space-y-2">
                        <li>
                          <a
                            href="#"
                            class="flex items-center w-full py-2 pl-10 text-gray-900 transition duration-75 group hover:bg-gray-200"
                            >Products</a
                          >
                        </li>
                        <li>
                          <a
                            href="#"
                            class="flex items-center w-full py-2 pl-10 text-gray-900 transition duration-75 group hover:bg-gray-200"
                            >Billing</a
                          >
                        </li>
                        <li>
                          <a
                            href="#"
                            class="flex items-center w-full py-2 pl-10 text-gray-900 transition duration-75 group hover:bg-gray-200"
                            >Invoice</a
                          >
                        </li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </aside>
            </div>
          </div>

          <div class="w-full ml-5">
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
                        <svg
                          class="w-3 h-3 mr-2.5"
                          aria-hidden="true"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"
                          />
                        </svg>
                        Home
                      </a>
                    </li>
                    <li>
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
                          >Projects</a
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
                          >Flowbite</span
                        >
                      </div>
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="w-full">
                <ul
                  class="list-disc list-inside space-y-4 text-sm text-gray-700"
                >
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                  </li>
                  <li class="hover:text-blue-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
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

