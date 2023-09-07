<script setup>
import UserLiveChatMessageForm from "@/Components/Forms/Chats/UserLiveChatMessageForm.vue";
import SenderTextMessageCard from "@/Components/Cards/Chats/SenderTextMessageCard.vue";
import SenderFileMessageCard from "@/Components/Cards/Chats/SenderFileMessageCard.vue";
import RecevierTextMessageCard from "@/Components/Cards/Chats/RecevierTextMessageCard.vue";
import ReceiverFileMessageCard from "@/Components/Cards/Chats/ReceiverFileMessageCard.vue";
import OnlineStatus from "@/Components/Status/OnlineStatus.vue";
import OfflineStatus from "@/Components/Status/OfflineStatus.vue";
import BusyStatus from "@/Components/Status/BusyStatus.vue";
import { Head, Link } from "@inertiajs/vue3";
import { computed, onMounted, onUpdated, ref } from "vue";
import { initFlowbite } from "flowbite";

const props = defineProps({
  liveChat: Object,
});

const messages = ref(props.liveChat.live_chat_messages);

// Define Variables
const msgScroll = ref(null);
const messageToEdit = ref(null);
const messageToReply = ref(null);

// Auto Scroll To Bottom
const scrollToBottom = () => {
  msgScroll.value.scrollTop = msgScroll.value.scrollHeight;
};

// const liveChatMessages = computed(() => {
//   return props.liveChatMessages.filter((message) => {
//     return message.live_chat_id === props.liveChat.id;
//   });
// });

const setMessageToEdit = (message) => {
  messageToEdit.value = message;
};

const setMessageToReply = (message) => {
  messageToReply.value = message;
};

const cancelEditMessage = () => {
  messageToEdit.value = null;
};

const cancelReplyMessage = () => {
  messageToReply.value = null;
};

onMounted(() => {
  initFlowbite();

  Echo.private(`live-chat.message`).listen("LiveChatMessageSent", (data) => {
    messages.value.push(data.liveChatMessage);
  });
});

onUpdated(() => {
  scrollToBottom();
});
</script>


<template>
  <Head title="Support Service Live Chat" />
  <div class="w-full min-h-screen background flex items-center justify-center">
    <div
      class="w-[1200px] h-auto border border-slate-300 shadow-lg rounded-md overflow-hidden"
    >
      <div v-if="liveChat" class="min-w-full">
        <!-- Live Chat Box Header -->
        <div
          class="w-full border-b shadow bg-white px-5 py-3 flex items-center justify-between"
        >
          <div class="flex items-center">
            <div class="mr-3">
              <img
                :src="liveChat.agent?.avatar"
                class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300"
              />
            </div>
            <div>
              <div class="flex items-center space-x-3">
                <h3 class="text-slate-700 font-bold text-md">
                  {{ liveChat.agent?.name }}
                </h3>
                <span
                  class="text-xs font-medium bg-blue-200 text-blue-700 px-2 py-0.5 rounded-full"
                >
                  Service Agent
                </span>
              </div>

              <!-- <OnlineStatus />

              <OfflineStatus />

              <BusyStatus /> -->
            </div>
          </div>

          <!-- End Chat Button -->
          <div class="">
            <Link
              v-if="liveChat.is_active === 1 && liveChat.ended_at === null"
              as="button"
              method="patch"
              :href="route('service.live-chat.update', liveChat.id)"
              class="text-xs font-semibold px-3 py-2 rounded-[4px] bg-red-600 text-white"
            >
              End Chat
            </Link>
          </div>
        </div>

        <!-- Chat Message Box -->
        <div class="h-[700px] bg-white flex flex-col justify-end">
          <div class="overflow-auto scrollbar p-5 h-auto" ref="msgScroll">
            <div v-for="message in messages" :key="message.id">
              <!-- Left Side For Recevier -->
              <div
                v-if="message.agent_id && !message.user_id && message.message"
              >
                <RecevierTextMessageCard
                  :message="message"
                  @editMessage="setMessageToEdit"
                  @replyMessage="setMessageToReply"
                />
              </div>
              <div
                v-if="
                  !message.user_id &&
                  message.agent_id &&
                  message.chat_file_attachments.length
                "
              >
                <ReceiverFileMessageCard :message="message" />
              </div>

              <!-- Right Side For Sender  -->
              <div
                v-if="message.user_id && !message.agent_id && message.message"
              >
                <SenderTextMessageCard
                  :message="message"
                  @editMessage="setMessageToEdit"
                  @replyMessage="setMessageToReply"
                />
              </div>
              <div
                v-if="
                  message.user_id &&
                  !message.agent_id &&
                  message.chat_file_attachments.length
                "
              >
                <SenderFileMessageCard :message="message" />
              </div>
            </div>
          </div>
        </div>

        <!-- Live Chat Message Form -->
        <UserLiveChatMessageForm
          :liveChat="liveChat"
          :messageToEdit="messageToEdit"
          @cancelEditMessage="cancelEditMessage"
          :messageToReply="messageToReply"
          @cancelReplyMessage="cancelReplyMessage"
        />
      </div>
    </div>
  </div>

  <!-- <div v-if="previousLiveChats.length" class="mb-5">
            <p
              class="w-full text-center text-sm font-medium text-blue-500 hover:text-blue-600 cursor-pointer mb-6"
            >
              <i class="fa-solid fa-message mr-1"></i>
              View Previous Chat History
            </p>

            <LastChatDiscussionInformationCard :liveChat="liveChat" />
          </div> -->

  <!-- <p
            v-if="!liveChat.is_active && liveChat.ended_at"
            class="text-sm font-bold text-gray-500 w-full text-center mt-5"
          >
            {{ __("THE_CHAT_HAS_ENDED") }}
          </p> -->
</template>


<style>
.background {
  background-image: url("https://cdn.dribbble.com/users/1003944/screenshots/15741863/06_comp_1_4x.gif?resize=400x300&vertical=center");
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  background-color: rgba(0, 0, 0, 0.037);
  background-blend-mode: darken;
}

.scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #999 #f0f0f0;
}

.scrollbar::-webkit-scrollbar {
  width: 6px;
}

.scrollbar::-webkit-scrollbar-track {
  background-color: #f0f0f0;
}

.scrollbar::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}
</style>
