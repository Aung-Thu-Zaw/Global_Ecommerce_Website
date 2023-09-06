<script setup>
import UserLiveChatMessageForm from "@/Components/Forms/Chats/UserLiveChatMessageForm.vue";
import SenderTextMessageCard from "@/Components/Cards/Chats/SenderTextMessageCard.vue";
import SenderFileMessageCard from "@/Components/Cards/Chats/SenderFileMessageCard.vue";
import RecevierTextMessageCard from "@/Components/Cards/Chats/RecevierTextMessageCard.vue";
import LastChatDiscussionInformationCard from "@/Components/Cards/Chats/LastChatDiscussionInformationCard.vue";
// import RecevierPhotoVideoMessageCard from "@/Components/Cards/Chats/RecevierPhotoVideoMessageCard.vue";
import OnlineStatus from "@/Components/Status/OnlineStatus.vue";
import OfflineStatus from "@/Components/Status/OfflineStatus.vue";
import BusyStatus from "@/Components/Status/BusyStatus.vue";
import { Head, Link } from "@inertiajs/vue3";
import { computed, onMounted, onUpdated, ref } from "vue";
import { initFlowbite } from "flowbite";

const props = defineProps({
  currentLiveChat: Object,
  liveChatMessages: Object,
});

const msgScroll = ref(null);

const scrollToBottom = () => {
  msgScroll.value.scrollTop = msgScroll.value.scrollHeight;
};

// initialize components based on data attribute selectors
onMounted(() => {
  initFlowbite();
});

onUpdated(() => {
  scrollToBottom();
});

// const lastDisplayedDate = ref("");

// const shouldDisplayDate = computed(() => {
//   const currentDate = props.message.created_at;
//   if (currentDate === lastDisplayedDate.value) {
//     return false;
//   }
//   lastDisplayedDate.value = currentDate;
//   return true;
// });

const currentLiveChatMessages = computed(() => {
  return props.liveChatMessages.filter((message) => {
    return message.live_chat_id === props.currentLiveChat.id;
  });
});
</script>


<template>
  <Head title="Support Service Live Chat" />

  <div class="w-full min-h-screen background flex items-center justify-center">
    <div
      class="w-[1200px] h-auto border border-slate-300 shadow-lg rounded-md overflow-hidden"
    >
      <div v-if="currentLiveChat" class="min-w-full">
        <!-- Header -->
        <div
          class="w-full border-b shadow bg-white px-5 py-3 flex items-center justify-between"
        >
          <div class="flex items-center">
            <div class="mr-3">
              <img
                :src="currentLiveChat.agent?.avatar"
                class="w-10 h-10 rounded-full object-cover ring-2 ring-slate-300"
              />
            </div>
            <div>
              <div class="flex items-center space-x-3">
                <h3 class="text-slate-700 font-bold text-md">
                  {{ currentLiveChat.agent?.name }}
                </h3>
                <span
                  class="text-xs font-medium bg-blue-200 text-blue-700 px-2 py-0.5 rounded-full"
                >
                  Service Agent
                </span>
              </div>

              <!-- Online Status -->
              <OnlineStatus />

              <!-- Offline Status -->
              <!-- <OfflineStatus /> -->

              <!-- Busy Status -->
              <!-- <BusyStatus /> -->
            </div>
          </div>
          <div class="">
            <Link
              v-if="
                currentLiveChat.is_active === 1 &&
                currentLiveChat.ended_at === null
              "
              as="button"
              method="patch"
              :href="route('service.live-chat.update', currentLiveChat.id)"
              class="text-xs font-semibold px-3 py-2 rounded-[4px] bg-red-600 text-white"
            >
              End Chat
            </Link>
          </div>
        </div>

        <div class="h-[700px] bg-white flex flex-col justify-end">
          <!-- <div v-if="previousLiveChats.length" class="mb-5">
            <p
              class="w-full text-center text-sm font-medium text-blue-500 hover:text-blue-600 cursor-pointer mb-6"
            >
              <i class="fa-solid fa-message mr-1"></i>
              View Previous Chat History
            </p>

            <LastChatDiscussionInformationCard :liveChat="currentLiveChat" />
          </div> -->
          <div class="overflow-auto scrollbar p-5 h-auto" ref="msgScroll">
            <div v-for="message in currentLiveChatMessages" :key="message.id">
              <!-- Left Side For Recevier -->
              <div
                v-if="message.agent_id && !message.user_id && message.message"
              >
                <RecevierTextMessageCard :message="message" />
              </div>
              <!-- <RecevierPhotoVideoMessageCard /> -->

              <!-- Right Side For Sender  -->
              <div
                v-if="message.user_id && !message.agent_id && message.message"
              >
                <SenderTextMessageCard :message="message" />
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

          <!-- <p
            v-if="!currentLiveChat.is_active && currentLiveChat.ended_at"
            class="text-sm font-bold text-gray-500 w-full text-center mt-5"
          >
            {{ __("THE_CHAT_HAS_ENDED") }}
          </p> -->
        </div>

        <!-- Footer Input Form -->
        <UserLiveChatMessageForm :liveChat="currentLiveChat" />
      </div>
    </div>
  </div>
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
