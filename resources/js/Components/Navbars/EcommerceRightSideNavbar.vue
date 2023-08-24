<script setup>
import ChatBox from "@/Components/ChatBox.vue";
import SuggestionForm from "@/Components/Forms/SuggestionForm.vue";
import FeedbackForm from "@/Components/Forms/FeedbackForm.vue";
import NotificationDropdownForUser from "@/Components/Dropdowns/NotificationDropdownForUser.vue";
import ShareOnSocialMediaCard from "@/Components/Cards/ShareOnSocialMediaCard.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const isVisibleChatbox = ref(false);
const isSuggestionFormOpened = ref(false);
const isFeedbackFormOpened = ref(false);

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
      <!-- Notification -->
      <NotificationDropdownForUser
        v-if="$page.props.auth.user && $page.props.auth.user.role !== 'admin'"
      />

      <!-- Chat box -->
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
          class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium transition-opacity duration-300 bg-white border text-gray-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700 w-[90px]"
        >
          Chat Box
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>

      <!-- Suggestion -->
      <div>
        <button
          @click="isSuggestionFormOpened = !isSuggestionFormOpened"
          data-tooltip-target="suggestion"
          data-tooltip-placement="left"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
          type="button"
        >
          <i class="fa-solid fa-envelope-open-text"></i>
        </button>

        <div
          id="suggestion"
          role="tooltip"
          class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium transition-opacity duration-300 bg-white border text-gray-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
        >
          Suggestions
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>

      <!-- Feedback -->
      <div>
        <button
          @click="isFeedbackFormOpened = !isFeedbackFormOpened"
          data-tooltip-target="feedbacks"
          data-tooltip-placement="left"
          class="mb-2 md:mb-0 text-white shadow-lg bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm text-center w-8 h-8"
          type="button"
        >
          <i class="fa-solid fa-pen-nib"></i>
        </button>

        <div
          id="feedbacks"
          role="tooltip"
          class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium transition-opacity duration-300 bg-white border text-gray-600 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
        >
          Feedback
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
      </div>

      <!-- Share On Social Media -->
      <ShareOnSocialMediaCard />
    </div>
  </div>

  <div v-if="isVisibleChatbox">
    <ChatBox @isVisible="isVisibleChatbox = false" />
  </div>

  <div>
    <SuggestionForm
      :isSuggestionFormOpened="isSuggestionFormOpened"
      @update:isSuggestionFormOpened="isSuggestionFormOpened = $event"
    />
  </div>

  <div>
    <FeedbackForm
      :isFeedbackFormOpened="isFeedbackFormOpened"
      @update:isFeedbackFormOpened="isFeedbackFormOpened = $event"
    />
  </div>
</template>

