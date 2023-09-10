<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import ChatConversationCard from "@/Components/Cards/Chats/ChatConversationCard.vue";
import FilterChatCardTabs from "@/Components/Tabs/FilterChatCardTabs.vue";
import ChatConversationCardSearchForm from "@/Components/Forms/Chats/ChatConversationCardSearchForm.vue";
import AdminLiveChatMessageBoxSection from "@/Components/Sections/AdminLiveChatMessageBoxSection.vue";
import AdminDashboardChatSidebarButtons from "@/Components/Sidebars/AdminDashboardChatSidebarButtons.vue";
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";
import { computed, onMounted, onUpdated, ref } from "vue";

const props = defineProps({
  liveChats: Object,
  folders: Object,
  liveChat: Object,
});

const selectedLiveChat = ref(props.liveChat);

const isMessageSearchFormOpened = ref(false);

onMounted(() => {
  Echo.private(`new-live-chat.assignment`).listen(
    "NewLiveChatAssignment",
    (data) => {
      data.liveChat.agent_id === usePage().props.auth.user?.id
        ? props.liveChats.push(data.liveChat)
        : console.log(data.liveChat);
    }
  );
});
</script>

<template>
  <AdminDashboardLayout>
    <Head :title="__('CHATS')" />
    <div class="w-full h-screen pt-[79px]">
      <div class="w-full h-full flex items-center">
        <div
          class="w-[600px] h-full border-r-2 border-r-slate-300 overflow-hidden"
        >
          <!-- Form -->
          <ChatConversationCardSearchForm
            :selectedLiveChat="selectedLiveChat"
          />

          <!-- Header -->
          <div class="w-full bg-white flex items-start justify-between h-full">
            <!-- Sidebar  -->
            <AdminDashboardChatSidebarButtons :folders="folders" />

            <div class="flex flex-col w-full h-full">
              <div class="w-full">
                <FilterChatCardTabs :selectedLiveChat="selectedLiveChat" />
              </div>
              <div class="w-full h-full">
                <div v-if="liveChats.length" class="w-full">
                  <!-- Chat Conversation -->

                  <div
                    class="w-full h-[760px] space-y-2 p-3 overflow-auto scrollbar"
                  >
                    <div
                      v-for="liveChat in liveChats"
                      :key="liveChat.id"
                      class="w-full"
                    >
                      <ChatConversationCard
                        :liveChat="liveChat"
                        :folders="folders"
                        class="border-slate-200 hover:bg-gray-50"
                        :class="{
                          'border-slate-400 bg-gray-100 shadow-md':
                            selectedLiveChat.id === liveChat.id,
                        }"
                      />
                    </div>
                  </div>
                </div>
                <div
                  v-else
                  class="w-full flex items-center justify-center h-full"
                >
                  <p class="font-semibold text-slate-500 text-sm">
                    {{ __("YOU_DONT_HAVE_ANY_CHAT_CONVERSATIONS") }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <AdminLiveChatMessageBoxSection :selectedLiveChat="selectedLiveChat" />
      </div>
    </div>
  </AdminDashboardLayout>
</template>

<style scoped>
.scrollbar::-webkit-scrollbar {
  display: none;
}
</style>
