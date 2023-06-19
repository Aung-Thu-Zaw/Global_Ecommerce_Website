<script setup>
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

const props = defineProps({
  conversation: Object,
});

const lastMessage = computed(
  () => props.conversation.messages[props.conversation.messages.length - 1]
);

const totalunseenMessages = computed(() =>
  props.conversation.messages.filter(
    (message) =>
      !message.is_seen && message.user_id !== usePage().props.auth.user.id
  )
);

const formattedTime = computed(() => {
  const currentDate = new Date().getDate();
  const createdDate = new Date(lastMessage.value.created_at).getDate();

  return currentDate > createdDate
    ? dayjs(lastMessage.value.created_at).format("DD-MMMM-YYYY")
    : dayjs(lastMessage.value.created_at).fromNow();
});
</script>

<template>
  <div class="border-2 rounded-md shadow-md cursor-pointer">
    <div class="py-3 flex items-start px-3">
      <img
        :src="conversation.customer.avatar"
        alt=""
        class="w-10 h-10 object-cover rounded-full ring-2 ring-slate-400"
      />
      <div class="ml-3 w-full">
        <div class="flex items-start justify-between">
          <h1
            class="flex items-center text-left text-sm font-semibold text-slate-700 w-[100px]"
          >
            <span class="line-clamp-1">
              {{ conversation.customer.name }}
            </span>
          </h1>
          <span class="text-[.7rem] text-slate-500 ml-auto">
            {{ formattedTime }}
          </span>
        </div>
        <div class="flex items-center justify-between">
          <p
            v-if="lastMessage.type === 'text'"
            class="text-[.7rem] line-clamp-1 w-[90%]"
            :class="{
              'text-slate-400': lastMessage.is_seen,
              'text-slate-600':
                !lastMessage.is_seen ||
                lastMessage.user_id === $page.props.auth.user.id,
            }"
          >
            {{
              lastMessage.user_id === $page.props.auth.user.id
                ? "You : " + lastMessage.message
                : lastMessage.message
            }}
          </p>
          <p
            v-if="lastMessage.type === 'image'"
            class="text-[.7rem] line-clamp-1 w-[90%]"
            :class="{
              'text-slate-400': lastMessage.is_seen,
              'text-slate-600':
                !lastMessage.is_seen ||
                lastMessage.user_id === $page.props.auth.user.id,
            }"
          >
            {{
              lastMessage.user_id === $page.props.auth.user.id
                ? "You : Send a photo"
                : "Send a photo"
            }}
          </p>
          <p
            v-if="lastMessage.type === 'video'"
            class="text-[.7rem] line-clamp-1 w-[90%]"
            :class="{
              'text-slate-400': lastMessage.is_seen,
              'text-slate-600':
                !lastMessage.is_seen ||
                lastMessage.user_id === $page.props.auth.user.id,
            }"
          >
            {{
              lastMessage.user_id === $page.props.auth.user.id
                ? "You : Send a video"
                : "Send a video"
            }}
          </p>
          <p
            v-if="totalunseenMessages.length"
            class="w-[10%] flex items-center justify-center"
          >
            <span
              class="text-[.6rem] rounded-full px-1.5 py-0.5 bg-blue-600 text-white flex items-center justify-center"
            >
              {{ totalunseenMessages.length }}
            </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>


