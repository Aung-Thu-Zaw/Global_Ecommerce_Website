
<script setup>
import ChatMessageForm from "@/Components/Forms/ChatMessageForm.vue";
import { onMounted, onUpdated, ref } from "vue";

defineProps({
  conversation: Object,
});

const msgScroll = ref(null);

onMounted(() => {
  scrollToBottom();
});

onUpdated(() => {
  scrollToBottom();
});

function scrollToBottom() {
  msgScroll.value.scrollTop = msgScroll.value.scrollHeight;
}
</script>
<template>
  <div
    v-if="
      $page.props.auth.user &&
      $page.props.auth.user.id !== conversation.customer_id
    "
    class="border-b-2 border-b-slate-300 shadow-md py-3 flex items-center px-3"
  >
    <img
      :src="conversation.customer.avatar"
      alt=""
      class="w-10 h-10 object-cover rounded-full ring-2 ring-blue-400 mr-3"
    />
    <h1 class="text-left text-lg font-semibold text-slate-700">
      {{ conversation.customer.name }}
    </h1>
  </div>

  <div
    v-else-if="
      $page.props.auth.user &&
      $page.props.auth.user.id !== conversation.vendor_id
    "
    class="border-b-2 border-b-slate-300 shadow-md py-3 flex items-center px-3"
  >
    <img
      :src="conversation.vendor.avatar"
      alt=""
      class="w-10 h-10 object-cover rounded-full ring-2 ring-slate-400 mr-3"
    />
    <div class="text-left text-md font-semibold text-slate-700">
      <h1>
        {{ conversation.vendor.shop_name }}
        <span
          v-if="conversation.vendor.offical"
          class="text-green-500 text-sm font-bold"
        >
          <i class="fa-solid fa-circle-check"></i>
        </span>
      </h1>

      <!-- <span class="animate-pulse text-[.7rem] text-green-500">
        <i class="fa-solid fa-circle text-[.6rem]"></i>
        Active
      </span> -->
      <span class="text-[.7rem] text-gray-400"> 5 minutes ago </span>
    </div>
  </div>
  <div
    class="overflow-auto w-full h-[565px] py-5 chat-container"
    ref="msgScroll"
  >
    <div class="w-full h-auto px-3 mb-5">
      <!-- left text  -->

      <div
        v-for="message in conversation.messages"
        :key="message.id"
        class="w-full"
      >
        <!-- Right Side  -->
        <div v-if="message.user_id === $page.props.auth.user.id" class="mb-2">
          <p class="text-center text-sm text-slate-500 font-bold mb-5">
            {{ message.created_at }}
          </p>
          <div class="flex items-end justify-end">
            <div class="flex items-center justify-end mb-3">
              <div class="pl-28">
                <p
                  v-if="message.type === 'text'"
                  class="p-3 border-2 border-slate-300 rounded-lg rounded-br-none shadow-md w-auto"
                >
                  {{ message.message }}
                </p>
                <div
                  v-if="message.type === 'image'"
                  class="h-[250px] border-2 border-slate-300 shadow-xl rounded-md overflow-hidden"
                >
                  <img
                    :src="message.image_path"
                    alt=""
                    class="h-full object-cover"
                  />
                </div>
                <div
                  v-if="message.type === 'video'"
                  class="w-full h-[400px] max-w-full border border-gray-200 rounded-lg shadow-lg overflow-hidden"
                >
                  <video
                    :src="message.video_path"
                    autoplay
                    muted
                    controls
                    class="w-full h-full"
                  ></video>
                </div>
              </div>
            </div>
            <img
              :src="message.user.avatar"
              alt=""
              class="w-8 h-8 object-cover rounded-full ring-2 ring-blue-400 ml-3"
            />
          </div>
        </div>

        <!-- left Side -->
        <div v-else class="mb-2">
          <div>
            <p class="text-center text-sm text-slate-500 font-bold mb-5">
              {{ message.created_at }}
            </p>
            <div class="flex items-end">
              <img
                :src="message.user.avatar"
                alt=""
                class="w-8 h-8 object-cover rounded-full ring-2 ring-blue-400 mr-3"
              />

              <div class="flex items-end justify-start mb-3 w-full">
                <div class="pr-28">
                  <p
                    class="p-3 border-2 border-slate-300 rounded-lg rounded-bl-none shadow-md w-auto"
                  >
                    {{ message.message }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <ChatMessageForm :conversation="conversation" />
</template>


<style>
.chat-container {
  scrollbar-width: thin;
  scrollbar-color: #999 #f0f0f0;
}

.chat-container::-webkit-scrollbar {
  width: 6px;
}

.chat-container::-webkit-scrollbar-track {
  background-color: #f0f0f0;
}

.chat-container::-webkit-scrollbar-thumb {
  background-color: #999;
  border-radius: 3px;
}
</style>
