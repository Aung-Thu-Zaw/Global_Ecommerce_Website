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
});

const isMessageSearchFormOpened = ref(false);

const selectedLiveChat = ref(null);

const handleSelectedChat = (chat) => {
  selectedLiveChat.value = chat;
};

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
    <div class="w-full h-[960px] pt-[79px] overflow-hidden">
      <div class="w-full h-full flex items-center">
        <div class="w-[600px] h-full border-r-2 border-r-slate-300">
          <!-- Form -->
          <ChatConversationCardSearchForm />

          <!-- Header -->
          <div class="w-full bg-white flex items-start justify-between h-full">
            <!-- Sidebar  -->
            <AdminDashboardChatSidebarButtons />

            <div v-if="liveChats.length" class="w-full">
              <FilterChatCardTabs />

              <!-- Chat Conversation -->

              <div
                class="w-full h-[760px] space-y-2 p-3 overflow-auto scrollbar"
              >
                <div v-for="liveChat in liveChats" :key="liveChat.id">
                  <ChatConversationCard
                    :liveChat="liveChat"
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
