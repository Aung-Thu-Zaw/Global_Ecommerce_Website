<script setup>
import ChatMessageForm from "@/Components/Forms/ChatMessageForm.vue";
import { computed, onMounted, onUpdated, ref } from "vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { usePage } from "@inertiajs/vue3";

dayjs.extend(relativeTime);

const props = defineProps({
  conversation: Object,
});

const msgScroll = ref(null);
const messages = ref(
  props.conversation.messages.length ? props.conversation.messages : []
);

onMounted(() => {
  Echo.private(`chat.message`)
    .listen("ChatMessage", (message) => {
      messages.value.push(message.message);
    })
    .listenForWhisper("typing", (e) => {
      console.log("Typing:", e);
    });

  scrollToBottom();
});

onUpdated(() => {
  scrollToBottom();
});

function scrollToBottom() {
  msgScroll.value.scrollTop = msgScroll.value.scrollHeight;
}

const formattedMessages = computed(() => {
  return messages.value.map((message) => {
    const date = dayjs(message.created_at);
    const relativeTimeString = date.fromNow();

    return {
      ...message,
      created_at:
        date.format("YYYY-MMMM-DD") + " " + "(" + relativeTimeString + ")",
    };
  });
});

const currentTime = new Date();
const threshold = 1000 * 60 * 3; // 3 minutes in milliseconds

const status = (last_activity) => {
  const lastActivity = new Date(last_activity);
  const timeDifference = currentTime.getTime() - lastActivity.getTime();

  return timeDifference < threshold ? "online" : "offline";
};
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
      class="w-10 h-10 object-cover rounded-full ring-2 ring-slate-400 mr-3"
    />
    <div class="text-left text-md font-semibold text-slate-700">
      <h1>
        {{ conversation.customer.name }}
      </h1>

      <span
        v-if="status(conversation.customer.last_activity) === 'online'"
        class="animate-pulse text-[.7rem] text-green-500"
      >
        <i class="fa-solid fa-circle text-[.6rem]"></i>
        Active
      </span>
      <span
        v-else-if="status(conversation.customer.last_activity) === 'offline'"
        class="text-[.7rem] text-gray-400"
      >
        {{ dayjs(conversation.customer.last_activity).fromNow() }}
      </span>
    </div>
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

      <span
        v-if="status(conversation.vendor.last_activity) === 'online'"
        class="animate-pulse text-[.7rem] text-green-500"
      >
        <i class="fa-solid fa-circle text-[.6rem]"></i>
        Active
      </span>
      <span
        v-else-if="status(conversation.vendor.last_activity) === 'offline'"
        class="text-[.7rem] text-gray-400"
      >
        {{ dayjs(conversation.vendor.last_activity).fromNow() }}
      </span>
    </div>
  </div>
  <div
    class="overflow-auto w-full h-[565px] py-5 chat-container"
    ref="msgScroll"
  >
    <div class="w-full h-auto px-3 mb-5">
      <!-- left text  -->

      <div
        v-for="message in formattedMessages"
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
                  class="p-3 border-2 border-slate-300 rounded-xl rounded-br-none shadow-md w-auto"
                >
                  {{ message.message }}
                </p>
                <div
                  v-if="message.type === 'image'"
                  class="h-[200px] border-2 border-slate-300 shadow-xl rounded-md overflow-hidden"
                >
                  <img
                    :src="message.image_path"
                    alt=""
                    class="h-full object-cover"
                  />
                </div>
                <div
                  v-if="message.type === 'video'"
                  class="w-full h-[300px] max-w-full border border-gray-200 rounded-lg shadow-lg overflow-hidden"
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
              class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-400 ml-3"
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
                class="w-8 h-8 object-cover rounded-full ring-2 ring-slate-400 mr-3"
              />

              <div class="flex items-end justify-start mb-3 w-full">
                <div class="pr-28">
                  <p
                    v-if="message.type === 'text'"
                    class="p-3 border-2 border-slate-300 rounded-xl rounded-bl-none shadow-md w-auto"
                  >
                    {{ message.message }}
                  </p>
                  <div
                    v-if="message.type === 'image'"
                    class="h-[200px] border-2 border-slate-300 shadow-xl rounded-md overflow-hidden"
                  >
                    <img
                      :src="message.image_path"
                      alt=""
                      class="h-full object-cover"
                    />
                  </div>
                  <div
                    v-if="message.type === 'video'"
                    class="w-full h-[300px] max-w-full border border-gray-200 rounded-lg shadow-lg overflow-hidden"
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
