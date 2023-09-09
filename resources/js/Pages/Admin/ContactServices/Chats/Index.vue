<script setup>
import AdminDashboardLayout from "@/Layouts/AdminDashboardLayout.vue";
import ChatConversationCard from "@/Components/Cards/Chats/ChatConversationCard.vue";
import FilterChatCardTabs from "@/Components/Tabs/FilterChatCardTabs.vue";
import ChatConversationCardSearchForm from "@/Components/Forms/Chats/ChatConversationCardSearchForm.vue";
import AdminDashboardChatSidebarButtons from "@/Components/Sidebars/AdminDashboardChatSidebarButtons.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";

const props = defineProps({
  liveChats: Object,
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

            <div class="flex flex-col w-full h-full">
              <div class="w-full">
                <FilterChatCardTabs />
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
                        class="border-slate-200 bg-white hover:bg-gray-100"
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

        <div class="w-full h-full flex flex-col items-center justify-center">
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
