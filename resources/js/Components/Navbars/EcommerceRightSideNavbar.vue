<script setup>
import ChatBox from "@/Components/ChatBox.vue";
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
          type="button"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
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
          type="button"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
        >
          <i class="fa-solid fa-pen-nib"></i>
        </button>
        <div
          id="feedbacks"
          role="tooltip"
          class="absolute invisible inline-block p-2 text-sm font-medium text-white bg-gray-600 rounded-md shadow-lg border opacity-0 tooltip w-[100px]"
        >
          Feedback
          <div class="tooltip-arrow" data-popper-arrow></div>
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
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
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
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
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
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
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
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
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
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
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
              class="absolute border invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
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
</template>

