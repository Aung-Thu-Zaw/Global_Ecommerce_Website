<script setup>
import { usePage } from "@inertiajs/vue3";
import MessageBox from "@/Components/MessageBox.vue";
import ConversationCardForCustomer from "@/Components/Cards/ConversationCardForCustomer.vue";
import ConversationCardForVendor from "@/Components/Cards/ConversationCardForVendor.vue";
import { computed, ref } from "vue";

const props = defineProps({
  conversation: Object,
});

const emit = defineEmits(["isVisible"]);

const handleClose = () => {
  emit("isVisible");
};

const selected = ref(props.conversation ? props.conversation.id : null);

const selectedConversation = ref(null);
const conversations = computed(() => usePage().props.conversations);

const handleSelectedConversation = (conversationId) => {
  selectedConversation.value = conversations.value.find(
    (conversation) => conversation.id === conversationId
  );

  selected.value = conversationId;
};
</script>


<template>
  <div
    class="fixed  bottom-0 right-14 w-[900px] h-[700px] rounded-tl-md border-2 border-r-0 shadow-sm bg-gray-50 chat-box"
  >
    <div class="flex items-center h-full">
      <div class="w-1/2 h-full">
        <div
          class="relative text-center flex items-center justify-center text-lg font-semibold text-slate-700 border-b py-[22px]"
        >
          <span
            @click="handleClose"
            class="absolute top-3 cursor-pointer left-3 border w-6 h-6 rounded-full flex items-center justify-center text-sm bg-slate-200 hover:bg-slate-400 hover:text-white transition-all"
          >
            <i class="fa-solid fa-xmark"></i>
          </span>
          <h1><i class="fa-solid fa-message"></i> Messages</h1>
        </div>

        <div
          class="p-2 space-y-1 h-[630px] overflow-auto conversation-container"
        >
          <div
            v-if="!$page.props.conversations.length"
            class="h-full flex items-center justify-center"
          >
            <p class="text-center font-bold text-sm text-slate-600">
              You don't have any conversations.
            </p>
          </div>
          <div
            v-for="conversation in $page.props.conversations"
            :key="conversation.id"
          >
            <div
              v-if="
                $page.props.auth.user &&
                $page.props.auth.user.id === conversation.customer_id
              "
            >
              <ConversationCardForCustomer
                :conversation="conversation"
                @click="handleSelectedConversation(conversation.id)"
                :class="{
                  'bg-slate-200': selected === conversation.id,
                }"
              />
            </div>
            <div
              v-else-if="
                $page.props.auth.user &&
                $page.props.auth.user.id === conversation.vendor_id
              "
            >
              <ConversationCardForVendor
                :conversation="conversation"
                @click="handleSelectedConversation(conversation.id)"
                :class="{
                  'bg-slate-200': selected === conversation.id,
                }"
              />
            </div>
            <div v-else>
              <p class="text-center font-bold text-sm text-slate-600">
                You don't have any conversations.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="border-l border-r w-full h-full">
        <div
          v-if="!selectedConversation && !conversation"
          class="border-b-2 border-b-slate-300 shadow-md py-5 flex items-center px-3"
        >
          <h1 class="text-left text-md font-semibold text-slate-700">
            Global E-commerce ( Chat Box )
          </h1>
        </div>
        <div v-if="selectedConversation || conversation" class="">
          <MessageBox
            :conversation="
              selectedConversation ? selectedConversation : conversation
            "
          />
        </div>
        <div
          v-else
          class="font-bold text-slate-500 text-center flex flex-col items-center justify-center h-[630px]"
        >
          <p>
            Once you start a new conversation or selected exisiting
            conversation,
          </p>
          <p>you'll see it messages here.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.chat-box {
  box-shadow: -5px 0px 8px 0px #3737377f;
}

.conversation-container {
  scrollbar-width: thin;
  scrollbar-color: #999 #f0f0f0;
}

.conversation-container::-webkit-scrollbar {
  width: 6px;
}

.conversation-container::-webkit-scrollbar-track {
  background-color: #f0f0f0;
}

.conversation-container::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}
</style>
