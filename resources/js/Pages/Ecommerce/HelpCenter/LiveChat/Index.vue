<script setup>
import UserLiveChatMessageForm from "@/Components/Forms/Chats/UserLiveChatMessageForm.vue";
import SenderTextMessageCard from "@/Components/Cards/Chats/SenderTextMessageCard.vue";
import SenderPhotoVideoMessageCard from "@/Components/Cards/Chats/SenderPhotoVideoMessageCard.vue";
import RecevierTextMessageCard from "@/Components/Cards/Chats/RecevierTextMessageCard.vue";
// import RecevierPhotoVideoMessageCard from "@/Components/Cards/Chats/RecevierPhotoVideoMessageCard.vue";
import OnlineStatus from "@/Components/Status/OnlineStatus.vue";
import OfflineStatus from "@/Components/Status/OfflineStatus.vue";
import BusyStatus from "@/Components/Status/BusyStatus.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";



defineProps({
  liveChat: Object,
  liveChatMessages: Object,
});

// initialize components based on data attribute selectors
onMounted(() => {
  initFlowbite();
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
</script>


<template>
  <Head title="Support Service Live Chat" />

  <div class="w-full min-h-screen background flex items-center justify-center">
    <div
      class="w-[1200px] h-auto border border-slate-300 shadow-lg rounded-md overflow-hidden"
    >
      <div class="min-w-full">
        <!-- Header -->
        <div
          class="w-full border-b shadow bg-white px-5 py-3 flex items-center"
        >
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

            <!-- Online Status -->
            <OnlineStatus />

            <!-- Offline Status -->
            <!-- <OfflineStatus /> -->

            <!-- Busy Status -->
            <!-- <BusyStatus /> -->
          </div>
        </div>

        <!-- Message -->
        <div class="bg-white">
          <div class="h-[700px] overflow-auto scrollbar">
            <div class="p-5 flex flex-col justify-end h-full">
              <div v-for="message in liveChatMessages" :key="message.id">
                <!-- <p
                  v-if="shouldDisplayDate"
                  class="text-center text-sm text-slate-500 font-bold px-5 mb-5"
                >
                  {{ message.created_at }}
                </p> -->
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
                  <SenderPhotoVideoMessageCard :message="message" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Footer Input Form -->
        <UserLiveChatMessageForm :liveChat="liveChat" />
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
