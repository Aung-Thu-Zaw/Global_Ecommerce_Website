<script setup>
import ChatBox from "@/Components/ChatBox.vue";
import ReportBugModal from "@/Components/Modals/ReportBugModal.vue";
import RequestFeatureModal from "@/Components/Modals/RequestFeatureModal.vue";
import FeedbackModal from "@/Components/Modals/FeedbackModal.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const isVisibleChatbox = ref(false);

const totalMessages = computed(() => {
  const totalUserConversations = usePage().props.conversations.filter(
    (conversation) =>
      conversation.customer_id === usePage().props.auth.user?.id ||
      conversation.vendor_id === usePage().props.auth.user?.id
  );

  const totalConversationUnseenMessages = totalUserConversations.reduce(
    (total, conversation) =>
      total +
      conversation.messages.reduce(
        (unseenCount, conversationMessage) =>
          unseenCount +
          (conversationMessage.is_seen === 0 &&
          usePage().props.auth.user.id !== conversationMessage.user_id
            ? 1
            : 0),
        0
      ),
    0
  );

  return totalConversationUnseenMessages;
});
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
            v-if="totalMessages"
            class="absolute -top-1 -right-1 bg-red-600 w-4 h-4 rounded-full text-[.7rem] flex items-center justify-center"
          >
            <span>{{ totalMessages }}</span>
          </div>
        </button>
        <div
          id="chat-box"
          role="tooltip"
          class="absolute invisible inline-block p-2 text-sm font-medium text-white bg-gray-600 rounded-md shadow-lg border opacity-0 tooltip w-[100px]"
        >
          Chat Box
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>

      <div>
        <button
          data-tooltip-target="request-feature"
          data-tooltip-placement="left"
          data-modal-target="request-feature-modal"
          data-modal-toggle="request-feature-modal"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
          type="button"
        >
          <i class="fa-solid fa-envelope-open-text"></i>
        </button>

        <div
          id="request-feature"
          role="tooltip"
          class="absolute invisible inline-block p-2 text-sm font-medium text-white bg-gray-600 rounded-md shadow-lg border opacity-0 tooltip w-[150px]"
        >
          Request Features
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>
      <div>
        <button
          data-tooltip-target="feedbacks"
          data-tooltip-placement="left"
          data-modal-target="feedback-modal"
          data-modal-toggle="feedback-modal"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
          type="button"
        >
          <i class="fa-solid fa-pen-nib"></i>
        </button>

        <div
          id="feedbacks"
          role="tooltip"
          class="absolute invisible inline-block p-2 text-sm font-medium text-white bg-gray-600 rounded-md shadow-lg border opacity-0 tooltip w-[200px]"
        >
          Feedback For Website
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>

      <div>
        <button
          data-tooltip-target="report-bugs"
          data-tooltip-placement="left"
          data-modal-target="report-modal"
          data-modal-toggle="report-modal"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
          type="button"
        >
          <i class="fa-solid fa-bug"></i>
        </button>

        <div
          id="report-bugs"
          role="tooltip"
          class="absolute invisible inline-block p-2 text-sm font-medium text-white bg-gray-600 rounded-md shadow-lg border opacity-0 tooltip w-[100px]"
        >
          Report Bugs
          <div class="tooltip-arrow" data-popper-arrow></div>
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
          class="absolute invisible inline-block p-2 text-sm font-medium text-dark bg-white rounded-md shadow-lg border opacity-0 tooltip w-[170px] text-left"
        >
          <div class="px-3 font-bold py-1 text-blue-600">
            <a
              :href="$page.props.socialShares.facebook"
              target="_blank"
              data-tooltip-target="facebook"
              data-tooltip-placement="top"
            >
              <i class="fa-brands fa-facebook mr-3 text-xl"></i>
              Facebook
            </a>
            <div
              id="facebook"
              role="tooltip"
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
            >
              Share on facebook
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>
          <div class="px-3 font-bold py-1 text-sky-600">
            <a
              :href="$page.props.socialShares.twitter"
              target="_blank"
              data-tooltip-target="twitter"
              data-tooltip-placement="top"
            >
              <i class="fa-brands fa-twitter mr-3 text-xl"></i>
              Twitter
            </a>
            <div
              id="twitter"
              role="tooltip"
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
            >
              Share on twitter
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>

          <div class="px-3 font-bold py-1 text-blue-800">
            <a
              :href="$page.props.socialShares.linkedin"
              target="_blank"
              data-tooltip-target="linkedin"
              data-tooltip-placement="top"
            >
              <i class="fa-brands fa-linkedin mr-3 text-xl"></i>
              Linked In
            </a>
            <div
              id="linkedin"
              role="tooltip"
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
            >
              Share on LinkedIn
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>
          <div data-popper-arrow></div>
          <div class="px-3 font-bold py-1 text-orange-500">
            <a
              :href="$page.props.socialShares.reddit"
              target="_blank"
              data-tooltip-target="reddit"
              data-tooltip-placement="top"
            >
              <i class="fa-brands fa-reddit mr-3 text-xl"></i>
              Reddit
            </a>
            <div
              id="reddit"
              role="tooltip"
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
            >
              Share on reddit
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>
          <div class="px-3 font-bold py-1 text-blue-500">
            <a
              :href="$page.props.socialShares.telegram"
              target="_blank"
              data-tooltip-target="telegram"
              data-tooltip-placement="top"
            >
              <i class="fa-brands fa-telegram mr-3 text-xl"></i>
              Telegram
            </a>
            <div
              id="telegram"
              role="tooltip"
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
            >
              Share on telegram
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>
          <div class="px-3 font-bold py-1 text-emerald-600">
            <a
              :href="$page.props.socialShares.whatsapp"
              target="_blank"
              data-tooltip-target="whatsapp"
              data-tooltip-placement="top"
            >
              <i class="fa-brands fa-whatsapp mr-3 text-xl"></i>
              Whatsapp
            </a>
            <div
              id="whatsapp"
              role="tooltip"
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip"
            >
              Share on whatsapp
              <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div v-if="isVisibleChatbox">
    <ChatBox @isVisible="isVisibleChatbox = false" />
  </div>

  <!-- Request Feature Modal -->
  <div
    id="request-feature-modal"
    tabindex="-1"
    aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
  >
    <div class="relative w-full max-w-4xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow">
        <button
          type="button"
          class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
          data-modal-hide="request-feature-modal"
        >
          <svg
            aria-hidden="true"
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
          <span class="sr-only">Close modal</span>
        </button>

        <RequestFeatureModal />
      </div>
    </div>
  </div>

  <!-- Report Bug Modal -->
  <div
    id="report-modal"
    tabindex="-1"
    aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
  >
    <div class="relative w-full max-w-4xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow">
        <button
          type="button"
          class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
          data-modal-hide="report-modal"
        >
          <svg
            aria-hidden="true"
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
          <span class="sr-only">Close modal</span>
        </button>

        <ReportBugModal />
      </div>
    </div>
  </div>

  <!-- Feedback Modal -->
  <div
    id="feedback-modal"
    tabindex="-1"
    aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
  >
    <div class="relative w-full max-w-4xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow">
        <button
          type="button"
          class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
          data-modal-hide="feedback-modal"
        >
          <svg
            aria-hidden="true"
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
          <span class="sr-only">Close modal</span>
        </button>

        <FeedbackModal />
      </div>
    </div>
  </div>
</template>

