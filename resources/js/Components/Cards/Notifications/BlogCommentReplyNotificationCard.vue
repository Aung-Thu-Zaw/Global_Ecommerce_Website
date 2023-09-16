<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { router } from "@inertiajs/vue3";

dayjs.extend(relativeTime);

const props = defineProps({
  notification: Object,
});

const goToBlog = () => {
  router.get(route("blogs.show", props.notification.data.blog));
};

const handleNotificationReadAt = () => {
  router.patch(
    route("notifications.read", props.notification.id),
    {
        notifiable_id: props.notification.notifiable_id,
    },
    {
      onSuccess: () => {
        goToBlog();
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
      'App\\Notifications\\Blogs\\BlogCommentReplyFromAuthorNotification'
    "
    class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer w-full"
    :class="{ 'bg-gray-50': notification.read_at }"
  >
    <div
      class="flex-shrink-0 bg-orange-300 text-orange-700 ring-2 ring-orange-500 w-10 h-10 rounded-md flex items-center justify-center p-3 font-bold"
    >
      <i class="fa-solid fa-flag"></i>
    </div>
    <div class="w-full pl-3">
      <div
        class="text-sm mb-1.5"
        :class="{
          'text-gray-600': !notification.read_at,
          'text-gray-500': notification.read_at,
        }"
      >
        {{ __(notification.data.message) }}

        <span
          class="font-bold text-sm block line-clamp-1"
          :class="{
            'text-slate-600': !notification.read_at,
            'text-gray-500': notification.read_at,
          }"
        >
          {{ notification.data.reply }}
        </span>
      </div>
      <div
        class="text-xs font-bold"
        :class="{
          'text-orange-500': !notification.read_at,
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
