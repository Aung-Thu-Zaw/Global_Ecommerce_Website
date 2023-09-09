<script setup>
import DropdownToolsForChatConversationCard from "@/Components/Dropdowns/Chats/DropdownToolsForChatConversationCard.vue";
import { computed, onMounted, ref, watch } from "vue";

const props = defineProps({
  liveChat: Object,
});

// const filteredMessages = computed(() => {
//   if (props.liveChat.live_chat_messages) {
//     return props.liveChat.live_chat_messages.filter((message) => {
//       return props.liveChat.id === message.live_chat_id;
//     });
//   }
// });

// const lastMessage = computed(
//   () => filteredMessages.value[filteredMessages.value.length - 1]
// );

// const lastMessage = computed(
//   () =>
//     props.liveChat.live_chat_messages[
//       props.liveChat.live_chat_messages.length - 1
//     ]
// );

const lastMessage = ref(null);

onMounted(() => {
  Echo.private(`live-chat.message`).listen("LiveChatMessageSent", (data) => {
    lastMessage.value = data.liveChatMessage;
  });
});
</script>

<template>
  <!-- Chat Card  -->
  <div
    v-if="liveChat"
    class="border rounded-md p-3 cursor-pointer transition-all"
    :class="{
      'border-l-4 border-r-4 border-l-red-600 border-r-red-600':
        liveChat.ended_at,
      'border-l-4 border-r-4 border-l-sky-600 border-r-sky-600':
        !liveChat.ended_at && !liveChat.live_chat_messages?.length,
      'border-l-4 border-r-4 border-l-green-500 border-r-green-500':
        !liveChat.ended_at && liveChat.live_chat_messages?.length,
    }"
  >
    <div class="flex items-center">
      <div class="flex items-center w-full">
        <img
          :src="liveChat?.user?.avatar"
          class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300 mr-2"
        />
        <div class="flex flex-col items-start w-full">
          <div class="w-full flex items-center justify-between">
            <h4 class="text-sm font-semibold text-slate-700">
              {{ liveChat?.user?.name }}
            </h4>

            <div class="flex items-center justify-center space-x-2">
              <!-- Dropdown  -->
              <DropdownToolsForChatConversationCard :liveChat="liveChat" />

              <div v-if="liveChat.pinned" class="text-xs text-slate-500">
                <i class="fa-solid fa-thumbtack"></i>
              </div>
            </div>
          </div>
          <!-- Send Text -->
          <div
            v-if="lastMessage.live_chat_id === liveChat.id"
            class="w-full flex items-center"
          >
            <span class="text-[.6rem] w-auto mr-1 font-medium text-amber-700">
              {{ lastMessage?.user_id ? lastMessage?.user?.name : "You" }} :
            </span>

            <span
              class="text-[.6rem] text-slate-600 line-clamp-1 w-auto min-w-[100px]"
            >
              {{
                lastMessage.message
                  ? lastMessage.message
                  : "Send " +
                    lastMessage.chat_file_attachments?.length +
                    " File(s)"
              }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

