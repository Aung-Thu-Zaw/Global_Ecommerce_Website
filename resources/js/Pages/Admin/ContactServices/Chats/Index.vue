<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
// import Breadcrumb from "@/Components/Breadcrumbs/ChatBreadcrumb.vue";
import ChatConversationCard from "@/Components/Cards/Chats/ChatConversationCard.vue";
import DropdownToolsForChatMessage from "@/Components/Dropdowns/Chats/DropdownToolsForChatMessage.vue";
import AgentLiveChatMessageForm from "@/Components/Forms/Chats/AgentLiveChatMessageForm.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const isMessageSearchFormOpened = ref(false);
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('CHATS')" />
    <div class="w-full h-[960px] pt-[79px] overflow-hidden">
      <div class="w-full h-full flex items-center">
        <div class="w-[600px] h-full border-r-2 border-r-slate-300">
          <!-- Form -->
          <div class="bg-white border-b px-2 py-[11px]">
            <form
              class="w-full border-b flex items-center justify-between border-2 border-gray-400 py-0.5 px-2 rounded-sm"
            >
              <input
                type="text"
                class="w-full border-none focus:ring-0 text-sm"
                :placeholder="__('SEARCH_CHAT')"
              />
              <i
                class="fa-solid fa-xmark ml-1 text-sm cursor-pointer text-gray-600 hover:text-red-600"
              ></i>
            </form>
          </div>

          <!-- Header -->
          <div class="w-full bg-white flex items-start justify-between h-full">
            <!-- Sidebar  -->
            <div
              class="border-r border-gray-300 shadow bg-gray-50 w-[70px] h-[815px] flex flex-col p-2 text-xs items-center space-y-5 overflow-auto scrollbar"
            >
              <div
                data-tooltip-target="trash-tooltip"
                data-tooltip-placement="right"
                class="flex items-center justify-center borer ring-2 ring-red-300 min-w-[40px] min-h-[40px] rounded-sm bg-red-600 text-white hover:bg-red-700"
              >
                <i class="fa-solid fa-trash-can"></i>

                <div
                  id="trash-tooltip"
                  role="tooltip"
                  class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
                >
                  {{ __("TRASH") }}
                  <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
              </div>
              <div
                data-tooltip-target="bookmark-tooltip"
                data-tooltip-placement="right"
                class="flex items-center justify-center borer ring-2 ring-primary-300 min-w-[40px] min-h-[40px] rounded-sm bg-primary-600 text-white hover:bg-primary-700"
              >
                <i class="fa-solid fa-bookmark"></i>
                <div
                  id="bookmark-tooltip"
                  role="tooltip"
                  class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
                >
                  {{ __("BOOKMARK") }}
                  <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
              </div>
              <div
                data-tooltip-target="bookmark-tooltip"
                data-tooltip-placement="right"
                class="flex items-center justify-center borer ring-2 ring-warning-300 min-w-[40px] min-h-[40px] rounded-sm bg-warning-600 text-white hover:bg-warning-700"
              >
                <i class="fa-solid fa-archive"></i>
                <div
                  id="bookmark-tooltip"
                  role="tooltip"
                  class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
                >
                  {{ __("ARCHIVE") }}
                  <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
              </div>

              <div
                data-tooltip-target="create-folder-tooltip"
                data-tooltip-placement="right"
                class="flex items-center justify-center borer bg-blue-600 ring-2 ring-blue-300 text-white min-w-[40px] min-h-[40px] rounded-sm hover:bg-blue-700"
              >
                <i class="fa-solid fa-folder-plus"></i>
                <div
                  id="create-folder-tooltip"
                  role="tooltip"
                  class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
                >
                  {{ __("CREATE_NEW_FOLDER") }}
                  <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
              </div>

              <span
                class="font-bold text-slate-600 pt-3 border-t border-slate-300 flex flex-col items-center justify-center"
              >
                <span> Chat </span>
                <span>
                  {{ __("FOLDERS") }}
                </span>
              </span>

              <div
                data-tooltip-target="folder-tooltip"
                data-tooltip-placement="right"
                class="flex items-center justify-center borer bg-gray-500 ring-2 ring-gray-300 text-white min-w-[40px] min-h-[40px] rounded-sm hover:bg-gray-600"
              >
                <i class="fa-solid fa-folder"></i>
                <div
                  id="folder-tooltip"
                  role="tooltip"
                  class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-800 bg-white rounded-lg shadow-lg opacity-0 tooltip border"
                >
                  Customers
                  <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
              </div>
            </div>
            <div class="w-full">
              <ul
                class="flex items-center justify-between text-sm font-medium text-center text-gray-500 w-full p-2"
              >
                <li class="">
                  <a
                    href="#"
                    class="inline-block px-3 py-2.5 text-blue-600 bg-blue-200 rounded-md border-2 border-blue-400 active text-xs transition-all shadow"
                    aria-current="page"
                    >{{ __("ALL_CHATS") }}</a
                  >
                </li>
                <li class="">
                  <a
                    href="#"
                    class="inline-block px-3 py-2.5 text-slate-600 bg-slate-200 hover:bg-slate-300 rounded-md border-2 border-slate-400 active text-xs transition-all shadow"
                    >{{ __("ONGOING_CHATS") }}</a
                  >
                </li>
                <li class="">
                  <a
                    href="#"
                    class="inline-block px-3 py-2.5 text-slate-600 bg-slate-200 hover:bg-slate-300 rounded-md border-2 border-slate-400 active text-xs transition-all shadow"
                    >{{ __("ENDED_CHATS") }}</a
                  >
                </li>
              </ul>

              <!-- Chat Conversation -->

              <div
                class="w-full h-[760px] space-y-2 p-3 overflow-auto scrollbar"
              >
                <ChatConversationCard />
              </div>
            </div>
          </div>
        </div>
        <div class="w-full h-full">
          <!-- Header -->
          <div class="w-full border-b bg-white px-5 py-3 flex items-center">
            <div class="flex items-center justify-between w-full">
              <div class="flex items-center">
                <div class="mr-3">
                  <img
                    src="https://img.freepik.com/premium-vector/female-user-profile-avatar-is-woman-character-screen-saver-with-emotions_505620-617.jpg?w=2000"
                    class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300"
                  />
                </div>
                <div>
                  <div class="flex items-center space-x-3">
                    <h3 class="text-slate-700 font-bold text-md">
                      Aung Thu Zaw
                    </h3>
                  </div>

                  <!-- Online Status -->
                  <div
                    class="flex items-center text-green-500 animate-pulse space-x-1"
                  >
                    <i class="fa-solid fa-circle text-[.5rem]"></i>
                    <span class="text-xs font-bold">Online</span>
                  </div>

                  <!-- Offline Status -->
                  <!-- <div class="flex items-center text-red-500 space-x-1">
              <i class="fa-solid fa-circle text-[.5rem]"></i>
              <span class="text-xs font-bold">Offline</span>
            </div> -->
                </div>
              </div>

              <div class="flex items-center space-x-5">
                <!-- Search Icon -->
                <div
                  @click="
                    isMessageSearchFormOpened = !isMessageSearchFormOpened
                  "
                  class="cursor-pointer text-slate-600 hover:text-slate-800"
                >
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <!-- Dropdown  -->
                <div class="font-bold text-slate-600 hover:text-slate-800">
                  <button
                    id="dropdownMenuIconButton"
                    data-dropdown-toggle="dropdownDots"
                    type="button"
                    class="p-2 hover:bg-gray-200 rounded-md"
                  >
                    <svg
                      class="w-4 h-4"
                      aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor"
                      viewBox="0 0 4 15"
                    >
                      <path
                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                      />
                    </svg>
                  </button>

                  <!-- Dropdown menu -->
                  <div
                    id="dropdownDots"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                  >
                    <ul
                      class="py-2 text-sm text-gray-600 font-medium"
                      aria-labelledby="dropdownMenuIconButton"
                    >
                      <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                          <i class="fa-solid fa-file-export mr-1"></i>
                          {{ __("EXPORT_CHAT") }}</a
                        >
                      </li>
                      <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">
                          <i class="fa-solid fa-broom mr-1"></i>
                          {{ __("CLEAR_HISTORY") }}</a
                        >
                      </li>
                    </ul>
                    <div class="py-2">
                      <a
                        href="#"
                        class="block px-4 py-2 hover:bg-gray-100 text-red-600 text-sm font-medium"
                      >
                        <i class="fa-solid fa-trash-can mr-2"></i>
                        {{ __("DELETE_CHAT") }}</a
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Search Form And Result  -->
          <div
            v-if="isMessageSearchFormOpened"
            class="fixed w-[1295px] top-[144px] h-auto border-t border-b bg-white py-2 px-10"
          >
            <!-- Search Message Form -->
            <div class="flex items-center justify-between space-x-10">
              <form
                class="flex items-center rounded-full px-5 bg-slate-100 py-1 border w-full"
              >
                <input
                  type="text"
                  class="w-full border-none focus:ring-0 text-xs bg-transparent"
                  :placeholder="__('SEARCH_MESSAGE')"
                />
                <i
                  class="fa-solid fa-xmark ml-1 text-sm text-slate-500 hover:text-red-600"
                ></i>
              </form>
              <div class="flex items-center space-x-5 w-auto">
                <div
                  @click="isMessageSearchFormOpened = false"
                  class="w-5 h-5 p-1 rounded-full flex items-center justify-center bg-gray-300 cursor-pointer hover:bg-gray-200"
                >
                  <i class="fa-solid fa-xmark text-xs"></i>
                </div>
                <div class="text-slate-600 hover:text-slate-500 cursor-pointer">
                  <i class="fa-solid fa-calendar"></i>
                </div>
              </div>
            </div>

            <!-- Result -->
            <!-- <div class="mt-5">
              <ul class="">
                <li
                  class="w-full border-t py-1 hover:bg-gray-100 px-5 rounded-sm cursor-pointer"
                >
                  <div class="flex items-center">
                    <img
                      src="https://img.freepik.com/free-psd/3d-illustration-person-with-glasses_23-2149436189.jpg"
                      class="w-8 h-8 rounded-full object-cover mr-3"
                    />
                    <div class="w-full">
                      <div
                        class="text-xs flex items-center justify-between w-full"
                      >
                        <h6 class="font-semibold">Aung Thu Zaw</h6>
                        <span class="text-slate-700 font-medium"
                          >3-September-2023</span
                        >
                      </div>
                      <span class="text-xs text-slate-600">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Nobis nihil dolorem sit quia reiciendis earum ea magnam,
                        modi perspiciatis rerum amet facere vel dicta cupiditate
                        aliquid iste fuga quod harum.
                      </span>
                    </div>
                  </div>
                </li>
              </ul>
            </div> -->
          </div>

          <!-- Message -->
          <div class="bg-white">
            <div class="h-[720px] overflow-auto scrollbar">
              <div class="p-5">
                <!-- Right Side  -->
                <div class="mb-2">
                  <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Monday )
                  </p>
                  <div class="flex items-end justify-end">
                    <div class="flex items-center justify-end">
                      <div class="pl-28">
                        <div class="flex items-center justify-center">
                          <!-- Dropdown  -->
                          <div
                            class="font-bold text-slate-500 hover:text-slate-800"
                          >
                            <button
                              id="messageDropdown"
                              data-dropdown-toggle="messageDropdownDots"
                              data-dropdown-placement="left-start"
                              type="button"
                              class="p-2"
                            >
                              <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 4 15"
                              >
                                <path
                                  d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                />
                              </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                              id="messageDropdownDots"
                              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                            >
                              <ul
                                class="py-2 text-sm text-gray-600 font-normal"
                                aria-labelledby="messageDropdown"
                              >
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i
                                      class="fa-solid fa-circle-check mr-1"
                                    ></i>
                                    {{ __("SELECT") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-reply mr-1"></i>
                                    {{ __("REPLY") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-thumbtack mr-1"></i>
                                    {{ __("PIN") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-copy mr-1"></i>
                                    {{ __("COPY_TEXT") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-download mr-1"></i>
                                    {{ __("DOWNLOAD") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-edit mr-1"></i>
                                    {{ __("EDIT") }}</a
                                  >
                                </li>

                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-trash mr-1"></i>
                                    {{ __("DELETE") }}</a
                                  >
                                </li>
                              </ul>
                            </div>
                          </div>
                          <p
                            class="p-3 border-2 bg-slate-50 border-slate-300 rounded-xl rounded-br-none shadow w-auto max-w-[500px] text-sm"
                          >
                            Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit. Voluptates hic soluta repudiandae sit cumque
                            velit ratione nam fugiat magnam blanditiis. Debitis,
                            culpa ex dolores repellendus corporis nemo at
                            quibusdam. Sequi!
                          </p>
                        </div>

                        <div
                          class="mt-1 text-[.6rem] text-slate-600 flex items-center justify-end space-x-4"
                        >
                          <span class="font-bold">{{ __("EDITED") }}</span>
                          <div
                            class="flex items-center justify-end space-x-2 mr-2"
                          >
                            <span class=""> 3:30 PM </span>
                            <span class="text-[.6rem] text-slate-600">
                              <i class="fa-solid fa-check text-green-500"></i>
                              <i class="fa-solid fa-check text-green-500"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <img
                      src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?w=740&t=st=1693393599~exp=1693394199~hmac=b8d8549ac43842545b9059353c6fb745d4d86f21531f6bdba7b292e0bcdd40cc"
                      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 ml-3"
                    />
                  </div>
                </div>

                <!-- left Side -->
                <div class="mb-2">
                  <div>
                    <!-- <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Sunday )
                  </p> -->
                    <div class="flex items-end">
                      <img
                        src="https://media.istockphoto.com/id/171383132/photo/customer-service-representative.jpg?s=612x612&w=0&k=20&c=dpu11BZe50RU09eyoLrn55aCkcLKJOj99iGyktLPblI="
                        class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 mr-3"
                      />

                      <div class="flex items-end justify-start w-full">
                        <div class="pr-28">
                          <div class="flex items-center justify-start">
                            <p
                              class="p-3 bg-slate-200 border-2 border-slate-300 rounded-xl rounded-bl-none shadow w-auto max-w-[500px] text-sm"
                            >
                              Lorem ipsum dolor sit amet, consectetur
                              adipisicing elit. Voluptates hic soluta
                              repudiandae sit cumque velit ratione nam fugiat
                              magnam blanditiis. Debitis, culpa ex dolores
                              repellendus corporis nemo at quibusdam. Sequi!ff
                            </p>
                            <!-- Dropdown  -->
                            <div
                              class="font-bold text-slate-500 hover:text-slate-800"
                            >
                              <button
                                id="messageDropdown"
                                data-dropdown-toggle="messageDropdownDots"
                                data-dropdown-placement="right-start"
                                type="button"
                                class="p-2"
                              >
                                <svg
                                  class="w-4 h-4"
                                  aria-hidden="true"
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="currentColor"
                                  viewBox="0 0 4 15"
                                >
                                  <path
                                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                  />
                                </svg>
                              </button>

                              <!-- Dropdown menu -->
                              <div
                                id="messageDropdownDots"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                              >
                                <ul
                                  class="py-2 text-sm text-gray-600 font-normal"
                                  aria-labelledby="messageDropdown"
                                >
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i
                                        class="fa-solid fa-circle-check mr-1"
                                      ></i>
                                      Select
                                    </a>
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-reply mr-1"></i>
                                      Reply
                                    </a>
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-thumbtack mr-1"></i>
                                      Pin
                                    </a>
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-copy mr-1"></i>
                                      Copy Text</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-download mr-1"></i>
                                      Download</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-edit mr-1"></i>
                                      Edit</a
                                    >
                                  </li>

                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-trash mr-1"></i>
                                      Delete</a
                                    >
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div
                            class="mt-1 text-[.6rem] text-slate-600 flex items-center justify-start space-x-4"
                          >
                            <div
                              class="flex items-center justify-end space-x-2"
                            >
                              <span class=""> 3:30 PM </span>
                              <span class="text-[.6rem] text-slate-600">
                                <i class="fa-solid fa-check text-green-500"></i>
                                <i class="fa-solid fa-check text-green-500"></i>
                              </span>
                            </div>

                            <span class="font-bold">{{ __("EDITED") }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Right Side  -->
                <div class="mb-2">
                  <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Monday )
                  </p>
                  <div class="flex items-end justify-end">
                    <div class="flex items-center justify-end">
                      <div class="pl-28">
                        <div class="flex items-center justify-center">
                          <!-- Dropdown  -->
                          <div
                            class="font-bold text-slate-500 hover:text-slate-800"
                          >
                            <button
                              id="messageDropdown"
                              data-dropdown-toggle="messageDropdownDots"
                              data-dropdown-placement="left-start"
                              type="button"
                              class="p-2"
                            >
                              <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 4 15"
                              >
                                <path
                                  d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                />
                              </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                              id="messageDropdownDots"
                              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                            >
                              <ul
                                class="py-2 text-sm text-gray-600 font-normal"
                                aria-labelledby="messageDropdown"
                              >
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i
                                      class="fa-solid fa-circle-check mr-1"
                                    ></i>
                                    {{ __("SELECT") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-reply mr-1"></i>
                                    {{ __("REPLY") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-thumbtack mr-1"></i>
                                    {{ __("PIN") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-copy mr-1"></i>
                                    {{ __("COPY_TEXT") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-download mr-1"></i>
                                    {{ __("DOWNLOAD") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-edit mr-1"></i>
                                    {{ __("EDIT") }}</a
                                  >
                                </li>

                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-trash mr-1"></i>
                                    {{ __("DELETE") }}</a
                                  >
                                </li>
                              </ul>
                            </div>
                          </div>
                          <div class="grid grid-cols-1">
                            <img
                              src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                              class="h-48 object-cover border border-slate-300 rounded-sm"
                            />
                          </div>
                        </div>
                        <div
                          class="flex items-center justify-end space-x-2 mr-2 mt-1"
                        >
                          <span class="text-[.6rem] text-slate-600">
                            3:30 PM
                          </span>
                          <span class="text-[.6rem] text-slate-600">
                            <i class="fa-solid fa-check text-green-500"></i>
                            <i class="fa-solid fa-check text-green-500"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <img
                      src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?w=740&t=st=1693393599~exp=1693394199~hmac=b8d8549ac43842545b9059353c6fb745d4d86f21531f6bdba7b292e0bcdd40cc"
                      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 ml-3"
                    />
                  </div>
                </div>

                <!-- Right Side  -->
                <div class="mb-2">
                  <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Monday )
                  </p>
                  <div class="flex items-end justify-end">
                    <div class="flex items-center justify-end">
                      <div class="pl-28">
                        <div class="flex items-center justify-center">
                          <!-- Dropdown  -->
                          <div
                            class="font-bold text-slate-500 hover:text-slate-800"
                          >
                            <button
                              id="messageDropdown"
                              data-dropdown-toggle="messageDropdownDots"
                              data-dropdown-placement="left-start"
                              type="button"
                              class="p-2"
                            >
                              <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 4 15"
                              >
                                <path
                                  d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                />
                              </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                              id="messageDropdownDots"
                              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                            >
                              <ul
                                class="py-2 text-sm text-gray-600 font-normal"
                                aria-labelledby="messageDropdown"
                              >
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i
                                      class="fa-solid fa-circle-check mr-1"
                                    ></i>
                                    {{ __("SELECT") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-reply mr-1"></i>
                                    {{ __("REPLY") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-thumbtack mr-1"></i>
                                    {{ __("PIN") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-copy mr-1"></i>
                                    {{ __("COPY_TEXT") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-download mr-1"></i>
                                    {{ __("DOWNLOAD") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-edit mr-1"></i>
                                    {{ __("EDIT") }}</a
                                  >
                                </li>

                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-trash mr-1"></i>
                                    {{ __("DELETE") }}</a
                                  >
                                </li>
                              </ul>
                            </div>
                          </div>
                          <div class="grid grid-cols-2 gap-0.5">
                            <img
                              src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                              class="h-28 object-cover border border-slate-300 rounded-sm"
                            />
                            <img
                              src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                              class="h-28 object-cover border border-slate-300 rounded-sm"
                            />
                          </div>
                        </div>
                        <div
                          class="flex items-center justify-end space-x-2 mr-2 mt-1"
                        >
                          <span class="text-[.6rem] text-slate-600">
                            3:30 PM
                          </span>
                          <span class="text-[.6rem] text-slate-600">
                            <i class="fa-solid fa-check text-green-500"></i>
                            <i class="fa-solid fa-check text-green-500"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <img
                      src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?w=740&t=st=1693393599~exp=1693394199~hmac=b8d8549ac43842545b9059353c6fb745d4d86f21531f6bdba7b292e0bcdd40cc"
                      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 ml-3"
                    />
                  </div>
                </div>

                <!-- left Side -->
                <div class="mb-2">
                  <div>
                    <!-- <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Sunday )
                  </p> -->
                    <div class="flex items-end">
                      <img
                        src="https://media.istockphoto.com/id/171383132/photo/customer-service-representative.jpg?s=612x612&w=0&k=20&c=dpu11BZe50RU09eyoLrn55aCkcLKJOj99iGyktLPblI="
                        class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 mr-3"
                      />

                      <div class="flex items-end justify-start w-full">
                        <div class="pr-28">
                          <div class="flex items-center justify-start">
                            <div class="grid grid-cols-2 gap-0.5">
                              <img
                                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                                class="h-28 object-cover border border-slate-300 rounded-sm"
                              />
                              <img
                                src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                                class="h-28 object-cover border border-slate-300 rounded-sm"
                              />
                            </div>
                            <!-- Dropdown  -->
                            <div
                              class="font-bold text-slate-500 hover:text-slate-800"
                            >
                              <button
                                id="messageDropdown"
                                data-dropdown-toggle="messageDropdownDots"
                                data-dropdown-placement="right-start"
                                type="button"
                                class="p-2"
                              >
                                <svg
                                  class="w-4 h-4"
                                  aria-hidden="true"
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="currentColor"
                                  viewBox="0 0 4 15"
                                >
                                  <path
                                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                  />
                                </svg>
                              </button>

                              <!-- Dropdown menu -->
                              <div
                                id="messageDropdownDots"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                              >
                                <ul
                                  class="py-2 text-sm text-gray-600 font-normal"
                                  aria-labelledby="messageDropdown"
                                >
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i
                                        class="fa-solid fa-circle-check mr-1"
                                      ></i>
                                      Select
                                    </a>
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-reply mr-1"></i>
                                      Reply
                                    </a>
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-thumbtack mr-1"></i>
                                      Pin
                                    </a>
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-copy mr-1"></i>
                                      Copy Text</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-download mr-1"></i>
                                      Download</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-edit mr-1"></i>
                                      Edit</a
                                    >
                                  </li>

                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-trash mr-1"></i>
                                      Delete</a
                                    >
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>

                          <div
                            class="flex items-center justify-start space-x-2 mr-2 mt-1"
                          >
                            <span class="text-[.6rem] text-slate-600">
                              3:50 PM
                            </span>
                            <span class="text-[.6rem] text-slate-600">
                              <i class="fa-solid fa-check text-green-500"></i>
                              <i class="fa-solid fa-check"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Right Side  -->
                <div class="mb-2">
                  <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Monday )
                  </p>
                  <div class="flex items-end justify-end">
                    <div class="flex items-center justify-end">
                      <div class="pl-28 w-[500px]">
                        <div class="flex items-center justify-center">
                          <!-- Dropdown  -->
                          <div
                            class="font-bold text-slate-500 hover:text-slate-800"
                          >
                            <button
                              id="messageDropdown"
                              data-dropdown-toggle="messageDropdownDots"
                              data-dropdown-placement="left-start"
                              type="button"
                              class="p-2"
                            >
                              <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 4 15"
                              >
                                <path
                                  d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                />
                              </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                              id="messageDropdownDots"
                              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                            >
                              <ul
                                class="py-2 text-sm text-gray-600 font-normal"
                                aria-labelledby="messageDropdown"
                              >
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i
                                      class="fa-solid fa-circle-check mr-1"
                                    ></i>
                                    {{ __("SELECT") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-reply mr-1"></i>
                                    {{ __("REPLY") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-thumbtack mr-1"></i>
                                    {{ __("PIN") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-copy mr-1"></i>
                                    {{ __("COPY_TEXT") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-download mr-1"></i>
                                    {{ __("DOWNLOAD") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-edit mr-1"></i>
                                    {{ __("EDIT") }}</a
                                  >
                                </li>

                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-trash mr-1"></i>
                                    {{ __("DELETE") }}</a
                                  >
                                </li>
                              </ul>
                            </div>
                          </div>
                          <div
                            class="flex flex-row-reverse items-center flex-wrap"
                          >
                            <img
                              src="https://cdn.dribbble.com/userupload/4443667/file/original-5d56901f011915cb845770ad7c5c3666.png?resize=1024x768&vertical=center"
                              class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                            />
                            <img
                              src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                              class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                            />
                            <img
                              src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                              class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                            />
                            <img
                              src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                              class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                            />
                            <img
                              src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                              class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                            />
                            <img
                              src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                              class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                            />
                            <img
                              src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                              class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                            />
                            <img
                              src="https://cdn.dribbble.com/userupload/7618814/file/original-a6d14b926794be13a47a0251ec5cf7f1.png?resize=1024x768"
                              class="h-20 object-cover border border-slate-300 rounded-sm ml-0.5 mb-0.5"
                            />
                          </div>
                        </div>
                        <div
                          class="flex items-center justify-end space-x-2 mr-2 mt-1"
                        >
                          <span class="text-[.6rem] text-slate-600">
                            3:30 PM
                          </span>
                          <span class="text-[.6rem] text-slate-600">
                            <i class="fa-solid fa-check text-green-500"></i>
                            <i class="fa-solid fa-check text-green-500"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <img
                      src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?w=740&t=st=1693393599~exp=1693394199~hmac=b8d8549ac43842545b9059353c6fb745d4d86f21531f6bdba7b292e0bcdd40cc"
                      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 ml-3"
                    />
                  </div>
                </div>

                <!-- Right Side  -->
                <div class="mb-2">
                  <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Monday )
                  </p>
                  <div class="flex items-end justify-end">
                    <div class="flex items-center justify-end">
                      <div class="pl-28">
                        <div class="flex items-center justify-center">
                          <!-- Dropdown  -->
                          <div
                            class="font-bold text-slate-500 hover:text-slate-800"
                          >
                            <button
                              id="messageDropdown"
                              data-dropdown-toggle="messageDropdownDots"
                              data-dropdown-placement="left-start"
                              type="button"
                              class="p-2"
                            >
                              <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 4 15"
                              >
                                <path
                                  d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                />
                              </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                              id="messageDropdownDots"
                              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                            >
                              <ul
                                class="py-2 text-sm text-gray-600 font-normal"
                                aria-labelledby="messageDropdown"
                              >
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i
                                      class="fa-solid fa-circle-check mr-1"
                                    ></i>
                                    {{ __("SELECT") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-reply mr-1"></i>
                                    {{ __("REPLY") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-thumbtack mr-1"></i>
                                    {{ __("PIN") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-copy mr-1"></i>
                                    {{ __("COPY_TEXT") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-download mr-1"></i>
                                    {{ __("DOWNLOAD") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-edit mr-1"></i>
                                    {{ __("EDIT") }}</a
                                  >
                                </li>

                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-trash mr-1"></i>
                                    {{ __("DELETE") }}</a
                                  >
                                </li>
                              </ul>
                            </div>
                          </div>
                          <p
                            class="p-3 bg-slate-50 border-2 border-slate-300 rounded-xl rounded-br-none shadow-md w-auto max-w-[500px] text-sm"
                          >
                            Lorem ipsum dolor sit amet.
                          </p>
                        </div>
                        <div
                          class="mt-1 text-[.6rem] text-slate-600 flex items-center justify-end space-x-4"
                        >
                          <span class="font-bold">{{ __("EDITED") }}</span>
                          <div
                            class="flex items-center justify-end space-x-2 mr-2"
                          >
                            <span class=""> 3:30 PM </span>
                            <span class="text-[.6rem] text-slate-600">
                              <i class="fa-solid fa-check text-green-500"></i>
                              <i class="fa-solid fa-check text-green-500"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <img
                      src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?w=740&t=st=1693393599~exp=1693394199~hmac=b8d8549ac43842545b9059353c6fb745d4d86f21531f6bdba7b292e0bcdd40cc"
                      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 ml-3"
                    />
                  </div>
                </div>

                <!-- Right Side  -->
                <div class="mb-2">
                  <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Monday )
                  </p>
                  <div class="flex items-end justify-end">
                    <div class="flex items-center justify-end">
                      <div class="pl-28">
                        <div class="flex items-center justify-center">
                          <!-- Dropdown  -->
                          <div
                            class="font-bold text-slate-500 hover:text-slate-800"
                          >
                            <button
                              id="messageDropdown"
                              data-dropdown-toggle="messageDropdownDots"
                              data-dropdown-placement="left-start"
                              type="button"
                              class="p-2"
                            >
                              <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 4 15"
                              >
                                <path
                                  d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                />
                              </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                              id="messageDropdownDots"
                              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                            >
                              <ul
                                class="py-2 text-sm text-gray-600 font-normal"
                                aria-labelledby="messageDropdown"
                              >
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i
                                      class="fa-solid fa-circle-check mr-1"
                                    ></i>
                                    {{ __("SELECT") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-reply mr-1"></i>
                                    {{ __("REPLY") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-thumbtack mr-1"></i>
                                    {{ __("PIN") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-copy mr-1"></i>
                                    {{ __("COPY_TEXT") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-download mr-1"></i>
                                    {{ __("DOWNLOAD") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-edit mr-1"></i>
                                    {{ __("EDIT") }}</a
                                  >
                                </li>

                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-trash mr-1"></i>
                                    {{ __("DELETE") }}</a
                                  >
                                </li>
                              </ul>
                            </div>
                          </div>
                          <p
                            class="p-3 bg-slate-50 border-2 border-slate-300 rounded-xl rounded-br-none shadow-md w-auto max-w-[500px] text-sm"
                          >
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Quae aspernatur voluptatum beatae libero ex
                            vero quisquam sequi nam, cupiditate eaque.
                          </p>
                        </div>
                        <div
                          class="mt-1 text-[.6rem] text-slate-600 flex items-center justify-end space-x-4"
                        >
                          <span class="font-bold">{{ __("EDITED") }}</span>
                          <div
                            class="flex items-center justify-end space-x-2 mr-2"
                          >
                            <span class=""> 3:30 PM </span>
                            <span class="text-[.6rem] text-slate-600">
                              <i class="fa-solid fa-check text-green-500"></i>
                              <i class="fa-solid fa-check text-green-500"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <img
                      src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?w=740&t=st=1693393599~exp=1693394199~hmac=b8d8549ac43842545b9059353c6fb745d4d86f21531f6bdba7b292e0bcdd40cc"
                      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 ml-3"
                    />
                  </div>
                </div>

                <!-- left Side -->
                <div class="mb-2">
                  <div>
                    <p
                      class="text-center text-sm text-slate-500 font-bold mb-5"
                    >
                      22-April-2023 ( Sunday )
                    </p>
                    <div class="flex items-end">
                      <img
                        src="https://media.istockphoto.com/id/171383132/photo/customer-service-representative.jpg?s=612x612&w=0&k=20&c=dpu11BZe50RU09eyoLrn55aCkcLKJOj99iGyktLPblI="
                        class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 mr-3"
                      />

                      <div class="flex items-end justify-start w-full">
                        <div class="pr-28">
                          <div class="flex items-center justify-start">
                            <video-player
                              src="https://player.vimeo.com/external/482032091.sd.mp4?s=3894ac8c829e2a945d5b2525ba2325e6890af37b&profile_id=164&oauth2_token_id=57447761"
                              controls
                              :loop="true"
                              :volume="0.6"
                              class="w-[500px] h-[283px] border border-slate-300 shadow-md"
                            />
                            <!-- Dropdown  -->
                            <div
                              class="font-bold text-slate-500 hover:text-slate-800"
                            >
                              <button
                                id="messageDropdown"
                                data-dropdown-toggle="messageDropdownDots"
                                data-dropdown-placement="right-start"
                                type="button"
                                class="p-2"
                              >
                                <svg
                                  class="w-4 h-4"
                                  aria-hidden="true"
                                  xmlns="http://www.w3.org/2000/svg"
                                  fill="currentColor"
                                  viewBox="0 0 4 15"
                                >
                                  <path
                                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                  />
                                </svg>
                              </button>

                              <!-- Dropdown menu -->
                              <div
                                id="messageDropdownDots"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                              >
                                <ul
                                  class="py-2 text-sm text-gray-600 font-normal"
                                  aria-labelledby="messageDropdown"
                                >
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i
                                        class="fa-solid fa-circle-check mr-1"
                                      ></i>
                                      Select
                                    </a>
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-reply mr-1"></i>
                                      Reply
                                    </a>
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-thumbtack mr-1"></i>
                                      Pin
                                    </a>
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-copy mr-1"></i>
                                      Copy Text</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-download mr-1"></i>
                                      Download</a
                                    >
                                  </li>
                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-edit mr-1"></i>
                                      Edit</a
                                    >
                                  </li>

                                  <li>
                                    <a
                                      href="#"
                                      class="block px-4 py-2 hover:bg-gray-100"
                                    >
                                      <i class="fa-solid fa-trash mr-1"></i>
                                      Delete</a
                                    >
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>

                          <div
                            class="flex items-center justify-start space-x-2 mr-2 mt-1"
                          >
                            <span class="text-[.6rem] text-slate-600">
                              3:50 PM
                            </span>
                            <span class="text-[.6rem] text-slate-600">
                              <i class="fa-solid fa-check text-green-500"></i>
                              <i class="fa-solid fa-check"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Right Side  -->
                <div class="mb-2">
                  <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Monday )
                  </p>
                  <div class="flex items-end justify-end">
                    <div class="flex items-center justify-end">
                      <div class="pl-28">
                        <div class="flex items-center justify-center">
                          <!-- Dropdown  -->
                          <div
                            class="font-bold text-slate-500 hover:text-slate-800"
                          >
                            <button
                              id="messageDropdown"
                              data-dropdown-toggle="messageDropdownDots"
                              data-dropdown-placement="left-start"
                              type="button"
                              class="p-2"
                            >
                              <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 4 15"
                              >
                                <path
                                  d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                />
                              </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                              id="messageDropdownDots"
                              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                            >
                              <ul
                                class="py-2 text-sm text-gray-600 font-normal"
                                aria-labelledby="messageDropdown"
                              >
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i
                                      class="fa-solid fa-circle-check mr-1"
                                    ></i>
                                    {{ __("SELECT") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-reply mr-1"></i>
                                    {{ __("REPLY") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-thumbtack mr-1"></i>
                                    {{ __("PIN") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-copy mr-1"></i>
                                    {{ __("COPY_TEXT") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-download mr-1"></i>
                                    {{ __("DOWNLOAD") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-edit mr-1"></i>
                                    {{ __("EDIT") }}</a
                                  >
                                </li>

                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-trash mr-1"></i>
                                    {{ __("DELETE") }}</a
                                  >
                                </li>
                              </ul>
                            </div>
                          </div>
                          <video-player
                            src="https://player.vimeo.com/progressive_redirect/playback/788713051/rendition/360p/file.mp4?loc=external&oauth2_token_id=57447761&signature=919ef4f383848136dec2a4c7b11a673bfa9c5837f31d5c4843e153ff238b2bb6"
                            controls
                            :loop="true"
                            :volume="0.6"
                            class="w-[500px] h-[283px] border border-slate-300 shadow-md"
                          />
                        </div>
                        <div
                          class="flex items-center justify-end space-x-2 mr-2 mt-1"
                        >
                          <span class="text-[.6rem] text-slate-600">
                            3:30 PM
                          </span>
                          <span class="text-[.6rem] text-slate-600">
                            <i class="fa-solid fa-check text-green-500"></i>
                            <i class="fa-solid fa-check text-green-500"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <img
                      src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?w=740&t=st=1693393599~exp=1693394199~hmac=b8d8549ac43842545b9059353c6fb745d4d86f21531f6bdba7b292e0bcdd40cc"
                      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 ml-3"
                    />
                  </div>
                </div>

                <!-- Right Side  -->
                <div class="mb-2">
                  <p class="text-center text-sm text-slate-500 font-bold mb-5">
                    22-April-2023 ( Monday )
                  </p>
                  <div class="flex items-end justify-end">
                    <div class="flex items-center justify-end">
                      <div class="pl-28">
                        <div class="flex items-center justify-center">
                          <!-- Dropdown  -->
                          <div
                            class="font-bold text-slate-500 hover:text-slate-800"
                          >
                            <button
                              id="messageDropdown"
                              data-dropdown-toggle="messageDropdownDots"
                              data-dropdown-placement="left-start"
                              type="button"
                              class="p-2"
                            >
                              <svg
                                class="w-4 h-4"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 4 15"
                              >
                                <path
                                  d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                />
                              </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                              id="messageDropdownDots"
                              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 border border-slate-300"
                            >
                              <ul
                                class="py-2 text-sm text-gray-600 font-normal"
                                aria-labelledby="messageDropdown"
                              >
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i
                                      class="fa-solid fa-circle-check mr-1"
                                    ></i>
                                    {{ __("SELECT") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-reply mr-1"></i>
                                    {{ __("REPLY") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-thumbtack mr-1"></i>
                                    {{ __("PIN") }}
                                  </a>
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-copy mr-1"></i>
                                    {{ __("COPY_TEXT") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-download mr-1"></i>
                                    {{ __("DOWNLOAD") }}</a
                                  >
                                </li>
                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-edit mr-1"></i>
                                    {{ __("EDIT") }}</a
                                  >
                                </li>

                                <li>
                                  <a
                                    href="#"
                                    class="block px-4 py-2 hover:bg-gray-100"
                                  >
                                    <i class="fa-solid fa-trash mr-1"></i>
                                    {{ __("DELETE") }}</a
                                  >
                                </li>
                              </ul>
                            </div>
                          </div>
                          <video-player
                            src="https://player.vimeo.com/external/484400309.sd.mp4?s=ce7283c34054fc63121bc763965fd4b8cb91e534&profile_id=164&oauth2_token_id=57447761"
                            controls
                            :loop="true"
                            :volume="0.6"
                            class="w-[500px] h-[283px] border border-slate-300 shadow-md"
                          />
                        </div>
                        <div
                          class="flex items-center justify-end space-x-2 mr-2 mt-1"
                        >
                          <span class="text-[.6rem] text-slate-600">
                            3:30 PM
                          </span>
                          <span class="text-[.6rem] text-slate-600">
                            <i class="fa-solid fa-check text-green-500"></i>
                            <i class="fa-solid fa-check text-green-500"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                    <img
                      src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?w=740&t=st=1693393599~exp=1693394199~hmac=b8d8549ac43842545b9059353c6fb745d4d86f21531f6bdba7b292e0bcdd40cc"
                      class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-300 ml-3"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <AgentLiveChatMessageForm />
        </div>
      </div>
    </div>
  </AdminDashboardLayout>
</template>


<style scoped>
.scrollbar::-webkit-scrollbar {
  display: none;
}
</style>
