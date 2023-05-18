<script setup>
import ChatBox from "@/Components/ChatBox.vue";
import { ref } from "vue";

const isVisibleChatbox = ref(false);
</script>

<template>
  <div
    class="fixed bottom-0 top-0 right-0 w-auto px-3 rounded-sm shadow-lg bg-gray-50 border-l transition-all"
  >
    <div class="h-full flex flex-col items-center justify-center space-y-5">
      <div class="relative">
        <button
          @click="isVisibleChatbox = !isVisibleChatbox"
          data-tooltip-target="chat-box"
          data-tooltip-placement="left"
          type="button"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
        >
          <i class="fa-solid fa-message"></i>

          <div
            class="absolute -top-1 -right-1 bg-red-600 w-4 h-4 rounded-full text-[.7rem] flex items-center justify-center"
          >
            <span>2</span>
          </div>
        </button>
        <div
          id="chat-box"
          role="tooltip"
          class="absolute z-10 invisible inline-block p-2 text-sm font-medium text-dark bg-white rounded-md shadow-lg border opacity-0 tooltip w-[100px]"
        >
          Chat Box
          <div class="tooltip-arrow border" data-popper-arrow></div>
        </div>
      </div>
      <div>
        <button
          data-tooltip-target="request-feature"
          data-tooltip-placement="left"
          type="button"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
        >
          <i class="fa-solid fa-envelope-open-text"></i>
        </button>
        <div
          id="request-feature"
          role="tooltip"
          class="absolute z-10 invisible inline-block p-2 text-sm font-medium text-dark bg-white rounded-md shadow-lg border opacity-0 tooltip w-[150px]"
        >
          Request Features
          <div class="tooltip-arrow border" data-popper-arrow></div>
        </div>
      </div>
      <div>
        <button
          data-tooltip-target="feedbacks"
          data-tooltip-placement="left"
          type="button"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
        >
          <i class="fa-solid fa-pen-nib"></i>
        </button>
        <div
          id="feedbacks"
          role="tooltip"
          class="absolute z-10 invisible inline-block p-2 text-sm font-medium text-dark bg-white rounded-md shadow-lg border opacity-0 tooltip w-[100px]"
        >
          Feedback
          <div class="tooltip-arrow border" data-popper-arrow></div>
        </div>
      </div>

      <div>
        <button
          data-tooltip-target="report-bugs"
          data-tooltip-placement="left"
          type="button"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
        >
          <i class="fa-solid fa-bug"></i>
        </button>
        <div
          id="report-bugs"
          role="tooltip"
          class="absolute z-10 invisible inline-block p-2 text-sm font-medium text-dark bg-white rounded-md shadow-lg border opacity-0 tooltip w-[100px]"
        >
          Report Bugs
          <div class="tooltip-arrow border" data-popper-arrow></div>
        </div>
      </div>

      <div>
        <button
          data-popover-target="share"
          data-popover-placement="left"
          type="button"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
        >
          <i class="fa-solid fa-share-nodes"></i>
        </button>
        <div
          data-popover
          id="share"
          role="tooltip"
          class="absolute z-10 invisible inline-block p-2 text-sm font-medium text-dark bg-white rounded-md shadow-lg border opacity-0 tooltip w-[170px] text-left"
        >
          <div class="px-3 font-bold py-1 text-blue-600">
            <a href="#">
              <i class="fa-brands fa-facebook mr-3 text-xl"></i>
              Facebook
            </a>
          </div>
          <div class="px-3 font-bold py-1 text-pink-600">
            <a href="#">
              <i class="fa-brands fa-instagram mr-3 text-xl"></i>
              Instagram
            </a>
          </div>
          <div class="px-3 font-bold py-1 text-sky-600">
            <a href="#">
              <i class="fa-brands fa-twitter mr-3 text-xl"></i>
              Twitter
            </a>
          </div>
          <div class="px-3 font-bold py-1 text-red-600">
            <a href="#">
              <i class="fa-brands fa-youtube mr-3 text-xl"></i>
              Youtube
            </a>
          </div>

          <div data-popper-arrow></div>
        </div>
      </div>
    </div>
  </div>

  <!-- ChatBox  -->
  <div v-if="isVisibleChatbox">
    <ChatBox @isVisible="isVisibleChatbox = false" />
  </div>
</template>

