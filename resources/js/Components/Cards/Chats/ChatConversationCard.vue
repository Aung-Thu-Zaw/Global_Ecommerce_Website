<script setup>
import DropdownToolsForChatConversationCard from "@/Components/Dropdowns/Chats/DropdownToolsForChatConversationCard.vue";
import { Link } from "@inertiajs/vue3";
import { computed, onMounted, ref, watch } from "vue";

const props = defineProps({
  liveChat: Object,
});

const unreadMessages = ref(
  props.liveChat ? props.liveChat.live_chat_messages : []
);

const lastMessage = ref(
  props.liveChat.live_chat_messages
    ? props.liveChat?.live_chat_messages[
        props.liveChat?.live_chat_messages.length - 1
      ]
    : null
);

const agentUnreadMessagesCount = computed(() => {
  const messages = unreadMessages.value.length
    ? unreadMessages.value.filter((message) => {
        return message.is_read_by_agent === 0;
      })
    : [];

  return messages ? messages.length : null;
});

onMounted(() => {
  Echo.private(`live-chat.message`).listen("LiveChatMessageSent", (data) => {
    if (data.liveChatMessage.live_chat_id === props.liveChat.id) {
      //   props.liveChat.live_chat_messages.push(data.liveChatMessage);
      unreadMessages.value.push(data.liveChatMessage);
      lastMessage.value = data.liveChatMessage;
    }
  });
});
</script>

<template>
  <div
    class="border rounded-md cursor-pointer transition-all w-full flex items-center justify-between"
  >
    <!-- Chat Card  -->
    <Link
      as="button"
      :href="route('admin.live-chats.show', { live_chat: liveChat.uuid })"
      v-if="liveChat"
      :data="{
        search: $page.props.ziggy.query?.search,
        tab: $page.props.ziggy.query?.tab,
      }"
      class="p-3 w-full h-full"
    >
      <!-- :class="{
            'border-l-4 border-r-4 border-l-red-600 border-r-red-600':
              liveChat.ended_at,
            'border-l-4 border-r-4 border-l-sky-600 border-r-sky-600':
              !liveChat.ended_at && !liveChat.live_chat_messages?.length,
            'border-l-4 border-r-4 border-l-green-500 border-r-green-500':
              !liveChat.ended_at && liveChat.live_chat_messages?.length,
          }" -->
      <div class="flex items-center">
        <div class="flex items-center w-full">
          <div class="w-14 flex items-center justify-center mr-1">
            <img
              :src="liveChat?.user?.avatar"
              class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300"
            />
          </div>
          <div class="flex flex-col items-start w-full">
            <div class="w-full flex items-center justify-between">
              <h4 class="text-sm font-semibold text-slate-700">
                {{ liveChat?.user?.name }}
              </h4>
            </div>
            <!-- Send Text -->
            <div
              v-if="lastMessage?.live_chat_id === liveChat.id"
              class="w-full flex items-center"
            >
              <span class="text-[.6rem] w-auto mr-1 font-medium text-amber-700">
                {{ lastMessage?.user_id ? lastMessage?.user?.name : "You" }} :
              </span>

              <span class="text-[.6rem] text-slate-600 line-clamp-1 w-auto">
                {{
                  lastMessage.message
                    ? lastMessage.message
                    : "Send " +
                      lastMessage?.chat_file_attachments?.length +
                      " File(s)"
                }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </Link>

    <div class="py-3 pr-3 flex flex-col items-center">
      <div class="flex items-center justify-center space-x-2">
        <!-- Dropdown -->
        <DropdownToolsForChatConversationCard :liveChat="liveChat" />

        <div v-if="liveChat.pinned" class="text-xs text-slate-500">
          <i class="fa-solid fa-thumbtack"></i>
        </div>
      </div>

      <div
        v-if="agentUnreadMessagesCount !== 0"
        class="border w-4 h-4 rounded-full bg-blue-600 text-white flex items-center justify-center p-2"
      >
        <span class="text-[.6rem]">{{ agentUnreadMessagesCount }}</span>
      </div>
    </div>
  </div>
</template>




