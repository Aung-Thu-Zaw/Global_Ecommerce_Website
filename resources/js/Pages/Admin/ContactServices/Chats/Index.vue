<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import ChatConversationCard from "@/Components/Cards/Chats/ChatConversationCard.vue";
import AdminDashboardChatSidebarButtons from "@/Components/Sidebars/AdminDashboardChatSidebarButtons.vue";
import AdminDashboardLiveChatBoxHeader from "@/Components/Headers/AdminDashboardLiveChatBoxHeader.vue";
import AgentLiveChatMessageForm from "@/Components/Forms/Chats/AgentLiveChatMessageForm.vue";
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";
import SenderTextMessageCard from "@/Components/Cards/Chats/SenderTextMessageCard.vue";
import SenderFileMessageCard from "@/Components/Cards/Chats/SenderFileMessageCard.vue";
import ReceiverFileMessageCard from "@/Components/Cards/Chats/ReceiverFileMessageCard.vue";
import RecevierTextMessageCard from "@/Components/Cards/Chats/RecevierTextMessageCard.vue";
import { computed, onMounted, onUpdated, ref } from "vue";

const props = defineProps({
  liveChats: Object,
});

const isMessageSearchFormOpened = ref(false);

const selectedLiveChat = ref(null);

const handleSelectedChat = (chat) => {
  selectedLiveChat.value = chat;
};

const readMessage=()=>{
    
}

const msgScroll = ref(null);
// Auto Scroll To Bottom
const scrollToBottom = () => {
  msgScroll.value.scrollTop = msgScroll.value.scrollHeight;
};
onUpdated(() => {
  scrollToBottom();
});

onMounted(() => {
  Echo.private(`new-live-chat.assignment`).listen(
    "NewLiveChatAssignment",
    (data) => {
      data.liveChat.agent_id === usePage().props.auth.user?.id
        ? props.liveChats.push(data.liveChat)
        : console.log(data.liveChat);
    }
  );

  Echo.private(`live-chat.message`).listen("LiveChatMessageSent", (data) => {
    selectedLiveChat.value.live_chat_messages.push(data.liveChatMessage);
  });
});
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
            <AdminDashboardChatSidebarButtons />

            <div v-if="liveChats.length" class="w-full">
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
                <div v-for="liveChat in liveChats" :key="liveChat.id">
                  <ChatConversationCard
                    :liveChat="liveChat"
                    :lastMessage="
                      liveChat.live_chat_messages[
                        liveChat.live_chat_messages.length - 1
                      ]
                    "
                    @click="handleSelectedChat(liveChat)"
                    :class="{
                      'border-slate-400 shadow-md bg-gray-200':
                        selectedLiveChat?.id === liveChat?.id,
                      'border-slate-200 bg-white hover:bg-gray-100':
                        selectedLiveChat?.id !== liveChat?.id,
                    }"
                  />
                </div>
              </div>
            </div>
            <div v-else class="w-full flex items-center justify-center h-full">
              <p class="font-semibold text-slate-500 text-sm">
                {{ __("YOU_DONT_HAVE_ANY_CHAT_CONVERSATIONS") }}
              </p>
            </div>
          </div>
        </div>

        <div v-if="selectedLiveChat" class="w-full h-full">
          <!-- Header -->
          <AdminDashboardLiveChatBoxHeader :liveChat="selectedLiveChat" />

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
          <div class="h-[720px] bg-white flex flex-col justify-end">
            <div class="overflow-auto scrollbar p-5 h-auto" ref="msgScroll">
              <div
                v-for="message in selectedLiveChat.live_chat_messages"
                :key="message.id"
              >
                <!-- Left Side For Recevier -->
                <div
                  v-if="message.user_id && !message.agent_id && message.message"
                >
                  <RecevierTextMessageCard
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
                  <ReceiverFileMessageCard :message="message" />
                </div>

                <!-- Right Side For Sender  -->
                <div
                  v-if="message.agent_id && !message.user_id && message.message"
                >
                  <SenderTextMessageCard
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
                  <SenderFileMessageCard :message="message" />
                </div>
              </div>
            </div>
          </div>

          <AgentLiveChatMessageForm
            :liveChat="selectedLiveChat"
            :messageToEdit="messageToEdit"
            @cancelEditMessage="cancelEditMessage"
            :messageToReply="messageToReply"
            @cancelReplyMessage="cancelReplyMessage"
          />
        </div>
        <div
          v-else
          class="w-full h-full flex flex-col items-center justify-center"
        >
          <img
            src="../../../../assets/images/live-chat.jpg"
            class="h-96 object-cover mb-5"
          />
          <p
            class="font-bold text-slate-600 text-sm border shadow bg-gray-100 px-3 py-1 rounded-full"
          >
            {{ __("SELECT_A_CHAT_TO_START_MESSAGING") }}
          </p>
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
