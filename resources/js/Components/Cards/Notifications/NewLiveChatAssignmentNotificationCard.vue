<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { router } from "@inertiajs/vue3";

dayjs.extend(relativeTime);

const props = defineProps({
  notification: Object,
});

const goToChatPage = () => {
  router.get(route("admin.chats.index"));
};

const handleNotificationReadAt = () => {
  router.patch(
    route("admin.notifications.read", props.notification.id),
    {
        notifiable_id: props.notification.notifiable_id,
    },
    {
      onSuccess: () => {
        goToChatPage();
      },
    }
  );
};
</script>

<template>
  <div
    @click="handleNotificationReadAt"
    v-if="
      notification.type ===
      'App\\Notifications\\Chats\\NewLiveChatAssignementFromUserNotification'
    "
    class="flex px-4 py-3 hover:bg-gray-100 cursor-pointer"
    :class="{ 'bg-gray-50': notification.read_at }"
  >
    <div
      class="flex-shrink-0 bg-lightBlue-300 text-lightBlue-700 ring-2 ring-lightBlue-500 w-10 h-10 rounded-md flex items-center justify-center p-3 font-bold"
    >
      <i
        class="fa-solid fa-message"
        :class="{
          'animate-pulse': !notification.read_at,
        }"
      ></i>
    </div>
    <div class="w-full pl-3">
      <div
        class="text-sm mb-1.5"
        :class="{
          'text-gray-700': !notification.read_at,
          'text-gray-500': notification.read_at,
        }"
      >
        {{ __(notification.data.message) }}

        <span
          class="font-bold text-sm block"
          :class="{
            'text-slate-600': !notification.read_at,
            'text-gray-500': notification.read_at,
          }"
        >
          {{ __("NAME") }} :
          {{ notification.data.name }}
        </span>
      </div>
      <div
        class="text-xs font-bold dark:text-blue-500"
        :class="{
          'text-lightBlue-500': !notification.read_at,
          'text-gray-500': notification.read_at,
        }"
      >
        <i
          v-if="!notification.read_at"
          class="fa-solid fa-circle animate-pulse text-[.6rem]"
        ></i>
        {{ dayjs(notification.created_at).fromNow() }}
      </div>
    </div>
  </div>
</template>
