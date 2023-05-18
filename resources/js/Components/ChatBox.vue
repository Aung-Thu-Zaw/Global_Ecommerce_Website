<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import MessageBox from "@/Components/MessageBox.vue";
import ConversationCardForCustomer from "@/Components/Cards/ConversationCardForCustomer.vue";
import ConversationCardForVendor from "@/Components/Cards/ConversationCardForVendor.vue";
import { computed, ref, watch } from "vue";
import { useReCaptcha } from "vue-recaptcha-v3";

const props = defineProps({
  conversation: Object,
});

const emit = defineEmits(["isVisible"]);

const handleClose = () => {
  emit("isVisible");
};

const selectedConversation = ref(null);
const conversations = computed(() => usePage().props.conversations);

const handleSelectedConversation = (conversationId) => {
  selectedConversation.value = conversations.value.find(
    (conversation) => conversation.id === conversationId
  );
};

</script>


<template>
  <div
    class="fixed z-40 bottom-0 right-14 w-[900px] h-[700px] rounded-tl-md border-2 border-r-0 shadow-sm bg-gray-50 chat-box"
  >
    <div class="flex items-center h-full">
      <div class="w-1/2 h-full">
        <div
          class="relative text-center flex items-center justify-center text-lg font-semibold text-slate-700 border-b py-[18px]"
        >
          <span
            @click="handleClose"
            class="absolute top-3 cursor-pointer left-3 border w-6 h-6 rounded-full flex items-center justify-center text-sm bg-slate-200 hover:bg-slate-400 hover:text-white transition-all"
          >
            <i class="fa-solid fa-xmark"></i>
          </span>
          <h1><i class="fa-solid fa-message"></i> Messages</h1>
        </div>

        <div class="p-2 space-y-1 h-[630px] overflow-auto">
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
              />
            </div>
            <div
              v-else-if="
                $page.props.auth.user &&
                $page.props.auth.user.id === conversation.vendor_id
              "
            >
              <ConversationCardForVendor :conversation="conversation" />
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
          class="border-b-2 border-b-slate-300 shadow-md py-3 flex items-center px-3"
        >
          <img
            src="https://images.samsung.com/is/image/samsung/assets/samsung-and-you/SamsungAndYouBlackBanner.png?$FB_TYPE_B_PNG$"
            alt=""
            class="w-10 h-10 object-cover rounded-full ring-2 ring-blue-400 mr-3"
          />
          <h1 class="text-left text-lg font-semibold text-slate-700">
            Samsung
          </h1>
        </div>

        <div class="overflow-auto w-full h-[565px] py-5">
          <MessageBox
            :conversation="
              selectedConversation ? selectedConversation : conversation
            "
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.chat-box {
  box-shadow: -5px 0px 8px 0px #3737377f;
}
</style>
